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
                                        NRs. {{ number_format($fund->amount,2) }}
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
                                        <a href="" class='text-success'>Verify</a>
                                        <a href="" class='text-danger'>Reject</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>  
</section>
<!--/ Complex headers table -->
@endsection