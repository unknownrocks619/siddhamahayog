<form method="POST" action="{{ isset($sewa) ? route('services.sewas.update-sewa-service') : route('services.sewas.submit-new-form') }}">
    @csrf
    @if(isset($sewa))
        <input type="hidden" name='__app_id' value="{{ encrypt($sewa->id) }}" style='display:none' />
    @endif
    <div class='modal-body'>
        <div class='row'>
            <div class='col-12'>
                <div id='error'></div>
            </div>
        </div>
        <div class='row'>
            <div class="col-md-12">
                <div class='form-group'>
                    <label class='control-label'>Sewa Type / Name
                        <span class='text-danger required'>*</span>
                    </label>
                    <input type='text' name='sewa_name' class='form-control' required='true' value=" {{ isset($sewa) ? $sewa->sewa_name : '' }}" />
                </div>
                <div class='form-group'>
                    <label class='control-label'>Sewa Description</label>
                    <textarea class='form-control' name='description'>{{ isset($sewa) ? $sewa->description : "" }}</textarea>
                </div>
            </div>
        </div>
    </div>
    <div class='modal-footer'>
        <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
            <i class="bx bx-x d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Close</span>
        </button>
        <button type="submit" class="btn btn-primary ml-1">
            <i class="bx bx-check d-block d-sm-none"></i>
            @if(isset($sewa))
                <span class="d-none d-sm-block">Update</span>
            @else
            <span class="d-none d-sm-block">Save</span>
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
                } else {
                    $("#error").attr('class','alert alert-danger mb-1').text(response.message);
                }
            },
            error : function (err) {

            }
        })
    })
</script>