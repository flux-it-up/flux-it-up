<?php

namespace App\Livewire\User;

use App\Livewire\Traits\Alert;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class UpdateProfile extends Component
{
    use Alert, WithFileUploads;

    public User $user;

    public ?string $password = null;

    public ?string $password_confirmation = null;

    public $avatar, $newAvatar;
    public $current_password;

    public bool $modal = false;

    public function mount(): void
    {
        $this->user = Auth::user();
        $this->avatar = $this->user->avatar;
    }

    public function rules(): array
    {
        return [
            'user.first_name' => [
                'required',
                'string',
                'max:255'
            ],
            'user.middle_name' => [
                'nullable',
                'string',
                'max:255'
            ],
            'user.last_name' => [
                'required',
                'string',
                'max:255'
            ],
            'password' => [
                'nullable',
                'string',
                'confirmed',
                Rules\Password::defaults()
            ],
            'user.phone' => [
                'nullable',
                'numeric',
                'digits:10'
            ],
            'user.dob' => [
                'nullable',
                'date'
            ],
            'newAvatar' => [
                'nullable',
                'image',
                'max:2048' // 2MB
            ]
        ];
    }

    public function render(): View
    {
        return view('livewire.user.update-profile');
    }

    public function save(): void
    {
        $user = Auth::user();

        $this->validate();

        if($this->newAvatar) {
            if($this->avatar)
            {
                Storage::disk('public')->delete($this->avatar);
            }
            
            $path = $this->newAvatar->store('avatars','public');
            $this->user->avatar = $path;
        }

        $this->user->password = when($this->password !== null, Hash::make($this->password), $this->user->password);

        if ($this->current_password && $this->password) {
            if (!Hash::check($this->current_password, $user->password)) {
                $this->addError('current_password', 'Your current password is incorrect.');
                return;
            }

            $this->validate([
                'new_password' => 'required|string|min:8|confirmed',
            ]);

            $user->password = Hash::make($this->password);
        }

        $this->user->save();

        $this->dispatch('updated');

        $this->resetExcept('user');

        $this->toast()->success('Profile updated successfully!')->send();
    }
}
