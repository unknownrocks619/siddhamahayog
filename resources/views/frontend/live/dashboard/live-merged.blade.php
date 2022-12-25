@if($program->live && $program->live->live)
<small class="text-muted">Started at {{ date('H:i A', strtotime($program->live->created_at)) }}</small>
<?php
$user_section = null;
if ($program->live->merge) {
    $user_section = user()->section->program_section_id;
    if (isset($program->live->merge->$user_section) || $program->live->section_id == NULL || $program->live->section_id == $user_section) :
        echo "<small class='text-info ps-2'>";
        echo "[Merged]";
        echo "</small>";
    endif;
}
?>
@endif