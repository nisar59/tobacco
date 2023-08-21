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
            <div class="block full">
                <!-- All Configuration Content -->
                <!-- User Assist Title -->
                <div class="block-title">
                    <h2>
                        <strong><a href="javascript:void(0)">{{ucwords(preg_replace('/\_/', ' ', $config_list_name))}}</a>
                            List</strong></h2>
                    <div class="pull-right p-1">
                        <a href="#modal-config-settings" class="enable-tooltip btn btn-primary"
                           data-placement="bottom" title="Settings" data-toggle="modal">
                            <i class="gi gi-plus"></i>
                        </a>
                    </div>
                </div>
                <!-- END User Assist Title -->
                <div class="table-responsive">
                    <table id="tobacco-config" class="table table-vcenter table-striped">
                        <thead class="thead-dark">
                        <tr>
                            <th style="background-color: #6364ff;color:white">Name</th>
                            <th style="background-color: #6364ff;color:white">Status</th>
                            {{--@if($config_list_name == 'expenses_type')--}}
                                {{--<th style="background-color: #6364ff;color:white">Expense Type</th>--}}
                            {{--@endif--}}
                            <th style="background-color: #6364ff;color:white" class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($models as $model)
                            <tr>
                                <td>{{$model->lable}}</td>
                                <td>
                                    @if ($model->status == 1)
                                        <span class="label label-success">Active</span>
                                    @else
                                        <span class="label label-warning">In-Active</span>
                                    @endif
                                </td>
                                {{--@if($config_list_name == 'expenses_type')--}}
                                    {{--<td>{{strtoupper($model->additional_key)}}</td>--}}
                                {{--@endif--}}

                                <td class="text-center">
                                    <div class="btn-group btn-group-xs">
                                        <form id="edit_config_{{$model->id}}" onclick="edit_config({{$model->id}})"
                                              action="" onsubmit="return false"
                                              method="post"
                                              style="display: inline">
                                            <input type="hidden" id="config_edit_id_{{$model->id}}"
                                                   name="config_edit_id" value="{{$model->id}}">
                                            <input type="hidden" id="config_edit_name_{{$model->id}}"
                                                   name="config_edit_name" value="{{$model->value}}">
                                            <input type="hidden" id="config_eidt_status_{{$model->id}}"
                                                   name="config_edit_status" value="{{$model->status}}">
                                            <button type="submit" class="btn btn-secondary cursor-pointer"
                                                    data-target="#modal-config-update"
                                                    data-toggle="modal">
                                                <i class="text-danger fa fa-pencil"></i>
                                            </button>
                                        </form>

                                        @php
                                            $display = \App\Helpers\GeneralHelper::getDisplay($model->value,$model->list_name)
                                        @endphp
                                        <form id="delete_config"
                                              onsubmit="return confirm('Are you sure you want to delete?')"
                                              action="{{url('/config/destroy/' . $model->id) }}"
                                              method="post"
                                              style="display: {{$display}}">
                                            {{csrf_field()}}
                                            {{method_field('POST')}}
                                            <button type="submit" class="btn btn-secondary cursor-pointer">
                                                <i class="text-danger fa fa-remove"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- END All Configuration Block -->
@endSection
@section('mdl')
    <div id="modal-config-settings" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <h2 class="modal-title"><i class="fa fa-pencil"></i> Settings</h2>
                </div>
                <!-- END Modal Header -->

                <!-- Modal Body -->
                <div class="modal-body">
                    <form action="{{url('config/save')}}"
                          method="post" class="form-horizontal form-bordered">
                        <fieldset>
                            {{csrf_field()}}
                            <input type="hidden" name="list_name" value="{{$config_list_name}}">
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="example-text-input2">Name</label>
                                <div class="col-md-6">
                                    <input type="text" id="example-text-input2" name="lable" class="form-control"
                                           placeholder="Please enter configuration name" data-toggle="tooltip"
                                           value=""
                                           title="configuration name!">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="val_status">Status</label>
                                <div class="col-md-6">
                                    <select id="val_status" name="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">In-Active</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-group form-actions">
                            <div class="col-xs-12 text-right">
                                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- END Modal Body -->
            </div>
        </div>
    </div>
    <div id="modal-config-update" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header text-center">
                    <h2 class="modal-title"><i class="fa fa-pencil"></i> Settings</h2>
                </div>
                <!-- END Modal Header -->

                <!-- Modal Body -->
                <div class="modal-body">
                    <form action="{{url('config/update')}}"
                          method="post" class="form-horizontal form-bordered">
                        <fieldset>
                            {{csrf_field()}}
                            <input type="hidden" id="config_list_name" name="list_name" value="{{$config_list_name}}">
                            <input type="hidden" id="config_update_id" name="id" value="">
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="config_update_label">Name</label>
                                <div class="col-md-6">
                                    <input type="text" id="config_update_label" name="lable" class="form-control"
                                           placeholder="Please enter configuration name" data-toggle="tooltip"
                                           value=""
                                           title="configuration name!">
                                </div>
                            </div>

                            @if(!empty($model->lable))
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="config_update_status">Status</label>
                                    <div class="col-md-6">
                                        <select id="config_update_status" name="status" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="0">In-Active</option>
                                        </select>
                                    </div>
                                </div>
                            @endif
                        </fieldset>
                        <div class="form-group form-actions">
                            <div class="col-xs-12 text-right">
                                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-sm btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- END Modal Body -->
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script type="text/javascript">
        setTimeout(function () {
            $("div.alert").remove();
        }, 5000); // 5 secs
    </script>

    <script type="text/javascript">
        function edit_config($this) {

            var id = $('#config_edit_id_' + $this).val();
            var name = $('#config_edit_name_' + $this).val();
            var status = $('#config_eidt_status_' + $this).val();

            $('#config_update_id').val(id);
            $('#config_update_label').val(name);
            $("#config_update_status").val(status).change();
        }
    </script>
@endsection