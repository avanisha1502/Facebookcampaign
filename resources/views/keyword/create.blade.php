<form id="keywordForm" action="{{ url('fetch-keywords') }}" method="post">
    @csrf
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label class="mb-2">{{ __('Keyword') }}:</label>
                <textarea class="form-control" name="keyword"
                    id="exampleFormControlTextarea1" rows="3" required></textarea>
                @error('keyword')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="mb-3">
                <label class="form-label">{{ __('Country') }}</label>
                <select class="selectpicker form-control" id="ex-search" name="country">
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
                @error('country')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <input type="hidden" name="domain_id" value="{{ $domain_id->id }}">
        <div class="modal-footer col-xs-12 col-sm-12 col-md-12 mt-3">
            <button type="button" class="btn btn-default" data-bs-dismiss="modal">{{ __('Close') }}</button>
            <button type="submit" class="btn btn-primary" id="submitBtn">{{ __('Add Keyword') }}</button>
            <button class="buttonload btn btn-primary" style="display: none;">
                <i class="fa fa-spinner fa-spin mr-2"></i>Loading
              </button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#keywordForm').on('submit', function() {
            $('#submitBtn').hide(); // Hide the submit button
            $('.buttonload').show(); // Show the loader
        });
    });
</script>
