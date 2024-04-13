<form method="post" class="ajax-form" action="{{route('admin.program.admin_add_member_to_group',['program' => $program,'group' => 1])}}">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Please select group </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
        <div class="row my-4">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="program_name">Search Group To Add <sup class="text-danger">*</sup></label>
                    <select name="groupID" id="" class="form-control no-select-2">
                        @foreach (App\Models\ProgramGrouping::where('program_id',request()->get('program'))->get() as $group)
                            <option value="{{$group->getKey()}}">{{$group->group_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <input type="hidden" name="memberID" value="{{request()->get('memberID')}}" class="memberID">
        <input type="hidden" name="transactionID" value="{{request()->get('transactionID')}}" class="memberID">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-label-primary" data-bs-dismiss="modal">Save Category</button>
    </div>
</form>