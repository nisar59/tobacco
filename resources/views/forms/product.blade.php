<div class="row">
    <div class="col-md-12">
        <!-- User Assist Block -->
        <div class="block">
            <!-- User Assist Title -->
            <div class="block-title">
                <h2><strong>@if(isset($model) && !empty($model->id)) Update @else Add New @endif</strong> Product</h2>
            </div>
            <!-- END User Assist Title -->

            <!-- User Assist Content -->

            <form action="@if(isset($model) && !empty($model->id)) {{url('/product/update')}} @else {{url('/product/save')}} @endif" method="post" class="form-horizontal form-bordered">

                {{csrf_field()}}
                @if(isset($model) && !empty($model->id)) <input type="hidden" id="product_id" name="id" value="{{$model->id}}"> @else @endif

                <div class="form-group has-success">
                    <label class="col-md-4 control-label" for="example-text-input3-uuid">Product Code</label>
                    <div class="col-md-6">
                        <input type="text" id="example-text-input3-uuid" name="uuid" class="form-control"
                               placeholder="Please enter Product Code" data-toggle="tooltip"
                               value="{{old('uuid',$model->uuid)}}"
                               title="Product Code!" required="required">
                        @if($errors->has('uuid'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('uuid') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-group has-success">
                    <label class="col-md-4 control-label" for="val_skill_manufacturer">Manufacturer</label>
                    <div class="col-md-6">
                        <select id="val_skill_manufacturer" name="manufacturer" class="form-control"
                                required="required">
                            <option value="">Please select Manufacturer</option>
                            @foreach($manufacturers as $manufacturer)
                                <option @if($model->manufacturer == $manufacturer->value) selected="selected"
                                        @endif value="{{$manufacturer->value}}">{{$manufacturer->lable}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group has-success">
                    <label class="col-md-4 control-label" for="val_skill_name">Name</label>
                    <div class="col-md-6">
                        <select id="val_skill_name" name="name" class="form-control" required="required">
                            <option value="">Select Product Type</option>
                            @foreach($products as $product)
                                <option @if($model->name == $product->value) selected="selected"
                                        @endif value="{{$product->value}}">{{$product->lable}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group has-success">
                    <label class="col-md-4 control-label" for="val_skill_flavour">Flavour</label>
                    <div class="col-md-6">
                        <select id="val_skill_flavour" name="flavour" class="form-control" required="required">
                            <option value="">Please select Flavour</option>
                            @foreach($flavours as $flavour)
                                <option @if($model->flavour == $flavour->value) selected="selected"
                                        @endif value="{{$flavour->value}}">{{$flavour->lable}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group has-success">
                    <label class="col-md-4 control-label" for="val_skill_packing">Packing</label>
                    <div class="col-md-6">
                        <select id="val_skill-packing" name="packing" class="form-control" required="required">
                            <option value="">Please select Packing</option>
                            @foreach($packings as $key=>$packing)
                                <option @if($model->packing == $packing->value) selected="selected"
                                        @endif value="{{$packing->value}}">{{$packing->lable}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group has-success">
                    <label class="col-md-4 control-label" for="example-min_stock_level">Stock Level</label>
                    <div class="col-md-6">
                        <input oninput="stockCheck(this)" type="number" min="0" id="example-min_stock_level" name="min_stock_level" class="form-control"
                               placeholder="Please enter minimum stock level" data-toggle="tooltip"
                               value="{{old('min_stock_level',$model->min_stock_level)}}"
                               title="min stock level!">
                        @if($errors->has('min_stock_level'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('min_stock_level') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group has-success">
                    <label class="col-md-4 control-label" for="example-sales_price">Sales Price</label>
                    <div class="col-md-6">
                        <input oninput="check(this)" step="any" min="1" type="number" id="example-sales_price" name="sales_price" class="form-control"
                               placeholder="Please enter sales price" data-toggle="tooltip"
                               value="{{old('sales_price',$model->sales_price)}}"
                               title="Sales Price!">
                        @if($errors->has('sales_price'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('sales_price') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                @if(!empty($model->uuid))
                    <div class="form-group has-success">
                        <label class="col-md-4 control-label" for="val_status">Status</label>
                        <div class="col-md-6">
                            <select id="val_status" name="status" class="form-control">
                                <option @if($model->status == 1) selected="selected"
                                        @endif value="1">Active</option>
                                <option @if($model->status == 0) selected="selected"
                                        @endif value="0">In-Active</option>
                            </select>
                        </div>
                    </div>
                @endif

                <div class="form-group has-success">
                    <label class="col-md-4 control-label" for="example-text-input3">Add Bar-Codes</label>
                    <div class="col-md-8">
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>

                        <div class="alert alert-success print-success-msg" style="display:none">
                            <ul></ul>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered" id="dynamic_field">
                                <tr>
                                    <td><input type="text" name="barcode[]" placeholder="Enter barcode"
                                               class="form-control barcode_list"/></td>
                                    <td>
                                        <button type="button" name="add" id="add" class="btn btn-success">Add More
                                        </button>
                                    </td>
                                </tr>
                                @if(isset($exBarCodes) && !empty($exBarCodes))
                                    @foreach($exBarCodes as $code)
                                        <tr id="row{{$code->id}}" class="dynamic-added">
                                            <td><input type="text" name="barcode_old[]" value="{{$code->barcode}}" placeholder="Enter barcode" class="form-control barcode_list" /></td>
                                            <td><button type="button" name="remove" id="{{$code->id}}" class="btn btn-danger btn_remove">X</button></td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

                <div class="form-group form-actions">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-sm btn-primary pull-right"><i class="fa fa-arrow-right"></i> Save
                        </button>
                    </div>
                </div>
            </form>
            <!-- END User Assist Content -->
        </div>
        <!-- END User Assist Block -->
    </div>

</div>

@section('script')
    <script type="text/javascript">
        var postURL = "<?php echo url('addmore'); ?>";
        var i = 1;

        $('#add').click(function () {
            i++;
            $('#dynamic_field').append('<tr id="row' + i + '" class="dynamic-added"><td><input type="text" name="barcode[]" placeholder="Enter barcode" class="form-control barcode_list" /></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
        });


        $(document).on('click', '.btn_remove', function () {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });

        function printErrorMsg(msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display', 'block');
            $(".print-success-msg").css('display', 'none');
            $.each(msg, function (key, value) {
                $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
            });
        }
    </script>

    <script>
        function check(input) {
            if (input.value <= '0') {
                Swal.fire('Sales Price must b greater than 0');
                $('#example-sales_price').val('1');
            }
        }

        function stockCheck(input) {
            if (input.value <= '0') {
                Swal.fire('Stock Level must b greater than 0');
                $('#example-min_stock_level').val('1');
            }
        }
    </script>
@endsection