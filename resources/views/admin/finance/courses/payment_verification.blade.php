@extends("layouts.admin")

@section("content")
<!-- Complex headers table -->
<section id="headers">
    <div class="row">
        <div class="col-12">
            <div class='card'>
                <div class='card-header'>
                    <x-alert></x-alert>
                </div>
                <div class='card-body'>
                    @if( ! $funds->count() ) 
                        <p class='text-danger'>No Pending Transaction.</p>
                    @else
                    
                    <table class='table table-bordered table-hover'>
                        <thead>
                            <tr>
                                <th>
                                    Sadhak
                                </th>
                                <th>Course</th>
                                <th>Transaction Amount</th>
                                <th>Transaction Source</th>
                                <th>Remarks</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($funds as $fund)
                                <tr>
                                    <td>
                                        {{ $fund->user_detail->full_name() }}
                                    </td>
                                    <td>
                                        {{ $fund->sibir->sibir_title }}
                                    </td>
                                    <td>
                                        NRs. {{ number_format((float) $fund->amount,2) }}
                                    </td>
                                    <td>
                                        {{ $fund->source }}
                                        @if($fund->file)
                                            <a href="#">View</a>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $fund->owner_remarks }}
                                    </td>
                                    <td>
                                        <a href="{{ route('courses.admin_change_payment_status',[$fund->id]) }}" class='text-success'>View Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif

                    {{ $funds->links() }}
                </div>
            </div>
        </div>
    </div>  
</section>
<!--/ Complex headers table -->
@endsection