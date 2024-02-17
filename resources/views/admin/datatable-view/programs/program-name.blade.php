{{$program->program_name}}
<br />

@if ($program->program_type == "paid")
    <span class='text-success px-2'>PAID</span>
@else
    <span class='text-warning px-2'>{{strtoupper($program->program_type)}}
@endif

