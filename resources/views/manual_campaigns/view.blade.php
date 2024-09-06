@extends('admin.home')

@section('contents')
    <div class="row">
        <div class="col-md-12">
            <div class="card d-flex justify-content-center align-items-center " style="height:86vh;">
                <div class="row col-md-12">
                    <div class="col-md-6 d-flex justify-content-end">
                        <a href="{{ route('new-campaign-manually.adcreative', $campaignAllDetails->id) }}"
                            class="btn btn-purple me-2 mb-2"><i class="fa fa-edit"></i>
                            {{ __('Ad Creatives') }}</a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('suboffer.create', $campaignAllDetails->id) }}"
                            class="btn btn-purple me-2 mb-2"><i class="fa fa-plus-circle fa-fw me-1"></i>
                            {{ __('Add Sub Offer') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
