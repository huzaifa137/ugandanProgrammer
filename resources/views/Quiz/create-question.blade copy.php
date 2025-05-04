@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title">Quiz</h4>
        </div>
        <div class="page-rightheader ml-auto d-lg-flex d-none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="d-flex"><svg class="svg-icon"
                            xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
                            <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3" />
                        </svg><span class="breadcrumb-icon"> Home</span></a></li>
                <li class="breadcrumb-item active" aria-current="page">Create Quiz</li>
            </ol>
        </div>
    </div>
    <!--End Page header-->
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add Question to: <strong>{{ $quiz->title }}</strong></h3>
                </div>
                
                <form id="quizForm" action="{{ route('questions.store', $quiz->id) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Question</label>
                            <input type="text" name="question" class="form-control" required>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6 mb-0">
                                <div class="form-group">
                                    <label>Question Type</label>
                                    <select name="type" id="question_type" class="form-control" required>
                                        <option value="">--- select ---</option>
                                        <option value="true_false">True / False</option>
                                        <option value="mcq">Multiple Choice (MCQ)</option>
                                        <option value="short_answer">Short Answer</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6 mb-0">
                                <div class="form-group">
                                    <div class="form-group d-none" id="mcq-options">
                                        <label>Options</label>
                                        @for ($i = 0; $i < 4; $i++)
                                            <input type="text" name="options[]" class="form-control mb-2"
                                                placeholder="Option {{ $i + 1 }}">
                                        @endfor
                                        <label>Correct Option (e.g., Option 1)</label>
                                        <input type="text" name="correct_answer_mcqs" class="form-control"
                                            placeholder="Correct Option">
                                    </div>

                                    <div class="form-group d-none" id="true-false">
                                        <label>Correct Answer</label>
                                        <select name="correct_answer_boolean" class="form-control">
                                            <option value="true">True</option>
                                            <option value="false">False</option>
                                        </select>
                                    </div>

                                    <div class="form-group d-none" id="short-answer">
                                        <label>Expected Answer (optional)</label>
                                        <input type="text" name="correct_answer_short_answer" class="form-control"
                                            placeholder="Expected Answer">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="quizId" class="form-control" value="{{ $quizId }}">


                        <div class="form-footer mt-3">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-file-alt me-1"></i> Add question
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
@endsection

@if (session('success'))
    <script>
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
@endif

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('question_type');

        typeSelect.addEventListener('change', function() {
            const selected = this.value;
            document.getElementById('mcq-options').classList.toggle('d-none', selected !== 'mcq');
            document.getElementById('true-false').classList.toggle('d-none', selected !== 'true_false');
            document.getElementById('short-answer').classList.toggle('d-none', selected !==
                'short_answer');
        });
        typeSelect.dispatchEvent(new Event('change'));
    });


    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('question_type');
        const mcqOptions = document.getElementById('mcq-options');
        const trueFalse = document.getElementById('true-false');
        const shortAnswer = document.getElementById('short-answer');
        const shortAnswerName = document.querySelector('input[name="correct_answer_short_answer"]');
        const correctAnswerMcq = document.querySelector('input[name="correct_answer_mcqs"]');


        function toggleFields() {
            const selected = typeSelect.value;

            mcqOptions.classList.toggle('d-none', selected !== 'mcq');
            trueFalse.classList.toggle('d-none', selected !== 'true_false');
            shortAnswer.classList.toggle('d-none', selected !== 'short_answer');

            if (selected === 'mcq') {
                correctAnswerMcq.setAttribute('required', 'required');
            } else {
                correctAnswerMcq.removeAttribute('required');
            }

            if (selected === 'short_answer') {
                shortAnswerName.setAttribute('required', 'required');
            } else {
                shortAnswerName.removeAttribute('required');
            }
        }

        typeSelect.addEventListener('change', toggleFields);

        toggleFields();
    });


    $(document).ready(function() {
        const form = $('#quizForm');
        const submitBtn = form.find('button[type="submit"]');

        form.on('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to add a question to this quiz.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Yes, add it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    submitBtn.prop('disabled', true);
                    submitBtn.html('Adding question... <i class="fas fa-spinner fa-spin"></i>');

                    $.ajax({
                        url: form.attr('action'),
                        method: form.attr('method'),
                        data: form.serialize(),
                        success: function(response) {

                            Swal.fire({
                                title: 'Success!',
                                text: 'Question added successfully!',
                                icon: 'success'
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(data) {
                            $('body').html(data.responseText);
                        }
                    });
                }
            });
        });
    });
</script>

@section('js')
@endsection
