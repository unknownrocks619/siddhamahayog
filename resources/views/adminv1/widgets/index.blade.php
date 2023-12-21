@extends("layouts.portal.app")


@section("page_title")
Widgets
@endsection

@section("content")
<section class="content home">
    <div class="row bg-white">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <x-alert></x-alert>
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <a href="{{ route('admin.widget.create') }}" data-toggle="modal" data-target="#new_widget" class="btn btn btn-primary">Create New Widget</a>
                        </div>
                    </div>
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Widget Type</th>
                                <th>Total Widget</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($widgets as $key => $widget_type_group)
                            <tr>
                                <td>{{__("widget.".$key)}}</td>
                                <td>{{ ($widget_type_group->count()) }}</td>
                                <td>
                                    <a href="{{ route('admin.widget.widget_by_type',['type'=>$key]) }}">
                                        View
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<x-modal modal="new_widget">
    <div class="modal-content">
        <form action="{{ route('admin.widget.create') }}" method="get">
            <div class="modal-header">
                <h5 class="modal-title">
                    Widget Selection
                </h5>
            </div>
            <div class="modal-body">
                <div class="row mt-b">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Widget Name" class="label-control">Widget Name
                                <sup class="text-danger">*</sup>
                            </label>
                            <input required type="text" name="widget_name" id="widget_name" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="widget_type" class="label-control">
                                Widget Type
                                <sup class="text danger">*</sup>
                            </label>
                            <select name="widget_type" id="widget_type" class="form-control">
                                <option value="gallery">Gallery</option>
                                <option value="accordian">Accordian</option>
                                <option value="banner_text">Banner Text</option>
                                <option value="grid_layout">Grid Layout</option>
                                <option value="button">Button</option>
                                <option value="slider">Slider</option>
                                <option value="video">Video</option>
                                <option value="faq">FAQ</option>
                                <option value="pdf_reder">PDF Reader</option>
                                <option value="image">Image</option>
                                <option value="iframe">Iframe</option>
                                <option value="full_text">Full Text</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Create Widget</button>
            </div>
        </form>
    </div>
</x-modal>
@endsection


@section("page_script")
<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

@endsection