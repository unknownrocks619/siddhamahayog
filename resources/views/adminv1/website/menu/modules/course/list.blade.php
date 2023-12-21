<div class="modal-content">
    <form action="{{ route('admin.menu.attach_module',$menu->id) }}" method="post">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title">
                {{ $menu->menu_name }} :: Link Modules
            </h5>
        </div>
        <div class="modal-body">
            <input type="hidden" name="type" value="courses">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="category" class="label-control">
                            Select Single Course
                        </label>
                        <select name="link" id="category" class="form-control">
                            <?php
                            $courses = \App\Models\Course::get();
                            foreach ($courses as $course) {
                                echo "<option value='{$course->id}'>{$course->title} - {$course->id}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 mt-4">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Attach Course </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
        </div>
    </form>
</div>