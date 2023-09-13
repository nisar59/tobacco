<!-- Tickets Header -->
<div class="content-header">
    <div class="header-section">
        <h1>
            <i class="fa fa-ticket"></i>Customer<br>
            <small>Sales Order Details!</small>
        </h1>
    </div>
</div>
<!-- END Tickets Header -->

<!-- Tickets Content -->
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
    <div class="col-sm-4 col-lg-3">
        <!-- Menu Block -->
        <div class="block full">
            <!-- Menu Title -->
            <div class="block-title clearfix">
                <h2><i class="fa fa-user"></i> Customer <strong>Info</strong></h2>
            </div>
            <!-- END Menu Title -->

            <!-- Menu Content -->
            <ul class="nav nav-pills nav-stacked">
                <li class="active">
                    <a href="javascript:void(0)">
                        <span class="badge pull-right">{{$customer->customer_name}}</span>
                        <i class="fa fa-user fa-fw"></i> <strong>Name</strong>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <span class="badge pull-right">{{$customer->contact_number}}</span>
                        <i class="fa fa-phone fa-fw"></i> <strong>Phone</strong>
                    </a>
                </li>
            </ul>
            <div class="block block-alt-noborder">
                <h3 class="sub-header">Sales <strong>Info</strong></h3>
                <ul class="nav nav-pills nav-stacked">
                    <li class="active">
                        <a href="javascript:void(0)">
                            <span class="badge pull-right">{{$record->invoice_number}}</span>
                            <i class="fa fa-file-invoice-dollar"></i> <strong>Invoice #</strong>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <span class="badge pull-right">{{$record->invoice_price}}</span>
                            <i class="fa fa-file-invoice-dollar"></i> <strong>Invoice Total</strong>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- END Menu Content -->
        </div>
        <!-- END Menu Block -->

    </div>
    <div class="col-sm-8 col-lg-9">
        <!-- Tickets Block -->
        <div class="block">
            <div class="block full">
                <div class="table-responsive">
                    <div class="col-md-12 text-right">
                        <a href="javascript:void(0)" class="btn btn-sm btn-alt btn-default"
                           onclick="App.pagePrint();"><i
                                    class="fa fa-print"></i> Print</a>
                    </div>
                    <table id="tobacco_sales" class="display nowrap dataTable dtr-inline">
                        <thead>
                        <tr>
                            <th class="text-center">Date</th>
                            <th class="text-center">Product</th>
                            <th>Unit Price</th>
                            <th class="text-center">Total Qty</th>
                            <th class="text-center">Returns Qty</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody class="text-center">
                        @if(!empty($modelDetails) && $modelDetails!=null)
                            @foreach($modelDetails as $detail)
                                <tr>
                                    <td><strong>{{date('m/d/Y', strtotime($detail->created_at))}}</strong></td>
                                    <td>{{$detail->product->uuid}}</td>
                                    <td>{{number_format($detail->unit_price)}}</td>
                                    <td>{{number_format($detail->quantity)}}</td>
                                    <td>{{number_format($detail->return_qty)}}</td>
                                    <td>
                                        <div class="btn-group btn-group-xs">
                                            <form id="return_{{$detail->id}}" onclick="edit_config({{$detail->id}})"
                                                  action="" onsubmit="return false"
                                                  method="post"
                                                  style="display: inline">
                                                <input type="hidden" id="detail_id_{{$detail->id}}"
                                                       value="{{$detail->id}}">
                                                <input type="hidden" id="detail_qty_{{$detail->id}}"
                                                       value="{{$detail->quantity}}">
                                                <input type="hidden" id="sr_qty_{{$detail->id}}"
                                                       value="{{$detail->return_qty}}">
                                                <button type="submit" class="btn btn-secondary cursor-pointer"
                                                        data-target="#modal-return-update"
                                                        data-toggle="modal">
                                                    <i class="text-danger fa fa-credit-card"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END Tickets Block -->
    </div>
</div>

<div id="modal-return-update" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title"><i class="fa fa-pencil"></i> Add Returns Against Following Sale</h2>
            </div>
            <!-- END Modal Header -->

            <!-- Modal Body -->
            <div class="modal-body">
                <form action="{{url('sales/return/save')}}"
                      method="post" class="form-horizontal form-bordered">
                    <fieldset>
                        {{csrf_field()}}
                        <input type="hidden" id="sales_return_id" name="sales_id" value="">
                        <input type="hidden" id="sr_qty" value="">
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="sales_return_qty">Return Quantity</label>
                            <div class="col-md-6">
                                <input type="number" id="sales_return_qty" name="sale_return_qty" class="form-control"
                                       placeholder="Please enter Return Quantity" data-toggle="tooltip" value=""
                                       title="Return Quantity!">
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-group form-actions">
                        <div class="col-xs-12 text-right">
                            <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>

<!-- END Tickets Content -->

@section('script')
    <script type="text/javascript" language="javascript"
            src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <script type="text/javascript">
        $("#tobacco_sales").DataTable({
            processing: true,
            select: true,
            paging: true,
            bFilter: false,
            dom: 'lBfrtip'
        });

    </script>
    <script type="text/javascript">
        function edit_config($this) {
            var detail_qty = $('#detail_qty_' + $this);
            var slr_qty = $('#sr_qty_' + $this);

            $('#sales_return_id').val($this);
            $('#sales_return_qty').val((detail_qty.val()-slr_qty.val()));

            $("input[name='sale_return_qty']").prop('max',(detail_qty.val()-slr_qty.val()));

        }
    </script>
@endsection