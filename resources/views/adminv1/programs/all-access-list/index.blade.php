@extends('layouts.portal.app')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row clearfix">
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Section Filter
                            </h2>
                        </div>
                        <form class="filter" action="{{ route('admin.program.section.index', $program->id) }}" method="get">
                            <div class="body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="section">Select Section</label>
                                            <select data-action="{{ route('admin.program.section.index', $program->id) }}"
                                                name="section" id="section" class="form-control">
                                                <option value="all">All</option>
                                                <option value="" @if (!$selectedSection) selected @endif>
                                                    Special Access</option>
                                                @foreach ($program->sections as $section)
                                                    <option value="{{ $section->getKey() }}"
                                                        @if ($selectedSection == $section->getKey()) selected @endif>
                                                        {{ $section->section_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="footer">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-primary">
                                                Apply Filter
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-md-12">
                    <x-alert></x-alert>
                    <div class="card">
                        <div class="header">
                            <h2><strong>Section</strong> Student</h2>
                            <ul class="header-dropdown">
                                <li class="remove">
                                    <button type="button"
                                        onclick="window.location.href='{{ route('admin.program.admin_program_detail', [$program->id]) }}'"
                                        class="btn btn-danger btn-sm boxs-close">
                                        <i class="zmdi zmdi-close"></i> Close</button>
                                </li>
                                <li class="remove">
                                    <a class="btn btn-info btn-sm" data-target="#create_section" data-toggle="modal"
                                        href="javascript:void(0);">
                                        Add Section
                                    </a>
                                </li>
                                @if ((int) $selectedSection)
                                    <li class="remove">
                                        <a class="btn btn-info btn-sm"
                                            href="{{ route('admin.program.sections.admin_edit_section', $selectedSection) }}"
                                            data-toggle="modal" data-target="#edit_create_section">
                                            Edit Section
                                        </a>
                                    </li>
                                @endif
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
                                            Current Section
                                        </th>
                                        <th>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sectionStudent as $student)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>
                                                {{ $student->student->full_name }}
                                            </td>
                                            <td>
                                                {{ $student->section->section_name }}
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.program.sections.admin_change_student_section', [$program->getKey(), $student->student->id, $student->section->getKey()]) }}"
                                                    data-target="#edit_create_section" data-toggle="modal"
                                                    class="btn btn-sm btn-info">Change Section
                                                </a>
                                                @if ($student->allow_all)
                                                    <a href="{{ route('admin.program.section.section-access', [$student->getKey()]) }}"
                                                        class="btn btn-sm btn-danger change-access-list remove-acess">Remove
                                                        Access To All</a>
                                                @else
                                                    <a href="{{ route('admin.program.section.section-access', [$student->getKey()]) }}"
                                                        class="btn btn-sm btn-danger change-access-list add-access">Add to
                                                        Full
                                                        Access</a>
                                                @endif
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
    </section>
    <x-modal modal="userDetail">
        <div class="body" id="modal-content">
        </div>

    </x-modal>

    <div class="modal fade" id="create_section" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role='document'>
            <div class="modal-content" id="section_modal">
                <form method="post" action="{{ route('admin.program.sections.admin_store_section', $program->id) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="modal-header bg-dark text-white">
                            <h4 class="title" id="largeModalLabel">{{ $program->program_name }} - <small>Create
                                    Section</small></h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <b>
                                            Section Name
                                            <sup class="text-danger">
                                                *
                                            </sup>
                                        </b>
                                        <input type="text" name="section_name" required class='form-control'
                                            id="section_time" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <b>
                                            Make Default Section
                                            <sup class="text-danger">*</sup>
                                        </b>
                                        <div class="form-group">
                                            <div class="radio inlineblock m-r-20">
                                                <input type="radio" name="default" id="default_yes" class="with-gap"
                                                    value="1">
                                                <label for="default_yes">Yes</label>
                                            </div>
                                            <div class="radio inlineblock">
                                                <input type="radio" name="default" id="default_no" class="with-gap"
                                                    value="0" checked="">
                                                <label for="default_no">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-block btn-sm ">Create New
                                        Section</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_create_section" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role='document'>
            <div class="modal-content" id="edit_section_modal">
                <h4>Please wait.. Loading Content.</h4>
            </div>
        </div>
    </div>
@endsection

@section('page_script')
    <script src="{{ asset('assets/plugins/momentjs/moment.js') }}"></script> <!-- Moment Plugin Js -->

    <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $("#userDetail").on("shown.bs.modal", function(event) {
            $("#modal-content").empty();
            $.ajax({
                method: "get",
                url: event.relatedTarget.href,
                success: function(response) {
                    $("#modal-content").html(response);
                }
            })
        });
        $("#edit_create_section").on("shown.bs.modal", function(event) {
            $.ajax({
                method: "get",
                url: event.relatedTarget.href,
                success: function(response) {
                    $("#edit_section_modal").html(response);
                }
            })
        });
        $(".change-access-list").on('click', function(event) {
            event.preventDefault();
            $.ajax({
                method: "POST",
                url: $(this).attr('href'),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
                }
            });

            if ($(this).hasClass('add-access')) {
                $(this).removeClass('add-access').addClass('remove-access').text('Remove Access To All');
            } else {
                $(this).removeClass('remove-access').addClass('add-access').text('Add Full Access');
            }
        })
        $(document).ready(function() {
            $("#datatable").DataTable()
        });
        $("form.filter").submit(function(event) {
            event.preventDefault();
            let currentAction = $(this).attr('action');
            let selection = $('#section').find(":selected").val();
            console.log('current Action: ', currentAction);;
            console.log('selection: ', selection);
            $(this).attr('action', currentAction + '/' + selection);
            $('form.filter')[0].submit();
        })
    </script>
@endsection


@section('page_title')
    ::Program :: Unpaid Access :: List
@endsection

@section('page_css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css" />
@endsection
