<div class="row">
    <div class="col-md-12">
        <!-- User Assist Block -->
        <div class="block">
            <!-- User Assist Title -->
            <div class="block-title">
                <h2><strong>@if(!empty($model->lable)) Update @else Add
                        New @endif</strong> {{ucwords(preg_replace('/\_/', ' ', $config_list_name))}}</h2>
            </div>
            <!-- END User Assist Title -->

            <!-- User Assist Content -->
            <form action="@if(!empty($model->lable)) {{url('config/update')}} @else {{url('config/save')}} @endif"
                  method="post" class="form-horizontal form-bordered">
                {{csrf_field()}}

                @if(!empty($model->lable)) <input type="hidden" name="id" value="{{$model->id}}"> @endif
                <input type="hidden" name="list_name" value="{{$config_list_name}}">
                <div class="form-group">
                    <label class="col-md-4 control-label" for="example-text-input2">Name</label>
                    <div class="col-md-6">
                        <input type="text" id="example-text-input2" name="lable" class="form-control"
                               placeholder="Please enter configuration name" data-toggle="tooltip"
                               value="{{old('lable',$model->lable)}}"
                               title="configuration name!">
                    </div>
                </div>

                @if(!empty($model->lable))
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="val_status">Status</label>
                        <div class="col-md-6">
                            <select id="val_status" name="status" class="form-control">
                                <option @if($model->status == 1) selected="selected"
                                        @endif value="1">Active</option>
                                <option @if($model->status == 0) selected="selected"
                                        @endif value="0">In-Active</option>
                            </select>
                        </div>
                    </div>
                @endif

                {{--@if($config_list_name == 'expenses_type')--}}
                    {{--<div class="form-group">--}}
                        {{--<label class="col-md-4 control-label" for="val_additional_key">Expense Type</label>--}}
                        {{--<div class="col-md-6">--}}
                            {{--<select id="val_additional_key" name="additional_key" class="form-control">--}}
                                {{--<option value="gp">GP</option>--}}
                                {{--<option value="np">NP</option>--}}
                            {{--</select>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--@endif--}}

                <div class="form-group form-actions">
                    <div class="col-md-8 col-md-offset-4">
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