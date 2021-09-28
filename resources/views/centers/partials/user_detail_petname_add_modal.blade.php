<form method="POST" action="{{ route('users.update_pet_name',['user_id'=>$user_detail->id]) }}">
@csrf
    <div class='modal-body'>
        <div class='row'>
            <div class='col-12'>
                <div id='error'></div>
            </div>
        </div>
        <div class='row'>
            <div class="col-md-12">
                <div class='form-group'>
                    <label class='control-label'>Full Name
                        <span class='text-danger required'>*</span>
                    </label>
                    <input type='text' name='name' readonly class='form-control' required='true' value="{{ $user_detail->full_name() }}" />
                </div>
                <div class='form-group'>
                    <label class='control-label'>Pet Name</label>
                    <input type="text" name="pet_name" class='form-control' value="{{ $user_detail->pet_name ?? '' }}" />
                </div>
            </div>
        </div>
    </div>
    <div class='modal-footer'>
        <div class='row'>
            <div class='col-12'>
                <button type='submit' class='btn btn-primary'>Update Detail</button>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    $("form").submit(function(event) {
        event.preventDefault();
        $.ajax({
            type : "POST",
            data : $(this).serialize(),
            url : $(this).attr('action'),
            success : function (response){
                // var res = JSON.parse(response);
                if (response.success === true){
                    $("#error").attr('class','alert alert-success mb-1').text(response.message);
                    $('#display_modal').on('hidden.bs.modal', function () {
                        $("#pet_name_container").text('applying Changes...');
                        $("#pet_name_container").load("{{ route('users.view-user-detail',$user_detail->id) }} #pet_name_container");

                    });
                } else {
                    $("#error").attr('class','alert alert-danger mb-1').text(response.message);
                }
            }
        })
    })
</script>