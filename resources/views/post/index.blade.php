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
                        @if(Auth::user()->can('create',App\Models\Post::class))
                        <a class="btn btn-sm btn-dark" href="{{route('posts.create')}}">Create</a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width:5%">No</th>
                            <th style="width:10%">Image</th>
                            <th style="width: 20%;">Title</th>
                            <th style="width: 20%;">User</th>
                            <th style="width:20%">Created At</th>
                            <th class="text-center" style="width:25%">Action</th>
                        </tr>
                        @foreach ($posts as $post)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>
                                <img src="{{ $post->image }}" alt="{{ $post->name }}" width="40">
                            </td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->user->first_name ?? '-' }} {{ $post->user->last_name ?? '-' }}</td>
                            <th>{{$post->created_at}}</th>
                            <td class="text-center">
                                @if(Auth::user()->can('view',$post))
                                <a class="btn btn-dark btn-circle btn-sm text-warning" href="{{ route('posts.show',$post->id) }}"><i class="fa-regular fa-eye"></i></a>
                                @endif
                                @if(Auth::user()->can('update',$post))
                                <a class="btn btn-dark btn-circle btn-sm text-info" href="{{ route('posts.edit',$post->id) }}"><i class="fa-regular fa-pen-to-square"></i></a>
                                @endif
                                @if(Auth::user()->can('delete',$post))
                                <button data-url="{{ route('posts.destroy',$post->id) }}" type="button" class="delete_record btn btn-dark btn-circle btn-sm text-danger"><i class="fa-regular fa-trash-can"></i></button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    {!! $posts->links() !!}
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