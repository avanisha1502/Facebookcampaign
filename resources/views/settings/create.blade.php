<form action="{{ route('setting.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <div class="mb-3">
                    <label class="mb-2">{{ __('Campaign Name') }}:</label>
                    <select name="group_name" class="form-control">
                        @foreach ($groups as $group)
                            @php
                                $isDisabled = $groupsWithoutSettings->contains($group) ? '' : 'disabled';
                            @endphp
                            <option value="{{ $group->id }}" {{ $isDisabled }}>{{ $group->group }}</option>
                        @endforeach
                    </select>

                    {{-- <select class="selectpicker form-control" id="ex-search" name="group_name">
                        @foreach ($groups as $group)
                            @php
                                $isDisabled = $groupsWithoutSettings->contains($group) ? '' : 'disabled';
                            @endphp
                            <option value="{{ $group->id }}" {{ $isDisabled }}>{{ $group->group }}</option>
                        @endforeach
                    </select> --}}
                </div>
            </div>
        </div>

    </div>

    <div class="modal-footer col-xs-12 col-sm-12 col-md-12 mt-3">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" class="btn btn-primary">{{ __('Add Name') }}</button>
    </div>
    </div>
</form>
