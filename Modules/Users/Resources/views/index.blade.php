@extends('layouts.custom_app')
@section('content')
    <div id="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h4 class="accordion-header" id="flush-headingOne">
                            <button class="btn btn-primary accordion-button collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                <span class="gi gi-search"></span>&nbsp;&nbsp;Search
                            </button>
                        </h4>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                             data-bs-parent="#accordionFlushExample">
                            <div class="block full">
                                <div class="table-responsive">
                                    <div class="block-options">
                                        <div class="col-md-3">
                                            <label for="val_skill_customer_name">Name</label>
                                            <input type="text" placeholder="Search with name" id="val_skill_customer_name" name="name" class="form-control filters" style="margin-top: 3px;margin-right: 5px"/>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="val_skill_contact_number">CNIC</label>
                                            <input type="text" placeholder="Search with phone" id="val_skill_contact_number" name="cnic" class="form-control filters"  style="margin-top: 3px;margin-right: 5px"/>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="val_skill_customer_name">Phone</label>
                                            <input type="text" placeholder="Search with name" id="val_skill_customer_name" name="phone" class="form-control filters"  style="margin-top: 3px;margin-right: 5px"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="block full">
                    <!-- All Orders Title -->
                    <div class="block-title">
                        <div class="block-options pull-right">
                            <a href="{{url('users/create')}}" class="btn btn-alt btn-sm btn-primary" data-toggle="tooltip"
                               title="Add New Customer"><i class="fa fa-plus"></i></a>
                            <a href="{{url('users')}}" class="btn btn-alt btn-sm btn-primary" data-toggle="tooltip"
                               title="Reset Filters"><i class="fas fa-refresh"></i></a>
                        </div>
                        <h2><strong>Users</strong> List</h2>
                    </div>

                    <div class="table-responsive">
                        <div class="card card-primary">
                            <div class="card-body">
                                <table class="display nowrap dataTable dtr-inline" id="data_table"
                                       style="width:100%;">
                                    {{--<thead class="text-center bg-primary text-white">--}}
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        //Roles table
        var data_table;

        function DataTableInit(data={}) {
            data_table = $('#data_table').DataTable({
                processing: true,
                serverSide: true,
                select: true,
                paging: true,
                bFilter: false,
                ajax: {
                    url: "{{url('users')}}",
                    data: data,
                },
                buttons: [],
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'role', name: 'role'},
                    {data: 'phone', name: 'phone'},
                    {data: 'status', name: 'status', class: 'text-center'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        class: "d-flex justify-content-center w-auto",
                        searchable: false
                    },
                ]
            });
        }

        DataTableInit();


        $(document).on('change', '.filters', function () {
            var data = {};
            $('.filters').each(function () {
                data[$(this).attr('name')] = $(this).val();
            });
            data_table.destroy();
            DataTableInit(data);
        });

    </script>
@endsection