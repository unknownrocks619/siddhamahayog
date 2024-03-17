<div class="col-md-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title">{{$people->full_name}}</h5>
            <div>
                <a href="">Add Family</a>
                <a href="">Update Family</a>
                <a href="">Add Room</a>
            </div>
        </div>
        <div class="card-body">
            <h6 class="text-light">Family Info</h6>
                <div class="list-group">
                    @foreach ($people->families as $family)
                    <label class="list-group-item">
                        <input class="form-check-input me-1" type="checkbox" value="">
                            {{$family->full_name}}
                    </label>
                    @endforeach
                </div>
        </div>
        <div class="card-footer"></div>
    </div>
</div>
