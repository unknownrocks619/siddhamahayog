@extends('frontend.theme.portal')

@section('content')
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- BreadCrumb -->
        <div class="row">
            <div class="col-8">
                <h4 class="fw-bold py-3 mb-4">
                    <span class="text-muted fw-light">Program /</span>
                    <span class="text-muted fw-light"><a
                            href="{{ route('user.account.programs.program.index') }}">{{ $program->program_name }}</a>
                        /</span>
                    Offline Videos
                </h4>
            </div>
        </div>

        <!-- Folder View -->
        @include('frontend.user.program.videos.content.list-view')


    </div>
    <!-- /Content -->
@endsection

@push('custom_script')
    <script type="text/javascript">
        $(document).ajaxStart(function() {
            $('.progress').fadeIn('fast', function() {
                $(this).removeClass('d-none');
            });

        }).ajaxStop(function() {
            $(".progress").fadeOut('medium', function() {
                $(this).addClass("d-none");
            })
        });

        $(".watchLession").click(function(event) {
            event.preventDefault();
            $("ul.lms-list li").removeClass("text-success")
            $(this).addClass('text-success');
            $.ajax({
                type: "get",
                url: $(this).data("href"),
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
                },
                success: function(response) {
                    $("#videoContent").html(response);
                }
            })
        })
    </script>
@endpush
