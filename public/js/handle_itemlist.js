
function handle_itemlist(itemlist, table, column, property) {
    let filter = '';
    let page = 1;
    let maxPage = 10;
    let groupBy = '';
    let orderBy = undefined;

    let apiAddress = table;
    let tableInfo = {};
    let divData = $(itemlist).find("div[name='list']");
    let bottomBar = $(itemlist).find("div[name='bottombar']");
    let pageList = $(bottomBar).find("div[name='pageList']");
    let list = divData.find('table').first();
    let selectedPage = undefined;

    function refreshColorPage(theDiv) {
        if (selectedPage !== undefined) {
            $(selectedPage).prop('disabled', false);
        }
        selectedPage = theDiv;
        $(selectedPage).prop('disabled', true);
    }

    function populatePageList() {
        pageList.empty();
        for (let i = 1; i <= tableInfo['last_page']; i++) {
            let disabled = '';
            if (i === 1) { disabled = 'disabled' }
            let theDiv = $(`
                <button name="${i}" class="dark:disabled:bg-[#2F2F32] disabled:bg-gray-100 disabled:text-[#5E93DA] dark:bg-[#242427] w-[30px] h-full  border-[1px] dark:border-[#464649] flex justify-center items-center cursor-pointer hover:bg-gray-100 dark:hover:bg-[#2F2F32]" ${disabled}>
                    <a class="mx-2 text-sm font-bold text-center text-inherit dark:text-gray-300">${i}</a>
                </button>
            `)
            if (i === 1) { selectedPage = theDiv }
            pageList.append(theDiv)
            theDiv.click(function () {
                page = i;
                populateTable();
                refreshColorPage(theDiv);
            })
        }
    }
    function populateTable(rePopulatePage) {
        $.ajax({
            url: getHost() + '/api/' + apiAddress,
            type: 'GET',
            dataType: 'json',
            data: {
                search: filter,
                page: page,
                maxPage: maxPage,
                groupBy: groupBy,
                orderBy: orderBy
            },
            success: function (response) {
                tableInfo = response['data'];
                table = response['data']['data'];
                list.empty();
                let checkboxTemplate = $(itemlist).find('[name="templateCheckbox"]').clone();
                let arrowTemplate = $(itemlist).find('[name="templateArrow"]').clone();
                function populateColumn() {
                    $(checkboxTemplate).css({
                        display: 'block'
                    });
                    $(arrowTemplate).css({
                        display: 'block'
                    });
                    list.append(`
                                <tr class="dark:bg-[#242427] bg-gray-100 dark:border-[#303032] border-t-[1px] border-b-[1px] w-[50%] " name="columnTR">
                                    <th class="p-4 text-left w-[20px] pl-[20px] pr-[5px]">
                                        ${checkboxTemplate.prop('outerHTML')}
                                    </th>
                                    
                                </tr>
                        `)
                    let columnTR = list.find("tr[name='columnTR']")
                    $.each(column, function (index, columnName) {
                        let button = $(`
                            <th class="p-4 text-left">
                                <button class="flex gap-[5px] items-center" name='columnButton'>
                                    <a class="text-black dark:text-gray-300">${columnName}</a>
                                    ${arrowTemplate.prop('outerHTML')}
                                </button>
                            </th>
                        `)
                        let buttons = $(button).find('button[name="columnButton"]');
                        columnTR.append(button);
                        $(buttons).click(function () {
                            orderBy = index;
                            populateTable();
                        });
                    });
                    if (property['useAction']) {
                        let button = $(`
                            <th class="p-4 text-left">
                                <button class="flex gap-[5px] items-center" name='columnButton'>
                                    <a class="text-black dark:text-gray-300">Action</a>
                                </button>
                            </th>
                        `)
                        columnTR.append(button);
                    }

                }

                populateColumn();
                
                for (let i = 0; i < table.length; i++) {
                    let itemData = table[i];
                    let listData = ``;
                    $.each(column, function (index, columnName) {
                        if (column[index] === undefined) { return true; }
                        listData += `
                            <td class="p-4">
                                <a class="text-black dark:text-gray-300">${itemData[index]}</a>
                            </td>
                        `

                    });

                    let theList = list.append(`
                            <tr class="dark:border-[#303032] border-t-[1px] border-b-[1px] dark:hover:bg-[#242427] hover:bg-gray-100 cursor-pointer" name=${i}>
                                <td class="p-4 w-[20px] pl-[20px] pr-[5px]">
                                    ${checkboxTemplate.prop('outerHTML')}
                                </td>
                                ${listData}
                            </tr>
                        `)
                    if (property['useAction']) {
                        let cloneTemplateDelete = itemlist.find('[name="templateDelete"]').clone();
                        let cloneTemplateSet = itemlist.find('[name="templateEdit"]').clone();
                        cloneTemplateDelete.removeClass('hidden');
                        cloneTemplateSet.removeClass('hidden');
                        let button = $(`
                                <td class="p-4 flex gap-[10px]">
                                    ${cloneTemplateSet.prop('outerHTML')}
                                    ${cloneTemplateDelete.prop('outerHTML')}
                                </td>
                            `);
                        button.find('button[name="templateDelete"]').click(function () {
                            if (property['onDelete']) {
                                property['onDelete'](itemData);
                            }
                        })
                        button.find('button[name="templateEdit"]').click(function () {
                            if (property['onEdit']) {
                                property['onEdit'](itemData);
                            }
                        })
                        theList.find(`tr[name='${i}']`).append(button);
                    }
                }

                $(itemlist).find('a[name="listInfo"]').html(`Showing ${tableInfo['from']} to ${tableInfo['to']} of ${tableInfo['total']} Results`)
                if (rePopulatePage === true) { populatePageList(); }
            },
            error: function (error) {

            }
        })
    }

    function loadTableFunction() {
        let perPageList = $(itemlist).find('select[name="perPageList"]');
        let search = $(itemlist).find('input[name="filterTable"]');
        let next = $(bottomBar).find('button[name="next"]');
        let prev = $(bottomBar).find('button[name="prev"]');
        $(perPageList).on('change', function () {
            maxPage = perPageList.val();
            populateTable(true);
        })
        $(search).on('change input', function () {
            filter = search.val();
            populateTable(true);
        })
        next.click(function () {
            if (page < tableInfo['last_page']) {
                page++;
                populateTable();
                refreshColorPage(pageList.find(`button[name='${page}']`));
            }
        })
        prev.click(function () {
            if (page > 1) {
                page--;
                populateTable();
                refreshColorPage(pageList.find(`button[name='${page}']`));
            }
        })
    }
    populateTable(true);
    loadTableFunction();
}