<?php

namespace App\Livewire\Customer\Profile;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Traits\Alert;
use Illuminate\Contracts\View\View;
use App\Models\{Address, State, County, City, PostalCode, User};
use App\Services\AddressService;
use Illuminate\Validation\ValidationException;

class CreateAddress extends Component
{
    use Alert;

    // ==================== Properties ====================
    
    public User $user;
    public bool $modal = false;

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

    public function openModal(): void
    {
        $this->modal = true;
        $this->resetForm();
    }

    public function closeModal(): void
    {
        $this->modal = false;
        $this->resetValidation();
    }

    public function save(): void
    {
        try {
            $this->validate();

            $addressData = $this->getAddressData();
            
            // Handle billing_same_as_shipping logic
            $type = $this->billing_same_as_shipping && $this->type === 'shipping' ? 'both' : $this->type;
            
            app(AddressService::class)->createAddress(
                $this->user,
                $addressData,
                $type,
                $this->is_default
            );

            $this->dispatch('address-created');
            $this->resetForm();
            $this->closeModal();
            
            $this->toast()
                ->success('Address created successfully!')
                ->send();

        } catch (ValidationException $e) {
            $this->toast()
                ->error('Please check the form for errors.')
                ->send();
            throw $e;
        } catch (\Exception $e) {
            $this->toast()
                ->error('An error occurred while creating the address.')
                ->send();
            
            // Log the error for debugging
            logger()->error('Address creation failed', [
                'user_id' => $this->user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
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

    private function getAddressData(): array
    {
        return [
            'label' => $this->label,
            'line1' => $this->line1,
            'line2' => $this->line2,
            'city_id' => $this->city_id,
            'county_id' => $this->county_id,
            'state_id' => $this->state_id,
            'postal_code' => $this->postal_code,
            'country' => $this->country,
        ];
    }

    private function resetForm(): void
    {
        $this->reset([
            'type',
            'label',
            'line1',
            'line2',
            'city_id',
            'county_id',
            'state_id',
            'postal_code',
            'is_default',
            'billing_same_as_shipping'
        ]);

        $this->type = 'shipping';
        $this->country = 'United States of America';
        $this->counties = collect();
        $this->cities = collect();
    }

    // ==================== Computed Properties ====================

    public function getCanSetDefaultProperty(): bool
    {
        return $this->type !== 'both';
    }

    public function getHasAddressesProperty(): bool
    {
        return $this->user->addresses()->exists();
    }

    // ==================== Render ====================

    public function render(): View
    {
        return view('livewire.customer.profile.create-address');
    }
}
