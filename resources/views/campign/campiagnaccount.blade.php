<form id="campaign-form" action="{{ route('campaignads.store', $campaign->id) }}" method="POST">
    @csrf
    <div class="row mb-3">
        <div class="custom-select-wrapper">
            <div class="custom-select">
                <label> Account ID: </label>
                <div class="custom-select__trigger"><span>Select an account</span>
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
    <div class="mb-3">
        <label for="pixel_id">Pixel ID: </label>
        <select id="pixel_id" name="pixel_id" class="form-select">
            <option value="">Select Pixel</option>
            <!-- Pixel options will be populated here -->
        </select>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>


<script>
    // $('#campaign-form').on('submit', function(event) {
    //     event.preventDefault(); // Prevent the default form submission

    //     var $form = $(this);
    //     var $progressBar = $('#progress-bar');
    //     var $generateButton = $('#generate-campaign');

    //     var formData = new FormData(this);

    //     $.ajax({
    //         url: $form.attr('action'),
    //         type: 'POST',
    //         data: formData,
    //         processData: false,
    //         contentType: false,
    //         xhr: function() {
    //             var xhr = new window.XMLHttpRequest();
    //             xhr.upload.addEventListener('progress', function(e) {
    //                 if (e.lengthComputable) {
    //                     var percentComplete = Math.round((e.loaded / e.total) * 100);
    //                     $progressBar.css('width', percentComplete + '%').text(
    //                         percentComplete + '%');
    //                 }
    //             });
    //             return xhr;
    //         },
    //         beforeSend: function() {
    //             $generateButton.prop('disabled', true); // Disable the button
    //             $('.progress').show(); // Show the progress bar
    //         },
    //         success: function(response) {
    //             $progressBar.css('width', '100%').text('Completed');
    //             setTimeout(function() {
    //                 $('.progress').hide(); // Hide the progress bar after completion
    //                 $generateButton.prop('disabled', false); // Re-enable the button
    //             }, 2000); // Adjust delay as needed
    //         },
    //         error: function(xhr) {
    //             $progressBar.css('width', '0%').text('Failed');
    //             setTimeout(function() {
    //                 $('.progress').hide(); // Hide the progress bar after error
    //                 $generateButton.prop('disabled', false); // Re-enable the button
    //             }, 2000); // Adjust delay as needed
    //         }
    //     });
    // });

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

    $(document).ready(function() {
        $('#account_id_input').val(''); // Initialize empty account ID

        $('.custom-select').on('click', '.custom-option', function() {
           var accountId = $('#account_id_input').val();
            // Clear previous pixel options
            $('#pixel_id').html('<option value="">Select Pixel</option>');

            // Fetch and populate pixels based on selected account
            $.ajax({
                url: '{{ route('pixels.byAccount', '') }}/' + accountId,
                method: 'GET',
                success: function(response) {
                    const pixelSelect = $('#pixel_id');
                    response.forEach(pixel => {
                        pixelSelect.append(
                            $('<option>').val(pixel.id).text(pixel.name)
                        );
                    });
                },
                error: function() {
                    alert('Failed to fetch pixels. Please try again.');
                }
            });
        });
    });
</script>
