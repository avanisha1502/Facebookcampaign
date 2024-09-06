@extends('admin.home')
<?php
use GuzzleHttp\Client;
?>
@section('contents')
    <div class="d-flex align-items-center mb-3">
        <div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{ __('PAGES') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Domains') }}</li>
            </ul>
            <h1 class="page-header mb-0">{{ __('Domains') }}</h1>
        </div>

        <div class="ms-auto">
            <a class="btn btn-theme" href="#" data-size="md" data-ajax-popup="true"
                data-url="{{ route('domain.create') }}" data-title="{{ __('Add New Domain  ') }}">
                <i class="fa fa-plus-circle fa-fw me-1"></i> {{ __('Add Domain') }}</a>
        </div>
    </div>

    <div>

        @foreach ($domains as $domain)
            <div class="card mb-3">
                <div class="card-body">
                    @php
                        $domainName = str_replace(['http://', 'https://', '/'], '', $domain->domain_name);
                        $keywords = App\Models\SerpbearKeyword::select(
                            'domain_id',
                            \DB::raw('COUNT(*) as keyword_count'),
                        )
                            ->where('domain_id', $domain->id)
                            ->groupBy('domain_id')
                            ->count();

                        $creationTime = Carbon\Carbon::parse($domain->created_at);
                        $currentDateTime = Carbon\Carbon::now();
                        $timeSinceCreation = $currentDateTime->diffInSeconds($creationTime);

                        if ($timeSinceCreation < 60) {
                            $timeSinceCreation = 'Less than a minute ago';
                        } elseif ($timeSinceCreation < 3600) {
                            $timeSinceCreation = floor($timeSinceCreation / 60) . ' minutes ago';
                        } elseif ($timeSinceCreation < 86400) {
                            $timeSinceCreation = floor($timeSinceCreation / 3600) . ' hours ago';
                        } else {
                            $timeSinceCreation = floor($timeSinceCreation / 86400) . ' days ago';
                        }

                        $client = new Client();
                        $response = $client->get('https://logo.clearbit.com/' . $domainName);
                        // dd($response);
                        if ($response->getStatusCode() == 200) {
                            $logoUrl = $response->getBody()->getContents();
                            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoUrl);
                            // return view('logo', ['logoUrl' => $logoUrl]);
                        } else {
                            dd('no');
                            // Handle error
                        }
                    @endphp
                    <div class="row gx-0 align-items-center ">
                        <div class="col-md-3">
                            <img src= {{ $logoBase64 }}  alt="{{ $domainName }}" class="card-img domain_img" />
                        </div>
                        <div class="col-md-9">

                            <div class="card-body row">
                                <div class="col-md-4">
                                    <a href="{{ route('domain.show', $domain->id) }}" style="text-decoration: none;">
                                        <h5 class="card-title ml-5">{{ $domainName }}</h5>
                                    </a>
                                    <p class="ml-5">{{ 'Updated' . ' ' . $timeSinceCreation }}</p>
                                </div>
                                <div class="col-md-4">
                                    <div class=" bg-indigo-50 p-1 px-2 text-xs button-tracker">
                                        <span class="icon tracker-icon" title=""><svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                preserveAspectRatio="xMidYMid meet" width="13" viewBox="0 0 24 24">
                                                <path fill="#364aff"
                                                    d="M21 7a.78.78 0 0 0 0-.21a.64.64 0 0 0-.05-.17a1.1 1.1 0 0 0-.09-.14a.75.75 0 0 0-.14-.17l-.12-.07a.69.69 0 0 0-.19-.1h-.2A.7.7 0 0 0 20 6h-5a1 1 0 0 0 0 2h2.83l-4 4.71l-4.32-2.57a1 1 0 0 0-1.28.22l-5 6a1 1 0 0 0 .13 1.41A1 1 0 0 0 4 18a1 1 0 0 0 .77-.36l4.45-5.34l4.27 2.56a1 1 0 0 0 1.27-.21L19 9.7V12a1 1 0 0 0 2 0V7z">
                                                </path>
                                            </svg></span> Tracker
                                    </div>
                                    <div
                                        class="dom_stats tracker-font font-semibold text-2xl p-4 pt-5 rounded border border-[#E9EBFF] text-center">
                                        <div class="flex-1 relative"><span class=" text-xs lg:text-sm text-gray-500 mb-1"
                                                style="display: block; font-size: medium; font-weight: bold;">Keywords</span>{{ $keywords ?? 0 }}
                                        </div>
                                        <div class="flex-1 relative"><span class="text-xs lg:text-sm text-gray-500 mb-1"
                                                style="display: block; font-size: medium; font-weight: bold;">Avg
                                                position</span>0
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class=" bg-indigo-50 p-1 px-2 text-xs button-tracker">
                                        <span class="icon tracker-icon" title=""><svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                preserveAspectRatio="xMidYMid meet" width="13" viewBox="0 0 256 262">
                                                <path
                                                    d="M255.878 133.451c0-10.734-.871-18.567-2.756-26.69H130.55v48.448h71.947c-1.45 12.04-9.283 30.172-26.69 42.356l-.244 1.622l38.755 30.023l2.685.268c24.659-22.774 38.875-56.282 38.875-96.027"
                                                    fill="#4285F4"></path>
                                                <path
                                                    d="M130.55 261.1c35.248 0 64.839-11.605 86.453-31.622l-41.196-31.913c-11.024 7.688-25.82 13.055-45.257 13.055c-34.523 0-63.824-22.773-74.269-54.25l-1.531.13l-40.298 31.187l-.527 1.465C35.393 231.798 79.49 261.1 130.55 261.1"
                                                    fill="#34A853"></path>
                                                <path
                                                    d="M56.281 156.37c-2.756-8.123-4.351-16.827-4.351-25.82c0-8.994 1.595-17.697 4.206-25.82l-.073-1.73L15.26 71.312l-1.335.635C5.077 89.644 0 109.517 0 130.55s5.077 40.905 13.925 58.602l42.356-32.782"
                                                    fill="#FBBC05"></path>
                                                <path
                                                    d="M130.55 50.479c24.514 0 41.05 10.589 50.479 19.438l36.844-35.974C195.245 12.91 165.798 0 130.55 0C79.49 0 35.393 29.301 13.925 71.947l42.211 32.783c10.59-31.477 39.891-54.251 74.414-54.251"
                                                    fill="#EB4335"></path>
                                            </svg>

                                        </span> Search Console
                                    </div>
                                    <div
                                        class="dom_stats tracker-font font-semibold text-2xl p-4 pt-5 rounded border border-[#E9EBFF] text-center">
                                        <div class="flex-1 relative"><span class=" text-xs lg:text-sm text-gray-500 mb-1"
                                                style="display: block; font-size: medium; font-weight: bold;">{{ __('Visits') }}</span>3
                                        </div>
                                        <div class="flex-1 relative"><span class="text-xs lg:text-sm text-gray-500 mb-1"
                                                style="display: block; font-size: medium; font-weight: bold;">{{ __('Impressions') }}</span>0
                                        </div>
                                        <div class="flex-1 relative"><span class="text-xs lg:text-sm text-gray-500 mb-1"
                                                style="display: block; font-size: medium; font-weight: bold;">{{ __('Avg Position') }}</span>0
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
