<div class="card">
    <div class="card-body">
        <table class='table table-bordered table-hover'>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($videos as $video)
                    <tr>
                        <td> {{ $video->video_title }} </td>
                        <td> {{ $video->description }} </td>
                        <td> 
                        <a data-target="#page-modal" data-toggle="modal" href="{{ route('modals.public_modal_display',['modal'=>'youtube_modal','reference'=>'Offline','reference_id'=>encrypt($video->id)]) }}" class="btn btn-sm btn-info">
                            <i class='fas fa-eye-open'></i>
                            Play Video
                        </a>
                    </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>



<script type="text/javascript">
    $('#page-modal').on('shown.bs.modal', function (event) {
			$('body').removeAttr('class');
			$.ajax({
				method : "GET",
				url : event.relatedTarget.href,
				success: function (response){
					$("#modal_content").html(response);
				}
			});
		})
</script>