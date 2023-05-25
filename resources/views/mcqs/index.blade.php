@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
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
                        <a class="btn btn-sm btn-dark" href="{{route('mcqs.create')}}">Create</a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Question</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mcqs as $key => $mcq)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>
                                        <span>
                                            <a class="text-decoration-none text-dark" data-bs-toggle="collapse" href="#collapse_option_{{$key}}" role="button" aria-expanded="false" aria-controls="collapse_option_{{$key}}">
                                                <h5>{{ $mcq->question }}</h5>
                                            </a>
                                        </span>
                                        <div class="collapse" id="collapse_option_{{$key}}">
                                            <div class="card card-body">
                                                <div class=""><b>Created at: </b> {{$mcq->created_at}}</div>
                                                <ul class="list-group">
                                                    @foreach ($mcq->options as $option)
                                                    <li class="list-group-item">
                                                        <input class="form-check-input me-1" {{$option->is_correct ? 'checked' : ''}} type="radio">
                                                        <label class="form-check-label">{{ $option->option }}</label>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-dark btn-circle btn-sm text-warning" href="{{ route('mcqs.show',$mcq->id) }}"><i class="fa-regular fa-eye"></i></a>
                                        <a class="btn btn-dark btn-circle btn-sm text-info" href="{{ route('mcqs.edit',$mcq->id) }}"><i class="fa-regular fa-pen-to-square"></i></a>
                                        <form style="display:inline" method="POST" action="{{ route('mcqs.destroy', $mcq->id) }}" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button data-url="{{ route('mcqs.destroy',$mcq->id) }}" type="submit" class="delete_record btn btn-dark btn-circle btn-sm text-danger"><i class="fa-regular fa-trash-can"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="my-2">
                            {!! $mcqs->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection