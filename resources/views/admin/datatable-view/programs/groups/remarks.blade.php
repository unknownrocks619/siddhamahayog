@php $missingFamilyProfile = [] @endphp

@foreach ($people->families as $family)
    @if( ! $family->profile_id) @php $missingFamilyProfile[] = $family->full_name @endphp @endif
@endforeach

@if(count($missingFamilyProfile))
    <div class="row">
        <div class="col-md-12 text-danger">
            <ul>
                @if( ! $people->profile_id )
                    <li>
                        <span >{{$people->full_name}} Profile Photo Is Missing</span>
                    </li>
                @endif

                @foreach ($missingFamilyProfile as $family)
                    <li>
                        <span>{{$family}} Profile Photo Is Missing</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@else
    <span class="badge bg-label-warning">OK</span>
@endif