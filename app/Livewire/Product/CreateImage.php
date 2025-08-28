<?php

namespace App\Livewire\Product;

use App\Livewire\Traits\Alert;
use App\Models\ProductImages;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use TallStackUi\Traits\Interactions;
use Livewire\Attributes\On;

class CreateImage extends Component
{
    use Alert, WithFileUploads;

    public ?Product $product;

    public $image, $product_id;

    public bool $modal = false;

    #[On('modal')]
    public function modal($id): void
    {
        $this->product_id = $id;
        $this->image = new ProductImages();

        $this->modal = true;
    }

    public function rules(): array
    {
        return [
            'image.image_url' => [
                'required',
                'image',
                'max:2048'
            ],
            'image.alt_text' => [
                'nullable',
                'string'
            ],
            'image.sort_order' => [
                'nullable',
                'integer'
            ],
            'image.is_primary' => [
                'boolean'
            ]
        ];
    }

    public function render()
    {
        return view('livewire.product.create-image');
    }

    public function save()
    {
        if(!$this->image->is_primary) {
            $this->image->is_primary = false;
        }

        $this->validate();

        if($this->image->image_url) {
            $path = $this->image->image_url->store('products/'.$this->product_id,'public');
            $this->image->image_url = $path;
        }

        $this->image->product_id = $this->product_id;

        $this->image->save();

        $this->dispatch('created');

        $this->resetExcept('image','product_id', 'product', 'ProductImages');
        $this->image = new ProductImages();

        $this->toast()->success('Product image uploaded successfully!')->send();
    }
}
