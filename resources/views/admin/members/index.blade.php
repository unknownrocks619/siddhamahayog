@extends('layouts.admin.master')
@push('page_title') All Members @endpush
@push('page_css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush
@section('main')
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light">Members/</span> All
            </h4>
            <div>
                <a href="{{route('admin.members.create')}}" class="btn btn-primary me-2"><i class="fas fa-plus"></i> Create New Member</a>
                <a href="{{route('admin.members.quick-add')}}" data-bs-target="#quickAdd" data-bs-toggle="modal" class="btn btn-primary "><i class="fas fa-plus"></i> Quick New Registration</a>


            </div>
        </div>
    </div>

    <div class="card bg-white mb-3 pb-0">
        <form action="" method="get">
            <div class="card-header pb-0">
                <h4 class="card-title">Filter Result</h4>
            </div>
            <div class="card-body pb-0">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="created_date">Date</label>
                            <input type="text" @if($filters['date'])  value="{{$filters['date']}}" @else data-value="-" @endif name="filter_date" id="date" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="created_date">Enrolled Programs</label>
                            <select name="filter_program[]" id="filter-program"  class="form-control" multiple>
                                <option value="">All</option>
                                @foreach(\App\Models\Program::get() as $program)
                                    <option @if(in_array($program->getKey(),$filters['programs'])) selected @endif value="{{$program->getKey()}}">{{$program->program_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="created_date">Role</label>
                            <select name="filter_roles[]" multiple id="filter-roles" class="form-control">
                                <option value="">All</option>
                                @foreach(\App\Models\Role::$roles as $key => $role)
                                    <option @if(in_array($key, $filters['roles'])) selected @endif value="{{$key}}">{{$role}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-12 text-end">
                        <button type="submit" class="btn btn-primary">Apply Filter</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Responsive Datatable -->
    <div class="card">
        <h5 class="card-header">All Member List</h5>
        <div class="card-datatable table-responsive">
            @if( ! in_array(adminUser()->role(),[
                    App\Classes\Helpers\Roles\Rule::SUPER_ADMIN,
                    App\Classes\Helpers\Roles\Rule::ADMIN,
                    App\Classes\Helpers\Roles\Rule::CENTER,
                    App\Classes\Helpers\Roles\Rule::CENTER_ADMIN,
                ]))
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-secondary">
                                You do not have permission to view this page.
                            </h5>
                        </div>
                    </div>
                </div>
            @else
                <table class="dt-responsive table" id="program-table">
                    <thead>
                        <tr>
                            <th>Full name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Subscriptions</th>
                            <th>Member Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    </tbody>

                    <tfoot>
                    <tr>
                        <th>Full name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Subscriptions</th>
                        <th>Member Date</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                </table>
            @endif
        </div>
    </div>
    <!--/ Responsive Datatable -->
    <x-modal modal="quickUserView">
        @include('admin.members.modal.user-quick-view')
    </x-modal>
    <x-modal modal="quickAdd">
        @include('admin.members.modal.user-quick-add')
    </x-modal>

@endsection

@push('page_script')
    <script src="{{ asset ('themes/admin/assets/vendor/libs/bs-stepper/bs-stepper.js')}}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $('input#date').daterangepicker({
            autoUpdateInput : false,
        });

        $('input#date').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        $('input#date').on('apply.daterangepicker', function(ev, picker) {
            $(this).removeAttr('data-value');
        });

        // $("#program-table thead tr").clone(true).addClass('filters').appendTo("#program-table thead")
        let abortController = null;

        $('#program-table').DataTable({
            processing: true,
            serverSide: true,
            fixedHeader: true,
            orderCellsTop: true,
            pageLength: 250,
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
            ajax: function (data, callback, settings) {
                if (abortController) {
                    abortController.abort();
                }
                abortController = new AbortController();

                if ($('input#date').data('value') ){
                    $('input#date').val('');
                }

                $.ajax({
                    url: '{{ url()->full() }}',
                    method: 'GET',
                    data: data,
                    dataType: 'json',
                    signal: abortController.signal, // Attach signal for aborting
                    success: function(response) {
                        callback(response);
                    },
                    error: function(xhr, status, error) {
                        if (status !== 'abort') {
                            console.error('Error loading data:', error);
                        }
                    }
                });
            },
            columns: [
                {
                    data: 'full_name',
                    name: 'full_name'
                },
                {
                    data: "email",
                    name: "email"
                },
                {
                    data: "phone",
                    name: "phone"
                },
                {
                    data: "program_involved",
                    name: "program_involved"
                },
                {
                    data: "registered_date",
                    name: "registered_date"
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
