@extends('layouts.admin.master')
@push('page_title') Program List @endpush
@section('main')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{route('admin.program.admin_program_list')}}">Programs</a>/</span> {{$program->program_name}}
    </h4>
    <div class="container-fluid">
        @if ($program->liveProgram->count())
            <div class="d-flex flex-column flex-md-row justify-content-end align-items-start align-items-md-center mb-3">
                @foreach ($program->liveProgram as $live_program)
                    <div class="d-flex align-content-center flex-wrap gap-2">
                        <button class="btn btn-label-danger delete-order waves-effect">End All</button>
                    </div>
                @endforeach
            </div>
        @else
            <div class="d-flex flex-column flex-md-row justify-content-end align-items-start align-items-md-center mb-3">
                <div class="d-flex align-content-center flex-wrap gap-2">
                    <button class="btn btn-label-success delete-order waves-effect">Go Live</button>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-xl-12 mb-4 col-lg-12 col-12">
                @include('admin.programs.partials.statistics',['program' => $program])
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Enrolled Student
                        </h4>
                    </div>
                    <div class="card-datatable table-responsive">
                        <table class=" table" id="program-table">
                            <thead>
                            <tr>
                                <th>Roll Number</th>
                                <th>Full name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Payment Info</th>
                                <th>Batch Name</th>
                                <th>Section name</th>
                                <th>Member Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            </tbody>

                            <tfoot>
                            <tr>
                                <th>Roll Number</th>
                                <th>Full name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Payment Info</th>
                                <th>Batch Name</th>
                                <th>Section name</th>
                                <th>Member Date</th>
                                <th>Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-12">
                @include('admin.programs.partials.quick-navigation')
            </div>
        </div>

    </div>
@endsection

@push('page_script')
    <script src="{{ asset ('themes/admin/assets/vendor/libs/bs-stepper/bs-stepper.js')}}"></script>

    <script>
        $("#program-table thead tr").clone(true).addClass('filters').appendTo("#program-table thead")

        $('#program-table').DataTable({
            processing: true,
            serverSide: true,
            fixedHeader: true,
            orderCellsTop: true,
            aaSorting: [],
            initComplete: function() {
                var api = this.api();

                api
                    .columns()
                    .eq(0)
                    .each(function(colIdx) {
                        // Set the header cell to contain the input element
                        var cell = $('.filters th').eq(
                            $(api.column(colIdx).header()).index()
                        );
                        var title = $(cell).text();
                        $(cell).html('<input type="text" placeholder="' + title + '" />');

                        // On every keypress in this input
                        $('input',
                            $('.filters th').eq($(api.column(colIdx).header()).index())
                        )
                            .off('keyup change')
                            .on('change', function(e) {
                                // Get the search value
                                $(this).attr('title', $(this).val());
                                var regexr = '({search})'; //$(this).parents('th').find('select').val();

                                var cursorPosition = this.selectionStart;
                                // Search the column for that value
                                api
                                    .column(colIdx)
                                    .search(
                                        this.value != '' ?
                                            regexr.replace('{search}', '(((' + this.value + ')))') :
                                            '',
                                        this.value != '',
                                        this.value == ''
                                    )
                                    .draw();
                            })
                            .on('keyup', function(e) {
                                e.stopPropagation();

                                $(this).trigger('change');
                                $(this)
                                    .focus()[0]
                                    .setSelectionRange(cursorPosition, cursorPosition);
                            });
                    });
            },
            ajax: '{{url()->full()}}',
            columns: [
                {
                    data: 'roll_number',
                    name: 'roll_number'
                },
                {
                    data: "full_name",
                    name: "full_name"
                },
                {
                    data: "phone_number",
                    name: "phone_number"
                },
                {
                    data: "email",
                    name: "email"
                },
                {
                    data : "total_payment",
                    name: "total_payment"
                },
                {
                    data: "batch",
                    name: "batch"
                },
                {
                    data : 'section',
                    name: 'section'
                },
                {
                    data : 'enrolled_date',
                    name: 'enrolled_date'
                },
                {
                    data: "action",
                    name: "action"
                }
            ]
        });

        $(function(){
            var e=document.getElementById("quickUserView")
            e.addEventListener("show.bs.modal",function(e){var t=document.querySelector("#wizard-create-app");if(null!==t){var n=[].slice.call(t.querySelectorAll(".btn-next")),c=[].slice.call(t.querySelectorAll(".btn-prev")),r=t.querySelector(".btn-submit");const a=new Stepper(t,{linear:!1});n&&n.forEach(e=>{e.addEventListener("click",e=>{a.next(),l()})}),c&&c.forEach(e=>{e.addEventListener("click",e=>{a.previous(),l()})}),r&&r.addEventListener("click",e=>{alert("Submitted..!!")})}})
        })
    </script>
@endpush
