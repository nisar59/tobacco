@extends('layouts.custom_app')
@section('content')
    <div class="content-header">
        <div class="header-section">
            <h1>
                <i class="fa fa-magic"></i>Cash Details View<br>
                <small></small>
            </h1>
        </div>
    </div>
    <!-- END Wizard Header -->
    <!-- Wizard Header -->
    <div class="row">
        <div class="col-md-12">
            <!-- Progress Bar Wizard Block -->
            <div class="block">
                <!-- Progress Bars Wizard Title -->
                <div class="block-title">
                    <h2><strong>Cash</strong> View</h2>
                </div>
                <!-- END Progress Bar Wizard Title -->

                <!-- Progress Bar Wizard Content -->
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-1">
                        <div class="block-section">
                            <h3 class="sub-header text-center"><strong>Files Attachment!</strong></h3>
                            <div class="col-xs-12">
                                {{--750/450--}}
                                @if(!empty($record->attachment_file) && file_exists( 'invoices/' . $record->attachment_file))
                                    <a href="{{ asset('invoices/'.$record->attachment_file) }}" data-toggle="lightbox-image">
                                        <img src="{{ asset('invoices/'.$record->attachment_file) }}" alt="image" class="img-responsive">
                                    </a>
                                @else
                                    <a href="{{ asset('backend/img/placeholders/photos/photo9.jpg/') }}" data-toggle="lightbox-image">
                                        <img src="{{ asset('backend/img/placeholders/photos/photo9.jpg/') }}" alt="image" class="img-responsive">
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-sm-offset-1">
                        <!-- Progress Wizard Content -->
                        <div class="col-sm-12 col-lg-12">
                            <!-- Menu Block -->
                            <div class="block full">
                                <!-- Menu Title -->
                                <div class="block-title clearfix">
                                    <div class="block-options pull-right">
                                        <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip"
                                           title="" data-original-title="Settings"><i class="fa fa-cog"></i></a>
                                    </div>
                                    <h2><i class="fa fa-ticket"></i> Cash <strong>Details</strong></h2>
                                </div>
                                <!-- END Menu Title -->

                                <!-- Menu Content -->
                                <ul class="nav nav-pills nav-stacked">
                                    <li class="active">
                                        <a href="javascript:void(0)">
                                <span class="badge pull-right"
                                      style="background-color: #0c0c00">{{ucfirst($record->type)}}</span>
                                            <strong>Payment Type</strong>
                                        </a>
                                    </li>
                                    <li class="active">
                                        <a href="javascript:void(0)">
                                <span class="badge pull-right"
                                      style="background-color: #0c0c00">{{ucfirst($record->payment_mode)}}</span>
                                            <strong>Payment Mode</strong>
                                        </a>
                                    </li>
                                    <li class="active">
                                        <a href="javascript:void(0)">
                                <span class="badge pull-right"
                                      style="background-color: #0c0c00">$ {{number_format((float)$record->amount, 2, '.', '')}}</span>
                                            <strong>Amount</strong>
                                        </a>
                                    </li>
                                </ul>
                                @if(!empty($record->remarks))
                                    <div class="block block-alt-noborder">
                                        <!-- Comments Content -->
                                        <h3 class="sub-header">Remarks</h3>
                                        <ul class="media-list">
                                            <li class="media">

                                                <div class="media-body">
                                                    <p>{{$record->remarks}}</p>
                                                </div>
                                            </li>
                                        </ul>
                                        <!-- END Comments Content -->
                                    </div>
                                    <!-- END Menu Content -->
                                @endif
                            </div>
                            <!-- END Menu Block -->
                        </div>
                        <!-- END Progress Wizard Content -->
                    </div>
                </div>
                <!-- END Progress Bar Wizard Content -->
            </div>
            <!-- END Progress Bar Wizard Block -->
        </div>
    </div>
@endSection