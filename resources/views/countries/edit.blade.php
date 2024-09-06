@extends('admin.home')
@section('contents')
    <div class="row gx-4">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header bg-none fw-bold">
                    Edit Countries
                </div>
                <form action="{{ route('update.countries', $countries->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Short Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="short_code"
                                    value="{{ $countries->short_code }}">
                                @error('short_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Country Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="country_name"
                                    value="{{ $countries->name }}">
                                @error('country_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">

                                <label class="form-label">Language <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="language"
                                    value="{{ $countries->language }}">
                                @error('language')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">

                                <label class="form-label">Group<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="group" value="{{ $countries->group }}">
                                @error('group')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-end ">
                                <button type="submit" class="btn btn-primary">Update Countries</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection
