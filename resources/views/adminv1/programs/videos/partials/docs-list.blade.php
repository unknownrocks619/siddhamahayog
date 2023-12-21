<div class="row clearfix">
    @foreach ($docs as $doc)
    <?php
    // $resource = $doc->resource;
    ?>
    <div class="col-lg-3 col-md-4 col-sm-12">
        <div class="card">
            <div class="file">
                <a href="javascript:void(0);">
                    <div class="hover">
                        <button onclick="window.location.href='{{ route("admin.resources.admin_edit_course_resource",[$doc->id]) }}'" type="button" class="btn btn-icon btn-icon-mini btn-round btn-primary">
                            <i class="zmdi zmdi-edit"></i>
                        </button>
                        <button onclick="window.location.href='{{ route("admin.resources.admin_delete_resource",['file_id'=>$doc->id,'file_address'=>'program_resources']) }}'" type="button" class="btn btn-icon btn-icon-mini btn-round btn-danger">
                            <i class="zmdi zmdi-delete"></i>
                        </button>
                    </div>
                    <div class="icon">
                        @if($doc->resource_type == "image")
                        <i class="zmdi zmdi-image"></i>
                        @elseif($doc->resource_type == "pdf")
                        <i class="zmdi zmdi-collection-pdf"></i>
                        @else
                        <i class="zmdi zmdi-collection-text"></i>
                        @endif
                    </div>
                    <div class="file-name">
                        <p class="m-b-5 text-muted">{{ $doc->resource_title }}</p>
                        <small>Type: {{ $doc->resource_type }} <span class="date text-muted">Nov 02, 2017</span></small>
                    </div>
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>