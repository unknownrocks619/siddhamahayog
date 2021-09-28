<form method="POST" action="{{ route('users.add_new_email',['user_id'=>$user_detail->id]) }}">
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
                    <label class='control-label'>Email Address</label>
                    <input required type="text" name="email" class='form-control' value="{{ $user_detail->userlogin->email ?? '' }}" />
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
                        $("#display_email_address").text('applying Changes...');
                        $("#display_email_address").load("{{ route('users.view-user-detail',$user_detail->id) }} #display_email_address");

                    });
                } else {
                    $("#error").attr('class','alert alert-danger mb-1').text(response.message);
                }
            }
        })
    })
</script>