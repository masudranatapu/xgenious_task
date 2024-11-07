<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">
            Update Country
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form id="submitFormUpdate">
        <input type="hidden" id="routeUrl" value="{{ route('country.update', $countries->id) }}">
        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">
                    Country Name
                    <span class="text-danger">*</span>
                </label>
                <input type="text" class="form-control" id="show_country_name" required
                    value="{{ $countries->country_name }}">
                <div class="text-danger" id="showUpdateError"></div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                Close
            </button>
            <button type="submit" class="btn btn-primary">
                Update
            </button>
        </div>
    </form>
</div>

<script>
    $('#submitFormUpdate').on('submit', function(e) {
        e.preventDefault();

        let country_name = $('#show_country_name').val();
        let updateUrl = $('#routeUrl').val();

        $.ajax({
            url: updateUrl,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                country_name: country_name,
            },
            success: function(response) {
                if (response.status == true) {
                    toastr.success(response.message);

                    $("#editDataModal").modal('hide');
                    getTableData();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(error) {
                let errors = error.responseJSON.errors;
                if (errors && errors.country_name) {
                    $('#showUpdateError').text(errors.country_name[0]);
                }
            }
        });
    });
</script>
