@extends('admin.home')
<style>
    .preview-container {
        position: relative;
        overflow: hidden;
        display: inline-block;
        /* Ensure proper alignment */
    }
</style>
@section('contents')
    <div class="row gx-4">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header bg-none fw-bold">
                    Facebook Campaign
                </div>
                <form action="{{ route('new-campaign-manually.update', $campaignAllDetails->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label"> {{ __('Topic Name') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="topic_name"
                                        value="{{ $campaignAllDetails->topic_name }}">
                                    @error('topic_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Strategy') }}<span class="text-danger">*</span></label>
                                    <select class="form-control" id="Strategy" name="strategy">
                                        <option value="">{{ __('Select Strategy') }}</option>
                                        <option value="none"
                                            {{ $campaignAllDetails->strategy == 'none' ? 'selected' : '' }}>
                                            {{ __('None') }} </option>
                                        <option value="st1"
                                            {{ $campaignAllDetails->strategy == 'st1' ? 'selected' : '' }}>
                                            {{ __('ST1') }} </option>
                                        <option value="st2"
                                            {{ $campaignAllDetails->strategy == 'st2' ? 'selected' : '' }}>
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
                                        <option value="a1" {{ $campaignAllDetails->pixel == 'a1' ? 'selected' : '' }}>
                                            {{ __('A1') }} </option>
                                        <option value="a2" {{ $campaignAllDetails->pixel == 'a2' ? 'selected' : '' }}>
                                            {{ __('A2') }} </option>
                                        <option value="a3" {{ $campaignAllDetails->pixel == 'a3' ? 'selected' : '' }}>
                                            {{ __('A3') }} </option>
                                        <option value="a4" {{ $campaignAllDetails->pixel == 'a4' ? 'selected' : '' }}>
                                            {{ __('A4') }} </option>
                                        <option value="a5" {{ $campaignAllDetails->pixel == 'a5' ? 'selected' : '' }}>
                                            {{ __('A5') }} </option>
                                        <option value="a6" {{ $campaignAllDetails->pixel == 'a6' ? 'selected' : '' }}>
                                            {{ __('A6') }} </option>
                                        <option value="a7" {{ $campaignAllDetails->pixel == 'a7' ? 'selected' : '' }}>
                                            {{ __('A7') }} </option>
                                        <option value="a8" {{ $campaignAllDetails->pixel == 'a8' ? 'selected' : '' }}>
                                            {{ __('A8') }} </option>
                                        <option value="a9" {{ $campaignAllDetails->pixel == 'a9' ? 'selected' : '' }}>
                                            {{ __('A9') }} </option>
                                        <option value="a10" {{ $campaignAllDetails->pixel == 'a10' ? 'selected' : '' }}>
                                            {{ __('A10') }} </option>

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
                                            {{ $campaignAllDetails->feed_provide == 'ads' ? 'selected' : '' }}>
                                            {{ __('ADS') }} </option>
                                        <option value="tonic"
                                            {{ $campaignAllDetails->feed_provide == 'tonic' ? 'selected' : '' }}>
                                            {{ __('Tonic') }} </option>
                                        <option value="system1"
                                            {{ $campaignAllDetails->feed_provide == 'system1' ? 'selected' : '' }}>
                                            {{ __('System1') }} </option>
                                        <option value="sedo"
                                            {{ $campaignAllDetails->feed_provide == 'sedo' ? 'selected' : '' }}>
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
                                        value="{{ $campaignAllDetails->custom_field ?? 'MB5' }}">
                                    @error('custom_field')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label"> {{ __('Campaign Name') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="campaign_name"
                                        placeholder="Enter Campaign Name" value="{{ $campaignAllDetails->campaign_name }}">
                                    @error('campaign_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Group') }}<span class="text-danger">*</span></label>
                                    <select class="form-control" id="groupSelect" name="group">
                                        <option value="">Select Group</option>
                                        @foreach ($uniqueGroups as $group)
                                            <option value="{{ $group->group }}"
                                                {{ $group->group == $campaignAllDetails->group ? 'selected' : '' }}>
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
                                    <label class="form-label">{{ __('Country') }}<span class="text-danger">*</span></label>
                                    <select class="form-control" id="countrySelect" name="country">
                                        <option value="">Select Country</option>
                                        @foreach ($allCountries as $country)
                                            <option value="{{ $country->name }}"
                                                {{ $country->name == $campaignAllDetails->country_name ? 'selected' : '' }}>
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
                                    <label class="form-label">{{ __('Short Code') }}<span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" id="shortCodeSelect" name="short_code">
                                        <option value="">Select Short Code</option>
                                    </select>
                                    @error('short_code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Language') }}<span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" id="languageSelect" name="language">
                                        <option value="">Select Language</option>
                                    </select>
                                    @error('language')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Upload Image/Video') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="files[]" multiple id="fileInput"
                                        value="{{ $campaignAllDetails->image }}">
                                    @error('files')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <div id="previewArea" class="row"></div>
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-4">
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
                                                <div class="mb-2">
                                                    @if (preg_match('/\.(mp4|webm|ogg)$/i', $image))
                                                        <video src="{{ $image }}" controls class="img-fluid"
                                                            style="max-height: 115px; border-radius: 15px;"></video>
                                                    @else
                                                        <img src="{{ $image }}" class="img-fluid"
                                                            style="max-height: 115px;border-radius: 15px;">
                                                    @endif
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div> --}}

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
                                                            style="max-height: 115px; border-radius: 15px;">
                                                    @endif
                                                    <button type="button" class="btn btn-danger btn-sm remove-btn"
                                                        onclick="removePreview(this, '{{ $image }}')">Remove</button>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>



                            {{-- <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Image') }}<span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="image"
                                        value="{{ $campaignAllDetails->image }}">
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div> --}}
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Offer URL') }}<span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" name="offer_url" placeholder="Enter Offer URL">{{ $campaignAllDetails->offer_url }}</textarea>
                                    @error('offer_url')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Headline') }}<span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" name="headline" placeholder="Enter Headline" rows="7">{{ $campaignAllDetails->headlines }}</textarea>
                                    @error('headline')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Primary Text') }}<span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" name="primary_text" rows="7" placeholder="Enter Primary Text">{{ $campaignAllDetails->primary_text }}</textarea>
                                    @error('primary_text')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-end ">
                                    <button type="submit"
                                        class="btn btn-primary">{{ __('Add Manual Campaign') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection
    @push('scripts')
        <script>
            // $(document).ready(function() {
            //     var currentCountry = '{{ old('country', $campaignAllDetails->country_name) }}';
            //     var currentShortCode = '{{ old('short_code', $campaignAllDetails->short_code) }}';
            //     var currentLanguage = '{{ old('language', $campaignAllDetails->language) }}';

            //     // Function to populate country dropdown based on selected group
            //     function populateCountries(group) {
            //         if (group) {
            //             $.ajax({
            //                 url: '{{ route('getCountriesByGroup') }}',
            //                 type: 'GET',
            //                 data: {
            //                     group: group
            //                 },
            //                 success: function(response) {
            //                     $('#countrySelect').empty();
            //                     $.each(response, function(index, country) {
            //                         console.log(country);

            //                         $('#countrySelect').append(
            //                             '<option value="' + country.name +
            //                             '" data-shortcode="' + country.short_code +
            //                             '" data-language="' + country.language + '"' +
            //                             (country.name === currentCountry ? ' selected' : '') +
            //                             '>' + country.name +
            //                             '</option>'
            //                         );
            //                     });
            //                     // Preselect country if available
            //                     var selectedCountry =
            //                         '{{ old('country', $campaignAllDetails->country_name) }}';
            //                     $('#countrySelect').val(selectedCountry).trigger('change');
            //                 }
            //             });
            //         } else {
            //             $('#countrySelect').empty().append('<option value="">Select Country</option>');
            //         }
            //     }

            //     // Handle country change event
            //     $('#countrySelect').on('change', function() {
            //         var country = $(this).val();
            //         // Call the populateShortCodesAndLanguagesedit function on country change
            //         if (country !== currentCountry) {
            //             populateShortCodesAndLanguagesedit(country);
            //         } else {
            //             populateShortCodesAndLanguages(country);
            //         }
            //     });

            //     // Function to populate short codes and languages based on selected country
            //     function populateShortCodesAndLanguagesedit(country) {
            //         if (country) {
            //             $.ajax({
            //                 url: '{{ route('getCountryDetails') }}',
            //                 type: 'GET',
            //                 data: {
            //                     country: country
            //                 },
            //                 success: function(response) {
            //                     console.log('ddd');

            //                     currentShortCode = response.short_code;
            //                     currentLanguage = response.language;

            //                     // Populate Short Code
            //                     $('#shortCodeSelect').empty();
            //                     $.each(response.all_short_codes, function(index, short_code) {
            //                         $('#shortCodeSelect').append(
            //                             '<option value="' + short_code +
            //                             '"' + (short_code === currentShortCode ? ' selected' :
            //                                 '') +
            //                             '>' + short_code + '</option>'
            //                         );
            //                     });

            //                     // Populate Language
            //                     $('#languageSelect').empty();
            //                     $.each(response.all_languages, function(index, language) {
            //                         $('#languageSelect').append(
            //                             '<option value="' + language + '"' +
            //                             (language === currentLanguage ? ' selected' : '') +
            //                             '>' + language + '</option>'
            //                         );
            //                     });
            //                 }
            //             });
            //         } else {
            //             $('#shortCodeSelect').empty().append('<option value="">Select Short Code</option>');
            //             $('#languageSelect').empty().append('<option value="">Select Language</option>');
            //         }
            //     }

            //     // Function to populate short codes and languages based on selected country (for initial load)
            //     function populateShortCodesAndLanguages(country) {
            //         if (country) {
            //             $.ajax({
            //                 url: '{{ route('getCountryDetails') }}',
            //                 type: 'GET',
            //                 data: {
            //                     country: country
            //                 },
            //                 success: function(response) {
            //                     // currentShortCode = response.short_code;
            //                     // currentLanguage = response.language;

            //                     // Populate Short Code
            //                     $('#shortCodeSelect').empty();
            //                     $.each(response.all_short_codes, function(index, short_code) {
            //                         $('#shortCodeSelect').append(
            //                             '<option value="' + short_code +
            //                             '"' + (short_code === currentShortCode ? ' selected' :
            //                                 '') +
            //                             '>' + short_code + '</option>'
            //                         );
            //                     });

            //                     // Populate Language
            //                     $('#languageSelect').empty();
            //                     $.each(response.all_languages, function(index, language) {
            //                         $('#languageSelect').append(
            //                             '<option value="' + language + '"' +
            //                             (language === currentLanguage ? ' selected' : '') +
            //                             '>' + language + '</option>'
            //                         );
            //                     });
            //                 }
            //             });
            //         } else {
            //             $('#shortCodeSelect').empty().append('<option value="">Select Short Code</option>');
            //             $('#languageSelect').empty().append('<option value="">Select Language</option>');
            //         }
            //     }

            //     // On group change, populate countries and preselect the current country
            //     $('#groupSelect').on('change', function() {
            //         var group = $(this).val();
            //         populateCountries(group);
            //     });

            //     // Trigger group change to prepopulate countries on page load
            //     var initialGroup = '{{ old('group', $campaignAllDetails->group) }}';
            //     if (initialGroup) {
            //         $('#groupSelect').val(initialGroup).trigger('change');
            //     } else if (currentCountry) {
            //         populateShortCodesAndLanguages(currentCountry); // Call this function on page load
            //     }
            // });
            $(document).ready(function() {
                var currentCountry = '{{ old('country', $campaignAllDetails->country_name) }}';
                var currentShortCode = '{{ old('short_code', $campaignAllDetails->short_code) }}';
                var currentLanguage = '{{ old('language', $campaignAllDetails->language) }}';

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
                                });
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
                                $.each(response.all_short_codes, function(index, short_code) {
                                    $('#shortCodeSelect').append(
                                        '<option value="' + short_code +
                                        '"' + (short_code === currentShortCode ? ' selected' :
                                            '') +
                                        '>' + short_code + '</option>'
                                    );
                                });

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
                                // currentShortCode = response.short_code;
                                // currentLanguage = response.language;

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
                var initialGroup = '{{ old('group', $campaignAllDetails->group) }}';
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
                const existingImages = @json($campaignAllDetails->image ?? '[]');
                const imagesArray = Array.isArray(existingImages) ? existingImages : [];

                if (fileInput) {
                    // Function to render existing images/videos
                    function renderExistingPreviews() {
                        if (imagesArray.length > 0) {
                            imagesArray.forEach(url => {
                                const previewElement = document.createElement('div');
                                previewElement.classList.add('col-md-3', 'mb-3', 'preview-container');

                                if (url.match(/\.(mp4|webm|ogg)$/i)) {
                                    previewElement.innerHTML = `
                            <video controls autoplay loop class="img-fluid" alt="Preview">
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
                                    previewElement.classList.add('col-md-3', 'mb-3',
                                        'preview-container');

                                    if (file.type.startsWith('image/')) {
                                        previewElement.innerHTML = `
                                <img src="${e.target.result}" class="img-fluid" alt="Preview" style="height:75px !important; border-radius: 15px;" />
                                <button type="button" class="btn btn-danger btn-sm mt-2 remove-btn" onclick="removePreview(this)">Remove</button>
                            `;
                                    } else if (file.type.startsWith('video/')) {
                                        previewElement.innerHTML = `
                                <video controls autoplay loop class="img-fluid" alt="Preview">
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
                                manuallycampaignId : manuallycampaignId
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
            // document.addEventListener('DOMContentLoaded', function() {
            //     const fileInput = document.getElementById('fileInput');

            //     // Parse existing images from the server
            //     const existingImages = @json($campaignAllDetails->image ?? '[]');

            //     // Ensure existingImages is an array
            //     const imagesArray = Array.isArray(existingImages) ? existingImages : [];

            //     const previewArea = document.getElementById('previewArea');

            //     if (fileInput) {

            //         // Function to render existing images/videos
            //         function renderExistingPreviews() {
            //             if (imagesArray.length > 0) {
            //                 imagesArray.forEach(url => {
            //                     const previewElement = document.createElement('div');
            //                     previewElement.classList.add('col-md-3', 'mb-3');

            //                     if (url.match(/\.(mp4|webm|ogg)$/i)) {
            //                         previewElement.innerHTML = `
    //                 <video controls autoplay loop class="img-fluid" alt="Preview">
    //                     <source src="${url}" type="video/mp4">
    //                 </video>
    //                 <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removePreview(this)">Remove</button>
    //             `;
            //                     } else {
            //                         previewElement.innerHTML = `
    //                 <img src="${url}" class="img-fluid" alt="Preview" />
    //                 <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removePreview(this)">Remove</button>
    //             `;
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
            //                         previewElement.classList.add('col-md-3', 'mb-3');

            //                         if (file.type.startsWith('image/')) {
            //                             previewElement.innerHTML = `
    //                     <img src="${e.target.result}" class="img-fluid" alt="Preview" style="height:75px !important; border-radius: 15px;" />
    //                     <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removePreview(this)">Remove</button>
    //                 `;
            //                         } else if (file.type.startsWith('video/')) {
            //                             previewElement.innerHTML = `
    //                     <video controls autoplay loop class="img-fluid" alt="Preview">
    //                         <source src="${e.target.result}" type="${file.type}">
    //                     </video>
    //                     <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removePreview(this)">Remove</button>
    //                 `;
            //                         }

            //                         previewArea.appendChild(previewElement);
            //                     };

            //                     fileReader.readAsDataURL(file);
            //                 });
            //             }
            //         });
            //     }
            // });

            // function removePreview(button) {
            //     const previewElement = button.parentElement;
            //     previewElement.remove();
            // }


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
                            `${topicNameInput.value}-${strategySelect.value}-${pixelSelect.value}-${feedProvideSelect.value}-${customFieldInput.value}`;
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
        </script>
    @endpush
