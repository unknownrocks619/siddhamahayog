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
                <div class="card">
                    <div class="header">
                        <h2>
                            <strong>Categories</strong> Available
                            <ul class="header-dropdown">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="zmdi zmdi-more"></i>
                                    </a>
                                    <ul class="dropdown-menu slideUp">
                                        <li>
                                            <a href="" data-toggle="modal" data-target="#addBatch">
                                                Add new Category
                                            </a>
                                        </li>
                                        <li>
                                            
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="menu_table" class="table table-hover table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                Category Name
                                            </th>
                                            <th>
                                                Category Type
                                            </th>
                                            <th>
                                                Description
                                            </th>
                                            <th>
                                                Total Count
                                            </th>
                                            <th>

                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $category)
                                        <tr>
                                            <td>{{$category->category_name}}</td>
                                            <td>{{ __("category.".$category->category_type) }}</td>
                                            <td>{!! strip_tags($category->description) !!}</td>
                                            <td>0</td>
                                            <td>
                                                <a href="{{ route('admin.category.edit',$category->id) }}" class="pr-3">Edit </a>
                                                <form style="display: inline;" onsubmit="return confirm('Are you sure to delete `{{ $category->category_name }}`')" action="{{ route('admin.category.destroy',$category->id)  }}" method="post">
                                                    @csrf
                                                    @method("DELETE")
                                                    |
                                                    <button class="btn btn-link text-danger"> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
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
                                    @foreach ($categories as $category)
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
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#menu_table').DataTable();
    })
</script>
@endsection