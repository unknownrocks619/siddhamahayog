<form action="{{ route('center.admin.member.reference.store',$member->id) }}" method="post">
    @csrf
    <div class="card">
        <div class="card-header">
            <h4>
                Member Reference Detail
            </h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="reference_person_name">
                            Reffered By
                        </label>
                        <input type="text" value="{{ $member->meta && $member->meta->remarks && isset($member->meta->remarks->referer_person) ? $member->meta->remarks->referer_person : '' }}" name="referer_person" id="refered_by" class="form-control" required />
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="form-group">
                        <label for="reference_person_name">
                            Relation With Member
                        </label>
                        <input type="text" value="{{ $member->meta && $member->meta->remarks && isset($member->meta->remarks->referer_relation) ? $member->meta->remarks->referer_relation : '' }}" name="referer_relation" id="refered_by" class="form-control" required />
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="form-group">
                        <label for="reference_person_name">
                            Phone Number
                        </label>
                        <input type="text" value="{{ $member->meta && $member->meta->remarks && isset($member->meta->remarks->referer_contact) ? $member->meta->remarks->referer_contact : '' }}" name="referer_contact" id="refered_by" class="form-control" required />
                    </div>
                </div>


            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                        Save Reference
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>