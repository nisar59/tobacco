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
                        <h2>Add Receipts</h2>
                    </div>
                    <!-- END User Assist Title -->

                    <!-- User Assist Content -->
                    <form action="{{url('sales/receivable/save')}}"
                          method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
                        {{csrf_field()}}
                        @if(isset($model) && !empty($model->id)) <input type="hidden" name="id"
                                                                        value="{{$model->id}}"> @else @endif

                        <div class="col-md-12 form-group has-success">
                            <div class="col-md-10">
                                <select id="val_skill_customer_id" name="customer_id"
                                        class="form-control  customer-filters" required="required">
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option @if($customer->customer_id == $selected_customer_id) selected
                                                @endif value="{{$customer->id}}"><strong>Customer
                                                Name: </strong> {{$customer->customer_name}} &nbsp;&nbsp;&nbsp; <strong>Receivables: $</strong> {{$customer->diff_amount}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <input type="hidden" id="val_skill_type" name="type" class="form-control" value="sale_receipts">

                        <div class="col-md-6 col-lg-6 col-sm-6 form-group has-success">
                            <label class="col-md-3 control-label" for="example-text-input2">Date</label>
                            <div class="col-md-9">
                                @if(isset($model) && !empty($model->exp_date))
                                    <input type="date" id="example-text-input2-exp_date" name="exp_date"
                                           class="form-control"
                                           placeholder="Please enter configuration name" data-toggle="tooltip"
                                           value="{{old('exp_date',date('Y-m-d',strtotime($model->exp_date)))}}"
                                           title="Payment Date!" required="required">
                                @else
                                    <input type="date" id="example-text-input2-exp_date" name="exp_date"
                                           class="form-control"
                                           placeholder="Please enter configuration name" data-toggle="tooltip"
                                           value=""
                                           title="Payment Date!" required="required">
                                @endif
                                @if($errors->has('exp_date'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('exp_date') }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-6 form-group has-success">
                            <label class="col-md-3 control-label" for="val_skill_payment_mode">Mode</label>
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
                            <label class="col-md-3 control-label" for="val_skill_payment_mode">Amount</label>
                            <div class="col-md-9">
                                <input type="number" id="example-text-input2-amount" name="amount" class="form-control"
                                       placeholder="Please enter Payment Amount" data-toggle="tooltip"
                                       value="{{old('amount',$model->amount)}}"
                                       title="Payment Amount!" required>
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
                            <label class="col-md-3 control-label" for="val_skill_attachment_file">File
                                Attachment</label>
                            <div class="col-md-9">
                                <input type="file" id="val_skill_attachment_file" name="attachment_file"
                                       class="form-control"
                                       placeholder="Attachment File" data-toggle="tooltip"
                                       value="{{old('attachment_file',$model->attachment_file)}}"
                                       title="Attachment File!">
                                @if(isset($model) && !empty($model->attachment_file)) <input type="hidden"
                                                                                             name="old_attachment_file"
                                                                                             value="{{$model->attachment_file}}"> @endif
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
    </script>
    <script>
        $("#example-text-input2-amount").change(function () {
            var data = $('#val_skill_customer_id').find(":selected").val();
            var amountInput = $(this).val();
            if (data !== '') {
                $.ajax({
                    type: "POST",
                    url: "{{url('sales/fetch/receivable')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': data
                    },
                    dataType: "json",
                    success: function (responce) {
                        if (amountInput > responce.receivable) {
                            Swal.fire(
                                'Oops!',
                                'Receiving must be Equal or below of receivable: ' + responce.receivable + ' !',
                                'error'
                            );
                            $('#example-text-input2-amount').val('0');
                        }
                    }
                });
            }
        });
    </script>

@endsection