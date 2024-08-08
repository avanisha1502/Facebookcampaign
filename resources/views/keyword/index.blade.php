@extends('admin.home')
@section('contents')
    <div class="d-flex align-items-center mb-3">
        <div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{ __('PAGES') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Keyword') }}</li>
            </ul>
            @php
                $domainName = str_replace(['http://', 'https://', '/'], '', $domain_name->domain_name);
            @endphp
            <h1 class="page-header mb-0">{{ $domainName }}</h1>
        </div>

        <div class="ms-auto">
            <a class="btn btn-theme" href="#" data-size="md" data-ajax-popup="true"
                data-url="{{ route('keyword.create', $domain_id) }}" data-title="{{ __('Add New Keyword') }}"><i
                    class="fa fa-plus-circle fa-fw me-1"></i> {{ __('Add Keyword') }}</a>
        </div>
    </div>

    <div id="datatable" class="mb-5">
        <div class="card">
            <div class="card-body">
                <table id="datatableDefault" class="table text-nowrap w-100">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-center">Keyword</th>
                            <th class="text-center">Position</th>
                            <th class="text-center">Best</th>
                            <th class="text-center">URL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($keyword_data as $keyword)
                            @php
                                $response = Http::get("https://restcountries.com/v3.1/name/{$keyword->country}");
                                $countryData = $response->json()[0] ?? null;
                                if ($countryData) {
                                    $countryCode = $countryData['cca2'] ?? null;
                                    $countryFlag = $countryData['flags']['png'] ?? null;
                                } else {
                                    $countryFlag = '';
                                }

                                if ($keyword->url != null) {
                                    $Url = $keyword->url;
                                    $parsedLinkUrl = parse_url($keyword->url);
                                    $domainName = isset($parsedLinkUrl['host']) ? $parsedLinkUrl['host'] : '';
                                    $domainPath = isset($parsedLinkUrl['path']) ? $parsedLinkUrl['path'] : '';
                                } else {
                                    $domainPath = '-';
                                    $Url = url()->current();
                                }
                            @endphp
                            <tr>
                                <td class="text-center"><a href="{{ route('keyword.show', $keyword->id) }}"> <img
                                            src="{{ $countryFlag }}" alt="Flag of Canada" class="img-flag"> </a></td>
                                <td class="text-center">{{ $keyword->keyword }}</td>
                                <td class="text-center"> <a href="{{ route('keyword.show', $keyword->id) }}"
                                        style="text-decoration: none; color: black;"> {{ $keyword->position ?? 0 }} </a>
                                </td>
                                <td class="text-center"> {{ $keyword->position ?? 0 }} </td>
                                <td class="text-center"> <a href="{{ $Url }}"
                                        style="text-decoration: none; color: black;" target="_blank">
                                        {{ $domainPath ?? '-' }} </a> </td>
                                {{-- <td>61</td> --}}
                                {{-- <td>{{ $keyword->url }}</td> --}}
                                {{-- <td>$320,800</td> --}}
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

