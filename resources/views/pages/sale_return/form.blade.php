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
                        <h2>Add New Sale Return</h2>
                    </div>
                    <!-- END User Assist Title -->

                    <!-- User Assist Content -->
                    <form action="{{url('salesreturns/save')}}"
                          method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
                        {{csrf_field()}}
                        @if(isset($model) && !empty($model->id)) <input type="hidden" name="id"
                                                                        value="{{$model->id}}"> @else @endif

                        <div class="col-md-6 col-lg-6 col-sm-6  form-group has-success">
                            <label class="col-md-2 control-label" for="val_skill_customer_id">Supplier</label>
                            <div class="col-md-10">
                                <select id="val_skill_customer_id" name="customer_id"
                                        class="form-control customer-filters" required="required">
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{$customer->id}}">{{$customer->customer_name}}</option>
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
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6 col-sm-6  form-group has-success">
                            <label class="col-md-2 control-label" for="val_skill_return_date">Date</label>
                            <div class="col-md-10">
                                <input type="date" required id="val_skill_return_date" name="return_date"
                                       class="form-control" value="">
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6 col-sm-6  form-group has-success">
                            <label class="col-md-2 control-label" for="val_skill_qty">Quantity</label>
                            <div class="col-md-10">
                                <input onchange="qtyChange( this.value );" type="number" required id="val_skill_qty"
                                       name="qty" class="form-control" min="1"
                                       value="1">
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6 col-sm-6  form-group has-success">
                            <label class="col-md-2 control-label" for="val_skill_unit_price">Amount</label>
                            <div class="col-md-10">
                                <input type="number" required id="val_skill_unit_price" name="unit_price"
                                       class="form-control" min="0.5" value="1.00" step=".01">
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
        $('.customer-filters').select2();
        $('.product-filters').select2();
    </script>

    <script>
        $("#val_skill_customer_id").change(function () {
            var data = $('#val_skill_customer_id').find(":selected").val();
            if (data !== '') {
                $.ajax({
                    type: "POST",
                    url: "{{url('salesreturns/fetch/product')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': data
                    },
                    dataType: "json",
                    success: function (responce) {
                        var options = '';
                        options += '<option value="">Select Product</option>';
                        $(responce).each(function (index, value) {
                            options += '<option value="' + value.id + '">' + value.code + '</option>';
                        });

                        $('.product-filters').html(options);
                    }
                });
            } else {
                $('.product-filters').html('<option value="">Select Product</option>');
            }
        });
    </script>

    <script>
        $("#val_skill_product_id").change(function () {
            var data = $('#val_skill_product_id').find(":selected").val();
            if (data !== '') {
                $.ajax({
                    type: "POST",
                    url: "{{url('salesreturns/fetch/product/details')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': data
                    },
                    dataType: "json",
                    success: function (responce) {
                        $('#val_skill_unit_price').val(responce.unit_price);
                    }
                });
            }
        });
    </script>

    <script>

        function qtyChange(qty) {
            var cId = $('#val_skill_customer_id').val();
            var pId = $('#val_skill_product_id').val();

            $.ajax({
                type: "POST",
                url: "{{url('salesreturns/fetch/product/qty')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "customer_id": cId,
                    "product_id": pId
                },
                dataType: "json",
                success: function (response) {

                    if (Number(response.quantity) < Number(qty)) {
                        Swal.fire(
                            'Oops!',
                            'Returns should must Below or equal to Purchased Quantity: ' + response.quantity + ' !',
                            'error'
                        );
                        $('#val_skill_qty').val('0');
                    }
                }
            });
        }

    </script>
@endsection