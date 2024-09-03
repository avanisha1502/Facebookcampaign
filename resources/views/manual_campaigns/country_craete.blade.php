<form action="{{ route('store.AddCountries') }}" method="POST" id="addGroupForm">
    @csrf
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label class="form-label">{{ __('Short Code') }} <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="short_code" placeholder="Enter Short Code">
                <span class="text-danger error-message" id="short_code_error"></span>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label class="form-label">{{ __('Country Name') }}<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="country_name" placeholder="Enter Country Name">
                <span class="text-danger error-message" id="country_name_error"></span>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label class="form-label">{{ __('Language') }} <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="language" placeholder="Enter Language">
                <span class="text-danger error-message" id="language_error"></span>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <label class="form-label">{{ __('Group') }}<span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="group" placeholder="Enter Group">
                <span class="text-danger error-message" id="group_error"></span>
            </div>
        </div>

        <div class="modal-footer col-xs-12 col-sm-12 col-md-12 mt-3">
            <button type="button" class="btn btn-default" data-bs-dismiss="modal">{{ __('Close') }}</button>
            <button type="submit" class="btn btn-primary">{{ __('Add Countries') }}</button>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        $('#addGroupForm').on('submit', function(e) {

            e.preventDefault();
            // Clear previous errors
            $('.error-message').text('');
            $('.form-control').removeClass('is-invalid');

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    console.log(response);
                    $('#commonModal').modal('hide');
                    $('#groupSelect').append('<option value="' + response.data
                        .group + '">' + response.data.group + '</option>');
                    $('#countrySelect').append('<option value="' + response.data
                        .name + '">' + response.data.name + '</option>');

                    $('#shortCodeSelect').append('<option value="' + response.data
                        .short_code + '">' + response.data.short_code + '</option>');
                    $('#languageSelect').append('<option value="' + response.data
                        .language + '">' + response.data.language + '</option>');
                },

                // success: function(response) {
                //     // Clear the form fields
                //     $('#groupName').val('');

                //     // Hide the modal
                //     $('#addGroupModal').modal('hide');

                //     // Append the new group to the dropdown
                //     $('#groupSelect').append(
                //         `<option value="${response.group_name}">${response.group_name}</option>`
                //         );

                //     // Optionally, select the newly added group in the dropdown
                //     $('#groupSelect').val(response.group_name);
                // },
                error: function(response) {
                    if (response.status === 422) {
                        var errors = response.responseJSON.errors;

                        // Show validation errors
                        if (errors.short_code) {
                            $('#short_code_error').text(errors.short_code[0]);
                            $('#short_code').addClass('is-invalid');
                        }
                        if (errors.country_name) {
                            $('#country_name_error').text(errors.country_name[0]);
                            $('#country_name').addClass('is-invalid');
                        }
                        if (errors.group) {
                            $('#group_error').text(errors.group[0]);
                            $('#group').addClass('is-invalid');
                        }
                        if (errors.language) {
                            $('#language_error').text(errors.language[0]);
                            $('#language').addClass('is-invalid');
                        }
                    }
                }
            });
        });
    });
</script>
