@extends('admin.home')

@section('contents')
    <div class="d-flex align-items-center mb-3">
        <div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{ __('PAGES') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Campaign') }}</li>
            </ul>
        </div>

        <div class="ms-auto">
            <a class="btn btn-theme" href="{{ route('new-campaign-manually.create') }}"
                data-title="{{ __('Add New Manual Campaign') }}"><i class="fa fa-plus-circle fa-fw me-1"></i>
                {{ __('Add New Manual Campaign') }}</a>
        </div>
    </div>
    <div class="row">
        @if ($manualCmapiagns->count() > 0)
            @foreach ($manualCmapiagns as $index => $campaign)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title d-flex justify-content-center">{{ $campaign->campaign_name }}</h5>
                            <div class="card-title d-flex justify-content-center">
                                {{ $campaign->group }}-{{ $campaign->country_name }}-{{ $campaign->short_code }}-{{ $campaign->language }}
                            </div>
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('new-campaign-manually.edit', $campaign->id) }}"
                                    class="btn btn-primary me-2 mb-2"><i class="fa fa-edit"></i>
                                    {{ __('Edit') }}</a>

                                @if ($campaign->headlines != null && $campaign->primary_text != null && $campaign->description != null)
                                    <a href="{{ route('generate-headlines-manual', $campaign->id) }}"
                                        class="btn btn-warning me-2 generate-button text-white mb-2"
                                        id="generate-{{ $campaign->id }}">
                                        <i class="fa-solid fa-redo"></i>
                                        {{ __('Regenerate Headlines') }}
                                    </a>
                                @else
                                    <a href="{{ route('generate-headlines-manual', $campaign->id) }}"
                                        class="btn btn-success me-2 generate-button show_btn mb-2"
                                        id="generate-{{ $campaign->id }}">
                                        <i class="fa-solid fa-audio-description"></i>
                                        {{ __('Generate Headlines') }}
                                    </a>
                                @endif
                                <div id="loader-{{ $campaign->id }}"
                                    class="loaderdd-{{ $campaign->id }} buttonload btn btn-primary me-2 hidden mb-2">
                                    <i class="fa fa-spinner fa-spin mr-2"></i>
                                    {{ __('Wait its generating....') }}
                                </div>

                                {{-- <a href="{{ route('generate-headlines-manual', $campaign->id) }}"
                                    class="btn btn-success me-2 generate-button show_btn mb-2"
                                    id="generate-{{ $campaign->id }}">
                                    <i class="fa-solid fa-audio-description"></i>
                                    {{ __('Generate Headlines') }}
                                </a> --}}

                                <a href="#" data-size="xl" data-ajax-popup="true"
                                    data-url="{{ route('new-campaign-manually.show', $campaign->id) }}"
                                    data-title="{{ __('Show Generated Headlines') }}" class="btn btn-purple me-2 mb-2 "><i
                                        class="fa fa-eye fa-fw me-1 "></i>
                                    {{ __('Show Campaign Headlines') }} </a>

                                <form method="POST" action="{{ route('new-campaign-manually.destroy', $campaign->id) }}"
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
        @endif
    </div>
@endsection


@push('scripts')
    <script>
        $(document).on('click', '.generate-button', function(e) {
            e.preventDefault(); // Prevent the default link action

            var button = $(this);
            var id = button.attr('id');

            if (!id) {
                console.error('Button ID is not defined.');
                return;
            }

            var parts = id.split('-');
            if (parts.length < 2) {
                console.error('Button ID format is incorrect.');
                return;
            }

            var loaderClass = '.loaderdd-' + parts[1]; // Define the loader class
            var loader = $($('div').filter(function() {
                return $(this).hasClass(loaderClass.substring(1));
            })); // Find the loader element by its class

            // Check if the loader exists
            if (loader.length === 0) {
                console.error('Loader not found with class:', loaderClass);
                return;
            }

            // Hide the button and show the loader
            button.hide();
            loader.removeClass('hidden'); // Remove the hidden class
            loader.addClass('loading'); // Add the loading class
            loader.show(); // Show the loader element

            // Optionally, make an AJAX request to handle the button click
            $.ajax({
                url: button.attr('href'),
                method: 'GET',
                success: function(response) {
                    // Optionally, hide the loader and show the button again if needed
                    loader.css('display', 'none'); // Hide the loader again
                    loader.addClass('hidden'); // Add the hidden class again

                    // Update the button text and class
                    button.text('Regenerate Headlines');
                    button.removeClass('generate-button');
                    button.addClass('generate-button btn btn-warning me-2');
                    button.html('<i class="fa-solid fa-redo"></i> Regenerate Headlines');
                    button.show();

                    show_toastr('Success', 'Campaign ad content generated successfully', 'success');
                },
                error: function(xhr) {
                    // Handle errors if needed
                    console.error('Error:', xhr.responseText);
                    // Show the button again in case of error
                    button.show();
                    loader.css('display', 'none'); // Hide the loader again
                    loader.addClass('hidden'); // Add the hidden class again
                    show_toastr('Error', 'Please check and try again', 'error');
                }
            });
        });

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
    </script>
@endpush
