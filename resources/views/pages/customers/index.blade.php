@extends('layouts.custom_app')
@section('content')
    <!-- All Orders Block -->
    <div id="page-content">
        <div class="row">
            <div class="content-header">
                <div class="header-section">
                    @if( Session::has("app_message") )
                        <div class="alert alert-success alert-block" role="alert">
                            <button class="close" data-dismiss="alert"></button>
                            {{ Session::get("app_message") }}
                        </div>
                    @endif
                    @if( Session::has("app_error") )
                        <div class="alert alert-danger alert-block" role="alert">
                            <button class="close" data-dismiss="alert"></button>
                            {{ Session::get("app_error") }}
                        </div>
                    @endif
                </div>
            </div>

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
                        <div id="flush-collapseOne" class="accordion-collapse collapse"
                             aria-labelledby="flush-headingOne"
                             data-bs-parent="#accordionFlushExample">
                            <div class="block full">
                                <div class="table-responsive">
                                    <div class="block-options">
                                        <div class="col-md-3">
                                            <label for="val_skill_customer_name">Name</label>
                                            <input type="text" placeholder="Search with name"
                                                   id="val_skill_customer_name" name="customer_name"
                                                   class="form-control filters" required="required"
                                                   style="margin-top: 3px;margin-right: 5px"/>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="val_skill_contact_number">Phone</label>
                                            <input type="text" placeholder="Search with phone"
                                                   id="val_skill_contact_number" name="contact_number"
                                                   class="form-control filters" required="required"
                                                   style="margin-top: 3px;margin-right: 5px"/>
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
                            <a href="{{url('customer/create')}}" class="btn btn-alt btn-sm btn-primary"
                               data-toggle="tooltip"
                               title="Add New Customer"><i class="fa fa-plus"></i></a>
                            <a href="{{url('customer/index')}}" class="btn btn-alt btn-sm btn-primary"
                               data-toggle="tooltip"
                               title="Reset Filters"><i class="fa fa-refresh"></i></a>
                        </div>
                        <h2><strong>Customer</strong> List</h2>
                    </div>
                    <!-- END All Orders Title -->

                    <!-- All Configuration Content -->

                    <div class="table-responsive">
                        <table id="tobacco-customer" class="display nowrap dataTable dtr-inline">
                            <thead>
                            <tr>
                                <th>Customer Name</th>
                                <th>Address</th>
                                <th>Contact Number</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Receivable</th>
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
    <!-- END All Configuration Block -->
@endSection

@section('script')
    <script type="text/javascript" language="javascript"
            src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>

    <script type="text/javascript">
        var tobacco_table = null;

        function customer_datatable(data={}) {
            console.log(data);
            tobacco_table = $("#tobacco-customer").DataTable({
                processing: true,
                serverSide: true,
                select: true,
                paging: true,
                bFilter: false,
                ajax: {
                    url: "{{ url('customer/index') }}",
                    data: data,
                },
                columns: [
                    {data: 'customer_name', name: 'customer_name'},
                    {data: 'address', name: 'address'},
                    {data: 'contact_number', name: 'contact_number'},
                    {data: 'email_id', name: 'email_id'},
                    {
                        data: 'status', name: 'status', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            var isnew;

                            if (oData.status === 1) {
                                isnew = '<span class="label label-success">Active</span>';
                            } else {
                                isnew = '<span class="label label-warning">In-Active</span>';
                            }
                            $(nTd).html(isnew);
                        }
                    },
                    {
                        data: 'receivable', name: 'receivable', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            const numberFormatter = Intl.NumberFormat('en-US');
                            const formatted = numberFormatter.format(oData.receivable);
                            var isnew = '<span class="" style="margin-left: 2em">$ '+formatted+'</span>';
                            $(nTd).html(isnew);
                        }
                    },
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],

            });
        }

        customer_datatable();


        $(document).on('change', '.filters', function () {
            var data = {};
            $('.filters').each(function () {
                data[$(this).attr('name')] = $(this).val();
            });
            tobacco_table.destroy();
            customer_datatable(data);
        });

        setTimeout(function () {
            $("div.alert").remove();
        }, 5000); // 5 secs
    </script>
@endsection