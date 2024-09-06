<form id="campaign-form" action="{{ route('campaignreport.generate') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="report_name">{{ __('Report name ∙ Optional') }}</label>
        <input type="text" id="report_name" class="form-control" name="report_name" placeholder="Untitled report"/>
    </div>

    <div class="row mb-3">
        <div class="custom-select-wrapper">
            <div class="custom-select">
                <label> {{ __('Account ID:') }} </label>
                <div class="custom-select__trigger"><span>{{ __('Select an account') }}</span>
                    <div class="arrow"></div>
                </div>
                <div class="custom-options">
                    @foreach ($adscampaign as $campaigns)
                        @php
                            if ($campaigns->account_status == '202') {
                                $status = 'Any Closed';
                                $bgColor = '#FFB3BA'; // Light Red
                                $Color = 'black';
                            } elseif ($campaigns->account_status == '2') {
                                $status = 'Disabled';
                                $bgColor = 'red'; // Light Green
                                $Color = 'white';
                            } elseif ($campaigns->account_status == '3') {
                                $status = 'Un Settled';
                                $bgColor = '#BAE1FF'; // Light Blue
                                $Color = 'black';
                            } elseif ($campaigns->account_status == '101') {
                                $status = 'Closed';
                                $bgColor = '#FFDFBA'; // Light Orange
                                $Color = 'black';
                            } elseif ($campaigns->account_status == '201') {
                                $status = 'Any Active';
                                $bgColor = '#FFFFBA'; // Light Yellow
                                $Color = 'black';
                            } else {
                                $status = 'Active';
                                $bgColor = '#1ca911'; // Light Gray
                                $Color = 'white';
                            }
                        @endphp
                        <span class="custom-option" data-value="{{ $campaigns->account_id }}">
                            {{ $campaigns->name }} - {{ $campaigns->account_id }}
                            <span class="status-label"
                                style="background-color: {{ $bgColor }}; color: {{ $Color }};">{{ $status }}</span>
                        </span>
                    @endforeach
                </div>
            </div>
            <input type="hidden" name="account_id" id="account_id_input">
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">{{ __('Generate Report') }}</button>
    </div>
</form>


<script>
    document.querySelector('.custom-select-wrapper').addEventListener('click', function() {
        this.querySelector('.custom-select').classList.toggle('open');
    })

    for (const option of document.querySelectorAll(".custom-option")) {
        option.addEventListener('click', function() {
            if (!this.classList.contains('selected')) {
                if (this.parentNode.querySelector('.custom-option.selected')) {
                    this.parentNode.querySelector('.custom-option.selected').classList.remove('selected');
                }
                this.classList.add('selected');

                // Update the trigger text
                let selectedText = this.textContent.trim();
                let statusLabel = this.querySelector('.status-label');
                if (statusLabel) {
                    selectedText = selectedText.replace(statusLabel.textContent.trim(), '').trim();
                }
                this.closest('.custom-select').querySelector('.custom-select__trigger span').textContent =
                    selectedText;

                // Update the hidden input value
                document.querySelector('#account_id_input').value = this.getAttribute('data-value');
            }
        })
    }

    window.addEventListener('click', function(e) {
        const select = document.querySelector('.custom-select')
        if (!select.contains(e.target)) {
            select.classList.remove('open');
        }
    });
</script>
