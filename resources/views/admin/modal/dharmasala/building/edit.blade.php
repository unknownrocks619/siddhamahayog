@php
    $building = \App\Models\Dharmasala\DharmasalaBuilding::where('id',request()->building)->first();
@endphp
<form method="post" class="ajax-append ajax-form" action="{{route('admin.dharmasala.building.edit',['building' => $building])}}">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Edit Building Info</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="program_name">Building Name<sup class="text-danger">*</sup></label>
                    <input type="text" name="building_name" value="{{$building->building_name}}" id="building_name" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="total_floors">No. of Floors</label>
                    <input type="number" value="{{$building->floors()->count()}}" name="total_floors" id="floors" class="form-control">
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="building_location">Building Location</label>
                    <input type="text" name="building_location" value="{{$building->building_location}}" id="building_location" class="form-control" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="building_color">Building Color</label>
                    <input type="color" name="building_color" value="{{$building->building_color}}" id="building_color" class="form-control" />
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="category">Building Category</label>
                    <select name="building_category" id="category" class="form-control">
                        @foreach (\App\Models\Dharmasala\DharmasalaBuilding::BuildingCategory as $key => $category)
                            <option value="{{$key}}" @if($key == $building->building_category) selected @endif>{{$category}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="Status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="online" @if($building->status == 'online') selected @endif>Active</option>
                        <option value="offline"  @if($building->status == 'offline') selected @endif>Inactive</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="enable_online_booking">Enable Online Accessible</label>
                    <select name="online_accessible" id="enable_online_booking" class="form-control">
                        <option value="1" @if($building->online) selected @endif>Yes</option>
                        <option value="0"  @if($building->online) selected @endif>No</option>
                    </select>
                </div>
            </div>
        </div>

    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update Building</button>
    </div>
</form>
