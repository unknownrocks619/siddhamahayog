@extends("layouts.admin")

@section("page_css")
<link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
@endsection

@section("content")
<!-- Complex headers table -->
<section id="headers">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="payment_list">
                        <thead>
                            <th>S.No</th>
                            <th>Full Name</th>
                            <th>Phone Number</th>
                            <th>Amouht</th>
                            <th>Transaction Source</th>
                            <th>Image Preview</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>  
</section>
<!--/ Complex headers table -->
@endsection


@section("footer_js")

<script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready( function () {
        $('#payment_list').DataTable({
            processing : true,
            serverSide : true,
            ajax: "{{ url()->full() }}",
            columns : [
                {data : 'id', name:'id'},
                {data: 'full_name', name:'full_name'},
                {data: 'phone_number',name:'phone_number'},
                {data : 'amount', name: 'amount'},
                {data : 'transaction_bank', name: 'transaction_bank'},
                {data : 'image_preview', name: 'image_preview'},
                {data : 'action', name: 'action'}
            ],
            buttons: ['copy', 'excel', 'pdf']
        });
    });
</script>
@endsection