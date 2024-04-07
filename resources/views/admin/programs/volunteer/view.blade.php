@extends('layouts.admin.master')
{{-- @push('title') Program >  Volunteer > {{$volunteer->full_name}} @endpush --}}
@section('main')
    <div class="d-flex justify-content-between align-items-center my-2">
        {{-- <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">
                <a href="{{route('admin.members.all')}}">Program</a>/<a href='{{route("admin.program.volunteer.admin_volunteer_list",["program" => $program])}}'>Volunteer</a>/</span>
            {{$member->full_name}}
        </h4> --}}
        <a href="{{route('admin.program.volunteer.admin_volunteer_list',['program' => $program])}}" data-bs-toggle="tooltip" data-bs-original-title="Go Back" class="btn btn-icon btn-danger">
            <i class="fas fa-arrow-left"></i>
        </a>
    </div>
    <!-- Responsive Datatable -->
    <div class="row">
        @include('admin.members.partials.user-profile',['member' => $member])
        @include('admin.programs.volunteer.partials.user-detail',['member' => $member,'volunteer' => $volunteer])
    </div>
    <x-modal modal="acceptUser"></x-modal>
    <x-modal modal="bulkAccept">
        @include('admin.modal.programs.volunteer.bulk-accept',['program' => $program,'volunteer' =>  $volunteer])
    </x-modal>
@endsection
