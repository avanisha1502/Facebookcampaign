@extends('admin.home')

@section('contents')
    <div class="d-flex align-items-center mb-3">
        <div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{ __('PAGES') }}</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('suboffer.index', $subOffer->offer_id) }}">{{ __('Sub Offer') }}
                    </a></li>
                <li class="breadcrumb-item active">{{ __('Edit Sub Offer') }}</li>
            </ul>
        </div>
    </div>

    <div class="row gx-4">
        <div class="col-xl-12">
            <form action="{{ route('suboffer.update', $subOffer->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card mb-4">
                    <div class="card-header bg-none fw-bold">
                        {{ 'Edit Sub Offer' }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label"> {{ __('Offer Name') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="topic_name"
                                        value="{{ $subOffer->offer_sub_topic_name }}">
                                    @error('topic_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Strategy') }}<span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" id="Strategy" name="strategy">
                                        <option value="">{{ __('Select Strategy') }}</option>
                                        <option value="none"
                                            {{ $subOffer->offer_sub_strategy == 'none' ? 'selected' : '' }}>
                                            {{ __('None') }} </option>
                                        <option value="st1"
                                            {{ $subOffer->offer_sub_strategy == 'st1' ? 'selected' : '' }}>
                                            {{ __('ST1') }} </option>
                                        <option value="st2"
                                            {{ $subOffer->offer_sub_strategy == 'st2' ? 'selected' : '' }}>
                                            {{ __('ST2') }} </option>
                                    </select>
                                    @error('strategy')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Pixel') }}<span class="text-danger">*</span></label>
                                    <select class="form-control" id="Pixel" name="pixel">
                                        <option value="">{{ __('Select Pixel') }}</option>
                                        <option value="a1" {{ $subOffer->offer_sub_pixel == 'a1' ? 'selected' : '' }}>
                                            {{ __('A1 (Healthy)') }} </option>
                                        <option value="a2" {{ $subOffer->offer_sub_pixel == 'a2' ? 'selected' : '' }}>
                                            {{ __('A2 (Jobs)') }} </option>
                                        <option value="a3" {{ $subOffer->offer_sub_pixel == 'a3' ? 'selected' : '' }}>
                                            {{ __('A3 (Service)') }} </option>
                                        <option value="a4" {{ $subOffer->offer_sub_pixel == 'a4' ? 'selected' : '' }}>
                                            {{ __('A4 (Auto)') }} </option>
                                        <option value="a5" {{ $subOffer->offer_sub_pixel == 'a5' ? 'selected' : '' }}>
                                            {{ __('A5 (Home&Garden)') }} </option>
                                        <option value="a6" {{ $subOffer->offer_sub_pixel == 'a6' ? 'selected' : '' }}>
                                            {{ __('A6 (Other)') }} </option>
                                        <option value="a7" {{ $subOffer->offer_sub_pixel == 'a7' ? 'selected' : '' }}>
                                            {{ __('A7 (Dating)') }} </option>
                                        <option value="a8" {{ $subOffer->offer_sub_pixel == 'a8' ? 'selected' : '' }}>
                                            {{ __('A8 (Eduction)') }} </option>
                                        <option value="a9" {{ $subOffer->offer_sub_pixel == 'a9' ? 'selected' : '' }}>
                                            {{ __('A9 (Finance)') }} </option>
                                        <option value="a10" {{ $subOffer->offer_sub_pixel == 'a10' ? 'selected' : '' }}>
                                            {{ __('A10 (Insurance)') }} </option>

                                    </select>
                                    @error('pixel')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Feed Provide') }}<span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" id="FeedProvide" name="feed_provide">
                                        <option value="">{{ __('Select Feed Provide') }}</option>
                                        <option value="ads"
                                            {{ $subOffer->offer_sub_feed_provide == 'ads' ? 'selected' : '' }}>
                                            {{ __('ADS') }} </option>
                                        <option value="tonic"
                                            {{ $subOffer->offer_sub_feed_provide == 'tonic' ? 'selected' : '' }}>
                                            {{ __('Tonic') }} </option>
                                        <option value="system1"
                                            {{ $subOffer->offer_sub_feed_provide == 'system1' ? 'selected' : '' }}>
                                            {{ __('System1') }} </option>
                                        <option value="sedo"
                                            {{ $subOffer->offer_sub_feed_provide == 'sedo' ? 'selected' : '' }}>
                                            {{ __('Sedo') }} </option>
                                    </select>
                                    @error('feed_provide')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Custom Field') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="custom_field" class="form-control"
                                        placeholder="Enter Custom Field"
                                        value="{{ $subOffer->offer_sub_custom_field ?? 'MB5' }}">
                                    @error('custom_field')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('Group') }}<span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-6 text-align-end mb-1">
                                            <a class="btn btn-primary btn-sm" href="#" data-size="md"
                                                data-ajax-popup="true" data-url="{{ route('AddCountries.create') }}"
                                                data-title="{{ __('Add New Group  ') }}">
                                                <i class="fa fa-plus-circle fa-fw "></i> </a>
                                        </div>
                                    </div>
                                    <select class="form-control" id="groupSelect" name="group">
                                        <option value="">Select Group</option>
                                        @foreach ($uniqueGroups as $group)
                                            <option value="{{ $group->group }}"
                                                {{ $group->group == $subOffer->offer_sub_group ? 'selected' : '' }}>
                                                {{ $group->group }}</option>
                                        @endforeach
                                    </select>
                                    @error('group')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('Country') }}<span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-6 text-align-end mb-1">
                                            <a class="btn btn-primary btn-sm" href="#" data-size="md"
                                                data-ajax-popup="true" data-url="{{ route('AddCountries.create') }}"
                                                data-title="{{ __('Add New Country') }}">
                                                <i class="fa fa-plus-circle fa-fw "></i> </a>
                                        </div>
                                    </div>
                                    <select class="form-control" id="countrySelect" name="country">
                                        <option value="">Select Country</option>
                                        @foreach ($allCountries as $country)
                                            <option value="{{ $country->name }}"
                                                {{ $country->name == $subOffer->offer_sub_country_name ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('country')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('Short Code') }}<span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-6 text-align-end mb-1">
                                            <a class="btn btn-primary btn-sm" href="#" data-size="md"
                                                data-ajax-popup="true" data-url="{{ route('AddCountries.create') }}"
                                                data-title="{{ __('Add New Short Code') }}">
                                                <i class="fa fa-plus-circle fa-fw "></i> </a>
                                        </div>
                                    </div>
                                    <select class="form-control" id="shortCodeSelect" name="short_code">
                                        <option value="">Select Short Code</option>
                                    </select>
                                    @error('short_code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('Language') }}<span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-6 text-align-end mb-1">
                                            <a class="btn btn-primary btn-sm" href="#" data-size="md"
                                                data-ajax-popup="true" data-url="{{ route('AddCountries.create') }}"
                                                data-title="{{ __('Add New Language') }}">
                                                <i class="fa fa-plus-circle fa-fw "></i> </a>
                                        </div>
                                    </div>
                                    <select class="form-control" id="languageSelect" name="language">
                                        <option value="">Select Language</option>
                                    </select>
                                    @error('language')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label"> {{ __('Campaign Name') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="campaign_name"
                                        value="{{ $subOffer->offer_sub_campaign_name }}">
                                    @error('campaign_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-end mb-3">
                            <button type="submit" class="btn btn-primary mr-5">{{ __('Update Sub Offer') }}</button>
                        </div>
                    </div>
                </div>
                {{-- <div class="card mb-4">
                    <div class="card-header bg-none fw-bold row">
                        <div class="col-md-6 align-items-center d-flex">
                            {{ __('Ads Section') }}
                        </div>
                        <div class="col-md-6 text-align-end">
                            @if (
                                $subOffer->offer_sub_headlines != null &&
                                    $subOffer->offer_sub_primary_text != null &&
                                    $subOffer->offer_sub_description != null)
                                <a href="javascript:void(0)"
                                    class="btn btn-warning me-2 generate-button show_btn mb-2 text-white"
                                    id="generate-{{ $subOffer->id }}" onclick="generateContent({{ $subOffer->id }})">
                                    <i class="fa-solid fa-audio-description"></i>
                                    {{ __('Regenerate Content') }}
                                </a>
                            @else
                                <a href="javascript:void(0)" class="btn btn-success me-2 generate-button show_btn mb-2"
                                    id="generate-{{ $subOffer->id }}" onclick="generateContent({{ $subOffer->id }})">
                                    <i class="fa-solid fa-audio-description"></i>
                                    {{ __('Generate Content') }} </a>
                            @endif

                            <div id="loader-{{ $subOffer->id }}"
                                class="loaderdd-{{ $subOffer->id }} buttonload btn btn-primary me-2 hidden mb-2">
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
                                        @if (!empty($subOffer->offer_sub_image))
                                            @php
                                                $images = json_decode($subOffer->offer_sub_image);
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
                                    <input type="text" class="form-control" name="offer_url"
                                        value="{{ $subOffer->offer_sub_offer_url }}">
                                    @error('offer_url')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Headline') }}<span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" name="headline" rows="3" id="sub_headline-{{ $subOffer->id }}">{{ $subOffer->offer_sub_headlines }}</textarea>
                                    @error('headline')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Primary Text') }}<span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" name="primary_text" rows="3" id="sub_primary-text-{{ $subOffer->id }}">{{ $subOffer->offer_sub_primary_text }}</textarea>
                                    @error('primary_text')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Description') }}<span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" name="description" rows="3" id="sub_description-{{ $subOffer->id }}">{{ $subOffer->offer_sub_description }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                </div> --}}
                
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var currentCountry = '{{ old('country', $subOffer->offer_sub_country_name) }}';
            var currentShortCode = '{{ old('short_code', $subOffer->offer_sub_short_code) }}';
            var currentLanguage = '{{ old('language', $subOffer->offer_sub_language) }}';

            // Function to populate country dropdown based on selected group
            function populateCountries(group) {
                if (group) {
                    $.ajax({
                        url: '{{ route('getCountriesByGroup') }}',
                        type: 'GET',
                        data: {
                            group: group
                        },
                        success: function(response) {
                            $('#countrySelect').empty();
                            $('#shortCodeSelect').empty();
                            $('#languageSelect').empty();
                            var firstShortCode = null;
                            $.each(response, function(index, country) {
                                $('#countrySelect').append(
                                    '<option value="' + country.name +
                                    '" data-shortcode="' + country.short_code +
                                    '" data-language="' + country.language + '"' +
                                    (country.name === currentCountry ? ' selected' : '') +
                                    '>' + country.name +
                                    '</option>'
                                );

                                $('#shortCodeSelect').append(
                                    '<option value="' + country.short_code +
                                    '"' + (country.short_code === currentShortCode ?
                                        ' selected' :
                                        '') +
                                    '>' + country.short_code + '</option>'
                                );

                                $('#languageSelect').append(
                                    '<option value="' + country.language + '"' +
                                    (country.language === currentLanguage ? ' selected' :
                                        '') +
                                    '>' + country.language + '</option>'
                                );

                                if (firstShortCode === null) {
                                    firstShortCode = country.short_code;
                                }
                            });

                            if (firstShortCode) {
                                $('#shortCodeSelect').val(
                                    firstShortCode
                                ); // Automatically select the first short code

                                // Trigger a change event to update the campaign name
                                $('#shortCodeSelect').trigger('change');
                            }
                            // Preselect country and trigger change event to populate short codes and languages
                            // $('#countrySelect').val(currentCountry).trigger('change');
                        }
                    });
                } else {
                    $('#countrySelect').empty().append('<option value="">Select Country</option>');
                    $('#shortCodeSelect').empty().append('<option value="">Select Short Code</option>');
                    $('#languageSelect').empty().append('<option value="">Select Language</option>');
                }
            }

            $('#countrySelect').on('change', function() {
                var country = $(this).val();
                // Call the populateShortCodesAndLanguagesedit function on country change
                if (country !== currentCountry) {
                    populateShortCodesAndLanguagesedit(country);
                } else {
                    populateShortCodesAndLanguages(country);
                }
            });

            // Function to populate short codes and languages based on selected country
            function populateShortCodesAndLanguagesedit(country) {
                if (country) {
                    $.ajax({
                        url: '{{ route('getCountryDetails') }}',
                        type: 'GET',
                        data: {
                            country: country
                        },
                        success: function(response) {
                            currentShortCode = response.short_code;
                            currentLanguage = response.language;

                            // Populate Short Code
                            $('#shortCodeSelect').empty();
                            $('#languageSelect').empty();
                            var firstShortCode = null;
                            $.each(response.all_short_codes, function(index, short_code) {
                                $('#shortCodeSelect').append(
                                    '<option value="' + short_code +
                                    '"' + (short_code === currentShortCode ? ' selected' :
                                        '') +
                                    '>' + short_code + '</option>'
                                );

                                if (firstShortCode === null) {
                                    firstShortCode = response.short_code;
                                }
                            });
                            if (firstShortCode) {
                                $('#shortCodeSelect').val(
                                    firstShortCode
                                ); // Automatically select the first short code

                                // Trigger a change event to update the campaign name
                                $('#shortCodeSelect').trigger('change');
                            }
                            // Populate Language
                            $.each(response.all_languages, function(index, language) {
                                $('#languageSelect').append(
                                    '<option value="' + language + '"' +
                                    (language === currentLanguage ? ' selected' : '') +
                                    '>' + language + '</option>'
                                );
                            });
                        }
                    });
                } else {
                    $('#shortCodeSelect').empty().append('<option value="">Select Short Code</option>');
                    $('#languageSelect').empty().append('<option value="">Select Language</option>');
                }
            }

            function populateShortCodesAndLanguages(country) {
                if (country) {
                    $.ajax({
                        url: '{{ route('getCountryDetails') }}',
                        type: 'GET',
                        data: {
                            country: country
                        },
                        success: function(response) {
                            // Populate Short Code
                            $('#shortCodeSelect').empty();
                            $.each(response.all_short_codes, function(index, short_code) {
                                $('#shortCodeSelect').append(
                                    '<option value="' + short_code +
                                    '"' + (short_code === currentShortCode ? ' selected' :
                                        '') +
                                    '>' + short_code + '</option>'
                                );
                            });

                            // Populate Language
                            $('#languageSelect').empty();
                            $.each(response.all_languages, function(index, language) {
                                $('#languageSelect').append(
                                    '<option value="' + language + '"' +
                                    (language === currentLanguage ? ' selected' : '') +
                                    '>' + language + '</option>'
                                );
                            });
                        }
                    });
                } else {
                    $('#shortCodeSelect').empty().append('<option value="">Select Short Code</option>');
                    $('#languageSelect').empty().append('<option value="">Select Language</option>');
                }
            }

            // On group change, populate countries and preselect the current country
            $('#groupSelect').on('change', function() {
                var group = $(this).val();
                populateCountries(group);
            });

            // Trigger group change to prepopulate countries on page load
            var initialGroup = '{{ old('group', $subOffer->offer_sub_group) }}';
            if (initialGroup) {
                $('#groupSelect').val(initialGroup).trigger('change');
            } else if (currentCountry) {
                populateShortCodesAndLanguages(currentCountry); // Call this function on page load
            }
        });


        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('fileInput');
            const previewArea = document.getElementById('previewArea');

            // Parse existing images from the server
            const existingImages = @json($subOffer->image ?? '[]');
            const imagesArray = Array.isArray(existingImages) ? existingImages : [];

            if (fileInput) {
                // Function to render existing images/videos
                function renderExistingPreviews() {
                    if (imagesArray.length > 0) {
                        imagesArray.forEach(url => {
                            const previewElement = document.createElement('div');
                            previewElement.classList.add('mb-3', 'preview-container');

                            if (url.match(/\.(mp4|webm|ogg)$/i)) {
                                previewElement.innerHTML = `
                            <video controls autoplay loop class="img-fluid" alt="Preview" style="max-height: 142px; border-radius: 15px; width: 91px;">
                                <source src="${url}" type="video/mp4">
                            </video>
                            <button type="button" class="btn btn-danger btn-sm remove-btn" onclick="removePreview(this, '${url}')">Remove</button>
                        `;
                            } else {
                                previewElement.innerHTML = `
                            <img src="${url}" class="img-fluid" alt="Preview" style="max-height: 145px; border-radius: 15px;"/>
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
                                previewElement.classList.add('mb-3',
                                    'preview-container');

                                if (file.type.startsWith('image/')) {
                                    previewElement.innerHTML = `
                                <img src="${e.target.result}" class="img-fluid" alt="Preview" style="max-height: 145px; border-radius: 15px;" />
                                <button type="button" class="btn btn-danger btn-sm mt-2 remove-btn" onclick="removePreview(this)">Remove</button>
                            `;
                                } else if (file.type.startsWith('video/')) {
                                    previewElement.innerHTML = `
                                <video controls autoplay loop class="img-fluid" alt="Preview" style="max-height: 142px; border-radius: 15px; width: 91px;">
                                    <source src="${e.target.result}" type="${file.type}">
                                </video>
                                <button type="button" class="btn btn-danger btn-sm mt-2 remove-btn" onclick="removePreview(this)">Remove</button>
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
            const manuallycampaignId = "{{ $subOffer->id }}";
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

        document.addEventListener('DOMContentLoaded', function() {
            const topicNameInput = document.querySelector('input[name="topic_name"]');
            const strategySelect = document.querySelector('select[name="strategy"]');
            const pixelSelect = document.querySelector('select[name="pixel"]');
            const feedProvideSelect = document.querySelector('select[name="feed_provide"]');
            const customFieldInput = document.querySelector('input[name="custom_field"]');
            const campaignNameInput = document.querySelector('input[name="campaign_name"]');

            if (topicNameInput && strategySelect && pixelSelect && feedProvideSelect && customFieldInput &&
                campaignNameInput) {
                const updateCampaignName = () => {
                    campaignNameInput.value =
                        `${topicNameInput.value} - ${strategySelect.value} - ${pixelSelect.value} - ${feedProvideSelect.value} - ${customFieldInput.value}`;
                };

                // Initialize the campaign name on page load
                updateCampaignName();

                // Add event listeners to update the campaign name when inputs change
                topicNameInput.addEventListener('input', updateCampaignName);
                strategySelect.addEventListener('change', updateCampaignName);
                pixelSelect.addEventListener('change', updateCampaignName);
                feedProvideSelect.addEventListener('change', updateCampaignName);
                customFieldInput.addEventListener('input', updateCampaignName);
            }
        });

        $(document).ready(function() {
            // Function to update the campaign name
            function updateCampaignName(subOfferCount) {
                const topicNameInput = $('input[name="topic_name"]').val();
                const strategySelect = $('select[name="strategy"]').val();
                const pixelSelect = $('select[name="pixel"]').val();
                const feedProvideSelect = $('select[name="feed_provide"]').val();
                const customFieldInput = $('input[name="custom_field"]').val();
                const groupFieldInput = $('#groupSelect').val();
                const shortcodeFieldInput = $('#shortCodeSelect').val();
                const campaignNameInput = $('input[name="campaign_name"]');
                
                const capitalizeWords = (str) => {
                    return str.split(' ')
                        .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
                        .join(' ');
                };

                const topicName = capitalizeWords(topicNameInput);
                const strategy = strategySelect.toUpperCase();
                const pixel = pixelSelect.toUpperCase();
                const feedProvide = feedProvideSelect.toUpperCase();
                const customField = customFieldInput.toUpperCase();
                const groupProvide = `[${groupFieldInput.toUpperCase()}]`;
                const shortProvide = `[${shortcodeFieldInput.toUpperCase()}]`;
                // const offerCount = isNaN(subOfferCount) ? 1 : subOfferCount ;
                const offerCount = isNaN(subOfferCount) ? 1 : subOfferCount;

                console.log(offerCount, 'news');
                console.log('subOfferCount' , subOfferCount);
                

                campaignNameInput.val(
                    `${topicName} - [${offerCount}] - ${shortProvide} - ${groupProvide} - ${strategy} - ${pixel} - ${feedProvide} - ${customField}`
                );
            }

            // Handle short code selection change
            $('#shortCodeSelect').on('change', function() {
                updateCampaignName();
            });

            // Initialize campaign name on page load if fields have values
            if ($('input[name="topic_name"]').val() || $('#groupSelect').val() || $('#shortCodeSelect').val() || $(
                    'countrySelect').val()) {
                updateCampaignName();
            }

            // Also update campaign name if any other fields change
            $('select[name="strategy"], select[name="pixel"], select[name="feed_provide"], input[name="custom_field"]')
                .on('change input', function() {
                    updateCampaignName();
                });

            $.ajax({
                url: `{{ route('subofferedits.count', ['id' => $subOffer->id]) }}`,
                method: 'GET',
                success: function(response) {
                    updateCampaignName(response.count.sequence);
                }
            });

            $('select[name="strategy"], select[name="pixel"], select[name="feed_provide"], input[name="custom_field"] , input[name="topic_name"], #groupSelect, #shortCodeSelect')
                .on('change input', function() {
                    $.ajax({
                        url: `{{ route('subofferedits.count', ['id' => $subOffer->id]) }}`,
                        method: 'GET',
                        success: function(response) {
                            updateCampaignName(response.count);
                        }
                    });
                });
        });

        const baseUrl = @json(route('generate-headlines-manual-suboffer', ['id' => $subOffer->id]));

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
                    document.getElementById(`sub_headline-${campaignId}`).value = data.headline || '';
                    document.getElementById(`sub_primary-text-${campaignId}`).value = data.primary_text || '';
                    document.getElementById(`sub_description-${campaignId}`).value = data.description || '';
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
