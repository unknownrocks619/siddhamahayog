<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\Notes\DeleteNotesRequest;
use App\Http\Requests\Frontend\User\Notes\ShowNotesRequest;
use App\Http\Requests\Frontend\User\Notes\StoreNotesRequest;
use App\Http\Requests\Frontend\User\Notes\UpdateNotesRequest;
use App\Models\MemberNotes;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserNoteController extends Controller
{
    //

    public function index()
    {
        $notes  = MemberNotes::where('member_id', auth()->id())->latest()->get();
        return view('frontend.user.notes', compact("notes"));
    }

    public function create()
    {
        return view("frontend.user.notes.create");
    }

    public function store(StoreNotesRequest $request)
    {
        $notes = new MemberNotes;
        $notes->member_id = user()->id;
        $notes->title = $request->title;
        $notes->note = $request->notes;
        $notes->slug = Str::slug($request->title, "-");

        try {
            $notes->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash("error", "Unable to save note.");
            return back()->withInput();
        }

        session()->flash("success", "Note Saved.");
        return back();
    }

    public function edit(ShowNotesRequest $request, MemberNotes $note)
    {
        return view("frontend.user.notes.edit", compact("note"));
    }

    public function update(UpdateNotesRequest $request, MemberNotes $note)
    {
        $note->title = $request->title;

        if ($note->isDirty("title")) {
            $note->slug = Str::slug($request->title, "-");
        }

        $note->note = $request->notes;

        try {
            $note->save();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash("error", "Unable to udpate note.");
            return back()->withInput();
        }

        session()->flash("success", "Note Updated.");
        return back();
    }


    public function destroy(DeleteNotesRequest $request, MemberNotes $note)
    {
        try {
            $note->delete();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash("error", "Unable to remove note. Please try again.");
            return back();
        }

        session()->flash('success', 'Note Deleted.');
        return back();
    }
}
