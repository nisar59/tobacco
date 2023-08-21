@extends('layouts.custom_app')
@section('content')
    <div id="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="block full">
                    <!-- All Orders Title -->
                    <div class="block-title">
                        <div class="block-options pull-right">
                            <a href="{{url('roles/create')}}" class="btn btn-alt btn-sm btn-primary"
                               data-toggle="tooltip"
                               title="Add New Customer"><i class="fa fa-plus"></i></a>
                            <a href="{{url('roles')}}" class="btn btn-alt btn-sm btn-primary"
                               data-toggle="tooltip"
                               title="Reset Filters"><i class="fa fa-refresh"></i></a>
                        </div>
                        <h2><strong>Roles & </strong> Permissions</h2>
                    </div>
                    <!-- END All Orders Title -->

                    <!-- All Configuration Content -->

                    <div class="table-responsive">
                        <table class="display nowrap dataTable dtr-inline" id="roles" style="width:100%;">
                            <thead>
                            {{--<thead class="text-center bg-primary text-white">--}}
                            <tr>
                                <th>Name</th>
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
@endsection
@section('script')
    <script type="text/javascript">
        //Roles table
        var roles_table = $('#roles').DataTable({
            processing: true,
            serverSide: true,
            select: true,
            paging: true,
            bFilter: false,
            ajax: "{{url('roles')}}",
            buttons: [],
            columnDefs: [{
                "targets": 1,
                "orderable": false,
                "searchable": false
            }],
            columns: [
                {data: 'name', name: 'name'},
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    class: "d-flex justify-content-center w-auto",
                    searchable: false
                },
            ]
        });

    </script>
@endsection