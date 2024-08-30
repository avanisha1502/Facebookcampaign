@extends('admin.home')

@section('contents')
    <div class="row gx-4">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header bg-none fw-bold">
                    {{ __('Manual Campaign Add') }}
                </div>
                <form action="{{ route('new-campaign-manually.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label"> {{ __('Topic Name') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="topic_name"
                                        placeholder="Enter Topic Name">
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
                                        <option name="a1" value="a1"> {{ __('A1') }} </option>
                                        <option name="a2" value="a2"> {{ __('A2') }} </option>
                                        <option name="a3" value="a3"> {{ __('A3') }} </option>
                                        <option name="a4" value="a4"> {{ __('A4') }} </option>
                                        <option name="a5" value="a5"> {{ __('A5') }} </option>
                                        <option name="a6" value="a6"> {{ __('A6') }} </option>
                                        <option name="a7" value="a7"> {{ __('A7') }} </option>
                                        <option name="a8" value="a8"> {{ __('A8') }} </option>
                                        <option name="a9" value="a9"> {{ __('A9') }} </option>
                                        <option name="a10" value="a10"> {{ __('A10') }} </option>

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
                                    <label class="form-label"> {{ __('Campaign Name') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="campaign_name"
                                        placeholder="Enter Campaign Name" readonly>
                                    @error('campaign_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Group') }}<span
                                            class="text-danger">*</span></label>
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
                                    <label class="form-label">{{ __('Country') }}<span
                                            class="text-danger">*</span></label>
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
                                    <input type="file" class="form-control" name="files[]" multiple id="fileInput">
                                    @error('files')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <div id="previewArea" class="row"></div>
                                </div>
                            </div>

                            {{-- <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Image') }}<span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="image" placeholder="Enter Image">
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div> --}}

                            <div class="col-md-4">
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
                            $('#countrySelect').empty();
                            $('#shortCodeSelect').empty();
                            $('#languageSelect').empty();
                            $.each(response, function(index, country) {
                                $('#countrySelect').append(
                                    '<option value="' + country.name +
                                    '" data-shortcode="' + country.short_code +
                                    '" data-language="' + country.language + '">' +
                                    country.name +
                                    '</option>'
                                );

                                $('#shortCodeSelect').append(
                                    '<option value="' + country.short_code + '">' +
                                    country.short_code + '</option>'
                                );

                                $('#languageSelect').append(
                                    '<option value="' + country.language + '">' +
                                    country.language + '</option>'
                                );
                            });
                        }
                    });
                } else {
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
                            });

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

                topicNameInput.addEventListener('input', updateCampaignName);
                strategySelect.addEventListener('change', updateCampaignName);
                pixelSelect.addEventListener('change', updateCampaignName);
                feedProvideSelect.addEventListener('change', updateCampaignName);
                customFieldInput.addEventListener('input', updateCampaignName);
            }
        });
    </script>
@endpush
