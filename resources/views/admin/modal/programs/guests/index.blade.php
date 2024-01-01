<form class="ajax-form" id="guestListForm" action="{{ route('admin.program.guest.store', ['program' => request()->program]) }}" method="post">
    <div class="modal-content">
        <div class="modal-header">
            <h4>Add Guest List</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="first_name">First Name
                            <sup class="text-danger">*</sup>
                        </label>
                        <input type="text" name="first_name" id="first_name" class="form-control" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="middle_name">Middle Name
                        </label>
                        <input type="text" name="middle_name" id="middle_name" class="form-control" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="last_name">Last Name
                            <sup class="text-danger">*</sup>
                        </label>
                        <input type="text" name="last_name" id="last_name" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="row my-4">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="remarks">Remarks
                            <sup class="text-danger">*</sup>
                        </label>
                        <textarea name="remarks" id="remarks" class="form-control border"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="access_code">
                            Access Code
                            <sup class="text-danger">*</sup>
                        </label>
                        <input type="text" required name="access_code" value="{{ \Str::uuid() }}"
                               min="8" id="" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add Guest List</button>
        </div>
    </div>
</form>
