@foreach ($program->sections ?? [] as $section):
    @php 
        $sectionStudentCount = $section->program_students_count;
        $link = route('admin.program.sections.admin_list_all_section',['program'=>$program->getKey(),'current_tab' => $section->slug]);
    @endphp

    @if((adminUser()->role()->isCenter() || adminUser()->role()->isCenterAdmin()) )
        <span class="mx-1 my-1 btn btn-label-danger">
            <a href="{{$link}}">
                {{$section->section_name}} ({{$section->programCenterStudent->count() }})
            </a>
        </span>

    @elseif( in_array(adminUser()->role(), App\Models\Program::STUDENT_COUNT_ACCESS) )
        <span class="mx-1 my-1 btn btn-label-danger">
            <a href="{{$link}}">
                {{$section->section_name}} ({{$sectionStudentCount}})
            </a>
        </span>
    @else
        <span class="mx-1 my-1 btn btn-label-primary">
            {{$section->section_name}} (0)
        </span>
    @endif

@endforeach