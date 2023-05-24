@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($message = Session::get('success'))
            <div class="mb-2 alert alert-success alert-dismissible fade show" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <span>{{ $module }}</span>
                        <a class="btn btn-sm btn-dark" href="{{route('categories.create')}}">Create</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width:5%">No</th>
                            <th style="width:10%">Image</th>
                            <th style="width: 40%;">Name</th>
                            <th style="width:20">Created At</th>
                            <th class="text-center" style="width:25%">Action</th>
                        </tr>
                        @foreach ($categories as $category)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>
                                <img src="{{ $category->image }}" alt="{{ $category->name }}" width="50">
                            </td>
                            <td>{{ $category->name }}</td>
                            <th>{{$category->created_at}}</th>
                            <td class="text-center">
                                <a class="btn btn-dark btn-circle btn-sm text-warning" href="{{ route('categories.show',$category->id) }}"><i class="fa-regular fa-eye"></i></a>
                                <a class="btn btn-dark btn-circle btn-sm text-info" href="{{ route('categories.edit',$category->id) }}"><i class="fa-regular fa-pen-to-square"></i></a>
                                <button data-url="{{ route('categories.destroy',$category->id) }}" type="button" class="delete_record btn btn-dark btn-circle btn-sm text-danger"><i class="fa-regular fa-trash-can"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    {!! $categories->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="delete_record_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST" id="delete_modal_form">
                <div class="modal-body">
                    <h5>Are you sure you want to <span class="text-danger">delete</span> this record ?</h5>
                    @csrf
                    @method('DELETE')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Yes Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
    $(".delete_record").on('click', function(event) {
            $("#delete_modal_form").attr('action', '#');
            let url = $(this).data('url');
            $("#delete_modal_form").attr('action', url);
            $("#delete_record_modal").modal('show');
        })
    });
</script>

@endpush