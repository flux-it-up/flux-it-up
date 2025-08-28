<?php

namespace App\Livewire\Product;

use Livewire\Component;
use App\Models\ProductImages;
use Livewire\Attributes\Renderless;
use App\Livewire\Traits\Alert;
use Illuminate\Support\Facades\Storage;

class DeleteImage extends Component
{
    use Alert;

    public ProductImages $image;
    public $path;

    public function render()
    {
        return <<<'HTML'
        <div>
            <x-button.circle icon="trash" color="red" wire:click="confirm" />
        </div>
        HTML;
    }

    #[Renderless]
    public function confirm(): void
    {
        $this->question()
            ->confirm(method: 'delete')
            ->cancel()
            ->send();
    }

    public function delete(): void
    {
        $path = $this->image->image_url;

        Storage::disk('public')->delete($path);

        $this->image->delete();

        $this->dispatch('deleted');

        $this->resetExcept('ProductImage');

        $this->toast()->success('Service removed successfully!')->send();
    }
}
