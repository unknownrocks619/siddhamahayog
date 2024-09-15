@extends('layouts.admin.master')
@push('page_title')
    Program List
@endpush
@section('main')
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">Programs/</span> All
            </h4>
            @if (adminUser()->role()->isSuperAdmin() || adminUser()->role()->isAdmin())
                <div class="row mb-2">
                    <div class="col-md-12 text-end">
                        <a href="{{ route('admin.program.admin_program_new') }}" class="btn btn-primary"><i
                                class="fas fa-plus"></i>Add New Program</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @if (in_array(auth()->guard('admin')->user()->role_id, \App\Models\Program::EDIT_PROGRAM_ACCESS))
        <div class="row mb-2">
            <div class="col-md-12 text-end">
                <a href="{{ route('admin.program.admin_program_new') }}" class="btn btn-primary"><i
                        class="fas fa-plus"></i>Add New Program</a>
            </div>
        </div>
    @endif

    <!-- Responsive Datatable -->
    <div class="card">
        <h5 class="card-header">All Program </h5>

        <div class="card-datatable table-responsive">
            @include('admin.programs.partials.program-list')
        </div>
    </div>
    <!--/ Responsive Datatable -->
    <x-modal modal="quickUserView">
        @include('admin.members.modal.user-quick-view')
    </x-modal>
    <x-modal modal="newBatch"></x-modal>
    <x-modal modal="liveSessionModal"></x-modal>
    <x-modal modal="mergeSession"></x-modal>
@endsection

@include('admin.programs.partials.footer-script')
