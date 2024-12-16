@section('property_name', $property->property_name)
@section('property_rent', $property)
@section('property_id', $property->id_property)
@section('title', '- Rent Management')

<x-app-layout>
    <script>
        $('#contentContainer').css('padding', '0px');
        $("#contentContainer").css("display", 'flex')
        $(document).ready(function() {
            let oldInput = @json(old());

            @if ($rent !== null)
                let saveChangedCard = $("#saveChangedCard");
                let facilityDummy = $("#facility-item-dummy");
                let albumDummy = $("#rentAlbumDummy");
                let renttagDummy = $("#renttagDummy");
                let theSaveButton = $('#saveChange');
                let theDiscardButton = $('#discardChange');
                let theLoadingIcon = saveChangedCard.find('div[name="loadingIcon"]');
                let lastWidth = saveChangedCard.width();
                let isDataSaved = true;

                let original = {
                    'rent_name': '{{ $rent->rent_name }}',
                    'rent_desc': decodeHTML('{{ $rent->rent_desc }}'),
                    'stock': '{{ $rent->stock }}',
                    'rent_price': '{{ $rent->rent_price }}',
                    'availability': '{{ $rent->availability }}',
                    'id_cover': '{{ $rent->id_cover !== null ? $rent->id_cover : '' }}',
                    'imagePath': '{{ $rent->id_cover !== null && $rent->album !== null ? $rent->album->imagePath : '' }}'
                }

                let changedData = {
                    'rentFacility': [],
                    'rentAlbum': [],
                    'rentTag': [],
                    'rentFacilityOrder': [],
                    'rent_name': original['rent_name'],
                    'rent_desc': original['rent_desc'],
                    'stock': original['stock'],
                    'rent_price': original['rent_price'],
                    'availability': original['availability'],
                    'id_cover': original['id_cover'],
                    'imagePath': original['imagePath']
                }

                $("#albumImage").on('change', function() {
                    $.ajax({
                        url: "{{ route('rentalbum.store') }}",
                        type: "POST",
                        dataType: 'json',
                        data: new FormData($('#formRentAlbum')[0]),
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            let clone = albumDummy.clone();
                            clone.css('display', 'block');
                            clone.find('div[name="albumImage"]').css('background-image',
                                'url("' +
                                "{{ asset('storage') }}" + '/' + data.data.imagePath + '")');
                            $("#rentAlbumContainer").append(clone);
                            console.log(data);
                            clone.find('button[name="setRentCover"]').click(function(event) {
                                $("#rentCover").attr('src',
                                    "{{ asset('storage') }}" + '/' +
                                    data.data.imagePath);
                                changedData['id_cover'] = data.data.id_album;
                                changedData['imagePath'] = data.data.imagePath;
                                askSave(true);
                            });
                            clone.find('button[name="deleteAlbum"]').click(function(event) {
                                const index = changedData['rentAlbum'].push({
                                    activity: 'delete',
                                    object: clone,
                                    id_album: data.id_album,
                                }) - 1;
                                clone.css('display', 'none');
                                askSave(true);
                            });

                            Toast.fire({
                                icon: 'success',
                                title: 'Album Uploaded',
                            });
                        }
                    })
                });

                Object.keys(changedData).forEach(key => {
                    if (typeof(changedData[key]) !== 'object') {
                        $(`[name='${key}']`).on('input change', function(event) {
                            changedData[key] = $(this).val();
                            askSave(true);
                        });
                    }
                })

                function onSave() {
                    Object.keys(changedData).forEach(key => {
                        if (typeof(changedData[key]) === 'object') {
                            if (changedData[key].length > 0) {
                                let getOnlyAdd = changedData[key].filter(data => data
                                    .activity ===
                                    'add');
                                let getOnlyDelete = changedData[key].filter(data => data
                                    .activity ===
                                    'delete');
                                let getOnlyUpdate = changedData[key].filter(data => data
                                    .activity ===
                                    'update');
                                changedData[key] = [];
                                if (getOnlyAdd.length > 0) {
                                    if (key === 'rentFacility') {
                                        $.ajax({
                                            url: "{{ route('rentfacility.store', ['id' => $rent->id_rent]) }}",
                                            type: "POST",
                                            dataType: 'json',
                                            contentType: 'application/json',
                                            async: false,
                                            data: JSON.stringify({
                                                data: getOnlyAdd,
                                            }),
                                            success: function(response) {
                                                for (let i = 1; i <= response.data.data
                                                    .length; i++) {
                                                    let data = response.data.data[i - 1];
                                                    let object = getOnlyAdd[i - 1].object;
                                                    object.attr('data-id', data.item_order);
                                                    object.attr('data-ids', data.id_rentfacility);
                                                    let deleteButton = object.find(
                                                        'button[name="delete"]');
                                                    let select = object.find(
                                                        'select[name="id_facility"]');
                                                    let openButton = object.find(
                                                        'button[name="open"]');
                                                    let quantity = object.find(
                                                        'input[name="quantity"]');
                                                    select.off('change');
                                                    select.change(function() {
                                                        let index = undefined
                                                        changedData['rentFacility']
                                                            .forEach(
                                                                (data, i) => {
                                                                    if (data.object.is(
                                                                            object)) {
                                                                        index = i;
                                                                    }
                                                                });
                                                        if (index !== undefined) {
                                                            changedData['rentFacility'][
                                                                index
                                                            ]['id_facility'] = $(
                                                                this).val();
                                                        } else {
                                                            changedData['rentFacility']
                                                                .push({
                                                                    activity: 'update',
                                                                    object: object,
                                                                    id_rentfacility: data
                                                                        .id_rentfacility,
                                                                    id_facility: $(
                                                                            this)
                                                                        .val(),
                                                                        original: {
                                                                            id_facility: data.id_facility,
                                                                            quantity: data.quantity,
                                                                        }
                                                                })
                                                        }
                                                        askSave(true);
                                                    });
                                                    quantity.off('change');
                                                    quantity.change(function() {
                                                        let index = undefined
                                                        changedData['rentFacility']
                                                            .forEach(
                                                                (data, i) => {
                                                                    if (data.object.is(
                                                                            object)) {
                                                                        index = i;
                                                                    }
                                                                });
                                                        if (index !== undefined) {
                                                            changedData['rentFacility'][
                                                                    index
                                                                ]['quantity'] = $(this)
                                                                .val();
                                                        } else {
                                                            changedData['rentFacility']
                                                                .push({
                                                                    activity: 'update',
                                                                    object: object,
                                                                    id_rentfacility: data
                                                                        .id_rentfacility,
                                                                    quantity: $(
                                                                            this)
                                                                        .val(),
                                                                        original: {
                                                                            id_facility: data.id_facility,
                                                                            quantity: data.quantity,
                                                                        }
                                                                })
                                                        }
                                                        askSave(true);
                                                    });
                                                    openButton.off('click');
                                                    openButton.click(function() {
                                                        $.ajax({
                                                            url: "/api/facility/" +
                                                                data
                                                                .id_facility,
                                                            type: "GET",
                                                            dataType: 'json',
                                                            success: function(
                                                                response) {
                                                                if (response
                                                                    .success
                                                                ) {
                                                                    previewFacility
                                                                        (response
                                                                            .data,
                                                                            false
                                                                        );
                                                                } else {
                                                                    Toast
                                                                        .fire({
                                                                            icon: 'error',
                                                                            title: 'You dont have access to this facility',
                                                                        })
                                                                }
                                                            }
                                                        })
                                                    });
                                                    deleteButton.off('click');
                                                    deleteButton.click(function() {
                                                        const index = changedData[
                                                            key].push({
                                                            activity: 'delete',
                                                            object: object,
                                                            id_rentfacility: data
                                                                .id_rentfacility,
                                                        }) - 1;
                                                        object.css('display', 'none');
                                                        askSave(true);
                                                    });
                                                    updateRentFacilityOrder();
                                                }
                                            },
                                            error: function(errors) {
                                                Toast.fire({
                                                    icon: 'error',
                                                    title: errors.responseJSON.message,
                                                }).then(function() {
                                                    askSave(false, true);
                                                })
                                            }
                                        })
                                    } else if (key === 'rentTag') {
                                        $.ajax({
                                            url: "{{ route('renttag.store', ['id' => $rent->id_rent]) }}",
                                            type: "POST",
                                            dataType: 'json',
                                            contentType: 'application/json',
                                            async: false,
                                            data: JSON.stringify({
                                                data: getOnlyAdd,
                                            }),
                                            success: function(response) {
                                                for (let i = 1; i <= response.data.data
                                                    .length; i++) {
                                                    let data = response.data.data[i - 1];
                                                    let object = getOnlyAdd[i - 1].object;
                                                    object.off('click');
                                                    object.click(function() {
                                                        const index = changedData[
                                                            key].push({
                                                            activity: 'delete',
                                                            object: object,
                                                            id_tag: data.id_tag
                                                        }) - 1;
                                                        object.css('display', 'none');
                                                        askSave(true);
                                                    });
                                                }

                                            },
                                            error: function(xhr) {
                                                console.log(xhr);
                                            }
                                        })
                                    }

                                }
                                if (getOnlyDelete.length > 0) {
                                    if (key === 'rentFacility') {
                                        $.ajax({
                                            url: "{{ route('rentfacility.delete', ['id' => $rent->id_rent]) }}",
                                            type: "DELETE",
                                            dataType: 'json',
                                            contentType: 'application/json',
                                            async: false,
                                            data: JSON.stringify({
                                                data: getOnlyDelete,
                                            }),
                                            success: function(data) {
                                                if (data.success) {
                                                    getOnlyDelete.forEach(data => {
                                                        data.object.remove();
                                                    });
                                                }
                                            }
                                        })
                                    } else if (key === 'rentAlbum') {
                                        $.ajax({
                                            url: "{{ route('rentalbum.delete', ['id' => $rent->id_rent]) }}",
                                            type: "DELETE",
                                            dataType: 'json',
                                            contentType: 'application/json',
                                            async: false,
                                            data: JSON.stringify({
                                                data: getOnlyDelete,
                                            }),
                                            success: function(data) {
                                                if (data.success) {
                                                    getOnlyDelete.forEach(data => {
                                                        data.object.remove();
                                                    });
                                                    $("#rentCover").attr('src', '');
                                                }
                                            }
                                        })
                                    } else if (key === 'rentTag') {
                                        $.ajax({
                                            url: "{{ route('renttag.delete', ['id' => $rent->id_rent]) }}",
                                            type: "DELETE",
                                            dataType: 'json',
                                            contentType: 'application/json',
                                            async: false,
                                            data: JSON.stringify({
                                                data: getOnlyDelete,
                                            }),
                                            success: function(data) {
                                                if (data.success) {
                                                    getOnlyDelete.forEach(data => {
                                                        data.object.remove();
                                                    });
                                                }
                                            },
                                            error: function(xhr) {
                                                console.log(xhr);
                                            }
                                        })
                                    }
                                }
                                if (getOnlyUpdate.length > 0) {
                                    if (key === 'rentFacility') {
                                        $.ajax({
                                            url: "{{ route('rentfacility.update', ['id' => $rent->id_rent]) }}",
                                            type: "PUT",
                                            dataType: 'json',
                                            contentType: 'application/json',
                                            async: false,
                                            data: JSON.stringify({
                                                data: getOnlyUpdate,
                                            }),
                                            success: function(response) {
                                                if (response.success) {
                                                    for (let i = 1; i <= response.data.data
                                                    .length; i++) {
                                                        let data = response.data.data[i - 1];
                                                        let object = getOnlyUpdate[i - 1].object;
                                                        object.attr('data-id', data.item_order);
                                                        object.attr('data-ids', data.id_rentfacility);
                                                        let deleteButton = object.find(
                                                            'button[name="delete"]');
                                                        let select = object.find(
                                                            'select[name="id_facility"]');
                                                        let openButton = object.find(
                                                            'button[name="open"]');
                                                        let quantity = object.find(
                                                            'input[name="quantity"]');
                                                        select.off('change');
                                                        select.change(function() {
                                                            let index = undefined
                                                            changedData['rentFacility']
                                                                .forEach(
                                                                    (data, i) => {
                                                                        if (data.object.is(
                                                                                object)) {
                                                                            index = i;
                                                                        }
                                                                    });
                                                            if (index !== undefined) {
                                                                changedData['rentFacility'][
                                                                    index
                                                                ]['id_facility'] = $(
                                                                    this).val();
                                                            } else {
                                                                changedData['rentFacility']
                                                                    .push({
                                                                        activity: 'update',
                                                                        object: object,
                                                                        id_rentfacility: data
                                                                            .id_rentfacility,
                                                                        id_facility: $(
                                                                                this)
                                                                            .val(),
                                                                            original: {
                                                                                id_facility: data.id_facility,
                                                                                quantity: data.quantity,
                                                                            }
                                                                    })
                                                            }
                                                            askSave(true);
                                                        });
                                                        quantity.off('change');
                                                        quantity.change(function() {
                                                            let index = undefined
                                                            changedData['rentFacility']
                                                                .forEach(
                                                                    (data, i) => {
                                                                        if (data.object.is(
                                                                                object)) {
                                                                            index = i;
                                                                        }
                                                                    });
                                                            if (index !== undefined) {
                                                                changedData['rentFacility'][
                                                                        index
                                                                    ]['quantity'] = $(this)
                                                                    .val();
                                                            } else {
                                                                changedData['rentFacility']
                                                                    .push({
                                                                        activity: 'update',
                                                                        object: object,
                                                                        id_rentfacility: data
                                                                            .id_rentfacility,
                                                                        quantity: $(
                                                                                this)
                                                                            .val(),
                                                                            original: {
                                                                                id_facility: data.id_facility,
                                                                                quantity: data.quantity,
                                                                            }
                                                                    })
                                                            }
                                                            askSave(true);
                                                        });
                                                        openButton.off('click');
                                                        openButton.click(function() {
                                                            $.ajax({
                                                                url: "/api/facility/" +
                                                                    data
                                                                    .id_facility,
                                                                type: "GET",
                                                                dataType: 'json',
                                                                success: function(
                                                                    response) {
                                                                    if (response
                                                                        .success
                                                                    ) {
                                                                        previewFacility
                                                                            (response
                                                                                .data,
                                                                                false
                                                                            );
                                                                    } else {
                                                                        Toast
                                                                            .fire({
                                                                                icon: 'error',
                                                                                title: 'You dont have access to this facility',
                                                                            })
                                                                    }
                                                                }
                                                            })
                                                        });
                                                        deleteButton.off('click');
                                                        deleteButton.click(function() {
                                                            const index = changedData[
                                                                key].push({
                                                                activity: 'delete',
                                                                object: object,
                                                                id_rentfacility: data
                                                                    .id_rentfacility,
                                                            }) - 1;
                                                            object.css('display', 'none');
                                                            askSave(true);
                                                        });
                                                    }
                                                }
                                            },
                                            error: function(xhr) {
                                                console.log(xhr);
                                            }
                                        })
                                    }
                                    if (key === 'rentFacilityOrder') {
                                        $.ajax({
                                            url: "{{ route('rentfacility.update', ['id' => $rent->id_rent]) }}",
                                            type: "PUT",
                                            dataType: 'json',
                                            contentType: 'application/json',
                                            async: false,
                                            data: JSON.stringify({
                                                data: getOnlyUpdate,
                                            }),
                                            success: function(data) {
                                                if (data.success) {
                                                    getOnlyUpdate.forEach(data => {
                                                        data.object.attr('data-id', data
                                                            .item_order);
                                                        data.object.attr('data-ids', data
                                                            .id_rentfacility);
                                                    });
                                                    updateRentFacilityOrder();
                                                }
                                            },
                                            error: function(xhr) {
                                                console.log(xhr);
                                            }
                                        })
                                    }
                                }
                            }
                        } else {
                            if (changedData[key] !== original[key]) {
                                $.ajax({
                                    url: "{{ route('rent.update', ['id' => $rent->id_rent]) }}",
                                    type: "PUT",
                                    dataType: 'json',
                                    async: false,
                                    data: {
                                        [key]: changedData[key],
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            original[key] = changedData[key];
                                            if (key === 'id_cover') {
                                                original['imagePath'] = changedData['imagePath']
                                            }
                                            $("#rent-" + response.data.id_rent).find('p').text(
                                                response.data.rent_name);
                                        }
                                    },
                                    error: function(xhr) {
                                        console.log(xhr);
                                    }
                                })
                            }
                        }
                    });
                    Toast.fire({
                        icon: 'success',
                        title: 'Changes Saved',
                    });
                }

                function onDiscard() {
                    Object.keys(changedData).forEach(key => {
                        if (typeof(changedData[key]) === 'object') {
                            let getOnlyAdd = changedData[key].filter(data => data.activity === 'add');
                            let getOnlyDelete = changedData[key].filter(data => data.activity ===
                                'delete');
                            let getOnlyUpdate = changedData[key].filter(data => data.activity ===
                                'update');
                            getOnlyAdd.forEach(data => {
                                data.object.remove();
                            });

                            getOnlyDelete.forEach(data => {
                                data.object.css('display', 'flex');
                            });

                            if (key === 'rentFacility') {
                                getOnlyUpdate.forEach(data => {
                                    let object = data.object;
                                    let select = object.find('select[name="id_facility"]');
                                    let quantity = object.find('input[name="quantity"]');
                                    if (data.original.id_facility !== undefined){
                                        select.val(data.original.id_facility);
                                    }
                                    if (data.quantity !== undefined){
                                        quantity.val(data.original.quantity);
                                    }

                                });
                            } 

                            if (key === 'rentFacilityOrder') {
                                getOnlyUpdate.forEach(data => {
                                    let object = data.object;
                                    object.attr('data-id', data.original.item_order);
                                    object.attr('data-ids', data.original.id_rentfacility);
                                });
                                $('#rentFacilityContainer .item').sort(function(a, b) {
                                    return $(a).attr('data-id') - $(b).attr('data-id');
                                    
                                }).appendTo('#rentFacilityContainer');
                            }

                            changedData[key] = [];
                        } else {
                            const editor = tinymce.get(key);
                            let object = $('#overview').find(`[name='${key}']`);
                            if (object.attr('type') === 'radio') {
                                let radio = object.filter(`[value='${original[key]}']`);
                                radio.prop('checked', true).change();
                            } else {
                                object.val(original[key]).change();
                            }
                            if (key === 'id_cover') {
                                $("#rentCover").attr('src',
                                    "{{ asset('storage') }}" + '/' + original['imagePath']);
                            }
                            changedData[key] = original[key];
                            if (editor !== null) {
                                editor.setContent(decodeHTML(original[key]));
                            }
                        }
                    });
                }

                function checkValidation() {
                    let anyChange = false
                    Object.keys(changedData).forEach(key => {
                        if (typeof(changedData[key]) === 'object') {
                            if (changedData[key].length > 0) {
                                anyChange = true;
                            }
                        } else {
                            if (changedData[key] !== original[key]) {
                                anyChange = true;
                            }
                        }
                    })

                    return anyChange;
                }

                function askSave(bool, force) {
                    bool = checkValidation();
                    if (bool) {
                        if (!isDataSaved && (force === undefined || !force)) {
                            return;
                        }
                        $("button[name='openOverview']").click();
                        isDataSaved = false;
                        ToastSave.fire({
                            icon: 'info',
                            title: 'You have unsaved changes',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                onSave();
                            } else if (result.isDenied) {
                                onDiscard();
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Changes are not saved',
                                })
                            }
                            isDataSaved = true;
                        });
                        return;
                    }
                    ToastSave.close();
                }

                $(window).on('beforeunload', function(e) {
                    if (!isDataSaved) {
                        const confirmationMessage =
                            "You have unsaved changes. Are you sure you want to leave?";
                        (e || window.event).returnValue = confirmationMessage;
                        return confirmationMessage;
                    }
                });

                $("#saveChange").click(function(event) {
                    saveChangedCard.animate({
                        width: '50px',
                    }, function() {
                        theSaveButton.css('display', 'none');
                        theDiscardButton.css('display', 'none');
                        theLoadingIcon.css('display', 'flex');
                        setTimeout(function() {

                            askSave(false);
                        }, 1000);
                    });
                });

                $("#discardChange").click(function(event) {
                    let getOnlyAdd = changedData['rentFacility'].filter(data => data.activity === 'add');
                    let getOnlyDelete = changedData['rentFacility'].filter(data => data.activity ===
                        'delete');
                    saveChangedCard.animate({
                        width: '50px',
                    }, function() {
                        theSaveButton.css('display', 'none');
                        theDiscardButton.css('display', 'none');
                        theLoadingIcon.css('display', 'flex');

                        askSave(false, 'error', 'Changes Discarded');
                    });
                });

                function addFacility(id_facility = 1) {
                    let clone = facilityDummy.clone();
                    clone.css('display', 'flex');
                    $("#rentFacilityContainer").append(clone);

                    const index = changedData['rentFacility'].push({
                        activity: 'add',
                        object: clone,
                        id_facility: id_facility,
                        quantity: 0,
                    }) - 1;

                    clone.find('select').val(id_facility);
                    clone.find('select').change(function(event) {
                        changedData['rentFacility'][index]['id_facility'] = $(this).val();
                    });
                    clone.find('input[name="quantity"]').change(function(event) {
                        changedData['rentFacility'][index]['quantity'] = $(this).val();
                    });
                    clone.find('button[name="open"]').click(function(event) {
                        $.ajax({
                            url: "/api/facility/" + changedData['rentFacility'][index][
                                'id_facility'
                            ],
                            type: "GET",
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    previewFacility(response.data, true);
                                } else {
                                    Toast.fire({
                                        icon: 'error',
                                        title: 'You dont have access to this facility',
                                    })
                                }
                            }
                        })
                    });
                    clone.find('button[name="delete"]').click(function(event) {
                        changedData['rentFacility'].splice(index, 1);
                        clone.remove();
                        askSave(false);
                    });
                    clone.find('button[name="open"]').click(function(event) {

                    });
                    $("#rentFacilityContainer").sortable("refresh");
                    askSave(true);
                }

                $("#addFacility").click(function(event) {
                    addFacility();
                });

                let rentfacilities = @json($rent->getRentFacility);
                rentfacilities.forEach(data => {
                    let clone = facilityDummy.clone();
                    clone.css('display', 'flex');
                    $("#rentFacilityContainer").append(clone);

                    clone.attr('data-id', data.item_order);
                    clone.attr('data-ids', data.id_rentfacility);
                    clone.find('input[name="quantity"]').val(data.quantity);
                    clone.find('select').val(data.id_facility);
                    clone.find('select').change(function() {
                        let index = undefined
                        changedData['rentFacility'].forEach(
                            (data, i) => {
                                if (data.object.is(clone)) {
                                    index = i;
                                }
                            });
                        if (index !== undefined) {
                            changedData['rentFacility'][index]['id_facility'] = $(
                                this).val();
                        } else {
                            changedData['rentFacility'].push({
                                activity: 'update',
                                object: clone,
                                id_rentfacility: data
                                    .id_rentfacility,
                                id_facility: $(
                                    this).val(),
                                    original: {
                                        id_facility: data.id_facility,
                                        quantity: data.quantity,
                                    }
                            })
                        }
                        askSave(true);
                    });
                    clone.find('input[name="quantity"]').change(function() {
                        let index = undefined
                        changedData['rentFacility'].forEach(
                            (data, i) => {
                                if (data.object.is(clone)) {
                                    index = i;
                                }
                            });
                        if (index !== undefined) {
                            changedData['rentFacility'][index]['quantity'] = $(
                                this).val();
                        } else {
                            changedData['rentFacility'].push({
                                activity: 'update',
                                object: clone,
                                id_rentfacility: data
                                    .id_rentfacility,
                                quantity: $(
                                    this).val(),
                                    original: {
                                        id_facility: data.id_facility,
                                        quantity: data.quantity,
                                    }
                            })
                        }
                        askSave(true);
                    });
                    clone.find('button[name="open"]').click(function(event) {
                        $.ajax({
                            url: "/api/facility/" + data.id_facility,
                            type: "GET",
                            dataType: 'json',
                            success: function(response) {
                                if (response.success) {
                                    previewFacility(response.data, true);
                                } else {
                                    Toast.fire({
                                        icon: 'error',
                                        title: 'You dont have access to this facility',
                                    })
                                }
                            }
                        })
                    });
                    clone.find('button[name="delete"]').click(function(event) {
                        const index = changedData['rentFacility'].push({
                            activity: 'delete',
                            object: clone,
                            id_rentfacility: data.id_rentfacility,
                        }) - 1;
                        clone.css('display', 'none');
                        askSave(true);
                    });
                });

                let rentAlbum = @json($rent->getAlbum);
                rentAlbum.forEach(data => {
                    let clone = albumDummy.clone();
                    clone.css('display', 'block');
                    clone.find('div[name="albumImage"]').css('background-image', 'url("' +
                        "{{ asset('storage') }}" + '/' + data.imagePath + '")');
                    $("#rentAlbumContainer").append(clone);

                    clone.find('button[name="setRentCover"]').click(function(event) {
                        $("#rentCover").attr('src',
                            "{{ asset('storage') }}" + '/' +
                            data.imagePath);
                        changedData['id_cover'] = data.id_album;
                        changedData['imagePath'] = data.imagePath;
                        askSave(true);
                    });
                    clone.find('button[name="deleteAlbum"]').click(function(event) {
                        const index = changedData['rentAlbum'].push({
                            activity: 'delete',
                            object: clone,
                            id_album: data.id_album,
                        }) - 1;
                        clone.css('display', 'none');
                        askSave(true);
                    });
                });

                let rentTag = @json($rent->getRentTag);
                rentTag.forEach(data => {
                    let clone = renttagDummy.clone();
                    clone.removeClass("hidden");
                    clone.html(data.tag);
                    $("#renttagContainer").append(clone);

                    clone.click(function() {
                        const index = changedData['rentTag'].push({
                            activity: 'delete',
                            object: clone,
                            id_tag: data.id_tag,
                        }) - 1;
                        clone.css('display', 'none');
                        askSave(true);
                    })
                });

                function addRentTag() {
                    let theTag = $("#renttagbox").val();
                    let clone = renttagDummy.clone();
                    clone.removeClass("hidden");
                    clone.html(theTag)
                    $("#renttagContainer").append(clone);

                    const index = changedData['rentTag'].push({
                        activity: 'add',
                        object: clone,
                        tag: theTag,
                    }) - 1;

                    clone.click(function() {
                        changedData['rentTag'].splice(index, 1);
                        clone.remove();
                        askSave(false);
                    })

                    askSave(true);
                }

                $("#addrenttag").click(function() {
                    addRentTag();
                })
                $("#renttagbox").onEnter(function() {
                    addRentTag();
                });
                handle_itemlist($('#guest-list'), 'rent/guest/' + {{ $rent->id_rent }}, {
                    'id_resident': 'ID Recident',
                    'full_name': 'Name',
                    'status': 'Status',
                    'check_in': 'Check In',
                    'check_out': 'Check Out',
                }, {});

                window.addFacility = addFacility;
                window.changedData = changedData;
                window.askSave = askSave;
            @endif
        })
    </script>
    <script>
        let oldInput = @json(old());
        $(document).ready(function() {
            if (oldInput['form_name'] !== undefined) {
                if (oldInput['form_name'].includes("rent")) {
                    createRent();
                }
                if (oldInput['form_name'].includes("facility/")) {
                    previewFacility(oldInput, true);
                }
                if (oldInput['form_name'].includes("facility")) {
                    createFacility();
                }
                if (oldInput['form_name'].includes("rent/")) {
                    rentDeleteModal(oldInput['id_rent']);
                }
            }
        })

        function createRent() {
            if (createBounced) {
                return;
            }
            createBounced = true;
            let returns = init_create_modal("rent", [{
                title: 'Rent Creation'
            }], [
                `
                            <div>
                                <input name="form_name" value='a' type="hidden">
                                <input name="id_property" value="{{ $property->id_property }}" type="hidden">
                                <div class="flex justify-between gap-[15px] ">
                                    <div class="mt-3 w-full h-full min-w-[0px]">
                                        <x-input-label for="rent_name">Nama Rent <a class="text-red-700">*</a></x-input-label>
                                        <x-text-input id="rent_name" style="" class="block mt-2 w-full h-full bg-gray-200" placeholder="Nama Rent"  type="text" name="rent_name"
                                            :value="old('rent_name')"  autofocus/>
                                    </div>
                                    <x-input-error :messages="$errors->get('rent_name')" class="mt-1" />
                                    <div class="mt-3 w-full h-full min-w-[0px]">
                                        <x-input-label for="stock">Rent Stock <a class="text-red-700">*</a></x-input-label>
                                        <x-text-input id="stock" style="" class="block mt-2 w-full h-full bg-gray-200" placeholder="Rent Stock"  type="number" name="stock"
                                            :value="old('stock')"  autofocus/>
                                    </div>
                                    <x-input-error :messages="$errors->get('stock')" class="mt-1" />
                                    
                                </div>
                                <div class="mt-3 w-full h-full min-w-[0px]">
                                        <x-input-label for="rent_price">Rent Price <a class="text-red-700">*</a></x-input-label>
                                        <x-custom-input id="rent_price" class="!pr-[0px]" placeholder="Price"  type="number" name="rent_price"
                                            :value="old('rent_price')"  autofocus>Rp.</x-custom-input>
                                    </div>
                                <x-input-error :messages="$errors->get('rent_price')" class="mt-1" />
                                <div class="mt-3 w-full min-w-[0px] ">
                                    <x-input-label for="rent_desc_modal">Rent Description <a class="text-red-700">*</a></x-input-label>
                                    <x-text-area id="rent_desc_modal" style="" class="block mt-2 w-full h-[150px] bg-gray-200" placeholder="Deskripsi Rent"  type="text" name="rent_desc"
                                    autofocus>{{ old('rent_desc') }}</x-text-area>
                                </div>
                                <x-input-error :messages="$errors->get('rent_desc')" class="mt-1" />
                            </div>
                        `,
            ], {
                1: ['rent_name', 'stock', 'rent_desc', 'rent_price'],
            }, {
                lastButton: "Create Rent",
                onCreate: function(form) {
                    loadTinyMCE('textarea#rent_desc_modal', function(editor) {
                        editor.on('Change', function() {
                            $("textarea#rent_desc_modal").val(editor.getContent())
                                .trigger(
                                    "change");
                        });
                    });
                    createBounced = false;
                },
            })
        }

        function createFacility() {
            if (createBounced) {
                return;
            }
            createBounced = true;
            let returns = init_create_modal("facility", [{
                title: 'Facility Creation'
            }, {
                title: 'Upload Image'
            }], [
                `
                            <div>
                                <input name="form_name" value='a' type="hidden">
                                <input name="id_property" value="{{ $property->id_property }}" type="hidden">
                                <div class="flex justify-between gap-[15px] ">
                                    <div class="mt-3 w-full h-full min-w-[0px]">
                                        <x-input-label for="facility_name">Nama Fasilitas <a class="text-red-700">*</a></x-input-label>
                                        <x-text-input id="facility_name" style="" class="block mt-2 w-full h-full bg-gray-200" placeholder="Nama Fasilitas"  type="text" name="facility_name"
                                            :value="old('facility_name')"  autofocus/>
                                    </div>
                                    <x-input-error :messages="$errors->get('facility_name')" class="mt-1" />
                                    <div class="mt-3 w-full h-full min-w-[0px]">
                                        <x-input-label for="facility_type">Facility Type <a class="text-red-700">*</a></x-input-label>
                                        <x-text-input id="facility_type" style="" class="block mt-2 w-full h-full bg-gray-200" placeholder="Tipe Fasilitas (Not case sencitive)"  type="text" name="facility_type"
                                            :value="old('facility_type')"  autofocus/>
                                    </div>
                                    <x-input-error :messages="$errors->get('facility_type')" class="mt-1" />
                                    
                                </div>
                                <div class="mt-3 w-full min-w-[0px] ">
                                    <x-input-label for="facility_desc_modal">Facility Description <a class="text-red-700">*</a></x-input-label>
                                    <x-text-area id="facility_desc_modal" style="" class="block mt-2 w-full h-[150px] bg-gray-200" placeholder="Deskripsi Fasilitas"  type="text" name="facility_desc"
                                    autofocus>{{ old('facility_desc') }}</x-text-area>
                                </div>
                                <x-input-error :messages="$errors->get('facility_desc')" class="mt-1" />
                            </div>
                        `, `
                            <div>
                                <div class="flex justify-center items-center w-full h-auto min-h-[350px] py-[25px] flex-col gap-4 border-4 rounded-2xl border-dashed" id="property_upload_area">
                                    <x-uploadfile id="albumImage" name="facility_image" text="Upload or Drag Here (.jpg/.jpeg)"></x-uploadfile>
                                </div>
                                <x-input-error :messages="$errors->get('facility_image')" class="mt-1" />
                                
                            </div>
                        `,
            ], {
                1: ['facility_name', 'facility_type', 'facility_desc'],
            }, {
                lastButton: "Create Facility",
                onCreate: function(form) {
                    loadTinyMCE('textarea#facility_desc_modal', function(editor) {
                        editor.on('Change', function() {
                            $("textarea#facility_desc_modal").val(editor.getContent())
                                .trigger(
                                    "change");
                        });
                    });
                    createBounced = false;
                },
            })
        }

        function rentDeleteModal(id) {
            @if ($rent !== null)
                if (createBounced) {
                    return;
                }
                createBounced = true;
                let returns = init_create_modal("rent/" + id, [{
                    title: ''
                }], [
                    `
                                <div>
                                    @method('DELETE')
                                    <input name="form_name" value='a' type="hidden">
                                    <input name="id_property" value="{{ $property->id_property }}" type="hidden">
                                    <input name="id_rent" value="{{ $rent->id_rent }}" type="hidden">
                                    <div class="flex flex-col gap-[15px] ">
                                        <div class="mt-3 w-full h-full min-w-[0px]">
                                            <x-input-label for="verification">Verification <a class="text-red-700">*</a></x-input-label>
                                            <x-text-input id="verification" style="" class="block mt-2 w-full h-full bg-gray-200" placeholder="Retype Rent Name to Confirm Delete"  type="text" name="verification"
                                                :value="old('verification')"  autofocus/>
                                        </div>
                                        <x-input-error :messages="$errors->get('verification')" class="mt-1" />
                                    </div>
                                </div>
                            `,
                ], {
                    1: ['verification'],
                }, {
                    hideStep: true,
                    lastButton: "Delete Rent",
                    onCreate: function(form) {

                        createBounced = false;
                    },
                })
            @endif
        }

        function previewFacility(data, disableEdit) {
            @if ($facilities !== null)
                if (createBounced) {
                    return;
                }
                let extended = `
                                    <x-uploadfile-v id="albumImage" name="facility_image" text="Upload or Drag Here (.jpg/.jpeg)"></x-uploadfile-v>
                                    
                `
                let readOnly = `false`;
                if (data.id_property === null) {
                    extended = "";
                    readOnly = "true";
                }
                createBounced = true;
                let returns = init_create_modal('facility/' + data.id_facility, [{
                    title: 'Facility Information'
                }], [
                    `
                            <div class="!flex flex-nowrap gap-[15px]">
                                <input name="form_name" value='a' type="hidden">
                                @method('PUT')
                                <div class="w-[400px]">
                                    <div class="flex justify-between gap-[15px] ">
                                        <div class="mt-3 w-full h-full min-w-[0px]">
                                            <x-input-label for="facility_name">Nama Fasilitas <a class="text-red-700">*</a></x-input-label>
                                            <x-text-input id="facility_name" style="" values="${data.facility_name}" class="block mt-2 w-full h-full bg-gray-200" placeholder="Nama Fasilitas"  type="text" name="facility_name"
                                                 autofocus/>
                                        </div>
                                        <x-input-error :messages="$errors->get('facility_name')" class="mt-1" />
                                        <div class="mt-3 w-full h-full min-w-[0px]">
                                            <x-input-label for="facility_type">Facility Type <a class="text-red-700">*</a></x-input-label>
                                            <x-text-input id="facility_type" style="" values="${data.facility_type}" class="block mt-2 w-full h-full bg-gray-200" placeholder="Tipe Fasilitas (Not case sencitive)"  type="text" name="facility_type"
                                                  autofocus/>
                                        </div>
                                        <x-input-error :messages="$errors->get('facility_type')" class="mt-1" />
                                        
                                    </div>
                                    <div class="mt-3 w-full min-w-[0px] ">
                                        <x-input-label for="facility_desc_modal">Facility Description <a class="text-red-700">*</a></x-input-label>
                                        <x-text-area id="facility_desc_modal" style="" class="block mt-2 w-full h-[150px] bg-gray-200" placeholder="Deskripsi Fasilitas"  type="text" name="facility_desc"
                                        autofocus>${data.facility_desc}</x-text-area>
                                    </div>
                                    <x-input-error :messages="$errors->get('facility_desc')" class="mt-1" />
                                </div>
                                <div style="background-image: url('/storage/${data.facility_image}'), url('{{ asset('img/placeholder.png') }}');" class="bg-contain bg-no-repeat rounded-2xl w-[235px]">
                                    <div class=" flex justify-center items-center w-full h-full min-h-[350px] flex-col gap-4 border-4 rounded-2xl border-dashed" id="property_upload_area">
                                        ${extended}
                                    </div>
                                    <x-input-error :messages="$errors->get('facility_image')" class="mt-1" />
                                </div>  
                            </div>
                        `,
                ], {
                    1: ['facility_name', 'facility_type', 'facility_desc'],
                }, {
                    hideStep: true,
                    disableContinue: disableEdit,
                    backAsClose: true,
                    backButton: 'Close',
                    lastButton: "Edit Facility",
                    readonly: ['facility_name', 'facility_type', 'facility_desc'],
                    onCreate: function(form) {
                        loadTinyMCE('textarea#facility_desc_modal', function(editor) {
                            editor.on('Change', function() {
                                $("textarea#facility_desc_modal").val(editor.getContent())
                                    .trigger(
                                        "change");
                            });
                        });
                        createBounced = false;
                    },
                })
            @endif
        }

        function handleCreate(createName) {
            if (createName === 'Rent') {
                createRent();
            } else if (createName === 'Facility') {
                createFacility();
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            function updateRentFacilityOrder() {
                let sortedData = $("#rentFacilityContainer").sortable("toArray", {
                    attribute: "data-id"
                }).map(id => {
                    let element = $(`[data-id="${id}"]`);
                    return {
                        id: element.data("ids"),
                        object: element
                    };
                });
                sortedData.forEach((data, index) => {
                    let id = data.id;
                    let order = index + 1;
                    changedData['rentFacilityOrder'][index] = {
                        activity: 'update',
                        id_rentfacility: parseInt(id),
                        item_order: order,
                        object: data.object,
                        original: {
                            item_order: data.object.attr('data-id')
                        }
                    };
                });
            }
            $("#rentFacilityContainer").sortable({
                handle: "[name='drag']",
                connectWith: "#rentFacilityContainer",
                placeholder: "ui-state-highlight",
            }).disableSelection();
            $("#rentFacilityContainer").sortable({
                stop: function(event, ui) {
                    if (ui.item.attr('data-id') === undefined) {
                        return;
                    }
                    updateRentFacilityOrder();
                    askSave(true);
                }
            });

            window.updateRentFacilityOrder = updateRentFacilityOrder;
        })
    </script>
    <style>
        .ui-state-highlight {
            height: 150px;
            background: #e0e0e0;
            border: 1px dashed #999;
            border-radius: 16px
        }
    </style>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ __('Rent Management') }}
        </h2>
    </x-slot>
    <div x-data="{ openedMenu: '@if (session('opened')){{ session('opened') }}@else{{ __('Rent') }}@endif' }" class="flex sticky top-0 flex-col gap-2 h-full">
        <div
            class=" h-full w-[300px]    dark:bg-[#18181B]  bg-[#f0f0f3] border-r-[1px] shadow-[rgba(0,0,15,0.1)_0px_0px_5px_0px] dark:border-[#272729] border-gray-200 rounded-l-xl pt-[30px] px-[0px] flex flex-col">
            <h3
                class=" px-[30px] flex justify-between items-center text-lg font-semibold text-gray-800  dark:text-gray-200">
                <x-a-label x-text="openedMenu"></x-a-label>
                <x-primary-button @click="handleCreate(openedMenu)" class="!rounded-full !p-[8px] !py-[5px]">
                    <div class="flex relative justify-center items-center w-full h-full">
                        <a class="text-sm">+ Add New</a>
                    </div>
                </x-primary-button>
            </h3>
            <div class="flex flex-col h-full">
                <div class="flex overflow-hidden mt-3 px-[15px] gap-[5px] flex-shrink-0">
                    <button @click="openedMenu = 'Rent'"
                        x-bind:class="openedMenu === 'Rent' ? 'dark:bg-[#27272a] bg-white dark:bg-opacity-30' :
                        'hover:dark:bg-[#27272a] hover:dark:bg-opacity-10 hover:bg-white hover:bg-opacity-30'"
                        class="w-full border-b-0 border-gray-200 p-[5px] rounded-xl rounded-b-none"><x-a-label>Rent</x-a-label></button>
                    <button @click="openedMenu = 'Facility'"
                        x-bind:class="openedMenu === 'Facility' ? 'dark:bg-[#27272a] bg-white dark:bg-opacity-30' :
                        'hover:dark:bg-[#27272a] hover:dark:bg-opacity-10 hover:bg-white hover:bg-opacity-30'"
                        class="w-full border-b-0 p-[5px] rounded-xl rounded-b-none"><x-a-label>Facility</x-a-label></button>
                </div>
                <div class="flex flex-col h-full rounded-t-xl rounded-bl-xl dark:bg-[#27272a] bg-white dark:bg-opacity-30">
                    <div x-show="openedMenu === 'Rent'" class="h-full p-[25px] flex flex-col gap-[10px] "
                        id="rentContainer">
                        <div class="flex gap-[10px]">
                            <x-search placeholder="Search" />
                            <button class="bg-transparent">
                                <x-icon.filter p=20 l=20 />
                            </button>
                            <button class="bg-transparent">
                                <x-icon.column p=20 l=20 />
                            </button>
                        </div>
                        <div class="flex flex-col gap-[10px] overflow-y-auto h-fit flex-1 flex-grow">
                            @foreach ($property->rent as $rents)
                                <a id="rent-{{ $rents->id_rent }}"
                                    href="{{ route('property.detail.rent.overview', ['id' => $property->id_property, 'id_rent' => $rents->id_rent]) }}">
                                    <div
                                        class="
                                        @if ($rent !== null) {{ $rents->id_rent === $rent->id_rent ? 'dark:bg-[#FAFAFA] dark:bg-opacity-10 bg-gray-100' : 'hover:bg-gray-100 hover:bg-opacity-50 dark:hover:bg-[#FAFAFA] dark:hover:bg-opacity-10' }}
                                        @else
                                            hover:bg-gray-100 hover:bg-opacity-50 dark:hover:bg-[#FAFAFA] dark:hover:bg-opacity-10 @endif
                                        rounded-lg p-[5px] px-[15px]">
                                        <p class="text-black dark:text-gray-300">{{ $rents->rent_name }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div x-show="openedMenu === 'Facility'"
                        class="h-full p-[25px] flex flex-col gap-[10px] flex-grow-0 flex-1 pb-[95px]" id="facilityContainer">
                        <div class="flex gap-[10px] ">
                            <x-search placeholder="Search" />
                            <button class="bg-transparent">
                                <x-icon.filter p=20 l=20 />
                            </button>
                            <button class="bg-transparent">
                                <x-icon.column p=20 l=20 />
                            </button>
                        </div>
                        <div class="flex flex-col gap-[10px] overflow-y-auto h-fit flex-1 flex-grow
                        [&::-webkit-scrollbar]:w-2
                                [&::-webkit-scrollbar-track]:rounded-full
                                [&::-webkit-scrollbar-thumb]:rounded-full
                                [&::-webkit-scrollbar-thumb]:bg-[#5E93DA]
                            ">
                            <x-nav-dropdown name="Own Facility">
                                <div class="px-[10px] py-0 flex gap-[10px] flex-col">
                                    @foreach ($facilities as $type => $items)
                                        @php
                                            $validItems = $items->filter(
                                                fn($facilit) => $facilit->id_property !== null,
                                            );
                                        @endphp
                                        @if ($validItems->isEmpty())
                                            @continue
                                        @endif
                                        <x-nav-dropdown :useBack=true name="{{ ucfirst($type) }}">
                                            <div class="p-[5px] py-0 flex gap-[5px] flex-col">
                                                @foreach ($validItems as $facilit)
                                                    @if ($facilit->id_property == null)
                                                        @continue
                                                    @endif
                                                    <div x-data="{ isHovered: false }" @mouseenter="isHovered = true"
                                                        @mouseleave="isHovered = false"
                                                        id="facility-{{ $facilit->id_facility }}"
                                                        class="
                                                        @if (!empty($facility)) {{ $facilit->id_facility === $facility->id_facility ? 'dark:bg-[#FAFAFA] dark:bg-opacity-10 bg-gray-100' : 'hover:bg-gray-100 hover:bg-opacity-50 dark:hover:bg-[#FAFAFA] dark:hover:bg-opacity-10' }}
                                                            @else
                                                                hover:bg-gray-100 hover:bg-opacity-50 dark:hover:bg-[#FAFAFA] dark:hover:bg-opacity-10 @endif
                                                            rounded-lg flex items-center text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 pr-[10px]"
                                                        {{-- href="{{ route('property.detail.facility.overview', ['id' => $property->id_property, 'id_rent' => $facilit->id_facility]) }}" --}}>
                                                        <button onclick="addFacility({{ $facilit->id_facility }})"
                                                            class="text-left  w-[90%]
                                                            p-[5px] px-[15px]">
                                                            <p class="">{{ $facilit->facility_name }}</p>

                                                        </button>
                                                        <div x-show="isHovered" class="flex">
                                                            <button
                                                                onclick='previewFacility(@json($facilit))'
                                                                class="bg-gray-200 m-auto p-[2px] dark:bg-[#242427] border-[1px] dark:border-[#464649] flex justify-center items-center rounded-xl cursor-pointer hover:bg-gray-100 dark:hover:bg-[#2F2F32]"
                                                                name="openFacility"><x-icon.set p="20"
                                                                    l="20" /></button>
                                                            <input name="id_facility"
                                                                value="{{ $facilit->id_facility }}" type="hidden">
                                                            <button
                                                                onclick="askConfirmation('facility/{{ $facilit->id_facility }}', 'DELETE', [], 'Are you sure you want to delete this facility?')"
                                                                class="bg-gray-200 m-auto p-[2px] dark:bg-[#242427] border-[1px] dark:border-[#464649] flex justify-center items-center rounded-xl cursor-pointer hover:bg-gray-100 dark:hover:bg-[#2F2F32]"
                                                                name="deleteFacility"><x-icon.delete p="20"
                                                                    l="20" /></button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </x-nav-dropdown>
                                    @endforeach
                                </div>
                            </x-nav-dropdown>
                            <x-nav-dropdown :open=false name="Public">
                                <div class="px-[10px] py-0 flex gap-[10px] flex-col">
                                    @foreach ($facilities as $type => $items)
                                        @php
                                            $validItems = $items->filter(fn($facilit) => $facilit->id_property == null);
                                        @endphp
                                        @if ($validItems->isEmpty())
                                            @continue
                                        @endif
                                        <x-nav-dropdown :useBack=true name="{{ ucfirst($type) }}">
                                            <div class="p-[5px] py-0 flex gap-[5px] flex-col">
                                                @foreach ($validItems as $facilit)
                                                    @if ($facilit->id_property !== null)
                                                        @continue
                                                    @endif
                                                    <div x-data="{ isHovered: false }" @mouseenter="isHovered = true"
                                                        @mouseleave="isHovered = false"
                                                        id="facility-{{ $facilit->id_facility }}"
                                                        class="
                                                        @if (!empty($facility)) {{ $facilit->id_facility === $facility->id_facility ? 'dark:bg-[#FAFAFA] dark:bg-opacity-10 bg-gray-100' : 'hover:bg-gray-100 hover:bg-opacity-50 dark:hover:bg-[#FAFAFA] dark:hover:bg-opacity-10' }}
                                                            @else
                                                                hover:bg-gray-100 hover:bg-opacity-50 dark:hover:bg-[#FAFAFA] dark:hover:bg-opacity-10 @endif
                                                            rounded-lg flex items-center text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 pr-[10px]"
                                                        {{-- href="{{ route('property.detail.facility.overview', ['id' => $property->id_property, 'id_rent' => $facilit->id_facility]) }}" --}}>
                                                        <button onclick="addFacility({{ $facilit->id_facility }})"
                                                            class="text-left  w-[90%]
                                                            p-[5px] px-[15px]">
                                                            <p class="">{{ $facilit->facility_name }}</p>

                                                        </button>
                                                        <div x-show="isHovered">
                                                            <button
                                                                onclick='previewFacility(@json($facilit), true)'
                                                                class="bg-gray-200 m-auto p-[2px] dark:bg-[#242427] border-[1px] dark:border-[#464649] flex justify-center items-center rounded-xl cursor-pointer hover:bg-gray-100 dark:hover:bg-[#2F2F32]"
                                                                name="openFacility"><x-icon.open p="20"
                                                                    l="20" /></button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </x-nav-dropdown>
                                    @endforeach
                                </div>
                            </x-nav-dropdown>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div x-data="{ openedRent: 'overview' }" class="p-[45px] py-[25px] w-full relative" id="overview">
        @if ($rent !== null)
            <div
                class="m-auto w-fit p-[10px] py-[8px] bg-white dark:bg-[#18181B] rounded-full shadow-lg h-auto border-gray-200 dark:border-[#272729] border-[1px]">
                <div class="flex gap-[10px]">
                    <button name="openOverview" @click="openedRent = 'overview'"
                        x-bind:class="openedRent === 'overview' ? 'bg-[#5E93DA]' : 'hover:bg-[#5E93DA] hover:bg-opacity-50'"
                        class="px-[10px] rounded-full"><x-a-label
                            x-bind:class="openedRent === 'overview' ? 'font-bold !text-white' : ''">Overview</x-a-label></button>
                    <button @click="openedRent = 'statistic'"
                        x-bind:class="openedRent === 'statistic' ? 'bg-[#5E93DA]' : 'hover:bg-[#5E93DA] hover:bg-opacity-50'"
                        class="px-[10px] rounded-full "><x-a-label
                            x-bind:class="openedRent === 'statistic' ? 'font-bold !text-white' : ''">Statistic</x-a-label></button>
                    <button @click="openedRent = 'guest'"
                        x-bind:class="openedRent === 'guest' ? 'bg-[#5E93DA]' : 'hover:bg-[#5E93DA] hover:bg-opacity-50'"
                        class="px-[10px] rounded-full "><x-a-label
                            x-bind:class="openedRent === 'guest' ? 'font-bold !text-white' : ''">Guest</x-a-label></button>
                </div>
            </div>
            <div
                class="flex overflow-hidden justify-center items-center absolute right-10 top-[25px] w-auto h-auto">
                <button id="deleteTenant" onclick="rentDeleteModal({{ $rent->id_rent }})"
                    class="w-auto h-auto px-[5px] text-sm font-bold text-white bg-red-500 rounded-xl shadow-lg hover:bg-red-600">
                    <div class="flex justify-center items-center w-auto h-auto p-[10px]">
                        <span class="">Delete</span>
                    </div>
                </button>
            </div>
            <div x-show="openedRent === 'overview'" class="mt-6 flex gap-[35px] pb-[25px]">
                <div class="flex gap-[30px] flex-col w-full">
                    <x-box-dropdown name="Rent Information" :open=true>
                        <x-slot:extended>
                            <a class="bg-[#5E93DA] ml-2 py-[1px] text-sm px-[10px] text-white w-auto rounded-lg">ID: {{ $rent->id_rent }}</a>
                        </x-slot:extended>
                        <div class="flex justify-between gap-[15px] ">
                            <div class="w-full h-full min-w-[0px]">
                                <x-input-label for="rent_name">Rent Name <a
                                        class="text-red-700">*</a></x-input-label>
                                <x-text-input id="rent_name" values="{{ $rent->rent_name }}"
                                    class="block mt-2 w-full h-full bg-gray-200" placeholder="Nama Rent"
                                    type="text" name="rent_name" :value="old('rent_name')" autofocus />
                            </div>
                            <x-input-error :messages="$errors->get('rent_name')" class="mt-1" />
                            <div class="w-full h-full min-w-[0px]">
                                <x-input-label for="stock">Stock <a class="text-red-700">*</a></x-input-label>
                                <x-text-input id="stock" values="{{ $rent->stock }}"
                                    class="block mt-2 w-full h-full bg-gray-200" placeholder="Stock"
                                    type="number" name="stock" :value="old('stock')" autofocus />
                            </div>
                            <x-input-error :messages="$errors->get('stock')" class="mt-1" />
                            <div class="w-full h-full min-w-[0px]">
                                <x-input-label for="price">Price <a class="text-red-700">*</a></x-input-label>
                                <x-custom-input id="price" values="{{ $rent->rent_price }}"
                                    class="!pr-[0px]" placeholder="Price"
                                    type="number" name="rent_price" :value="old('rent_price')" autofocus>Rp.
                                    </x-custom-input>
                            </div>
                            <x-input-error :messages="$errors->get('price')" class="mt-1" />
                        </div>
                        <script>
                            addFunctionToTheme('overview', function() {
                                loadTinyMCE('textarea#rent_desc', function(editor) {
                                    editor.on('Change', function() {
                                        $("#overview").find("textarea#rent_desc").val(editor.getContent()).trigger(
                                            "change");
                                    });
                                });
                            });
                        </script>
                        <div class="mt-3 w-full min-w-[0px] ">
                            <x-input-label for="rent_desc">Rent Description <a
                                    class="text-red-700">*</a></x-input-label>
                            <x-text-area id="rent_desc" style=""
                                class="block mt-2 w-full h-[150px] bg-gray-200" placeholder="Deskripsi Rent"
                                type="text" name="rent_desc" autofocus>{{ $rent->rent_desc }}</x-text-area>
                        </div>
                        <x-input-error :messages="$errors->get('rent_description')" class="mt-1" />
                    </x-box-dropdown>
                    <x-box-dropdown name="Rent Albums" open="<?php echo Session::has('success-rentalbum'); ?>">
                        <x-slot:extended>
                            <x-a-label class='text-xs'> (hover the album to show action)</x-a-label>
                        </x-slot:extended>
                        <div class="w-full">
                            <form id="formRentAlbum">
                                <input name="id" value="{{ $rent->id_rent }}" type="hidden">
                                <div class="flex justify-center items-center w-full h-auto min-h-[50px] py-[25px] flex-col gap-4 border-4 rounded-2xl border-dashed"
                                    id="property_upload_area">
                                    <x-uploadfile id="albumImage" name="album" :hide_filename=true
                                        :hide_preview=true text="Upload or Drag Here (.jpg/.jpeg)" />
                                </div>
                                <x-input-error :messages="$errors->get('album')" class="mt-1" />
                            </form>
                        </div>
                        <div class="flex gap-[10px] flex-wrap mt-4 max-h-[200px] overflow-y-auto"
                            id="rentAlbumContainer">
                            <div id="rentAlbumDummy" class="hidden">
                                <div class="relative bg-cover rounded-lg w-[100px] h-[100px]" name="albumImage">
                                    <div
                                        class="w-full h-full p-[10px] rounded-lg bg-black bg-opacity-30 opacity-0 hover:opacity-100 flex justify-end">
                                        <button
                                            class="bg-gray-200 m-auto p-[5px] dark:bg-[#242427] border-[1px] dark:border-[#464649] flex justify-center items-center rounded-xl cursor-pointer hover:bg-gray-100 dark:hover:bg-[#2F2F32]"
                                            name="setRentCover"><x-icon.set p="20" l="20" /></button>
                                        <button
                                            class="bg-gray-200 m-auto p-[5px] dark:bg-[#242427] border-[1px] dark:border-[#464649] flex justify-center items-center rounded-xl cursor-pointer hover:bg-gray-100 dark:hover:bg-[#2F2F32]"
                                            name="deleteAlbum"><x-icon.delete p="20" l="20" /></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-box-dropdown>
                    <x-box-dropdown name="Rent Facilities">
                        <x-slot:extended>
                            <x-a-label class='text-xs'> (or click from facility tab)</x-a-label>
                        </x-slot:extended>
                        <x-card.facility-item class="hidden item" id="facility-item-dummy">
                            @foreach ($facilities as $type => $items)
                                @foreach ($items as $facilit)
                                    <option value="{{ $facilit->id_facility }}">
                                        {{ $facilit->facility_name }}</option>
                                @endforeach
                            @endforeach
                        </x-card.facility-item>
                        <div class="flex flex-col gap-[20px]" id="rentFacilityContainer">

                        </div>
                        <br>
                        <button
                            class="m-auto p-2 dark:bg-[#242427] border-[1px] dark:border-[#464649] flex justify-center items-center rounded-xl cursor-pointer hover:bg-gray-100 dark:hover:bg-[#2F2F32]"
                            id="addFacility">
                            <x-a-label class="text-sm font-bold">Add to Facility</x-a-label>
                        </button>
                    </x-box-dropdown>
                </div>
                <div class="w-[400px] flex gap-[30px] flex-col">
                    <x-box-dropdown name="Rent Cover" :open=true>
                        <x-slot:extended>
                            <x-a-label class='text-xs'> (from albums)</x-a-label>
                        </x-slot:extended>
                        <img id="rentCover"
                            src="
                        @if ($rent->id_cover !== null && $rent->album !== null) {{ asset('storage/' . $rent->album->imagePath) }} @endif
                        "
                            class="object-cover rounded-xl"
                            onerror="this.src='{{ asset('img/placeholder.png') }}'" width=100% height=100%>

                    </x-box-dropdown>
                    <x-box-dropdown name="Availability" :open=true :disableDropdown=true>
                        <div class="flex flex-col gap-[15px]">
                            <x-card.choose-item class="w-full h-[35px]"
                                additionalClass="!flex-row justify-between px-[20px] py-[5px]" id="private"
                                name="availability" value="0" :checked="$rent->availability === 0">
                                <x-icon.private p="25" l="25" />
                                <x-a-label for="private" class="text-sm font-bold">Private</x-a-label>
                            </x-card.choose-item>
                            <x-card.choose-item class="w-full h-[35px]"
                                additionalClass="!flex-row justify-between px-[20px] py-[5px]" id="public"
                                name="availability" value="1" :checked="$rent->availability === 1">
                                <x-icon.public p="25" l="25" />
                                <x-a-label for="public" class="text-sm font-bold">Public</x-a-label>
                            </x-card.choose-item>
                        </div>
                    </x-box-dropdown>
                    <x-box-dropdown name="Tags" :open=false>
                        <x-slot:extended>
                            <x-a-label class='text-xs'> (click to remove)</x-a-label>
                        </x-slot:extended>
                        <div class="flex gap-[5px]">
                            <x-search id="renttagbox" placeholder="Add Tags"><x-slot:extended>
                                    <x-icon.tag p="20" l="20" />
                                </x-slot:extended>
                            </x-search>
                            <x-primary-button id="addrenttag" class="!w-[36px] !p-1 !h-[36px]"><x-icon.add p="20"
                                    l="20" /></x-primary-button>
                        </div>
                        <div id="renttagContainer"
                            class="hidden has-[:not(.hidden)]:flex gap-[6px] mt-4 flex-wrap">
                            <a class="bg-[#5E93DA] py-[1px] text-sm px-[10px] text-white w-auto rounded-lg hidden cursor-pointer"
                                id="renttagDummy"></a>
                        </div>
                    </x-box-dropdown>
                    <x-box-dropdown name="History" :open=true>
                        <x-a-label>Created At</x-a-label><br>
                        <x-a-label class="text-xs">{{ $rent->created_at }}</x-a-label><br><br>
                        <x-a-label>Updated At</x-a-label><br>
                        <x-a-label class="text-xs">{{ $rent->updated_at }}</x-a-label>
                    </x-box-dropdown>

                </div>
            </div>
            <div x-show="openedRent === 'statistic'" class="mt-6 flex gap-[35px]">

            </div>
            <div x-show="openedRent === 'guest'" class="mt-6 flex gap-[35px]">
                <x-card.list-item id="guest-list" />
            </div>
        @endif

    </div>
    {{-- <x-rentNavigation/> --}}
</x-app-layout>
