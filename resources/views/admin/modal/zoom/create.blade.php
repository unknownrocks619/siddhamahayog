<form action="{{route('admin.admin_zoom_account_store')}}" class="ajax-append ajax-form" method="post">
    <div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Add New Zoom Account</h4>
        <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>

    </div>
    <div class="modal-body">
        <div class="row clearfix mt-3">
            <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                <div class="form-group">
                    <label for="account_name">Name
                        <sup class='text-danger'>*</sup>
                    </label>
                    <input type="text" class="form-control" name="name" id="account_name" required />

                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                <div class="form-group">
                    <label for="account_name">Account Status
                        <sup class='text-danger'>*</sup>
                    </label>
                    <select name="status" id="account_status" class='form-control' required>
                        <option value="active" selected>Active</option>
                        <option value="suspend">Suspend</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row clearfix mt-3">
            <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                <div class="form-group">
                    <label for="account_username">
                        Zoom Registered Email
                        <sup class="text-danger">
                            *
                        </sup>
                    </label>
                    <input type="email"  name="username" id="" class="input-group form-control">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 m-b-20">
                <div class="form-group">
                    <label for="category">
                        Account Access Category
                        <sup class="text-danger">
                            *
                        </sup>
                    </label>
                    <select name="category" id="category" class="form-control">
                        @foreach (\App\Models\ZoomAccount::ACCESS_TYPES as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row clearfix mt-3">
            <div class="col-lg-12 col-md-12 col-sm-12 m-b-20">
                <div class="form-group">
                    <label for="api_token">
                        Developer API TOKEN
                        <sup class="text-danger">*</sup>
                    </label>
                    <textarea name="api_token" placeholder="paste your token here" id="api_token" cols="30" rows="6" class='form-control'></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <div class="row">
            <div class="col-md-12 text-end">
                <button type="submit" class="btn btn-primary">
                    Add Zoom Account
                </button>
            </div>
        </div>
    </div>
</div>
</form>
