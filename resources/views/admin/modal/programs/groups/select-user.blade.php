<form method="post" class="ajax-form" action="{{route('admin.program.admin_add_member_to_group',['program' => $program,'group' => $group])}}">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Select Member from Enrolled List</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        <div class="row my-4">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="program_name">Search User To Add <sup class="text-danger">*</sup></label>
                    <input data-action="{{route('admin.program.admin_grouping_member_list',['program' => $program,'group' => $group])}}"
                           type="text"
                           placeholder="Search Member by Email or phone"
                           name="member"
                           id="member"
                           class="form-control" />
                </div>
            </div>
        </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" name="full_name" id="full_name" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control">
                        </div>
                    </div>

                </div>

                <div class="row my-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="full_address">Full Address</label>
                            <textarea name="full_address" id="full_address" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" name="email_address" id="email_address" class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 text-end">
                        <button class="btn btn-primary">Save Member Information</button>
                    </div>
                </div>
            </form>
        <div class="row">
            <div class="col-md-12" id="search_result">
                
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
    </div>
</form>

@if ( ! request()->ajax())
    @push('page_script')
    <script type="text/javascript">
        $("#member").keyup(function(event) {
            event.preventDefault();
            let _this = this;
            $.ajax({
                url : $(_this).data("action"),
                data : {member : $(_this).val()},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method : "GET",
                success : function (response) {
                    $("#search_result").html(response);
                },
                error : function (response) {
                    if (response.status == 401)  {
                        // window.location.href = '/login';
                    }
                    // if (resonse.data.stats)
                }
            })
        });
    </script>
            
    @endpush
@endif