@extends('layouts.custom_app')
@section('content')
    <!-- All Orders Block -->
    <div class="content-header">
        <div class="header-section">
            <h1 style="font-weight: bold">
                <i class="fa fa-comments-o"></i>Cash Flow Statement
            </h1>
            <h2>From
                <strong style="font-weight: bold">{{date('m/d/Y', strtotime($date1))}}</strong>
                To
                <strong style="font-weight: bold">{{date('m/d/Y', strtotime($date2))}}</strong>
            </h2>
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
            {{--title="Reset Filters"><i class="fa fa-refresh"></i>--}}
            {{--<button class="btn btn-alt btn-sm btn-primary" onClick="window.print()"><i class="fa fa-download"></i></button>--}}

            {{--</div>--}}
            {{--<h2>Cash in Hand as on start date. {{$date1}}</h2>--}}
            {{--</div>--}}
            <!-- END All Orders Title -->
                <div class="table-responsive">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <table class="display nowrap dataTable dtr-inline">
                            <thead>
                            </thead>
                            <tbody style="background:lightgrey">
                            <tr>
                                <td colspan="2" >&nbsp;</td>
                                <td class="text-right" scope="col">Amount $</td>
                            </tr>
                            <tr style="background-image: linear-gradient(90deg, #090979 0%, #090979 35%, #00d4ff 100%); color:white">
                                <td colspan="2"><strong style="font-weight:bold; font-size: x-large">Cash in Hand as on</strong>&nbsp;&nbsp;<strong style="font-weight:bolder; font-size:x-large">{{date('m/d/Y', strtotime($date1))}}</strong></td>
                                <td class="text-right" style="font-weight: bold">{{number_format($cashInPutPre)}}</td>
                            </tr>
                            </tbody>
                        </table>
                        <br>
                        <table class="display nowrap dataTable dtr-inline">
                            <thead style="background:#e7e7e7">
                            <tr>
                                <th scope="col">Inflows</th>
                                <th scope="col">&nbsp;</th>
                                <th scope="col">&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="2"><strong>Sales</strong></td>
                                <td class="text-right">{{number_format($sales)}}</td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Cash input</strong></td>
                                <td class="text-right">{{number_format($cashInPut)}}</td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong style="font-weight: bold">Total Inflows</strong></td>
                                <td class="text-right" style="font-weight: bold">{{number_format($grossCashInflow)}}</td>
                            </tr>
                            </tbody>
                        </table>
                        <table class="display nowrap dataTable dtr-inline">
                            <thead style="background:#e7e7e7">
                            <tr>
                                <th scope="col">Outflows</th>
                                <th scope="col">&nbsp;</th>
                                <th scope="col">&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="2"> <strong>Purchases</strong></td>
                                <td class="text-right">{{number_format($purchases)}}</td>
                            </tr>
                            @if(!empty($expenseTypesNp) && $expenseTypesNp!=null)
                                @foreach($expenseTypesNp as $expenseTypeNp)
                                    <tr>
                                        <td colspan="2"><strong>{{$expenseTypeNp->lable}}</strong></td>
                                        <td class="text-right">{{number_format(\App\Helpers\GeneralHelper::getExpenseAll($expenseTypeNp->value))}}</td>
                                    </tr>
                                @endforeach
                            @endif
                            <tr>
                                <td colspan="2"><strong style="font-weight: bold">Total Outflows</strong></td>
                                <td class="text-right" style="font-weight: bold">{{number_format($netCashOutflow)}}</td>
                            </tr>
                            </tbody>
                        </table>
                        <table class="display nowrap dataTable dtr-inline">
                            <thead>

                            </thead>
                            <tbody style="background:lightgrey">
                            <tr style="background-image: linear-gradient(90deg, #020051 0%, #090979 35%, #00d4ff 100%); color:white">
                                <td colspan="2"><strong style="font-weight:bold; font-size: x-large">Cash in Hand as on</strong>&nbsp;&nbsp;<strong style="font-weight:bolder; font-size:x-large">{{date('m/d/Y', strtotime($date2))}}</strong></td>
                                <td class="text-right" style="font-weight: bold">{{number_format(($cashInPutPre+$grossCashInflow)-$netCashOutflow)}}</td>
                            </tr>
                            </tbody>
                        </table>
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