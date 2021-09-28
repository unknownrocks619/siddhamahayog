@extends("layouts.admin")

@section("content")
<!-- Complex headers table -->
<section id="headers">
    <div class="row">
        <div class="col-8">
        </div>
        <div class='col-4'>
            <form>
                <div class='card'>
                    <div class='card-header'>
                        <h4 class='card-title'>Verify Payment</h4>
                    </div>
                    <div class='card-body'>
                        <div class='form-row'>
                            <div class='col-md-12'>
                                <label class='label-control'>Payment Status</label>
                                <select class='form-control'>
                                    <option value="approve" @if(request()->status == "approve") selected @endif>Approve</option>
                                    <option value="reject" @if(request()->status != "approve") selected @endif>Reject</option>
                                </select>
                            </div>
                        </div>            
                    </div>
                    <div class='card-footer'>
                        <button type="submit" class='btn btn-primary'></button>
                    </div>
                </div>
            </form>
        </div>
    </div>  
</section>
<!--/ Complex headers table -->
@endsection

@section("footer_js")
@endsection