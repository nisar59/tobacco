<div class="row">
    <div class="col-md-12">
        <!-- User Assist Block -->
        <div class="block">
            <!-- User Assist Title -->
            <div class="block-title">
                <h2><strong>@if(isset($model) && !empty($model->id)) Update @else Add New @endif</strong> Supplier</h2>
            </div>
            <!-- END User Assist Title -->

            <!-- User Assist Content -->
            <form action="@if(isset($model) && !empty($model->id)) {{url('/supplier/update')}} @else {{url('/supplier/save')}} @endif" method="post" class="form-horizontal form-bordered">
                {{csrf_field()}}
                @if(isset($model) && !empty($model->id)) <input type="hidden" name="id" value="{{$model->id}}"> @else @endif

                <div class="col-md-6 col-lg-6 col-sm-6 form-group has-success">
                    <label class="col-md-3 control-label" for="example-text-input2-supplier_name">Supplier Name</label>
                    <div class="col-md-9">
                        <input type="text" id="example-text-input2-supplier_name" name="supplier_name" class="form-control"
                               placeholder="Please enter Supplier Name" data-toggle="tooltip" value="{{old('supplier_name',$model->supplier_name)}}"
                               title="Supplier Name!">
                        @if($errors->has('supplier_name'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('supplier_name') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6 form-group has-success">
                    <label class="col-md-2 control-label" for="example-text-input2-address">Address</label>
                    <div class="col-md-10">
                        <input type="text" id="example-text-input2-address" name="address" class="form-control"
                               placeholder="Please enter Address" data-toggle="tooltip" value="{{old('address',$model->address)}}"
                               title="Address!">
                        @if($errors->has('address'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('address') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6 form-group has-success">
                    <label class="col-md-3 control-label" for="example-text-input2-contact_number">Contact Number</label>
                    <div class="col-md-9">
                        <input type="text" id="example-text-input2-contact_number" name="contact_number" class="form-control"
                               placeholder="Please enter Contact Number" data-toggle="tooltip" value="{{old('contact_number',$model->contact_number)}}"
                               title="Contact Number!">
                        @if($errors->has('contact_number'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('contact_number') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6 form-group has-success">
                    <label class="col-md-2 control-label" for="example-text-input2-email_id">Email</label>
                    <div class="col-md-10">
                        <input type="text" id="example-text-input2-email_id" name="email_id" class="form-control"
                               placeholder="Please enter Email" data-toggle="tooltip" value="{{old('email_id',$model->email_id)}}"
                               title="Email!">
                        @if($errors->has('email_id'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('email_id') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-group has-success form-actions">
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