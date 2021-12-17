<div class="modal-header">
    <button type="button" data-dismiss="modal" aria-label="Close" class='btn btn-danger'>Close</button>
</div>
<div class="modal-body">
    <form action="" method="post">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <label for="profession" class="label-control">
                    Select Your Profession
                </label>
                <select type="text" class='form-control'>
                    <option value="engineer">Engineer</option>
                    <option value="teacher">Teacher</option>
                    <option value="professor">Professor</option>
                    <option value="technician">Technician</option>
                    <option value="computer_engineer">Computer Engineer</option>
                    <option value="accountant">Accountant</option>
                    <option value="nurse">Nurse</option>
                    <option value="doctor">Doctor</option>
                    <option value="student">Student</option>
                    <option value="journalist">Journalist</option>
                    <option value="photographer">Photographer</option>
                    <option value="agriculture">Agriculture</option>
                    <option value="literature">Literature</option>
                    <option value="others">Others</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="education_label" class="label-control">Education Level</label>
                <select class='form-control'>
                    <option value="none">None</option>
                    <option value="primary">Primary</option>
                    <option value="secondary">Secondary</option>
                    <option value="higher_secondary">Higher Secondary</option>
                    <option value="bachelors">Bachelors</option>
                    <option value="masters">Masters</option>
                    <option value="phd">PHd</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <label for="skills">Skills</label>
                <textarea class='form-control' name='skills'></textarea>
            </div>
        </div>
    </form>
</div>