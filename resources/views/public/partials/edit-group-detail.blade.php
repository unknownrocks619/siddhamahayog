@if($record->leader_id != auth()->user()->user_detail_id)
    <div class='modal-header'>
        <h5 class='modal-title'>Permission Error</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class='modal-body bg-danger-light'>
        <p class='modal-text'>You are not authorized to perform this action.</p>
    </div>
@else
    <div class='modal-header'>
        <h5 class='modal-title'>Update `{{$record->member_detail->full_name()}}` Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <form method="post" action="{{ route('public.family.public_update_user_detail',encrypt($record->id)) }}" id="update_member_detail">
        <div class='modal-body'>
            <div class='row'>
                <div class='col-md-12 mb-2'>
                    <div id="error_update"></div>
                </div>
                <div class="col-md-12">
                    <label class='label-control'>Relation</label>
                    <input type="text" class='form-control' value="{{ $record->relation }}" required name='relation' />
                </div>
                <div class="col-md-12 mt-3">
                    <label class='label-control'>Status</label>
                    <select name='status' class='form-control'>
                        <option value="1" @if($record->status) selected @endif>Active</option>
                        <option value="0" @if( ! $record->status) selected @endif>Inactive</option>
                    </select>
                </div>

            </div>
        </div>
        <div class='modal-footer'>
            <div class='row'>
                <div class='col-md-12'>
                    <button type="submit" class="btn btn-primary">Update Detail</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $("#update_member_detail").submit(function(event) {
            event.preventDefault();
            $("#error_update").fadeOut('fast',function(){
                $(this).removeAttr("class");
                $(this).empty();
            })
            $.ajax({
                type : "POST",
                data : $(this).serializeArray(),
                url : $(this).attr("action"),
                headers : {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                success : function ( response ) {
                    if (response.success == true) {
                        $("#error_update").attr('class','alert alert-success')
                    } else {
                        $("#error_update").attr("class",'alert alert-danger')
                    }
                    $('#error_update').fadeIn('medium', function() {
                        $(this).html(response.message);
                    })
                }
            });
        })
    </script>
@endif