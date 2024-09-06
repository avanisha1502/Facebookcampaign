<form action="{{ route('domain.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label>{{ __('Domain URL') }}:</label>
                <textarea class="form-control" name="domain_name" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
        </div>

        <div class="modal-footer col-xs-12 col-sm-12 col-md-12 mt-3">
            <button type="button" class="btn btn-default" data-bs-dismiss="modal">{{ __('Close') }}</button>
            <button type="submit" class="btn btn-primary">{{ __('Add Domain') }}</button>
        </div>
    </div>
</form>