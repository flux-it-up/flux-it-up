@if ($simple)
    <div class="flex py-2 pl-2">
        <span class="text-primary-600 dark:text-dark-600 text-base font-semibold leading-6" x-text="@js($text ?? $slot)"></span>
    </div>
@elseif ($line)
    <div class="relative">
        <div class="absolute inset-0 flex items-center">
            <div class="border-primary-600 dark:border-primary-500 w-full border-t"></div>
        </div>
        <div class="relative flex justify-center">
            <span class="dark:bg-dark-900 text-primary-600 dark:text-dark-600 bg-white px-3 text-base font-bold" x-text="@js($text ?? $slot)"></span>
        </div>
    </div>
@else
    <div class="relative">
        <div class="absolute inset-0 flex items-center">
            <div class="border-primary-100 dark:border-dark-500 w-full border-t"></div>
        </div>
        <div class="relative flex justify-start">
            <span class="dark:bg-dark-700 text-primary-600 dark:text-dark-100 bg-white px-3 text-base font-semibold" x-text="@js($text ?? $slot)"></span>
        </div>
    </div>
@endif