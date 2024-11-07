<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">
            Update Country
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form id="submitFormUpdate">
        <input type="hidden" id="routeUrl" value="{{ route('state.update', $state->id) }}">
        <div class="modal-body">
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">
                        Country
                        <span class="text-danger">*</span>
                    </label>
                    <select id="update_country_id" class="form-control" required>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}" @if ($state->country_id == $country->id) selected @endif>
                                {{ $country->country_name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="text-danger" id="showUpdateCountryError"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">
                        State Name
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" id="update_state_name" required
                        value="{{ $state->state_name }}">
                    <div class="text-danger" id="showUpdateStateError"></div>
                </div>
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

        let country_id = $('#update_country_id').val();
        let state_name = $('#update_state_name').val();
        let updateUrl = $('#routeUrl').val();

        $.ajax({
            url: updateUrl,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                country_id: country_id,
                state_name: state_name,
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
                if (errors) {
                    if (errors.state_name) {
                        $('#showUpdateCountryError').text(errors.state_name[0]);
                    }
                    if (errors.country_id) {
                        $('#showUpdateStateError').text(errors.country_id[0]);
                    }
                }
            }
        });
    });
</script>
