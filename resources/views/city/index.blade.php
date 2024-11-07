@extends('layouts.app')

@section('content')
    <div class="dashboard__inner">
        <div class="dashboard__inner__item dashboard__card bg__white padding-20 radius-10">
            <h4 class="dashboard__inner__item__header__title">
                City
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDataModal">
                    Add City
                </button>
            </h4>
            <div class="tableStyle_one mt-4">
                <div class="table_wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>State Name</th>
                                <th>City Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableData">

                        </tbody>
                    </table>
                </div>
            </div>
            {{-- store data  --}}
            <div class="modal fade" id="addDataModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                Store City
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="submitForm">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">
                                        State
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select id="state_id" class="form-control" required>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}">
                                                {{ $state->state_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="text-danger" id="showCountryError"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">
                                        City Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="city_name" required>
                                    <div class="text-danger" id="showCityError"></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- edit data  --}}
            <div class="modal fade" id="editDataModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" id="showUpdateForm">

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function getTableData() {
            $.ajax({
                url: "{{ route('city.data') }}",
                type: "GET",
                success: function(response) {

                    $("#tableData").html(response);

                },
                error: function(error) {
                    toastr.error('Something went wrong');
                }
            });
        }

        getTableData();

        $('#submitForm').on('submit', function(e) {
            e.preventDefault();

            let state_id = $('#state_id').val();
            let city_name = $('#city_name').val();

            $.ajax({
                url: "{{ route('city.store') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    state_id: state_id,
                    city_name: city_name,
                },
                success: function(response) {
                    if (response.status == true) {
                        toastr.success(response.message);

                        $('#state_id').val('');
                        $('#city_name').val('');

                        $("#addDataModal").modal('hide');

                        getTableData();

                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(error) {
                    let errors = error.responseJSON.errors;
                    if (errors) {
                        if (errors.city_name) {
                            $('#showCityError').text(errors.city_name[0]);
                        }
                        if (errors.state_id) {
                            $('#showStateError').text(errors.state_id[0]);
                        }
                    }
                }
            });
        });

        function editData(url) {

            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {

                    $("#editDataModal").modal('show');
                    $("#showUpdateForm").html(response);

                },
            });
        }

        function deleteData(state_id, url) {

            if (state_id) {

                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(response) {
                        if (response.status == true) {

                            toastr.success(response.message);

                            getTableData();

                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(error) {
                        toastr.error('Something went wrong. Try again');
                    }
                });
            } else {
                toastr.error('Country id not defiend');
            }
        }
    </script>
@endpush
