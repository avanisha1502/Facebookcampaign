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
                            {{-- @dd($campaign) --}}
                                @if (isset($campaign) && !empty($campaign))
                                @php
                                    $adsets= json_decode($campaign->adsets);
                                    $ads  = json_decode($campaign->ads);
                                @endphp
                                    <!-- Campaign Row -->
                                    <tr>
                                        <td rowspan="{{ count($adsets ?? []) + collect($ads ?? [])->groupBy('adset_id')->count() + 1 }}"
                                            style="border: 1px solid #00000040; padding: 8px;">
                                            {{ $campaign->name }}
                                        </td>
                                        <td style="border: 1px solid #00000040;  padding: 8px;">All</td>
                                        <td style="border: 1px solid #00000040;  padding: 8px;">All</td>
                                        {{-- <td style="border: 1px solid #00000040; padding: 8px;">{{ optional($campaign['campaign'][0] ?? null)['reach'] }}</td> --}}
                                        <td style="border: 1px solid #00000040; padding: 8px;">
                                            {{ number_format(floatval($campaign->reach ?? 0)) }}</td>
                                        <td style="border: 1px solid #00000040; padding: 8px;">
                                            {{ number_format(floatval($campaign->impressions ?? 0)) }}
                                        </td>
                                        <td style="border: 1px solid #00000040; padding: 8px;">
                                            {{ htmlentities('₹ ') . number_format(floatval($campaign->spend ?? 0), 2) }}
                                        </td>
                                        <td style="border: 1px solid #00000040; padding: 8px;">
                                            {{ $campaign->purchase ?? '—' }}</td>
                                        <td style="border: 1px solid #00000040; padding: 8px;">
                                            {{ number_format(floatval($campaign->inline_link_clicks ?? 0)) }}
                                        </td>
                                        <td style="border: 1px solid #00000040; padding: 8px;">
                                            {{ htmlentities('₹ ') . number_format(floatval($campaign->cpc ?? 0), 2) }}
                                        </td>
                                        <td style="border: 1px solid #00000040; padding: 8px;">
                                            {{ htmlentities('₹ ') . number_format(floatval($campaign->cpm ?? 0), 2) }}
                                        </td>
                                        <td style="border: 1px solid #00000040; padding: 8px;">
                                            {{ number_format(floatval($campaign->ctr ?? 0) , 2) }} %
                                        </td>
                                        <input type="hidden" name="campaignsWithInsights[]"
                                        value="{{ json_encode($campaign) }}">

                                    </tr>
                                @endif
                                <!-- Adset Rows -->
                                @foreach (json_decode($campaign->adsets) ?? [] as $adset)
                                    <tr>
                                        <td rowspan="{{ collect($ads ?? [])->where('adset_id', $adset->adset_id)->count() + 1 }}"
                                            style="border: 1px solid #00000040; padding: 8px;">
                                            {{ $adset->name }}
                                        </td>
                                        <td style="border: 1px solid #00000040;  padding: 8px;">All</td>
                                        <td style="border: 1px solid #00000040; padding: 8px;">
                                            {{ number_format(floatval($adset->reach ?? 0)) }}</td>
                                        <td style="border: 1px solid #00000040; padding: 8px;">
                                            {{ number_format(floatval($adset->impressions ?? 0)) }}</td>
                                        <td style="border: 1px solid #00000040; padding: 5px;">
                                            {{ htmlentities('₹ ') . number_format(floatval($ad->spend ?? 0), 2) }}
                                        </td>
                                        <td style="border: 1px solid #00000040; padding: 8px;">
                                            {{ $adset->purchase ?? '—' }}</td>
                                        <td style="border: 1px solid #00000040; padding: 8px;">
                                            {{ number_format(floatval($adset->inline_link_clicks ?? 0)) }}
                                        </td>
                                        <td style="border: 1px solid #00000040; padding: 5px;">
                                            {{ htmlentities('₹ ') . number_format(floatval($adset->cpc ?? 0), 2) }}
                                        </td>
                                        <td style="border: 1px solid #00000040; padding: 5px;">
                                            {{ htmlentities('₹ ') . number_format(floatval($adset->cpm ?? 0), 2) }}
                                        </td>
                                        <td style="border: 1px solid #00000040; padding: 8px;">
                                            {{ number_format(floatval($adset->ctr ?? 0) , 2) }} %</td>
                                    </tr>

                                    <!-- Ad Rows -->
                                    @foreach (json_decode($campaign->ads) ?? [] as $ad)
                                        @if ($ad->adset_id == $adset->adset_id)
                                            <tr>
                                                <td style="border: 1px solid #00000040; padding: 8px;">{{ $ad->name }}
                                                </td>
                                                <td style="border: 1px solid #00000040; padding: 8px;">
                                                    {{ number_format(floatval($ad->reach ?? 0)) }}</td>
                                                <td style="border: 1px solid #00000040; padding: 8px;">
                                                    {{ number_format(floatval($ad->impressions ?? 0)) }}</td>
                                                <td style="border: 1px solid #00000040; padding: 5px;">
                                                    {{ htmlentities('₹ ') . number_format(floatval($ad->spend ?? 0), 2) }}
                                                </td>
                                                <td style="border: 1px solid #00000040; padding: 8px;">
                                                    {{ $ad->purchase ?? '—' }}</td>
                                                <td style="border: 1px solid #00000040; padding: 8px;">
                                                    {{ number_format(floatval($ad->inline_link_clicks ?? 0)) }}
                                                </td>
                                                <td style="border: 1px solid #00000040; padding: 5px;">
                                                    {{ htmlentities('₹ ') . number_format(floatval($ad->cpc ?? 0), 2) }}
                                                </td>
                                                <td style="border: 1px solid #00000040; padding: 5px;">
                                                    {{ htmlentities('₹ ') . number_format(floatval($ad->cpm ?? 0), 2) }}
                                                </td>
                                                <td style="border: 1px solid #00000040; padding: 8px;">
                                                    {{ number_format(floatval($ad->ctr ?? 0),2) }} %</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach

                                @php
                                    $totalReach += floatval($campaign->reach ?? 0);
                                    $totalImpressions += floatval($campaign->impressions ?? 0);
                                    $totalSpend += floatval($campaign->spend ?? 0);
                                    $totalPurchases += 0;
                                    $totalLinkClicks += floatval($campaign->inline_link_clicks ?? 0);
                                    $totalCPC += floatval($campaign->cpc ?? 0);
                                    $totalCPM += floatval($campaign->cpm ?? 0);
                                    $totalCTR += floatval($campaign->ctr ?? 0);
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
