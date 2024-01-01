@extends('layouts.admin.master')
@push('page_title') Edit Notice - {{$notice->title}} @endpush
@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-between align-items-center">
                <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">
                <a href="{{route('admin.notices.notice.index')}}">Notices</a>/</span> {{$notice->title}}
                </h4>
                <a href="{{route('admin.notices.notice.index')}}" class="btn btn-danger btn-icon">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
        </div>
        <form action="{{route('admin.notices.notice.update',['notice' => $notice])}}" class="ajax-component-form" method="post">
            @method('PUT')
            <div class="card">
                <h5 class="card-header">Update Notice Info</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="notice_title">Notice Title</label>
                                <input type="text" name="title" value="{{$notice->title}}" id="notice_title" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="notice_type">Select Notice Type</label>
                                <select name="notice_type" id="notice_type" class="form-control">\
                                    @foreach (\App\Models\Notices::TYPES as $key => $value)
                                        <option value="{{$key}}" @if($notice->notice_type == $key) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="notice_status">Status</label>
                                <select name="active" id="status" class="form-control">
                                    <option value="1" @if($notice->active) selected @endif>Active</option>
                                    <option value="0" @if( ! $notice->active) selected @endif>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row my-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="video_url">Video Url</label>
                                <input type="url" @if($notice->settings && isset($notice->settings->link)) value="{{$notice->settings->link}}" @endif name="video_url" id="video_url" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" name="image" id="image" class="form-control">
                            </div>
                        </div>

                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="notice" id="description" class="form-control tiny-mce">{!! $notice->notice !!}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer my-3">
                    <div class="row">
                        <div class="col-md-12 text-end">
                            <button class="btn btn-primary" type="submit">Save Notice</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection

@push('page_script')
@endpush
