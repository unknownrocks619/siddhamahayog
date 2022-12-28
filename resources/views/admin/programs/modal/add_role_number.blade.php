<form method="post" action="">
    @csrf
    <div class="modal-header">
        <h4 class="title" id="largeModalLabel">Add Batch</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <b>
                        Student Name
                        <sup class='text-danger'>*</sup>
                    </b>
                    <div class='form-control readonly'>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <b>
                        Roll Number
                        <sup class='text-danger'>*</sup>
                    </b>
                    <input type="text" name="" id="roll_number" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-default btn-round waves-effect">Add Batch</button>
        <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
    </div>
</form>