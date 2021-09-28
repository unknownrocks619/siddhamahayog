<form method="POST" action="{{ route('services.sewas.delete') }}">
    @csrf
    @if(isset($sewa))
        <input type="hidden" name='__app_id' value="{{ encrypt($sewa->id) }}" style='display:none' />
    @endif
    <div class='modal-body bg-white'>
        <div class='row'>
            <div class='col-12'>
                <div id='error'></div>
            </div>
        </div>
        <div class='row'>
            <div class="col-md-12">
               You are about to delete, <strong>{{ $sewa->sewa_name }} Sewa</strong>
            </div>
            <div class='col-md-12 mt-2 bg-secondary px-2  py-2'>
                <h4 class='text-danger'>Wait !!</h4>
                <p class='text-white'>
                    Total People Interested : {{ $sewa->usersewabridge->count()}}
                </p>
                <p class='text-white'>
                    Total People who Signed : {{ $sewa->usersewabridge->count()}}
                </p>
            </div>
        </div>
    </div>
    <div class='modal-footer bg-white'>
        <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
            <i class="bx bx-x d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Close</span>
        </button>
        <button type="submit" class="btn btn-danger ml-1">
            <i class="bx bx-check d-block d-sm-none"></i>
            @if(isset($sewa))
                <span class="d-none d-sm-block">Confirm Delete</span>
            @endif
        </button>
    </div>
</form>

<script>
    $("form").submit(function(event){
        event.preventDefault();
        $.ajax({
            method : "POST",
            data : $(this).serialize(),
            url : $(this).attr('action'),
            success : function (response) {

                // var res = JSON.parse(response);
                if (response.success === true){
                    $("#error").attr('class','alert alert-success mb-1').text(response.message);
                    $(function(){

                            $("#sewa_data").text('loading...');
                            $("#sewa_data").load('{{ url("admin/services/sewas/index #sewa_data") }}')
                            // $('#myInput').trigger('focus')
                            // $.ajax({

                            // });
                        $("#delete").modal('toggle');
                    })
                } else {
                    $("#error").attr('class','alert alert-danger mb-1').text(response.message);
                }
            },
            error : function (err) {

            }
        })
    })

</script>