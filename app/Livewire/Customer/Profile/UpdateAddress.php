<?php

namespace App\Livewire\Customer\Profile;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Traits\Alert;
use Illuminate\Contracts\View\View;
use App\Models\{Address, State, County, City, PostalCode, User};
use App\Services\AddressService;
use Illuminate\Validation\ValidationException;

class UpdateAddress extends Component
{
    use Alert;

    // ==================== Properties ====================
    
    public User $user;
    public bool $modal = false;
    public ?Address $address = null; // Add this property to store the current address

    // Form fields - these match your blade template
    #[Validate('required|string|in:shipping,billing,both')]
    public string $type = 'shipping';

    #[Validate('nullable|string|max:255')]
    public ?string $label = null;

    #[Validate('required|string|max:255')]
    public string $line1 = '';

    #[Validate('nullable|string|max:255')]
    public ?string $line2 = null;

    #[Validate('required|exists:cities,id')]
    public ?int $city_id = null;

    #[Validate('required|exists:counties,id')]
    public ?int $county_id = null;

    #[Validate('required|exists:states,id')]
    public ?int $state_id = null;

    #[Validate('required|string|max:10')]
    public string $postal_code = '';

    #[Validate('required|string|max:255')]
    public string $country = 'United States of America';

    #[Validate('boolean')]
    public bool $is_default = false;

    #[Validate('boolean')]
    public bool $billing_same_as_shipping = false;

    // Collections for dropdowns
    public $states;
    public $counties;
    public $cities;

    // ==================== Lifecycle Methods ====================

    public function mount(): void
    {
        $this->user = Auth::user();
        $this->modal = false;
        $this->initializeCollections();
    }

    #[On('load::address')]
    public function load(int $addressId): void
    {
        // Find the address by ID
        $address = Address::findOrFail($addressId);
        $this->address = $address;
        
        // Load address data into form fields
        $this->type = $address->type;
        $this->label = $address->label;
        $this->line1 = $address->line1;
        $this->line2 = $address->line2;
        $this->city_id = $address->city_id;
        $this->county_id = $address->county_id;
        $this->state_id = $address->state_id;
        $this->postal_code = $address->postal_code;
        $this->country = $address->country;
        $this->is_default = $address->is_default;
        
        // Load related collections
        $this->updateCollectionsFromAddress($address);
        
        // Open the modal
        $this->modal = true;
    }

    // ==================== Event Listeners ====================

    public function updatedPostalCode(): void
    {
        if (empty($this->postal_code)) {
            return;
        }

        $postalCode = PostalCode::where('postal_code', $this->postal_code)->first();
        
        if ($postalCode) {
            $this->state_id = $postalCode->state_id;
            $this->county_id = $postalCode->county_id;
            $this->city_id = $postalCode->city_id;
            
            // Update the collections based on postal code
            $this->updateCollectionsFromPostalCode($postalCode);
            
            // Dispatch event for JavaScript
            $this->dispatch('postal-code-updated');
        }
    }

    public function updatedStateId(): void
    {
        if ($this->state_id) {
            $this->counties = County::where('state_id', $this->state_id)
                ->select('name', 'id')
                ->orderBy('name')
                ->get();
            
            // Reset dependent fields
            $this->county_id = null;
            $this->city_id = null;
            $this->cities = collect();
        }
    }

    public function updatedCountyId(): void
    {
        if ($this->county_id) {
            $this->cities = City::where('county_id', $this->county_id)
                ->select('name', 'id')
                ->orderBy('name')
                ->get();
            
            // Reset dependent field
            $this->city_id = null;
        }
    }

    // ==================== Actions ====================

    public function closeModal(): void
    {
        $this->modal = false;
        $this->resetValidation();
    }

    public function save(): void
    {
        try {
            $this->validate();

            if (!$this->address) {
                throw new \Exception('No address selected for update');
            }

            $addressData = $this->getAddressData();
            
            // Update the address
            app(AddressService::class)->updateAddress(
                $this->user,
                $this->address,
                $addressData,
                $this->is_default
            );

            $this->dispatch('address-updated');
            $this->closeModal();
            
            $this->toast()
                ->success('Address updated successfully!')
                ->send();

        } catch (ValidationException $e) {
            $this->toast()
                ->error('Please check the form for errors.')
                ->send();
            throw $e;
        } catch (\Exception $e) {
            $this->toast()
                ->error('An error occurred while updating the address: ' . $e->getMessage())
                ->send();
        }
    }

    // ==================== Helper Methods ====================

    private function initializeCollections(): void
    {
        $this->states = State::select('name', 'id')
            ->orderBy('name')
            ->get();
        
        $this->counties = collect();
        $this->cities = collect();
    }

    private function updateCollectionsFromPostalCode(PostalCode $postalCode): void
    {
        // Update counties for the selected state
        $this->counties = County::where('state_id', $postalCode->state_id)
            ->select('name', 'id')
            ->orderBy('name')
            ->get();

        // Update cities for the selected county
        $this->cities = City::where('county_id', $postalCode->county_id)
            ->select('name', 'id')
            ->orderBy('name')
            ->get();
    }

    private function updateCollectionsFromAddress(Address $address): void
    {
        // Load counties for the selected state
        $this->counties = County::where('state_id', $address->state_id)
            ->select('name', 'id')
            ->orderBy('name')
            ->get();

        // Load cities for the selected county
        $this->cities = City::where('county_id', $address->county_id)
            ->select('name', 'id')
            ->orderBy('name')
            ->get();
    }

    private function getAddressData(): array
    {
        return [
            'type' => $this->type,
            'label' => $this->label,
            'line1' => $this->line1,
            'line2' => $this->line2,
            'city_id' => $this->city_id,
            'county_id' => $this->county_id,
            'state_id' => $this->state_id,
            'postal_code' => $this->postal_code,
            'country' => $this->country,
            'is_default' => $this->is_default,
        ];
    }

    // ==================== Computed Properties ====================

    public function getCanSetDefaultProperty(): bool
    {
        return $this->type !== 'both';
    }

    // ==================== Render ====================

    public function render(): View
    {
        return view('livewire.customer.profile.update-address');
    }
}
