<?php

namespace App\Livewire\Product;

use App\Livewire\Traits\Alert;
use App\Models\Product;
use App\Models\ProductImages;
use Illuminate\Validation\Rules;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Illuminate\Database\Eloquent\Builder;

class ManageImages extends Component
{
    use Alert, WithPagination;

    public Product $product;

    public $options, $id;

    public ?int $quantity = 25;

    public ?string $search = null;

    public array $sort = [
        'column' => 'id',
        'direction' => 'asc',
    ];

    public array $headers = [
        ['index' => 'id', 'label' => '#'],
        ['index' => 'image_url', 'label' => 'Image'],
        ['index' => 'alt_text', 'label' => 'Alt Text'],
        ['index' => 'is_primary', 'label' => 'Primary'],
        ['index' => 'action'],
    ];

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function render()
    {
        return view('livewire.product.manage-images');
    }

    #[Computed]
    public function rows(): LengthAwarePaginator
    {
        return ProductImages::where('product_id', $this->product->id)
            ->when($this->search !== null, fn (Builder $query) => $query->whereAny(['image_url','alt_text'], 'like', '%'.trim($this->search).'%'))
            ->orderBy('sort_order','asc')
            ->paginate($this->quantity)
            ->withQueryString();
    }
}
