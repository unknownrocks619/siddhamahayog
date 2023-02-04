<div class="modal-body">
    <form action="{{route('admin.exam.udpate-primary-question',[$program->getKey(),$exam->getKey()])}}" method="post">
        @method("PUT")
        @csrf
        <div class="modal-header">
            <h4>
                Edit ::  {{ $exam->title}}
            </h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="term">Exam Term
                            <sup class="text-danger">*</sup>
                        </label>
                        <input type="text" name="exam_title" id="term" class="form-control" value="{{ $exam->title}}">
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control richtextEditor"></textarea>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" name="start_date" value="{{ $exam->start_date }}" id="start_date" class="form-control" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" name="end_date" id="end_date" value="{{ $exam->end_date }}" class="form-control" />
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="timer">Enable Timer</label>
                        <select name="timer" id="timer" class="form-control show-tick">
                            <option value="1" @if($exam->enable_time) selected @endif>Yes</option>
                            <option value="0"  @if( ! $exam->enable_time) selected @endif>No</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="timer">Active</label>
                        <select name="active" id="timer" class="form-control show-tick">
                            <option value="1" @if($exam->active) selected @endif>Yes</option>
                            <option value="0"  @if( ! $exam->active) selected @endif>No</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Update Question Paper</button>
        </div>
    </form>
</div>

<div class="modal-footer">

</div>

<script>
    $('.richtextEditor').summernote({
            height: 275,
            popover: {
                image: [],
                link: [],
                air: []
            },
        });
    $('.richtextEditor').summernote('code' , '{!! $exam->description !!}')
</script>
