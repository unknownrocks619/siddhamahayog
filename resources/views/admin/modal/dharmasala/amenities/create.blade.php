<form method="post" class="ajax-append ajax-form" action="{{route('admin.dharmasala.amenities.create')}}">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Add Amenity Info</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Amenity Name<sup class="text-danger">*</sup></label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="icon">Icon</label>
                    <input type="text" name="icon" id="icon" class="form-control">
                </div>
                <small class="text-info">Icon Reference: <a href="https://fontawesome.com/v6/search?q=bed&o=r&m=free" target="_blank">https://fontawesome.com/v6/search?q=bed&o=r&m=free</a></small>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save Amenity</button>
    </div>
</form>
