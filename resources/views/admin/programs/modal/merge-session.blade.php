<form method="post" action="{{ route('admin.program.live_program.merge.store',[$program->id,$live->id]) }}">
    @csrf
    <div class="modal-header">
        <h4 class="title" id="largeModalLabel">Merge Session {{ $program->program_name }}</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <b>
                        Program Name
                        <sup class='text-danger'>*</sup>
                    </b>
                    <div class='form-control readonly'>
                        {{ $program->program_name }}
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <b>
                        Active Session
                        <sup class='text-danger'>*</sup>
                    </b>
                    <div class="form-control readonly">
                        {{ ($live->programSection) ? $live->programSection->section_name : "OPEN" }}
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <b>
                        Select Section
                        <sup class="text-dagner">*</sup>
                    </b>
                    <?php
                    $sections = $program->sections()->where('id', '!=', ($live->programSection) ? $live->programSection->id : NULL)->get();
                    echo "<select class='form-control' name='merge_with'>";
                    foreach ($sections as $section) {
                        echo "<option value='{$section->id}'>";
                        echo $section->section_name;
                        echo "</option>";
                    }
                    echo "</select>";
                    ?>

                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-default btn-round waves-effect">Merge </button>
        <button type="button" class="btn btn-danger btn-simple btn-round waves-effect" data-dismiss="modal">CLOSE</button>
    </div>
</form>