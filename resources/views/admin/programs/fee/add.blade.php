@extends("layouts.portal.app")

@section("page_title")
::Add Fee Collection
@endsection

@section("top_css")
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endsection

@section("content")
<section class="content">
    <div class="container">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Program Payment</h2>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                <x-alert></x-alert>
                <div class="card">
                    <div class="header">
                        <h2><strong>Member</strong> Fee Collection </h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <button type="button" onclick="window.location.href='{{route('admin.program.admin_program_detail',[$program->id])}}'" class="btn btn-danger btn-sm boxs-close">
                                    <i class="zmdi zmdi-close"></i> Close</button>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>
                                        Program Name
                                        <sup class="text-danger">*</sup>
                                    </strong>
                                    <input value="{{$program->program_name}}" type="text" name="program_name" id="program_name" readonly class="form-control">
                                    @error("program_name")
                                    <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Member
                                        <sup class="text-danger">*</sup>
                                    </label>
                                    <select placeholder="Click to select member" name="member" class="form-control select_member" id="select_member">
                                        <option>Click to select member</option>
                                        <?php

                                        use App\Models\Member;

                                        $users = Member::get();
                                        ?>

                                        @foreach ($users as $user)
                                        <option value='{{ $user->id }}'>{{ $user->full_name }} &lt;{{ $user->email }}&gt;</option>";
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="student_info">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section("page_script")
<script src="{{ asset ('assets/plugins/momentjs/moment.js') }}"></script> <!-- Moment Plugin Js -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
<script>
    // $(document).ready(function(){
    $("#select_member").select2()
    // });

    $("#select_member").change(function(event) {
        let member = $(this).val();
        $.ajax({
            type: "GET",
            url: "{{ route('admin.program.enroll.admin_program_member_enroll',[$program->id]) }}",
            data: "member=" + member,
            success: function(response) {
                $("#student_info").html(response);
            }
        })
    });
</script>
@endsection