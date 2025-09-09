<div class="space-y-24"> {{-- Single root element for Livewire --}}

        {{-- HERO --}}
        <div class="relative min-h-screen w-full">
            <div class="grid !min-h-[49rem] bg-[#0a0a0a] px-8">
                <div class="container mx-auto mt-32 grid h-full w-full grid-cols-1 place-items-center lg:mt-14 lg:grid-cols-2">
                    <div class="col-span-1">
                        <h1 class="text-5xl font-semibold leading-tight text-white mb-4">
                            Your console <br /> not working?
                        </h1>
                        <p class="text-xl text-white mb-7 md:pr-16 xl:pr-28">
                            Don't let a broken console pause your fun.
                        </p>
                        <div class="flex flex-col gap-2 md:mb-2 md:w-10/12 md:flex-row">
                            <a href="{{ route('services') }}" wire:navigate
                               class="font-bold uppercase text-sm py-3.5 px-7 rounded-lg bg-white text-black shadow-md hover:shadow-lg flex justify-center items-center gap-3">
                                Get a Quote
                            </a>
                        </div>
                    </div>
                    <img alt="team work" loading="lazy"
                         class="col-span-1 my-20 h-auto max-h-[20rem] -translate-y-32 md:max-h-[25rem] lg:my-0 lg:ml-auto lg:max-h-[40rem] lg:translate-y-0"
                         src="{{ asset('assets/images/xboxonexwcontroller.png') }}" />
                </div>
            </div>

            <div class="mx-8 lg:mx-16 -mt-24 rounded-xl bg-white p-5 md:p-14 shadow-md items-center">
                <h3 class="text-3xl font-semibold text-gray-700 mb-3">Why Choose Us?</h3>
                <div class="text-base text-gray-500 lg:w-5/12">
                    <ul class="list-disc">
                        <li>Fast Turnaround - Most repairs completed within 48 hours.</li>
                        <li>Competitive Pricing with No Hidden Fees</li>
                        <li>Mail-in Option Available</li>
                        <li>Limited Warranty on All Repairs</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- SERVICES --}}
        <section class="-mt-10 py-18 px-4">
            <div class="container mx-auto mb-15 text-center">
                <h1 class="text-5xl font-bold text-dark-400 mb-4">What We Fix</h1>
                <p class="text-xl text-dark-500 mx-auto w-full px-4 lg:w-11/12 lg:px-8">
                    We specialize in repairs for all major gaming consoles:
                </p>
            </div>

            <div class="container mx-auto grid max-w-6xl grid-cols-1 gap-4 gap-y-12 md:grid-cols-2">
                @forelse($categories as $category)
                    <div class="flex flex-col rounded-xl bg-dark-600 text-dark-700 shadow-md">
                        <div class="p-6">
                            <h5 class="text-xl font-bold text-primary-700 mb-2">
                                {{ $category->name }}
                            </h5>
                            <p class="text-dark-800">{{ $category->description }}</p>
                        </div>
                    </div>
                @empty
                    <p>No service categories found.</p>
                @endforelse
            </div>

            <div class="container mx-auto mt-12 text-center">
                <a href="{{ route('services') }}" wire:navigate
                   class="font-semibold uppercase text-sm py-3.5 px-7 rounded-lg bg-primary-700 text-dark-400 shadow-md hover:shadow-lg">
                    View All Services
                </a>
            </div>
        </section>

        {{-- PRICING --}}
        <div class="relative isolate bg-dark-300 px-6 py-24 sm:py-32 lg:px-8">
        <div class="mx-auto max-w-4xl text-center">
            <h2 class="text-base/7 font-semibold text-primary-900">Pricing</h2>
            <p class="mt-2 text-5xl font-semibold tracking-tight text-balance text-primary-600 sm:text-6xl">Choose your service</p>
        </div>
        <p class="mx-auto mt-6 max-w-2xl text-center text-lg font-medium text-pretty text-dark-700 sm:text-xl/8">Choose a service that will get you back in the gaming chair.</p>
        <div class="mx-auto mt-16 grid max-w-lg grid-cols-1 items-center gap-y-6 sm:mt-20 sm:gap-y-0 lg:max-w-4xl lg:grid-cols-2">
            <div class="rounded-3xl rounded-t-3xl bg-white/60 p-8 ring-1 ring-gray-900/10 sm:mx-8 sm:rounded-b-none sm:p-10 lg:mx-0 lg:rounded-tr-none lg:rounded-bl-3xl">
            <h3 id="tier-standard" class="text-xl md:text-2xl lg:text-3xl font-semibold text-primary-450">Standard Repair</h3>
            <p class="mt-4 flex items-baseline gap-x-2">
                <span class="text-base text-dark-500">Starting at </span>
                <span class="text-5xl font-semibold tracking-tight text-gray-900">$75</span>
            </p>
            <p class="mt-6 text-base/7 text-dark-700">For everyday fixes.</p>
            <ul role="list" class="mt-8 space-y-3 text-sm/6 text-dark-700 sm:mt-10">
                <li class="flex gap-x-3 text-primary-500">
                    <x-icon name="check" class="h-6 w-6 mr-2">
                        <x-slot:right>
                            <span class="text-dark-700">Covers common issues (HDMI port, overheating, disc read errors)*</span>
                        </x-slot:right>
                    </x-icon>
                </li>
                <li class="flex gap-x-3 text-primary-500">
                    <x-icon name="check" class="h-5 w-5 mr-2">
                        <x-slot:right>
                            <span class="text-dark-700">7-10 Business day turnaround</span>
                        </x-slot:right>
                    </x-icon>
                </li>
                <li class="flex gap-x-3 text-primary-500">
                    <x-icon name="check" class="h-5 w-5 mr-2">
                        <x-slot:right>
                            <span class="text-dark-700">30 Day Limited Repair Warranty</span>
                        </x-slot:right>
                    </x-icon>
                </li>
                <li class="flex gap-x-3 text-primary-500">
                    <x-icon name="check" class="h-5 w-5 mr-2">
                        <x-slot:right>
                            <span class="text-dark-700">Free diagnostics</span>
                        </x-slot:right>
                    </x-icon>
                </li>
            </ul>
            <p class="mt-6 text-base/7 text-xs text-dark-500">* Some parts may cost extra</p>
            <a href="#" aria-describedby="tier-standard" class="mt-8 block rounded-md px-3.5 py-2.5 hover:bg-primary-100 text-center text-sm font-semibold text-primary-500 hover:text-primary-700 inset-ring inset-ring-primary-400 hover:inset-ring-primary-300 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600 sm:mt-10">Start a quote</a>
            </div>
            <div class="relative rounded-3xl bg-dark-900 p-8 shadow-2xl ring-1 ring-gray-900/10 sm:p-10">
            <h3 id="tier-priority" class="text-xl md:text-2xl lg:text-3xl font-semibold text-primary-450">
                Priority Repair
            </h3>
            <p class="mt-4 flex items-baseline gap-x-2">
                <span class="text-base text-dark-600">Starting at </span>
                <span class="text-6xl font-semibold tracking-tight text-white">$140</span>        
            </p>
            <p class="mt-6 text-base/7 text-gray-300">For serious gamers who just can't wait.</p>
            <ul role="list" class="mt-8 space-y-3 text-sm/6 text-gray-300 sm:mt-10">
                <li class="flex gap-x-3 text-primary-450">
                    <x-icon name="check" class="h-5 w-5 mr-2">
                        <x-slot:right>
                            <span class="text-gray-300">Covers all standard repair services</span>
                        </x-slot:right>
                    </x-icon>
                </li>
                <li class="flex gap-x-3 text-primary-450">
                    <x-icon name="check" class="h-5 w-5 mr-2">
                        <x-slot:right>
                            <span class="text-gray-300">48-hour turnaround (jump the queue)</span>
                        </x-slot:right>
                    </x-icon>
                </li>
                <li class="flex gap-x-3 text-primary-450">
                    <x-icon name="check" class="h-5 w-5 mr-2">
                        <x-slot:right>
                            <span class="text-gray-300">60 Day Limited Repair Warranty</span>
                        </x-slot:right>
                    </x-icon>
                </li>
                <li class="flex gap-x-3 text-primary-450">
                    <x-icon name="check" class="h-5 w-5 mr-2">
                        <x-slot:right>
                            <span class="text-gray-300">Free Diagnostics</span>
                        </x-slot:right>
                    </x-icon>
                </li>
                <li class="flex gap-x-3 text-primary-450">
                    <x-icon name="check" class="h-5 w-5 mr-2">
                        <x-slot:right>
                            <span class="text-gray-300">Priority phone & email support</span>
                        </x-slot:right>
                    </x-icon>
                </li>
                <li class="flex gap-x-3 text-primary-450">
                    <x-icon name="check" class="h-5 w-5 mr-2">
                        <x-slot:right>
                            <span class="text-gray-300">Cleaning & maintenance check included</span>
                        </x-slot:right>
                    </x-icon>
                </li>
            </ul>
            <p class="mt-6 text-base/7 text-xs text-dark-500">* Some parts may cost extra</p>
            <a href="#" aria-describedby="tier-enterprise" class="mt-8 block rounded-md bg-primary-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:text-primary-200 hover:bg-primary-800 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-500 sm:mt-10">Get started today</a>
            </div>
        </div>
        </div>

        {{-- CUSTOMER REVIEWS --}}
        <section class="px-10 !py-20">
        <div class="container mx-auto">
            <div class="mb-20 flex w-full flex-col items-center">
                <h2
                    class="block antialiased tracking-normal font-sans text-4xl font-bold leading-[1.3] text-primary-700 mb-2">
                    What Our Clients Say</h2>
                <p
                    class="block antialiased font-sans text-xl font-normal leading-relaxed text-inherit mb-10 max-w-3xl text-center !text-dark-600">
                    Discover what our valued clients have to say about their experiences with our services. We take
                    pride in delivering exceptional results and fostering lasting partnerships.</p>
            </div>
            <div class="grid grid-cols-1 gap-x-8 gap-y-12 md:grid-cols-3 lg:px-20">
                <div
                    class="relative flex flex-col bg-clip-border rounded-xl bg-dark-900 text-dark-500 items-center text-center">
                    <div class="p-6">
                        <img src="{{ asset('assets/images/profile_avatar_placeholder.png') }}" alt="Jason M"
                            class="inline-block relative object-cover object-center !rounded-full w-[58px] h-[58px] rounded-lg mb-3" />
                        <h6
                            class="block antialiased tracking-normal font-sans text-base font-bold leading-relaxed text-primary-500">
                            Jason M.</h6>
                        <p
                            class="block antialiased font-sans text-sm leading-normal text-inherit mb-3 font-medium !text-primary-500">
                            Hot Springs, AR</p>
                        <p
                            class="block antialiased font-sans text-base leading-relaxed text-inherit mb-5 font-normal !text-dark-500">
                            &quot;<!-- -->Fast, friendly, and my playstation works like new again. Highly recommend!<!-- -->&quot;</p>
                    </div>
                </div>
                <div
                    class="relative flex flex-col bg-clip-border rounded-xl bg-dark-900 text-dark-500 items-center text-center">
                    <div class="p-6">
                        <img src="{{ asset('assets/images/profile_avatar_placeholder.png') }}" alt="Emily R"
                            class="inline-block relative object-cover object-center !rounded-full w-[58px] h-[58px] rounded-lg mb-3" />
                        <h6
                            class="block antialiased tracking-normal font-sans text-base font-semibold leading-relaxed text-primary-500">
                            Emily R.</h6>
                        <p
                            class="block antialiased font-sans text-sm leading-normal text-inherit mb-3 font-medium !text-primary-500">
                            Glenwood, AR</p>
                        <p
                            class="block antialiased font-sans text-base leading-relaxed text-inherit mb-5 font-normal !text-dark-500">
                            &quot;<!-- -->Great service. They diagnosed and fixed my Xbox in two days!<!-- -->&quot;</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

        {{-- STATS --}}
        <section class="bg-dark-300 -mb-20 py-20 px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 max-w-8xl mx-auto items-center">
                <div class="flex justify-center px-4 lg:px-0">
                    <img alt="iphone-photo"
                        loading="lazy"
                        decoding="async"
                        class="rounded-xl w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-3xl xl:max-w-5xl"
                        src="{{ asset('assets/images/playstation4wds4.png') }}" />
                </div>
                <div class="col-span-1 mx-auto max-w-lg px-4 lg:px-0">
                    <h2
                        class="block antialiased tracking-normal font-sans text-4xl font-semibold leading-[1.3] text-primary-700 mb-4">
                        Repairs We Completed</h2>
                    <p
                        class="block antialiased font-sans font-normal text-inherit mb-5 px-4 text-left text-xl !text-dark-700 lg:px-0">
                        Here is what we have repaired.</p>
                    <div class="col-span-2 grid gap-5 grid-cols-2 ">
                        <div
                            class="relative flex flex-col bg-clip-border rounded-xl bg-transparent text-dark-700 shadow-none">
                            <div class="p-6 grid px-0">
                                <h2
                                    class="block antialiased tracking-normal font-sans text-6xl font-semibold leading-[1.3] text-primary-700 mb-2">
                                    0</h2>
                                <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-normal">
                                    Playstation 5</p>
                            </div>
                        </div>
                        <div
                            class="relative flex flex-col bg-clip-border rounded-xl bg-transparent text-dark-700 shadow-none">
                            <div class="p-6 grid px-0">
                                <h2
                                    class="block antialiased tracking-normal font-sans text-6xl font-semibold leading-[1.3] text-primary-700 mb-2">
                                    0</h2>
                                <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-normal">
                                    Xbox S/X</p>
                            </div>
                        </div>
                        <div
                            class="relative flex flex-col bg-clip-border rounded-xl bg-transparent text-dark-700 shadow-none">
                            <div class="p-6 grid px-0">
                                <h2
                                    class="block antialiased tracking-normal font-sans text-6xl font-semibold leading-[1.3] text-primary-700 mb-2">
                                    2</h2>
                                <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-normal">
                                    Playstation 4</p>
                            </div>
                        </div>
                        <div
                            class="relative flex flex-col bg-clip-border rounded-xl bg-transparent text-dark-700 shadow-none">
                            <div class="p-6 grid px-0">
                                <h2
                                    class="block antialiased tracking-normal font-sans text-6xl font-semibold leading-[1.3] text-primary-700 mb-2">
                                    3</h2>
                                <p class="block antialiased font-sans text-base leading-relaxed text-inherit font-normal">
                                    Xbox One</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- FAQs --}}
        <section class="py-20 bg-dark-800">
            <div class="container mx-auto px-6 lg:px-12">
                <h2 class="text-4xl font-bold text-center text-dark-400 mb-12">
                    Frequently Asked Questions
                </h2>

                <div class="space-y-6 max-w-3xl mx-auto">
                    <!-- Item 1 -->
                    <div x-data="{ open: false }" class="bg-dark-600 shadow-md rounded-xl p-6">
                        <button @click="open = !open" class="flex justify-between items-center w-full text-left">
                            <span class="text-lg font-semibold text-primary-700">How long does a console repair take?</span>
                            <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-primary-700 transform transition-transform duration-200"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="mt-4 text-dark-400">
                            Most repairs are completed within 48 hours, depending on parts availability.
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <div x-data="{ open: false }" class="bg-dark-600 shadow-md rounded-xl p-6">
                        <button @click="open = !open" class="flex justify-between items-center w-full text-left">
                            <span class="text-lg font-semibold text-primary-700">Do you offer a warranty?</span>
                            <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-primary-700 transform transition-transform duration-200"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="mt-4 text-dark-400">
                            Yes! All repairs come with a limited warranty on parts and labor.
                        </div>
                    </div>

                    <!-- Item 3 -->
                    <div x-data="{ open: false }" class="bg-dark-600 shadow-md rounded-xl p-6">
                        <button @click="open = !open" class="flex justify-between items-center w-full text-left">
                            <span class="text-lg font-semibold text-primary-700">Can I mail in my console?</span>
                            <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-primary-700 transform transition-transform duration-200"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="mt-4 text-dark-400">
                            Absolutely! We offer a secure mail-in repair option with fast turnaround times.
                        </div>
                    </div>

                    <!-- Item 4 -->
                    <div x-data="{ open: false }" class="bg-dark-600 shadow-md rounded-xl p-6">
                        <button @click="open = !open" class="flex justify-between items-center w-full text-left">
                            <span class="text-lg font-semibold text-primary-700">What payment methods do you accept?</span>
                            <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-primary-700 transform transition-transform duration-200"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="mt-4 text-dark-400">
                            We accept credit/debit cards and cash in-store.
                        </div>
                    </div>

                    <!-- Item 5 -->
                    <div x-data="{ open: false }" class="bg-dark-600 shadow-md rounded-xl p-6">
                        <button @click="open = !open" class="flex justify-between items-center w-full text-left">
                            <span class="text-lg font-semibold text-primary-700">Do you repair all console types?</span>
                            <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-primary-700 transform transition-transform duration-200"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="mt-4 text-dark-400">
                            Yes, we service PlayStation, Xbox, Nintendo Switch, and accessories.
                        </div>
                    </div>

                    <!-- Item 6 -->
                    <div x-data="{ open: false }" class="bg-dark-600 shadow-md rounded-xl p-6">
                        <button @click="open = !open" class="flex justify-between items-center w-full text-left">
                            <span class="text-lg font-semibold text-primary-700">How can I book a repair?</span>
                            <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-primary-700 transform transition-transform duration-200"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="mt-4 text-dark-400">
                            You can schedule a repair directly on our website or visit our store.
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div> {{-- end single root --}}