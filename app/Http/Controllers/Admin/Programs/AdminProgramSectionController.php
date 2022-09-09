<?php

namespace App\Http\Controllers\Admin\Programs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Program\AdminProgramSectionRequest;
use App\Models\Program;
use App\Models\ProgramSection;
use Illuminate\Http\Request;
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
        $all_sections = ProgramSection::where('program_id', $program->id)->latest()->get();
        return view('admin.programs.section.index', compact("all_sections", "program"));
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
        $program_section->program_id = $program->id;
        $program_section->section_name = $request->section_name;
        $program_section->slug = Str::slug($request->section_name, '-');
        $program_section->default = ($request->default) ? true : false;

        // check slug 
        $slug = $program_section->where('slug', Str::slug($request->section_name))->where('program_id', $program->id)->exists();
        if ($slug) {
            session()->flash('error', "Section Name Already Exists.");
            return back()->withInput();
        }
        try {
            DB::transaction(function () use ($program_section, $program) {
                if ($program_section->default) {

                    $check_previous = $program_section->where("program_id", $program->id)->where('default', true)->first();

                    if ($check_previous) {
                        $check_previous->default = false;
                    }

                    if ( $check_previous && $check_previous->isDrity()) {
                        $check_previous->save();
                    }
                }
                $program_section->save();
            });
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error', "Unable to add section. Error: " . $th->getMessage());
            return back()->withInput();
        }

        session()->flash('success', "Section Crated.");
        return back();
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
        $section->section_name = $request->section_name;

        if ($section->isDirty("section_name")) {
            // check for slug exists.
            $slug_exits = ProgramSection::where('slug', Str::slug($request->section_name))->where('program_id', $section->program_id)->exists();
            if ($slug_exits) {
                session()->flash('error', "Section already exists.");
                return redirect()->route('admin.program.sections.admin_list_all_section', [$section->program_id]);
            }
        }

        $section->default = ($request->default) ? true : false;

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
        return redirect()->route('admin.program.sections.admin_list_all_section', $section->program_id);
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
}
