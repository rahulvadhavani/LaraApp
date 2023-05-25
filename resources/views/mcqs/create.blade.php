@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <span>{{ $module }}</span>
                        <a class="btn btn-sm btn-dark" href="{{route('mcqs.index')}}">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div>
                        <form method="POST" action="{{ route('mcqs.store') }}" class="form">
                            @csrf

                            <div class="form-group">
                                <label for="question">Question:</label>
                                <textarea id="question" name="question" rows="3" class="form-control" required>{{old('question')}}</textarea>
                                @error('question')
                                <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mt-2">
                                <label for="options">Options:</label>
                                <div id="options">
                                    <div class="option row">
                                        <div class="col-10 d-inline-block">
                                            <input type="text" name="options[]" class="form-control" required>
                                        </div>
                                        <div class="col-1 d-inline-block px-2 fs-5">
                                            <input class="form-check-input" type="radio" name="correct_answer" value="0" required>
                                        </div>
                                        <div class="col-1 d-inline-block">
                                            <i style="cursor: pointer;" class="text-danger fs-4 remove-option fa-solid fa-circle-xmark"></i>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" id="add-option" class="my-2 btn btn-dark"><i class="text-danger fa-solid fa-circle-plus"></i> Add</button>
                                @error('options.*')
                                <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-dark">Submit</button>
                            </div>
                        </form>
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
        const addOptionButton = $('#add-option');
        const optionsContainer = $('#options');
        let optionIndex = 1;

        function createOptionField(index) {
            const optionField = $('<div/>', {
                class: 'option row'
            });
            optionField.html(`
            <div class="col-10 d-inline-block mt-2">
                <input  type="text" name="options[]" class="form-control" required>
            </div>
            <div class="col-1 d-inline-block mt-2">
                <input class="form-check-input fs-5" type="radio" name="correct_answer" value="${index}" required>
            </div>
            <div class="col-1 d-inline-block mt-2">
            <i style="cursor: pointer;" class="text-danger fs-4 remove-option fa-solid fa-circle-xmark"></i>
            </div>
        `);
            return optionField;
        }

        function addOption() {
            const optionField = createOptionField(optionIndex);
            optionsContainer.append(optionField);
            optionIndex++;
        }

        function removeOption(event) {
            const optionField = $(event.target).closest('.option');
            optionField.remove();
        }

        addOptionButton.on('click', addOption);
        optionsContainer.on('click', '.remove-option', removeOption);
    });
</script>
@endpush