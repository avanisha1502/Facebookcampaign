@extends('admin.home')


@section('contents')
    <style>
        .preview-images-zone {
            width: 100%;
            /* border: 1px solid #ddd; */
            /* min-height: 180px; */
            border-radius: 5px;
            /* padding: 20px; */
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            box-sizing: border-box;
        }

        .preview-image {
            width: 150px;
            height: 150px;
            margin: 10px;
            overflow: hidden;
            position: relative;
            border-radius: 35px;
            border: 1px solid #d3c5c5;
        }

        .preview-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .delete-button {
            position: absolute;
            top: 58px;
            right: 49px;
            background: rgb(255 6 6);
            color: white;
            border: 1px solid red;
            padding: 5px;
            border-radius: 5px;
            cursor: pointer;
            display: none;
        }

        .preview-image:hover .delete-button {
            display: block;
        }
    </style>
    <div class="card">

        <form action="{{ route('generate-imageUpload-store', $campaign->id) }}" method="POST" enctype="multipart/form-data"
            id="campaign-Image">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="language-select" class=" mb-2">Account ID:</label>
                            <select id="account-select" class="form-select" name="account_id">
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->name }} - {{ $account->account_id }}</option>
                                @endforeach
                            </select>
                            @error('account_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="language-select" class=" mb-2">Language:</label>
                            <select id="language-select" class="form-select" name="language">
                                @foreach ($languages as $language)
                                    <option value="{{ $language->language }}">{{ $language->language }}</option>
                                @endforeach
                            </select>
                            @error('language')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="file-input mb-3" class=" mb-2">Image:</label>
                            <input id="file-input" type="file" name="images[]" class="form-control" value="{{ old('images')  }}" multiple >
                            @error('images.*')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            @if ($errors->has('images'))
                                <span class="text-danger">{{ $errors->first('images') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Hidden input field to store deleted image URLs -->
                    <input type="hidden" name="deleted_images" id="deleted-images" value="">

                    <div class="preview-images-zone"></div>
                </div>
            </div>
            <div class="modal-footer mb-3 mr-15">
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            // Display image previews
            function readURL(input) {
                if (input.files && input.files.length) {
                    Array.from(input.files).forEach(file => {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            var html = `
                            <div class="preview-image">
                                <img src="${e.target.result}">
                                <button class="delete-button">Delete &times;</button>
                            </div>`;
                            $('.preview-images-zone').append(html);
                        }

                        reader.readAsDataURL(file);
                    });
                }
            }

            // Trigger image preview when file input changes
            $("input[name='images[]']").change(function() {
                readURL(this);
            });

            // Remove image preview on delete button click
            $(document).on('click', '.delete-button', function() {
                $(this).closest('.preview-image').remove();
            });
        });


        $(document).ready(function() {
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            const campaignId = "{{ $campaign->id }}"; // Ensure this is available or set dynamically

            function fetchImages(language) {
                $.ajax({
                    url: "{{ route('fetch-images') }}",
                    type: 'GET',
                    data: {
                        language: language,
                        campaign_id: campaignId // Include the campaign ID in the request
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Add CSRF token to the headers
                    },
                    success: function(response) {
                        console.log('Response:', response); // Debugging: Check the response

                        let images = typeof response.images === 'string' ? JSON.parse(response.images) :
                            response.images;

                        let previewZone = $('.preview-images-zone');
                        previewZone.empty();

                        if (images && images.length) {
                            images.forEach(function(image) {
                                previewZone.append(`
                            <div class="preview-image">
                                <img src="${image}" alt="Image">
                                <button class="delete-button" data-image-url="${image}" data-campaign-id="${campaignId}">Delete &times;</button>
                            </div>
                        `);
                            });

                            // Attach event listener for delete buttons
                            $('.delete-button').click(function() {
                                let imageUrl = $(this).data('image-url');
                                let campaignId = $(this).data('campaign-id');

                                $.ajax({
                                    url: "{{ route('delete-image') }}",
                                    type: 'DELETE',
                                    data: {
                                        language: $("#language-select")
                                    .val(), // Use the selected language
                                        campaign_id: campaignId,
                                        image_url: imageUrl
                                    },
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken // Add CSRF token to the headers
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            // Remove the image from the DOM
                                            $(this).closest('.preview-image')
                                                .remove();
                                        } else {
                                            console.error(
                                            'Failed to delete image.');
                                        }
                                    }.bind(this),
                                    error: function(xhr, status, error) {
                                        console.error('AJAX Error:', status,
                                        error); // Handle AJAX errors
                                    }
                                });
                            });
                        } else {
                            previewZone.append(
                            '<p></p>'); // Handle the case when there are no images
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error); // Handle AJAX errors
                    }
                });
            }

            // Fetch images for the default language on page load
            fetchImages($("#language-select").val());

            // Fetch images when language changes
            $("#language-select").change(function() {
                fetchImages($(this).val());
            });
        });


        // $(document).ready(function() {
        //     const csrfToken = $('meta[name="csrf-token"]').attr('content');
        //     $("#language-select").change(function() {
        //         let selectedLanguage = $(this).val();
        //         var campaignId = "{{ $campaign->id }}"; // Get the campaign ID from the hidden input

        //         $.ajax({
        //             type: 'GET',
        //             url: "{{ route('fetch-images') }}",
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //             },
        //             data: {
        //                 language: selectedLanguage,
        //                 campaign_id: campaignId // Include the campaign ID in the request
        //             },
        //             success: function(response) {
        //                 console.log('Response:', response); // Debugging: Check the response

        //                 let images = typeof response.images === 'string' ? JSON.parse(response
        //                     .images) : response.images;

        //                 let previewZone = $('.preview-images-zone');
        //                 previewZone.empty();

        //                 if (images && images.length) {
        //                     images.forEach(function(image) {
        //                         previewZone.append(`
    //                 <div class="preview-image">
    //                     <img src="${image}" alt="Image">
    //                     <button class="delete-button" data-image-url="${image}" data-campaign-id="${campaignId}">Delete &times;</button>
    //                 </div>
    //             `);
        //                     });

        //                     // Attach event listener for delete buttons
        //                     $('.delete-button').click(function() {
        //                         let imageUrl = $(this).data('image-url');
        //                         let campaignId = $(this).data('campaign-id');

        //                         $.ajax({
        //                             url: "{{ route('delete-image') }}",
        //                             type: 'DELETE',
        //                             data: {
        //                                 language: selectedLanguage,
        //                                 campaign_id: campaignId,
        //                                 image_url: imageUrl
        //                             },
        //                             headers: {
        //                                 'X-CSRF-TOKEN': csrfToken // Add CSRF token to the headers
        //                             },
        //                             success: function(response) {
        //                                 if (response.success) {
        //                                     // Remove the image from the DOM
        //                                     $(this).closest(
        //                                             '.preview-image')
        //                                         .remove();
        //                                 } else {
        //                                     console.error(
        //                                         'Failed to delete image.'
        //                                     );
        //                                 }
        //                             }.bind(this),
        //                             error: function(xhr, status, error) {
        //                                 console.error('AJAX Error:', status,
        //                                     error); // Handle AJAX errors
        //                             }
        //                         });
        //                     });
        //                 } else {
        //                     previewZone.append(
        //                         '<p></p>'
        //                     ); // Handle the case when there are no images
        //                 }
        //             },
        //             error: function(xhr, status, error) {
        //                 console.error('AJAX Error:', status, error); // Handle AJAX errors
        //             }
        //         });
        //     });

        // });
    </script>
@endpush
