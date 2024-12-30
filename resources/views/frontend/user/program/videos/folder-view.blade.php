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
            <div class="col-md-4" style="max-height:95vh; overflow:hidden;overflow-y:scroll">


                <!-- Mobile View -->
                <div class="col-md-4 mb-2 bg-footer-theme d-sm-none">
                    <div class="row">
                        <div class="accordion mt-3" id="course_list_accordian">
                            <div class="card accordion-item">
                                <h2 class="accordion-header">
                                    <button type="button" class="accordion-button border-bottom bg-secondary text-white"
                                        data-bs-toggle="collapse" data-bs-target="#courses_list" aria-expanded="true"
                                        aria-controls="accordionTwo">
                                        Select Courses
                                    </button>
                                </h2>
                                <div id="courses_list" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                    data-bs-parent="#course_list_accordian">
                                    <div class="accordion-body">
                                        @forelse ($program->videoCourses()->orderBy('sort','asc')->get() as $courses)
                                            <div class="col-md-6 mb-5 pb-2 lister-name mobile-view"
                                                data-slug="{{ $courses->slug }}" data-name="{{ $courses->course_name }}"
                                                data-item="{{ $courses->getKey() }}"
                                                data-action="{{ route('user.account.programs.videos.video-lession', [$courses->getKey()]) }}">
                                                <div class="row">
                                                    <a href="" class="course-selection">
                                                        <div class="col-md-12 text-center">
                                                            <img src="{{ asset('folder.png') }}" class="img-fluid w-50" />
                                                        </div>
                                                        <div class="col-md-12 text-center fs-5">
                                                            {{ $courses->course_name }}
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>

                                        @empty
                                            <div class="col-md-12">

                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if (!$program->videoCourses->count())
                                <div class="card accordion-item active">
                                    <h2 class="accordion-header bg-primary">
                                        <button type="button" class="accordion-button bg-primary" data-bs-toggle="collapse"
                                            data-bs-target="#accordionTwo" aria-expanded="true"
                                            aria-controls="accordionTwo">
                                            {{ $program->program_name }}
                                        </button>
                                    </h2>
                                    <div id="accordionTwo" class="accordion-collapse collapse show"
                                        aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="alert alert-info">
                                                Videos for {{ $program->program_name }} is currently
                                                unavailable.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>



                <!-- Desktop View -->
                <div class="card d-none d-md-block md-lg-block d-xl-block">
                    <div class="card-body">
                        <div class="row course-lister">
                            @forelse ($program->videoCourses()->orderBy('sort','asc')->get() as $courses)
                                <div class="col-md-6 mb-5 pb-2 lister-name" data-slug="{{ $courses->slug }}"
                                    data-name="{{ $courses->course_name }}" data-item="{{ $courses->getKey() }}"
                                    data-action="{{ route('user.account.programs.videos.video-lession', [$courses->getKey()]) }}">
                                    <div class="row">
                                        <a href="" class="course-selection">
                                            <div class="col-md-12 text-center">
                                                <img src="{{ asset('folder.png') }}" class="img-fluid w-50" />
                                            </div>
                                            <div class="col-md-12 text-center fs-5">
                                                {{ $courses->course_name }}
                                            </div>
                                        </a>
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

            <div class="col-md-8 video-content" id='videoContent' style="max-height:90vh;overflow:hidden;overflow-y:scroll">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!-- /Content -->

    <x-modal modal='videoModal'></x-modal>
@endsection

@push('custom_script')
    <script src="{{ asset('assets/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <script type="text/javascript">
        class CourseList {
            _courses = [];
            _html = '';
            setCourses(course_key, course_name, course_index, lessions = []) {
                let courses = {
                    course_key: course_name,
                    lessions: lessions
                }

                if (this._courses[course_index] === undefined) {
                    this._courses.push(course_index);
                }
                this._courses[course_index] = courses;
            }


            getCourses(index) {
                if (this._courses[index] !== undefined) {
                    return this._courses[index];
                }
                return;
            }

            getLessions(courseIndex, lessionIndex = null) {
                if (this._courses[courseIndex] !== undefined) {
                    let courses = this._courses[courseIndex];
                    let lession = courses.lessions;
                    if (lessionIndex != null && lessionIndex !== undefined) {
                        return lession[lessionIndex];
                    }
                    return lession;
                }
            }

            saveLessions(courseIndex, lession = []) {
                if (this._courses[courseIndex] !== undefined) {
                    this._courses[courseIndex].lessions = lession;
                }
            }

            buildAllLession(courseIndex) {
                let _content = "";
                let _lessions = this.getLessions(courseIndex);
                if (_lessions.length) {
                    _lessions.forEach((element, index) => {
                        _content += `<div class='col-md-6  mb-2 pb-3 lession-lister' data-course='${courseIndex}' data-lession="${element.id}">
                        <div class='row  border-end border-secondary  m-1 p-1' >`
                        if (element.video_lock == true) {
                            // _content += `
                        //     <div style='background:url("/video-locked.png");background-position:top;background-size:contain;background-repeat:no-repeat' class='col-md-3 text-center d-flex justify-content-center aling-item-center'>
                        //     </div>
                        // `
                        } else {
                            // _content += `
                        //     <div style='background:url("/video-icon.png");background-position:top;background-size:contain;background-repeat:no-repeat' class='col-md-3 text-center  d-flex justify-content-center aling-item-center'>
                        //     </div>
                        // `
                        }
                        _content += `<div class='col-md-12'>
                                <div class='row'>
                                    <div class='col-md-12'>
                                        <h5 class='text-primary'>
                                            ${element.lession_name}
                                            </h5>
                                    </div>`
                        if (element.video_description != null) {
                            _content += `<div class='col-md-12 description text-dark'>
                                    ${element.video_description}
                                    </div>`
                        }
                        _content += `<div class='col-md-12 mt-1'>

                                        <span class='badge bg-dark mt-1'>
                                            Time:
                                            ${element.total_duration}
                                        </span>
                                        <span class='badge bg-dark'>
                                            Date:
                                            ${element.lession_date}
                                        </span>`
                        if (element.video_lock == true) {
                            _content += `<span class='badge bg-danger ms-1'>
                                        <i class='bx bx-lock-open'></i>
                                        Locked
                                    </span>`
                        }
                        _content += `</div>
                                </div>
                            </div>
                    `
                        if (element.video_lock == false) {
                            _content += `<div class='row'><div class='col-md-12 mt-3'>
                            <button type='button' class='w-100 btn btn-primary btn-sm watch-lession'>Play Video</button>
                            </div></div>`
                        }
                        _content += "</div>"
                        _content += "</div>";
                    });
                } else {
                    _content +=
                        `
                            <div class='col-md-12 text-center'>
                                <h4 class='text-primary'>
                                    Lession Not Available.
                                </h4>
                                <img src="/3952613.jpg" class="img-fluid w-50 text-center" />
                            </div>`;
                }
                this._html = `<div class='card'><div class='card-body'>
                    <div class='row d-flex justify-content-between'>
                        ${_content}
                    </div>
                </div></div>`

            }

            render() {
                return this._html;
            }

        }

        window.progarm = "{{ $program->getKey() }}"
        window.currentCourseIndex = 0;
        window.courses = new CourseList;

        $(document).ready(function() {
            $.each($('.lister-name'), function(index, element) {
                let params = {
                    "course_key": $(element).data('slug'),
                    'course_name': $(element).data('name'),
                    'course_index': $(element).data('item')
                }
                window.courses.setCourses(params.course_key, params.course_name, params.course_index);
            })
        })

        $(document).on('click', '.course-selection', function(event) {
            event.preventDefault();
            let _this = this;

            if ($(_this).hasClass('course-selected')) {
                return;
            }
            let parentDiv = $(_this).closest('div.lister-name');
            if ($(parentDiv).hasClass('mobile-view')) {
                let accordian_parent = $(_this).closest('div.accordion-collapse');
                $(accordian_parent).removeClass('show');
            }
            let params = {
                "course_key": $(parentDiv).data('slug'),
                'course_name': $(parentDiv).data('name'),
                'course_index': $(parentDiv).data('item'),
                'action_route': $(parentDiv).data('action')
            }
            $('.course-selected').removeClass('course-selected text-muted');
            $(_this).addClass('course-selected text-muted')
            window.currentCourseIndex = params.course_index;
            let currentCourses = courses.getCourses(params.course_index);
            let lessions = currentCourses.lessions;
            $('#videoContent').empty().html(
                '<div class="card"><div class="card-body text-center"><h4 class="text-center">Please wait...</h4></div></div>'
            );
            if (!lessions.length) {
                sendXMLHTTPRequest(params.action_route, 'GET', {}, 'courseLessionBinder', params);
            } else {
                courses.buildAllLession(params.course_index);
                $('#videoContent').empty().html(courses.render());

            }

        })

        $(document).on('click', '.watch-lession', function(event) {
            event.preventDefault();
            let _parent = $(this).closest('div.lession-lister');
            let url = '/account/programs/videos/list/' + window.progarm + '/' + window.currentCourseIndex + '/' + $(
                _parent).data('lession');
            $(_parent).find('button').prop('disabled', true).html('Please wait...');

            sendXMLHTTPRequest(url, 'POST', {}, 'popModalWithHTML');

            setTimeout(() => {
                $(_parent).find('button').prop('disabled', false).html('Play Video');
            }, 3000);
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

        const sendXMLHTTPRequest = function(requestEndPoint, requestMethod, params = {}, successCallback = null,
            callbackParams = {}) {
            $.ajax({
                method: requestMethod,
                url: requestEndPoint,
                data: params,
                headers: {
                    'X-CSRF-TOKEN': $("meta[name=csrf-token]").attr('content')
                },
                success: function(response) {

                    if (successCallback !== null) {
                        window[successCallback](response, callbackParams);
                    }
                }
            })
        }


        window.courseLessionBinder = function(response, params) {
            courses.saveLessions(params.course_index, response);
            courses.buildAllLession(params.course_index);
            $("#videoContent").empty().html(courses.render());
        }


        $(document).on('click', '.btn-close', function(event) {
            let _modal = $(this).closest('div.modal');
            if ($(_modal).find('iframe').length) {
                $(_modal).find('div.modal-body').remove();
                $(_modal).find('script').remove();
            }
        })
    </script>
@endpush
