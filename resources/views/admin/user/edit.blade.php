@extends('layouts.admin_app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($message = Session::get('error'))
            <div class="mb-2 alert alert-danger alert-dismissible fade show" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <span>{{ $module }}</span>
                        <a class="btn btn-sm btn-dark" href="{{route('admin.users.index')}}">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update',$user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{$user->id}}">
                        <div class="row">
                            <div class="col-xs-12 mt-3 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <strong>First Name:</strong>
                                    <input required value="{{old('first_name',$user->first_name)}}" type="text" name="first_name" class="form-control" placeholder="Enter First Name">
                                </div>
                                @error('first_name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-xs-12 mt-3 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <strong>Last Name:</strong>
                                    <input required value="{{old('last_name',$user->last_name)}}" type="text" name="last_name" class="form-control" placeholder="Enter Last Name">
                                </div>
                                @error('last_name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-xs-12 mt-3 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Email:</strong>
                                    <input autocomplete="off" required value="{{old('email',$user->email)}}" type="email" name="email" class="form-control" placeholder="Enter Email">
                                </div>
                                @error('email')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-xs-12 mt-3 col-sm-12 col-md-12">
                                <div class="alert alert-warning d-flex align-items-center" role="alert">
                                    <i class="fa-solid fa-circle-info text-danger"></i>
                                    <div class="mx-2">
                                        Leave <b>Password</b> empty, if you are not going to change the password.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <strong>Password:</strong>
                                    <input autocomplete="off" type="password" name="password" class="form-control" placeholder="Enter Password">
                                </div>
                                @error('password')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mt-3 row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <strong for="input_image">Image:</strong>
                                        <input name="image" accept="image/*" class="form-control form-control-lg" id="input_image" type="file">
                                    </div>
                                </div>
                                <div class="col-xs-12  col-sm-12 col-md-6 d-done" id="image_preview_div">
                                    <img src="{{$user->image}}" alt="" id="image_preview" width="70px">
                                </div>
                                @error('image')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mt-3 row">
                                <div class="form-group">
                                    <strong for="permissions">Permissions:</strong>
                                    <div class="p-2">
                                        <strong>Post</strong>
                                        <div class="row p-2">
                                            <div class="form-check col-6">
                                                <input  @checked(in_array("create",$user->permissions))  type="checkbox" name="permissions[]" id="create" value="create" class="form-check-input">
                                                <label class="form-check-label" for="create">create</label>
                                            </div>
                                            <div class="form-check col-6">
                                                <input @checked(in_array("update",$user->permissions)) type="checkbox" name="permissions[]" id="update" value="update" class="form-check-input">
                                                <label class="form-check-label" for="update">Update</label>
                                            </div>
                                            <div class="form-check col-6">
                                                <input @checked(in_array("view",$user->permissions)) type="checkbox" name="permissions[]" id="view" value="view" class="form-check-input">
                                                <label class="form-check-label" for="view">View</label>
                                            </div>
                                            <div class="form-check col-6">
                                                <input @checked(in_array("delete",$user->permissions)) type="checkbox" name="permissions[]" id="delete" value="delete" class="form-check-input">
                                                <label class="form-check-label" for="delete">Delete</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @error('permissions.*')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-xs-12 mt-5 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script>
    $(document).ready(function() {
        $("#input_image").change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image_preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
                $("#image_preview_div").removeClass('d-none');
            }
        });
    });
</script>

@endpush