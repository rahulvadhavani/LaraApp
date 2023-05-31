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
                            <a class="btn btn-sm btn-dark" href="{{route('admin.posts.edit',$post->id)}}">Edit</a>
                            <a class="btn btn-sm btn-dark" href="{{route('admin.posts.index')}}">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body d-flex justify-content-center">
                    <div class="card" style="width: 70%;">
                        <div class="d-flex justify-content-center">
                            <img src="{{$post->image}}" style="width:200px" class="card-img-top" alt="{{$post->title}}">
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><b>Title:</b> {{$post->title}} </li>
                                <li class="list-group-item"><b>Description :</b> {{$post->description}} </li>
                                <li class="list-group-item"><b>Created By :</b> {{$post->user->first_name ?? '-'}} {{ $post->user->last_name ??'-'}}</li>
                                <li class="list-group-item"><b>Created At :</b> {{$post->created_at}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection