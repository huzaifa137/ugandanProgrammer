@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title">Account Information</h4>
        </div>
        <div class="page-rightheader ml-auto d-lg-flex d-none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="d-flex"><svg class="svg-icon"
                            xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
                            <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3" />
                        </svg><span class="breadcrumb-icon"> Home</span></a></li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </div>
    </div>
    <!--End Page header-->
@endsection
@section('content')
    <!-- Row -->
    <div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Course Information</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Course Title</label>
                        <input type="text" class="form-control" id="title" name="title"
                            placeholder="Enter course title" required>
                    </div>

                    <div class="form-group">
                        <label for="instructor_id">Instructor</label>
                        <select class="form-control" id="instructor_id" name="instructor_id">
                            @foreach ($instructors as $instructor)
                                <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select class="form-control" id="category_id" name="category_id">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="Language">Language</label>
                        <select class="form-control" id="language" name="language">
                            @foreach ($languages as $language)
                                <option value="{{ $language->id }}">{{ $language->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Course Content</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="description">Course Description</label>
                        <textarea class="form-control" id="description" name="description" rows="5"
                            placeholder="Write course description..."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="difficulty">Difficulty</label>
                        <select class="form-control" name="difficulty" id="difficulty">
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="advanced">Advanced</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tags">Tags (comma-separated)</label>
                        <input type="text" class="form-control" name="tags" id="tags"
                            placeholder="e.g. PHP, Laravel, Web Development">
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Settings</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="thumbnail">Thumbnail</label>
                        <input type="file" class="form-control" id="thumbnail" name="thumbnail">
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_published" name="is_published">
                        <label class="form-check-label" for="is_published">Publish Course</label>
                    </div>
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary">Save Course</button>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div><!-- end app-content-->
    </div>
@endsection
@section('js')
@endsection
