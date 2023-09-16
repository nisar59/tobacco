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
                                            <label for="val_skill_exp_date">Date From/To</label>
                                            <input type="text" id="val_skill_exp_date" name="exp_date" value="" class="form-control daterange filters"  style="margin-top: 3px;margin-right: 5px"/>
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
                            <a href="{{url('sales/receipts/0')}}" class="btn btn-alt btn-sm btn-primary"
                               data-toggle="tooltip"
                               title="Add New payment">Add Receipts</a>
                            <a href="{{url('sales/receivable')}}" class="btn btn-alt btn-sm btn-primary"
                               data-toggle="tooltip"
                               title="Reset Filters"><i class="fa fa-refresh"></i></a>
                        </div>
                        <h2><strong>Customer Receipts</strong> List</h2>
                    </div>
                    <!-- END All Orders Title -->

                    <!-- All Configuration Content -->

                    <div class="table-responsive">
                        <table id="tobacco-customer" class="display nowrap dataTable dtr-inline">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Customer Name</th>
                                <th>Contact Number</th>
                                <th>Mode</th>
                                <th>Amount</th>
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
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <script type="text/javascript">
        $('.daterange').daterangepicker();
    </script>

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
                    url: "{{ url('sales/receivable') }}",
                    data: data,
                },
                columns: [
                    {
                        data: 'exp_date', name: 'exp_date', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                            var toDay = new Date(oData.exp_date);
                            var isnew = '<span class="">'+toDay.toLocaleDateString("en-US", options)+'</span>';
                            $(nTd).html(isnew);
                        }
                    },
                    {data: 'customer_name', name: 'customer_name'},
                    {data: 'contact_number', name: 'contact_number'},
                    {data: 'payment_mode', name: 'payment_mode'},
                    {
                        data: 'amount', name: 'amount', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            var isnew = '<span class="" style="margin-left: 2em">$ '+oData.amount+'</span>';
                            $(nTd).html(isnew);
                        }
                    }
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