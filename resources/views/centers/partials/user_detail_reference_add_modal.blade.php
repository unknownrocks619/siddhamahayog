<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<form method="POST" action="{{ route('users.user_reference.update-reference',['user_id'=>$user_detail->id]) }}">
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
                    <label class='control-label'>Refered Person (If By Person)
                    </label>
                    <select class='form-control select2_personal_reference' name='refered_by_person'>

                    </select>
                </div>
                <div class='form-group'>
                    <label class='control-label'>Refered Center (If by Center)</label>
                    <select name="refered_center" class='form-control'>
                        <option>Select Center</option>
                        @php
                            $centers = new App\Models\Center;
                            foreach ($centers::get() as $center){
                                echo "<option value='{$center->id}' >";
                                    echo $center->name;
                                echo "</option>";
                            }
                        @endphp 
                    </select>                
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
    $(document).ready(function(){
        $(".select2_personal_reference").select2({
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