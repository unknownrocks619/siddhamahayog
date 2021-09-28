<form method="POST" action="{{ route('bookings.check-out-user',$record->id) }}">
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
                <h5>Visitors Log</h5>
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
            <div class='col-md-7'>
                <div class='form-group'>
                    <label class='label-control'>Check Out Date</label>
                    <input type="date" value="{{ old('check_out_date',date('Y-m-d')) }}" class='form-control' name='check_out_date' />
                </div>
                <div class='form-group'>
                    <label class='label-control'>Check Out Time</label>
                    <input type="text" value="{{ old('check_out_time',date('h:i A')) }}" class='form-control' name='check_out_time' />
                </div>
                <div class='form-group'>
                    <label class='label-control'>Remarks</label>
                    <textarea name='remarks' class='form-control'></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class='modal-footer'>
        <div class='row'>
            <div class='col-12'>
            <div class='form-group'>
                    <label class='label-control'>Donation (Nepalese Rupeese)</label>
                    <input type="text" name='donation' value='0' class='form-control' />
                </div>
                <button type='submit' class='btn btn-danger'>Check Out Visitor</button>
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
</script>