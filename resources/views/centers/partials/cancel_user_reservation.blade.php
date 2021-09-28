

    <div class='modal-body'>
        <div class='row'>
            <div class='col-12'>
                <div id='error'></div>
            </div>
        </div>
        <div class='row'>
            <div class="col-md-8">
                <h5>Reservation Detail</h5>
                <p>
                    <span>
                        Room Number :
                        @php
                            $room_detail = $record->room;
                            echo $room_detail->room_number;
                        @endphp 
                    </span>
                    <br />
                    <span>
                        Block / Name :
                        {{ $room_detail->room_name }}
                    </span>
                    <br />
                    <span>
                        Reservation For Date : 
                        {{ date("d M, Y D",strtotime($record->check_in_date)) }}
                    </span>
                    <br />
                    <span>
                        Guest Name :
                        @php
                            $user_detail = $record->userdetail;
                            echo $user_detail->full_name();
                        @endphp
                    </span>
                    <br />
                    <span>
                        Guest Phone :
                        {{ $user_detail->phone_number }}
                    </span>
                </p>
            </div>
        </div>
    </div>
    <div class='modal-footer'>
        <div class='row'>
        <div class='col-4 pull-right mx-2'>
        <form method="POST" action="{{ route('bookings.check-out-user',$record->id) }}">
            @csrf
            <input type="hidden" name="cancel_reservation" value="true" />
            <input type="hidden" name="arrival" value="true" />
                <input type="submit"  class='btn btn-primary' name="arived" value="Visitor Arrived" />
        </form>
            </div>
        
            <div class='col-6 pull-left'>
            <form method="POST" action="{{ route('bookings.check-out-user',$record->id) }}">
    @csrf
    <input type="hidden" name="cancel_reservation" value="true" />
                <button type='submit' name="cancel"  class='btn btn-danger'>Cancel Reservation</button>
                </form
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    $("form").submit(function(event) {
        event.preventDefault();
        $.ajax({
            type : "PUT",
            data : $(this).serialize(),
            url : $(this).attr('action'),
            success : function (response) {
                if (response.success === true){
                    $("#error").attr('class','alert alert-success mb-1').text(response.message);
                    
                } else {
                    $("#error").attr('class','alert alert-danger mb-1').text(response.message);
                }
            }
        });
    })
</script>