@extends("layouts.portal.app")

@section("content")
<section class="content">
    <div class="container-fluid">

        <div class="block-header">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <h2>Program `{{$program->program_name}}` -- <span class="text-danger">Exam Center</span></h2>
                </div>
            </div>
        </div>

        <div class="row my-2">
            <div class="col-md-12">
                <a href="{{route('admin.exam.list', $program->getKey())}}" class="btn btn-warning">Close</a>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-md-7" id='questionForm'>
                @include('admin.programs.exams.question.edit')
            </div>

            <div class="col-md-5">
                <div class="card">
                    <div class="header">
                        <h2>
                            {{ $exam->title }}
                        </h2>
                    </div>
                    <div class="body js-question-lister" style="max-height:800px;overflow:scroll;">
                        @include("admin.programs.exams.question.lister", compact('exam','program'))
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section("page_script")
<script src="{{ asset ('assets/bundles/mainscripts.bundle.js') }}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/summernote/dist/summernote.js') }}"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript" src='{{ asset('assets/js/question.js') }}'></script>
<script>
    $(document).ready(function() {
        $('.richtext').summernote({
            height: 275,
            popover: {
                image: [],
                link: [],
                air: []
            }
        })
    });
</script>
@endsection

@section("page_css")
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-select/css/bootstrap-select.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/summernote/dist/summernote.css') }}">
@endsection
