@extends('layouts.custom_app')
@section('content')
    <div id="page-content">
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
                                <h2>Update Cash Input</h2>
                            </div>
                            <!-- END User Assist Title -->

                            <!-- User Assist Content -->
                            <form action="{{url('/cash/update')}}"
                                  method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
                                {{csrf_field()}}
                                @if(isset($model) && !empty($model->id)) <input type="hidden" name="id"
                                                                                value="{{$model->id}}"> @else @endif
                                <div class="col-md-6 col-lg-6 col-sm-6 form-group has-success">
                                    <label class="col-md-3 control-label" for="val_skill_type">Input Type</label>
                                    <div class="col-md-9">
                                        <select id="val_skill_type" name="type" class="form-control" required="required">
                                            <option value="cash_input">Cash Input</option>
                                        </select>
                                        @if($errors->has('type'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('type') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-6 form-group has-success">
                                    <label class="col-md-3 control-label" for="example-text-input2">Cash Date</label>
                                    <div class="col-md-9">
                                        @if(isset($model) && !empty($model->exp_date))
                                            <input type="date" id="example-text-input2-exp_date" name="exp_date" class="form-control"
                                                   placeholder="Please enter configuration name" data-toggle="tooltip"
                                                   value="{{old('exp_date',date('Y-m-d',strtotime($model->exp_date)))}}"
                                                   title="Cash Date!">
                                        @else
                                            <input type="date" id="example-text-input2-exp_date" name="exp_date" class="form-control"
                                                   placeholder="Please enter configuration name" data-toggle="tooltip"
                                                   value=""
                                                   title="Cash Date!">
                                        @endif
                                        @if($errors->has('exp_date'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('exp_date') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-6 form-group has-success">
                                    <label class="col-md-3 control-label" for="val_skill_payment_mode">Cash Mode</label>
                                    <div class="col-md-9">
                                        <select id="val_skill_payment_mode" name="payment_mode" class="form-control"
                                                required="required">
                                            <option value="">Please select Payment Mode</option>
                                            @php
                                                $cashMode = \App\Helpers\GeneralHelper::getExpenseModes();
                                            @endphp
                                            @foreach($cashMode as $key=>$mode)
                                                <option @if($model->payment_mode == $key) selected="selected"
                                                        @endif value="{{$key}}">{{$mode}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('payment_mode'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('payment_mode') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-6 form-group has-success">
                                    <label class="col-md-3 control-label" for="val_skill_payment_mode">Cash Amount</label>
                                    <div class="col-md-9">
                                        <input type="number" step="any" id="example-text-input2-amount" name="amount" class="form-control"
                                               placeholder="Please enter Cash Amount" data-toggle="tooltip"
                                               value="{{old('amount',$model->amount)}}"
                                               title="Cash Amount!">
                                        @if($errors->has('amount'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('amount') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-6 form-group has-success">
                                    <label class="col-md-3 control-label" for="val_skill_remarks">Remarks</label>
                                    <div class="col-md-9">
                                        <input type="text" id="val_skill_remarks" name="remarks" class="form-control"
                                               placeholder="Any Remarks" data-toggle="tooltip"
                                               value="{{old('remarks',$model->remarks)}}"
                                               title="Remarks!">
                                        @if($errors->has('remarks'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('remarks') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-6 form-group has-success">
                                    <label class="col-md-3 control-label" for="val_skill_attachment_file">File Attachment</label>
                                    <div class="col-md-9">
                                        <input type="file" id="val_skill_attachment_file" name="attachment_file" class="form-control"
                                               placeholder="Attachment File" data-toggle="tooltip"
                                               value="{{old('attachment_file',$model->attachment_file)}}"
                                               title="Attachment File!">
                                        @if(isset($model) && !empty($model->attachment_file)) <input type="hidden" name="old_attachment_file" value="{{$model->attachment_file}}"> @endif
                                    </div>
                                </div>

                                <div class="form-group form-actions">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-arrow-right"></i> Save
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
    </div>
@endSection