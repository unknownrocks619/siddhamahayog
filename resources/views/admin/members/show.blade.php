@extends('layouts.admin.master')
@push('title') Members > {{$member->full_name}} @endpush
@section('main')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{route('admin.members.all')}}">Members</a>/</span> {{$member->full_name}}
    </h4>
    <!-- Responsive Datatable -->
    <div class="row">
        @include('admin.members.partials.user-profile',['member' => $member])

        @include('admin.members.partials.user-detail',['member' => $member])
    </div>
    <!--/ Responsive Datatable -->
    <x-modal modal="quickUserView">
        @include('admin.members.modal.user-quick-view')
    </x-modal>
@endsection
