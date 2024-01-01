@extends('layouts.admin.master')
@push('page_title') Program List @endpush
@section('main')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{route('admin.program.admin_program_list')}}">Programs</a>/</span>Live
    </h4>
    <!-- Responsive Datatable -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <table class="dt-responsive table" id="program-table">
                <thead>
                    <tr>
                        <th>Zoom Account</th>
                        <th>Program</th>
                        <th>Section</th>
                        <th>Started At</th>
                        <th>Lock Status</th>
                        <th>Started By</th>
                        <th></th>
                    </tr>
                </thead>
                    @foreach ($lives as $live)
                        <tr>
                            <td>
                                {{ $live->zoomAccount->account_username }}
                            </td>
                            <td>
                                <a href="{{route('admin.program.admin_program_detail',['program' => $live->program->getKey()])}}">
                                {{ $live->program->program_name }}
                                </a>
                            </td>
                            <td>
                                @if($live->section_id)
                                    <span class="label label-bg-success">{{$live->programSection->section_name}}</span>
                                @else
                                    <span class="label label-bg-primary">All Sections</span>
                                @endif
                            </td>
                            <td>
                                {{ $live->created_at }}
                            </td>
                            <td>
                                <span class="{{$live->lock ? 'badge bg-danger' : 'badge bg-success'}}">
                                    {{$live->lock ? 'Locked' : 'Open'}}
                                </span>
                            </td>
                            <td>
                                @if($live->started_by)
                                    <span class="label label-bg-success">
                                        {{ $live->programCordinate->full_name }}
                                    </span>
                                @else
                                    <span class="label label-bg-danger">ADMIN</span>
                                @endif
                            </td>
                            <td>
                                <button type="button"
                                        class="btn btn-label-primary ajax-modal"
                                        data-bs-target="#ramDasList"
                                        data-bs-toggle="modal"
                                        data-action="{{route('admin.modal.display',['view' => 'live.ramdas-list','live'=>$live->getKey()])}}",
                                >
                                    Ram Das List
                                </button>
                                <button type="button"
                                        data-method="get"
                                        data-title="Re-Join Zoom Session"
                                        data-confirm="Re-joining the session will not promise to join as Host, If host permission is not available you will be assigned as co-host."
                                        data-action="{{route('admin.program.live-program-as-admin',$live->id)}}"
                                        class="clickable btn btn-success data-confirm">Re-Join</button>
                                <button data-title="Confirm End Live Meeting"
                                        data-confirm="You are about to terminate the live session. This will however will not terminate zoom meeting."
                                        data-method="POST"
                                        data-action="{{route('admin.program.live_program.end',$live->id)}}"
                                        type="button" class="btn btn-danger data-confirm">End Program</button>

                            </td>
                        </tr>
                    @endforeach
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <!--/ Responsive Datatable -->
    <x-modal modal="ramDasList"></x-modal>
@endsection
