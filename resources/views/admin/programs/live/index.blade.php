<div class="modal-header">
    <h4>
        Live Seetings
    </h4>
</div>
<div class="modal-body">
    <form action="{{ route('admin.program.store_live',$program->id) }}" method="post">
        @csrf

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Select Zoom Account</label>
                    <?php
                    $accounts = \App\Models\ZoomAccount::where('account_status', 'active')->get();
                    ?>

                    <select name="zoom_account" id="zoom_account" class="form-control">
                        @foreach ($accounts as $account)
                        <option value="{{ $account->id }}">{{ $account->account_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Select Section</label>
                    <select class="form-control" name="section" id="section">
                        <option value="">Select Section </option>
                        @foreach ($program->sections as $section)
                        <option value="{{ $section->id }}"> {{ $section->section_name }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-success">Go Live</button>
            </div>
        </div>
    </form>
</div>