<form action="<?php echo  route('user.account.event.live', [$program->id, $live->id]) ?>" class="confirm-join-session" method="post">
    <div class="modal-header">
        <h5 class="modal-title">Please Choose Section</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="available_live">
                        Select Section
                    </label>
                    <select name="select_section" id="select_section" class="form-control">
                        <?php
                        $livePrograms = $program->allLivePrograms()->with(['sections'])->get();
                        foreach ($livePrograms as $section) {
                            echo "<option value='{$section->sections->getKey()}'>{$section->sections->section_name}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <?php
        if (\App\Models\Role::ACTING_ADMIN == user()->role_id || \App\Models\Role::ADMIN == user()->role_id) :
        ?>
            <div class="row mt-2">
                <div class="col-md-12">
                    <p class="text-info">
                        You are in support group. Please select how would you like to join the session.
                    </p>
                    <div class="form-group">
                        <label for="join_as">
                            Join As
                        </label>
                        <select name="join_as" id="join_as" class="form-control">
                            <option value="1">Host / Co-Host</option>
                            <option value="0">Member</option>
                        </select>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="modal-footer">
</form>
<div class="row">
    <div class="col-md-12 d-flex-justify-content-end">
        <button type="submit" class='btn btn-primary'>
            Join Selected Section
        </button>
    </div>
</div>
</div>