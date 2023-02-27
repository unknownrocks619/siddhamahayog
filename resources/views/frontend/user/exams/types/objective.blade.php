<form action="action()" method="post">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="answer">
                    Please type your answer below.
                </label>
                <textarea name="answer" id="answer" class="form-control save-state" data-name='answer' cols="30" rows="10"></textarea>
            </div>
        </div>
    </div>
    <div class="row  d-flext justify-content-end bg-light mt-3 align-items-center">
        <div class="col-md-6 text-right d-flex align-items-center justify-content-end">
            <button type="submit" class="btn btn-link text-danger me-3 draft">
                Save as Draft
            </button>
            <button type="submit" class="btn btn-primary save">
                Submit Answer
            </button>
        </div>
    </div>
</form>
