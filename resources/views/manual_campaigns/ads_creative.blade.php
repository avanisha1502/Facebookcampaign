@extends('admin.home')

@section('contents')
    <div class="row gx-4">
        <div class="col-xl-12">
            <form action="{{ route('new-campaign-manually.adcreativeupdate', $campaignAllDetails->id) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card mb-4">
                    <div class="card-header bg-none fw-bold row">
                        <div class="col-md-6 align-items-center d-flex">
                            {{ __('Ads Section') }}
                        </div>
                        <div class="col-md-6 text-align-end">
                            @if (
                                $campaignAllDetails->headlines != null &&
                                    $campaignAllDetails->primary_text != null &&
                                    $campaignAllDetails->description != null)

                                <a href="javascript:void(0)" class="btn btn-warning me-2 generate-button show_btn mb-2 text-white mb-2 "
                                    id="generate-{{ $campaignAllDetails->id }}"
                                    onclick="generateContent({{ $campaignAllDetails->id }})">
                                    <i class="fa-solid fa-audio-description"></i>
                                    {{ __('Regenerate Headlines') }}
                                </a>
                            @else
                                <a href="javascript:void(0)" class="btn btn-success me-2 generate-button show_btn mb-2"
                                    id="generate-{{ $campaignAllDetails->id }}"
                                    onclick="generateContent({{ $campaignAllDetails->id }})">
                                    <i class="fa-solid fa-audio-description"></i>
                                    {{ __('Generate Headlines') }}
                                </a>
                            @endif
                            <div id="loader-{{ $campaignAllDetails->id }}"
                                class="loaderdd-{{ $campaignAllDetails->id }} buttonload btn btn-primary me-2 hidden mb-2">
                                <i class="fa fa-spinner fa-spin mr-2"></i>
                                {{ __('Wait its generating....') }}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Upload Image/Video') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="files[]" multiple id="fileInput">
                                    @error('files')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <div id="previewArea" class="d-flex g-10">
                                        <!-- Existing previews -->
                                        @if (!empty($campaignAllDetails->image))
                                            @php
                                                $images = json_decode($campaignAllDetails->image);
                                            @endphp
                                            @foreach ($images as $image)
                                                <div class="mb-2 preview-container">
                                                    @if (preg_match('/\.(mp4|webm|ogg)$/i', $image))
                                                        <video src="{{ $image }}" controls class="img-fluid"
                                                            style="max-height: 142px; border-radius: 15px; width: 91px;"></video>
                                                    @else
                                                        <img src="{{ $image }}" class="img-fluid"
                                                            style="max-height: 145px; border-radius: 15px;">
                                                    @endif
                                                    <button type="button" class="btn btn-danger btn-sm remove-btn"
                                                        onclick="removePreview(this, '{{ $image }}')">Remove</button>
                                                    <a href="{{ route('download.image', ['url' => $image]) }}"
                                                        class="btn btn-primary btn-sm download-btn">Download</a>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Offer URL') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="offer_url" value="{{ $campaignAllDetails->offer_url ?? '' }}">
                                    @error('offer_url')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Headline') }}<span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" name="headline" id="headline-{{ $campaignAllDetails->id }}" placeholder="Enter Headline"
                                        rows="3">{{ $campaignAllDetails->headlines }}</textarea>
                                    @error('headline')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Primary Text') }}<span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" name="primary_text" placeholder="Enter Primary Text"
                                        id="primary-text-{{ $campaignAllDetails->id }}" rows="3">{{ $campaignAllDetails->primary_text }}</textarea>
                                    @error('primary_text')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Description') }}<span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" name="description" id="description-{{ $campaignAllDetails->id }}"
                                        placeholder="Enter Description" rows="3">{{ $campaignAllDetails->description }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4 mr-3">
                        <div class="col-md-12 text-end ">
                            <button type="submit" class="btn btn-primary">{{ __('Add Ads Creative') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('fileInput');
            const previewArea = document.getElementById('previewArea');

            // Parse existing images from the server
            const existingImages = @json($campaignAllDetails->image ?? '[]');
            const imagesArray = Array.isArray(existingImages) ? existingImages : [];

            if (fileInput) {
                // Function to render existing images/videos
                function renderExistingPreviews() {
                    if (imagesArray.length > 0) {
                        imagesArray.forEach(url => {
                            const previewElement = document.createElement('div');
                            previewElement.classList.add('mb-2', 'preview-container');
                            if (url.match(/\.(mp4|webm|ogg)$/i)) {
                                previewElement.innerHTML = `
                            <video controls autoplay loop class="img-fluid" alt="Preview" style="max-height: 142px; border-radius: 15px; width: 91px;">
                                <source src="${url}" type="video/mp4">
                            </video>
                            <button type="button" class="btn btn-danger btn-sm remove-btn" onclick="removePreview(this, '${url}')">Remove</button>
                        `;
                            } else {
                                previewElement.innerHTML = `
                            <img src="${url}" class="img-fluid" alt="Preview" />
                            <button type="button" class="btn btn-danger btn-sm remove-btn" onclick="removePreview(this, '${url}')">Remove</button>
                        `;
                            }

                            previewArea.appendChild(previewElement);
                        });
                    }
                }

                // Render existing previews on page load
                renderExistingPreviews();

                fileInput.addEventListener('change', function(event) {
                    const files = event.target.files;
                    if (files) {
                        Array.from(files).forEach(file => {
                            const fileReader = new FileReader();

                            fileReader.onload = function(e) {
                                const previewElement = document.createElement('div');
                                previewElement.classList.add('mb-2',
                                    'preview-container');

                                if (file.type.startsWith('image/')) {
                                    previewElement.innerHTML = `
                                <img src="${e.target.result}" class="img-fluid" alt="Preview" style="height:75px !important; border-radius: 15px;" />
                                <button type="button" class="btn btn-danger btn-sm remove-btn" onclick="removePreview(this)">Remove</button>
                            `;
                                } else if (file.type.startsWith('video/')) {
                                    previewElement.innerHTML = `
                                <video controls autoplay loop class="img-fluid" alt="Preview" style="max-height: 142px; border-radius: 15px; width: 91px;">
                                    <source src="${e.target.result}" type="${file.type}">
                                </video>
                                <button type="button" class="btn btn-danger btn-sm remove-btn" onclick="removePreview(this)">Remove</button>
                            `;
                                }

                                previewArea.appendChild(previewElement);
                            };

                            fileReader.readAsDataURL(file);
                        });
                    }
                });
            }
        });

        function removePreview(button, url = null) {
            const previewElement = button.parentElement;
            const manuallycampaignId = "{{ $campaignAllDetails->id }}";
            if (url) {
                fetch('{{ route('delete.image') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            url: url,
                            manuallycampaignId: manuallycampaignId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            previewElement.remove();
                        } else {
                            alert('Failed to remove image');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to remove image');
                    });
            } else {
                previewElement.remove();
            }
        }

        // $(document).on('click', '.generate-button', function(e) {
        //     e.preventDefault(); // Prevent the default link action

        //     var button = $(this);
        //     var id = button.attr('id');

        //     if (!id) {
        //         console.error('Button ID is not defined.');
        //         return;
        //     }

        //     var parts = id.split('-');
        //     if (parts.length < 2) {
        //         console.error('Button ID format is incorrect.');
        //         return;
        //     }

        //     var loaderClass = '.loaderdd-' + parts[1]; // Define the loader class
        //     var loader = $($('div').filter(function() {
        //         return $(this).hasClass(loaderClass.substring(1));
        //     })); // Find the loader element by its class

        //     // Check if the loader exists
        //     if (loader.length === 0) {
        //         console.error('Loader not found with class:', loaderClass);
        //         return;
        //     }

        //     // Hide the button and show the loader
        //     button.hide();
        //     loader.removeClass('hidden'); // Remove the hidden class
        //     loader.addClass('loading'); // Add the loading class
        //     loader.show(); // Show the loader element

        //     // Optionally, make an AJAX request to handle the button click
        //     $.ajax({
        //         url: button.attr('href'),
        //         method: 'GET',
        //         success: function(response) {
        //             // Optionally, hide the loader and show the button again if needed
        //             loader.css('display', 'none'); // Hide the loader again
        //             loader.addClass('hidden'); // Add the hidden class again

        //             // Update the button text and class
        //             button.text('Regenerate Headlines');
        //             button.removeClass('generate-button');
        //             button.addClass('generate-button btn btn-warning me-2');
        //             button.html('<i class="fa-solid fa-redo"></i> Regenerate Headlines');
        //             button.show();

        //             show_toastr('Success', 'Campaign ad content generated successfully', 'success');
        //         },
        //         error: function(xhr) {
        //             // Handle errors if needed
        //             console.error('Error:', xhr.responseText);
        //             // Show the button again in case of error
        //             button.show();
        //             loader.css('display', 'none'); // Hide the loader again
        //             loader.addClass('hidden'); // Add the hidden class again
        //             show_toastr('Error', 'Please check and try again', 'error');
        //         }
        //     });
        // });
        const baseUrl = @json(route('generate-headlines-manual', ['id' => $campaignAllDetails->id]));

        function generateContent(campaignId) {
            // Show the loader
            document.getElementById(`loader-${campaignId}`).classList.remove('hidden');
            // Hide the generate button
            document.getElementById(`generate-${campaignId}`).classList.add('d-none');
            // Send AJAX request
            fetch(baseUrl)
                .then(response => response.json())
                .then(data => {
                    // Hide the loader
                    document.getElementById(`loader-${campaignId}`).classList.add('hidden');

                    // Show the generate button again
                    document.getElementById(`generate-${campaignId}`).classList.remove('d-none');

                    // Update the form fields with generated content
                    document.getElementById(`headline-${campaignId}`).value = data.headline || '';
                    document.getElementById(`primary-text-${campaignId}`).value = data.primary_text || '';
                    document.getElementById(`description-${campaignId}`).value = data.description || '';
                })
                .catch(error => {
                    console.error('Error generating content:', error);
                    // Hide the loader and show the generate button if there's an error
                    document.getElementById(`loader-${campaignId}`).classList.add('hidden');
                    document.getElementById(`generate-${campaignId}`).classList.remove('d-none');
                });
        }
    </script>
@endpush
