@props([
    'title',
    'value',
    'icon' => null,
    'color' => 'blue'
])

@php
$colorClasses = [
    'blue' => 'bg-blue-500',
    'green' => 'bg-green-500',
    'yellow' => 'bg-yellow-500',
    'red' => 'bg-red-500',
    'emerald' => 'bg-emerald-500',
    'purple' => 'bg-purple-500',
];
@endphp

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ $title }}</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $value }}</p>
        </div>
        @if($icon)
            <div class="p-3 rounded-full {{ $colorClasses[$color] ?? $colorClasses['blue'] }}">
                <x-icon name="{{ $icon }}" class="w-6 h-6 text-white" />
            </div>
        @endif
    </div>
</div>