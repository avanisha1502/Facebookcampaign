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

    <div class="card" style="position: relative;">
        <div class="table-responsive">
            <div id="datatable" class="mb-5">
                <div class="card-body">
                    <table id="datatableDefault" class="table text-nowrap w-100" style="margin-top:50px;">
                        <thead>
                            <tr>
                                {{-- <th>#</th> --}}
                                {{-- <th class="">{{ __('Image') }}</th> --}}
                                <th class="">{{ __('Campaign Name') }}</th>
                                <th class="">{{ __('Group') }}</th>
                                <th class="">{{ __('Country Name') }}</th>
                                <th class="">{{ __('Short Code') }}</th>
                                <th class="">{{ __('Language') }}</th>
                                <th class="">{{ __('Offer Url') }}</th>
                                {{-- <th class="">{{ __('Headlines') }}</th>
                                <th class="">{{ __('Primary Text') }}</th> --}}
                                <th class="">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        @if ($manualCmapiagns->count() > 0)
                            <tbody>
                                @foreach ($manualCmapiagns as $index => $campaign)
                                    <tr style="background-color: aliceblue; font-weight: 500;">
                                        {{-- <td class="">
                                            <img src="{{ $campaign->image }}"
                                                style="height: 75px; width: 73px; border-radius: 11px;">
                                        </td> --}}
                                        <td class=""> {{ $campaign->campaign_name }} </td>
                                        <td class=""> {{ $campaign->group }} </td>
                                        <td class=""> {{ $campaign->country_name }} </td>
                                        <td class=""> {{ $campaign->short_code }} </td>
                                        <td class=""> {{ $campaign->language }} </td>
                                        @php
                                            $short = \Illuminate\Support\Str::limit($campaign->offer_url, 50);
                                        @endphp
                                        <td class="" data-url="{{ $campaign->offer_url }}"
                                            onclick="copyToClipboard(this)" style="cursor: pointer;"> {{ $short }}
                                        </td>
                                        {{-- <td class=""> {{ $campaign->headlines }} </td>
                                        <td class=""> {{ $campaign->primary_text }} </td> --}}
                                        <td class="">
                                            <div class="justify-content-center">
                                                <div>
                                                    <a href="{{ route('new-campaign-manually.edit', $campaign->id) }}"
                                                        class="btn btn-primary me-2 mb-2"><i class="fa fa-edit"></i>
                                                        {{ __('Edit') }}</a>
                                                </div>
                                                <div>
                                                    <a href="#" data-size="xl" data-ajax-popup="true"
                                                        data-url="{{ route('new-campaign-manually.show', $campaign->id) }}"
                                                        data-title="{{ __('Show Generated Headlines') }}"
                                                        class="btn btn-purple me-2 mb-2 "><i
                                                            class="fa fa-eye fa-fw me-1 "></i>
                                                        {{ __('Show Campaign Headlines') }} </a>

                                                </div>
                                                <form method="POST"
                                                    action="{{ route('new-campaign-manually.destroy', $campaign->id) }}"
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
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @endif
                    </table>
                </div>
                {{-- <form class="datatable-footer-part" action="{{ route('campaign.filter') }}" method="post">
                @csrf
                <div class="datable-footer-part-1">
                    <select name="data_filter" id="data_filter" onchange="javascript:this.form.submit()">
                        @if ($data_filter == '10')
                            <option value="10" selected>10</option>
                        @else
                            <option value="10">10</option>
                        @endif

                        @if ($data_filter == '25')
                            <option value="25" selected>25</option>
                        @else
                            <option value="25">25</option>
                        @endif

                        @if ($data_filter == '50')
                            <option value="50" selected>50</option>
                        @else
                            <option value="50">50</option>
                        @endif

                        @if ($data_filter == '100')
                            <option value="100" selected>100</option>
                        @else
                            <option value="100">100</option>
                        @endif
                    </select>
                    <span>Entries per page</span>
                </div>
                <input type="hidden" name="search" value="{{ request()->get('search') }}">
                <div class="datable-footer-part-2"> {{ $campaigns->firstItem() }} ~
                    {{ $campaigns->lastItem() }}
                </div>
                <div class="datable-footer-part-3">{{ $campaigns->links('vendor.pagination.bootstrap-4') }}</div>
            </form> --}}

            </div>
        </div>
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
