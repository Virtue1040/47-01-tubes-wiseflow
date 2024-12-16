@props(['id'])
<div id={{ $id }}
    class="h-auto w-full rounded-2xl flex flex-col dark:bg-[#464649] dark:border-[#272729] border-gray-200 border-[1px] bg-white">
    <x-checkbox-input class="hidden" name="templateCheckbox" />
    <div class="hidden rotate-90" name="templateArrow">
        <x-icon.arrow-right p="20" l="20"></x-icon.arrow-right>
    </div>
    <button
        class="w-auto bg-gray-200 hidden p-[5px] dark:bg-[#242427] border-[1px] dark:border-[#464649] justify-center items-center rounded-xl cursor-pointer hover:bg-gray-100 dark:hover:bg-[#2F2F32]"
        name="templateEdit"><x-icon.set p="20" l="20" /></button>
    <button
        class="w-auto bg-gray-200 hidden p-[5px] dark:bg-[#242427] border-[1px] dark:border-[#464649] justify-center items-center rounded-xl cursor-pointer hover:bg-gray-100 dark:hover:bg-[#2F2F32]"
        name="templateDelete"><x-icon.delete p="20" l="20" /></button>
    <div class="h-[60px] px-7 py-3 flex justify-between dark:bg-[#18181B] bg-white rounded-t-2xl" name="topbar">
        <x-select class="dark:!border-[#464649] !rounded-lg">
            <option value=0 selected>Group By</option>
        </x-select>
        <div class="flex gap-[10px]">
            <x-search placeholder="Search" name="filterTable" />
            <button class="bg-transparent">
                <x-icon.filter p=20 l=20 />
            </button>
            <button class="bg-transparent">
                <x-icon.column p=20 l=20 />
            </button>
        </div>
    </div>
    <div class="flex overflow-x-auto h-auto dark:bg-[#18181B]" name="list">
        <table class="w-full">

        </table>
    </div>
    <div class="h-[60px] px-7 py-3 flex justify-between items-center dark:bg-[#18181B] bg-white rounded-b-2xl"
        name="bottombar">
        <div class="flex gap-[10px] items-center h-full">
            <x-select-text title="Per Page" name="perPageList">
                <option value=10 selected>10</option>
                <option value=20>20</option>
                <option value=50>50</option>
                <option value=2>2</option>
                <option value=1>1</option>
                <option value=9999999999999>All</option>
            </x-select-text>
            <x-a-label name="listInfo">Showing 1 to 10 of 100 results</x-a-label>
        </div>
        <div class="flex gap-[10px] h-full">
            <div class=" border-[1px] dark:border-[#222224] rounded-md h-full flex items-center justify-center">
                <button
                    class="w-[30px] h-full rotate-180 dark:bg-[#242427] border-[1px] dark:border-[#464649] flex justify-center items-center rounded-r-md cursor-pointer hover:bg-gray-100 dark:hover:bg-[#2F2F32]"
                    name="prev">
                    <x-icon.arrow-right p="20" l="20"></x-icon.arrow-right>
                </button>
                <div class="flex justify-center items-center h-full" name="pageList">

                </div>
                <button
                    class="w-[30px] h-full dark:bg-[#242427] border-[1px] dark:border-[#464649] flex justify-center items-center rounded-r-md cursor-pointer hover:bg-gray-100 dark:hover:bg-[#2F2F32]"
                    name="next">
                    <x-icon.arrow-right p="20" l="20"></x-icon.arrow-right>
                </button>
            </div>
        </div>
    </div>
</div>
