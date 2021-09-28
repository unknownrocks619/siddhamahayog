<form method="POST" action="{{ route('users.user_verification.update_verfication',['user_id'=>$user_detail->id]) }}">
    @csrf
    <input type="hidden" name="check_out_visitor" value="true" />
    <div class='modal-body'>
        <div class='row'>
            <div class='col-12'>
                <div id='error'></div>
            </div>
        </div>
        
        <!-- User Verification -->
        <div class='row mt-2'>
            <div class="col-6 col-sm-6">
                <div class="form-group">
                    <label class='control-label'>
                        Document Type
                        <span class='required text-danger'>*</span>
                    </label>
                    <select class="form-control" name='document_type'>
                        <option value="Citizenship" @if(old('document_type') == "Citizenship") selected @endif>Citizenship</option>
                        <option value='Passport' @if(old('document_type') == "Password") selected @endif>Passport</option>
                        <option value='Driving' @if(old('document_type') == "Driving") selected @endif>Driving License</option>
                        <option value='PAN CARD' @if(old('document_type') == "PAN CARD") selected @endif>PAN Card</option>
                        <option value='ID' @if(old('document_type') == "ID") selected @endif>ID Card</option>
                        <option value='Other' @if(old('document_type') == "Other") selected @endif>Other</option>

                    </select>
                </div>
            </div>

            <div class="col-6 col-sm-6">
            <fieldset class="form-group">
                <label for="basicInputFile">With Browse button</label>
                <div class="custom-file">
                  <input type="file" name="document_file" class="custom-file-input" id="inputGroupFile01">
                  <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>
              </fieldset>
            </div>
        </div>

        <div class='row mt-2'>
            <div class="col-6 col-sm-6">
                <div class="form-group">
                    <label class='control-label'>
                        Gaurdian / Parent Name
                    </label>
                    <input type='text' name='gaurdian_name' value="{{ old('gaurdian_name') }}" class='form-control' />
                </div>
            </div>

            <div class="col-6 col-sm-6">
                <div class="form-group">
                    <label class='control-label'>
                        Gaurdian / Parent Phone Number
                    </label>
                    <input type='text' name='gaurdian_phone' value="{{ old('gaurdian_phone') }}" class='form-control' />
                    
                </div>
            </div>
        </div>
        <h5 class='text-center'>OR</h5>
        <div class='row mt-2'>
            <div class='col-12'>
                <div class='form-group'>
                    <label class='control-label'>
                        Search Gaurdian In Our Database
                    </label>
                    <input type='text' value="{{ old('gaurdian_search') }}" placeholder="Search By Name, Email or Phone Number" name='gaurdian_search' class='form-control' />
                </div>
            </div>
        </div>
        <!-- / User Verification -->
    </div>
    <div class='modal-footer'>
        <div class='row'>
            <div class='col-12'>
                <button type='submit' class='btn btn-primary'>Verify User</button>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
 $(".custom-file-input").change(function (event) {
            $(this).next('.custom-file-label').html(event.target.files[0].name);
        });
    $("form").submit(function(event) {
       
        event.preventDefault();
        $.ajax({
            type : "POST",
            data : new FormData($(this)[0]),
            url : $(this).attr('action'),
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
            success : function (response){
                // var res = JSON.parse(response);
                if (response.success === true){
                    $("#error").attr('class','alert alert-success mb-1').text(response.message);
                    $('#display_modal').on('hidden.bs.modal', function () {
                        $("#user_verification_update").text('applying Changes...');
                        $("#user_verification_update").load("{{ route('users.view-service-detail',[$user_detail->id,'verification']) }} #user_verification_update");

                    });
                } else {
                    $("#error").attr('class','alert alert-danger mb-1').text(response.message);
                }
            }
        })
    })
</script>