<?php

namespace App\Http\Controllers\Admin\Programs;

use App\Http\Controllers\Admin\Datatables\ProgramDataTablesController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Program\AdminProgramSectionRequest;
use App\Models\Member;
use App\Models\Program;
use App\Models\ProgramBatch;
use App\Models\ProgramSection;
use App\Models\ProgramStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AdminProgramSectionController extends Controller
{
    /**
     * @param Request $request
     * @param Program $program
     * @return \Illuminate\Contracts\Foundation\Application|
     *          \Illuminate\Contracts\View\Factory|
 *              \Illuminate\Contracts\View\View
     */
    public function index(Request $request, Program $program, $current_tab=null)
    {
        if ($request->ajax()) {

            $members = ProgramStudent::all_program_student($program,$request->member,30);
            $sections = ProgramSection::where('program_id', $program->getKey())
                                            ->where('id',$request->get('section'))
                                            ->first();
            
            return view('admin.programs.section.partials.search_result', compact('members', 'program', 'sections'));
        }
        //
        $all_sections = ProgramSection::where('program_id', $program->getKey())
            ->with(['programStudents'])
            ->latest()->get();

            return view('admin.programs.section.index', compact("all_sections", "program","current_tab"));
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
        if ($programSection->default) {
            return $this->json(false,'Unable to delete default section.');
        }

        $defaultSection = ProgramSection::where('default',1)->where('program_id',$programSection->program_id)->first();

        if ( ! $defaultSection ) {

            $programSection->default = true;
            $programSection->save();
            return $this->json(false,'Unable to delete default section.');

        }

        ProgramStudent::where('program_id',$programSection->program_id)
                        ->where('program_section_id',$programSection->getKey())
                        ->update(['program_section_id' => $defaultSection->getKey()]);

        $programSection->delete();
        return $this->json(true,'Section Removed.','reload');
    }


    public function sectionStudent(Request $request, Program $program, ProgramSection $section)
    {
        if ($request->ajax()  ) {

            $searchTerm = isset($request->get('search')['value']) ? $request->get('search')['value'] : '';

            return (new ProgramDataTablesController($searchTerm))
                ->setSearchTerm($searchTerm)
                ->setRawColumns(['roll_number',"full_name"])
                ->getSectionStudents($program,$section);

        }
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
        $programBatch = ProgramStudent::where('program_id', $program->getKey())
                                        ->where('student_id', $member->getKey())
                                        ->first();

        $current_section = ProgramSection::where('id',$request->post('section'))->first();
        $programBatch->program_section_id = $current_section->getKey();

        try {
            $programBatch->save();
        } catch (\Throwable $th) {
            return $this->returnResponse(false,'Error: '. $th->getMessage(),null,[],200,route('admin.program.sections.admin_list_all_section', ['program' => $program->getKey()]));
        }
        return $this->returnResponse(true,
                            'Student Record updated.',
                            'redirect',
                                    ['location' => route('admin.program.sections.admin_list_all_section',
                                                            ['program' => $program,
                                                            'current_tab' => str($current_section)->slug()->value()]
                                                        )],
                            200,
                            route('admin.program.sections.admin_list_all_section', ['program' => $program->getKey(),'current_tab' => str($current_section)->slug()->value()]));
    }

    public function fullSectionAccess(Request $request, ProgramStudent $studentID)
    {
        $studentID->allow_all = !$studentID->allow_all;
        $studentID->save();
    }

    public function updateDefaultSection(Program $program, ProgramSection $section) {

        try {
            DB::transaction(function() use ($program,$section) {
                $currentDefaultProgram = ProgramSection::where('program_id',$program->getKey())
                                                        ->where('default',true)
                                                        ->update(['default' => false]);

                // now update current section as default.
                $section->default = true;
                $section->save();
            });
        } catch (\Exception $error) {
            return $this->json(false,'Unable to default section.');
        }

        return $this->json(true,'Default Change has been updated.','redirect',['location' => route('admin.program.sections.admin_list_all_section',['program' => $program,str($section->section_name)->slug()->value()])]);

    }

}
