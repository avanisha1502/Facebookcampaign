<link rel="stylesheet" href="{{  asset('assets/css/bootstrap-tagsinput.css') }}" crossorigin="anonymous">
<style> 
</style>
<form id="keywordForm" action="{{ route('googleadskeyword.store') }}" method="post">
    @csrf
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label class="mb-2">{{ __('Keyword') }}:</label>
                <input type="text" class="form-control" value="" data-role="tagsinput" id="tags" name="keyword" required>
                @error('keyword')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="mb-3">
                <label class="form-label">{{ __('Country') }}</label>
                <select class="selectpicker form-control" id="ex-search" name="country" required>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
                @error('country')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="modal-footer col-xs-12 col-sm-12 col-md-12 mt-3">
            <button type="button" class="btn btn-default" data-bs-dismiss="modal">{{ __('Close') }}</button>
            <button type="submit" class="btn btn-primary" id="submitBtn">{{ __('Add Keyword') }}</button>
            <button class="buttonload btn btn-primary" style="display: none;">
                <i class="fa fa-spinner fa-spin mr-2"></i>Loading
              </button>
            {{-- <div id="loader" style="display: none;">Loading...</div> --}}
        </div>
    </div>
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        $('#keywordForm').on('submit', function() {
            $('#submitBtn').hide(); // Hide the submit button
            $('.buttonload').show(); // Show the loader
        });
    });
</script>