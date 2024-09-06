@extends('admin.home')

@section('contents')
    <div class="d-flex align-items-center mb-3">
        <div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{ __('PAGES') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Keyword') }}</li>
            </ul>
        </div>

        <div class="ms-auto">
            <a class="btn btn-theme" href="#" data-size="md" data-ajax-popup="true"
                data-url="{{ route('googleadskeyword.create') }}" data-title="{{ __('Add New Keyword') }}"><i
                    class="fa fa-plus-circle fa-fw me-1"></i> {{ __('Add Keyword') }}</a>
        </div>
    </div>
    <div class="card" style="position: relative;">
        <div class="table-responsive">
            <div id="datatable" class="mb-5">
                <div class="dt-search Search">
                    {{-- <label for="dt-search-1" class="dt-search-1">Search:</label> --}}
                    <form action="{{ route('googleadskeyword.filter') }}" method="post" role="search">
                        @csrf
                        <div class="input-group position-relative">
                            <input type="search" class="form-control rounded-start" id="input" name="search"
                                placeholder="Search" value="{{ request()->get('search') ?? '' }}">
                            <button class="btn btn-theme fs-13px fw-semibold" type="submit">Search</button>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <table id="datatableDefault" class="table text-nowrap w-100" style="margin-top:50px;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center">{{ __('Keyword') }}</th>
                                <th class="text-center">{{ __('Monthly Search') }}</th>
                                <th class="text-center">{{ __('Competition') }}</th>
                                <th class="text-center">{{ __('Top of Page Bid (Low Range)') }}</th>
                                <th class="text-center">{{ __('Top of Page Bid (High Range)') }}</th>
                            </tr>
                        </thead>
                        @if ($keywordSuggestions->count() > 0)
                            <tbody>
                                {{-- <tr style="background-color: aliceblue;">
                                        <td style="font-weight: 500;"> Keywords you provided</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr> --}}
                                @foreach ($KeyProvides as $index => $keywordsugeestion)
                                    <tr style="background-color: aliceblue; font-weight: 500;">
                                        <td class="text-center"><a
                                                href="{{ route('googleadskeyword.show', $keywordsugeestion->id) }}"> <img
                                                    src="{{ $keywordsugeestion->country->image_url }}" alt="Flag of Canada"
                                                    class="img-flag"> </a></td>
                                        <td class="text-center">{{ $keywordsugeestion->name }}</td>
                                        <td class="text-center"> <a href="#" style="text-decoration: none; color: black;">
                                                {{ number_format(floatval($keywordsugeestion->monthly_search)) }} </a>
                                        </td>
                                        <td class="text-center py-1 align-middle">
                                            <a href="#" style="text-decoration: none; color: black;" target="_blank">
                                                <div class="keyword_ctr text-center inline-block ml-4 relative-1 lg:m-0 justify-center"
                                                    style="display: flex;
                                                                justify-content: center;">
                                                    <div
                                                        class="idea_competiton  flex bg-slate-100 rounded w-28 text-xs font-semibold">
                                                        <span class="p-1 flex-1" style="display: inline-block; margin-left: 7px;">
                                                            {{ $keywordsugeestion->competition }} / 100</span>
                                                        @if ($keywordsugeestion->competition >= 0 && $keywordsugeestion->competition <= 33)
                                                            <span
                                                                class=" inline-block p-1 flex-1 rounded-e text-white idea_competiton--LOW"
                                                                style="display: inline-block;">LOW</span>
                                                        @elseif($keywordsugeestion->competition > 33 && $keywordsugeestion->competition <= 66)
                                                            <span
                                                                class=" inline-block p-1 flex-1 rounded-e text-white idea_competiton--Medium"
                                                                style="display: inline-block;">Medium</span>
                                                        @else
                                                            <span
                                                                class=" inline-block p-1 flex-1 rounded-e text-white idea_competiton--high"
                                                                style="display: inline-block;">High</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            {{ $keywordsugeestion->country->currency_symbol }}
                                            {{ number_format((float) $keywordsugeestion->low_bid_range, 2) }}</td>
                                        <td class="text-center">
                                            {{ $keywordsugeestion->country->currency_symbol }}
                                            {{ number_format((float) $keywordsugeestion->high_bid_range, 2) }}</td>
                                    </tr>
                                @endforeach

                                {{-- <tr style="background-color: aliceblue;">
                                        <td style="font-weight: 500;"> Keyword ideas</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr> --}}
                                @foreach ($keywordSuggestions as $index => $keywordsugeestion)
                                    <tr>
                                        <td class="text-center"><a
                                                href="{{ route('googleadskeyword.show', $keywordsugeestion->id) }}"> <img
                                                    src="{{ $keywordsugeestion->country->image_url }}" alt="Flag of Canada"
                                                    class="img-flag"> </a></td>
                                        <td class="text-center">{{ $keywordsugeestion->name }}</td>
                                        <td class="text-center"> <a href="#" style="text-decoration: none; color: black;">
                                                {{ number_format(floatval($keywordsugeestion->monthly_search)) }} </a>
                                        </td>
                                        <td class="text-center py-1 align-middle">
                                            <a href="#" style="text-decoration: none; color: black;" target="_blank">
                                                <div class="keyword_ctr text-center inline-block ml-4 relative-1 lg:m-0 justify-center"
                                                    style="display: flex;
                                                            justify-content: center;">
                                                    <div
                                                        class="idea_competiton  flex bg-slate-100 rounded w-28 text-xs font-semibold">
                                                        <span class="p-1 flex-1" style="display: inline-block; margin-left: 7px;">
                                                            {{ $keywordsugeestion->competition }} / 100</span>
                                                        @if ($keywordsugeestion->competition >= 0 && $keywordsugeestion->competition <= 33)
                                                            <span
                                                                class=" inline-block p-1 flex-1 rounded-e text-white idea_competiton--LOW"
                                                                style="display: inline-block;">LOW</span>
                                                        @elseif($keywordsugeestion->competition > 33 && $keywordsugeestion->competition <= 66)
                                                            <span
                                                                class=" inline-block p-1 flex-1 rounded-e text-white idea_competiton--Medium"
                                                                style="display: inline-block;">Medium</span>
                                                        @else
                                                            <span
                                                                class=" inline-block p-1 flex-1 rounded-e text-white idea_competiton--high"
                                                                style="display: inline-block;">High</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            {{ $keywordsugeestion->country->currency_symbol }}
                                            {{ number_format((float) $keywordsugeestion->low_bid_range, 2) }}</td>
                                        <td class="text-center">
                                            {{ $keywordsugeestion->country->currency_symbol }}
                                            {{ number_format((float) $keywordsugeestion->high_bid_range, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @endif
                    </table>
                </div>
                <form class="datatable-footer-part" action="{{ route('googleadskeyword.filter') }}" method="post">
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
                    <div class="datable-footer-part-2"> {{ $keywordSuggestions->firstItem() }} ~
                        {{ $keywordSuggestions->lastItem() }}
                    </div>
                    <div class="datable-footer-part-3">{{ $keywordSuggestions->links('vendor.pagination.bootstrap-4') }}</div>
                </form>
            </div>
        </div>
    </div>
@endsection
