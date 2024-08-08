<form id="campaign-form" action="{{ route('campaignads.store', $campaign->id) }}" method="POST">
    @csrf
    <div class="row mb-3">

        <select class="form-select"name="account_id">
            @foreach ($adscampaign as $campaigns)
                <option value="{{ $campaigns->account_id }}">{{ $campaigns->name }} - {{ $campaigns->account_id }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>


<script>
    let toggle = function() {
        document.querySelectorAll('.dropdown-wrapper')[0].classList.toggle('active');
    }
    document.querySelectorAll('.toggle')[0].addEventListener("click", toggle);

    $('#campaign-form').on('submit', function(event) {
        alert('Form submit event fired');
        event.preventDefault(); // Prevent the default form submission

        var $form = $(this);
        var $progressBar = $('#progress-bar');
        var $generateButton = $('#generate-campaign');

        var formData = new FormData(this);

        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        var percentComplete = Math.round((e.loaded / e.total) * 100);
                        $progressBar.css('width', percentComplete + '%').text(
                            percentComplete + '%');
                    }
                });
                return xhr;
            },
            beforeSend: function() {
                $generateButton.prop('disabled', true); // Disable the button
                $('.progress').show(); // Show the progress bar
            },
            success: function(response) {
                $progressBar.css('width', '100%').text('Completed');
                setTimeout(function() {
                    $('.progress').hide(); // Hide the progress bar after completion
                    $generateButton.prop('disabled', false); // Re-enable the button
                }, 2000); // Adjust delay as needed
            },
            error: function(xhr) {
                $progressBar.css('width', '0%').text('Failed');
                setTimeout(function() {
                    $('.progress').hide(); // Hide the progress bar after error
                    $generateButton.prop('disabled', false); // Re-enable the button
                }, 2000); // Adjust delay as needed
            }
        });
    });
</script>
