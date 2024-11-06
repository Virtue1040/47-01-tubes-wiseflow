<button {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 bg-[#5E93DA] dark:bg-[#5E93DA] border border-transparent rounded-md font-semibold text-xs text-white dark:text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-[#315079] focus:bg-gray-700 dark:focus:bg-[#5E93DA] active:bg-gray-900 dark:active:bg-[#5E93DA] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
