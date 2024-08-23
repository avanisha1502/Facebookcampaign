@extends('admin.home')

{{-- @push('css') --}}

{{-- @endpush --}}
@section('contents')
    <div class="row gx-4">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header bg-none fw-bold">
                    Facebook Campaign
                </div>
                <form action="{{ route('store-campaign') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Vertical <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="vertical" placeholder="Enter Vertical">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Topic<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="topic" placeholder="Enter Topic">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Campaign Name<span class="text-danger">*</span></label>
                                    <select class="selectpicker form-control" id="ex-search" name="campaing_id">
                                        @foreach ($adscampaign as $campaign)
                                            <option value="{{ $campaign->id }}">
                                                {{ $campaign->name }} - Ad account ID : {{ $campaign->account_id }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Keywords<span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="keyword" placeholder="Enter Keyword" rows="7"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tracking URL<span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="tracking_url" placeholder="Enter Tracking URL" rows="7"></textarea>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" name="is_regions" id="is_regions"
                                        value="1">
                                    <label class="form-check-label" for="is_regions">Regions</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-end ">
                                    <button type="submit" class="btn btn-primary">Add Campaign</button>
                                </div>
                            </div>

                        </div>
                </form>
            </div>
        </div>
    </div>
    @endsection
