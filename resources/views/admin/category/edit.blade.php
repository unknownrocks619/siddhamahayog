@extends("layouts.portal.app")

@section("page_title")
Program
@endsection

@section("page_css")
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css" />
<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
@endsection


@section("content")
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Categories</h2>
                </div>
            </div>
        </div>
        <x-alert></x-alert>
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('admin.category.update',$category->id) }}" method="post">
                    @csrf
                    @method("PUT")
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <a href="{{ route('admin.category.index') }}" class="btn btn-info">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left-circle">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polyline points="12 8 8 12 12 16"></polyline>
                                            <line x1="16" y1="12" x2="8" y2="12"></line>
                                        </svg>
                                        Go Back</a>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category_name">Category Name
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input type="text" name="category_name" value="{{ old('category_name',$category->category_name) }}" id="category_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="slug">Slug
                                            <sup class="text-danger">*unique</sup>
                                        </label>
                                        <input type="text" name="slug" value="{{ old('slug',$category->slug) }}" id="slug" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 my-2 mt-4">
                                    <div class="form-group">
                                        <label for="category_type">Category Type
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <select name="category_type" id="category_type" class="form-control">
                                            <option value="general">General</option>
                                            <option value="gallery" @if(old('category_type',$category->category_type)=="gallery" ) selected @endif>Gallery</option>
                                            <option value="lms" @if(old('category_type',$category->category_type)=="lms" ) selected @endif>LMS</option>
                                            <option value="video" @if(old('category_type',$category->category_type)=="video" ) selected @endif>Video</option>
                                            <option value="book_upload_category" @if(old('category_type',$category->category_type)=="book_upload_category" ) selected @endif>Book Upload Category</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="parent_category">Parent Category
                                        </label>
                                        <select name="parent_id" class="form-control" id="parent_id">
                                            <option value="">Select Parent Category</option>
                                            @foreach (categories() as $local_category)
                                            <option value="{{ $local_category->id }}" @if(old('parent_id',$category->parent_id) == $category->id) selected @endif>{{ $local_category->category_name }}</option>
                                            @if($local_category->descendants)
                                            @foreach ($category->descendants as $children)
                                            <option value="{{$children->id}}" @if(old('parent_id',$category->parent_id)) selected @endif class="pl-5 ml-3">-{{ $children->category_name }}</option>
                                            @endforeach
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">
                                            Descripton
                                        </label>
                                        <textarea name="description" id="description" class="form-control">{{ old('description',$category->description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update Category</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section("modal")
<!-- Large Size -->
<div class="modal fade" id="addBatch" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('admin.category.store') }}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        New Category
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category_name">Category Name
                                    <sup class="text-danger">*</sup>
                                </label>
                                <input type="text" name="category_name" value="{{ old('category_name') }}" id="category_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category_type">Category Type
                                    <sup class="text-danger">*</sup>
                                </label>
                                <select name="category_type" id="category_type" class="form-control">
                                    <option value="general">General</option>
                                    <option value="gallery" @if(old('category_type')=="gallery" ) selected @endif>Gallery</option>
                                    <option value="lms" @if(old('category_type')=="lms" ) selected @endif>LMS</option>
                                    <option value="video" @if(old('category_type')=="video" ) selected @endif>Video</option>
                                    <option value="book_upload_category" @if(old('category_type')=="book_upload_category" ) selected @endif>Book Upload Category</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parent_category">Parent Category
                                </label>
                                <select name="parent_id" class="form-control" id="parent_id">
                                    <option value="">Select Parent Category</option>
                                    @foreach (categories() as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @if($category->descendants)
                                    @foreach ($category->descendants as $children)
                                    <option value="{{$children->id}}" class="pl-5 ml-3">-{{ $children->category_name }}</option>
                                    @endforeach
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">
                                    Descripton
                                </label>
                                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Create Category</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection


@section("page_script")
<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

@endsection