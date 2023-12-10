<div class="modal-header border-bottom border-1">
    <h4>
        Your Daily Yagya Count
    </h4>
</div>
<form action="{{route('frontend.jaap.counter-daily')}}" method="post" class="jaap-counter-form">
    @csrf
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mt-2">
                <div class="form-group">
                    <label for="jap_type">Select Date</label>
                    <input type="date" value="{{date('Y-m-d')}}" name="date" id="date" class="form-control">
                </div>
            </div>

            <div class="col-md-6 mt-2">
                    <label for="total_count">
                        Total Mantra Chat Today
                        <sup class="text-danger">*</sup>
                    </label>
                    <input type="number" name="total_count" id="total_count" class="form-control" />
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-between">
                <a href="" data-bs-dismiss="modal" class="text-danger">Cancel</a>
                <button onclick="saveJaapCount(this)" data-bs-dismiss="modal" class="btn btn-primary">Save My Jaap</button>
            </div>
        </div>
    </div>
</form>

<script>
    $('.jaap-counter-form').submit(function(event) {
        event.preventDefault();
    })

    function saveJaapCount() {
        $('form.jaap-counter-form').attr('disabled',true);

        $.ajax({
            method : "POST",
            url : $('form.jaap-counter-form').attr('action'),
            data : $('form.jaap-counter-form').serializeArray(),
            success: function (response) {
                $('form.jaap-counter-form').attr('disabled',true);
            }
        })
    }
</script>
