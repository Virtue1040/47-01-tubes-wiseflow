@props(['disabled' => false])

<textarea autocomplete="off" @disabled($disabled) {{ $attributes->merge(['class' => 'border-[1px] border-gray-200 dark:border-gray-700 bg-[#FAFAFA] p-3 dark:bg-white dark:bg-opacity-10 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md ']) }}>{{ $slot }}</textarea>
