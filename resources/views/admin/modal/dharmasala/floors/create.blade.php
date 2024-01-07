@php
    $routeParams = [];
    $building = null;
    if (request()->building) {
        $building = \App\Models\Dharmasala\DharmasalaBuilding::where('id',request()->building)->first();
        $routeParams['building'] = $building->getKey();
    }
@endphp
<form method="post" class="ajax-append ajax-form" action="{{route('admin.dharmasala.floor.create',$routeParams)}}">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Add Floors</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="floor_plan">Floor Name<sup class="text-danger">*</sup></label>
                    <input type="text" name="floor_name" id="floor_name" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="total_rooms">Total Rooms</label>
                    <input type="number" name="total_rooms" id="total_rooms" class="form-control">
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="online_access">Allow Online Access</label>
                    <select name="online_access" id="online_access" class="form-control">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="Status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
        </div>

        @if( ! $building )
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="building">Building</label>
                        <select name="building" id="building" class="form-control">
                            @foreach(\App\Models\Dharmasala\DharmasalaBuilding::get() as $dharmashalaBuilding)
                                <option value="{{$dharmashalaBuilding->getKey()}}">{{$dharmashalaBuilding->building_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add New Floor</button>
    </div>
</form>
