@if( ! $query->count() )
    <h4>Result Not Found</h4>
@else
    <table class='table table-bordered table-hover table-responsive'>
        <thead>
            <tr>
                <td>S.No</td>
                <td>Full Name</td>
                <td>Status</td>
                <td>Payment</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($query as $result)
                <tr>
                    <td> {{ $result->id }} </td>
                    <td>{{ $result->full_name() }}</td>
                    <td>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif