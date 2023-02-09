@extends('layouts.portal.app')

@section('content')
    <section class="content">
        <div class="container-fluid">

            <div class="block-header">
                <div class="row clearfix">
                    <div class="col-lg-5 col-md-5 col-sm-12">
                        <h2>Program `{{ $program->program_name }}` -- <span class="text-danger">Exam Center</span></h2>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-md-12">
                    <x-alert></x-alert>
                    <div class="card">
                        <div class="header">
                            <h2>
                                <strong>
                                    Program
                                </strong>
                                student
                            </h2>
                            <ul class="header-dropdown">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal"
                                        data-target='#addExamTerm'>
                                        <x-plus>Add New Exam</x-plus>
                                    </a>
                                </li>
                                <li class="dropdown">
                                    <a href="{{ route('admin.program.admin_program_detail', [$program->getKey()]) }}"
                                        class="btn btn-danger">
                                        <x-arrow-left>Go Back</x-arrow-left>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            S.No
                                        </th>
                                        <th>
                                            Exam Term
                                        </th>
                                        <th>
                                            Total Questions
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Timer
                                        </th>
                                        <th>

                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($exams as $exam)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>
                                                {{ $exam->title }}
                                            </td>
                                            <td>
                                                {{ $exam->questions->count() }}
                                            </td>
                                            <td>
                                                @if ($exam->active)
                                                    <span class="badge badge-success">
                                                        Active
                                                    </span>
                                                @else
                                                    <span class="badge badge-danger">
                                                        Inactive
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($exam->enable_time)
                                                    <span class="badge badge-success">
                                                        Enabled
                                                    </span>
                                                @else
                                                    <span class="badge badge-danger">
                                                        Disabled
                                                    </span>
                                                @endif

                                                @if ($exam->start_date)
                                                    <p>
                                                        <span style="font-weight: bold">Start Date: </span>
                                                        {{ $exam->start_date }}
                                                    </p>
                                                @endif

                                                @if ($exam->end_date)
                                                    <p>
                                                        <span style="font-weight: bold">End Date: </span>
                                                        {{ $exam->end_date }}
                                                    </p>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.exam.edit', [$program->getKey(), $exam->getKey()]) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <x-plus class="text-info">
                                                        Questions
                                                    </x-plus>
                                                </a>
                                                <a href="{{ route('admin.exam.edit-primary-question', [$program->getKey(), $exam->getKey()]) }}"
                                                    data-target="#editQuestion" data-toggle="modal"
                                                    class="btn btn-primary btn-sm">
                                                    <x-pencil class="text-primary">
                                                        Edit
                                                    </x-pencil>
                                                </a>
                                                <form class="d-inline"
                                                    action="{{ route('admin.exam.delete-primary-question', [$program->getKey(), $exam->getKey()]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <x-trash>
                                                            Delete
                                                        </x-trash>
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
            </div>
        </div>
    </section>

    <x-modal modal='editQuestion'></x-modal>
    <x-modal modal='addExamTerm'>
        <form action="{{ route('admin.exam.store', [$program->getKey()]) }}" method="post">
            @csrf
            <div class="modal-header">
                <h4>
                    Create New Exam Term
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="term">Exam Term
                                <sup class="text-danger">*</sup>
                            </label>
                            <input type="text" name="exam_title" id="term" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control richtext"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="timer">Enable Timer</label>
                            <select name="timer" id="timer" class="form-control show-tick">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Create Exam</button>
            </div>
        </form>
    </x-modal>
@endsection

@section('page_script')
    <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/summernote/dist/summernote.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.richtext').summernote({
                height: 275,
                popover: {
                    image: [],
                    link: [],
                    air: []
                }
            })
        });
    </script>
    <script type="text/javascript">
        $("#editQuestion").on("shown.bs.modal", function(event) {
            $.ajax({
                method: "get",
                url: event.relatedTarget.href,
                success: function(response) {
                    $("#modal-content").html(response);
                }
            })
        });
    </script>
@endsection

@section('page_css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/dist/summernote.css') }}">
@endsection
