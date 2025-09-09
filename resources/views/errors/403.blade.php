<x-site>
    <div class="flex items-center justify-center min-h-screen bg-gray-50 dark:bg-gray-900">
        <div class="text-center p-8 bg-white dark:bg-gray-800 rounded-2xl shadow-lg max-w-md w-full">
            <h1 class="text-7xl font-extrabold text-red-600 dark:text-red-400">403</h1>
            <h2 class="mt-4 text-3xl font-semibold text-gray-700 dark:text-gray-200">
                @lang('Forbidden')
            </h2>
            <p class="mt-2 text-gray-500 dark:text-gray-400">
                @lang('You do not have permission to access this page.')
            </p>

            <div class="mt-6 flex justify-center gap-3">
                <a href="{{ url()->previous() ?? route('welcome') }}"
                   class="px-6 py-3 bg-red-600 text-white font-medium rounded-lg shadow hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 transition">
                    @lang('Go Back')
                </a>
                <a href="{{ route('welcome') }}"
                   class="px-6 py-3 bg-gray-200 text-gray-700 font-medium rounded-lg shadow hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition">
                    @lang('Home')
                </a>
            </div>
        </div>
    </div>
</x-site>