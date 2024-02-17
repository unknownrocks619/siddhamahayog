@php
    $totalStudent =  $program->students?->count() ?? 0;
@endphp

@if ( ( adminUser()->role()->isCenter() || adminUser()->role()->isCenterAdmin() ) ||  in_array(adminUser()->role(),App\Models\Program::STUDENT_COUNT_ACCESS))
    <span class="btn-label-{{($totalStudent) ? 'primary' : 'danger'}} px-2 py-1">0</span>
@else
    <span class="btn-label-danger px-2 py-1">0</span>
@endif
