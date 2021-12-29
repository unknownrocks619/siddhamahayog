
<div id="msgDisplay">

</div>
<table width="100%" border='1'>
    <tr>
        <td>
            <div id="screen_preview">Please Wait...loading your camera.</div>
        </td>
        <td>
            <div class='card card-body' id="img_preview">Your snapshot will be displayed here.</div>
            <div class="col-md-12" id="display_col" style="display:none">
                <br />
                <button type="button" id="save_image_button" class="btn btn-success text-white">Confirm Snap</button>
            </div>

        </td>

    </tr>
</table>
<br />
<button type="button" onClick="take_snapshot()" class="btn btn-primary">Take A Snap</button> &nbsp;&nbsp;
<button type="button" class="btn btn-primary" onClick="window.close()">Close</button>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>

<script src="{{ asset('js/webcam.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function(){
        configure();
    });

    function configure(){
			Webcam.set({
				width: 320,
				height: 240,
				image_format: 'jpeg',
				jpeg_quality: 150
			});
            Webcam.attach( '#screen_preview' );
            // $("#saveImage").fadeOut('fast',function(){
            //     $(this).attr('disabled',true);
            // })
        }
    // A button for taking snaps
    function take_snapshot() {
            // play sound effect
            // shutter.play();

            // take snapshot and get image data
            Webcam.snap( function(data_uri) {
                // display results in page
                document.getElementById('img_preview').innerHTML = 
                    '<img style="width:320px;height:240px" id="imageprev" src="'+data_uri+'" class=" img-thumbnail" />';
                    var image = window.opener.document.getElementById('parent_image_id');
                    // var image = document.getElementById('parent_image_id');
                        image.src = data_uri;
                
            } );
            $("#display_col").fadeIn('fast');
            // Webcam.reset();
    }
    $("#save_image_button").click(function(){
            var base64Image = document.getElementById("imageprev").src;
            // var formData = new FormData();
            // formData.append('')
            Webcam.upload( base64Image, 
                '{{ url("admin/user_webcam_upload") }}?user_id={{ encrypt($user_detail->id) }}',
                 "{{ csrf_token() }}",
                 function(code, text) {
                    var response = JSON.parse(text);
                    
                    if(response.error === false)
                    {
                        $("#msgDisplay").fadeIn('medium',function(){
                         // let's setup this 
                         $(this).attr('class','alert alert-success');
                         $(this).html(response.message);
 
                     })
                    }
                })
            });
        

</script>
