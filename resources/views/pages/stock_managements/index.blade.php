@extends('layouts.custom_app')
@section('content')
    <!-- All Orders Block -->
    <div class="row">
        <div class="content-header">
            <div class="header-section">
                <div class="content-header">
                    <div class="header-section">
                        <h1>
                            <i class="fa fa-ticket"></i>Stock Management<br>
                        </h1>
                    </div>
                </div>
                <ul class="breadcrumb breadcrumb-top">
                    <li><a href="{{url('/')}}">Home</a></li>
                    <li class="active"><a href="{{url('config/stock')}}">Product wise Stock</a></li>
                </ul>
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

        <div class="col-md-12">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                    <h4 class="accordion-header" id="flush-headingOne">
                        <button class="btn btn-primary accordion-button collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false"
                                aria-controls="flush-collapseOne">
                            <span class="gi gi-search"></span>&nbsp;&nbsp;Search
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
                    <h2><strong>Product wise Stock</strong></h2>
                </div>
                <!-- END All Orders Title -->

                <!-- All Configuration Content -->

                <div class="table-responsive">
                    <table id="tobacco-product" class="display nowrap dataTable dtr-inline">
                        <thead>
                        <tr>
                            <th style="font-size: medium">Product</th>
                            <th style="font-size: medium">Stock In Hand (Qty)</th>
                            <th style="font-size: medium">Per unit (Price)</th>
                            <th style="font-size: medium">Stock Amount (Total)</th>
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
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" />

    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <script type="text/javascript">
        $('.daterange').daterangepicker();
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
                    {data: 'stock_in_hand', name: 'stock_in_hand', orderable: false, searchable: false,render: $.fn.dataTable.render.number(',',  2, '')},
                    {data: 'unit_price', name: 'unit_price', orderable: false, searchable: false,render: $.fn.dataTable.render.number(',',  2, '')},
                    {
                        data: 'deleted', name: 'deleted', orderable: false, searchable: false, "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            var isnew = oData.stock_in_hand*+oData.unit_price;
                            $(nTd).html(isnew.toLocaleString());
                        }
                    }
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