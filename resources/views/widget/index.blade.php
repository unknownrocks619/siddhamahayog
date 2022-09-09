@extends("layouts.portal.app")

@section("title")
Widgets
@endsection

@section("css")
<link rel="stylesheet" href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endsection

@section("content")
<!-- Main Content -->
<section class="content home">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-md-6" id="import_form" style="display:none"></div>
            <div class="col-lg-12 col-md-12">
                <x-alert></x-alert>
                <div class="card">
                    <div class="header">
                        <h2><strong>Available</strong> Widgets </h2>
                        <ul class="header-dropdown">
                            <li>
                                <a href="{{ route('admin.course.create') }}" class="btn btn-sm btn-info">
                                    <i class="zmdi zmdi-plus"></i> Add New Widget </a>
                            </li>
                        </ul>
                    </div>
                    <div class="body widgets">
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection


@section("modal")
<div class="modal fade" id="newOrg" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('admin.organisation.store') }}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title" id="defaultModalLabel">New Organisation</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>Organisation</strong> Name
                                <sup class="text-danger">*</sup>
                                <input type="text" value="{{ old('org_name') }}" name="org_name" id="org_name" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Official</strong> Contact Person
                                <sup class="text-danger">*</sup>
                                <input type="text" value="{{ old('organisation_contact_person') }}" name="organisation_contact_person" id="org_contact_person" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Official</strong> Phone Number
                                <sup class="text-danger">*</sup>
                                <input value="{{ old('official_phone_number') }}" type="text" name="official_phone_number" id="org_phone_number" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>Website</strong>
                                <input type="url" name="website" value="{{ old('website') }}" id="website" class="form-control" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <strong>
                                    Organisation Type
                                </strong>
                                <select name="org_type" id="org_type" class="form-control">
                                    <option value="college">College</option>
                                    <option value="school">School</option>
                                    <option value="university">University</option>
                                    <option value="office">Office</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">

                        <div class="col-md-4">
                            <div class="form-group">
                                <strong>Status</strong>
                                <select name="org_status" id="org_status" class="form-control">
                                    <option value="yes">Active</option>
                                    <option value="no">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <strong>Remarks</strong>
                                <textarea name="remarks" id="remark" class="form-control">{{ old('remarks') }}</textarea>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-round waves-effect">SAVE ORGANISATION</button>
                    <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section("script")
<script src="{{ asset ('admin/assets/bundles/mainscripts.bundle.js') }}"></script>
<script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    // $(document).ready(function(){
    //     var table = $("#course_table").dataTable({
    //     processing : true,
    //             serverSide : true,
    //             ajax: "{{ url()->full() }}",
    //             columns : [
    //                 {data: 'course_name', name:'course_name'},
    //                 {data: 'status',name: 'status'},
    //                 {data: 'total_chapters',name:'total_chapters'},
    //                 {data : 'permission', name: 'permission'},
    //                 {data : 'total_student', name: 'total_student'},
    //                 {data : 'action', name: 'action'}
    //             ],
    //     })
    // })
</script>
@endsection