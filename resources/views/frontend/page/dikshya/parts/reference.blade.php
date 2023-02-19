<div class="row">
    <div class="col-md-12 mt-2">
        <h4 class="theme-text">
            Reference Detail
        </h4>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="referer_person">
                    Referer Person
                </label>
                <input value="{{ $user_record['referer_person'] ?? old('referer_person') }}" type="text"
                    name="referer_person" id="referer_person"
                    class="form-control @error('referer_person') border border-danger @enderror">
                @error('referer_person')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="referer_relation">
                    Relation
                </label>
                <input type="text" value="{{ $user_record['referer_relation'] ?? old('referer_relation') }}"
                    name="referer_relation" id="referer_relation"
                    class="form-control @error('referer_relation') border border-danger @enderror">

                @error('referer_relation')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="form-group">
                <label for="referer_contact">Referer Mobile Number</label>
                <input type="text" value="{{ $user_record['referer_contact'] ?? old('referer_contact') }}"
                    name="referer_contact" id="referer_contact"
                    class="form-control @error('referer_contact') border border-danger @enderror">
                @error('referer_contact')
                    <div class="text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>

        </div>
    </div>
</div>
