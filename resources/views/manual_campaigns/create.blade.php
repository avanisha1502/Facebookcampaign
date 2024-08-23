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
                            <div class="col-md-3">
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
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Group') }}<span class="text-danger">*</span></label>
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
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('Country') }}<span class="text-danger">*</span></label>
                                    <select class="form-control" id="countrySelect" name="country">
                                        <option value="">Select Country</option>
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
                                    <label class="form-label">{{ __('Image') }}<span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="image" placeholder="Enter Image">
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
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
                                    <button type="submit" class="btn btn-primary">{{ __('Add Manual Campaign') }}</button>
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
                console.log('ddd');

                var group = $(this).val();

                if (group) {
                    $.ajax({
                        url: '{{ route('getCountriesByGroup') }}',
                        type: 'GET',
                        data: {
                            group: group
                        },
                        success: function(response) {
                            $('#countrySelect').empty().append(
                                '<option value="">Select Country</option>');
                            $.each(response, function(index, country) {
                                // Directly access the 'name', 'short_code', and 'language' properties of the 'country' object
                                $('#countrySelect').append(
                                    '<option value="' + country.name +
                                    '" data-shortcode="' + country.short_code +
                                    '" data-language="' + country.language + '">' +
                                    country.name +
                                    '</option>'
                                );
                            });
                        }
                    });
                } else {
                    $('#countrySelect').empty().append('<option value="">Select Country</option>');
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
    </script>
@endpush
