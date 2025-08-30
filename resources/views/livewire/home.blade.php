<x-site-layout>
    <div class="relative min-h-screen w-full">
        <header class="grid !min-h-[49rem] bg-[#0a0a0a] px-8">
            <div class="container mx-auto mt-32 grid h-full w-full grid-cols-1 place-items-center lg:mt-14 lg:grid-cols-2">
                <div class="col-span-1">
                    <h1 class="block antialiased tracking-normal font-sans text-5xl font-semibold leading-tight text-white mb-4">
                        Your console <br /> not working?</h1>
                    <p class="block antialiased font-sans text-xl font-normal leading-relaxed text-inherit mb-7 !text-white md:pr-16 xl:pr-28">
                        Don't let a broken console pause your fun.</p>
                    <div class="flex flex-col gap-2 md:mb-2 md:w-10/12 md:flex-row">
                        <a href="#" wire:navigate class="align-middle select-none font-sans font-bold text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-sm py-3.5 px-7 rounded-lg bg-white text-black shadow-md shadow-blue-gray-500/10 hover:shadow-lg hover:shadow-blue-gray-500/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none flex justify-center items-center gap-3"> Get a Quote </a>
                    </div>
                </div>
                <img alt="team work" loading="lazy" height="300" decoding="async" data-nimg="1"
                    class="col-span-1 my-20 h-full max-h-[30rem] -translate-y-32 md:max-h-[36rem] lg:my-0 lg:ml-auto lg:max-h-[40rem] lg:translate-y-0"
                    style="color:transparent" src="{{ asset('assets/images/xboxonexwcontroller.png') }}" />
            </div>
        </header>
        <div class="mx-8 lg:mx-16 -mt-24 rounded-xl bg-white p-5 md:p-14 shadow-md">
            <div>
                <h3
                    class="block antialiased tracking-normal font-sans text-3xl font-semibold leading-snug text-gray-700 mb-3">Why Choose Us?</h3>
                <div
                    class="block antialiased font-sans text-base leading-relaxed font-normal text-gray-500 lg:w-5/12">
                    <ul class="list-disc">
                        <li>Fast Turnaround - Most repairs completed within 48 hours.</li>
                        <li>Competitive Pricing with No Hidden Fees</li>
                        <li>Mail-in Option Available</li>
                        <li>Limited Warranty on All Repairs</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-site-layout>