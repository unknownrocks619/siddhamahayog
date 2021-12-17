@extends("layouts.admin")

@section("content")
<!-- Complex headers table -->
<section id="headers">
    <div class="row">
        @if (! $funds->count() )
            <div class="col-12">
                <p class="text-danger">No Pending Transaction.</p>
            </div>
        @endif

        @if( $funds->count())
            @foreach ($funds as $fund)
            <div class="col-4">
                <div class="card @if(! $fund->image_file || ! $fund->image_file->path) bg-danger @endif">
                    <div class="card-header">
                        <h4 >{{ ucwords($fund->user_detail->full_name()) }}
                            <small style="font-size:16px" class='text-info'>Phone Number: {{ $fund->user_detail->phone_number }}</small>
                        </h4>
                        <br />
                        NRs. {{ number_format((float) $fund->amount,2) }}
                    </div>
                    <div class="card-body">
                        @if ($fund->image_file && $fund->image_file->path) 
                        <img src="{{ app('url')->asset($fund->image_file->path) }}" class='img-fluid' />    
                        @else
                            <p class="text-white">Image Not Available</p>
                        @endif
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('courses.admin_change_payment_status',[$fund->id]) }}" class="btn btn-primary">View Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        @endif


    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            @if($funds->count())
                {{ $funds->links() }}
            @endif
        </div>
    </div>
</section>
<!--/ Complex headers table -->
@endsection