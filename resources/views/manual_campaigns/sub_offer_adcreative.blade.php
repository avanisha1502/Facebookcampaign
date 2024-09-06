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
        <form class="card repeater" id="content-form-{{ $subOffer->id }}" enctype="multipart/form-data">
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

                                    {{-- <a href="#"
                                        class="btn btn-info loader text-white {{ isset($subOffers->id) ? 'd-none' : '' }}">
                                        <i class="fa fa-spinner fa-spin mr-2"></i> {{ __('Wait') }}
                                    </a> --}}

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
        </form>

    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Event listener for adding a new repeater item dynamically
        document.querySelectorAll('[data-repeater-create]').forEach(button => {
            button.addEventListener('click', function() {
                setTimeout(() => {
                    document.querySelectorAll('.campaign-name').forEach(input => {
                        setCampaignName(input);
                    });
                }, 100); // Adding a small delay to ensure the new row is fully added
            });
        });
        $(document).ready(function() {
            $(document).on('click', '[data-repeater-create]', function(e) {
                e.preventDefault();
                let repeaterList = $(this).closest('form').find('[data-repeater-list]');
                let newItem = repeaterList.find('tr').last();
                newItem.find('.save-button').removeClass('d-none'); // Show Save button for new item
                newItem.find('.update-button').addClass('d-none'); // Hide Update button for new item
            });
        });

        // document.addEventListener('DOMContentLoaded', function() {
        //     document.addEventListener('click', function(event) {
        //         if (event.target.closest('.save-button')) {
        //             event.preventDefault();
        //             let row = event.target.closest('tr[data-repeater-item]');
        //             if (!row) {
        //                 alert('Could not find the row for this Save button.');
        //                 return;
        //             }
        //             const rowIndex = Array.from(row.closest('tbody').children).indexOf(row);
        //             let formData = new FormData();

        //             // Get form fields
        //             const campaignName = row.querySelector(
        //                 `input[name="group-a[${rowIndex}][campaign_name]"]`);
        //             const imageInput = row.querySelector(`input[name="group-a[${rowIndex}][files][]"]`);
        //             const offerUrlField = row.querySelector(
        //                 `textarea[name="group-a[${rowIndex}][offerurl]"]`);
        //             const headlineField = row.querySelector(
        //                 `textarea[name="group-a[${rowIndex}][headline]"]`);
        //             const primaryTextField = row.querySelector(
        //                 `textarea[name="group-a[${rowIndex}][primary_text]"]`);
        //             const descriptionField = row.querySelector(
        //                 `textarea[name="group-a[${rowIndex}][description]"]`);

        //             // Flattened keys for form data
        //             if (campaignName) formData.append(`campaign_name`, campaignName.value);
        //             if (headlineField) formData.append(`headline`, headlineField.value);
        //             if (primaryTextField) formData.append(`primary_text`, primaryTextField.value);
        //             if (descriptionField) formData.append(`description`, descriptionField.value);
        //             if (offerUrlField) formData.append(`offerurl`, offerUrlField.value);

        //             // Handle the file input properly
        //             if (imageInput && imageInput.files.length > 0) {
        //                 for (let i = 0; i < imageInput.files.length; i++) {
        //                     formData.append(`files[]`, imageInput.files[
        //                         i]); // Files appended in a flattened structure
        //                 }
        //             }

        //             formData.append('offer_id', '{{ $subOffer->id }}');
        //             formData.append('main_offer_id', '{{ $subOffer->offer_id }}');

        //             // Log FormData contents (for debugging)
        //             // for (let pair of formData.entries()) {
        //             //     console.log(pair[0] + ': ' + pair[1]);
        //             // }

        //             // Send the flattened form data via fetch
        //             fetch('{{ route('save.repeater.data') }}', {
        //                     method: 'POST',
        //                     body: formData,
        //                     headers: {
        //                         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
        //                             .getAttribute('content')
        //                     }
        //                 })
        //                 .then(response => response.json())
        //                 .then(data => {
        //                     if (data.success) {
        //                         show_toastr('Success', 'Sub Offer Ad Creatives added successfully',
        //                             'success');
        //                     } else {
        //                         alert('Error saving data: ' + (data.message || 'Unknown error'));
        //                     }
        //                 })
        //                 .catch(error => {
        //                     console.error('Error:', error);
        //                     alert('Error saving data: ' + error.message);
        //                 });
        //         }
        //     });
        // });

        document.addEventListener('click', function(event) {
            // Save button logic
            if (event.target.closest('.save-button')) {
                event.preventDefault();
                handleFormSubmit(event, 'save');
            }

            // Update button logic
            if (event.target.closest('.update-button')) {
                event.preventDefault();
                handleFormSubmit(event, 'update');
            }

            function handleFormSubmit(event, action) {
                let row = event.target.closest('tr[data-repeater-item]');
                if (!row) {
                    alert('Could not find the row for this button.');
                    return;
                }

                const rowIndex = Array.from(row.closest('tbody').children).indexOf(row);
                let formData = new FormData();

                // Get form fields
                const campaignName = row.querySelector(`input[name="group-a[${rowIndex}][campaign_name]"]`);
                const imageInput = row.querySelector(`input[name="group-a[${rowIndex}][files][]"]`);
                const offerUrlField = row.querySelector(`textarea[name="group-a[${rowIndex}][offerurl]"]`);
                const headlineField = row.querySelector(`textarea[name="group-a[${rowIndex}][headline]"]`);
                const primaryTextField = row.querySelector(`textarea[name="group-a[${rowIndex}][primary_text]"]`);
                const descriptionField = row.querySelector(`textarea[name="group-a[${rowIndex}][description]"]`);

                // Append form fields to FormData
                if (campaignName) formData.append('campaign_name', campaignName.value);
                if (headlineField) formData.append('headline', headlineField.value);
                if (primaryTextField) formData.append('primary_text', primaryTextField.value);
                if (descriptionField) formData.append('description', descriptionField.value);
                if (offerUrlField) formData.append('offerurl', offerUrlField.value);

                // Handle the file input
                if (imageInput && imageInput.files.length > 0) {
                    for (let i = 0; i < imageInput.files.length; i++) {
                        formData.append('files[]', imageInput.files[i]);
                    }
                }

                formData.append('offer_id', '{{ $subOffer->id }}');
                formData.append('main_offer_id', '{{ $subOffer->offer_id }}');

                // Set URL for save or update
                let url = action === 'save' ? '{{ route('save.repeater.data') }}' :
                    '{{ route('update.repeater.data') }}';
                if (action === 'update') {
                    const subOfferId = event.target.getAttribute('data-id');
                    formData.append('sub_offer_id', subOfferId);
                }

                // Show loader while processing and disable buttons
                const loader = row.querySelector('.loader');
                const saveButton = row.querySelector('.save-button');
                const updateButton = row.querySelector('.update-button');

                if (loader) loader.classList.remove('hidden');
                if (saveButton) saveButton.setAttribute('disabled', true);
                if (updateButton) updateButton.setAttribute('disabled', true);

                // Send form data via fetch
                fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Hide the loader and re-enable buttons after request
                        if (loader) loader.classList.add('hidden');
                        if (saveButton) saveButton.removeAttribute('disabled');
                        if (updateButton) updateButton.removeAttribute('disabled');

                        if (data.success) {
                            // Display success notification
                            show_toastr('Success', action === 'save' ?
                                'Sub Offer Ad Creatives added successfully' :
                                'Sub Offer Ad Creatives updated successfully', 'success');

                            // If it was a save action, switch the button to "Update"
                            if (action === 'save') {
                                if (saveButton) saveButton.classList.add('d-none'); // Hide save button
                                if (updateButton) {
                                    updateButton.classList.remove('d-none'); // Show update button
                                    updateButton.setAttribute('data-id', data
                                    .sub_offer_id); // Update data-id for update button
                                }
                            }
                        } else {
                            alert('Error saving data: ' + (data.message || 'Unknown error'));
                        }
                    })
                    .catch(error => {
                        // Hide loader if there is an error
                        if (loader) loader.classList.add('hidden');
                        if (saveButton) saveButton.removeAttribute('disabled');
                        if (updateButton) updateButton.removeAttribute('disabled');
                        console.error('Error:', error);
                        alert('Error saving data: ' + error.message);
                    });
            }
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

                        // Find the closest table row and update the form fields with the generated content
                        const row = generateButton.closest('tr[data-repeater-item]');
                        if (row) {
                            const rowIndex = Array.from(row.closest('tbody').children).indexOf(row);

                            const headlineField = row.querySelector(
                                `textarea[name="group-a[${rowIndex}][headline]"]`);
                            const primaryTextField = row.querySelector(
                                `textarea[name="group-a[${rowIndex}][primary_text]"]`);
                            const descriptionField = row.querySelector(
                                `textarea[name="group-a[${rowIndex}][description]"]`);

                            // Safely update values if fields exist
                            if (headlineField) headlineField.value = data.headline || '';
                            if (primaryTextField) primaryTextField.value = data.primary_text || '';
                            if (descriptionField) descriptionField.value = data.description || '';

                            // Debug: Check if values are correctly set
                            console.log('Headline:', headlineField ? headlineField.value : 'No field found');
                            console.log('Primary Text:', primaryTextField ? primaryTextField.value :
                                'No field found');
                            console.log('Description:', descriptionField ? descriptionField.value :
                                'No field found');
                        } else {
                            console.log('Row not found for campaign ID:', campaignId);
                        }
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

        const offerSubCampaignName = "{{ $subOffer->offer_sub_campaign_name }}";

        // Function to format today's date as YYYY-MM-DD
        function getTodayDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // Function to set campaign name with today's date
        function setCampaignName(input) {
            if (!input.value) {
                input.value = `${offerSubCampaignName} - ${getTodayDate()}`;
            }
        }

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
    </script>
@endpush
