@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <span>{{ $module }}</span>
                        <div>
                        <a class="btn btn-sm btn-dark" href="{{route('categories.edit',$category->id)}}">Edit</a>
                        <a class="btn btn-sm btn-dark" href="{{route('categories.index')}}">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body d-flex justify-content-center">
                    <div class="card" style="width: 70%;">
                        <div class="d-flex justify-content-center">
                            <img src="{{$category->image}}" style="width:200px" class="card-img-top" alt="{{$category->name}}">
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><b>Name :</b> {{$category->name}} </li>
                                <li class="list-group-item"><b>Created At :</b> {{$category->created_at}}</li>
                            </ul>
                        </div>
                    </div>
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
            }
        });
    });
</script>

@endpush