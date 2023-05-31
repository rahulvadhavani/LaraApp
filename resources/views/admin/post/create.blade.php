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
                        <a class="btn btn-sm btn-dark" href="{{route('admin.posts.index')}}">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="0">
                        <div class="row">
                            <div class="col-xs-12 mt-3 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <strong>Title:</strong>
                                    <input required value="{{old('title')}}" type="text" name="title" class="form-control" placeholder="Enter Title">
                                </div>
                                @error('title')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-xs-12 mt-3 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Description:</strong>
                                    <textarea name="description" class="form-control" id="description" rows="3">{{old('description')}}</textarea>                                        <label for="description">Description</label>
                                </div>
                                @error('description')
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
                                    <img src="#" alt="" id="image_preview" width="70px">
                                </div>
                                @error('image')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-xs-12 mt-5 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
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