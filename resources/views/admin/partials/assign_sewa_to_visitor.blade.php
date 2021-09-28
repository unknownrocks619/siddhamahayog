<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<form method="POST" action="{{ route('services.sewas.assign-visitor-to-sewa',['user_id'=>$user_detail->id,'booking_id'=>$record->id]) }}">
    @csrf
    <input type="hidden" name="check_out_visitor" value="true" />
    <div class='modal-body'>
        <div class='row'>
            <div class='col-12'>
                <div id='error'></div>
            </div>
        </div>
        <div class='row'>
            <div class="col-md-5">
                <h5>Assign Visitor with Sewa</h5>
                
                <p>
                    <!-- Get List of users signed Sewas -->
                    Interested In Sewa : <br />
                    @php
                        $signed_sewas = $user_detail->user_sewa;
                        if ($user_detail->user_sewa){
                            foreach ($signed_sewas as $signed_sewa) {
                                echo "<span class='text-white badge badge-primary'>";
                                    echo $signed_sewa->usersewa->sewa_name;
                                echo "</span>";
                                echo "&nbsp;";
                            }
                        }
                    @endphp
                </p>
                <p>
                    Involved In Sewa : <br />
                    @php
                        $involvement_sewas = $user_detail->user_assigned_sewa;
                        if ($involvement_sewas){
                            foreach ($involvement_sewas as $signed_sewa) {
                                    echo "<span class='text-white badge badge-success' style=\"background:green\">";
                                        echo $signed_sewa->usersewa->sewa_name;
                                    echo "</span>";
                                    echo "&nbsp;";
                            }
                        }
                    @endphp
                </p>

            </div>
            <div class='col-md-7'>
                <div class='form-group'>
                    <label class='label-control'>Select Sewa</label>
                    <select multiple name='sewas[]' class='form-control sewas'>
                        @php
                            $sewas = new App\Models\UserSewa;
                            foreach ($sewas::get() as $sewa) {
                                echo "<option value='{$sewa->id}'>";
                                    echo $sewa->sewa_name;
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
                <button type='submit' class='btn btn-danger'>Assign User For Sewa</button>
            </div>
        </div>
    </div>
</form>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $("form").submit(function(event) {
        event.preventDefault();
        $.ajax({
            type : "POST",
            data : $(this).serialize(),
            url : $(this).attr('action'),
            success : function (response) {
                if (response.success === true){
                    $("#error").attr('class','alert alert-success mb-1').text(response.message);
                    $('#booking_modal').on('hidden.bs.modal', function () {
                        $("#booking_table").text('Please wait applying while we are applying changes....');
                        $("#booking_table").load("{{ route('bookings.booking-list') }} #booking_table");

                    });
                } else {
                    $("#error").attr('class','alert alert-danger mb-1').text(response.message);
                }
            }
        })
    })

    $(document).ready(function() {
        $(".sewas").select2({
        });
    });
</script>