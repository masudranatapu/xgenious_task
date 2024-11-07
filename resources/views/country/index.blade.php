@extends('layouts.app')

@section('content')
    <div class="dashboard__inner">
        <div class="dashboard__inner__item dashboard__card bg__white padding-20 radius-10">
            <h4 class="dashboard__inner__item__header__title">
                Country
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDataModal">
                    Add Country
                </button>
            </h4>
            <div class="tableStyle_one mt-4">
                <div class="table_wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Country Name</th>
                                <th>Total State</th>
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
                                        Country Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="country_name" required>
                                    <div class="text-danger" id="showError"></div>
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
                url: "{{ route('country.data') }}",
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

            let country_name = $('#country_name').val();

            $.ajax({
                url: "{{ route('country.store') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    country_name: country_name,
                },
                success: function(response) {
                    if (response.status == true) {
                        toastr.success(response.message);

                        $("#country_name").val('');

                        $("#addDataModal").modal('hide');

                        getTableData();

                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(error) {
                    let errors = error.responseJSON.errors;
                    if (errors) {
                        if (errors.country_name) {
                            $('#showError').text(errors.country_name[0]);
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

        function deleteData(country_id, url) {

            if (country_id) {

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
