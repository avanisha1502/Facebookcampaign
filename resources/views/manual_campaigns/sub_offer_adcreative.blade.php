@extends('admin.home')

@section('contents')
    <div class="d-flex align-items-center mb-3">
        <div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{ __('PAGES') }}</a></li>
                <li class="breadcrumb-item active"><a
                        href="{{ route('suboffer.index', $subOffer->offer_id) }}">{{ __('Sub Offer') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Sub Offer Ads Creatives') }}</li>
                <li class="breadcrumb-item active">{{ $subOffer->offer_sub_campaign_name }}</li>
            </ul>
        </div>
    </div>

    <div class="row gx-4">
        {{-- <form class="card repeater" id="content-form-{{ $subOffer->id }}" enctype="multipart/form-data">
            @csrf
            <div class="item-section py-2">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
                        <div class="all-button-box me-2">
                            <a href="#" data-repeater-create="" class="btn btn-primary">
                                <i class="ti ti-plus"></i> Add item
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-sm mb-0">
                <thead>
                    <tr>
                        <th scope="col">{{ __('Campaign Name') }}</th>
                        <th scope="col">{{ __('Upload Image/Video') }}</th>
                        <th scope="col">{{ __('Offer URL') }}</th>
                        <th scope="col">{{ __('Headline') }}</th>
                        <th scope="col">{{ __('Primary Text') }}</th>
                        <th scope="col">{{ __('Description') }}</th>
                        <th scope="col">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody data-repeater-list="group-a">
                    @foreach ($SubOfferads as $subOffers)
                        <tr data-repeater-item data-item-id="{{ $subOffers->id }}">
                            <td>
                                <input type="text" name="campaign_name" class="form-control campaign-name"
                                    value="{{ $subOffers->campaign_name ?? '' }}" />
                            </td>
                            <td>
                                <input type="file" class="form-control" name="files" multiple>
                                <div class="preview-area d-flex g-10"></div>
                            </td>
                            <td>
                                <textarea name="offerurl" class="form-control">{{ $subOffers->sub_offer_ad_craetive_offer_url ?? '' }}</textarea>
                            </td>
                            <td>
                                <textarea name="headline" class="form-control">{{ $subOffers->sub_offer_ad_craetive_headlines ?? '' }}</textarea>
                            </td>
                            <td>
                                <textarea name="primary_text" class="form-control">{{ $subOffers->sub_offer_ad_craetive_primary_text ?? '' }}</textarea>
                            </td>
                            <td>
                                <textarea name="description" class="form-control">{{ $subOffers->sub_offer_ad_craetive_description ?? '' }}</textarea>
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-warning me-2 text-white generate-button"
                                    data-campaign-id="{{ $subOffers->id }}">
                                    <i class="fa-solid fa-audio-description"></i> {{ __('Regenerate Content') }}
                                </a>
                                <div id="loader-{{ $subOffers->id }}"
                                    class="loader buttonload btn btn-primary me-2 hidden mb-2">
                                    <i class="fa fa-spinner fa-spin mr-2"></i>
                                    {{ __('Wait its generating....') }}
                                </div>

                                <!-- Conditionally display the Save or Update button -->
                                <a href="#"
                                    class="btn btn-lime update-button text-white {{ isset($subOffers->id) ? '' : 'd-none' }}"
                                    data-id="{{ $subOffers->id }}">
                                    <i class="ti ti-save"></i> {{ __('Update') }}
                                </a>

                                <a href="#"
                                    class="btn btn-teal save-button text-white {{ isset($subOffers->id) ? 'd-none' : '' }}">
                                    <i class="ti ti-save"></i> {{ __('Save') }}
                                </a>

                                <a href="javascript:void(0);" data-repeater-delete class="btn btn-danger">
                                    <i class="ti ti-trash"></i> {{ __('Remove') }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form> --}}
        {{-- <form class="card repeater" id="content-form-{{ $subOffer->id }}" enctype="multipart/form-data">
            @csrf
            <div class="item-section py-2">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
                        <div class="all-button-box me-2">
                            <a href="#" data-repeater-create="" class="btn btn-primary">
                                <i class="ti ti-plus"></i> Add item
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-sm mb-0">
                <thead>
                    <tr>
                        <th scope="col">{{ __('Campaign Name') }}</th>
                        <th scope="col">{{ __('Upload Image/Video') }}</th>
                        <th scope="col">{{ __('Offer URL') }}</th>
                        <th scope="col">{{ __('Headline') }}</th>
                        <th scope="col">{{ __('Primary Text') }}</th>
                        <th scope="col">{{ __('Description') }}</th>
                        <th scope="col">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody data-repeater-list="group-a">
                    @if ($SubOfferads && count($SubOfferads) > 0)
                        @foreach ($SubOfferads as $subOffers)
                            <tr data-repeater-item data-item-id="{{ $subOffers->id }}">
                                <td>
                                    <input type="text" name="campaign_name" class="form-control campaign-name"
                                        value="{{ $subOffers->campaign_name ?? '' }}" />
                                </td>
                                <td>
                                    <input type="file" class="form-control" name="files" multiple>
                                    <div class="preview-area d-flex g-10"></div>
                                </td>
                                <td>
                                    <textarea name="offerurl" class="form-control">{{ $subOffers->sub_offer_ad_craetive_offer_url ?? '' }}</textarea>
                                </td>
                                <td>
                                    <textarea name="headline" class="form-control">{{ $subOffers->sub_offer_ad_craetive_headlines ?? '' }}</textarea>
                                </td>
                                <td>
                                    <textarea name="primary_text" class="form-control">{{ $subOffers->sub_offer_ad_craetive_primary_text ?? '' }}</textarea>
                                </td>
                                <td>
                                    <textarea name="description" class="form-control">{{ $subOffers->sub_offer_ad_craetive_description ?? '' }}</textarea>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" class="btn btn-warning me-2 text-white generate-button"
                                        data-campaign-id="{{ $subOffers->id }}">
                                        <i class="fa-solid fa-audio-description"></i> {{ __('Regenerate Content') }}
                                    </a>
                                    <div id="loader-{{ $subOffers->id }}"
                                        class="loader buttonload btn btn-primary me-2 hidden mb-2">
                                        <i class="fa fa-spinner fa-spin mr-2"></i>
                                        {{ __('Wait....') }}
                                    </div>

                                    <a href="#"
                                        class="btn btn-lime update-button text-white {{ isset($subOffers->id) ? '' : 'd-none' }}"
                                        data-id="{{ $subOffers->id }}">
                                        <i class="ti ti-save"></i> {{ __('Update') }}
                                    </a>

                                    <a href="#"
                                        class="btn btn-teal save-button text-white {{ isset($subOffers->id) ? 'd-none' : '' }}">
                                        <i class="ti ti-save"></i> {{ __('Save') }}
                                    </a>
                                    <a href="javascript:void(0);" data-repeater-delete class="btn btn-danger">
                                        <i class="ti ti-trash"></i> {{ __('Remove') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <!-- Render an empty repeater item when there are no existing sub-offers -->
                        <tr data-repeater-item>
                            <td>
                                <input type="text" name="campaign_name" class="form-control campaign-name"
                                    value="" />
                            </td>
                            <td>
                                <input type="file" class="form-control" name="files" multiple>
                                <div class="preview-area d-flex g-10"></div>
                            </td>
                            <td>
                                <textarea name="offerurl" class="form-control"></textarea>
                            </td>
                            <td>
                                <textarea name="headline" class="form-control"></textarea>
                            </td>
                            <td>
                                <textarea name="primary_text" class="form-control"></textarea>
                            </td>
                            <td>
                                <textarea name="description" class="form-control"></textarea>
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-warning me-2 text-white generate-button"
                                    data-campaign-id="{{ $subOffer->id }}">
                                    <i class="fa-solid fa-audio-description"></i> {{ __('Regenerate Content') }}
                                </a>

                                <a href="#"
                                    class="btn btn-teal save-button text-white {{ isset($subOffers->id) ? 'd-none' : '' }}">
                                    <i class="ti ti-save"></i> {{ __('Save') }}
                                </a>
                                <a href="javascript:void(0)" class="btn btn-danger" data-repeater-delete>
                                    <i class="ti ti-trash"></i> {{ __('Remove') }}
                                </a>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </form> --}}

        <form class="repeater" id="content-form-{{ $subOffer->id }}" enctype="multipart/form-data">
            @csrf
            <div class="item-section py-2">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-12 d-flex align-items-center justify-content-between justify-content-md-end">
                        <div class="all-button-box me-2">
                            <a href="#" id="add-row" class="btn btn-primary">
                                <i class="ti ti-plus"></i> Add item
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="excel-view-wrapper" style="overflow-x: auto; max-width: 100%;">
                <div id="excel-view"></div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Getting the offer sub campaign name from PHP
        const offerSubCampaignName = "{{ $subOffer->offer_sub_campaign_name }}";
        let hot;
        let filePreviewData = {};
        let fileStorage = {};

        // Function to format today's date as YYYY-MM-DD
        // function getTodayDate() {
        //     const today = new Date();
        //     const year = today.getFullYear();
        //     const month = String(today.getMonth() + 1).padStart(2, '0');
        //     const day = String(today.getDate()).padStart(2, '0');
        //     return `${year}-${month}-${day}`;
        // }

        // // Function to set campaign name with today's date if the input is empty
        // function setCampaignName(input) {
        //     if (!input.value) {
        //         input.value = `${offerSubCampaignName} - ${getTodayDate()}`;
        //     }
        // }

        // Adding event listener to repeater create buttons
        document.querySelectorAll('[data-repeater-create]').forEach(button => {
            button.addEventListener('click', function() {
                // Using setTimeout to ensure the new repeater row is fully added before targeting it
                setTimeout(() => {
                    // Find the last repeater row added
                    const repeaterRows = document.querySelectorAll(
                        '.repeater-row'); // Adjust the selector to match your repeater rows
                    const lastRow = repeaterRows[repeaterRows.length - 1]; // Get the last added row

                    // Check if the new row contains an input field for the campaign name
                    if (lastRow) {
                        const newInput = lastRow.querySelector(
                            '.campaign-name'); // Adjust to target the input correctly
                        if (newInput) {
                            setCampaignName(newInput); // Setting campaign name for the new input
                        }
                    }
                }, 100); // Adding a slight delay for row insertion
            });
        });


        // Event listener for adding a new repeater item dynamically
        // document.querySelectorAll('[data-repeater-create]').forEach(button => {
        //     button.addEventListener('click', function() {
        //         setTimeout(() => {
        //             document.querySelectorAll('.campaign-name').forEach(input => {
        //                 setCampaignName(input);
        //             });
        //         }, 100); // Adding a small delay to ensure the new row is fully added
        //     });
        // });
        // $(document).ready(function() {
        //     $(document).on('click', '[data-repeater-create]', function(e) {
        //         e.preventDefault();
        //         let repeaterList = $(this).closest('form').find('[data-repeater-list]');
        //         let newItem = repeaterList.find('tr').last();
        //         newItem.find('.save-button').removeClass('d-none'); // Show Save button for new item
        //         newItem.find('.update-button').addClass('d-none'); // Hide Update button for new item
        //     });
        // });

        // document.addEventListener('click', function(event) {
        //     // Save button logic
        //     if (event.target.closest('.save-button')) {
        //         event.preventDefault();
        //         handleFormSubmit(event, 'save');
        //     }

        //     // Update button logic
        //     if (event.target.closest('.update-button')) {
        //         event.preventDefault();
        //         handleFormSubmit(event, 'update');
        //     }


        //     function handleFormSubmit(event, action, rowIndex) {
        //         event.preventDefault();

        //         const formData = new FormData();
        //         const row = hot.getDataAtRow(rowIndex);

        //         formData.append('campaign_name', row[1] || '');
        //         formData.append('offerurl', row[3] || '');
        //         formData.append('headline', row[4] || '');
        //         formData.append('primary_text', row[5] || '');
        //         formData.append('description', row[6] || '');

        //         const fileKey = `${rowIndex}-2`;
        //         if (fileStorage[fileKey]) {
        //             fileStorage[fileKey].forEach(file => {
        //                 formData.append('files[]', file);
        //             });
        //         }

        //         formData.append('offer_id', '{{ $subOffer->id }}');
        //         formData.append('main_offer_id', '{{ $subOffer->offer_id }}');

        //         let url = action === 'save' ? '{{ route('save.repeater.data') }}' :
        //             '{{ route('update.repeater.data') }}';
        //         if (action === 'update') {
        //             const subOfferId = row[0];
        //             formData.append('sub_offer_id', subOfferId);
        //         }

        //         const td = event.target.closest('td');
        //         const loader = td.querySelector('.loader');
        //         const saveButton = td.querySelector('.save-button');
        //         const updateButton = td.querySelector('.update-button');

        //         if (loader) loader.classList.remove('hidden');
        //         if (saveButton) saveButton.setAttribute('disabled', true);
        //         if (updateButton) updateButton.setAttribute('disabled', true);

        //         fetch(url, {
        //                 method: 'POST',
        //                 body: formData,
        //                 headers: {
        //                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
        //                         'content')
        //                 }
        //             })
        //             .then(response => response.json())
        //             .then(data => {
        //                 if (loader) loader.classList.add('hidden');
        //                 if (saveButton) saveButton.removeAttribute('disabled');
        //                 if (updateButton) updateButton.removeAttribute('disabled');

        //                 if (data.success) {
        //                     show_toastr('Success', action === 'save' ?
        //                         'Sub Offer Ad Creatives added successfully' :
        //                         'Sub Offer Ad Creatives updated successfully', 'success');

        //                     if (action === 'save') {
        //                         if (saveButton) saveButton.classList.add('d-none');
        //                         if (updateButton) {
        //                             updateButton.classList.remove('d-none');
        //                             updateButton.setAttribute('data-id', data.sub_offer_id);
        //                         }
        //                         // Update the record ID in the Handsontable data
        //                         hot.setDataAtCell(rowIndex, 0, data.sub_offer_id);
        //                     }
        //                 } else {
        //                     alert('Error saving data: ' + (data.message || 'Unknown error'));
        //                 }
        //             })
        //             .catch(error => {
        //                 if (loader) loader.classList.add('hidden');
        //                 if (saveButton) saveButton.removeAttribute('disabled');
        //                 if (updateButton) updateButton.removeAttribute('disabled');
        //                 console.error('Error:', error);
        //                 alert('Error saving data: ' + error.message);
        //             });
        //     }

        // function handleFormSubmit(event, action) {
        //     let row = event.target.closest('tr');

        //     if (!row) {
        //         alert('Could not find the row for this button.');
        //         return;
        //     }

        //     // Create a new FormData object
        //     let formData = new FormData();
        //     console.log(formData);

        //     // Extract data from each cell
        //     let cells = row.querySelectorAll('td');
        //     cells.forEach((cell, index) => {
        //         // Get file data from fileStorage if available
        //         const fileKey = `${row.rowIndex}-${index}`;
        //         if (fileStorage[fileKey]) {
        //             fileStorage[fileKey].forEach(fileData => {
        //                 formData.append('files[]', fileData.file);
        //             });
        //         } else {
        //             // Handle non-file input fields (e.g., text inputs, textareas)
        //             let field = cell.querySelector('input, textarea');
        //             if (field) {
        //                 formData.append(`field${index}`, field.value.trim());
        //             }
        //         }
        //     });

        //     // Append other necessary form fields (you can add more as needed)
        //     formData.append('offer_id', '{{ $subOffer->id }}');
        //     formData.append('main_offer_id', '{{ $subOffer->offer_id }}');

        //     // Determine the URL for save or update
        //     let url = action === 'save' ? '{{ route('save.repeater.data') }}' :
        //         '{{ route('update.repeater.data') }}';

        //     if (action === 'update') {
        //         const subOfferId = event.target.getAttribute('data-id');
        //         formData.append('sub_offer_id', subOfferId);
        //     }

        //     // Send the form data using Fetch API
        //     fetch(url, {
        //             method: 'POST',
        //             body: formData,
        //             headers: {
        //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
        //                     'content')
        //             }
        //         })
        //         .then(response => response.json())
        //         .then(data => {
        //             if (data.success) {
        //                 // Show success notification
        //                 show_toastr('Success', action === 'save' ?
        //                     'Sub Offer Ad Creatives added successfully' :
        //                     'Sub Offer Ad Creatives updated successfully', 'success');
        //             } else {
        //                 alert('Error saving data: ' + (data.message || 'Unknown error'));
        //             }
        //         })
        //         .catch(error => {
        //             console.error('Error:', error);
        //             alert('Error saving data: ' + error.message);
        //         });
        // }
        document.addEventListener('click', function(event) {
            // Save button logic
            if (event.target.closest('.save-button')) {
                event.preventDefault();
                const row = event.target.closest('tr');
                const rowIndex = row ? row.rowIndex - 1 : -1; // Adjust if there's a header row
                handleFormSubmit(event, 'save', rowIndex);
            }

            // Update button logic
            if (event.target.closest('.update-button')) {
                event.preventDefault();
                const row = event.target.closest('tr');
                const rowIndex = row ? row.rowIndex - 1 : -1; // Adjust if there's a header row
                handleFormSubmit(event, 'update', rowIndex);
            }
        });

        function handleFormSubmit(event, action, rowIndex) {
            event.preventDefault();

            const formData = new FormData();
            const row = document.querySelectorAll('table tr')[rowIndex + 1]; // +1 if there's a header row

            if (!row) {
                console.error('Row not found');
                return;
            }

            const cells = row.querySelectorAll('td');

            formData.append('campaign_name', cells[1]?.textContent || '');
            formData.append('offerurl', cells[3]?.textContent || '');
            formData.append('headline', cells[4]?.textContent || '');
            formData.append('primary_text', cells[5]?.textContent || '');
            formData.append('description', cells[6]?.textContent || '');

            const fileKey = `${rowIndex}-2`;
            if (fileStorage[fileKey]) {
                fileStorage[fileKey].forEach(file => {
                    formData.append('files[]', file);
                });
            }

            formData.append('offer_id', '{{ $subOffer->id }}');
            formData.append('main_offer_id', '{{ $subOffer->offer_id }}');

            let url = action === 'save' ? '{{ route('save.repeater.data') }}' :
                '{{ route('update.repeater.data') }}';
            if (action === 'update') {
                const subOfferId = cells[0]?.textContent;
                formData.append('sub_offer_id', subOfferId);
            }

            const td = event.target.closest('td');
            const loader = td.querySelector('.loader');
            const saveButton = td.querySelector('.save-button');
            const updateButton = td.querySelector('.update-button');

            if (loader) loader.classList.remove('hidden');
            if (saveButton) {
                saveButton.setAttribute('disabled', true);
                saveButton.classList.add('hidden');
                // updateButton.classList.remove('d-none');
            }
            if (updateButton) updateButton.setAttribute('disabled', true);

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (loader) loader.classList.add('hidden');
                    if (saveButton) {
                        saveButton.removeAttribute('disabled');
                        saveButton.classList.add('hidden');
                        // updateButton.classList.remove('d-none');
                    }
                    if (updateButton) updateButton.removeAttribute('disabled');

                    if (data.success) {
                        show_toastr('Success', action === 'save' ?
                            'Sub Offer Ad Creatives added successfully' :
                            'Sub Offer Ad Creatives updated successfully', 'success');

                        if (action === 'save') {
                            if (saveButton) {
                                saveButton.classList.add('hidden');
                                saveButton.removeAttribute('disabled');
                                updateButton.classList.remove('d-none');
                            }
                            if (updateButton) {
                                updateButton.classList.remove('d-none');
                                updateButton.setAttribute('data-id', data.sub_offer_id);
                            }
                            // Update the record ID in the table
                            cells[0].textContent = data.sub_offer_id;
                        }
                    } else {
                        alert('Error saving data: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    if (loader) loader.classList.add('hidden');
                    if (saveButton) saveButton.removeAttribute('disabled');
                    if (updateButton) updateButton.removeAttribute('disabled');
                    console.error('Error:', error);
                    alert('Error saving data: ' + error.message);
                });
        }

        $(document).ready(function() {
            $('.repeater').repeater({
                initEmpty: false,
                defaultValues: {
                    'campaign_name': '',
                    'headline': '',
                    'primary_text': '',
                    'description': ''
                },
                show: function() {
                    $(this).slideDown();
                },
                // hide: function(deleteElement) {
                //     if (confirm('Are you sure you want to delete this item?')) {
                //         $(this).slideUp(deleteElement);
                //     }
                // },
                hide: function(deleteElement) {
                    // Get the ID of the element to delete
                    let row = $(this);
                    let subOfferId = row.attr(
                        'data-item-id'); // Assuming the ID is stored in a data attribute

                    // Use SweetAlert for delete confirmation
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'Do you want to delete this item? This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (subOfferId) {
                                // Send AJAX request to delete the record from the database
                                fetch('{{ route('delete.repeater.data') }}', {
                                        method: 'POST',
                                        body: JSON.stringify({
                                            sub_offer_id: subOfferId
                                        }),
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]').getAttribute(
                                                'content')
                                        }
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            // If successful, remove the item from the DOM
                                            row.slideUp(deleteElement, function() {
                                                $(this).remove(); // Remove the row
                                            });
                                            show_toastr('Success',
                                                'Item has been deleted successfully',
                                                'success'
                                            ); // Call your toaster function here
                                            // Swal.fire(
                                            //     'Deleted!',
                                            //     'The item has been deleted.',
                                            //     'success'
                                            // );
                                        } else {
                                            Swal.fire(
                                                'Error!',
                                                'Error deleting data: ' + (data
                                                    .message || 'Unknown error'),
                                                'error'
                                            );
                                        }
                                    })
                                    .catch(error => {
                                        Swal.fire(
                                            'Error!',
                                            'Error deleting data: ' + error.message,
                                            'error'
                                        );
                                    });
                            } else {
                                // If no ID (new item), just remove the row
                                row.slideUp(deleteElement, function() {
                                    $(this).remove(); // Remove the item from the DOM
                                });
                                show_toastr('Success', 'Item has been deleted successfully',
                                    'success'); // Call your toaster function here
                                // Swal.fire(
                                //     'Deleted!',
                                //     'The item has been deleted.',
                                //     'success'
                                // );
                            }
                        }
                    });
                },
                ready: function(setIndexes) {
                    // Callback for setting indexes when the form is loaded
                }
            });
        });


        // document.addEventListener('click', function(event) {
        //     // Save button logic
        //     if (event.target.closest('.save-button')) {
        //         event.preventDefault();
        //         handleFormSubmit(event, 'save');
        //     }

        //     // Update button logic
        //     if (event.target.closest('.update-button')) {
        //         event.preventDefault();
        //         handleFormSubmit(event, 'update');
        //     }

        //     function handleFormSubmit(event, action) {
        //         let row = event.target.closest('tr[data-repeater-item]');
        //         if (!row) {
        //             alert('Could not find the row for this button.');
        //             return;
        //         }

        //         const rowIndex = Array.from(row.closest('tbody').children).indexOf(row);
        //         let formData = new FormData();

        //         // Get form fields
        //         const campaignName = row.querySelector(`input[name="group-a[${rowIndex}][campaign_name]"]`);
        //         const imageInput = row.querySelector(`input[name="group-a[${rowIndex}][files][]"]`);
        //         const offerUrlField = row.querySelector(`textarea[name="group-a[${rowIndex}][offerurl]"]`);
        //         const headlineField = row.querySelector(`textarea[name="group-a[${rowIndex}][headline]"]`);
        //         const primaryTextField = row.querySelector(`textarea[name="group-a[${rowIndex}][primary_text]"]`);
        //         const descriptionField = row.querySelector(`textarea[name="group-a[${rowIndex}][description]"]`);

        //         // Flattened keys for form data
        //         if (campaignName) formData.append(`campaign_name`, campaignName.value);
        //         if (headlineField) formData.append(`headline`, headlineField.value);
        //         if (primaryTextField) formData.append(`primary_text`, primaryTextField.value);
        //         if (descriptionField) formData.append(`description`, descriptionField.value);
        //         if (offerUrlField) formData.append(`offerurl`, offerUrlField.value);

        //         // Handle the file input properly
        //         if (imageInput && imageInput.files.length > 0) {
        //             for (let i = 0; i < imageInput.files.length; i++) {
        //                 formData.append(`files[]`, imageInput.files[i]);
        //             }
        //         }

        //         formData.append('offer_id', '{{ $subOffer->id }}');
        //         formData.append('main_offer_id', '{{ $subOffer->offer_id }}');

        //         let url = action === 'save' ? '{{ route('save.repeater.data') }}' :
        //             '{{ route('update.repeater.data') }}';
        //         if (action === 'update') {
        //             const subOfferId = event.target.getAttribute('data-id');
        //             formData.append('sub_offer_id', '{{ $subOffer->id }}');
        //             formData.append('sub_offer_id', subOfferId);
        //         }

        //         // Show loader while processing
        //         const loader = row.querySelector('.loader');
        //         if (loader) loader.classList.remove('hidden');

        //         // Send the form data via fetch
        //         fetch(url, {
        //                 method: 'POST',
        //                 body: formData,
        //                 headers: {
        //                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
        //                         'content')
        //                 }
        //             })
        //             .then(response => response.json())
        //             .then(data => {
        //                 if (loader) loader.classList.add('hidden'); // Hide the loader

        //                 if (data.success) {
        //                     show_toastr('Success', action === 'save' ?
        //                         'Sub Offer Ad Creatives added successfully' :
        //                         'Sub Offer Ad Creatives updated successfully', 'success');

        //                     // Change Save button to Update button after a successful save
        //                     if (action === 'save') {
        //                         let saveButton = row.querySelector('.save-button');
        //                         let updateButton = row.querySelector('.update-button');

        //                         if (saveButton) saveButton.classList.add('d-none');
        //                         if (updateButton) updateButton.classList.remove('d-none');

        //                         // Optionally, update the data-id attribute for the update button
        //                         updateButton.setAttribute('data-id', data.sub_offer_id);
        //                     }

        //                 } else {
        //                     alert('Error saving data: ' + (data.message || 'Unknown error'));
        //                 }
        //             })
        //             .catch(error => {
        //                 if (loader) loader.classList.add('hidden'); // Hide the loader in case of error
        //                 console.error('Error:', error);
        //                 alert('Error saving data: ' + error.message);
        //             });
        //     }
        // });

        document.addEventListener('DOMContentLoaded', function() {
            const baseUrl = @json(route('generate-headlines-manual-suboffer', ['id' => $subOffer->id]));

            // Function to generate content for a specific repeater item
            function generateContent(campaignId, generateButton) {
                const loader = generateButton.nextElementSibling; // Assuming loader is immediately after the button

                // Show the loader and hide the generate button
                loader.classList.remove('hidden');
                generateButton.classList.add('d-none');

                // Send AJAX request
                fetch(`${baseUrl}?campaign_id=${campaignId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Hide the loader and show the generate button
                        loader.classList.add('hidden');
                        generateButton.classList.remove('d-none');

                        // Find the closest table row and update the content in the appropriate <td> elements
                        const row = generateButton.closest('tr');
                        console.log('Table Data:', hot.getData());
                        const rowIndex = hot.getData().findIndex(row => row[0] ==
                            campaignId); // Assuming first column (index 0) has the record ID

                        if (rowIndex !== -1) {
                            // Update Handsontable data directly based on the response
                            hot.setDataAtCell(rowIndex, 4, data.headline ||
                                'N/A'); // Update headline (column index 4)
                            hot.setDataAtCell(rowIndex, 5, data.primary_text ||
                                'N/A'); // Update primary text (column index 5)
                            hot.setDataAtCell(rowIndex, 6, data.description ||
                                'N/A'); // Update description (column index 6)

                            // Debug: Check if values are correctly set
                            console.log('Headline:', hot.getDataAtCell(rowIndex, 4));
                            console.log('Primary Text:', hot.getDataAtCell(rowIndex, 5));
                            console.log('Description:', hot.getDataAtCell(rowIndex, 6));
                        } else {
                            console.log('Row not found for campaign ID:', campaignId);
                        }


                        // const rowIndex = hot.toPhysicalRow(row.rowIndex); // Convert DOM row to physical row index

                        // if (row) {

                        //     const headlineCell = row.children[5]; // Assuming headline is in the 5th <td>
                        //     const primaryTextCell = row.children[6]; // Assuming primary text is in the 6th <td>
                        //     const descriptionCell = row.children[7]; // Assuming description is in the 7th <td>
                        //     console.log(headlineCell);

                        //     // Safely update the content if the cells exist
                        //     if (headlineCell) headlineCell.textContent = data.headline || 'N/A';
                        //     if (primaryTextCell) primaryTextCell.textContent = data.primary_text || 'N/A';
                        //     if (descriptionCell) descriptionCell.textContent = data.description || 'N/A';

                        //     // Debug: Check if values are correctly set
                        //     console.log('Headline:', headlineCell ? headlineCell.textContent : 'No cell found');
                        //     console.log('Primary Text:', primaryTextCell ? primaryTextCell.textContent :
                        //         'No cell found');
                        //     console.log('Description:', descriptionCell ? descriptionCell.textContent :
                        //         'No cell found');
                        // } else {
                        //     console.log('Row not found for campaign ID:', campaignId);
                        // }
                    })
                    .catch(error => {
                        console.error('Error generating content:', error);
                        // Hide the loader and show the generate button if there's an error
                        loader.classList.add('hidden');
                        generateButton.classList.remove('d-none');
                    });
            }

            // Attach event listener using delegation for dynamically added repeater items
            document.addEventListener('click', function(event) {
                const target = event.target;

                // Check if the clicked element is a generate button
                if (target.classList.contains('generate-button')) {
                    const campaignId = target.getAttribute('data-campaign-id');
                    generateContent(campaignId, target);
                }
            });
        });


        // const offerSubCampaignName = "{{ $subOffer->offer_sub_campaign_name }}";

        // Populate campaign name when the document is ready (initial load)
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.campaign-name').forEach(input => {
                setCampaignName(input);
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Function to handle file preview
            function handleFileInputChange(fileInput) {
                fileInput.addEventListener('change', function(event) {
                    const files = event.target.files;
                    const previewArea = this.closest('tr').querySelector('.preview-area');

                    if (files.length > 0) {
                        Array.from(files).forEach((file, index) => {
                            const fileReader = new FileReader();

                            fileReader.onload = function(e) {
                                const previewElement = document.createElement('div');
                                previewElement.classList.add('mb-3', 'preview-container',
                                    'mt-3');
                                previewElement.dataset.fileIndex = index;

                                if (file.type.startsWith('image/')) {
                                    previewElement.innerHTML = `
                                <img src="${e.target.result}" class="img-fluid preview-image" alt="Preview"/>
                                <button type="button" class="btn btn-danger btn-sm mt-2 remove-btn">Remove</button>
                            `;
                                } else if (file.type.startsWith('video/')) {
                                    previewElement.innerHTML = `
                                <video controls class="img-fluid preview-video" alt="Preview">
                                    <source src="${e.target.result}" type="${file.type}">
                                </video>
                                <button type="button" class="btn btn-danger btn-sm mt-2 remove-btn">Remove</button>
                            `;
                                } else {
                                    alert('Unsupported file type');
                                    return;
                                }

                                previewArea.appendChild(previewElement);
                            };

                            fileReader.readAsDataURL(file);
                        });
                    }
                });
            }

            // Attach event listeners to existing file inputs
            document.querySelectorAll('input[type="file"]').forEach(fileInput => {
                handleFileInputChange(fileInput);
            });

            // Attach event listener for dynamically added repeaters
            document.addEventListener('click', function(event) {
                if (event.target.matches('[data-repeater-create]')) {
                    setTimeout(function() {
                        const newFileInputs = document.querySelectorAll('input[type="file"]');
                        newFileInputs.forEach(fileInput => {
                            if (!fileInput.dataset.listenerAttached) {
                                handleFileInputChange(fileInput);
                                fileInput.dataset.listenerAttached = true;
                            }
                        });
                    }, 100);
                }
            });

            // Handle remove preview button
            document.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-btn')) {
                    const previewContainer = event.target.closest('.preview-container');
                    const fileInput = previewContainer.closest('tr').querySelector('input[type="file"]');
                    const fileIndex = parseInt(previewContainer.dataset.fileIndex);

                    // Create a new FileList without the removed file
                    const dt = new DataTransfer();
                    Array.from(fileInput.files).forEach((file, index) => {
                        if (index !== fileIndex) {
                            dt.items.add(file);
                        }
                    });

                    fileInput.files = dt.files;
                    previewContainer.remove();
                }
            });
        });

        // const customButtonRenderer = function(hotInstance, td, row, col, prop, value, cellProperties) {
        //     Handsontable.renderers.TextRenderer.apply(this, arguments);
        //     const recordId = hotInstance.getDataAtCell(row, 0); // Adjust the column index if needed

        //     const campaignId = {{ $subOffer->id }};
        //     const regenerateButton = document.createElement('a');
        //     regenerateButton.href = 'javascript:void(0)';
        //     regenerateButton.className = 'btn btn-warning me-2 text-white generate-button btn-sm mb-2 mt-2';
        //     regenerateButton.dataset.campaignId = recordId;
        //     regenerateButton.innerHTML = '<i class="fa-solid fa-audio-description"></i> Regenerate Content';

        //     const loaderDiv = document.createElement('div');
        //     loaderDiv.id = `loader-${recordId}`;
        //     loaderDiv.className = 'loader buttonload btn btn-primary me-2 hidden mb-2 btn-sm mb-2';
        //     loaderDiv.innerHTML = '<i class="fa fa-spinner fa-spin mr-2"></i> Wait....';

        //     const updateButton = document.createElement('a');
        //     updateButton.href = '#';
        //     updateButton.className = `btn btn-lime mb-2 update-button text-white ${recordId ? '' : 'd-none'}`;
        //     updateButton.dataset.id = recordId;
        //     updateButton.innerHTML = '<i class="ti ti-save"></i> Update';

        //     const saveButton = document.createElement('a');
        //     saveButton.href = '#';
        //     saveButton.className = `btn btn-teal save-button mb-2 text-white ${recordId ? 'd-none' : ''}`;
        //     saveButton.innerHTML = '<i class="ti ti-save"></i> Save';

        //     const removeButton = document.createElement('a');
        //     removeButton.href = 'javascript:void(0);';
        //     removeButton.className = 'btn btn-danger btn-sm text-white mb-2';
        //     removeButton.dataset.repeaterDelete = '';
        //     removeButton.innerHTML = '<i class="ti ti-trash"></i> Remove';

        //     td.innerHTML = ''; // Clear existing content
        //     td.appendChild(regenerateButton);
        //     td.appendChild(loaderDiv);
        //     td.appendChild(updateButton);
        //     td.appendChild(saveButton);
        //     td.appendChild(removeButton);
        // };

        // document.addEventListener('DOMContentLoaded', function() {
        //     const container = document.getElementById('excel-view');

        //     // Prepopulate data from your form
        //     let formData = @json($SubOfferads);
        //     // console.log(formData);

        //     // Transforming data to array format (Handsontable expects array of arrays)
        //     const data = formData.map(offer => [
        //         offer.id || '',
        //         offer.sub_offer_ad_craetive_campaign_name || '',
        //         '', // Image file input placeholder
        //         offer.sub_offer_ad_craetive_offer_url || '',
        //         offer.sub_offer_ad_craetive_headlines || '',
        //         offer.sub_offer_ad_craetive_primary_text || '',
        //         offer.sub_offer_ad_craetive_description || '',
        //     ]);

        //     // Handsontable initialization
        //     const hot = new Handsontable(container, {
        //         data: data,
        //         colHeaders: ['Record ID', 'Campaign Name', 'Upload Image/Video', 'Offer URL', 'Headline',
        //             'Primary Text', 'Description', 'Action'
        //         ],

        //         rowHeaders: true,
        //         contextMenu: true,
        //         manualColumnResize: true, // Allow resizing columns manually
        //         manualRowResize: true,
        //         stretchH: 'all', // Stretches table to fill available space
        //         licenseKey: 'non-commercial-and-evaluation', // Replace with your license if needed
        //         width: '100%',
        //         height: 'auto',
        //         columns: [{
        //                 data: 0, // Record ID column
        //                 type: 'text',
        //                 width: 0, // Hide this column
        //                 // className: 'htHidden', // Ensure it's hidden
        //             },
        //             {
        //                 data: 1,
        //                 type: 'text',
        //                 width: 150,
        //             },
        //             {
        //                 data: 2,
        //                 renderer: customFileRenderer,
        //                 width: 150,
        //             },
        //             {
        //                 data: 3,
        //                 type: 'text',
        //                 width: 200,
        //             },
        //             {
        //                 data: 4,
        //                 type: 'text',
        //                 width: 300,
        //             },
        //             {
        //                 data: 5,
        //                 type: 'text',
        //                 width: 250,
        //             },
        //             {
        //                 data: 6,
        //                 type: 'text',
        //                 width: 250,
        //             },
        //             {
        //                 data: 7,
        //                 renderer: customButtonRenderer,
        //                 width: 150,
        //                 readOnly: true, // Makes the "Action" column non-editable
        //                 manualColumnResize: false // Disables column resizing for the "Action" column
        //             },
        //         ],
        //         autoColumnSize: {
        //             samplingRatio: 23,
        //         },
        //     });

        //     // Custom file input renderer for file uploads
        //     function customFileRenderer(instance, td, row, col, prop, value, cellProperties) {
        //         Handsontable.dom.empty(td);
        //         const input = document.createElement('input');
        //         input.type = 'file';
        //         input.className = 'form-control';
        //         input.name = 'files[]'; // Match your input name
        //         td.appendChild(input);
        //         return td;
        //     }

        //     // Function to handle adding new rows dynamically
        //     document.getElementById('add-row').addEventListener('click', function(e) {
        //         e.preventDefault();
        //         hot.alter('insert_row');
        //     });

        //     // Function to save data back to form inputs
        //     function saveDataToForm() {
        //         const data = hot.getData();
        //         const hiddenData = data.map(row => ({
        //             recordId: row[0],
        //             campaignName: row[1],
        //             offerUrl: row[3],
        //             headline: row[4],
        //             primaryText: row[5],
        //             description: row[6],
        //         }));
        //         console.log(hiddenData);

        //         document.getElementById('hidden-data').value = JSON.stringify(hiddenData);
        //     }
        // });

        const customButtonRenderer = function(hotInstance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            const recordId = hotInstance.getDataAtCell(row, 0); // Adjust the column index if needed

            const campaignId = {{ $subOffer->id }};
            const regenerateButton = document.createElement('a');
            regenerateButton.href = 'javascript:void(0)';
            regenerateButton.className = 'btn btn-warning me-2 text-white generate-button btn-sm mb-2 mt-2';
            regenerateButton.dataset.campaignId = recordId;
            regenerateButton.innerHTML = '<i class="fa-solid fa-audio-description"></i> Regenerate Content';

            const loaderDiv = document.createElement('div');
            loaderDiv.id = `loader-${recordId}`;
            loaderDiv.className = 'loader buttonload btn btn-primary me-2 hidden mb-2 btn-sm mt-2';
            loaderDiv.innerHTML = '<i class="fa fa-spinner fa-spin mr-2"></i> Wait....';

            const updateButton = document.createElement('a');
            updateButton.href = '#';
            updateButton.className =
                `btn btn-lime mb-2 btn-sm me-2 mt-2 update-button text-white ${recordId ? '' : 'd-none'}`;
            updateButton.dataset.id = recordId;
            updateButton.innerHTML = '<i class="ti ti-save"></i> Update';

            const saveButton = document.createElement('a');
            saveButton.href = '#';
            saveButton.className =
                `btn btn-teal mt-2 btn-sm me-2 mb-2 save-button text-white ${recordId ? 'd-none' : ''}`;
            saveButton.innerHTML = '<i class="ti ti-save"></i> Save';

            const removeButton = document.createElement('a');
            removeButton.href = 'javascript:void(0);';
            removeButton.className = 'btn btn-danger btn-sm text-white';
            removeButton.dataset.repeaterDelete = '';
            removeButton.innerHTML = '<i class="ti ti-trash"></i> Remove';

            removeButton.addEventListener('click', function() {
                // SweetAlert for confirmation
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action will permanently delete this item!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Call your delete route via AJAX
                        $.ajax({
                            url: '{{ route('delete.repeater.data') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}', // Add CSRF token for Laravel
                                id: recordId // Send the record ID
                            },
                            success: function(response) {
                                if (response.success) {
                                    show_toastr('Success',
                                    'Sub Offer Ad creative has been deleted successfully', 'success');
                                    // Remove the row from Handsontable
                                    hotInstance.alter('remove_row', row);
                                    saveDataToForm(); // Save updated data after deletion

                                    // Show success toaster message
                                  
                                } else {
                                    // Show error toaster message if deletion failed
                                    show_toastr('Error', 'Failed to delete the item',
                                        'error');
                                }
                            },
                            error: function() {
                                // Show error toaster message if AJAX request failed
                                show_toastr('Error', 'Something went wrong', 'error');
                            }
                        });
                    }
                });
            });

            td.innerHTML = ''; // Clear existing content
            td.appendChild(regenerateButton);
            td.appendChild(loaderDiv);
            td.appendChild(updateButton);
            td.appendChild(saveButton);
            td.appendChild(removeButton);
        };

        function getTodayDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('excel-view');

            // Prepopulate data from your form
            let formData = @json($SubOfferads);
            // Ensure the hidden input field exists
            let hiddenDataInput = document.getElementById('hidden-data');
            if (!hiddenDataInput) {
                hiddenDataInput = document.createElement('input');
                hiddenDataInput.type = 'hidden';
                hiddenDataInput.id = 'hidden-data';
                hiddenDataInput.name = 'hidden_data'; // Ensure this matches your backend expectations
                document.querySelector('#content-form-{{ $subOffer->id }}').appendChild(hiddenDataInput);
            }
            // Transforming data to array format (Handsontable expects array of arrays)
            const data = formData.map(offer => [
                offer.id || '',
                offer.sub_offer_ad_craetive_campaign_name || '',
                offer.sub_offer_ad_craetive_sub_image || '', // Image file input placeholder
                offer.sub_offer_ad_craetive_offer_url || '',
                offer.sub_offer_ad_craetive_headlines || '',
                offer.sub_offer_ad_craetive_primary_text || '',
                offer.sub_offer_ad_craetive_description || '',
            ]);

            // Handsontable initialization
            const hot = new Handsontable(container, {
                data: data,
                colHeaders: ['Record ID', 'Campaign Name', 'Upload Image/Video', 'Offer URL', 'Headline',
                    'Primary Text', 'Description', 'Action'
                ],
                rowHeaders: true,
                contextMenu: true,
                manualColumnResize: true,
                manualRowResize: true,
                stretchH: 'all',
                licenseKey: 'non-commercial-and-evaluation',
                width: '100%',
                height: 'auto',
                persistentState: true,
                columns: [{
                        data: 0,
                        type: 'text',
                        width: 0
                    },
                    {
                        data: 1,
                        type: 'text',
                        width: 150
                    },
                    {
                        data: 2,
                        renderer: customFileRenderer,
                        width: 150
                    },
                    {
                        data: 3,
                        type: 'text',
                        width: 200
                    },
                    {
                        data: 4,
                        type: 'text',
                        width: 300
                    },
                    {
                        data: 5,
                        type: 'text',
                        width: 250
                    },
                    {
                        data: 6,
                        type: 'text',
                        width: 250
                    },
                    {
                        data: 7,

                        renderer: customButtonRenderer,
                        width: 200,
                        readOnly: true,
                        manualColumnResize: false
                    },
                ],
                autoColumnSize: {
                    samplingRatio: 23
                },
                afterChange: function(changes, source) {
                    if (source !== 'loadData') {
                        this.render();
                        saveDataToForm(); // Save data after every change
                    }
                },
                // beforeKeyDown: function(event) {
                //     const selected = this.getSelected();
                //     if (selected) {
                //         const row = selected[0];
                //         const col = selected[1];
                //         const prop = this.colToProp(col);
                //         const value = this.getDataAtCell(row, col);
                //         if (value === null || value === undefined) {
                //             this.setDataAtCell(row, col, '');
                //         }
                //     }
                // },
            });
            //     data: data,
            //     colHeaders: ['Record ID', 'Campaign Name', 'Upload Image/Video', 'Offer URL', 'Headline',
            //         'Primary Text', 'Description', 'Action'
            //     ],
            //     rowHeaders: true,
            //     contextMenu: true,
            //     manualColumnResize: true, // Allow resizing columns manually
            //     manualRowResize: true,
            //     stretchH: 'all', // Stretches table to fill available space
            //     licenseKey: 'non-commercial-and-evaluation', // Replace with your license if needed
            //     width: '100%',
            //     height: 'auto',
            //     persistentState: true, // This ensures Handsontable keeps track of cell states
            //     columns: [{
            //             data: 0, // Record ID column
            //             type: 'text',
            //             width: 0, // Hide this column
            //         },
            //         {
            //             data: 1, // Campaign Name column
            //             type: 'text',
            //             width: 150,
            //         },
            //         {
            //             data: 2, // File upload column
            //             renderer: customFileRenderer,
            //             width: 150,
            //         },
            //         {
            //             data: 3, // Offer URL column
            //             type: 'text',
            //             width: 200,
            //         },
            //         {
            //             data: 4, // Headline column
            //             type: 'text',
            //             width: 300,
            //         },
            //         {
            //             data: 5, // Primary Text column
            //             type: 'text',
            //             width: 250,
            //         },
            //         {
            //             data: 6, // Description column
            //             type: 'text',
            //             width: 250,
            //         },
            //         {
            //             data: 7, // Action buttons column
            //             renderer: customButtonRenderer,
            //             width: 200,
            //             readOnly: true, // Makes the "Action" column non-editable
            //             manualColumnResize: false // Disables column resizing for the "Action" column
            //         },
            //     ],
            //     autoColumnSize: {
            //         samplingRatio: 23,
            //     },
            // });

            // Custom file input renderer for file uploads
            // function customFileRenderer(instance, td, row, col, prop, value, cellProperties) {
            //     Handsontable.dom.empty(td);
            //     const input = document.createElement('input');
            //     input.type = 'file';
            //     input.className = 'form-control mt-2 mr-2';
            //     input.style.marginRight = '4px'; // Add inline style for margin-right
            //     input.style.width = '211px'; // Add inline style for width
            //     input.name = 'files[]'; // Match your input name
            //     input.multiple = true;
            //     td.appendChild(input);
            //     return td;
            // }

            // Custom file input renderer for file uploads with persistent preview and file data
            // function customFileRenderer(instance, td, row, col, prop, value, cellProperties) {
            //     Handsontable.dom.empty(td); // Clear the cell

            //     const input = document.createElement('input');
            //     input.type = 'file';
            //     input.className = 'form-control mt-2 mr-2';
            //     input.style.marginRight = '4px'; // Add inline style for margin-right
            //     input.style.width = '211px'; // Add inline style for width
            //     input.name = 'files[]'; // Match your input name
            //     input.multiple = true; // Allow multiple file uploads
            //     td.appendChild(input); // Append the input field

            //     const previewContainer = document.createElement('div');
            //     previewContainer.className = 'preview-container mt-2'; // Add some margin for the preview
            //     td.appendChild(previewContainer);

            //     // If there are already file previews stored for this cell, display them
            //     const fileKey = `${row}-${col}`; // Use row and col as a unique key
            //     if (fileStorage[fileKey]) {
            //         fileStorage[fileKey].forEach(file => {
            //             const previewData = file.preview;
            //             if (file.type.startsWith('image/')) {
            //                 const img = document.createElement('img');
            //                 img.src = previewData;
            //                 img.style.maxWidth = '100px';
            //                 img.style.maxHeight = '100px';
            //                 img.style.marginRight = '5px'; // Add margin between images
            //                 previewContainer.appendChild(img);
            //             } else if (file.type.startsWith('video/')) {
            //                 const video = document.createElement('video');
            //                 video.src = previewData;
            //                 video.controls = true;
            //                 video.style.maxWidth = '100px';
            //                 video.style.maxHeight = '100px';
            //                 video.style.marginRight = '5px'; // Add margin between videos
            //                 previewContainer.appendChild(video);
            //             }
            //         });
            //     }

            //     // Add change event listener to input
            //     input.addEventListener('change', function(event) {
            //         const files = event.target.files;
            //         previewContainer.innerHTML = ''; // Clear previous previews

            //         if (files && files.length > 0) {
            //             // Store the file data for the cell in fileStorage
            //             fileStorage[fileKey] = [];

            //             Array.from(files).forEach(file => {
            //                 const reader = new FileReader();

            //                 reader.onload = function(e) {
            //                     if (file.type.startsWith('image/')) {
            //                         // Create image preview
            //                         const img = document.createElement('img');
            //                         img.src = e.target.result;
            //                         img.style.maxWidth = '100px';
            //                         img.style.maxHeight = '100px';
            //                         img.style.marginRight = '5px'; // Add margin between images
            //                         previewContainer.appendChild(img);
            //                     } else if (file.type.startsWith('video/')) {
            //                         // Create video preview
            //                         const video = document.createElement('video');
            //                         video.src = e.target.result;
            //                         video.controls = true;
            //                         video.style.maxWidth = '100px';
            //                         video.style.maxHeight = '100px';
            //                         video.style.marginRight =
            //                             '5px'; // Add margin between videos
            //                         previewContainer.appendChild(video);
            //                     }

            //                     // Store the file data with its preview
            //                     fileStorage[fileKey].push({
            //                         file: file,
            //                         preview: e.target.result,
            //                         type: file.type
            //                     });
            //                 };

            //                 reader.readAsDataURL(
            //                     file); // Read the file as a Data URL to create a preview
            //             });
            //         }
            //     });

            //     return td;
            // }

            // function customFileRenderer(instance, td, row, col, prop, value, cellProperties) {
            //     Handsontable.dom.empty(td);
            //     const input = document.createElement('input');
            //     input.type = 'file';
            //     input.className = 'file-input';
            //     input.multiple = true;
            //     input.style.display = 'none';
            //     input.accept = 'image/*,video/*';

            //     const button = document.createElement('button');
            //     button.textContent = 'Upload Files';
            //     button.className = 'btn btn-purple btn-sm mt-2';
            //     button.onclick = function(e) {
            //         e.preventDefault();
            //         input.click();
            //     };

            //     const previewContainer = document.createElement('div');
            //     previewContainer.className = 'preview-container';

            //     td.appendChild(button);
            //     td.appendChild(input);
            //     td.appendChild(previewContainer);

            //     const fileKey = `${row}-${col}`;

            //     // Function to create preview
            //     function createPreview(file) {
            //         const preview = document.createElement('div');
            //         preview.className = 'file-preview';

            //         let src = '';
            //         let isExistingFile = false;

            //         if (typeof file === 'string') {
            //             // If file is a string, assume it's a path or URL
            //             src = file;
            //             isExistingFile = true;
            //         } else if (file instanceof File) {
            //             src = URL.createObjectURL(file);
            //         } else {
            //             console.error('Unsupported file type:', file);
            //             return null;
            //         }

            //         if (src.match(/\.(jpeg|jpg|gif|png)$/i) || (file instanceof File && file.type.startsWith(
            //                 'image/'))) {
            //             const img = document.createElement('img');
            //             img.src = src;
            //             img.alt = isExistingFile ? 'Existing image' : file.name;
            //             img.style.maxWidth = '100px';
            //             img.style.maxHeight = '100px';
            //             preview.appendChild(img);
            //         } else if (src.match(/\.(mp4|webm|ogg)$/i) || (file instanceof File && file.type.startsWith(
            //                 'video/'))) {
            //             const video = document.createElement('video');
            //             video.src = src;
            //             video.style.maxWidth = '100px';
            //             video.style.maxHeight = '100px';
            //             video.controls = true;
            //             preview.appendChild(video);
            //         }

            //         const fileName = document.createElement('p');
            //         fileName.textContent = isExistingFile ? src.split('/').pop() : file.name;
            //         preview.appendChild(fileName);

            //         return preview;
            //     }

            //     // Populate existing files if any
            //     if (value) {
            //         let existingFiles = value;
            //         if (typeof value === 'string') {
            //             // If value is a string, assume it's a single file path or URL
            //             existingFiles = [value];
            //         } else if (!Array.isArray(value)) {
            //             // If value is not an array, wrap it in an array
            //             existingFiles = [value];
            //         }

            //         existingFiles.forEach(file => {
            //             const previewElement = createPreview(file);
            //             if (previewElement) {
            //                 previewContainer.appendChild(previewElement);
            //             }
            //         });
            //     }

            //     input.addEventListener('change', function(e) {
            //         const files = Array.from(e.target.files);
            //         fileStorage[fileKey] = files;

            //         // Update previews
            //         previewContainer.innerHTML = '';
            //         files.forEach(file => {
            //             const previewElement = createPreview(file);
            //             if (previewElement) {
            //                 previewContainer.appendChild(previewElement);
            //             }
            //         });

            //         saveDataToForm();
            //     });

            //     return td;
            // }


            // function customFileRenderer(instance, td, row, col, prop, value, cellProperties) {
            //     Handsontable.dom.empty(td);

            //     const input = document.createElement('input');
            //     input.type = 'file';
            //     input.className = 'file-input';
            //     input.multiple = true;
            //     input.accept = 'image/*,video/*';
            //     input.style.display = 'none';

            //     const button = document.createElement('button');
            //     button.textContent = 'Upload Files';
            //     button.className = 'btn btn-purple btn-sm mt-2';
            //     button.onclick = (e) => {
            //         e.preventDefault();
            //         input.click();
            //     };

            //     const previewContainer = document.createElement('div');
            //     previewContainer.className = 'preview-container';
            //     previewContainer.style.display = 'flex';
            //     previewContainer.style.flexWrap = 'wrap';
            //     previewContainer.style.gap = '5px';
            //     previewContainer.style.marginTop = '5px';

            //     td.appendChild(button);
            //     td.appendChild(input);
            //     td.appendChild(previewContainer);

            //     const fileKey = `${row}-${col}`;

            //     function createPreview(src) {
            //         const container = document.createElement('div');
            //         container.style.position = 'relative';
            //         container.style.width = '100px';
            //         container.style.height = '100px';

            //         let element;
            //         if (src.match(/\.(mp4|webm|ogg)$/i)) {
            //             element = document.createElement('video');
            //             element.controls = true;
            //         } else {
            //             element = document.createElement('img');
            //         }

            //         element.src = src;
            //         element.style.width = '100%';
            //         element.style.height = '100%';
            //         element.style.objectFit = 'cover';

            //         const removeBtn = document.createElement('button');
            //         removeBtn.textContent = '×';
            //         removeBtn.style.position = 'absolute';
            //         removeBtn.style.top = '5px';
            //         removeBtn.style.right = '5px';
            //         removeBtn.style.background = 'rgba(255, 0, 0, 0.7)';
            //         removeBtn.style.color = 'white';
            //         removeBtn.style.border = 'none';
            //         removeBtn.style.borderRadius = '50%';
            //         removeBtn.style.width = '20px';
            //         removeBtn.style.height = '20px';
            //         removeBtn.style.cursor = 'pointer';
            //         removeBtn.style.display = 'none';

            //         container.appendChild(element);
            //         container.appendChild(removeBtn);

            //         container.onmouseover = () => removeBtn.style.display = 'block';
            //         container.onmouseout = () => removeBtn.style.display = 'none';

            //         removeBtn.onclick = (e) => {
            //             e.stopPropagation();
            //             container.remove();
            //             updateFileStorage();
            //         };

            //         return container;
            //     }

            //     function updateFileStorage() {
            //         const elements = previewContainer.querySelectorAll('img, video');
            //         fileStorage[fileKey] = Array.from(elements).map(el => el.src);
            //         instance.setDataAtCell(row, col, JSON.stringify(fileStorage[fileKey]), 'auto');
            //     }

            //     function displayFiles(sources) {
            //         previewContainer.innerHTML = '';
            //         sources.forEach(src => {
            //             const preview = createPreview(src);
            //             previewContainer.appendChild(preview);
            //         });
            //     }

            //     // Display existing files
            //     if (value) {
            //         try {
            //             const sources = JSON.parse(value);
            //             displayFiles(sources);
            //         } catch (e) {
            //             console.error('Error parsing cell value:', e);
            //         }
            //     }

            //     input.onchange = (e) => {
            //         const files = Array.from(e.target.files);
            //         const filePromises = files.map(file => {
            //             return new Promise((resolve) => {
            //                 const reader = new FileReader();
            //                 reader.onload = (e) => resolve(e.target.result);
            //                 reader.readAsDataURL(file);
            //             });
            //         });

            //         Promise.all(filePromises).then(newSources => {
            //             let allSources = newSources;

            //             if (fileStorage[fileKey]) {
            //                 allSources = [...fileStorage[fileKey], ...newSources];
            //             }

            //             displayFiles(allSources);
            //             updateFileStorage();
            //         });
            //     };

            //     return td;
            // }


            function customFileRenderer(instance, td, row, col, prop, value, cellProperties) {
                Handsontable.dom.empty(td);

                const input = document.createElement('input');
                input.type = 'file';
                input.className = 'file-input';
                input.multiple = true;
                input.accept = 'image/*,video/*';
                input.style.display = 'none';

                const button = document.createElement('button');
                button.textContent = 'Upload Files';
                button.className = 'btn btn-purple btn-sm mt-2';
                button.onclick = (e) => {
                    e.preventDefault();
                    input.click();
                };

                const previewContainer = document.createElement('div');
                previewContainer.className = 'preview-container';
                previewContainer.style.display = 'flex';
                previewContainer.style.flexWrap = 'wrap';
                previewContainer.style.gap = '5px';
                previewContainer.style.marginTop = '5px';

                td.appendChild(button);
                td.appendChild(input);
                td.appendChild(previewContainer);

                const fileKey = `${row}-${col}`;

                function createPreview(src) {
                    const container = document.createElement('div');
                    container.style.position = 'relative';
                    container.style.width = '100px';
                    container.style.height = '100px';

                    let element;
                    if (src.match(/\.(mp4|webm|ogg)$/i)) {
                        element = document.createElement('video');
                        element.controls = true;
                    } else {
                        element = document.createElement('img');
                    }

                    element.src = src;
                    element.style.width = '100%';
                    element.style.height = '100%';
                    element.style.objectFit = 'fill';

                    // const removeBtn = document.createElement('button');
                    // removeBtn.textContent = '×';
                    // removeBtn.style.position = 'absolute';
                    // removeBtn.style.top = '5px';
                    // removeBtn.style.right = '5px';
                    // removeBtn.style.background = 'rgba(255, 0, 0, 0.7)';
                    // removeBtn.style.color = 'white';
                    // removeBtn.style.border = 'none';
                    // removeBtn.style.borderRadius = '50%';
                    // removeBtn.style.width = '20px';
                    // removeBtn.style.height = '20px';
                    // removeBtn.style.cursor = 'pointer';
                    // removeBtn.style.display = 'none';

                    container.appendChild(element);
                    // container.appendChild(removeBtn);

                    // container.onmouseover = () => removeBtn.style.display = 'block';
                    // container.onmouseout = () => removeBtn.style.display = 'none';

                    // removeBtn.onclick = (e) => {
                    //     e.stopPropagation();
                    //     container.remove();
                    //     updateFileStorage();
                    // };

                    return container;
                }

                function updateFileStorage(fileNames) {
                    instance.setDataAtCell(row, col, JSON.stringify(fileNames), 'auto');
                }

                function displayFiles(sources) {
                    previewContainer.innerHTML = '';
                    sources.forEach(src => {
                        const preview = createPreview(src);
                        previewContainer.appendChild(preview);
                    });
                }

                // Display existing files
                if (value) {
                    try {
                        const sources = JSON.parse(value);
                        displayFiles(sources);
                    } catch (e) {
                        console.error('Error parsing cell value:', e);
                    }
                }

                // input.addEventListener('change', function(e) {
                //     const files = Array.from(e.target.files);
                //     fileStorage[fileKey] = files;

                //     // Update file list
                //     previewContainer.innerHTML = '';
                //     files.forEach(file => {
                //         previewContainer.appendChild(createPreview(file));
                //         // const li = document.createElement('li');
                //         // li.textContent = file.name;
                //         // previewContainer.appendChild(li);
                //     });

                //     saveDataToForm();
                // });

                input.addEventListener('change', function(e) {
                    const newFiles = Array.from(e.target.files);

                    // Retrieve the existing files from the cell's value if any
                    let existingFiles = [];
                    try {
                        existingFiles = JSON.parse(instance.getDataAtCell(row, col)) || [];
                    } catch (e) {
                        console.error('Error parsing existing files:', e);
                    }

                    // Combine new files with existing ones
                    const combinedFiles = [...existingFiles, ...newFiles];

                    // Update the file storage
                    fileStorage[fileKey] = combinedFiles;

                    // Update the file list with existing files
                    previewContainer.innerHTML = ''; // Clear container to re-display all images
                    combinedFiles.forEach(file => {
                        if (typeof file === 'string') {
                            // For existing files (already uploaded), use the URL directly
                            previewContainer.appendChild(createPreview(file));
                        } else {
                            // For new files, create a Blob URL for previewing
                            const src = URL.createObjectURL(file);
                            previewContainer.appendChild(createPreview(src));
                        }
                    });

                    // Save the combined list to the cell value
                    updateFileStorage(combinedFiles.map(file => (typeof file === 'string' ? file : URL
                        .createObjectURL(file))));

                    saveDataToForm();
                });


                // input.onchange = (e) => {
                //     const files = Array.from(e.target.files);
                //     const formData = new FormData();

                //     files.forEach(file => {
                //         formData.append('files[]', file);
                //     });

                //     // Send files to the server
                //     fetch('/upload-endpoint', {
                //             method: 'POST',
                //             body: formData,
                //         })
                //         .then(response => response.json())
                //         .then(data => {
                //             if (data.success) {
                //                 const fileNames = data.fileNames; // assuming server returns file names
                //                 // displayFiles(fileNames.map(name =>
                //                 // `/path/to/uploaded/files/${name}`)); // adjust this path as needed
                //                 updateFileStorage(fileNames);
                //             } else {
                //                 console.error('Upload failed:', data.message);
                //             }
                //         })
                //         .catch(error => {
                //             console.error('Error uploading files:', error);
                //         });
                // };

                return td;
            }



            // function customFileRenderer(instance, td, row, col, prop, value, cellProperties) {
            //     Handsontable.dom.empty(td);

            //     const input = document.createElement('input');
            //     input.type = 'file';
            //     input.className = 'file-input';
            //     input.multiple = true;
            //     input.style.display = 'none'; // Hide the actual file input

            //     const button = document.createElement('button');
            //     button.textContent = 'Upload Files';
            //     button.className = 'btn btn-purple btn-sm mt-2';
            //     button.onclick = function(e) {
            //         e.preventDefault();
            //         input.click();
            //     };

            //     // const fileList = document.createElement('ul');
            //     // fileList.className = 'file-list';

            //     const previewContainer = document.createElement('div');
            //     previewContainer.className = 'preview-container';
            //     previewContainer.style.position = 'relative';
            //     previewContainer.style.width = '100px';
            //     previewContainer.style.height = '100px';


            //     td.appendChild(button);
            //     td.appendChild(input);
            //     td.appendChild(previewContainer);

            //     const fileKey = `${row}-${col}`;

            //     function createPreview(file) {
            //         const preview = document.createElement('div');
            //         preview.className = 'file-preview';

            //         if (file.type.startsWith('image/')) {
            //             const img = document.createElement('img');
            //             img.src = URL.createObjectURL(file);
            //             img.alt = file.name;
            //             img.style.maxWidth = '30px';
            //             img.style.maxHeight = '90px';
            //             preview.appendChild(img);
            //         } else if (file.type.startsWith('video/')) {
            //             const video = document.createElement('video');
            //             video.src = URL.createObjectURL(file);
            //             video.style.maxWidth = '50px';
            //             video.style.maxHeight = '900px';
            //             video.controls = true;
            //             preview.appendChild(video);
            //         }

            //         // const fileName = document.createElement('p');
            //         // fileName.textContent = file.name;
            //         // preview.appendChild(fileName);

            //         return preview;
            //     }

            //     // Populate existing files if any
            //     // if (fileStorage[fileKey]) {
            //     //     fileStorage[fileKey].forEach(file => {
            //     //         const li = document.createElement('li');
            //     //         li.textContent = file.name;
            //     //         previewContainer.appendChild(li);
            //     //     });
            //     // }
            //     if (fileStorage[fileKey]) {
            //         fileStorage[fileKey].forEach(file => {
            //             previewContainer.appendChild(createPreview(file));
            //         });
            //     }

            //     input.addEventListener('change', function(e) {
            //         const files = Array.from(e.target.files);
            //         fileStorage[fileKey] = files;

            //         // Update file list
            //         previewContainer.innerHTML = '';
            //         files.forEach(file => {
            //             previewContainer.appendChild(createPreview(file));
            //             // const li = document.createElement('li');
            //             // li.textContent = file.name;
            //             // previewContainer.appendChild(li);
            //         });

            //         saveDataToForm();
            //     });

            //     return td;
            // }




            // Function to handle adding new rows dynamically
            document.getElementById('add-row').addEventListener('click', function(e) {
                e.preventDefault();

                // Insert a new row in the table
                hot.alter('insert_row');

                // Get the index of the newly added row
                const rowIndex = hot.countRows() - 1;
                const offerSubCampaignName = "{{ $subOffer->offer_sub_campaign_name }}";

                // Automatically set the campaign name in the new row (column index 1 is for Campaign Name)
                const campaignName = `${offerSubCampaignName} - ${getTodayDate()}`;

                // Set the value for the new row's Campaign Name
                hot.setDataAtCell(rowIndex, 1, campaignName);
            });

            // Function to save data back to form inputs
            function saveDataToForm() {
                const data = hot.getData();
                console.log('data', data);

                const hiddenData = data.map((row, index) => ({
                    recordId: row[0] || '',
                    campaignName: row[1] || '',
                    files: fileStorage[`${index}-2`] || [], // Get files for this row
                    offerUrl: row[3] || '',
                    headline: row[4] || '',
                    primaryText: row[5] || '',
                    description: row[6] || '',
                }));

                hiddenDataInput.value = JSON.stringify(hiddenData);
                console.log('Saving data:', hiddenData);
            }



            // Add event listener for form submission
            document.querySelector('#content-form-{{ $subOffer->id }}').addEventListener('submit', function(e) {
                saveDataToForm();
                hot.render();
            });

            // Initial save
            saveDataToForm();


            // Add event listener for clicking outside the table
            document.addEventListener('click', function(event) {
                if (!container.contains(event.target)) {
                    saveDataToForm();
                }
            });
        });
    </script>
@endpush
