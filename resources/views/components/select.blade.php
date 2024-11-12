@props(['disabled' => false])

<div class="relative w-full h-auto">
<select autocomplete="off" @disabled($disabled) {{ $attributes->merge(['class' => 'border-[1px] border-gray-200 dark:border-gray-700 appearance-none bg-[#FAFAFA] p-[6.5px]  dark:bg-white dark:bg-opacity-10 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md ']) }}>{{ $slot }}</select>
<!-- Custom Arrow positioned on the right with margin-right -->
<div class="absolute right-2 top-1/2 text-gray-400 transform -translate-y-1/2 pointer-events-none">
    <!-- Example of a simple SVG for the down arrow -->
    <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 w-5 h-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
      <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
    </svg>
  </div>
</div>