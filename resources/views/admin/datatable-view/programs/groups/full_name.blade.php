@if($people->is_card_generated)
    <span class="fas fa-start"></span>
@endif
<span class="@if(! $people->profile_id) text-white @endif">
{{$people->full_name}}
</span>
<br />
@if(! $people->is_card_generated)
    <a 
        class="badge bg-label-warning"
        href="{{route('admin.program.admin_program_generate_card',['people' => $people,'program' => $people->program_id,'group' => $people->group_id])}}">
            Generate Card
    </a>
@endif
@if($people->is_card_generated)
    <a href="{{route('admin.program.amdmin_group_card_view',['people' => $people,'program' => $people->program_id,'group' => $people->group_id])}}">
        View Family Card
    </a>
@endif