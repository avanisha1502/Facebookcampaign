@extends('admin.home')

<style>
    .hidden {
        display: none;
    }

    .loading {
        display: block;
    }

    .contrnt {
        display: contents;
    }
</style>
@section('contents')
    <div class="d-flex align-items-center mb-3">
        <div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{ __('PAGES') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Campaign') }}</li>
            </ul>
        </div>

        <div class="ms-auto">
            <a class="btn btn-theme" href="{{ route('create-campaign') }}" data-title="{{ __('Add New Campaign') }}"><i
                    class="fa fa-plus-circle fa-fw me-1"></i> {{ __('Add Campaign') }}</a>
        </div>
    </div>
    <div class="card" style="position: relative;">
        <div class="table-responsive">
            <div id="datatable" class="mb-5">
                <div class="row">
                    <form action="{{ route('campaign.show') }}" method="POST">
                        @csrf
                        <div class="campaign_select">
                            <select class=" form-control" name="campaing_id" id="ex-basic" onchange="this.form.submit()">
                                @foreach ($adscampaign as $campaign)
                                    <option value="{{ $campaign->id }}">
                                        {{ $campaign->name }} - Ad account ID : {{ $campaign->account_id }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="dt-search Search">
                    <form action="{{ route('campaign.filter') }}" method="post" role="search">
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
                                {{-- <th>#</th> --}}
                                <th class="">{{ __('Vertical') }}</th>
                                <th class="">{{ __('Topic') }}</th>
                                <th class="">{{ __('Keyword') }}</th>
                                <th class="" hidden>{{ __('Campaign Name') }}</th>
                                <th class="" hidden>{{ __('Domain Name') }}</th>
                                <th class="" hidden>{{ __('Offer Url') }}</th>
                                <th class="">{{ __('Tracking Url') }}</th>
                                <th class="">{{ __('Action') }}</th>
                            </tr>
                        </thead>

                        {{-- @foreach ($adscampaign as $campaign)
                            @php
                                $cam = json_decode($campaign->campaigns , true);
                            @endphp
                            @foreach ($cam['data'] as $cami)
                                @dd($cami['name'])
                            @endforeach
                        @endforeach --}}
                        @if ($campaigns->count() > 0)
                            <tbody>
                                @php
                                    function formatKeywords($keywords, $limit = 1)
                                    {
                                        // Split the keywords by commas
                                        $keywordsArray = explode(',', $keywords);
                                        $formattedKeywords = [];

                                        // Group keywords in chunks of $limit
                                        foreach (array_chunk($keywordsArray, $limit) as $chunk) {
                                            $keywordButtons = array_map(function ($keyword) {
                                                $trimmedKeyword = trim($keyword);
                                                return '<button class="badge badge-primary" onclick="copyToClipboard(\'' .
                                                    htmlspecialchars($trimmedKeyword, ENT_QUOTES) .
                                                    '\')">' .
                                                    htmlspecialchars($trimmedKeyword) .
                                                    '</button>';
                                            }, $chunk);
                                            $formattedKeywords[] = implode(', ', $keywordButtons);
                                        }

                                        // Join the chunks with <br> for line breaks
                                        return implode('<br>', $formattedKeywords);
                                    }

                                    function formatArrayItems($items, $limit = 1)
                                    {
                                        // Group items in chunks of $limit
                                        $formattedItems = [];

                                        foreach (array_chunk($items, $limit) as $chunk) {
                                            $itemButtons = array_map(function ($item) {
                                                $trimmedItem = htmlspecialchars($item, ENT_QUOTES);
                                                return '<button class="badge badge-primary" onclick="copyToClipboard(\'' .
                                                    $trimmedItem .
                                                    '\')">' .
                                                    $trimmedItem .
                                                    '</button>';
                                            }, $chunk);
                                            $formattedItems[] = implode(', ', $itemButtons);
                                        }

                                        // Remove the trailing comma from the last chunk
                                        $lastChunk = array_pop($formattedItems);
                                        $formattedItems[] = rtrim($lastChunk, ',');

                                        // Join the chunks with <br> for line breaks
                                        return implode('<br>', $formattedItems);
                                    }

                                    function formatArrayItemsss($items, $limit = 1)
                                    {
                                        // Group items in chunks of $limit
                                        $formattedItems = [];
                                        foreach (array_chunk($items, $limit) as $chunk) {
                                            $itemButtons = array_map(
                                                function ($index, $item) {
                                                    $trimmedItem = htmlspecialchars($item, ENT_QUOTES);
                                                    // Extract the prefix and the last segment after the last hyphen
                                                    $segments = explode('-', $trimmedItem);
                                                    $prefix = $segments[0]; // Assuming the prefix is the first segment
                                                    $lastSegments = array_slice($segments, -4);
                                                    $prefix1 = $lastSegments[0];
                                                    // Create the formatted item
                                                    $formattedItem = $prefix . '-' . $prefix1;
                                                    return '<button class="badge badge-primary hover-tooltip" data-tooltip-position="bottom"  data-tooltip=' .
                                                        $trimmedItem .
                                                        ' onclick="copyToClipboard(\'' .
                                                        $trimmedItem .
                                                        '\')">' .
                                                        $formattedItem .
                                                        '</button>';
                                                },
                                                array_keys($chunk),
                                                $chunk,
                                            );
                                            $formattedItems[] = implode(', ', $itemButtons);
                                        }

                                        // Remove the trailing comma from the last chunk
                                        $lastChunk = array_pop($formattedItems);
                                        $formattedItems[] = rtrim($lastChunk, ',');
                                        // Join the chunks with <br> for line breaks
                                        return implode('<br>', $formattedItems);
                                    }

                                    function formatArrayItemall($items, $limit = 1)
                                    {
                                        // Group items in chunks of $limit
                                        $formattedItems = [];
                                        foreach (array_chunk($items, $limit) as $chunk) {
                                            $itemButtons = array_map(
                                                function ($index, $item) {
                                                    $trimmedItem = htmlspecialchars($item, ENT_QUOTES);
                                                    // Extract the prefix and the last segment after the last hyphen
                                                    $segments = explode('-', $trimmedItem);
                                                    $prefix = $segments[0]; // Assuming the prefix is the first segment
                                                    $lastSegments = array_slice($segments, -3);
                                                    // dd($lastSegments);
                                                    $prefix1 = $lastSegments[0];
                                                    // Create the formatted item
                                                    $formattedItem = $prefix . '-' . $prefix1;
                                                    return '<button class="badge badge-primary hover-tooltip" data-tooltip-position="bottom"  data-tooltip=' .
                                                        $trimmedItem .
                                                        ' onclick="copyToClipboard(\'' .
                                                        $trimmedItem .
                                                        '\')">' .
                                                        $formattedItem .
                                                        '</button>';
                                                },
                                                array_keys($chunk),
                                                $chunk,
                                            );
                                            $formattedItems[] = implode(', ', $itemButtons);
                                        }

                                        // Remove the trailing comma from the last chunk
                                        $lastChunk = array_pop($formattedItems);
                                        $formattedItems[] = rtrim($lastChunk, ',');
                                        // Join the chunks with <br> for line breaks
                                        return implode('<br>', $formattedItems);
                                    }

                                    // Move this function outside of formatURLItemsut
                                    function getLastWord($string)
                                    {
                                        // Split the string by hyphens
                                        $parts = explode('-', $string);
                                        // Return the last element
                                        return end($parts);
                                    }

                                    function formatURLItemsut($items, $limit = 1)
                                    {
                                        // Group items in chunks of $limit
                                        $formattedItems = [];
                                        foreach (array_chunk($items, $limit) as $chunk) {
                                            $itemButtons = array_map(function ($item) {
                                                // Ensure $item is an array with 'full' key
                                                if (isset($item)) {
                                                    $fullUrl = htmlspecialchars($item, ENT_QUOTES);

                                                    // Extract the host and transform it
                                                    $parsedUrl = parse_url($fullUrl);
                                                    $host = $parsedUrl['host'] ?? '';
                                                    $scheme = $parsedUrl['scheme'] ?? '';

                                                    // Example: moving-services-asia.site -> asia.site
                                                    $domainParts = explode('.', $host);

                                                    // Apply the function to each element in the array
                                                    $lastWords = array_map('getLastWord', $domainParts);
                                                    $lastWordsString = implode('.', $lastWords);
                                                    $transformedDomain = $scheme . '://' . $lastWordsString;

                                                    // Button to copy the full URL
                                                    return '<button class="badge badge-primary hover-tooltip" data-tooltip-position="bottom" data-tooltip=' .
                                                        $fullUrl .
                                                        ' onclick="copyToClipboard(\'' .
                                                        $fullUrl .
                                                        '\')">' .
                                                        $transformedDomain .
                                                        '</button>';
                                                }
                                                return '<button class="badge badge-primary" disabled>Invalid URL</button>'; // Handle invalid cases
                                            }, $chunk);

                                            $formattedItems[] = implode(', ', $itemButtons);
                                        }

                                        // Join the chunks with <br> for line breaks
                                        return implode('<br>', $formattedItems);
                                    }

                                    function formatURLItems($items, $limit = 1)
                                    {
                                        // Group items in chunks of $limit
                                        $formattedItems = [];

                                        foreach (array_chunk($items, $limit) as $chunk) {
                                            $itemButtons = array_map(function ($item) {
                                                // Ensure $item is an array with 'base' and 'full' keys
                                                if (isset($item['base']) && isset($item['full'])) {
                                                    $baseUrl = htmlspecialchars($item['base'], ENT_QUOTES);
                                                    $fullUrl = htmlspecialchars($item['full'], ENT_QUOTES);

                                                    // Extract the host and transform it
                                                    $parsedUrl = parse_url($baseUrl);
                                                    $host = $parsedUrl['host'] ?? '';
                                                    $scheme = $parsedUrl['scheme'] ?? '';
                                                    $domainParts = explode('.', $host);
                                                    $lastWords = array_map('getLastWord', $domainParts);
                                                    $lastWordsString = implode('.', $lastWords);
                                                    $baseUrls = $scheme . '://' . $lastWordsString;
                                                    return '<button class="badge badge-primary hover-tooltip" data-tooltip-position="bottom" data-tooltip=' .
                                                        $fullUrl .
                                                        ' onclick="copyToClipboard(\'' .
                                                        $fullUrl .
                                                        '\')">' .
                                                        $baseUrls .
                                                        '</button>';
                                                }
                                                return '<button class="badge badge-primary" disabled>Invalid URL</button>'; // Handle invalid cases
                                            }, $chunk);

                                            $formattedItems[] = implode(', ', $itemButtons);
                                        }

                                        // Join the chunks with <br> for line breaks
                                        return implode('<br>', $formattedItems);
                                    }

                                    function formatURLTracking($items, $limit = 1)
                                    {
                                        // Split the keywords by commas
                                        $keywordsArray = explode(',', $items);

                                        $formattedKeywords = [];

                                        // Group keywords in chunks of $limit
                                        foreach (array_chunk($keywordsArray, $limit) as $chunk) {
                                            $keywordButtons = array_map(function ($keyword) {
                                                $delimiter = '/cf/';

                                                $trimmedKeyword = trim($keyword);
                                                $pos = strpos($trimmedKeyword, $delimiter);
                                                $baseUrl = substr($trimmedKeyword, 0, $pos);
                                                return '<button class="badge badge-primary hover-tooltip" data-tooltip-position="bottom" data-tooltip=' .
                                                    $keyword .
                                                    '  onclick="copyToClipboard(\'' .
                                                    htmlspecialchars($trimmedKeyword, ENT_QUOTES) .
                                                    '\')">' .
                                                    htmlspecialchars($baseUrl) .
                                                    '</button>';
                                            }, $chunk);
                                            $formattedKeywords[] = implode(', ', $keywordButtons);
                                        }

                                        return implode('<br>', $formattedKeywords);
                                    }

                                    // function formatURLTracking($items, $limit = 1)
                                    // {
                                    //     // Split the keywords by commas
                                    //     $keywordsArray = explode(',', $items);

                                    //     $formattedKeywords = [];

                                    //     // Define possible delimiters
                                    //     $delimiters = ['/cf/', '/cf/r/'];

                                    //     // Group keywords in chunks of $limit
                                    //     foreach (array_chunk($keywordsArray, $limit) as $chunk) {
                                    //         $keywordButtons = array_map(function ($keyword) use ($delimiters) {
                                    //             $trimmedKeyword = trim($keyword);

                                    //             // Find the position of the first delimiter
                                    //             $pos = -1;
                                    //             foreach ($delimiters as $delimiter) {
                                    //                 $pos = strpos($trimmedKeyword, $delimiter);
                                    //                 if ($pos !== false) {
                                    //                     break;
                                    //                 }
                                    //             }

                                    //             // Extract base URL if a delimiter is found
                                    //             $baseUrl = $pos !== false ? substr($trimmedKeyword, 0, $pos) : $trimmedKeyword;
                                    //             // dd($baseUrl);
                                    //             return '<button class="badge badge-primary hover-tooltip" data-tooltip-position="bottom" data-tooltip=' .
                                    //                 htmlspecialchars($keyword, ENT_QUOTES) .
                                    //                 ' onclick="copyToClipboard(\'' .
                                    //                 htmlspecialchars($trimmedKeyword, ENT_QUOTES) .
                                    //                 '\')">' .
                                    //                 htmlspecialchars($baseUrl) .
                                    //                 '</button>';
                                    //         }, $chunk);

                                    //         $formattedKeywords[] = implode(', ', $keywordButtons);
                                    //     }

                                    //     return implode('<br>', $formattedKeywords);
                                    // }

                                @endphp
                                @foreach ($campaigns as $index => $campaign)
                                    @php
                                        $campaignNames = json_decode($campaign->topic_campaign_name, true);
                                        $topic_domain_name = json_decode($campaign->topic_domain_name, true);
                                        $topic_offer_urls = json_decode($campaign->topic_offer_url, true);
                                        $treacking_url = json_decode($campaign->tracking_url, true);

                                        $urls = [];
                                        if (is_array($topic_offer_urls)) {
                                            foreach ($topic_offer_urls as $url) {
                                                $parsedUrl = parse_url($url);
                                                if ($parsedUrl !== false) {
                                                    $baseUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
                                                    $urls[] = ['base' => $baseUrl, 'full' => $url];
                                                } else {
                                                    $urls[] = ['base' => 'Invalid URL', 'full' => 'Invalid URL'];
                                                }
                                            }
                                        } elseif (is_string($topic_offer_urls)) {
                                            $parsedUrl = parse_url($topic_offer_urls);
                                            if ($parsedUrl !== false) {
                                                $baseUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
                                                $urls[] = ['base' => $baseUrl, 'full' => $topic_offer_urls];
                                            } else {
                                                $urls[] = ['base' => 'Invalid URL', 'full' => 'Invalid URL'];
                                            }
                                        } else {
                                            $urls[] = ['base' => 'Invalid URL format', 'full' => 'Invalid URL format'];
                                        }
                                    @endphp
                                    <tr style="background-color: aliceblue; font-weight: 500;">
                                        <td class=""> {{ $campaign->vertical }} </td>
                                        <td class=""> {{ $campaign->topic }} </td>

                                        <td class=""> <span> {!! formatKeywords($campaign->keyword) !!} </span></td>

                                        @if ($campaign->is_region != '0')
                                            <td class="" hidden> <span> {!! formatArrayItemsss($campaignNames) !!}<span></td>
                                        @else
                                            <td class="" hidden> <span> {!! formatArrayItemall($campaignNames) !!}<span></td>
                                        @endif
                                        <td class="" hidden><span> {!! formatURLItemsut($topic_domain_name) !!} <span></td>
                                        <td class="" hidden>{!! formatURLItems($urls) !!}</td>
                                        <td class="">{!! formatURLTracking($campaign->tracking_url) !!}</td>
                                        <td class="">
                                            <div class="justify-content-center">
                                                <div>
                                                    <a href="{{ route('edit-campaign', $campaign->id) }}"
                                                        class="btn btn-primary me-2 mb-2"><i class="fa fa-edit"></i>
                                                        {{ __('Edit') }}</a>
                                                </div>
                                                <div>
                                                    @if ($campaign->generateHeadlines != null)
                                                        <a href="{{ route('generate-headlines', $campaign->id) }}"
                                                            class="btn btn-warning me-2 generate-button text-white mb-2"
                                                            id="generate-{{ $campaign->id }}">
                                                            <i class="fa-solid fa-redo"></i>
                                                            {{ __('Regenerate Headlines') }}
                                                        </a>
                                                    @else
                                                        <a href="{{ route('generate-headlines', $campaign->id) }}"
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
                                                </div>

                                                {{-- @if ($campaign->generateHeadlines != null) --}}
                                                <div>
                                                    <a href="#" data-size="xl" data-ajax-popup="true"
                                                        data-url="{{ route('generate-headlines-show', $campaign->id) }}"
                                                        data-title="{{ __('Show Generated Headlines') }}"
                                                        class="btn btn-purple me-2 mb-2 "><i
                                                            class="fa fa-eye fa-fw me-1 "></i>
                                                        {{ __('Show Generated Headlines') }} </a>

                                                </div>

                                                <div>
                                                    <a href="{{ route('generate-imageUpload', $campaign->id) }}"
                                                        class="btn btn-pink me-2 mb-2 text-white"><i
                                                            class="fa fa-upload"></i>
                                                        {{ __('Upload') }}</a>
                                                </div>

                                                {{-- <div>
                                                    <a href="#" data-size="md" data-ajax-popup="true"
                                                        data-url="{{ route('adsaccounts-list', $campaign->id) }}"
                                                        data-title="{{ __('Account List') }}"
                                                        class="btn btn-info me-2 mb-2 text-white"><i
                                                            class="fa fa-facebook"></i>
                                                        {{ __('Generate Campaign') }}</a>
                                                </div> --}}

                                                <div>
                                                    <a href="#" data-size="md" data-ajax-popup="true"
                                                        data-url="{{ route('adsaccounts-list', $campaign->id) }}"
                                                        data-title="{{ __('Account List') }}"
                                                        class="btn btn-info me-2 mb-2 text-white"
                                                        data-campaign-id="{{ $campaign->id }}">
                                                        <i class="fa fa-facebook"></i> {{ __('Generate Campaign') }}
                                                    </a>
                                                </div>
                                                
                                                {{-- <div id="progress-{{ $campaign->id }}" class="progress"
                                                    style="width: 200px; ">
                                                    <div id="progress-bar-{{ $campaign->id }}" class="progress-bar"
                                                        role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                        aria-valuemax="100">0%</div>
                                                </div> --}}

                                                {{-- @endif --}}

                                                <form method="POST"
                                                    action="{{ route('delete-campaign', $campaign->id) }}"
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
                <form class="datatable-footer-part" action="{{ route('campaign.filter') }}" method="post">
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
                </form>

            </div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    document.addEventListener('DOMContentLoaded', function() {
        var copyableElements = document.querySelectorAll('.copyable');

        copyableElements.forEach(function(element) {
            element.addEventListener('click', function() {
                var url = element.getAttribute('data-url');
                copyToClipboard(url);
            });
        });
    });

    function copyToClipboard(text) {
        // Create a temporary textarea element
        var textarea = document.createElement("textarea");
        textarea.value = text;
        // Append the textarea to the body
        document.body.appendChild(textarea);
        // Select the text
        textarea.select();
        // Copy the text
        document.execCommand("copy");
        // Remove the textarea from the body
        document.body.removeChild(textarea);
        // Optional: Alert the user
        show_toastr('Success', 'Text copied to clipboard', 'success');
    }
</script>
