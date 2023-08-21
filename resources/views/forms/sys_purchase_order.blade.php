<div class="row">
    <div class="col-md-12">
        <!-- User Assist Block -->
        <div class="block">
            <!-- User Assist Title -->
            <div class="block-title">
                <h2><strong>@if(isset($model) && !empty($model->id)) Update @else Add @endif</strong> Purchase Order</h2>
            </div>

            <form action="{{url('purchase/save')}}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" name="_method" value="{{isset($method)?$method:'POST'}}"/>
                <div class="col-md-3 form-group">
                    <label for="supplier_id">Supplier</label>
                    <select id="supplier_id" name="supplier_id" class="form-control supplier-filters" required="required">
                        <option value="">Select Supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
                        @endforeach
                    </select>
                    @if($errors->has('supplier_id'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('supplier_id') }}</strong>
                        </div>
                    @endif
                </div>

                <div class="col-md-3 form-group">
                    <label for="order_date">Date</label>
                    <div class="input-group">
                        <input type="date" class="form-control {{ $errors->has('order_date') ? ' is-invalid' : '' }}" name="order_date" id="order_date"
                               value="{{old('order_date',$model->order_date)}}"
                               placeholder="" required="required" >
                        <div class="input-group-addon">
                            <label for="order_date" class="fa fa-calendar">
                            </label>
                        </div>
                    </div>
                    @if($errors->has('order_date'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('order_date') }}</strong>
                        </div>
                    @endif
                </div>

                <div class="col-md-3 form-group">
                    <label for="invoice_number">Invoice Number</label>
                    <input type="text" class="form-control {{ $errors->has('invoice_number') ? ' is-invalid' : '' }}" name="invoice_number" id="invoice_number" value="{{old('invoice_number',$model->invoice_number)}}" placeholder="" maxlength="100" >
                    @if($errors->has('invoice_number'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('invoice_number') }}</strong>
                        </div>
                    @endif
                </div>

                <div class="col-md-3 form-group">
                    <label for="invoice_number">Invoice Image</label>
                    <input type="file" class="form-control {{ $errors->has('image') ? ' is-invalid' : '' }}" name="image" id="image" value="{{old('image',$model->image)}}" placeholder="" maxlength="100" >
                    @if($errors->has('invoice_number'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('invoice_number') }}</strong>
                        </div>
                    @endif
                </div>

                <div class="col-md-12 table-responsive">
                    <table id="tobacco_purchase_supplier" class="table table-vcenter table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Supplier</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Address</th>
                            <th scope="col">Email</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12 purchase overflow-auto form-group">
                    <!--<div style="min-width: 600px">-->
                    <header>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="product_id">Select product</label>
                                <select id="product_id" name="product_id" class="form-control filters-product" required="required">
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}">{{$product->name}}-{{$product->manufacturer}}-{{$product->flavour}}-{{$product->packing}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <div class="col-md-4 form-group">
                                    <label for="add-pro"></label>
                                    <a class="form-control btn btn-info add-filtered-product" id="add-pro"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                    </header>
                    <main>
                        <div class="row">
                            <div class="col-sm-12 col-xs-12 table-responsive">
                                <table id="tobacco_purchase_order" class="table table-condensed" border="0" cellspacing="0" cellpadding="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="text-center col-xs-1 col-sm-1">P-Id</th>
                                        <th class="text-center col-xs-7 col-sm-4">Description</th>
                                        <th class="text-center col-xs-1 col-sm-2">Add Qty</th>
                                        <th class="text-center col-xs-3 col-sm-2">Purchase Price/Unit</th>
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
                                        <th class="text-center"><input type="text" value="0" name="order_total" id="order_total" readonly="readonly"></th>
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