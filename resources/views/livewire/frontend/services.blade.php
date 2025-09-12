<div class="space-y-24"> {{-- Single root element for Livewire --}}

    <div class="game-console-repair bg-dark-400 mt-24">
        <div class="game-console-repair-blur relative isolate py-24 sm:py-32 lg:px-8">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <h2 class="text-center text-3xl font-semibold text-primary-500">Brands We Work With</h2>
                <div class="mx-auto mt-10 grid max-w-lg grid-cols-3 items-center gap-x-8 gap-y-10 sm:max-w-xl sm:grid-cols-6 sm:gap-x-10 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                    @foreach($brands as $brand)
                    <img height="80" src="{{ Storage::url($brand->logo) }}" alt="Transistor" class="col-span-2 max-h-26 w-full object-contain lg:col-span-1" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @foreach($brands as $brand)
        @if($loop->odd)
            <div class="relative isolate overflow-hidden bg-gray-900 -mt-24 px-6 py-24 sm:py-32 lg:overflow-visible lg:px-0">
                <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 lg:mx-0 lg:max-w-none lg:grid-cols-2 lg:items-start lg:gap-y-10">
                    <div class="lg:col-span-2 lg:col-start-1 lg:row-start-1 lg:mx-auto lg:grid lg:w-full lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8">
                        <div class="lg:pr-4">
                            <div class="lg:max-w-lg">
                            <p class="text-base/7 font-semibold text-indigo-400"></p>
                            <h1 class="mt-2 text-4xl font-semibold tracking-tight text-pretty text-primary-500 sm:text-5xl">{{ $brand->name }}</h1>
                            <p class="mt-6 text-md/8 text-dark-300">We fix all of your favorite consoles and get you back in the game in no time! We’ve got your back with our limited warranty on all game console repairs, no matter what your favorite game is.</p>
                            </div>
                        </div>
                    </div>
                    <div class="-mt-12 -ml-12 p-12 lg:sticky lg:top-4 lg:col-start-2 lg:row-span-2 lg:row-start-1 lg:overflow-hidden">
                        <img src="{{ asset('assets/images/'.$brand->name.'.png') }}" alt="" class="w-3xl max-w-none rounded-xl bg-transparent sm:w-228" />
                    </div>
                    <div class="lg:col-span-2 lg:col-start-1 lg:row-start-2 lg:mx-auto lg:grid lg:w-full lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8">
                        <div class="lg:pr-4">
                            <div class="max-w-xl text-base/7 text-gray-400 lg:max-w-lg">
                                <p>We offer the following services for {{ $brand->name }} consoles.</p>
                                <ul role="list" class="mt-8 text-gray-400">
                                    @forelse($brand->services as $service)
                                        <li class="flex gap-x-3">
                                            <x-icon name="check-badge" outline class="mt-1 size-5 flex-none text-primary-500" />
                                            <span>{{ $service->name }}</span>
                                        </li>
                                    @empty
                                        <span>No services available.</span>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="relative isolate overflow-hidden bg-dark-700 px-6 py-24 -mt-24 sm:py-32 lg:overflow-visible lg:px-0">
                <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 lg:mx-0 lg:max-w-none lg:grid-cols-2 lg:items-start lg:gap-y-10">
                    <div class="lg:col-span-2 lg:col-start-2 lg:row-start-1 lg:mx-auto lg:grid lg:w-full lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8">
                        <div class="lg:pr-4">
                            <div class="lg:max-w-lg">
                            <p class="text-base/7 font-semibold text-indigo-400"></p>
                            <h1 class="mt-2 text-4xl font-semibold tracking-tight text-pretty text-primary-500 sm:text-5xl">{{ $brand->name }}</h1>
                            <p class="mt-6 text-md/8 text-dark-300">We fix all of your favorite consoles and get you back in the game in no time! We’ve got your back with our limited warranty on all game console repairs, no matter what your favorite game is.</p>
                            </div>
                        </div>
                    </div>
                    <div class="-mt-12 -ml-12 p-12 lg:sticky lg:top-4 lg:col-start-1 lg:row-span-2 lg:row-start-1 lg:overflow-hidden">
                        <img src="{{ asset('assets/images/'.$brand->name.'.png') }}" alt="" class="w-3xl max-w-none rounded-xl bg-transparent sm:w-228" />
                    </div>
                    <div class="lg:col-span-2 lg:col-start-2 lg:row-start-2 lg:mx-auto lg:grid lg:w-full lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8">
                        <div class="lg:pr-4">
                            <div class="max-w-xl text-base/7 text-gray-400 lg:max-w-lg">
                                <p>We offer the following services for {{ $brand->name }} consoles.</p>
                                <ul role="list" class="mt-8 text-gray-400">
                                    @forelse($brand->services as $service)
                                        <li class="flex gap-x-3">
                                            <x-icon name="check-badge" outline class="mt-1 size-5 flex-none text-primary-500" />
                                            <span>{{ $service->name }}</span>
                                        </li>
                                    @empty
                                        <span>No services available.</span>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

</div>