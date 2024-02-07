@extends('layouts.admin.master')
@push('page_title') Room Amenity @endpush
@section('main')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Dharmasala / Rooms</span> / Amenity
    </h4>
    <!-- Responsive Datatable -->
    <div class="row my-1">
        <div class="col-md-12 text-end">
            <button class="btn btn-icon btn-danger" data-bs-target="#addAmenities" data-bs-toggle="modal"><i class="fas fa-plus"></i> </button>
        </div>
    </div>
    <div class="card">
        <h5 class="card-header">All Amenity</h5>

        <div class="card-datatable table-responsive">
            <table class="table table-hover table-border" id="amenitiesListTable">
                <thead>
                    <tr>
                       <th>Amenity Name</th>
                        <th>Icon</th>
                        <th>Available in Rooms</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($amenities as $amenity)
                        <tr>
                            <td>{{$amenity->amenity_name}}</td>
                            <td><i class="{{$amenity->icon}}"></i></td>
                            <td>
                                @forelse ($amenity->rooms() as $room)
                                    <span class="badge bg-label-info mx-1">
                                        {{$room->room_number}}
                                    </span>
                                @empty
                                    Not Attached
                                @endforelse
                            </td>
                            <td>
                                <a href="{{route('admin.dharmasala.amenities.edit',['amenity' => $amenity])}}" class="btn btn-primary btn-icon">
                                    <i class="fas fa-pencil"></i>
                                </a>
                                <button data-method="post" 
                                        data-action="{{route('admin.dharmasala.amenities.delete',['amenity' => $amenity])}}" 
                                        class="btn btn-danger btn-icon data-confirm" 
                                        data-confirm="You are about to delete amenities.@if($amenity->rooms()->count()) This amenity is being used in {{$amenity->rooms()->count()}} room(s). This amenity will be also be removed from these room. @endif This action cannot be undone." 
                                        type="button">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!--/ Responsive Datatable -->
    <x-modal modal="addAmenities">
        @include('admin.modal.dharmasala.amenities.create');
    </x-modal>
@endsection
@push('page_script')
    <script>
        $('#amenitiesListTable').dataTable();
    </script>
@endpush
