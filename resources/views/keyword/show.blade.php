@extends('admin.home')
@section('contents')
    @php
        $organicResults = json_decode($keyword_details['organic_results'], true);
        $count = 1; 
    @endphp
    <div class="row">
        <div class="col-sm-12">
            @foreach ($organicResults as $related_serch)
                <!-- using grid -->
                <div class="card mb-3 shadow-box">
                    <div class="card-body {{ $count == $keyword_details->position ? 'postion-get' : '' }}">
                        <h5 class="card-title mb-3">{{ $count }}<b>. </b> {{ $related_serch['title'] }}</h5>
                        <a href="{{ $related_serch['link'] }}" target="_blank"> <p class="card-text">{{ $related_serch['displayed_link'] }}</p> </a>
                    </div>
                </div>
                @php $count++; @endphp
            @endforeach
        </div>
    </div>
@endsection
