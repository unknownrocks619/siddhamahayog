@if( $booking)
    <h4 class='text-danger'>Selected Date is not avaiable for booking.</h4>
    <button type="submit" class='btn btn-primary'>Re-Check Avaibility</button>
@else
    <p class='text-success'>Booking Available</p>
    <button name="confirm" type="submit" class='btn btn-primary'>Confirm My Booking</button>
    <script>
        $("form").attr('action',"{{ route('public.room.public_confirm_room_booking') }}")
        $("form :input").prop('readonly',true);
        $("form :button").prop('readonly',false);
        $(function() {
            $.ajaxSetup({
                headers : {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
        });
    </script>
@endif