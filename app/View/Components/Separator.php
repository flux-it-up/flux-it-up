<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Arr;

class Separator extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $text = null,
        public ?bool $simple = null,
        public ?bool $line = null,
        public ?bool $lineRight = null,
    ) {
        match (true) {
            $this->simple => $this->line = false,
            $this->line => $this->simple = false,
            $this->lineRight => $this->lineRight = true,
            default => $this->simple = true,
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.separator');
    }

    public function personalization(): array
    {
        return Arr::dot([
            'simple' => [
                'wrapper' => 'flex py-2 pl-2',
                'base' => 'text-primary-600 dark:text-dark-600 text-base font-semibold leading-6',
            ],
            'line' => [
                'wrapper' => [
                    'first' => 'relative',
                    'second' => 'absolute inset-0 flex items-center',
                    'third' => 'relative flex justify-center',
                ],
                'border' => 'border-primary-600 dark:border-primary-500 w-full border-t',
                'base' => 'dark:bg-dark-900 text-primary-600 dark:text-dark-600 bg-white px-3 text-base font-bold',
            ],
            'line-right' => [
                'wrapper' => [
                    'first' => 'relative',
                    'second' => 'absolute inset-0 flex items-center',
                    'third' => 'relative flex justify-start',
                ],
                'border' => 'border-primary-100 dark:border-dark-500 w-full border-t',
                'base' => 'dark:bg-dark-700 text-primary-600 dark:text-dark-100 bg-white px-3 text-base font-semibold',
            ],
        ]);
    }
}
