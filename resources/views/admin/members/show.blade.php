@extends('layouts.admin.master')
@push('title')
    Members > {{ $member->full_name }}
@endpush
@section('main')
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">
                <a href="{{ route('admin.members.all') }}">Members</a>/</span>
            {{ $member->full_name }}
        </h4>

        @if (request()->get('_ref') == 'program' && request()->get('_refID'))
            <a href="{{ route('admin.program.admin_program_detail', ['program' => request()->get('_refID')]) }}"
                data-bs-toggle="tooltip" data-bs-original-title="Go Back" class="btn btn-icon btn-danger">
                <i class="fas fa-arrow-left"></i>
            </a>
        @elseif(request()->get('_ref') == 'transaction-detail' && request()->get('_refID'))
            <a href="{{ route('admin.program.fee.admin_fee_transaction_by_program', ['program' => request()->get('_refID')]) }}"
                data-bs-toggle="tooltip" data-bs-original-title="Go Back" class="btn btn-icon btn-danger">
                <i class="fas fa-arrow-left"></i>
            </a>
        @elseif(request()->get('_ref') == 'teacher' && request()->get('_refID'))
            <a href="{{ route('admin.members.show', ['member' => request()->get('_refID')]) }}" data-bs-toggle="tooltip"
                data-bs-original-title="Go Back" class="btn btn-icon btn-danger">
                <i class="fas fa-arrow-left"></i>
            </a>
        @else
            <a href="{{ route('admin.members.all') }}" data-bs-toggle="tooltip" data-bs-original-title="Go Back"
                class="btn btn-icon btn-danger">
                <i class="fas fa-arrow-left"></i>
            </a>
        @endif
    </div>
    <!-- Responsive Datatable -->
    <div class="row" @if (
        !in_array(adminUser()->role(), [
            App\Classes\Helpers\Roles\Rule::SUPER_ADMIN,
            App\Classes\Helpers\Roles\Rule::ADMIN,
        ]) && !in_array($tab, ['media-info', 'emergency-info'])) data-enable-rule='true' @endif>
        @include('admin.members.partials.user-profile', ['member' => $member])

        @include('admin.members.partials.user-detail', ['member' => $member])
    </div>
    <!--/ Responsive Datatable -->
    <x-modal modal="quickUserView">
        @include('admin.members.modal.user-quick-view')
    </x-modal>
@endsection
