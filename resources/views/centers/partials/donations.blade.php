<form method="POST" action="{{ route('donation',['user_detail'=>$user_detail->id]) }}">
    @csrf
    <div class='modal-body'>
        <div class='row'>
            <div class='col-12'>
                <div id='error'></div>
            </div>
        </div>
        <div class='row'>
            <div class="col-md-12">
                <div class='col-12'>
                    <div class='form-group'>
                        <label class='label-control'>Donation (Nepalese Rupeese)</label>
                        <input type="text" name='donation' value='0' class='form-control' />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='modal-footer'>
        <div class='row'>
            <div class='col-12'>
                <button type='submit' class='btn btn-danger'>Confirm Donation</button>
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