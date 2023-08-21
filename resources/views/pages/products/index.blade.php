@extends('layouts.custom_app')
@section('content')
    <!-- All Orders Block -->
    <div class="row">
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
                    <div class="block-options pull-right">
                        <a href="{{url('product/create')}}" class="btn btn-alt btn-sm btn-primary" data-toggle="tooltip"
                           title="Add New Product"><i class="fa fa-plus"></i></a>
                        <a href="{{url('product/index')}}" class="btn btn-alt btn-sm btn-primary" data-toggle="tooltip"
                           title="Reset Filters"><i class="fa fa-refresh"></i></a>
                    </div>
                    <h2><strong>Products List</strong></h2>
                </div>
                <!-- END All Orders Title -->

                <!-- All Configuration Content -->

                <div class="table-responsive">
                    <table id="tobacco-product" class="display nowrap dataTable dtr-inline">
                        <thead>
                        <tr>
                            <th style="font-size: medium">Code</th>
                            <th style="font-size: medium">Manufacturer</th>
                            <th style="font-size: medium">Packing</th>
                            <th style="font-size: medium">Flavour</th>
                            <th style="font-size: medium">Product Type</th>
                            <th style="font-size: medium">Sale Price</th>
                            <th style="font-size: medium">Status</th>
                            <th style="font-size: medium">Action</th>
                        </tr>
                        </thead>
                        <tbody style="text-align: center;">

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- END All Configuration Block -->
@endSection

@section('script')
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" />

    <script type="text/javascript">
        var tobacco_table = null;

        function product_datatable(data={}) {
            console.log(data);
            tobacco_table = $("#tobacco-product").DataTable({
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
                    {data: 'uuid', name: 'uuid', orderable: false, searchable: false},
                    {data: 'manufacturer', name: 'manufacturer', orderable: false, searchable: false, "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            var isnew = oData.manufacturer;
                            $(nTd).html(isnew.charAt(0).toUpperCase()+isnew.slice(1).toLowerCase());
                        }
                    },
                    {data: 'packing', name: 'packing', orderable: false, searchable: false},
                    {data: 'flavour', name: 'flavour', orderable: false, searchable: false, "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            var isnew = oData.flavour;
                            $(nTd).html(isnew.charAt(0).toUpperCase()+isnew.slice(1).toLowerCase());
                        }
                    },
                    {data: 'name', name: 'name', orderable: false, searchable: false, "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            var isnew = oData.name;
                            $(nTd).html(isnew.charAt(0).toUpperCase()+isnew.slice(1).toLowerCase());
                        }
                    },
                    {data: 'sales_price', name: 'sales_price', orderable: false, searchable: false},
                    {
                        data: 'status', name: 'status', orderable: false, searchable: false, "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            var isnew;

                            if (oData.status === 1) {
                                isnew = '<span class="label label-success">Active</span>';
                            } else {
                                isnew = '<span class="label label-warning">In-Active</span>';
                            }
                            $(nTd).html(isnew);
                        }
                    },
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],

            });
        }

        product_datatable();


        $(document).on('change', '.filters', function () {
            var data = {};
            $('.filters').each(function () {
                data[$(this).attr('name')] = $(this).val();
            });
            tobacco_table.destroy();
            product_datatable(data);
        });

        setTimeout(function () {
            $("div.alert").remove();
        }, 5000); // 5 secs
    </script>
@endsection