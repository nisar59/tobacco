<!-- Tickets Header -->
<div class="content-header">
    <div class="header-section">
        <h1>
            <i class="fa fa-ticket"></i>Supplier<br>
            <small>Detail Ledger!</small>
        </h1>
    </div>
</div>
<!-- END Tickets Header -->

<!-- Tickets Content -->
<div class="row">
    <div class="col-md-4">
        <!-- Menu Block -->
        <div class="block full">
            <!-- Menu Title -->
            <div class="block-title clearfix">

                <h2><i class="fa fa-user"></i> Supplier <strong>Info</strong></h2>
            </div>
            <!-- END Menu Title -->

            <!-- Menu Content -->
            <ul class="nav nav-pills nav-stacked">
                <li class="active">
                    <a href="javascript:void(0)">
                        <span class="badge pull-right">{{$record->supplier_name}}</span>
                        <i class="fa fa-user fa-fw"></i> <strong>Name</strong>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <span class="badge pull-right">{{$record->contact_number}}</span>
                        <i class="fa fa-phone fa-fw"></i> <strong>Phone</strong>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <span class="badge pull-right">Email</span>
                        <i class="fa fa-folder-o fa-fw"></i> <strong>{{$record->email_id}}</strong>
                    </a>
                </li>
            </ul>
            <div class="block block-alt-noborder">
                <h3 class="sub-header">Address</h3>
                <ul class="media-list">
                    <li class="media">
                        <div class="media-body">
                            <p>{{$record->address}}</p>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- END Menu Content -->
        </div>
        <!-- END Menu Block -->
    </div>
    <div class="col-md-8">
        <!-- Tickets Block -->
        <div class="block full">
            <div class="block-options">
                <form action="{{url('/supplier/show/'.$record->id)}}"
                      method="GET" class="">
                    <div class="input-group">
                        <label for="val_skill_purchase_date">Date From/To</label>
                        <input type="text" id="val_skill_purchase_date" name="purchase_date" value=""
                               class="form-control daterange filters"
                               style="margin-top: 3px;margin-right: 5px"/>
                        <span class="input-group-addon" style="height: 64px;padding-top: 47px;border: 0;"><i class="fa fa-search"></i></span>
                    </div>
                </form>
            </div>
        </div>

        <div class="block full">
            <div class="table-responsive">
                <div class="col-md-12 text-right">
                    <a href="javascript:void(0)" class="btn btn-sm btn-alt btn-default" onclick="App.pagePrint();"><i
                                class="fa fa-print"></i> Print</a>
                    {{--<a class="btn btn-success" href="{{url('customer/sales_ledger_export')}}" id="export"><i class="fa fa-cloud-download"></i></a>--}}
                </div>
                <table id="tobacco_purchase" class="display nowrap dataTable dtr-inline">
                    <thead>
                    <tr>
                        <th class="text-left">Date</th>
                        <th class="text-left">Description</th>
                        <th class="text-left">Invoice</th>
                        <th class="text-left">Amount</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                    <tr>
                        <th style="font-size: large" class="text-center">Balance Receivable</th>
                        <th class="text-center"></th>
                        <th></th>
                        <th style="font-size: large">$ {{$record->payable_amount}}</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- END Tickets Block -->
    </div>
</div>
<!-- END Tickets Content -->
@section('script')
    <script type="text/javascript" language="javascript"
            src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <script type="text/javascript">
        $('.daterange').daterangepicker();
        var tobacco_table = null;

        function supplier_datatable(data={}) {
            console.log(data);
            tobacco_table = $("#tobacco_purchase").DataTable({
                processing: true,
                serverSide: true,
                select: true,
                paging: true,
                bFilter: false,
                ajax: {
                    url: "{{ url('supplier/show/'.$record->id) }}",
                    data: data,
                },
                columns: [
                    {data: 'date', name: 'date'},
                    {data: 'description', name: 'description'},
                    {data: 'invoice', name: 'invoice'},
                    {
                        data: 'amount', name: 'amount', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            if(oData.payable === 0){
                                var isnew = '<span class="">0</span>';
                            }else {
                                var isnew = '<span class="">$ '+oData.amount+'</span>';
                            }

                            $(nTd).html(isnew);
                        }
                    }
                ],

            });
        }

        supplier_datatable();


        $(document).on('change', '.filters', function () {
            var data = {};
            $('.filters').each(function () {
                data[$(this).attr('name')] = $(this).val();
            });
            tobacco_table.destroy();
            supplier_datatable(data);
        });

    </script>
@endsection