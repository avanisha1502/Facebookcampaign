@extends('admin.home')

@section('contents')
    <div class="row gx-4">
        <div class="col-xl-12">
            {{-- <div class="card mb-4"> --}}
            {{-- <div class="card-header bg-none fw-bold">
                    {{ __('Manual Campaign Add') }}
                </div> --}}
            <form action="{{ route('new-campaign-manually.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card mb-4">
                    <div class="card-header bg-none fw-bold">
                        {{ __('Manual Campaign Add') }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label"> {{ __('Offer Name') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="topic_name"
                                        placeholder="Enter Offer Name">
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
                                        <option name="none" value="none"> {{ __('None') }} </option>
                                        <option name="st1" value="st1"> {{ __('ST1') }} </option>
                                        <option name="st2" value="st2"> {{ __('ST2') }} </option>
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
                                        <option name="a1" value="a1"> {{ __('A1 (Healthy)') }} </option>
                                        <option name="a2" value="a2"> {{ __('A2 (Jobs)') }} </option>
                                        <option name="a3" value="a3"> {{ __('A3 (Service)') }} </option>
                                        <option name="a4" value="a4"> {{ __('A4 (Auto)') }} </option>
                                        <option name="a5" value="a5"> {{ __('A5 (Home&Garden)') }} </option>
                                        <option name="a6" value="a6"> {{ __('A6 (Other)') }} </option>
                                        <option name="a7" value="a7"> {{ __('A7 (Dating)') }} </option>
                                        <option name="a8" value="a8"> {{ __('A8 (Eduction)') }} </option>
                                        <option name="a9" value="a9"> {{ __('A9 (Finance)') }} </option>
                                        <option name="a10" value="a10"> {{ __('A10 (Insurance)') }} </option>

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
                                        <option name="ads" value="ads"> {{ __('ADS') }} </option>
                                        <option name="tonic" value="tonic"> {{ __('Tonic') }} </option>
                                        <option name="system1" value="system1"> {{ __('System1') }} </option>
                                        <option name="sedo" value="sedo"> {{ __('Sedo') }} </option>
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
                                        placeholder="Enter Custom Field" value="MB5">
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
                                            <option value="{{ $group->group }}">{{ $group->group }}</option>
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
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label"> {{ __('Campaign Name') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="campaign_name"
                                        placeholder="Enter Campaign Name">
                                    @error('campaign_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4 mr-3">
                        <div class="col-md-12 text-end ">
                            <button type="submit" class="btn btn-primary">{{ __('Add Manual Campaign') }}</button>
                        </div>
                    </div>
                </div>
            </form>
            {{-- <div class="card mb-4">
                    <div class="card-header bg-none fw-bold">
                        {{ __('Ads Section') }}
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
                                    <div id="previewArea" class="row"></div>
                                </div>
                            </div>


                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Offer URL') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="offer_url"
                                        placeholder="Enter Offer URL">
                                    @error('offer_url')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Headline') }}<span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" name="headline" placeholder="Enter Headline" rows="7"></textarea>
                                    @error('headline')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Primary Text') }}<span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" name="primary_text" placeholder="Enter Primary Text" rows="7"></textarea>
                                    @error('primary_text')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                </div> --}}
            {{-- </div> --}}
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#groupSelect').on('change', function() {
                var group = $(this).val();
                if (group) {
                    $.ajax({
                        url: '{{ route('getCountriesByGroup') }}',
                        type: 'GET',
                        data: {
                            group: group
                        },
                        success: function(response) {
                            // Clear and populate country and language selects
                            $('#countrySelect').empty();
                            $('#shortCodeSelect').empty();
                            $('#languageSelect').empty();

                            var firstShortCode = null;

                            $.each(response, function(index, country) {
                                $('#countrySelect').append(
                                    '<option value="' + country.name +
                                    '" data-shortcode="' + country.short_code +
                                    '" data-language="' + country.language + '">' +
                                    country.name +
                                    '</option>'
                                );

                                // Set the first short code found
                                if (firstShortCode === null) {
                                    firstShortCode = country.short_code;
                                }
                                $('#shortCodeSelect').append(
                                    '<option value="' + country.short_code + '">' +
                                    country.short_code + '</option>'
                                );

                                $('#languageSelect').append(
                                    '<option value="' + country.language + '">' +
                                    country.language + '</option>'
                                );
                            });

                            // Populate short code dropdown and set its value
                            if (firstShortCode) {
                                $('#shortCodeSelect').val(
                                    firstShortCode
                                ); // Automatically select the first short code

                                // Trigger a change event to update the campaign name
                                $('#shortCodeSelect').trigger('change');
                            }


                        }
                    });
                } else {
                    // Clear the selects if no group is selected
                    $('#countrySelect').empty().append('<option value="">Select Country</option>');
                    $('#shortCodeSelect').empty().append('<option value="">Select Short Code</option>');
                    $('#languageSelect').empty().append('<option value="">Select Language</option>');
                }
            });

            $('#countrySelect').on('change', function() {
                var country = $(this).val();

                if (country) {
                    $.ajax({
                        url: '{{ route('getCountryDetails') }}',
                        type: 'GET',
                        data: {
                            country: country
                        },
                        success: function(response) {
                            // Populate Short Code Dropdown
                            $('#shortCodeSelect').empty();
                            var firstShortCode = null;
                            $.each(response.all_short_codes, function(index,
                                short_code) {
                                $('#shortCodeSelect').append(
                                    '<option value="' + short_code +
                                    '"' +
                                    (short_code === response
                                        .short_code ? ' selected' : ''
                                    ) +
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

                            // Populate Language Dropdown
                            $('#languageSelect').empty();
                            $.each(response.all_languages, function(index,
                                language) {
                                $('#languageSelect').append(
                                    '<option value="' + language + '"' +
                                    (language === response.language ?
                                        ' selected' : '') +
                                    '>' + language + '</option>'
                                );
                            });
                        }
                    });
                } else {
                    $('#shortCodeSelect').empty().append(
                        '<option value="">Select Short Code</option>');
                    $('#languageSelect').empty().append(
                        '<option value="">Select Language</option>');
                }
            });
        });

        $(document).ready(function() {
            // Function to update the campaign name
            function updateCampaignName() {
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

                campaignNameInput.val(
                    `${topicName} - ${shortProvide} - ${groupProvide} - ${strategy} - ${pixel} - ${feedProvide} - ${customField}`
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
            $('select[name="strategy"], select[name="pixel"], select[name="feed_provide"], input[name="custom_field"] , input[name="topic_name"]')
                .on('change input', function() {
                    updateCampaignName();
                });
        });

       


        // document.addEventListener('DOMContentLoaded', function() {
        //     const topicNameInput = document.querySelector('input[name="topic_name"]');
        //     const strategySelect = document.querySelector('select[name="strategy"]');
        //     const pixelSelect = document.querySelector('select[name="pixel"]');
        //     const feedProvideSelect = document.querySelector('select[name="feed_provide"]');
        //     const customFieldInput = document.querySelector('input[name="custom_field"]');
        //     const groupFieldInput = document.querySelector('select[name="group"]');
        //     const shortcodeFieldInput = document.querySelector('select[name="short_code"]');
        //     const campaignNameInput = document.querySelector('input[name="campaign_name"]');
        //     if (topicNameInput && strategySelect && pixelSelect && feedProvideSelect && customFieldInput &&
        //         groupFieldInput && shortcodeFieldInput &&
        //         campaignNameInput) {
        //         const updateCampaignName = () => {
        //             const capitalizeWords = (str) => {
        //                 return str.split(' ')
        //                     .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
        //                     .join(' ');
        //             };

        //             const topicName = capitalizeWords(topicNameInput.value);
        //             const strategy = strategySelect.value.toUpperCase();
        //             const pixel = pixelSelect.value.toUpperCase();
        //             const feedProvide = feedProvideSelect.value.toUpperCase();
        //             const customField = customFieldInput.value.toUpperCase();
        //             const groupProvide = `[${groupFieldInput.value.toUpperCase()}]`;
        //             const shortProvide = `[${shortcodeFieldInput.value.toUpperCase()}]`;

        //             campaignNameInput.value =
        //                 `${topicName} - ${shortProvide} - ${groupProvide} - ${strategy} - ${pixel} - ${feedProvide} - ${customField}`;
        //         };

        //         topicNameInput.addEventListener('input', updateCampaignName);
        //         strategySelect.addEventListener('change', updateCampaignName);
        //         pixelSelect.addEventListener('change', updateCampaignName);
        //         feedProvideSelect.addEventListener('change', updateCampaignName);
        //         customFieldInput.addEventListener('input', updateCampaignName);
        //         groupFieldInput.addEventListener('change', updateCampaignName);
        //         shortcodeFieldInput.addEventListener('change', updateCampaignName);
        //     }
        // });
    </script>
@endpush
