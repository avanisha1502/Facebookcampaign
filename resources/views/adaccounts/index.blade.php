@extends('admin.home')

@section('contents')
    <div class="d-flex align-items-center mb-3">
        <div>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{ __('PAGES') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Facebook') }}</li>
            </ul>
        </div>
    </div>

    <div class="card mb-4" style="position: relative;">
        <div class="card-body">
            <div class="row">
                {{-- <div class="col-md-6">
                    <form id="campaignFilterForm" action="{{ route('adsaccounts.filter') }}" method="post">
                        @csrf
                        <div class="campaign_select">
                            <div class="dropdown-wrapper toggle">
                                <span class="dropdown-heading">
                                    {{ $adscampaign->firstWhere('id', $defaultCampaignId)->name ?? 'Select Campaign' }}
                                    ({{ $adscampaign->firstWhere('id', $defaultCampaignId)->account_id ?? 'No Account ID' }})
                                </span>

                
                                <div class="icon-wrapper">
                                    <i class="toggle fa fa-chevron-down"></i>
                                    <div class="dropdown-content">
                                        <ul>
                                            @foreach ($adscampaign as $campaign)
                                                <li>
                                                    <input type="radio" name="campaing_id" value="{{ $campaign->id }}"
                                                        {{ $campaign->id == $defaultCampaignId ? 'checked' : '' }}
                                                        id="campaign_{{ $campaign->id }}"
                                                        onchange="document.getElementById('campaignFilterForm').submit();">
                                                    <label for="campaign_{{ $campaign->id }}">
                                                        <strong class="mb-2">{{ $campaign->name }}</strong>
                                                        <span>Ad account ID: {{ $campaign->account_id }}</span>
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div> --}}
                <div class="col-md-12 d-flex justify-content-end">
                    <button id="refresh-button" class="btn btn-theme"><i class="fa-solid fa-redo"></i> {{ __('Refresh') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="position: relative;">
        <div class="table-responsive">
            <div id="datatable" class="mb-5">
                
                <div class="dt-search Search">
                    <form action="{{ route('accounts.filter') }}" method="post" role="search">
                        @csrf
                        <div class="input-group position-relative">
                            <input type="search" class="form-control rounded-start" id="input" name="search"
                                placeholder="Search" value="{{ request()->get('search') ?? '' }}">
                            <button class="btn btn-theme fs-13px fw-semibold" type="submit">Search</button>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <table id="datatable" class="table text-nowrap w-100 table-striped" style="margin-top:50px;">
                        <thead>
                            <tr>
                                {{-- <th>#</th> --}}
                                <th class="">{{ __('Name') }}</th>
                                <th class="">{{ __('Account ID') }}</th>
                                <th class="">{{ __('Act Account Id') }}</th>
                            </tr>
                        </thead>
                        @if ($accounts->count() > 0)
                            <tbody>
                                @foreach ($accounts as $index => $account)
                                <tr style="background-color: aliceblue; font-weight: 500;">
                                    <td class="">{{ $account->name }}</td>
                                    <td class="">{{ $account->account_id }}</td>
                                    <td class="">{{ $account->act_account_id }}</td>
                                </tr>
                                @endforeach

                            </tbody>
                        @endif

                    </table>
                </div>
                <form class="datatable-footer-part" action="{{ route('accounts.filter') }}" method="post">
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
                    <div class="datable-footer-part-2"> {{ $accounts->firstItem() }} ~
                        {{ $accounts->lastItem() }}
                    </div>
                    <div class="datable-footer-part-3">{{ $accounts->links('vendor.pagination.bootstrap-4') }}</div>
                </form>

            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        let toggle = function() {
            document.querySelectorAll('.dropdown-wrapper')[0].classList.toggle('active');
        }
        document.querySelectorAll('.toggle')[0].addEventListener("click", toggle);
    </script>

    <script>
        document.getElementById('refresh-button').addEventListener('click', function() {
            fetch('{{ route('adaccounts') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.success) {
                        updateAdAccountsTable(data.accounts); 
                        show_toastr('Success', 'Accounts Refeshed successfully', 'success');
                    } else {
                        show_toastr('Error', 'Failed to refresh Accounts.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    show_toastr('Error', 'An error occurred while refreshing Accounts.', 'error');
                });
        });

        function updateAdAccountsTable(accounts) {
        const tableBody = document.querySelector('#datatable tbody');
        tableBody.innerHTML = ''; // Clear existing rows

        accounts.forEach(account => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${account.id}</td>
                <td>${account.name}</td>
                <td>${account.status}</td>
            `;
            tableBody.appendChild(row);
        });
    }
    </script>
@endpush
