@extends("layouts.portal.app")

@section("content")
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row clearfix">
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-md-8">
                <x-alert></x-alert>
                <div class="card">
                    <div class="header">
                        <h2><strong>Quick</strong> Navigation</h2>
                        <ul class="header-dropdown">
                            <li>
                                <a href="{{route('admin.program.admin_program_detail',[$program->id])}}" class="btn btn-danger btn-sm boxs-close">
                                    <i class="zmdi zmdi-close"></i> Close</a>
                            </li>

                        </ul>
                    </div>
                    <div class="body">
                        <table id="datatable" class="table table-border table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        S.No
                                    </th>
                                    <th>
                                        Full Name
                                    </th>
                                    <th>
                                        Phone Number
                                    </th>
                                    <th>
                                        Email Address
                                    </th>
                                    <th>
                                        Remarks
                                    </th>
                                    <th>

                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                <tr>
                                    <td>{{-- $loop->iteration --}}</td>
                                    <td>{{ $student->students->full_name }} </td>
                                    <td>{{ $student->students->phone_number }}</td>
                                    <td>{{ $student->students->email }}</td>
                                    <td>{{ $student->remarks }}</td>
                                    <td>
                                        <form action="{{ route('admin.program.scholarship.remove',[$program->getKey(),$student->students->getKey()]) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <form action="{{ route('admin.program.scholarship.store',$program->getKey()) }}" method="post">
                                @csrf
                                <div class="header">
                                    <h2>
                                        <strong>Add New</strong> Scholar Student
                                    </h2>
                                </div>
                                <div class="body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="student">
                                                    Select Student
                                                    <sup class="text-danger">*</sup>
                                                </label>
                                                <select name="student" id="studentList" class="form-control">
                                                    @foreach ($enrolledStudent as $en_student)
                                                    <option value="{{ $en_student->student->getKey() }}">
                                                        {{ $en_student->student->full_name }} ( {{ $en_student->student->email }})
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Scholar Type">
                                                    Scholarship Type
                                                </label>
                                                <select name="scholarship_type" id="scholarTyp" class="form-control">
                                                    <option value="full">Full</option>
                                                    <option value="vip">VIP</option>
                                                    <option value="void">VOID</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Scholar Type">
                                                    Remarks
                                                </label>
                                                <textarea name="remarks" class="form-control border border-primary"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="footer">
                                    <button type="submit" class="btn btn-primary">Add Scholarship Information</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

@section("page_script")
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>
<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
<script>
    $("#studentList").select2({
        width: "100%"
    })
    $(document).ready(function() {
        $("#datatable").DataTable()
    });
</script>
@endsection


@section("page_title")
::Program :: Scholarship :: List
@endsection

@section("page_css")
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css" />

@endsection