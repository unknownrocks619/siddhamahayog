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
                            <button class="accordion-button" @if($building->building_color) style="background: {{$building->building_color}} !important;color:#fff" @endif type="button" data-bs-toggle="collapse" data-bs-target="#{{str($building->building_name)->slug('_')}}_{{$building->getKey()}}" aria-expanded="true" aria-controls="collapseOne">
                                {{$building->building_name}}
                            </button>
                        </h2>
                    <div id="{{str($building->building_name)->slug('_')}}_{{$building->getKey()}}" class="accordion-collapse collapse" aria-labelledby="item_{{$building->getKey()}}" data-bs-parent="#dharamasalaBuilding">
                        <div class="accordion-body my-3">
                            <button class="btn btn-primary ajax-modal" data-bs-target="#dharmasalaFloorForm" data-bs-toggle="modal" data-action="{{route('admin.modal.display',['view' => 'dharmasala.floors.create','building' => $building->getKey()])}}">
                                <i class="fas fa-plus"></i> Add Floors
                            </button>

                            @foreach ($building->floors as $floor)
                                <div class="row my-3">
                                    <div class="col-md-12 bg-light">
                                        <div class="card-header d-flex justify-content-between">
                                            <h4>{{$floor->floor_name}}</h4>
                                            <div>
                                                <button class="btn btn-primary ajax-modal" data-bs-toggle="" data-bs-target="" data-action="route('admin.')"><i class="fas fa-plus"></i> Add Rooms</button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                @foreach ($floor->rooms as $room)
                                                    <div class="col-md-3 my-3">
                                                        <i class="fas fa-bed fs-2"></i>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
    <x-modal modal="dharmasalaFloorForm"></x-modal>

@endsection
