@extends('layouts.admin.master')
@push('page_title') Rooms @endpush
@section('main')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Dharmasala/</span> Rooms
    </h4>
    <!-- Responsive Datatable -->
    <div class="row my-1">
        <div class="col-md-12 text-end">
            <button class="btn btn-icon btn-danger" data-bs-target="#addRoom" data-bs-toggle="modal"><i class="fas fa-plus"></i> </button>
        </div>
    </div>
    <div class="card">
        <h5 class="card-header">Available Rooms</h5>

        <div class="card-datatable table-responsive">
            <table class="table table-hover table-border" id="rooms">
                <thead>
                    <tr>
                       <th>Room Number</th>
                        <th>Building Name</th>
                        <th>Floor</th>
                        <th>Status</th>
                        <th>Total Capacity</th>
                        <th>Amenities</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rooms as $room)
                        <tr>
                            <td>
                                <a href="" class="ajax-modal" data-bs-toggle="modal" data-bs-target="#assignUserToRoom" data-action="{{route('admin.modal.display',['view'=>'dharmasala.booking.book-user','room'=>$room->getKey()])}}">
                                    {{ $room->room_number }}
                                </a>
                            </td>
                            <td>{{ $room->building?->building_name ?? 'Not Assigned' }}</td>
                            <td>{{ $room->floor?->floor_name ?? 'Not Assigned' }}</td>
                            <td>
                                @if(! $room->total_active_reserved_count)
                                    <span class="badge bg-label-success">Empty</span>
                                @else
                                    <a href=""
                                       class="ajax-modal"
                                       data-bs-target="#userBookingList"
                                       data-bs-toggle="modal"
                                       data-action="{{route('admin.modal.display',['view' => 'dharmasala.booking.booked-user-info-room','room' => $room->getKey()])}}"
                                    >
                                        @if($room->total_active_reserved_count >= $room->room_capacity)
                                            <span class="badge bg-label-danger">Full</span>
                                        @else
                                            <span class="badge bg-label-info">{{ $room->total_active_reserved_count }} Used</span>
                                        @endif
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{$room->room_capacity ??  'Not Set' }}
                            </td>
                            <td>
                                @if($room->roomAmenities()->count())
                                    @foreach ($room->roomAmenities() as $amenities)
                                        <span class="mx-1 badge bg-label-primary">
                                            {{$amenities->amenity_name}}
                                        </span>
                                    @endforeach
                                @else
                                        No Amenities Associated
                                @endif
                            </td>
                            <th>
                                <a href="{{route('admin.dharmasala.room.edit',['room' => $room])}}" class="btn btn-primary btn-icon">
                                    <i class="fas fa-pencil"></i>
                                </a>
                                <button data-method="post"
                                        data-action="{{route('admin.dharmasala.rooms.delete',['room' => $room])}}"
                                        type="button"
                                        data-confirm="You are about to delete room and its detail. Rooms that are already in use will still be using same room. This action cannot be undone. Confirm Your Action !"
                                        class="btn btn-danger btn-icon data-confirm">
                                        <i class="fas fa-trash"></i>
                                </button>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!--/ Responsive Datatable -->
    <x-modal modal="addRoom">
        @include('admin.modal.dharmasala.rooms.create');
    </x-modal>
    <x-modal modal="assignUserToRoom"></x-modal>
    <x-modal modal="userBookingList"></x-modal>
@endsection
@push('page_script')
    <script>
        $('#rooms').dataTable();
    </script>
@endpush
