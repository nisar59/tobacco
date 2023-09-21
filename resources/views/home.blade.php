@extends('layouts.custom_app')

@section('content')
    <!-- Dashboard 2 Content -->
    <div class="content-header content-header-media">
        <div class="header-section">
            <div class="row">
                <!-- Main Title (hidden on small devices for the statistics to fit) -->
                <div class="col-md-3 col-lg-6 hidden-xs hidden-sm">
                    <h1>Welcome <strong>{{ Auth::user()->name }}</strong><br>
                        <small>You Look Awesome!</small>
                    </h1>
                </div>
                <!-- END Main Title -->

                <!-- Top Stats -->
                <div class="col-md-9 col-lg-6">
                    <div class="row text-center">
                        <div class="col-xs-6 col-sm-3">
                            <h2 class="animation-hatch">
                                $<strong>{{$sales}}</strong><br>
                                <small style="font-size: small"><i class="fa fa-money"></i> Sales</small>
                            </h2>
                        </div>
                        <div class="col-xs-6 col-sm-3">
                            <h2 class="animation-hatch">
                                $<strong>{{$purchases}}</strong><br>
                                <small style="font-size: small"><i class="fa fa-money"></i> Purchases</small>
                            </h2>
                        </div>
                        <!-- We hide the last stat to fit the other 3 on small devices -->
                        <div class="col-xs-6 col-sm-3">
                            <h2 class="animation-hatch">
                                $<strong>{{number_format($expenses)}}</strong><br>
                                <small style="font-size: small"><i class="gi gi-briefcase"></i> Expenses</small>
                            </h2>
                        </div>
                        <div class="col-sm-6  col-sm-3">
                            <h2 class="animation-hatch">
                                $<strong>{{number_format($profitLoos)}}</strong><br>
                                <small style="font-size: small"><i class="fa fa-money"></i> Cash-In-Hand</small>
                            </h2>
                        </div>
                    </div>
                </div>
                <!-- END Top Stats -->
            </div>
        </div>
        <!-- For best results use an image with a resolution of 2560x248 pixels (You can also use a blurred image with ratio 10:1 - eg: 1000x100 pixels - it will adjust and look great!) -->
        <img src="{{ asset('backend/img/placeholders/headers/dashboard_header.jpg') }}" alt="header image"
             class="animation-pulseSlow">
    </div>

    <!-- Classic and Bars Chart -->
    <div class="row">
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
                                            @foreach($productTypes as $types)
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
                    <h2><strong>Stock Status</strong></h2>
                </div>
                <!-- END All Orders Title -->

                <!-- All Configuration Content -->

                <div class="table-responsive">
                    <table id="tobacco-product" class="display nowrap dataTable dtr-inline">
                        <thead>
                        <tr>
                            <th style="font-size: medium">Sr.</th>
                            <th style="font-size: medium">Product</th>
                            <th style="font-size: medium">Stock In Hand (Qty)</th>
                            <th style="font-size: medium">Min Stock Level (Qty)</th>
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
    <!-- END Classic and Bars Chart -->
@endsection
@section('script')
    {{--<script src="{{ asset('backend/js/pages/compCharts.js') }}"></script>--}}
    {{--<script type="text/javascript">--}}
    {{--CompCharts.init();--}}
    {{--</script>--}}

    <script type="text/javascript" language="javascript"
            src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>

    <script type="text/javascript">
        var tobacco_product_table = null;
        var i = 0;

        function product_datatable(data={}) {
            tobacco_product_table = $("#tobacco-product").DataTable({
                processing: true,
                serverSide: true,
                select: true,
                paging: true,
                bFilter: false,
                ajax: {
                    url: "{{ url('/home') }}",
                    data: data,
                },
                columns: [
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iDisplayIndex) {
                            i++;
                            $(nTd).html(i);
                        }
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: false,
                        searchable: false,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            var rowData = oData.manufacturer + ' ' + oData.packing + ' ' + oData.flavour + ' ' + oData.name;

                            $(nTd).html(rowData);
                        }
                    },
                    {
                        data: 'stock_in_hand', name: 'stock_in_hand', orderable: false, searchable: false,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            var isnew = oData.stock_in_hand;
                            $(nTd).html(isnew.toLocaleString());
                        }
                    },
                    {data: 'min_stock_level', name: 'min_stock_level', orderable: false, searchable: false},
                    {
                        data: 'unit_price',
                        name: 'unit_price',
                        orderable: false,
                        searchable: false,
                        render: $.fn.dataTable.render.number(',', 2, '')
                    },
                    {
                        data: 'deleted',
                        name: 'deleted',
                        orderable: false,
                        searchable: false,
                        "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                            var isnew = oData.stock_in_hand * +oData.unit_price;
                            $(nTd).html(isnew.toLocaleString());
                        }
                    }
                ],
                "fnRowCallback": function (nRow, oData, iDisplayIndex, iDisplayIndexFull) {
                    if (oData['stock_in_hand'] >= oData['min_stock_level']) {
                        $('td', nRow).css('background-color', 'white');
                    } else {
                        $('td', nRow).css('background-color', '#ff00003d');
                    }
                }

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