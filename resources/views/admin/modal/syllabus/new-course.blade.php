<form class="ajax-form" method="post"
      action="{{ route('admin.program.courses.admin_program_course_add', [$program->id]) }}">
    @csrf
    <div class="modal-header">
        <h4 class="title" id="largeModalLabel">Add New Course</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <b>
                        Course Name / Title
                        <sup class="text-danger">
                            *
                        </sup>
                    </b>
                    <input type="text" name="course_title" required class='form-control'
                           id="course_title" />
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="form-group">
                    <b>
                        Description
                    </b>
                    <textarea class='form-control' name='description' id="description"></textarea>
                </div>
            </div>
            <div class="col-md-12 mt-4">
                <div class="form-group">
                    <b>
                        Lock Course
                    </b>
                    <div class="radio">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="radio" name="lock_course" id="lock_course_yes_modal"
                                       value="yes">
                                <label for="lock_course_yes_modal" class='text-success'>
                                    Yes, Lock Course
                                </label>
                            </div>
                            <div class="col-md-6">
                                <input type="radio" checked name="lock_course"
                                       id="lock_course_no_modal_single" value="no">
                                <label for="lock_course_no_modal_single" class='text-danger'>
                                    No, Don't Lock Course
                                </label>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-4">
                <div class="form-group">
                    <b>
                        Lock Resource
                    </b>
                    <div class="radio">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="radio" name="lock_resources" id="lock_resources_yes_modal"
                                       value="yes">
                                <label for="lock_resources_yes_modal" class='text-success'>
                                    Yes, Lock Resource
                                </label>
                            </div>
                            <div class="col-md-6">
                                <input type="radio" checked name="lock_resources"
                                       id="lock_resources_no_modal" value="no">
                                <label for="lock_resources_no_modal" class='text-danger'>
                                    No, Don't Lock Resource
                                </label>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row mt-5">
            <div class="col-md-12 d-flex justify-content-between">
                <button type="button" class="btn btn-label-danger" data-bs-dismiss="modal">Discard Changes</button>
                <button type="submit" class="btn btn-primary btn-block">Create New
                    Course</button>
            </div>
        </div>
    </div>
</form>
