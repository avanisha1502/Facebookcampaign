@extends('admin.home')

@section('contents')
    <div class="d-flex align-items-center mb-3">
        <div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{ __('PAGES') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Countries') }}</li>
            </ul>
        </div>

        <div class="ms-auto">
            <a class="btn btn-theme" href="{{ route('create.countries') }}" data-title="{{ __('Add New Countries') }}"><i
                    class="fa fa-plus-circle fa-fw me-1"></i> {{ __('Add Countries') }}</a>
        </div>
    </div>
    <div class="card" style="position: relative;">
        <div class="table-responsive">
            <div id="datatable" class="mb-5">
                <div class="dt-search Search">
                    <form action="{{ route('countries.filter') }}" method="post" role="search">
                        @csrf
                        <div class="input-group position-relative">
                            <input type="search" class="form-control rounded-start" id="input" name="search"
                                placeholder="Search" value="{{ request()->get('search') ?? '' }}">
                            <button class="btn btn-theme fs-13px fw-semibold" type="submit">Search</button>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <table id="datatableDefault" class="table text-nowrap w-100" style="margin-top:50px;">
                        <thead>
                            <tr>
                                {{-- <th>#</th> --}}
                                <th class="">{{ __('Short Code') }}</th>
                                <th class="">{{ __('Country Name') }}</th>
                                <th class="">{{ __('Language') }}</th>
                                <th class="">{{ __('Group') }}</th>
                                <th class="">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($countries as $country)
                                <tr>
                                    <td>{{ $country->short_code }}</td>
                                    <td>{{ $country->name }}</td>
                                    <td>{{ $country->language }}</td>
                                    <td>{{ $country->group }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <div>
                                                <a class="btn btn-primary  me-2"
                                                    href="{{ route('edit.countries', $country->id) }}"
                                                    data-title="{{ __('Edit Countries') }}"><i
                                                        class="fa fa-edit fa-fw me-1"></i>
                                                    {{ __('Edit') }}</a>
                                            </div>

                                            <form method="POST" action="{{ route('destroy.countries', $country->id) }}"
                                                id="user-form-{{ $country->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button type="submit" class="btn btn-danger show_confirm">
                                                    <span class="text-white"><i class="fa fa-trash fa-fw me-1"></i>
                                                        {{ __('Delete') }}</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
                <form class="datatable-footer-part" action="{{ route('countries.filter') }}" method="post">
                    @csrf
                    <div class="datable-footer-part-1">
                        <select name="data_filter" id="data_filter" onchange="javascript:this.form.submit()">
                            @if ($data_filter == '10')
                                <option value="10" selected>10</option>
                            @else
                                <option value="10">10</option>
                            @endif

                            @if ($data_filter == '25')
                                <option value="25" selected>25</option>
                            @else
                                <option value="25">25</option>
                            @endif

                            @if ($data_filter == '50')
                                <option value="50" selected>50</option>
                            @else
                                <option value="50">50</option>
                            @endif

                            @if ($data_filter == '100')
                                <option value="100" selected>100</option>
                            @else
                                <option value="100">100</option>
                            @endif
                        </select>
                        <span>Entries per page</span>
                    </div>
                    <input type="hidden" name="search" value="{{ request()->get('search') }}">
                    <div class="datable-footer-part-2"> {{ $countries->firstItem() }} ~
                        {{ $countries->lastItem() }}
                    </div>
                    <div class="datable-footer-part-3">{{ $countries->links('vendor.pagination.bootstrap-4') }}</div>
                </form>
            </div>
        </div>
    </div>
@endsection

<script>
    function copyToClipboard(text) {
        // Create a temporary textarea element
        var textarea = document.createElement("textarea");
        textarea.value = text;
        // Append the textarea to the body
        document.body.appendChild(textarea);
        // Select the text
        textarea.select();
        // Copy the text
        document.execCommand("copy");
        // Remove the textarea from the body
        document.body.removeChild(textarea);
        // Optional: Alert the user
        show_toastr('Success', 'Text copied to clipboard', 'success');
    }
</script>
