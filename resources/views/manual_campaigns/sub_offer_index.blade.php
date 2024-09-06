@extends('admin.home')

@section('contents')
    <div class="d-flex align-items-center mb-3">
        <div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{ __('PAGES') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('new-campaign-manually.index') }}">{{ __('Offer') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Sub Offer') }}</li>
            </ul>
        </div>

        <div class="ms-auto">
            <a class="btn btn-success" href="{{ route('suboffer.create', $id) }}"
                data-title="{{ __('Add New Sub Offer') }}"><i class="fa fa-plus-circle fa-fw me-1"></i>
                {{ __('Add New Sub Offer') }}</a>
        </div>
    </div>
    <div class="row">
        @if ($SubOffers->count() > 0)
            <div class="row">
                <div class="col-md-12">
                    <div class="card-header mb-3">
                        <h5 class="card-title">{{ __('Sub Offer List') }}</h5>
                    </div>
                </div>
            </div>
            @foreach ($SubOffers as $index => $campaign)
                <div class="col-md-4 mb-3">
                    <div class="card card_wed">
                        <div class="card-body">
                            <h5 class="card-title d-flex justify-content-center">
                                <a href="{{ route('suboffer.adscreative', $campaign->id) }}"
                                    style="text-decoration: none; color:black">{{ $campaign->offer_sub_campaign_name }}</a>
                            </h5>
                            <div class="card-title d-flex justify-content-center">
                                {{ $campaign->offer_sub_group }}-{{ $campaign->offer_sub_country_name }}-{{ $campaign->offer_sub_short_code }}-{{ $campaign->offer_sub_language }}
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                <a href="{{ route('sub-offer.edit', $campaign->id) }}" class="btn btn-primary me-2 mb-2"><i
                                        class="fa fa-edit"></i>
                                    {{ __('Edit') }}</a>

                                <form method="POST" action="{{ route('suboffer.destroy', $campaign->id) }}"
                                    id="user-form-{{ $campaign->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <input name="_method" type="hidden" value="DELETE">
                                    <button type="submit" class="btn btn-danger show_confirm">
                                        <span class="text-white"><i class="fa fa-trash"></i>
                                            {{ __('Delete') }}</span>
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-md-12">
                <div class="card card_wed">
                    <div class="card-body">
                        <h5 class="card-title d-flex justify-content-center">{{ __('No Sub Offers Found') }}
                        </h5>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection


@push('scripts')
    <script>
        function copyToClipboard(element) {
            var text = element.getAttribute('data-url');
            var textarea = document.createElement("textarea");
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand("copy");
            document.body.removeChild(textarea);
            show_toastr('Success', 'Text copied to clipboard', 'success');
        }

        // document.addEventListener('DOMContentLoaded', function() {
        //     const fileInput = document.getElementById('fileInput');
        //     const previewArea = document.getElementById('previewArea');

        //     // Parse existing images from the server
        //     const existingImages = @json($campaignAllDetails->image ?? '[]');
        //     const imagesArray = Array.isArray(existingImages) ? existingImages : [];

        //     if (fileInput) {
        //         // Function to render existing images/videos
        //         function renderExistingPreviews() {
        //             if (imagesArray.length > 0) {
        //                 imagesArray.forEach(url => {
        //                     const previewElement = document.createElement('div');
        //                     previewElement.classList.add('mb-2', 'preview-container');
        //                     if (url.match(/\.(mp4|webm|ogg)$/i)) {
        //                         previewElement.innerHTML = `
        //                     <video controls autoplay loop class="img-fluid" alt="Preview" style="max-height: 142px; border-radius: 15px; width: 91px;">
        //                         <source src="${url}" type="video/mp4">
        //                     </video>
        //                     <button type="button" class="btn btn-danger btn-sm remove-btn" onclick="removePreview(this, '${url}')">Remove</button>
        //                 `;
        //                     } else {
        //                         previewElement.innerHTML = `
        //                     <img src="${url}" class="img-fluid" alt="Preview" />
        //                     <button type="button" class="btn btn-danger btn-sm remove-btn" onclick="removePreview(this, '${url}')">Remove</button>
        //                 `;
        //                     }

        //                     previewArea.appendChild(previewElement);
        //                 });
        //             }
        //         }

        //         // Render existing previews on page load
        //         renderExistingPreviews();

        //         fileInput.addEventListener('change', function(event) {
        //             const files = event.target.files;
        //             if (files) {
        //                 Array.from(files).forEach(file => {
        //                     const fileReader = new FileReader();

        //                     fileReader.onload = function(e) {
        //                         const previewElement = document.createElement('div');
        //                         previewElement.classList.add('mb-2',
        //                             'preview-container');

        //                         if (file.type.startsWith('image/')) {
        //                             previewElement.innerHTML = `
        //                         <img src="${e.target.result}" class="img-fluid" alt="Preview" style="max-height: 145px; border-radius: 15px;" />
        //                         <button type="button" class="btn btn-danger btn-sm remove-btn" onclick="removePreview(this)">Remove</button>
        //                     `;
        //                         } else if (file.type.startsWith('video/')) {
        //                             previewElement.innerHTML = `
        //                         <video controls autoplay loop class="img-fluid" alt="Preview" style="max-height: 142px; border-radius: 15px; width: 91px;">
        //                             <source src="${e.target.result}" type="${file.type}">
        //                         </video>
        //                         <button type="button" class="btn btn-danger btn-sm remove-btn" onclick="removePreview(this)">Remove</button>
        //                     `;
        //                         }

        //                         previewArea.appendChild(previewElement);
        //                     };

        //                     fileReader.readAsDataURL(file);
        //                 });
        //             }
        //         });
        //     }
        // });

        // function removePreview(button, url = null) {
        //     const previewElement = button.parentElement;
        //     const manuallycampaignId = "{{ $campaignAllDetails->id }}";
        //     if (url) {
        //         fetch('{{ route('delete.image') }}', {
        //                 method: 'POST',
        //                 headers: {
        //                     'Content-Type': 'application/json',
        //                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        //                 },
        //                 body: JSON.stringify({
        //                     url: url,
        //                     manuallycampaignId: manuallycampaignId
        //                 })
        //             })
        //             .then(response => response.json())
        //             .then(data => {
        //                 if (data.success) {
        //                     previewElement.remove();
        //                 } else {
        //                     alert('Failed to remove image');
        //                 }
        //             })
        //             .catch(error => {
        //                 console.error('Error:', error);
        //                 alert('Failed to remove image');
        //             });
        //     } else {
        //         previewElement.remove();
        //     }
        // }
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
