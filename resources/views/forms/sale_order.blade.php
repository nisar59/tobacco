<style>
    .table {
        border-collapse: separate;
        border-spacing:0 20px;
    }
</style>
<div class="row">
    <div class="col-md-12">
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
        <!-- User Assist Block -->
        <div class="block full">
            <!-- Invoice Title -->
            <div class="block-title">
                <div class="block-options pull-right">
                    <a href="javascript:void(0)" class="btn btn-sm btn-alt btn-default" onclick="App.pagePrint();"><i class="fa fa-print"></i> Print</a>
                </div>
                <h2><strong>Sales</strong> invoice</h2>
            </div>

            <form action="@if(isset($model) && !empty($model->customer_id)) {{url('sales/update')}} @else {{url('sales/save')}} @endif" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="{{isset($method)?$method:'POST'}}"/>
                <input type="hidden" name="sales_id" value="{{isset($model)?$model->id:''}}"/>
                <input type="hidden" name="sale_date_old" value="{{isset($model)?$model->sale_date:''}}"/>
                <!-- 2 Column grid -->
                <div class="row block-section">
                    <!-- suplier Info -->
                    <div class="col-sm-6">
                        <img src="{{ asset('backend/img/placeholders/avatars/avatar10.jpg') }}" alt="photo" class="img-circle">
                        <hr>
                        <div class="col-md-8">
                            <select id="customer_id" name="customer_id" class="form-control customer-filters" required="required">
                                <option value="">Select Customer</option>
                                @foreach($customers as $customer)
                                    <option @if($model->customer_id == $customer->id) selected @else @endif value="{{$customer->id}}">{{$customer->customer_name}}</option>
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
                                                    <input value="@if(isset($customerSelected) && !empty($customerSelected)) {{$customerSelected->customer_name}}  @endif" placeholder="Customer" class="form-control" readonly="readonly" style="border: 0;background-color:white" id="s_name"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                                    <input value="@if(isset($customerSelected) && !empty($customerSelected)) {{$customerSelected->contact_number}}  @endif" placeholder="Phone" class="form-control" readonly="readonly" style="border: 0;background-color:white" id="s_phone"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                                                    <input value="@if(isset($customerSelected) && !empty($customerSelected)) {{$customerSelected->address}}  @endif" placeholder="Address" class="form-control" readonly="readonly" style="border: 0;background-color:white" id="s_address"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-pencil"></i></span>
                                                    <input value="@if(isset($customerSelected) && !empty($customerSelected)) {{$customerSelected->email_id}}  @endif" placeholder="Email" class="form-control" readonly="readonly" style="border: 0;background-color:white" id="s_email"/>
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
                        <img src="{{ asset('backend/img/placeholders/avatars/avatar7.jpg') }}" alt="photo" class="img-circle">
                        <hr>
                        <div class="card text-black">
                            <div class="card-body">
                                <div>
                                    <address>
                                        <div class="col-md-12 form-group">
                                            <div class="col-md-4"><label for="sale_date"></label></div>
                                            <div class="col-md-8 input-group">
                                                    <input type="date" class="form-control" name="sale_date" id="sale_date" value="@if(isset($model) && !empty($model->sale_date)){{old('sale_date',date('Y-m-d',strtotime($model->sale_date)))}}@endif" placeholder="" @if(isset($model) && !empty($model->sale_date)) @else required="required" @endif>
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
                    <table class="table table-vcenter" id="tobacco_sales_order">
                        <thead>
                        <tr>
                            <div class="col-md-4 form-group">
                                <label for="product_id"></label>
                                <select id="product_id" name="product_id" class="form-control filtered-product"
                                        @if(isset($model) && !empty($model->sale_date)) @else required="required" @endif>
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}">{{ucfirst($product->manufacturer)}} {{$product->packing}} {{ucfirst($product->flavour)}} {{ucfirst($product->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="col-md-3 form-group">
                                    <label for="add-pro"></label>
                                    <a class="form-control btn btn-info add-filtered-product" id="add-pro-sale"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                        </tr>
                        <tr>
                            <th></th>
                            <th style="width: 60%;font-size:medium">Product</th>
                            <th class="text-left" style="font-size:medium">Quantity</th>
                            <th class="text-left" style="font-size:medium">Sale Price/Unit</th>
                            <th class="text-left" style="font-size:medium">Amount</th>
                            <th class="text-center" style="font-size:medium">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($model) && !empty($model->salesDetails))
                            @foreach($model->salesDetails as $details)
                                <tr>
                                    <td class='text-center'>
                                        <input style='margin: 10px 0 10px 0 !important;' id='p_id_{{$details->id}}' type='hidden' readonly name='p_id[]' value='{{$details->product_id}}'>
                                    </td>

                                    <td>
                                        <input id='p_uu_id_{{$details->id}}' type='text'
                                               style='border: 0!important;margin: 10px 0 0 0 !important;'
                                               value='{{$details->product->uuid}}' readonly='readonly'><br>
                                        <span class='label label-info' id='p_details'
                                              style='margin: 10px 0 10px 0 !important;'><i class='fa fa-briefcase'></i>&nbsp;&nbsp;{{ucfirst($details->product->manufacturer)}} {{$details->product->packing}} {{ucfirst($details->product->flavour)}} {{ucfirst($details->product->name)}}</span>

                                    </td>

                                    <td class='text-left'><strong style='margin-left: 20px'
                                                                  class='label label-info'>x </strong><input
                                                id='p_unit_qty_{{$details->id}}' type='number'
                                                data-value='{{$details->id}}' data-id='{{$details->product_id}}' onchange='update_qty_amounts(this.id)'
                                                name='p_unit_qty[]' value='{{$details->quantity}}' class='unit_qty'
                                                style='border: 0!important;text-align:left;margin: 10px 0 10px 0 !important;'>
                                    </td>

                                    <td class='text-center'><strong style='margin-left: 20px'
                                                                    class='label label-info'>$ </strong><input
                                                id='p_unit_price_{{$details->id}}' type='number' readonly='true'
                                                data-value='{{$details->id}}' onchange='update_price_amounts(this.id)'
                                                name='p_unit_price[]' value='{{$details->unit_price}}'
                                                class='unit_price'
                                                style='border: 0!important;text-align:left;margin: 10px 0 10px 0 !important;'>
                                    </td>

                                    <td class='text-center'><strong style='margin-left: 20px'
                                                                    class='label label-info'>$ </strong><input type="text"
                                                id='p_total_price_{{$details->id}}' name='p_total_price[]'
                                                value='{{number_format($details->quantity*$details->unit_price)}}' class='p_total_price'
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
                    <table  class="table table-vcenter" id="tobacco_purchase_order_total">
                        <tbody>
                        <tr>
                            <td colspan="3" class="text-left"><span class="h3"><strong
                                            style="font-size:large;font-weight:Bold;">Carriage</strong></span></td>
                            <td colspan="3" class="text-right"><span class="h3">
                                    <strong style="font-size:large;font-weight:Bold;">%</strong>
                                    <input type="number"
                                           value="10"
                                           name="carriage_percentage"
                                           style="border: 0!important;"
                                           id="carriage_percent"
                                    >
                                </span>
                            </td>

                            <td class="text-right"><span class="h3"><strong>$</strong>&nbsp;
                                    <input type="text"
                                           value=""
                                           name="carriage_total"
                                           style="border: 0!important;"
                                           id="carriage_amount"
                                           readonly="readonly"></span>
                            </td>
                        </tr>
                        <tr class="active">
                            <td colspan="5" class="text-left"><span class="h3"><strong style="font-size:large;font-weight:Bold;">TOTAL AMOUNT</strong></span></td>
                            <td class="text-right"><span class="h3"><strong>$</strong>&nbsp;<input value=" @if(isset($model) && !empty($model->invoice_price)) {{number_format($model->invoice_price)}} @else 0 @endif" type="text" name="order_total" style="border: 0!important;" id="order_total" readonly="readonly"></span></td>
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