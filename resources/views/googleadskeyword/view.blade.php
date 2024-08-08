@extends('admin.home')
@section('contents')

<h5> <img src="{{ $Country->image_url }}" class="img-flag">  <span> {{ $GoogleKeyword->name }} </span> {{ number_format(floatval($GoogleKeyword->monthly_search)) }} {{ '/Month' }}.</h5>
<hr>
<h4 class="Right-modal-titile"> {{ __('Search Volume Trend') }} </h4>
@php
    $searchTrendData = json_decode($GoogleKeyword->search_trend, true);
    $categories = [];
    $seriesData = [];
    foreach ($searchTrendData as $trend) {
        // Adjust the month and year if month is greater than 12
        $month = $trend['month'];
        $year = $trend['year'];
        if ($month > 12) {
            $year += floor(($month - 1) / 12);
            $month = (($month - 1) % 12) + 1;
        }
        $monthYear = date('M,y', strtotime("{$year}-{$month}-01"));

        // Add month and year to categories
        $categories[] = $monthYear;

        // Add monthly searches to series data
        $seriesData[] = $trend['monthly_searches'];
    }
    $count = 1;
@endphp
<div id="apexAreaChart"></div>


<h4 class="Right-modal-titile">
    {{ __('Google Search Result') }}
</h4>
<hr>
<div class="keywordBox">
    @foreach ($organicResults as $googleWords)
        <div class="card mb-3 shadow-box p-10">
            <div class="card-body">
                <h6 class="card-title mb-3"><b>  {{ $count }}. </b>  {{ $googleWords['title'] }} </h6>
                <a href="{{ $googleWords['url'] }}" target="_blank">
                    <p class="card-text">{{ $googleWords['url'] }}</p>
                </a>
            </div>
        </div>
        @php $count++; @endphp
    @endforeach
</div>
@endsection

@push('scripts')
<script>
    var apexAreaChartOptions = {
        chart: {
            height: 350,
            type: 'area',
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth',
            width: 3
        },
        colors: [app.color.teal, app.color.inverse],
        series: [{
            name: 'Monthly Searches',
            // data: [31, 40, 28, 51, 42, 109, 100]
            data: {!! json_encode($seriesData) !!}
        }, ],
        xaxis: {
            categories: {!! json_encode($categories) !!},
            axisBorder: {
                show: true,
                color: app.color.inverse,
                height: 1,
                width: '100%',
                offsetX: 0,
                offsetY: -1
            },
            axisTicks: {
                show: true,
                borderType: 'solid',
                color: app.color.inverse,
                height: 6,
                offsetX: 0,
                offsetY: 0
            }
        },
        yaxis: {
            min: 500, // Start value
            tickAmount: 10, // Number of ticks
            labels: {
                formatter: function(value) {
                    return value.toFixed(0); // Format the labels
                }
            }
        },
        tooltip: {
            enabled: true,
            x: {
                format: 'dd/MM/yy HH:mm'
            }
        }
    };
    var apexAreaChart = new ApexCharts(
        document.querySelector('#apexAreaChart'),
        apexAreaChartOptions
    );
    apexAreaChart.render();
</script>
@endpush

