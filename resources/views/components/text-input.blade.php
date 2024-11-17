@props(['disabled' => false])

<input  autocomplete="off" @disabled($disabled) {{ $attributes->merge(['class' => 'border-[1px] border-gray-200 dark:border-[#464649] bg-[#FAFAFA] p-2 dark:bg-white dark:bg-opacity-10 dark:text-gray-300  rounded-md ']) }}>
