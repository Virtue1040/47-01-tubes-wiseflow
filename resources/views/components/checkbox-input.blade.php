@props(['disabled' => false, 'id' => 'checkbox'])

<input id={{ $id }} autocomplete="off" type="checkbox" @disabled($disabled) {{ $attributes->merge(['class' => 'peer m-auto checked:bg-opacity-100 checked:bg-[#5E93DA] cursor-pointer appearance-none border-[1px] border-gray-200 dark:border-[#303032] bg-[#FAFAFA] p-2 dark:bg-white dark:bg-opacity-10 dark:text-gray-300  rounded-md ']) }}>