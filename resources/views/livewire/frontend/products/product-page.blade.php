<div>
    <div class="bg-transparent mt-24">
  <div class="pt-6 m-10">
    <x-breadcrumb />

    <!-- Image gallery -->
    <div class="mx-auto mt-6 max-w-2xl sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:gap-8 lg:px-8">
      @forelse($product->orderedImages as $index => $image)
          @if($index === 0)
              {{-- First image - large left column --}}
              <img src="{{ Storage::url($image->image_url) }}" 
                  alt="{{ $product->name }}" 
                  class="row-span-2 size-full rounded-lg object-cover" />
          @elseif($index === 1)
              {{-- Second image - top right --}}
              <img src="{{ Storage::url($image->image_url) }}" 
                  alt="{{ $product->name }}" 
                  class="col-start-2 aspect-3/2 size-full rounded-lg object-cover max-lg:hidden" />
          @elseif($index === 2)
              {{-- Third image - bottom right --}}
              <img src="{{ Storage::url($image->image_url) }}" 
                  alt="{{ $product->name }}" 
                  class="col-start-2 row-start-2 aspect-3/2 size-full rounded-lg object-cover max-lg:hidden" />
          @elseif($index === 3)
              {{-- Fourth image - right column --}}
              <img src="{{ Storage::url($image->image_url) }}" 
                  alt="{{ $product->name }}" 
                  class="row-span-2 aspect-4/5 size-full object-cover sm:rounded-lg lg:aspect-3/4" />
          @endif
        @empty
          <img src="{{ Storage::url('products/placeholder.png') }}" 
             alt="Placeholder image" 
             class="row-span-2 size-full rounded-lg object-cover" />
        @endforelse
    </div>

    <!-- Product info -->
    <div class="mx-auto max-w-2xl px-4 pt-10 pb-16 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:grid-rows-[auto_auto_1fr] lg:gap-x-8 lg:px-8 lg:pt-16 lg:pb-24">
      <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
        <h1 class="text-2xl font-bold tracking-tight text-primary-600 sm:text-3xl">{{ $product->name }}</h1>
      </div>

      <!-- Options -->
      <div class="mt-4 lg:row-span-3 lg:mt-0">
        <h2 class="sr-only">Product information</h2>
        @if($product->sale_price && $product->sale_price > 0.00)
            <p class="text-3xl font-bold tracking-tight text-[#228B22]">${{ $product->sale_price }}</p>
            <p class="text-sm tracking-tight text-dark-600">was ${{ $product->price }}</p>
        @elseif($product->sale_price && $product->sale_price == 0.00)
            <p class="text-3xl font-bold tracking-tight text-[#228B22]">FREE</p>
            <p class="text-sm tracking-tight text-dark-600">was ${{ $product->price }}</p>
        @else
            <p class="text-3xl tracking-tight text-primary-600">${{ $product->price }}</p>
        @endif

        <!-- Reviews -->
        <div class="mt-6">
          <h3 class="sr-only">Reviews</h3>
          <div class="flex items-center">
            <div class="flex items-center">
              <!-- Active: "text-gray-900", Default: "text-gray-200" -->
              <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5 shrink-0 text-primary-600">
                <path d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" fill-rule="evenodd" />
              </svg>
              <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5 shrink-0 text-primary-600">
                <path d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" fill-rule="evenodd" />
              </svg>
              <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5 shrink-0 text-primary-600">
                <path d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" fill-rule="evenodd" />
              </svg>
              <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5 shrink-0 text-primary-600">
                <path d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" fill-rule="evenodd" />
              </svg>
              <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5 shrink-0 text-dark-900">
                <path d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" fill-rule="evenodd" />
              </svg>
            </div>
            <p class="sr-only">4 out of 5 stars</p>
            <a href="#" class="ml-3 text-sm font-medium text-primary-600 hover:text-primary-500">117 reviews</a>
          </div>
        </div>

        <form class="mt-10">

          <!-- Quantity -->


          <button type="submit" class="mt-10 flex w-full items-center justify-center rounded-md border border-transparent bg-primary-600 px-8 py-3 text-base font-semibold text-white hover:bg-primary-700 focus:ring-3 focus:ring-primary-400 focus:ring-offset-2 focus:outline-hidden">Add to cart</button>
        </form>
      </div>

      <div class="py-10 lg:col-span-2 lg:col-start-1 lg:border-r lg:border-gray-200 lg:pt-6 lg:pr-8 lg:pb-16">
        <!-- Description and details -->
        <div>
          <h3 class="sr-only">Description</h3>

          <div class="space-y-6">
            <p class="text-base text-gray-900">{{ $product->description }}</p>
          </div>
        </div>

        @if(!empty($product->specifications))
        
        <div class="mt-10">
          <h3 class="text-sm font-medium text-gray-900">Specifications</h3>

          <div class="mt-4">
            <ul role="list" class="list-disc space-y-2 pl-4 text-sm">
              @foreach($product->specifications as $sk=>$sv)
              <li class="text-gray-400"><span class="text-gray-600">{{ $sk }} - {{$sv}}</span></li>
              @endforeach
            </ul>
          </div>
        </div>
        @endif

        <!--
        <div class="mt-10">
          <h2 class="text-sm font-medium text-gray-900">Details</h2>

          <div class="mt-4 space-y-6">
            <p class="text-sm text-gray-600">The 6-Pack includes two black, two white, and two heather gray Basic Tees. Sign up for our subscription service and be the first to get new, exciting colors, like our upcoming &quot;Charcoal Gray&quot; limited release.</p>
          </div>
        </div>-->
      </div>
    </div>
  </div>
</div>

</div>
