@extends('admin.home')
@section('contents')
    <div class="row gx-4">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header bg-none fw-bold">
                    Create Countries
                </div>
                <form action="{{ route('store.countries') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Short Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="short_code" placeholder="Enter Short Code">
                                @error('short_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Country Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="country_name"
                                    placeholder="Enter Country Name">
                                @error('country_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">

                                <label class="form-label">Language <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="language" placeholder="Enter Language">

                                @error('language')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">

                                <label class="form-label">Group<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="group" placeholder="Enter Group">

                                @error('group')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-end ">
                                <button type="submit" class="btn btn-primary">Add Countries</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
