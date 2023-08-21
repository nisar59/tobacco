<div class="row">
    <div class="col-md-12">
        <!-- User Assist Block -->
        <div class="block">
            <!-- User Assist Title -->
            <div class="block-title">
                <h2><strong>@if(isset($model) && !empty($model->id)) Update @else Add @endif</strong> Sales Order</h2>
            </div>

            <form action="{{url('sales/save')}}" method="POST" >
                {{csrf_field()}}
                <input type="hidden" name="_method" value="{{isset($method)?$method:'POST'}}"/>
                <div class="col-md-12">
                    <div class="col-md-4 form-group">
                        <label for="customer_id">Customer</label>
                        <select id="customer_id" name="customer_id" class="form-control customer-filters" required="required">
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{$customer->id}}">{{$customer->customer_name}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('customer_id'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('customer_id') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="sale_date">Sales Date</label>
                        <div class="input-group">
                            <input type="date" class="form-control {{ $errors->has('sale_date') ? ' is-invalid' : '' }}" name="sale_date" id="sale_date"
                                   value="{{old('sale_date',$model->sale_date)}}"
                                   placeholder="" required="required" >
                            <div class="input-group-addon">
                                <label for="sale_date" class="fa fa-calendar">
                                </label>
                            </div>
                        </div>
                        @if($errors->has('sale_date'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('sale_date') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-12 table-responsive">
                    <table id="tobacco_sales_customer" class="table table-vcenter table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Customer</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Address</th>
                            <th scope="col">Email</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12 sales overflow-auto form-group">
                    <!--<div style="min-width: 600px">-->
                    <header>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="product_id">Select Product</label>
                                <select id="product_id" name="product_id" class="form-control filters-product" required="required">
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}">{{$product->name}}-{{$product->manufacturer}}-{{$product->flavour}}-{{$product->packing}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <div class="col-md-4 form-group">
                                    <label for="add-pro-sale"></label>
                                    <a class="form-control btn btn-info add-filtered-product" id="add-pro-sale"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                    </header>
                    <main>
                        <div class="row">
                            <div class="col-sm-12 col-xs-12 table-responsive">
                                <table id="tobacco_sales_order" class="table table-condensed" border="0" cellspacing="0" cellpadding="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="text-center col-xs-1 col-sm-1">P-Id</th>
                                        <th class="text-center col-xs-7 col-sm-4">Description</th>
                                        <th class="text-center col-xs-1 col-sm-2">Add Unit Qty</th>
                                        <th class="text-center col-xs-3 col-sm-2">Add Unit Price</th>
                                        <th class="text-center col-xs-3 col-sm-2">Total Price</th>
                                        <th class="text-center col-xs-1 col-sm-1">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th colspan="3">
                                            Order<br>
                                            Information content
                                        </th>
                                        <th class="text-center">Order Total</th>
                                        <th class="text-center"><input type="number" value="0" name="order_total" id="order_total" readonly="readonly"></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </main>
                    <!--</div>-->
                </div>

                <div class="form-group text-right ">
                    <input type="reset" class="btn btn-default" value="Reset"/>
                    <input type="submit" class="btn btn-primary" value="Save"/>

                </div>
            </form>
        </div>
    </div>
</div>