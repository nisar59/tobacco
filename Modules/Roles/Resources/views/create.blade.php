@extends('layouts.custom_app')
@section('content')

  <div id="page-content">
    <div class="row">
      <div class="col-md-12">
        <!-- User Assist Block -->
        <div class="block">
          <div class="block-title">
            <h2><strong>Add Roles & Permissions</strong></h2>
          </div>
          <form action="{{url('roles/store')}}" method="post">
            @csrf
            <div class="row">
              <div class="col-12 col-md-12">
                <div class="card card-primary">
                  <div class="card-header bg-white">
                    <h4>Add Roles & Permissions</h4>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label>Role</label>
                      <input type="text" class="form-control" name="role" placeholder="Role">
                    </div>
                    <div class="form-group row">
                      @foreach(AllPermissions() as $name=> $permissions)
                        <div class="col-4">
                          <label class="d-block text-capitalize">{{$name}}</label>
                          @foreach($permissions as $permission)
                            <div class="form-check">
                              <input class="form-check-input" name="permissions[]" value="{{$name.'.'.$permission}}" type="checkbox" id="defaultCheck{{$name.$permission}}">
                              <label class="form-check-label text-capitalize" for="defaultCheck{{$name.$permission}}">
                                {{$permission}}
                              </label>
                            </div>
                          @endforeach
                        </div>
                      @endforeach
                    </div>
                  </div>
                  <div class="card-footer text-end">
                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('js')
@endsection