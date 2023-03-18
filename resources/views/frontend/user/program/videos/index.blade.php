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
            <div class="col-4 text-end">
                <button data-href="{{ route('user.account.programs.program.index') }}"
                    class="clickable btn btn-danger text-right " type="button" id="orederStatistics">
                    <i class="bx bx-block"></i>
                    Close
                </button>
            </div>
        </div>

        <!-- Folder View -->
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row couser-lister">
                            @forelse ($program->videoCourses as $courses)
                                <div class="col-md-6 mb-5 pb-2 lister-name" data-slug="{{ $courses->slug }}"
                                    data-name="{{ $courses->course_name }}" data-item="{{ $courses->getKey() }}">
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <img src="{{ asset('folder.png') }}" class="img-fluid w-50" />
                                        </div>
                                        <div class="col-md-12 text-center fs-5">
                                            <a href="" class="course-selection">{{ $courses->course_name }}</a>
                                        </div>
                                    </div>
                                </div>

                            @empty
                                <div class="col-md-12">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 video-content" id='videoContent'>

            </div>
        </div>


    </div>
    <!-- /Content -->
@endsection

@push('custom_script')
    <script type="text/javascript">
        class CourseList {
            _courses = [];

            function setCourses(course_key, course_name, course_index, lessions = []) {
                let courses = {
                    course_key: course_name,
                    lessions: lessions
                }

                if (this._courses[course_index] === undefined) {
                    this._courses.push(course_index);
                }
                this._courses[course_index] = courses;
            }


            function getCourses(index) {
                if (this._courses[index] !== undefined) {
                    return this._courses[index];
                }
                return;
            }

            function getLessions(courseIndex, lessionIndex = null) {
                if (this._courses[index] !== undefined) {
                    let lession = this._courses.lessions;

                    if (lessionIndex != null) {
                        return lession[lessionIndex];
                    }
                    return lession;
                }
            }

            function saveLessions(courseIndex, lession = []) {

            }
        }

        window.courses = new CourseList;

        $(document).ready(function() {
            $.each($('.lister-item'), function(index, element) {
                let params = {
                    "course_key": $(element).data('slug'),
                    'course_name': $(element).data('name'),
                    'course_index': $(element).data('item')
                }
                window.courses.push(params.course_key, params.course_name);
            })
        })

        $(document).on('click', '.course-selection', function(event) {
            event.preventDefault();
            let _this = this;
            let parentDiv = $(_this).closest('div.lister-item');
            let params = {
                "course_key": $(parentDiv).data('slug'),
                'course_name': $(parentDiv).data('name'),
                'course_index': $(parentDiv).data('item')
            }
            let currentCourses = courses.getCourses(params.course_index);
            console.log(currentCourses);
        })

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
