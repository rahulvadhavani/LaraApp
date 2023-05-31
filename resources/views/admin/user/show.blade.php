@extends('layouts.admin_app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <span>{{ $module }}</span>
                        <div>
                            <a class="btn btn-sm btn-dark" href="{{route('admin.users.edit',$user->id)}}">Edit</a>
                            <a class="btn btn-sm btn-dark" href="{{route('admin.users.index')}}">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body d-flex justify-content-center">
                    <div class="card" style="width: 70%;">
                        <div class="d-flex justify-content-center">
                            <img src="{{$user->image}}" style="width:200px" class="card-img-top" alt="{{$user->name}}">
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><b>First Name :</b> {{$user->first_name}} </li>
                                <li class="list-group-item"><b>Last Name :</b> {{$user->last_name}} </li>
                                <li class="list-group-item"><b>Email:</b> {{$user->email}} </li>
                                <li class="list-group-item"><b>Role:</b> {{$user->role}} </li>
                                <li class="list-group-item"><b>Created At :</b> {{$user->created_at}}</li>
                                <li class="list-group-item">
                                    <b>Permissions : </b>
                                    <ul class="list-group list-group-flush">
                                        @foreach($user->permissions as $permission)
                                        <li class="list-group-item">{{$permission}}</li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection