@extends('layouts.admin.master')
@push('page_title') Notices @endpush
@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-between align-items-center">
                <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">
                <a href="{{route('admin.notices.notice.index')}}">Notices</a>/</span> All
                </h4>
                <a href="{{route('admin.notices.notice.create')}}" class="btn btn-danger btn-icon">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="card">
            <h5 class="card-header">All Notices</h5>
            <div class="card-datatable table-responsive">
                <table class="dt-responsive table" id="program-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($notices as $notice)
                        <tr>
                            <td>
                                {{ $notice->title }}
                            </td>
                            <td>
                                {{ \App\Models\Notices::TYPES[$notice->notice_type] }}
                            </td>
                            <td>
                                @if($notice->active)
                                    <span class="badge bg-label-success">
                                        Active
                                    </span>
                                @else
                                    <span class="badge bg-label-danger">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td>
                                <a href="" class="btn btn-primary btn-icon">
                                    <i class="fas fa-pencil"></i>
                                </a>
                                <button data-method="post" data-action="{{ route('admin.notices.notice.destroy',$notice->id) }}" class="btn btn-danger btn-icon" type="button" data-confirm="You are about to delete notice from the system. This action cannot be undone. Are you Sure? ">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('page_script')
@endpush
