<form action="{{ route('campaignads.store') }}" method="POST"  enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
            <div class="form-group">
                <label>{{ __('Name') }}:</label>
                <input type="text" class="form-control" name="campaign_name">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
            <div class="form-group">
                <label>{{ __('Objective') }}:</label>
                <input type="text" class="form-control" name="campaign_objective">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
            <div class="form-group">
                <label>{{ __('Ad Set Name') }}:</label>
                <input type="text" class="form-control" name="adset_name">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
            <div class="form-group">
                <label>{{ __('Daily budget') }}:</label>
                <input type="text" class="form-control" name="daily_budget">
            </div>
        </div>

        {{-- <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
            <div class="form-group">
                <label>{{ __('Bid Amount') }}:</label>
                <input type="text" class="form-control" name="bid_amount">
            </div>
        </div> --}}

        <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
            <div class="form-group">
                <label>{{ __('ad name') }}:</label>
                <input type="text" class="form-control" name="ad_name">
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
            <div class="form-group">
                <label>{{ __('Facebook Page') }}:</label>
                <select class="selectpicker form-control" id="ex-search" name="facebook_page" required>
                    @foreach ($pages['data'] as $page)
                        <option value="{{ $page['id'] }}"> <img src="{{ $page['picture']['data']['url'] }}"
                            style="border-radius: 35px;width: 35px;height: 35px;"> {{ $page['name'] }} - ID: {{ $page['id'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label>{{ __('Image') }}:</label>
                {{-- <input type="file" name="image" required> --}}
                <input type="file" class="form-control" name="image">
            </div>
        </div>

        <div class="modal-footer col-xs-12 col-sm-12 col-md-12 mt-3">
            <button type="button" class="btn btn-default" data-bs-dismiss="modal">{{ __('Close') }}</button>
            <button type="submit" class="btn btn-primary">{{ __('Add Campaign') }}</button>
        </div>
    </div>
</form>
