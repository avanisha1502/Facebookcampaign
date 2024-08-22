@extends('admin.home')

@section('contents')
    <div class="d-flex align-items-center mb-3">
        <div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{ __('PAGES') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Campaign Report') }}</li>
            </ul>
        </div>

        <div class="ms-auto">
            <a class="btn btn-theme" href="#" data-size="md" data-ajax-popup="true"
                data-url="{{ route('campaign-reporting.Accounts') }}" data-title="{{ __('Generate Report') }}"><i
                    class="fa fa-plus-circle fa-fw me-1"></i> {{ __('Generate Report') }}</a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table id="datatableDefault" class="table text-nowrap w-100" style="margin-top:50px;">
                <thead>
                    <tr>
                        {{-- <th>#</th> --}}
                        <th class="">{{ __('Report Name') }}</th>
                        <th class="">{{ __('Created ') }}</th>
                        <th class="">{{ __('Action') }}</th>
                    </tr>
                </thead>
                @if ($reports->count() > 0)
                    
                    <tbody>
                        @foreach ($reports as $index => $report)
                            <tr style="background-color: aliceblue; font-weight: 400;">
                                <td> {{ $report->report_name ?? '' }} </td>
                                <td> {{ date('d-m-Y', strtotime($report->created_at)) }} </td>
                                <td> 
                                    <div class="justify-content-center">
                                        <div class="d-flex">

                                                <a href="{{ route('campaign-reporting.show' , $report->id) }}"
                                                class="btn btn-purple me-2 mb-2"><i class="fa fa-eye"></i>
                                                {{ __('View') }}</a>
                                                
                                                <form method="POST"
                                                    action="{{ route('delete-report', $report->id) }}"
                                                    id="user-form-{{ $report->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="submit" class="btn btn-danger show_confirm">
                                                        <span class="text-white"><i class="fa fa-trash"></i>
                                                            {{ __('Delete') }}</span>
                                                    </button>
                                                </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
        </div>
    </div>

@endsection
