@extends('admin.home')

@section('contents')
    <div class="d-flex align-items-center mb-3">
        <div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{ __('PAGES') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Offer') }}</li>
            </ul>
        </div>

        <div class="ms-auto">
            <a class="btn btn-theme" href="{{ route('new-campaign-manually.create') }}"
                data-title="{{ __('Add New Manual Campaign') }}"><i class="fa fa-plus-circle fa-fw me-1"></i>
                {{ __('Add New Manual Offer') }}</a>
        </div>
    </div>
    <div class="row">
        @if ($manualCmapiagns->count() > 0)
            @foreach ($manualCmapiagns as $index => $campaign)
                <div class="col-md-4 mb-3">
                    <div class="card card_wed">
                        <div class="card-body">
                            <h5 class="card-title d-flex justify-content-center">
                               <a href="{{ route('suboffer.index', $campaign->id) }}" style="text-decoration: none; color:black">  {{ $campaign->campaign_name }} </a>
                            </h5>
                            <div class="card-title d-flex justify-content-center">
                                {{ $campaign->group }}-{{ $campaign->country_name }}-{{ $campaign->short_code }}-{{ $campaign->language }}
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                <a href="{{ route('new-campaign-manually.edit', $campaign->id) }}"
                                    class="btn btn-primary me-2 mb-2"><i class="fa fa-edit"></i>
                                    {{ __('Edit') }}</a>
                               
                                    {{-- <a href="{{ route('AdsCreationOption.show', $campaign->id) }}"
                                        class="btn btn-purple me-2 mb-2"><i class="fa fa-edit"></i>
                                        {{ __('Ad Creatives') }}</a> --}}

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
