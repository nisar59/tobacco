@extends('layouts.custom_app')
@section('content')
    <div id="page-content">
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
                <div class="block">
                    <!-- User Assist Title -->
                    <div class="block-title">
                        <h2>Add New Purchase Return</h2>
                    </div>
                    <!-- END User Assist Title -->

                    <!-- User Assist Content -->
                    <form action="{{url('purchasereturns/save')}}"
                          method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
                        {{csrf_field()}}
                        @if(isset($model) && !empty($model->id)) <input type="hidden" name="id"
                                                                        value="{{$model->id}}"> @else @endif

                        <div class="col-md-6 col-lg-6 col-sm-6  form-group has-success">
                            <label class="col-md-2 control-label" for="val_skill_supplier_id">Supplier</label>
                            <div class="col-md-10">
                                <select id="val_skill_supplier_id" name="supplier_id"
                                        class="form-control supplier-filters" required="required">
                                    <option value="">Select Supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6 col-sm-6  form-group has-success">
                            <label class="col-md-2 control-label" for="val_skill_product_id">Product</label>
                            <div class="col-md-10">
                                <select id="val_skill_product_id" name="product_id"
                                        class="form-control product-filters" required="required">
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                        <option value="{{$product->id}}">{{$product->uuid}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6 col-sm-6  form-group has-success">
                            <label class="col-md-2 control-label" for="val_skill_return_date">Date</label>
                            <div class="col-md-10">
                                <input type="date" required id="val_skill_return_date" name="return_date" class="form-control" value="">
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6 col-sm-6  form-group has-success">
                            <label class="col-md-2 control-label" for="val_skill_qty">Quantity</label>
                            <div class="col-md-10">
                                <input type="number" required id="val_skill_qty" name="qty" class="form-control" min="1" value="1">
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6 col-sm-6  form-group has-success">
                            <label class="col-md-2 control-label" for="val_skill_unit_price">Amount</label>
                            <div class="col-md-10">
                                <input type="number" required id="val_skill_unit_price" name="unit_price" class="form-control" min="0.5" value="1.00" step=".01">
                            </div>
                        </div>


                        <div class="form-group form-actions">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-arrow-right"></i>
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- END User Assist Content -->
                </div>
                <!-- END User Assist Block -->
            </div>
        </div>
    </div>
@endSection

@section('script')
    <script type="text/javascript">
        $('.supplier-filters').select2();
        $('.product-filters').select2();
    </script>
@endsection