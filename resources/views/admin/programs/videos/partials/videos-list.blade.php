<div class="row clearfix">
    @forelse ($videos_by_program as $videos)
        <div class="col-lg-3 col-md-4 col-sm-12">
            <div class="card">
                <div class="file">
                    <a href="javascript:void(0);">
                        <div class="hover">
                            <button onclick="window.location.href='{{ route("admin.videos.admin_edit_video_by_program",[$videos->program_id,$videos->id]) }}'" type="button" class="btn btn-icon btn-icon-mini btn-round btn-danger">
                                <i class="zmdi zmdi-edit"></i>
                            </button>
                            <button onclick="window.location.href='{{ route("admin.resources.admin_delete_resource",['file_id'=>$videos->id,'file_address'=>'program_lession']) }}'" type="button" class="btn btn-icon btn-icon-mini btn-round btn-danger">
                                <i class="zmdi zmdi-delete"></i>
                            </button>
                        </div>
                        <div class="image">
                            <img src="assets/images/image-gallery/1.jpg" alt="img" class="img-fluid">
                        </div>
                        <div class="file-name">
                            <p class="m-b-5 text-muted">{{ $videos->lession_name }}</p>
                            <small>
                                Duration: {{ $videos->total_duration }} 
                                <span class="date text-muted">{{ carbon_date_format($videos->lession_date,"M d, Y") }}</span></small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-md-12 mt-3 bg-brown">
            <h3 class='text-white pt-3'>
                Media File Not Found
            </h3>
        </div>      
    @endforelse
</div>