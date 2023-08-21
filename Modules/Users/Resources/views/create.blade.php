@extends('layouts.custom_app')
@section('content')
    <div id="page-content">
        <div class="row">
            <div class="col-md-12">
                <!-- User Assist Block -->
                <div class="block">
                    <div class="block-title">
                        <h2><strong>Create User</strong></h2>
                    </div>
                    <form action="{{url('users/store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="card card-primary">
                                    <div class="card-header bg-white">
                                        <h4>Add Users</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Name</label>
                                                <input type="text" class="form-control" value="{{old('name')}}" name="name"
                                                       placeholder="Name">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Father Name</label>
                                                <input type="text" class="form-control" name="father_name"
                                                       value="{{old('father_name')}}" placeholder="Father Name">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>CNIC</label>
                                                <input type="text" class="form-control" name="cnic" value="{{old('cnic')}}"
                                                       placeholder="CNIC">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Email</label>
                                                <input type="email" class="form-control" value="{{old('email')}}" name="email"
                                                       placeholder="Email">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Phone</label>
                                                <input type="text" class="form-control" name="phone" value="{{old('phone')}}"
                                                       placeholder="Phone">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Password</label>
                                                <input type="password" class="form-control" name="password" placeholder="Password">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Role</label>
                                                <select class="form-control select2" name="role">
                                                    @foreach($data['role'] as $role)
                                                        <option value="{{$role->name}}">{{$role->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end text-right">
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