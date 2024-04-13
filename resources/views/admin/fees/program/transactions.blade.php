@extends('layouts.admin.master')
@push('page_title') Program  > Fee > Transactions @endpush
@section('main')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{route('admin.program.admin_program_detail',['program' => $program])}}"> Programs</a> / </span> Transactions
    </h4>
    <div class="row mb-2">
        <div class="col-md-12 d-flex justify-content-between">
            <a href="{{route('admin.program.admin_program_detail',['program' => $program])}}" class="btn btn-danger btn-icon">
                <i class="fas fa-arrow-left"></i>
            </a>
            {{-- <button data-bs-target="#quickUserView" data-bs-toggle="modal" data-action="{{route('admin.modal.display',['view' => 'programs.guests.index','program' => $program->getKey()])}}" class="btn btn-primary btn-icon ajax-modal">
                <i class="fas fa-plus"></i>
            </button> --}}
        </div>
    </div>

    @if(adminUser()->role()->isSuperAdmin())
        @include('admin.fees.program.partials.stat')
    @endif
    <div class="row">
        <div class="@if(adminUser()->role()->isSuperAdmin() || adminUser()->role()->isAdmin()) col-md-12 @else col-md-12 @endif">
            <!-- Responsive Datatable -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title">Transaction Overviews</h5>
                        <a href="{{route('admin.members.create')}}" class="btn btn-primary">Add Transaction</a>
                    </div>
                </div>
                
                <div class="card-datatable table-responsive">
                    <form action="{{url()->full()}}" method="get">
                        <div class="row p-3 bg-light">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="filter_center">Filter By Center: </label>
                                    <select name="filter_center" id="filter_center" class="form-control">
                                        <option value="" disabled selected>Select Center</option>
                                        @foreach (\App\Models\Centers::get() as $center)
                                            <option value="{{$center->getKey()}}">{{$center->center_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="filter_staff">Filter By Staff: </label>
                                    <select name="filter_staff" id="filter_center" class="form-control">
                                        <option value="" disabled selected>Select User To Filter</option>
                                        @foreach (\App\Models\AdminUser::get() as $adminUser)
                                        <option value="{{$adminUser->getKey()}}">{{$adminUser->full_name()}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="filter_staff">Filter By Amount: </label>
                                    <input type="number" name="filter_amount" id="filter_amount" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="filter_type">Filter Type: </label>
                                    <select name="filter_type" id="filter_type" class="form-control">
                                        <option value="gt">Greater Than (>)</option>
                                        <option value="lt">Less Than (<)</option>
                                        <option value="gte">Greater Than Equals(>=)</option>
                                        <option value="lte">Less Than Equals(<=)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <button class="btn btn-primary">
                                    Apply Filter
                                </button>
                            </div>
                        </div>
                    </form>
                    <table class="dt-responsive table" id="program_fee_overview">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            @if(adminUser()->role()->isSuperAdmin() || adminUser()->role()->isAdmin())
                                <th>
                                    Entry
                                </th>
                                <th>
                                    Center
                                </th>
                            @endif


                            <th>
                            @if($program->getKey() == 5) Voucher Number @else Category @endif
                            </th>
                            <th>Status</th>
                            <th>Tx Info</th>
                            <th>Source</th>
                            <th>Amount</th>
                            <th>Tx Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <!--/ Responsive Datatable -->

        </div>
        <div  class="@if(adminUser()->role()->isSuperAdmin() || adminUser()->role()->isAdmin()) position-fixed bottom-50 end-0 @else col-md-2 d-none @endif">
            <button class="btn btn-primary btn-icon" 
            data-bs-toggle="collapse" data-bs-target="#transaction-quick-navigation" aria-expanded="false" aria-controls="collapseExample"
            ><i class="fas fa-nav"></i></button>
        </div>
        <div class="collapse" id="transaction-quick-navigation">
            <div class="col-md-2">
                <div class="position-fixed bottom-0 left-0 text-end border border-danger">
                    <button class="btn btn-danger btn-icon js-close-element text-end" data-bs-type="collapse" data-bs-target="#transaction-quick-navigation"><i class="fas fa-close"></i></button>
                    @include('admin.fees.program.partials.quick-navigation',['program' => $program])
                </div>
            </div>
    
        </div>
    </div>
    <x-modal modal="imageFile"></x-modal>
    <x-modal modal="transactionOptionModal"></x-modal>
@endsection

@push('page_script')
    <script>
        $('#program_fee_overview').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{url()->full()}}',
            aaSorting: [],
            pageLength: 250,
            columns: [
                {
                    data : 'printable',
                    name : 'printable'
                },
                {
                    data: 'member_name',
                    name: "member_name"
                },
                @if(adminUser()->role()->isSuperAdmin() || adminUser()->role()->isAdmin()) 
                    {data : 'staff_name',name:'staff_name'},
                    {data : 'center', name:'center'},
                @endif
                {
                    data: "category",
                    name: "category"
                },
                {
                    data: "status",
                    name: "status"
                },
                {
                    data: "media",
                    name: "media"
                },
                {
                    data: "source",
                    name: "source"
                },
                {
                    data: 'transaction_amount',
                    name: 'transaction_amount'
                },

                {
                    data: 'transaction_date',
                    name: "transaction_date"
                },
                {
                    data: "action",
                    name: "action"
                },
            ],
            order: [
                [0, 'desc']
            ]
        });

        $(document).on('change','.printableTransaction',function (event) {
            // event.preventDefault();
            let postData = {
                'memberID' : $(this).attr('data-member-id'),
                'transactionID'   : $(this).attr('data-transaction-id'),
                'source' : 'transaction'
            }

            if ( ! $(this).is(':checked') ) {
                $(document).find('#transactionID_'+postData.transactionID).addClass('d-none')

                $.ajax({
                    type : 'post',
                    url : "{{route('admin.program.admin_remove_member_from_group',['program' => $program,'group' => 1])}}",
                    data : postData,
                });
                return 
            }
            $(document).find('#transactionID_'+postData.transactionID).trigger('click').removeClass('d-none')
            // $('#transactionID_'+postData.transactionID).removeClass('d-none')
            // $('#transactionID_'+postData.transactionID).('click')
        });
    </script>


@endpush
