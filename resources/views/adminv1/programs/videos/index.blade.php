@extends("layouts.portal.app")

@section("content")
<section class="content file_manager">    
    <div class="container">
        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>File Manager::{{ $program->program_name }}</h2>                    
                </div>            
                <x-admin-breadcrumb>
                    <li class="breadcrumb-item"><a href=''>File Manager</a></li>
                    <li class="breadcrumb-item active">{{ $program->program_name }} </li>
                </x-admin-breadcrumb>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <ul class="nav nav-tabs padding-0">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Doc">Doc</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Media">Media</a></li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="Doc">
                        <p class="text-info">Loading...Please wait.</p>
                    </div>
                    <div class="tab-pane" id="Media">
                        <p class="text-info">Loading...Please wait.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section("page_script")
<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            type : "GET",
            url: "{{ route('admin.videos.admin_list_videos_filemanager',[$program->id]) }}",
            success: function (response){
                $("#Media").html(response);
            }
        });

        $.ajax({
            type : "GET",
            url : "{{ route('admin.resources.doc.admin_doc_by_program',[$program->id]) }}",
            success : function (response) {
                $("#Doc").html(response);
            }
        })
    });
</script>
@endsection