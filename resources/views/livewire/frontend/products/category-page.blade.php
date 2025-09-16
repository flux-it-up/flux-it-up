<div>
    <div class="mt-24 flex">
        {{-- Sidebar --}}
        <aside class="min-h-screen w-sm bg-dark-900 text-white px-4 py-10">
            <h2 class="font-bold text-lg mb-4">Search/Filters</h2>
            <div class="py-2">
                <x-input label="Search" placeholder="Search products..." wire:model.live.debounce.300ms="search" />
            </div>
            <div class="py-2">
                <x-select.styled
                    label="Brand"
                    placeholder="All Brands"
                    wire:model.live="brand"
                    :options="$brands"
                    select="label:name|value:id"
                />
            </div>
            <div class="py-2">
                <div class="flex gap-2">
                    <x-input label="Min Price" wire:model.live.debounce.300ms="min_price" />
                    <x-input label="Max Price" wire:model.live.debounce.300ms="max_price" />
                </div>
            </div>
            <div class="py-2">
                <x-select.styled
                    label="Sort By"
                    placeholder="Default"
                    wire:model.live.debounce.400ms="sort"
                    :options="[
                        ['label' => 'Latest', 'value' => 'latest'],
                        ['label' => 'Price: Low to High', 'value' => 'price_asc'],
                        ['label' => 'Price: High to Low', 'value' => 'price_desc'],
                    ]"
                />
            </div>
        </aside>

        {{-- Product grid --}}
        <div class="flex p-4 bg-dark-800">
            <div class="max-w-full py-8 sm:px-6 lg:px-8">
                <x-breadcrumb />
                <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                    @forelse($products as $product)
                    <div class="group relative shadow-none">
                        <img src="{{ Storage::url($product->primary_image) }}" alt={{ $product->name }}." image" class="aspect-square w-full rounded-md shadow-none bg-transparent object-cover group-hover:opacity-75 lg:aspect-auto lg:h-80" />
                        <div class="flex justify-between p-2">
                            <div>
                                <h3 class="text-md font-semibold text-primary-600">
                                    <a href="{{ route('products.show', ['category' => $product->category->slug, 'product' => $product->slug]) }}">
                                        <span aria-hidden="true" class="absolute inset-0"></span>
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <p class="mt-1 text-sm text-dark-500">{{ $product->description }}</p>
                            </div>
                            @if($product->sale_price)
                            <div class="pl-4">
                                <span class="text-dark-700 line-through">${{ number_format($product->price, 2) }}</span><br />
                                <span class="text-[#228B22]">${{ number_format($product->sale_price, 2) }}</span>
                            </div>
                            @else
                                <p class="text-primary-600">${{ number_format($product->price, 2) }}</p>
                            @endif
                        </div>
                    </div>
                    @empty
                        <div class="text-md text-dark-600">No products available.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

