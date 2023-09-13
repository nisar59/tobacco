@extends('layouts.custom_app')
@section('content')
    <!-- All Orders Block -->
    <div class="content-header">
        <div class="header-section">
            <h1>
                <i class="fa fa-ticket"></i>Stock Management<br>
                <small>Product stock details!</small>
            </h1>
        </div>
    </div>

    <!-- All stock Block -->

    <div style="display: none" class="row">
        <div class="col-md-12">
            <div class="accordion accordion-flush" id="accordionFlushExampleStock">
                <div class="accordion-item">
                    <h4 class="accordion-header" id="flush-headingOne">
                        <button class="btn btn-primary accordion-button collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#flush-collapseOneStock" aria-expanded="false"
                                aria-controls="flush-collapseOneStock">
                            <span class="gi gi-search"></span>&nbsp;&nbsp;Stock Search Filters
                        </button>
                    </h4>
                    <div id="flush-collapseOneStock" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                         data-bs-parent="#accordionFlushExampleStock">

                        <div class="block full">
                            <div class="table-responsive">
                                <div class="block-options">
                                    <div class="col-md-7">
                                        <label for="val_skill_report_date">Stock Date From/To</label>
                                        <input type="text" id="val_skill_report_date" name="report_date" value="" class="form-control daterange filters"  style="margin-top: 3px;margin-right: 5px"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="block full">
                <!-- All Orders Title -->
                <div class="block-title">
                    <h2><strong>Stock</strong> Management</h2>
                </div>
                <!-- END All Orders Title -->

                <!-- All Configuration Content -->

                <div class="table-responsive">
                    <table id="tobacco_stock" class="table table-vcenter table-striped">
                        <thead>
                        <tr>
                            <th style="font-size: medium">Report Date</th>
                            <th style="font-size: medium">Opening Stock</th>
                            <th style="font-size: medium">Purchase/Sale Return</th>
                            <th style="font-size: medium">Sale/Purchase Return</th>
                            <th style="font-size: medium">Closing Stock</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- All Products Block -->
    <div class="row">
        <div class="col-md-12">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                    <h4 class="accordion-header" id="flush-headingOne">
                        <button class="btn btn-primary accordion-button collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false"
                                aria-controls="flush-collapseOne">
                            <span class="gi gi-search"></span>&nbsp;&nbsp;Product Search Filters
                        </button>
                    </h4>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                         data-bs-parent="#accordionFlushExample">

                        <div class="block full">
                            <div class="table-responsive">
                                <div class="block-options">
                                    <div class="col-md-3">
                                        <label for="val_skill_product_type">Product Type</label>
                                        <select id="val_skill_product_type" name="name" class="form-control filters"
                                                required="required" style="margin-top: 3px;margin-right: 5px">
                                            <option value="">Search Filter Product Type</option>
                                            @foreach($products as $types)
                                                <option value="{{$types->value}}">{{$types->lable}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="val_skill_manufacturer">Manufacturer</label>
                                        <select id="val_skill_manufacturer" name="manufacturer"
                                                class="form-control filters" required="required"
                                                style="margin-top: 3px;margin-right: 5px">
                                            <option value="">Search Filter Manufacturer</option>
                                            @foreach($manufacturers as $types)
                                                <option value="{{$types->value}}">{{$types->lable}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="val_skill_flavour">Flavour</label>
                                        <select id="val_skill_flavour" name="flavour" class="form-control filters"
                                                required="required" style="margin-top: 3px;margin-right: 5px">
                                            <option value="">Search Filter Flavour</option>
                                            @foreach($flavours as $types)
                                                <option value="{{$types->value}}">{{$types->lable}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="val_skill_packing">Packing</label>
                                        <select id="val_skill_packing" name="packing" class="form-control filters"
                                                required="required" style="margin-top: 3px;margin-right: 5px">
                                            <option value="">Search Filter Packing</option>
                                            @foreach($packings as $types)
                                                <option value="{{$types->value}}">{{$types->lable}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="block full">
                <!-- All Orders Title -->
                <div class="block-title">
                    <h2><strong>Products (SIH)</strong></h2>
                </div>
                <!-- END All Orders Title -->

                <!-- All Configuration Content -->

                <div class="table-responsive">
                    <table id="tobacco-product" class="table table-vcenter table-striped">
                        <thead>
                        <tr>
                            <th style="font-size: medium">Product</th>
                            <th style="font-size: medium">Stock In Hand</th>
                            <th style="font-size: medium">Min Stock Level</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- END All Block -->
@endSection

@section('script')
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <script type="text/javascript">
        $('.daterange').daterangepicker();
    </script>

    <script type="text/javascript">
        var tobacco_table = null;

        function stock_datatable(data={}) {
            console.log(data);
            tobacco_table = $("#tobacco_stock").DataTable({
                processing: true,
                serverSide: true,
                select: true,
                paging: true,
                bFilter: false,
                ajax: {
                    url: "{{ url('report/stock') }}",
                    data: data,
                },
                columns: [
                    {
                        data: 'report_date', name: 'report_date', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            var formattedDate = new Date(oData.report_date);
                            var dateString = moment(oData.report_date).format("Y-MM-DD");

                            $(nTd).html(dateString);
                        }
                    },
                    {data: 'opening_stock', name: 'opening_stock'},
                    {
                        data: 'purchase', name: 'purchase', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            var isnew = oData.purchase+'/'+oData.sale_return;
                            $(nTd).html(isnew);
                        }
                    },
                    {
                        data: 'sale', name: 'sale', "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            var isnew = oData.sale+'/'+oData.purchase_return;
                            $(nTd).html(isnew);
                        }
                    },
                    {data: 'closing_stock', name: 'closing_stock'},
                ],

            });
        }

        stock_datatable();


        $(document).on('change', '.filters', function () {
            var data = {};
            $('.filters').each(function () {
                data[$(this).attr('name')] = $(this).val();
            });
            tobacco_table.destroy();
            stock_datatable(data);
        });

        setTimeout(function(){
            $("div.alert").remove();
        }, 5000 ); // 5 secs
    </script>

    <script type="text/javascript">
        var tobacco_product_table = null;

        function product_datatable(data={}) {
            tobacco_product_table = $("#tobacco-product").DataTable({
                processing: true,
                serverSide: true,
                select: true,
                paging: true,
                bFilter: false,
                ajax: {
                    url: "{{ url('product/index') }}",
                    data: data,
                },
                columns: [
                    {
                        data: 'name', name: 'name', orderable: false, searchable: false, "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            var isnew = oData.name+'-'+oData.manufacturer+'-'+oData.flavour+'-'+oData.packing;
                            $(nTd).html(isnew);
                        }
                    },
                    {data: 'stock_in_hand', name: 'stock_in_hand', orderable: false, searchable: false},
                    {data: 'min_stock_level', name: 'min_stock_level', orderable: false, searchable: false},
                ],

            });
        }

        product_datatable();
        $(document).on('change', '.filters', function () {
            var data = {};
            $('.filters').each(function () {
                data[$(this).attr('name')] = $(this).val();
            });
            tobacco_product_table.destroy();
            product_datatable(data);
        });

        setTimeout(function () {
            $("div.alert").remove();
        }, 5000); // 5 secs
    </script>
@endsection