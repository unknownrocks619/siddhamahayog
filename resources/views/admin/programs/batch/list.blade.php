@extends('layouts.admin.master')
@push('page_title') Program > Batch List @endpush
@section('main')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">
            <a href="{{route('admin.program.admin_program_list')}}">Programs</a>/ <a href="{{route('admin.program.admin_program_detail',['program'=> $program->getKey()])}}">{{$program->program_name}}</a></span>/ Manage Student Batch
    </h4>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-12 mb-3">
                <a class="btn btn-danger btn-icon" href="{{route('admin.program.admin_program_detail',['program' => $program])}}"><i class="fas fa-arrow-left"></i></a>
            </div>
            <div class="col-md-9 col-sm-12 mb-3">
                <div class="row">
                    <div class="col-md-12 text-end">
                        <a data-bs-target="#assignBatch" data-bs-toggle="modal" class="btn btn-primary btn-icon" href="{{route('admin.program.admin_program_list')}}"><i class="fas fa-link"></i></a>
                        <a data-bs-target="#createNewBatch" data-bs-toggle="modal" class="btn btn-danger btn-icon" href="{{route('admin.program.admin_program_list')}}"><i class="fas fa-plus"></i></a>
                        <a href="#" class="btn btn-secondary disabled">Batch</a>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-body">

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            @foreach ($batches as $batch)
                                <li class="nav-item" role="presentation">
                                    <button
                                            class="nav-link @if(($current_tab && $current_tab == str($batch->batch->batch_name)->slug()->value()) || (! $current_tab && $loop->first)) active @endif"
                                            id="batch-{{$batch->batch->getKey()}}-tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#batchTabContent_{{$batch->batch->getKey()}}"
                                            type="button"
                                            role="tab"
                                            aria-controls="home"
                                            aria-selected="true">
                                        {{$batch->batch->batch_name}}</button>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            @foreach ($batches as $batchProgram)
                                @php $batch = $batchProgram->batch;@endphp
                                <div
                                        class="tab-pane fade show @if(($current_tab && $current_tab == str($batch->batch_name)->slug()->value()) || (! $current_tab && $loop->first)) active @endif"
                                        id="batchTabContent_{{$batch->getKey()}}"
                                        role="tabpanel"
                                        aria-labelledby="batch-{{$batch->getKey()}}-tab">

                                    <div class="card-datatable table-responsive my-2 border-bottom">
                                        <div class="row">
                                            <div class="col-md-12 d-flex justify-content-between align-items-center">
                                                <h4 class="card-header">{{$batch->batch_name}}</h4>
                                                <div class="">
                                                        <button type="button"
                                                                data-method="post"
                                                                data-action="{{route('admin.program.batches.admin_unlink_batch',['program' => $program,'batch'=>$batch])}}"
                                                                data-confirm="Unlink batch will transfer all its student to last available batch. This action cannot be undone. Do you wish to continue ?"
                                                                class="btn btn-danger btn-icon data-confirm">
                                                            <i class="fas fa-unlink"></i>
                                                        </button>
                                                    <button class="btn btn-primary ajax-modal"
                                                            data-action="{{route('admin.modal.display',['view' => 'programs.batch.assign-student','program' => $program->getKey(),'batch' => $batch->getKey()])}}"
                                                            data-bs-target="#assignStudentToProgramBatch"
                                                            data-bs-toggle="modal">Assign Student</button>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table batch-datatable" data-action="{{route('admin.program.batches.admin_batch_students',['program'=> $program,'batch'=> $batch->getKey()])}}" data-batch-id="{{$batch->getKey()}}">
                                            <thead>
                                                <tr class="thead-background-color">
                                                    <th>
                                                        @if($program->getKey() == 5 )
                                                            Total Jap
                                                        @else
                                                            Roll Number
                                                        @endif
                                                    </th>
                                                    <th>Full name</th>
                                                    <th>Phone</th>
                                                    <th>Email</th>
                                                    <th>Country</th>
                                                    <th>Address</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <x-modal modal="assignStudentToProgramBatch"></x-modal>
    <x-modal modal="assignBatch">
        @include('admin.modal.programs.batch.assign',['program' => $program])
    </x-modal>
    <x-modal modal="createNewBatch">
        @include('admin.modal.programs.batch.new',['program' => $program->getKey(),'callback' => 'reload'])
    </x-modal>
@endsection

@push('page_script')
    <script>
        var offSetHeight = parseFloat($('#layout-menu').height()) + parseFloat($('nav').height()) + 20;
        console.log(offSetHeight);
        $.each($('.batch-datatable'), function(index,elm) {
            let _actionUrl = $(elm).data('action');

            $(elm).DataTable({
                processing: true,
                ajax: _actionUrl,
                pageLength: 100,
                serverSide: true,
                columns: [
                    {
                        data: 'roll_number',
                        name: 'roll_number'
                    },
                    {
                        data: "full_name",
                        name: "full_name"
                    },
                    {
                        data: "phone_number",
                        name: "phone_number"
                    },
                    {
                        data: "email",
                        name: "email"
                    },
                    {
                        data : "country",
                        name : 'country'
                    },
                    {
                        data : 'full_address',
                        name : 'full_address'
                    },
                    // {
                    //     data : 'enrolled_date',
                    //     name: 'enrolled_date'
                    // },
                    // {
                    //     data: "action",
                    //     name: "action"
                    // }
                ],
            });
        })
    </script>
@endpush

@push('page_css')
    <style>
        tbody {
            display:block;
            overflow:auto;
        }
        thead, tbody tr {
            display:table;
            width:100%;
            table-layout:fixed;
        }
    </style>
@endpush
