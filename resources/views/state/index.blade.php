@extends('layouts.app')

@section('content')
    <div class="dashboard__inner">
        <div class="dashboard__inner__item dashboard__card bg__white padding-20 radius-10">
            <h4 class="dashboard__inner__item__header__title">
                State
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDataModal">
                    Add State
                </button>
            </h4>
            <div class="tableStyle_one mt-4">
                <div class="table_wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Country Name</th>
                                <th>State Name</th>
                                <th>Total City</th>
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
                                Store Country
                            </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="submitForm">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">
                                        Country
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select id="country_id" class="form-control" required>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">
                                                {{ $country->country_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="text-danger" id="showCountryError"></div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">
                                        State Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="state_name" required>
                                    <div class="text-danger" id="showStateError"></div>
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
                url: "{{ route('state.data') }}",
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

            let country_id = $('#country_id').val();
            let state_name = $('#state_name').val();

            $.ajax({
                url: "{{ route('state.store') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    country_id: country_id,
                    state_name: state_name,
                },
                success: function(response) {
                    if (response.status == true) {
                        toastr.success(response.message);

                        $('#country_id').val('');
                        $('#state_name').val('');

                        $("#addDataModal").modal('hide');

                        getTableData();

                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(error) {
                    let errors = error.responseJSON.errors;
                    if (errors) {
                        if (errors.state_name) {
                            $('#showCountryError').text(errors.state_name[0]);
                        }
                        if (errors.country_id) {
                            $('#showStateError').text(errors.country_id[0]);
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
