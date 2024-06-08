<form action="{{route('admin.members.quick-add')}}" class="ajax-form" method="post">
    <div class="modal-header">
        <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body p-2">
    <div class="text-center">

        <h3 class="mb-2">Register New Member</h3>
        <p>Provide data with this form to create your app.</p>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" id="first_name" class="form-control" />
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="middle_name">Middle Name</label>
                <input type="text" name="middle_name" id="middle_name" class="form-control">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" id="last_name" class="form-control">
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" name="phone_number" id="phone_number" class="form-control">
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" />
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <div class="form-group">
                <label for="email">Password</label>
                <input type="text" name="password" id="email" class="form-control" />
            </div>
        </div>

    </div>

    <div class="row border my-3 p4 mt-5">
        <div class="col-md-12 text-center">
            <h3 class="mb-2">
                Select Program to Enroll
            </h3>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="program">Select Program To Enroll</label>
                <select onchange="window.selectElementChange(this,'program')" name="program" id="program" class="form-control">
                    @foreach (\App\Models\Program::get() as $program)
                        <option value="{{$program->getKey()}}">{{$program->program_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @foreach (\App\Models\Program::get() as $program)
            <div class="col-md-12 my-4 mt-3 program {{$program->getKey()}} @if(! $loop->first) d-none @endif">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for='batch'>Select Batch</label>
                            <select name="program_{{$program->getKey()}}_batch" id="" class="form-control">
                                @foreach ($program->batches as $batch)
                                    <option value="{{$batch->batch->getKey()}}">{{$batch->batch->batch_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="">Section</label>
                        <select name="program_{{$program->getKey()}}_section" id="" class="form-control">
                            @foreach ($program->sections as $section)
                                <option value="{{$section->getKey()}}">{{$section->section_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
    <div class="modal-footer">
        <div class="row">
            <div class="col-md-12 text-end">
                <button type="submit" class="btn btn-primary">Save Member</button>
            </div>
        </div>
    </div>
</form>
