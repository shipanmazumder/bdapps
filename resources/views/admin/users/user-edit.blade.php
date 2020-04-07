@extends('admin.layout.default')
@section('title_area')
User Information
@endsection
@section('main_section')
    <div class="content">
        <div class="container">
             @if(Session::has('message'))
                <div class="alert alert-{{Session::get("class")}}">{{Session::get("message")}}</div>
             @endif
            <!-- Start Widget -->
                <div class="row">
                    {!! Form::open(['url' => 'admin/user-edit/'.$single->id]) !!}
                    @method("POST")
                        <div class="col-sm-6">
                            <div class="panel panel-border panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion-test" href="#collapseOne" class="collapsed">
                                          User Information modify
                                        </a>
                                    </h3>
                                </div>
                                    <div class="panel-body">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="name">Name</label><small class="req">*</small><br/>
                                                <input type="text" value="{{$single->name}}" name="name" required placeholder="Name" class="form-control">
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="phone">Phone</label><small class="req">*</small><br/>
                                                <input type="text" value="{{$single->phone}}" name="phone" required placeholder="Phone" class="form-control">
                                                @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="email">Email</label><small class="req">*</small><br/>
                                                <input type="email" value="{{$single->email}}" name="email" required placeholder="Email" class="form-control">
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="versity_name">University</label><small class="req">*</small><br/>
                                                <input type="text" value="{{$single->versity_name}}" name="versity_name" required placeholder="University Name" class="form-control">
                                                @error('versity_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password"  placeholder="Password" name="password" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group pull-right m-t-22">
                                                <input type="submit" class=" btn btn-primary pull-right" value="Update" name="submit" />
                                            </div>
                                        </div>
                                    </div> <!-- panel-body -->
                            </div> <!-- panel -->
                        </div> <!-- col -->
                        {!! Form::close() !!}
                </div>
        </div> <!-- container -->
    </div>
@endsection
