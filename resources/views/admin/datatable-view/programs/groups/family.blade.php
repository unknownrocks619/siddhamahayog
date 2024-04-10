<div class="list-group">
    @forelse ($people->families as $family)
        @if( ! $family->profile_id) @php $missingFamilyProfile[] = $family->full_name @endphp @endif
        <label class="list-group-item" >
                <span @if(! $family->profile_id) class="text-warning" @endif>
                    {{$family->full_name}}
                </span>
        </label>
    @empty
        No Family Member
    @endforelse
</div>