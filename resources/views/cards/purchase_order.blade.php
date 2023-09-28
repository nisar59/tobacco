<style>
    .table {
        border-collapse: separate;
        border-spacing:0 20px;
    }
</style>
<div id="page-content">
    <!-- END Invoice Header -->

    <!-- Invoice Block -->
    <div class="block full">
        <!-- Invoice Title -->
        <div class="block-title">
            <div class="block-options pull-right">
                <a href="{{url('purchase/create')}}" class="btn btn-sm btn-alt btn-default" data-toggle="tooltip"
                   title="New invoice"><i class="fa fa-plus"></i></a>
                <a href="{{url('purchase/edit',$record->id)}}" class="btn btn-sm btn-alt btn-default"
                   data-toggle="tooltip" title="Delete invoice"><i class="fa fa-pencil"></i></a>
                <form onsubmit="return confirm('Are you sure you want to delete?')"
                      action="{{url('purchase/destroy')}}"
                      method="post"
                      style="display: inline">
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{$record->id}}">
                    {{method_field('POST')}}
                    <button type="submit" class="btn btn-secondary cursor-pointer">
                        <i class="text-danger fa fa-remove"></i>
                    </button>
                </form>
                <a href="javascript:void(0)" class="btn btn-sm btn-alt btn-default" onclick="App.pagePrint();"><i
                            class="fa fa-print"></i> Print</a>
            </div>
            <h2><strong>Invoice</strong> #{{$record->invoice_number}}</h2>
        </div>
        <!-- END Invoice Title -->

        <!-- Invoice Content -->
        <!-- 2 Column grid -->
        <div class="row block-section">
            <!-- Company Info -->
            <div class="col-md-12">
                <div class="col-md-6 col-sm-6 col-lg-6">
                    <img src="{{ asset('backend/img/placeholders/avatars/avatar10.jpg') }}" alt="photo" class="img-circle">
                    <hr>
                    <h2><strong>Purchase Info.</strong></h2>
                    <address>
                        <i class="fa fa-calendar"></i> {{date('Y-M-d',strtotime($record->order_date))}}<br>
                        <i class="fa fa-image"></i> {{$record->invoice_number}}<br>
                        <i class="fa fa-money"></i> {{number_format($record->invoice_price)}}<br>
                    </address>
                    <h2><strong>Supplier Ifo.</strong></h2>
                    <address>
                        <i class="fa fa-user"></i> {{$record->supplier->supplier_name}}<br>
                        <i class="fa fa-envelope-o"></i> {{$record->supplier->address}}<br>
                        <i class="fa fa-phone"></i> {{$record->supplier->contact_number}}<br>
                        <i class="fa fa-envelope-o"></i> <a href="javascript:void(0)">{{$record->supplier->email_id}}</a>
                    </address>
                </div>
                <!-- END Company Info -->

                <!-- Client Info -->
                <div class="col-md-6 col-sm-6 col-lg-6">
                    <div class="col-md-12 col-sm-12 col-lg-6">
                        {{--750/450--}}
                        @if(!empty($record->image) && file_exists( 'invoices/' . $record->image))
                            <a href="{{ asset('invoices/'.$record->image) }}" data-toggle="lightbox-image">
                                <img style="width: 300px;height: 300px;margin-left: 230px;margin-top: 40px;" src="{{ asset('invoices/'.$record->image) }}" alt="image" class="img-responsive">
                            </a>
                        @else
                            <a href="{{ asset('backend/img/placeholders/photos/photo9.jpg/') }}" data-toggle="lightbox-image">
                                <img style="width: 300px;height: 300px;margin-left: 230px;margin-top: 40px;" src="{{ asset('backend/img/placeholders/photos/photo9.jpg/') }}" alt="image" class="img-responsive">
                            </a>
                        @endif
                    </div>
                </div>
                <!-- END Client Info -->
            </div>
        </div>
        <!-- END 2 Column grid -->

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-vcenter">
                <thead>
                <tr>
                    <th></th>
                    <th style="width: 60%;">Product</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Unit Price</th>
                    <th class="text-right">Amount</th>
                </tr>
                </thead>
                <tbody>
                @foreach($record->purchaseDetails as $detail)
                    <tr>
                        <td class="text-center">1</td>
                        <td>
                            <h3>{{$detail->product->uuid}}</h3>
                            <span class="label label-info"><i class="fa fa-clock-o"></i>{{$detail->product->name.'-'.$detail->product->manufacturer.'-'.$detail->product->flavour}}</span>
                            <span class="label label-info">{{$detail->product->packing}}</span>
                        </td>
                        <td class="text-center h3"><strong>x <span class="badge">{{$detail->quantity}}</span></strong></td>
                        <td class="text-center h3"><strong>$ {{number_format((float)$detail->unit_price, 2, '.', '')}}</strong></td>
                        <td class="text-right h3"><span class="label label-primary">$ {{number_format((float)$detail->quantity*$detail->unit_price, 2, '.', '')}}</span></td>
                    </tr>
                @endforeach
                {{--<tr class="active">--}}
                    {{--<td colspan="4" class="text-left"><span class="h3"><strong>Carriage</strong></span></td>--}}
                    {{--<td class="text-right"><span class="h3"><strong>$ {{number_format($record->carriage_amount)}}</strong></span></td>--}}
                {{--</tr>--}}
                <tr class="active">
                    <td colspan="4" class="text-left"><span class="h3"><strong>TOTAL AMOUNT</strong></span></td>
                    <td class="text-right"><span class="h3"><strong>$ {{number_format((float)$record->invoice_price, 2, '.', '')}}</strong></span></td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- END Table -->

        <div class="clearfix">
        </div>
        <!-- END Invoice Content -->
    </div>
    <!-- END Invoice Block -->
    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Image preview</h4>
                </div>
                <div class="modal-body">
                    <img src="" id="imagepreview" style="width: 400px; height: 264px;" >
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>