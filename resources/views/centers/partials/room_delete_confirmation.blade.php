<form method="POST" action="{{ route('rooms.delete-room',$record->id) }}">
@method('DELETE')
@csrf
    <div class='modal-body'>
        <div class='row'>
            <div class='col-12'>
                <div id='error'></div>
            </div>
        </div>
        <div class='row'>
            <div class="col-md-12">
               You are about to delete, Room Number : <strong>{{ $record->room_number }} </strong> Block: <strong> {{ $record->room_name }} Room</strong>
            </div>
            <div class='col-md-12 mt-2 bg-secondary px-2  py-2'>
                <h4 class='text-danger'>Wait !!</h4>
                <p class='text-white'>
                    @php
                        $count_usages = $record->occupied_room->count();
                        if ($count_usages ) {
                            echo "This Room is currently occupied by " . $count_usages . ' number of People';
                        }
                    @endphp
                </p>
                <p class='text-white'>
                        If you wish to confirm delete all records. Press Confirm Delete now Button
                </p>
            </div>
        </div>
    </div>
    <div class='modal-footer'>
        <div class='row'>
            <div class='col-12'>
                @if ($count_usages )
                    <button type='button' class='btn disabled'>Delete</button>
                @else
                    <button type='submit' class='btn btn-danger'>Confirm Delete</button>
                @endif
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    $("form").submit(function(event) {
        event.preventDefault();
        $.ajax({
            type : "DELETE",
            data : $(this).serialize(),
            url : $(this).attr('action'),
            success : function (response){
                // var res = JSON.parse(response);
                if (response.success === true){
                    $("#error").attr('class','alert alert-success mb-1').text(response.message);
                    $('#delete').on('hidden.bs.modal', function () {
                        $("#room_data").text('applying Changes...');
                        $("#room_data").load("{{ route('rooms.room-list') }} #room_data");

                    });
                } else {
                    $("#error").attr('class','alert alert-danger mb-1').text(response.message);
                }
            }
        })
    })
</script>