<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="jap_type">Jaap Type</label>
                <select name="jap_type" id="jap_type" class="form-control">
                    <option value="sumeru">Sumeru</option>
                    <option value="mantra">Mantra</option>
                    <option value="maala">Maala</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <label for="form-group">
                <label for="jap_start_date">Jaap Start Date</label>
                <input type="date" name="jaap_start_date" id="jaap_start_date" class="form-control" />
            </label>
        </div>
    </div>

    <div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="jap_count_for">
                Jaap Count Program For
            </label>
            <select name="jaap_count_program" id="jaap_count_program" class="form-control">
                @foreach (\App\Models\Program::get() as $program)
                    <option {{$loop->last ? 'selected' : ''}} value="{{$program->getKey()}}">{{$program->program_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
</div>
