<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<form method="POST" action="{{ route('users.update_marital_stat',['user_id'=>$user_detail->id]) }}">
@csrf
    <div class='modal-body'>
        <div class='row'>
            <div class='col-12'>
                <div id='error' class='alert alert-info'>If You Submit this form, Your status will be changed to Married</div>
            </div>
        </div>
        <div class='row'>
            <div class="col-md-12">
                <div class='form-group'>
                    <label class='control-label'>Married To (Full Name)</label>
                    <input type='text' name='married_to' class='form-control'  value="" />
                </div>
                <div class='divider divider-primary'>
                    <div class='divider-text'>OR</div>
                </div>
                <div class='form-group'>
                    <label class='control-label'>Select Existing User</label>
                    <select name="married_to_existing" id="select_existing" class='form-control'></select>
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
                        $("#marital_status_info").text('applying Changes...');
                        $("#marital_status_info").load("{{ route('users.view-user-detail',$user_detail->id) }} #marital_status_info");

                    });
                } else {
                    $("#error").attr('class','alert alert-danger mb-1').text(response.message);
                }
            }
        })
    })
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#select_existing").select2({
        placeholder: 'Type name or Phone Number',
        ajax : {
                url : '{{ url(route("get_user_list")) }}',
                dataType : 'json',
                processResults : function (data)
                {
                    // params.page = params.page || 1;
                    return {
                        results : data.results
                      
                    };
                }
            }
    });

    })
</script>