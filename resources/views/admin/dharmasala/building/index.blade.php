@extends('layouts.admin.master')
@push('page_title') Dharmasala Building @endpush
@section('main')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Dharmasala/</span> Building
    </h4>
    <!-- Responsive Datatable -->
    <div class="row my-1">
        <div class="col-md-12 text-end">
            <button class="btn btn-icon btn-danger" data-bs-target="#buildingModal" data-bs-toggle="modal"><i class="fas fa-plus"></i> </button>
        </div>
    </div>
    <div class="card">
        <h5 class="card-header">Available Building</h5>

        <div class="card-datatable table-responsive">
            <div class="accordion" id="dharamasalaBuilding">
                @foreach ($buildings as $building)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="item_{{$building->getKey()}}">
                            <button class="accordion-button d-inline" @if($building->building_color) style="background: {{$building->building_color}} !important;color:#fff" @endif type="button" data-bs-toggle="collapse" data-bs-target="#{{str($building->building_name)->slug('_')}}_{{$building->getKey()}}" aria-expanded="true" aria-controls="collapseOne">
                                {{$building->building_name}}
                            </button>

                        </h2>
                    <div id="{{str($building->building_name)->slug('_')}}_{{$building->getKey()}}" class="accordion-collapse collapse" aria-labelledby="item_{{$building->getKey()}}" data-bs-parent="#dharamasalaBuilding">
                        <div class="accordion-body my-3">
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-default ajax-modal"
                                        data-method="get"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal"
                                        data-action="{{route('admin.modal.display',['building' => $building->getKey(),'view' => 'dharmasala.building.edit'])}}">
                                    <i class="fas fa-pencil me-2"></i>
                                    Edit Building Info
                                </button>

                                <button class="btn btn-primary ajax-modal mx-1" data-bs-target="#dharmasalaFloorForm" data-bs-toggle="modal" data-action="{{route('admin.modal.display',['view' => 'dharmasala.floors.create','building' => $building->getKey()])}}">
                                    <i class="fas fa-plus me-1"></i> Add Floors
                                </button>

                                <button class="btn btn-danger ajax-modal" data-bs-target="#dharmasalaFloorForm" data-bs-toggle="modal" data-action="{{route('admin.modal.display',['view' => 'dharmasala.floors.create','building' => $building->getKey()])}}">
                                    <i class="fas fa-trash me-1"></i> Delete Floor
                                </button>

                            </div>


                            @foreach ($building->floors as $floor)
                                <div class="row my-3">
                                    <div class="col-md-12 bg-light">
                                        <div class="card-header d-flex justify-content-between">
                                            <h4>{{$floor->floor_name}}</h4>
                                            <div class="d-flex">
                                                <button class="btn btn-primary ajax-modal me-1"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#addRoom"
                                                        data-action="{{route('admin.modal.display',['view' => 'dharmasala.rooms.create','building' => $building->getKey(),'floor' => $floor->getKey()])}}">
                                                    <i class="fas fa-plus"></i> Add Rooms</button>
                                                <button class="btn btn-danger btn-icon data-confirm"
                                                        type="button"
                                                        data-confirm="Removing Floors will deattach rooms from the floors."
                                                        data-action="{{route('admin.dharmasala.floor.delete',['floor' =>$floor])}}">
                                                    <i class="fas fa-trash"></i>
                                                </button>

                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @foreach ($floor->rooms as $room)
                                                    @php
                                                        $defaultColour = 'btn-default';
                                                        $occupied = $room->total_active_reserved_count;

                                                        if ($room->total_active_reserved_count >= $room->room_capacity ) {
                                                            $defaultColour = 'btn-danger';
                                                        } else if ( $room->total_active_reserved_count >= ($room->room_capacity / 2) ) {
                                                            $defaultColour = 'btn-warning';
                                                        } else if ($room->total_active_reserved_count >= 1) {
                                                            $defaultColour = 'btn-success';
                                                        }

                                                    @endphp
                                                    <div class="col-md-1 my-3">
                                                        <button class=" {{$defaultColour}} ajax-modal " data-action="{{route('admin.modal.display',['view' => 'dharmasala.booking.book-user','room' => $room->getKey()])}}" type="button" data-bs-target="#assignUserToRoom" data-bs-toggle="modal">
                                                            @if($room->room_type == "open")
                                                                <i class="fas fa-tent fs-2"></i>
                                                            @else
                                                                <i class="fas fa-bed fs-2"></i>
                                                            @endif
                                                            
                                                            <h5 class="mb-0">{{$room->room_number}}</h5>
                                                            <p>{{$room->total_active_reserved_count}} / {{$room->room_capacity}} </p>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="accordion-footer my-3">
                            <div class="row">
                                <div class="col-md-12 text-end">

                                    <button class="btn btn-primary" data-action="{{route('admin.dharmasala.building.edit',['building' => $building])}}">
                                        <i class="fas fa-pencil me-2"></i>
                                        Edit Building Info
                                    </button>

                                    <button class="btn btn-danger data-confirm" data-confir="Delete Building and remove link with floors and rooms. Already booked will still have this information stored." data-action="{{route('admin.dharmasala.building.delete',['building' => $building])}}" data-method="post">
                                        <i class="fas fa-trash me-2"></i>
                                        Delete Building
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!--/ Responsive Datatable -->
    <x-modal modal="buildingModal">
        @include('admin.modal.dharmasala.building.create');
    </x-modal>
    
    <x-modal modal="editModal"></x-modal>
    <x-modal modal="dharmasalaFloorForm"></x-modal>
    <x-modal modal="addRoom"></x-modal>
    <x-modal modal="assignUserToRoom"></x-modal>
@endsection
