@extends('layouts.custom_app')
@section('content')
    <!-- All Orders Block -->
    <div class="content-header">
        <div class="header-section">
            <h1 style="font-size: 20px!important;">
                <i class="fa fa-comments-o"></i>Cash Flow Statement from {{date('d-m-y', strtotime($date1))}}
                to {{date('d-m-y', strtotime($date2))}}
            </h1>
        </div>
    </div>

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
                                    <div class="col-md-12">
                                        <form action="{{url('report/profit/loss')}}"
                                              method="GET" class="form-horizontal form-bordered">
                                            {{csrf_field()}}
                                            <div class="col-md-12 form-group">
                                                <div class="col-md-6">
                                                    <label for="val_skill_exp_date">Date From/To</label>
                                                    <input type="text" id="val_skill_exp_date" name="exp_date" value=""
                                                           class="form-control daterange filters"
                                                           style="margin-top: 3px;margin-right: 5px"/>
                                                </div>
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-sm btn-primary"><i
                                                                class="fa fa-arrow-right"></i> Submit
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
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
            {{--<div class="block-title">--}}
            {{--<div class="block-options pull-right">--}}
            {{--<a href="{{url('report/profit/loss')}}" class="btn btn-alt btn-sm btn-primary"--}}
            {{--data-toggle="tooltip"--}}
            {{--title="Reset Filters"><i class="fa fa-refresh"></i></a>--}}
            {{--<button class="btn btn-alt btn-sm btn-primary" onClick="window.print()"><i class="fa fa-download"></i></button>--}}

            {{--</div>--}}
            {{--<h2>Cash in Hand as on start date. {{$date1}}</h2>--}}
            {{--</div>--}}
            <!-- END All Orders Title -->
                <div class="table-responsive">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <hr style="border-top:3px solid red">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <h4>
                                    <a href="javascript:void(0)" style="font-size:large;color:black"><strong>Cash in
                                            Hand as on {{date('d-m-y', strtotime($date1))}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></a><br>
                                </h4>
                            </div>
                            <div class="col-md-6 text-right" style="padding-right: 0!important;">
                                <a href="javascript:void(0)"
                                   style="color: black!important;font-weight:bold">{{number_format($cashInPutPre)}}</a>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top: 1em">
                            <table id="prt-table" class="display nowrap dtr-inline">
                                <thead>
                                <tr>
                                    <th style="font-size: large">Inflows</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <table id="pr-table" class="display nowrap dataTable dtr-inline"
                                   style="margin: 1em 0 0 3em">
                                <thead>
                                <tr>
                                    <th colspan="1">Description</th>
                                    <th class="text-center" style="width: 100px;">$</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td style="padding-left:18px">
                                        <h4>
                                            <a href="javascript:void(0)"><strong>Sales</strong></a><br>
                                            <small></small>
                                        </h4>
                                    </td>
                                    <td class="text-center "><a
                                                href="javascript:void(0)">{{number_format($sales)}}</a></td>
                                </tr>
                                <tr>
                                    <td style="padding-left:18px">
                                        <h4>
                                            <a href="javascript:void(0)"><strong>Cash input</strong></a><br>
                                            <small></small>
                                        </h4>
                                    </td>
                                    <td class="text-center "><a
                                                href="javascript:void(0)">{{number_format($cashInPut)}}</a></td>
                                </tr>
                                <tr>
                                    <td style="padding-left:18px">
                                        <h4>
                                            <a href="javascript:void(0)"><strong>Total Inflows</strong></a><br>
                                            <small></small>
                                        </h4>
                                    </td>
                                    <td class="text-center "><a
                                                href="javascript:void(0)">{{number_format($grossCashInflow)}}</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <table>
                                <thead>
                                <tr>
                                    <th style="font-size: large">Outflows</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <table id="ls-table" class="display nowrap dataTable dtr-inline"
                                   style="margin: 1em 0 0 3em">
                                <thead>
                                <tr>
                                    <th>Description</th>
                                    <th class="text-center " style="width: 100px;">$</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td style="padding-left:18px">
                                        <h4>
                                            <a href="javascript:void(0)"><strong>Purchases</strong></a><br>
                                            <small></small>
                                        </h4>
                                    </td>
                                    <td class="text-center "><a
                                                href="javascript:void(0)">{{number_format($purchases)}}</a></td>
                                </tr>
                                @if(!empty($expenseTypesNp) && $expenseTypesNp!=null)
                                    @foreach($expenseTypesNp as $expenseTypeNp)
                                        <tr>
                                            <td style="padding-left:18px">
                                                <h4>
                                                    <a href="javascript:void(0)"><strong>{{$expenseTypeNp->lable}}</strong></a><br>
                                                    <small></small>
                                                </h4>
                                            </td>
                                            <td class="text-center "><a
                                                        href="javascript:void(0)">{{number_format(\App\Helpers\GeneralHelper::getExpenseAll($expenseTypeNp->value))}}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                <tr>
                                    <td style="padding-left:18px">
                                        <h4>
                                            <a href="javascript:void(0)"><strong>Total Outflows&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></a><br>
                                            <small></small>
                                        </h4>
                                    </td>
                                    <td class="text-center "><a
                                                href="javascript:void(0)">{{number_format($netCashOutflow)}}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: solid 0;border-style: none solid solid none;">&nbsp;</td>
                                    <td style="border: 0;border-style: none solid solid none;">&nbsp;</td>
                                </tr>

                                <tr style="margin-top: 10px!important;">
                                    <td>
                                        <h4>
                                            <a href="javascript:void(0)" style="font-size:large;color:black"><strong>Cash
                                                    in Hand as on {{date('d-m-y', strtotime($date2))}}
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></a><br>
                                        </h4>
                                    </td>
                                    <td class="text-center"><a
                                                href="javascript:void(0)"
                                                style="color: black!important;font-weight:bold">{{number_format(($cashInPutPre+$grossCashInflow)-$netCashOutflow)}}</a>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>&nbsp;
                        <hr style="border-top:3px solid red">
                    </div>
                    <div class="col-md-2"></div>
                </div>
                <hr>

                {{--<div class="block-title" style="display: none">--}}
                {{--<div class="col-md-12">--}}
                {{--<table>--}}
                {{--<thead>--}}
                {{--<tr>--}}
                {{--<th class="totalCashInHandHeading" style="font-size: large">Cash in Hand as on today. {{$date2}}</th>--}}
                {{--<th class="totalCashInHand"></th>--}}
                {{--<th style="font-size: x-large;color:red!important;">{{$grossCashInflow-$netCashOutflow}}</th>--}}
                {{--</tr>--}}
                {{--</thead>--}}
                {{--</table>--}}
                {{--</div>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>

    <!-- END All Configuration Block -->
@endSection

@section('script')
    <script type="text/javascript" language="javascript"
            src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>

    <script type="text/javascript"
            src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <script type="text/javascript">
        $('.daterange').daterangepicker();
    </script>
@endsection