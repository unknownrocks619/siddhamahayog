<?php

namespace App\Http\Controllers\Admin\Programs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Program\AdminProgramSectionRequest;
use App\Models\Member;
use App\Models\Program;
use App\Models\ProgramSection;
use App\Models\ProgramStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AdminProgramSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Program $program)
    {
        //
        $all_sections = ProgramSection::where('program_id', $program->id)
            ->with(['programStudents'])
            ->latest()->get();
        return view('admin.programs.section.index', compact("all_sections", "program"));
    }

    public function student_list_per_section(Program $program, $section = null)
    {
        $sectionStudent = ProgramStudent::with(['student', 'section'])->where('program_id', $program->getKey());

        if ($section && $section != 'all') {
            $sectionStudent->where('program_section_id', $section);
        } elseif (!$section) {
            $sectionStudent->where('allow_all', true);
        }
        $selectedSection = $section;
        $sectionStudent = $sectionStudent->get();
        return view('admin.programs.all-access-list.index', compact('sectionStudent', 'program', 'selectedSection'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Program $program = null)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminProgramSectionRequest $request, Program $program)
    {
        //
        $program_section = new ProgramSection;
        $program_section->fill([
            'program_id' => $program->getKey(),
            'section_name'  => $request->post('section_name'),
            'slug'  => Str::slug($request->post('section_name'),'-'),
            'default'   => $request->post('default') ?? false
        ]);
        // check slug
        $slug = $program_section->where('slug', Str::slug($request->section_name))->where('program_id', $program->getKey())->exists();

        if ($slug) {
            return $this->returnResponse(false,'Section name already exists.',null,[],200,route('admin.program.section.index',['program' => $program->getKey()]));
        }

        try {
            DB::transaction(function () use ($program_section, $program) {
                if ($program_section->default) {

                    $check_previous = ProgramSection::where("program_id", $program->id)
                                                    ->where('default', true)->first();
                    if ($check_previous) {
                        $check_previous->default = false;
                        $check_previous->save();
                    }

                }
                $program_section->save();
            });

        } catch (\Throwable $th) {
            return $this->returnResponse(false,'Error: '. $th->getMessage(),null,[],200,route('admin.program.section.index',['program' => $program->getKey()]));
        }

        $jsCallback = $request->post('callback') ?? '';
        $params  = $request->post('params') ?? [];
        $params['items'] = ['id' => $program_section->getKey(),'text' => $program_section->section_name];
        return $this->returnResponse(true,"Section Created",$jsCallback,$params,200,route('admin.program.section.index',['program' => $program->getKey()]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProgramSection  $programSection
     * @return \Illuminate\Http\Response
     */
    public function show(ProgramSection $programSection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProgramSection  $programSection
     * @return \Illuminate\Http\Response
     */
    public function edit(ProgramSection $section)
    {
        //
        return view('admin.programs.section.modal.edit', compact("section"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProgramSection  $programSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProgramSection $section)
    {
        //
        $current_section = $section->section_name;
        $section->section_name = $request->section_name;
        if ($section->isDirty("section_name")) {
            // check for slug exists.
            $slug_exits = ProgramSection::where('slug', Str::slug($request->section_name))->where('program_id', $section->program_id)->exists();
            if ($slug_exits) {
                session()->flash('error', "Section already exists.");
                return redirect()->route('admin.program.section.index', [$section->program_id, $current_section]);
            }
        }

        $section->default = ($request->default) ? $request->defult : $section->default;

        try {
            DB::transaction(function () use ($section) {
                if ($section->isDirty("default")) {
                    // check
                    $check_previous = ProgramSection::where("program_id", $section->program_id)->where('default', true)->first();

                    if ($check_previous) {
                        $check_previous->default = false;
                    }

                    if ($check_previous  && $check_previous->isDirty("default")) {
                        $check_previous->save();
                    }
                }

                $section->save();
            });
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash("error", "Unable to update section.");
            return back();
        }
        session()->flash('success', "Section updated.");
        return redirect()->route('admin.program.section.index', [$section->program_id, $current_section]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProgramSection  $programSection
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProgramSection $programSection)
    {
        //

    }


    public function sectionStudent(Request $request, Program $program, ProgramSection $section)
    {

        //
        $all_students = ProgramStudent::with(["section", "batch", 'student'])->where('program_id', $program->id)->where('program_section_id', $section->getKey())->get();
        return view("admin.programs.section.section-student", compact("all_students", "section", "program"));
    }

    public function changeSection(Request $request, Program $program, Member $member, ProgramSection $section)
    {
        $program = $program->load(["sections"]);
        return view("admin.programs.section.modal.change-section", compact("program", "member", 'section'));
    }

    public function updateSection(Request $request, Program $program, Member $member)
    {
        $programBatch = ProgramStudent::where('program_id', $program->id)
            ->where('student_id', $member->id)
            ->first();

        $current_section = $programBatch->program_section_id;
        $programBatch->program_section_id = $request->section;

        try {
            $programBatch->save();
        } catch (\Throwable $th) {
            dd($th->getMessage());
            session()->flash('error', "Error: " . $th->getMessage());
            return redirect()->route('admin.program.sections.admin_list_all_section', [$program->id]);
        }

        session()->flash('success', "Student data updated.");
        return redirect()->route('admin.program.sections.admin_list_all_section', [$program->id, $current_section]);
    }

    public function fullSectionAccess(Request $request, ProgramStudent $studentID)
    {
        $studentID->allow_all = !$studentID->allow_all;
        $studentID->save();
    }
}
