<style>
    .table {
        border-collapse: separate;
        border-spacing:0 20px;
    }

</style>
<div class="row">
    <div class="col-md-12">
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
    <!-- User Assist Block -->
        <div class="block full">
            <!-- Invoice Title -->
            <div class="block-title">
                <div class="block-options pull-right">
                    <a href="javascript:void(0)" class="btn btn-sm btn-alt btn-default" onclick="App.pagePrint();"><i
                                class="fa fa-print"></i> Print</a>
                </div>
                <h2><strong>Purchase</strong> invoice</h2>
            </div>

            <form action="@if(isset($model) && !empty($model->supplier_id)) {{url('purchase/update')}} @else {{url('purchase/save')}} @endif"
                  method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="{{isset($method)?$method:'POST'}}"/>
                <input type="hidden" name="purchase_id" value="{{isset($model)?$model->id:''}}"/>
                <input type="hidden" name="order_date_old" value="{{isset($model)?$model->order_date:''}}"/>
                <!-- 2 Column grid -->
                <div class="row block-section">
                    <!-- suplier Info -->
                    <div class="col-sm-6">
                        <img src="{{ asset('backend/img/placeholders/avatars/avatar10.jpg') }}" alt="photo"
                             class="img-circle">
                        <hr>
                        <div class="col-md-8">
                            <select id="supplier_id" name="supplier_id" class="form-control supplier-filters"
                                    required="required">
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option @if($model->supplier_id == $supplier->id) selected @else @endif
                                    value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>

                        <div class="card text-black">
                            <div class="card-body">
                                <div>
                                    <address>
                                        <div class="d-flex justify-content-between">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                    <input placeholder="Supplier" readonly="readonly"
                                                           value="@if(isset($supplierSelected) && !empty($supplierSelected)) {{$supplierSelected->supplier_name}}  @endif"
                                                           class="form-control" style="border: 0;background-color:white"
                                                           id="s_name"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                                    <input placeholder="Phone" readonly="readonly"
                                                           value="@if(isset($supplierSelected) && !empty($supplierSelected)) {{$supplierSelected->contact_number}}  @endif"
                                                           class="form-control" style="border: 0;background-color:white"
                                                           id="s_phone"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i
                                                                class="fa fa-envelope-o"></i></span>
                                                    <input placeholder="Address" readonly="readonly"
                                                           value="@if(isset($supplierSelected) && !empty($supplierSelected)) {{$supplierSelected->address}}  @endif"
                                                           class="form-control" style="border: 0;background-color:white"
                                                           id="s_address"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                                    <input placeholder="Email" readonly="readonly"
                                                           value="@if(isset($supplierSelected) && !empty($supplierSelected)) {{$supplierSelected->email_id}}  @endif"
                                                           class="form-control"
                                                           style="border: 0; background-color:white"
                                                           id="s_email"/>
                                                </div>
                                            </div>
                                        </div>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END supplier Info -->

                    <!-- purchase Info -->
                    <div class="col-sm-6 text-right">
                        <img src="@if(isset($model) && !empty($model->image)) {{ asset('invoices/'.$model->image) }} @else {{ asset('backend/img/placeholders/avatars/avatar7.jpg') }} @endif"
                             alt="photo"
                             class="img-circle" style="height: 200px;width: 200px;">
                        <hr>
                        <div class="card text-black">
                            <div class="card-body">
                                <div>
                                    <address>
                                        <div class="col-md-12 form-group">
                                            <div class="col-md-4"><label for="invoice_number"></label></div>
                                            <div class="col-md-8 input-group">
                                                <input type="text" class="form-control" name="invoice_number"
                                                       id="invoice_number"
                                                       value="@if(isset($model) && !empty($model->invoice_number)) {{$model->invoice_number}}  @endif"
                                                       placeholder="Invoice Number"
                                                       maxlength="100" required>
                                            </div>
                                        </div>
                                        <br>

                                        <div class="col-md-12 form-group">
                                            <div class="col-md-4"><label for="image"></label></div>
                                            <div class="col-md-8 input-group">
                                                <input type="file" class="form-control" name="image" id="image" value=""
                                                       placeholder="" maxlength="100">
                                                @if(isset($model) && !empty($model->image)) <input type="hidden"
                                                                                                   name="old_image"
                                                                                                   value="{{$model->image}}"> @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <div class="col-md-4"><label for="order_date"></label></div>
                                            <div class="col-md-8 input-group">
                                                <input type="date" class="form-control"
                                                       value="@if(isset($model) && !empty($model->order_date)){{old('order_date',date('Y-m-d',strtotime($model->order_date)))}}@endif"
                                                       name="order_date"
                                                       id="order_date"
                                                       @if(isset($model) && !empty($model->order_date)) @else required="required" @endif>
                                            </div>
                                        </div>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END purchase Info -->
                </div>
                <!-- END 2 Column grid -->

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-vcenter" id="tobacco_purchase_order">
                        <thead>
                        <tr>
                            <div class="col-md-4 form-group">
                                <label for="product_id"></label>
                                <select id="product_id" name="product_id" class="form-control filtered-product"
                                        @if(isset($model) && !empty($model->order_date)) @else required="required" @endif>
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}">{{ucfirst($product->manufacturer)}} {{$product->packing}} {{ucfirst($product->flavour)}} {{ucfirst($product->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-3 form-group">
                                    <label for="add-pro"></label>
                                    <a class="form-control btn btn-info add-filtered-product" id="add-pro"><i
                                                class="fa fa-plus"></i></a>
                                </div>
                            </div>
                        </tr>
                        <tr>
                            <th></th>
                            <th style="width: 60%;font-size:medium">Product</th>
                            <th class="text-left" style="font-size:medium">Quantity</th>
                            <th class="text-left" style="font-size:medium">Purchase Price/Unit</th>
                            <th class="text-left" style="font-size:medium">Amount</th>
                            <th class="text-center" style="font-size:medium">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($model) && !empty($model->purchaseDetails))
                            @foreach($model->purchaseDetails as $details)
                                <tr>
                                    <td class='text-center'>
                                        <input style='margin: 10px 0 10px 0 !important;' id='p_id_{{$details->id}}'
                                               type='hidden' readonly name='p_id[]' value='{{$details->product_id}}'>
                                    </td>

                                    <td>
                                        <input id='p_uu_id_{{$details->id}}' type='text'
                                               style='border: 0!important;margin: 10px 0 0 0 !important;'
                                               value='{{$details->product->uuid}}' readonly='readonly'><br>
                                        <span class='label label-info' id='p_details'
                                              style='margin: 10px 0 10px 0 !important;'><i class='fa fa-clock-o'></i>&nbsp;&nbsp;
                                            {{ucfirst($details->product->manufacturer)}} {{$details->product->packing}} {{ucfirst($details->product->flavour)}} {{ucfirst($details->product->name)}}</span>

                                    </td>

                                    <td class='text-left'><strong style='margin-left: 20px'
                                                                  class='label label-info'>x </strong><input
                                                id='p_unit_qty_{{$details->id}}' type='number'
                                                data-value='{{$details->id}}' onchange='update_qty_amounts(this.id)'
                                                name='p_unit_qty[]' value='{{$details->quantity}}' class='unit_qty'
                                                style='border: 0!important;text-align:left;margin: 10px 0 10px 0 !important;'>
                                    </td>

                                    <td class='text-center'><strong style='margin-left: 20px'
                                                                    class='label label-info'>$ </strong><input
                                                id='p_unit_price_{{$details->id}}' type='number'
                                                data-value='{{$details->id}}' onchange='update_price_amounts(this.id)'
                                                name='p_unit_price[]' value='{{$details->unit_price}}'
                                                class='unit_price'
                                                style='border: 0!important;text-align:left;margin: 10px 0 10px 0 !important;'>
                                    </td>

                                    <td class='text-center'><strong style='margin-left: 20px'
                                                                    class='label label-info'>$ </strong><input
                                                id='p_total_price_{{$details->id}}' name='p_total_price[]' type="text"
                                                value='{{number_format($details->quantity*$details->unit_price)}}'
                                                class='p_total_price'
                                                readonly='readonly'
                                                style='border: 0!important;text-align:left;margin: 10px 0 10px 0 !important;'>
                                    </td>

                                    <td class='text-center'>
                                        <button class='btn btn-danger btnDelete'><i class='fa fa-trash'></i></button>
                                    </td>

                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    {{--===================================================Total Amount========================================--}}
                    <table class="table table-vcenter" id="tobacco_purchase_order_total">
                        <tbody>
                        {{--<tr>--}}
                            {{--<td colspan="3" class="text-left"><span class="h3"><strong--}}
                                            {{--style="font-size:large;font-weight:Bold;">Carriage</strong></span></td>--}}
                            {{--<td colspan="3" class="text-right"><span class="h3">--}}
                                    {{--<strong style="font-size:large;font-weight:Bold;">%</strong>--}}
                                    {{--<input type="number"--}}
                                           {{--value="10"--}}
                                           {{--name="carriage_percentage"--}}
                                           {{--style="border: 0!important;"--}}
                                           {{--id="carriage_percent"--}}
                                           {{-->--}}
                                {{--</span>--}}
                            {{--</td>--}}

                            {{--<td class="text-right"><span class="h3"><strong>$</strong>&nbsp;--}}
                                    {{--<input type="text"--}}
                                           {{--value=""--}}
                                           {{--name="carriage_total"--}}
                                           {{--style="border: 0!important;"--}}
                                           {{--id="carriage_amount"--}}
                                           {{--readonly="readonly"></span>--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                        <tr class="active">
                            <td colspan="3" class="text-left"><span class="h3"><strong
                                            style="font-size:large;font-weight:Bold;">TOTAL AMOUNT</strong></span>
                            </td>
                            <td colspan="3" class="text-center">.</td>
                            <td class="text-right"><span class="h3"><strong>$</strong>&nbsp;
                                    <input type="text"
                                           value=" @if(isset($model) && !empty($model->invoice_price)) {{number_format($model->invoice_price)}} @else 0 @endif"
                                           name="order_total"
                                           style="border: 0!important;"
                                           id="order_total"
                                           readonly="readonly"></span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="clearfix">
                        <div class="btn-group pull-right">
                            <button type="submit" class="btn btn-default"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </div>
                <!-- END Table -->
            </form>
            <!-- END Invoice Content -->
        </div>
    </div>
</div>