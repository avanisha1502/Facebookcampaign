@extends('admin.home')
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
                            <div class="col-md-3">
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
                            <div class="col-md-3">
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
                            <div class="col-md-3">
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
                            <div class="col-md-3">
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
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Upload Image/Video') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="files[]" multiple id="fileInput" value="{{ $campaignAllDetails->image }}">
                                    @error('files')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <div id="previewArea" class="row"></div>
                                </div>
                            </div>
                            
                            <!--<div class="col-md-4">-->
                            <!--    <div class="mb-3">-->
                            <!--        <label class="form-label">{{ __('Image') }}<span class="text-danger">*</span></label>-->
                            <!--        <input type="file" class="form-control" name="image"-->
                            <!--            value="{{ $campaignAllDetails->image }}">-->
                            <!--        @error('image')-->
                            <!--            <span class="text-danger">{{ $message }}</span>-->
                            <!--        @enderror-->
                            <!--    </div>-->
                            <!--</div>-->
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
                                    <textarea class="form-control" name="primary_text" rows="7">{{ $campaignAllDetails->primary_text }}</textarea>
                                    @error('primary_text')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-end ">
                                    <button type="submit" class="btn btn-primary">{{ __('Add Manual Campaign') }}</button>
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
                                $('#countrySelect').empty().append();
                                $.each(response, function(index, country) {
                                    $('#countrySelect').append(
                                        '<option value="' + country.name +
                                        '" data-shortcode="' + country.short_code +
                                        '" data-language="' + country.language + '"' +
                                        (country.name === currentCountry ? ' selected' : '') +
                                        '>' + country.name +
                                        '</option>'
                                    );
                                });
                                // Preselect country if available
                                var selectedCountry =
                                    '{{ old('country', $campaignAllDetails->country_name) }}';
                                $('#countrySelect').val(selectedCountry).trigger('change');
                            }
                        });
                    } else {
                        $('#countrySelect').empty().append('<option value="">Select Country</option>');
                    }
                }

                // Handle country change event
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
                                console.log('ddd');
                                
                                currentShortCode = response.short_code;
                                currentLanguage = response.language;

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

                // Function to populate short codes and languages based on selected country (for initial load)
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

                if (fileInput) {
                    console.log('dddddd');
                    
                    fileInput.addEventListener('change', function(event) {
                        const previewArea = document.getElementById('previewArea');
                        previewArea.innerHTML = ''; // Clear the previous previews

                        const files = event.target.files;
                        if (files) {
                            Array.from(files).forEach(file => {
                                const fileReader = new FileReader();

                                fileReader.onload = function(e) {
                                    const previewElement = document.createElement('div');
                                    previewElement.classList.add('col-md-3', 'mb-3');

                                    if (file.type.startsWith('image/')) {
                                        previewElement.innerHTML = `
                                <img src="${e.target.result}" class="img-fluid" alt="Preview" />
                                <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removePreview(this)">Remove</button>
                            `;
                                    } else if (file.type.startsWith('video/')) {
                                        previewElement.innerHTML = `
                                <video controls autoplay loop class="img-fluid" alt="Preview">
                                    <source src="${e.target.result}" type="${file.type}">
                                </video>
                                <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removePreview(this)">Remove</button>
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

            function removePreview(button) {
                const previewElement = button.parentElement;
                previewElement.remove();
            }
        </script>
    @endpush
