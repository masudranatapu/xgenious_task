<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">
            Update City
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form id="submitFormUpdate">
        <input type="hidden" id="routeUrl" value="{{ route('city.update', $city->id) }}">
        <div class="modal-body">
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">
                        State
                        <span class="text-danger">*</span>
                    </label>
                    <select id="update_state_id" class="form-control" required>
                        @foreach ($states as $state)
                            <option value="{{ $state->id }}" @if ($state->id == $city->state_id) selected @endif>
                                {{ $state->state_name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="text-danger" id="showUpdateStateError"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">
                        City Name
                        <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" id="update_city_name" required
                        value="{{ $city->city_name }}">
                    <div class="text-danger" id="showUpdateCityError"></div>
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

        let state_id = $('#update_state_id').val();
        let city_name = $('#update_city_name').val();
        let updateUrl = $('#routeUrl').val();

        $.ajax({
            url: updateUrl,
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                state_id: state_id,
                city_name: city_name,
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
                    if (errors.state_id) {
                        $('#showUpdateStateError').text(errors.state_id[0]);
                    }
                    if (errors.city_name) {
                        $('#showUpdateCityError').text(errors.city_name[0]);
                    }
                }
            }
        });
    });
</script>
