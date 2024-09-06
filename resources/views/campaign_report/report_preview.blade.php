@extends('admin.home')

@section('contents')
    @if (!empty($campaignsWithInsights))
        <form action="{{ route('campaignreport.save', $reports->id ?? '') }}" method="POST">
            @csrf
            <div class="row mb-5">
                <div class="col-md-6 d-flex g-10">
                    <input type="text" class="hidden" name="report_id" value="{{ $reports->id }}" id="report_id">
                    <input type="hidden" name="account_id" value="{{ $account }}">
                    {{-- <button  type="button"  class="btn btn-outline-indigo"> <i class="fa fa-arrow-left mr-3" aria-hidden="true"></i> All Reports</button> --}}
                    <button type="button" class="btn btn-outline-indigo" data-action="all-reports">
                        <i class="fa fa-arrow-left mr-3" aria-hidden="true"></i> All Reports
                    </button>
                    <input type="text" name="report_name" class="form-control"
                        value="{{ old('report_name', $report_name) }}" style="width: 155px;">
                    <button type="button" class="btn btn-outline-indigo">{{ __('Account ID : ') . $accountId }} </button>
                </div>
                <div class="col-md-6 d-flex g-10 justify-content-end">
                    <button type="submit" class="btn btn-success">{{ __('Save Report') }}</button>
                    <button type="button" class="btn btn-primary" onclick="location.reload()"> <i
                            class="fa-solid fa-redo mr-3"></i>{{ __('Refresh') }}</button>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style=" padding: 8px;">Campaign Name</th>
                                <th style=" padding: 8px;">Adset Name</th>
                                <th style=" padding: 8px;">Ad Name</th>
                                <th style=" padding: 8px;">Reach</th>
                                <th style=" padding: 8px;">Impressions</th>
                                <th style=" padding: 8px;">Spend</th>
                                <th style=" padding: 8px;">{{ __('Purchase') }}</th>
                                <th style=" padding: 8px;">{{ __('Inline Link Clicks') }}</th>
                                <th style=" padding: 8px;">CPC</th>
                                <th style=" padding: 8px;">CPM</th>
                                <th style=" padding: 8px;">CTR</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalReach = 0;
                                $totalImpressions = 0;
                                $totalSpend = 0;
                                $totalPurchases = 0;
                                $totalLinkClicks = 0;
                                $totalCPC = 0;
                                $totalCPM = 0;
                                $totalCTR = 0;
                            @endphp
                            @foreach ($campaignsWithInsights as $campaign)
                                @if (isset($campaign['campaign'][0]) && !empty($campaign['campaign'][0]))
                                    <!-- Campaign Row -->
                                    <tr>
                                        <td rowspan="{{ count($campaign['adsets'] ?? []) +collect($campaign['ads'] ?? [])->groupBy('adset_id')->count() +1 }}"
                                            style="border: 1px solid #00000040; padding: 8px;">
                                            {{ $campaign['name'] }}
                                        </td>
                                        <td style="border: 1px solid #00000040;  padding: 8px;">All</td>
                                        <td style="border: 1px solid #00000040;  padding: 8px;">All</td>
                                        {{-- <td style="border: 1px solid #00000040; padding: 8px;">{{ optional($campaign['campaign'][0] ?? null)['reach'] }}</td> --}}
                                        <td style="border: 1px solid #00000040; padding: 8px;">
                                            {{ number_format(floatval($campaign['campaign'][0]['reach'] ?? 0)) }}</td>
                                        <td style="border: 1px solid #00000040; padding: 8px;">
                                            {{ number_format(floatval($campaign['campaign'][0]['impressions'] ?? 0)) }}
                                        </td>
                                        <td style="border: 1px solid #00000040; padding: 8px;">
                                            {{ htmlentities('₹ ') . number_format(floatval($campaign['campaign'][0]['spend'] ?? 0), 2) }}
                                        </td>
                                        <td style="border: 1px solid #00000040; padding: 8px;">
                                            {{ $campaign['campaign'][0]['purchase'] ?? '—' }}</td>
                                        <td style="border: 1px solid #00000040; padding: 8px;">
                                            {{ number_format(floatval($campaign['campaign'][0]['inline_link_clicks'] ?? 0)) }}
                                        </td>
                                        <td style="border: 1px solid #00000040; padding: 8px;">
                                            {{ htmlentities('₹ ') . number_format(floatval($campaign['campaign'][0]['cpc'] ?? 0), 2) }}
                                        </td>
                                        <td style="border: 1px solid #00000040; padding: 8px;">
                                            {{ htmlentities('₹ ') . number_format(floatval($campaign['campaign'][0]['cpm'] ?? 0), 2) }}
                                        </td>
                                        <td style="border: 1px solid #00000040; padding: 8px;">
                                            {{ number_format(floatval($campaign['campaign'][0]['ctr'] ?? 0) , 2) }} %
                                        </td>
                                        <input type="hidden" name="campaignsWithInsights[]"
                                        value="{{ json_encode($campaign) }}">

                                    </tr>
                                @endif

                                <!-- Adset Rows -->
                                @foreach ($campaign['adsets'] ?? [] as $adset)
                                    <tr>
                                        <td rowspan="{{ collect($campaign['ads'] ?? [])->where('adset_id', $adset['adset_id'])->count() + 1 }}"
                                            style="border: 1px solid #00000040; padding: 8px;">
                                            {{ $adset['name'] }}
                                        </td>
                                        <td style="border: 1px solid #00000040;  padding: 8px;">All</td>
                                        <td style="border: 1px solid #00000040; padding: 8px;">
                                            {{ number_format(floatval($adset['reach'] ?? 0)) }}</td>
                                        <td style="border: 1px solid #00000040; padding: 8px;">
                                            {{ number_format(floatval($adset['impressions'] ?? 0)) }}</td>
                                        <td style="border: 1px solid #00000040; padding: 5px;">
                                            {{ htmlentities('₹ ') . number_format(floatval($ad['spend'] ?? 0), 2) }}
                                        </td>
                                        <td style="border: 1px solid #00000040; padding: 8px;">
                                            {{ $adset['purchase'] ?? '—' }}</td>
                                        <td style="border: 1px solid #00000040; padding: 8px;">
                                            {{ number_format(floatval($adset['inline_link_clicks'] ?? 0)) }}
                                        </td>
                                        <td style="border: 1px solid #00000040; padding: 5px;">
                                            {{ htmlentities('₹ ') . number_format(floatval($adset['cpc'] ?? 0), 2) }}
                                        </td>
                                        <td style="border: 1px solid #00000040; padding: 5px;">
                                            {{ htmlentities('₹ ') . number_format(floatval($adset['cpm'] ?? 0), 2) }}
                                        </td>
                                        <td style="border: 1px solid #00000040; padding: 8px;">
                                            {{ number_format(floatval($adset['ctr'] ?? 0) , 2) }} %</td>
                                    </tr>

                                    <!-- Ad Rows -->
                                    @foreach ($campaign['ads'] ?? [] as $ad)
                                        @if ($ad['adset_id'] == $adset['adset_id'])
                                            <tr>
                                                <td style="border: 1px solid #00000040; padding: 8px;">{{ $ad['name'] }}
                                                </td>
                                                <td style="border: 1px solid #00000040; padding: 8px;">
                                                    {{ number_format(floatval($ad['reach'] ?? 0)) }}</td>
                                                <td style="border: 1px solid #00000040; padding: 8px;">
                                                    {{ number_format(floatval($ad['impressions'] ?? 0)) }}</td>
                                                <td style="border: 1px solid #00000040; padding: 5px;">
                                                    {{ htmlentities('₹ ') . number_format(floatval($ad['spend'] ?? 0), 2) }}
                                                </td>
                                                <td style="border: 1px solid #00000040; padding: 8px;">
                                                    {{ $ad['purchase'] ?? '—' }}</td>
                                                <td style="border: 1px solid #00000040; padding: 8px;">
                                                    {{ number_format(floatval($ad['inline_link_clicks'] ?? 0)) }}
                                                </td>
                                                <td style="border: 1px solid #00000040; padding: 5px;">
                                                    {{ htmlentities('₹ ') . number_format(floatval($ad['cpc'] ?? 0), 2) }}
                                                </td>
                                                <td style="border: 1px solid #00000040; padding: 5px;">
                                                    {{ htmlentities('₹ ') . number_format(floatval($ad['cpm'] ?? 0), 2) }}
                                                </td>
                                                <td style="border: 1px solid #00000040; padding: 8px;">
                                                    {{ number_format(floatval($ad['ctr'] ?? 0),2) }} %</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach

                                @php
                                    $totalReach += floatval($campaign['campaign'][0]['reach'] ?? 0);
                                    $totalImpressions += floatval($campaign['campaign'][0]['impressions'] ?? 0);
                                    $totalSpend += floatval($campaign['campaign'][0]['spend'] ?? 0);
                                    $totalPurchases += 0;
                                    $totalLinkClicks += floatval($campaign['campaign'][0]['inline_link_clicks'] ?? 0);
                                    $totalCPC += floatval($campaign['campaign'][0]['cpc'] ?? 0);
                                    $totalCPM += floatval($campaign['campaign'][0]['cpm'] ?? 0);
                                    $totalCTR += floatval($campaign['campaign'][0]['ctr'] ?? 0);
                                @endphp
                            @endforeach
                        </tbody>
                        <tfoot >
                            <tr style="border: 1px solid #00000040; ">
                                <td colspan="3" style="padding: 8px;">{{ __('Total') }}</td>
                                <td style="border: 1px solid #00000040; padding: 8px;">{{ number_format($totalReach) }}</td>
                                <td style="border: 1px solid #00000040; padding: 8px;">{{ number_format($totalImpressions) }}</td>
                                <td style="border: 1px solid #00000040; padding: 5px;">{{ htmlentities('₹ ') . number_format($totalSpend, 2) }}</td>
                                <td style="border: 1px solid #00000040; padding: 8px;">{{ $totalPurchases }}</td>
                                <td style="border: 1px solid #00000040; padding: 5px;">{{ number_format($totalLinkClicks) }}</td>
                                <td style="border: 1px solid #00000040; padding: 5px;">{{ htmlentities('₹ ') . number_format($totalCPC, 2) }}</td>
                                <td style="border: 1px solid #00000040; padding: 5px;">{{ htmlentities('₹ ') . number_format($totalCPM) }}</td>
                                <td style="border: 1px solid #00000040; padding: 5px;">{{ number_format($totalCTR , 2) }} %</td>
                            </tr>
                        </tfoot>

                    </table>

                    {{-- <table id="datatableDefault" class="table text-nowrap w-100">
                        <thead>
                            <tr>
                                <th>{{ __('Campaign Name') }}</th>
                                <th>{{ __('Ad Set Name') }}</th>
                                <th>{{ __('Ad Name') }}</th>
                                <th>{{ __('Reach') }}</th>
                                <th>{{ __('Impressions') }}</th>
                                <th>{{ __('Spend') }}</th>
                                <th>{{ __('Purchase') }}</th>
                                <th>{{ __('Inline Link Clicks') }}</th>
                                <th>{{ __('CPC') }}</th>
                                <th>{{ __('CPM') }}</th>
                                <th>{{ __('CTR') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalReach = 0;
                                $totalImpressions = 0;
                                $totalSpend = 0;
                                $totalPurchases = 0;
                                $totalLinkClicks = 0;
                                $totalCPC = 0;
                                $totalCPM = 0;
                                $totalCTR = 0;
                            @endphp

                            @foreach ($campaignsWithInsights as $campaign)
                                @if (isset($campaign['campaign'][0]) && !empty($campaign['campaign'][0]))
                                    <!-- Campaign Row -->
                                    <tr style="background-color: aliceblue;">
                                        
                                        <td>
                                           
                                                {{ $campaign['campaign'][0]['name'] }}
                                        </td>
                                        <td> </td>
                                        <td> </td>
                                        <td >{{ number_format(floatval($campaign['campaign'][0]['reach'] ?? 0)) }}</td>
                                        <td>{{ number_format(floatval($campaign['campaign'][0]['impressions'] ?? 0)) }}
                                        </td>
                                        <td>{{ htmlentities('₹ ') . number_format(floatval($campaign['campaign'][0]['spend'] ?? 0), 2) }}
                                        </td>
                                        <td>{{ $campaign['campaign'][0]['purchase'] ?? '--' }}</td>
                                        <td>{{ number_format(floatval($campaign['campaign'][0]['inline_link_clicks'] ?? 0)) }}
                                        </td>
                                        <td>{{ htmlentities('₹ ') . number_format(floatval($campaign['campaign'][0]['cpc'] ?? 0), 2) }}
                                        </td>
                                        <td>{{ htmlentities('₹ ') . number_format(floatval($campaign['campaign'][0]['cpm'] ?? 0), 2) }}
                                        </td>
                                        <td>{{ floatval($campaign['campaign'][0]['ctr'] ?? 0) }} %</td>
                                    </tr>
                                @endif

                                <!-- Ad Sets Rows -->
                                @if (!empty($campaign['adsets']))
                                    @foreach ($campaign['adsets'] as $adset)
                                        <tr>
                                            <td> </td>
                                            <td style="padding-left: 20px;">
                                                <div>
                                                    {{ $adset['name'] }}
                                                </div>
                                            </td>
                                            <td>{{ number_format(floatval($adset['reach'] ?? 0)) }}</td>
                                            <td>{{ number_format(floatval($adset['impressions'] ?? 0)) }}</td>
                                            <td>{{ htmlentities('₹ ') . number_format(floatval($adset['spend'] ?? 0), 2) }}
                                            </td>
                                            <td>{{ $adset['purchase'] ?? '--' }}</td>
                                            <td>{{ number_format(floatval($adset['inline_link_clicks'] ?? 0)) }}</td>
                                            <td>{{ htmlentities('₹ ') . number_format(floatval($adset['cpc'] ?? 0), 2) }}
                                            </td>
                                            <td>{{ htmlentities('₹ ') . number_format(floatval($adset['cpm'] ?? 0), 2) }}
                                            </td>
                                            <td>{{ floatval($adset['ctr'] ?? 0) }} %</td>
                                        </tr>

                                        @if (!empty($campaign['ads']))
                                            @foreach ($campaign['ads'] as $ad)
                                                @if ($ad['adset_id'] === $adset['adset_id'])
                                                    <tr>
                                                        <td> </td>
                                                        <td> </td>
                                                        <td style="padding-left: 40px;"><div> {{ $ad['name'] }} </div></td>
                                                        <td>{{ number_format(floatval($ad['reach'] ?? 0)) }}</td>
                                                        <td>{{ number_format(floatval($ad['impressions'] ?? 0)) }}</td>
                                                        <td>{{ htmlentities('₹ ') . number_format(floatval($ad['spend'] ?? 0), 2) }}
                                                        </td>
                                                        <td>{{ $ad['purchase'] ?? '--' }}</td>
                                                        <td>{{ number_format(floatval($ad['inline_link_clicks'] ?? 0)) }}
                                                        </td>
                                                        <td>{{ htmlentities('₹ ') . number_format(floatval($ad['cpc'] ?? 0), 2) }}
                                                        </td>
                                                        <td>{{ htmlentities('₹ ') . number_format(floatval($ad['cpm'] ?? 0), 2) }}
                                                        </td>
                                                        <td>{{ floatval($ad['ctr'] ?? 0) }} %</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif

                                @php
                                    $totalReach += floatval($campaign['reach'] ?? 0);
                                    $totalImpressions += floatval($campaign['impressions'] ?? 0);
                                    $totalSpend += floatval($campaign['spend'] ?? 0);
                                    $totalPurchases += 0;
                                    $totalLinkClicks += floatval($campaign['inline_link_clicks'] ?? 0);
                                    $totalCPC += floatval($campaign['cpc'] ?? 0);
                                    $totalCPM += floatval($campaign['cpm'] ?? 0);
                                    $totalCTR += floatval($campaign['ctr'] ?? 0);
                                @endphp
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">{{ __('Total') }}</td>
                                <td>{{ number_format($totalReach) }}</td>
                                <td>{{ number_format($totalImpressions) }}</td>
                                <td>{{ htmlentities('₹ ') . number_format($totalSpend, 2) }}</td>
                                <td>{{ $totalPurchases }}</td>
                                <td>{{ number_format($totalLinkClicks) }}</td>
                                <td>{{ htmlentities('₹ ') . number_format($totalCPC, 2) }}</td>
                                <td>{{ htmlentities('₹ ') . number_format($totalCPM) }}</td>
                                <td>{{ $totalCTR }} %</td>
                            </tr>
                        </tfoot>
                    </table> --}}

        </form>
    @else
        <p>{{ __('No report data available.') }}</p>
    @endif
@endsection


@push('scripts')
    <script>
        let isDirty = false;
        let form = null;
        let hasChanges = false; // Flag to indicate if there are unsaved changes

        function setDirty() {
            isDirty = true;
            hasChanges = true; // Mark as having changes
        }

        function getHiddenInputsData() {
            const hiddenInputs = document.querySelectorAll('input[name="campaignsWithInsights[]"]');
            return Array.from(hiddenInputs).map(input => JSON.parse(input.value));
        }

        function showConfirmationPopup(action) {
            // If there are no unsaved changes, just perform the action
            if (!isDirty) {
                action();
                return;
            }

            const confirmation = confirm('You have unsaved changes. Do you want to save them before leaving?');
            if (confirmation) {
                saveChanges(action); // Call saveChanges to handle saving
            } else {
                action(); // Proceed with the action without saving
            }
        }

        function saveChanges(callback) {
            const campaignData = getHiddenInputsData();
            var reportId = $('#report_id').val();
            console.log(reportId);

            // Assuming there's an endpoint for saving changes
            // url: '{{ route('campaignreport.save', '') }}/' + reportId,
            fetch(`{{ route('campaignreport.save', '') }}/' + reportId`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        campaignsWithInsights: campaignData
                    })
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        hasChanges = false; // Update flag after successful save
                        callback(); // Proceed with the action
                    } else {
                        alert('Failed to save data. Please try again.');
                    }
                })
                .catch(error => {
                    alert('An error occurred while saving. Please try again.');
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            form = document.querySelector('form');
            document.querySelectorAll('button[data-action]').forEach(function(button) {
                button.addEventListener('click', function() {
                    const action = button.getAttribute('data-action');
                    if (action === 'all-reports') {
                        showConfirmationPopup(function() {
                            window.location.href =
                                '{{ url('campaign-reporting') }}'; // Navigate to All Reports
                        });
                    } else if (action === 'refresh') {
                        showConfirmationPopup(function() {
                            window.location.reload(); // Refresh the page
                        });
                    }
                });
            });
        });

        window.addEventListener('beforeunload', function(e) {
            if (isDirty) {
                const confirmationMessage = 'You have unsaved changes. Are you sure you want to leave?';
                e.returnValue = confirmationMessage;
                return confirmationMessage;
            }
        });
    </script>
@endpush
