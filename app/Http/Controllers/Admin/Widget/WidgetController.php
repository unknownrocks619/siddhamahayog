<?php

namespace App\Http\Controllers\Admin\Widget;

use App\Http\Controllers\Controller;
use App\Models\Widget;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class WidgetController extends Controller
{
    //

    public function index() {

        if (request()->ajax() ) {

            $widgets = Widget::where("page",false)->get();
            return DataTables::of($widgets)
                            ->addColumn("widget_name", function ($row) {
                                return $row->widget_name;
                            })
                            ->addColumn('widget_type', function ($row) {
                                return ucwords(str_replace(["-","_"]," ",$row->widget_type));
                            })
                            ->addColumn("action", function ($row) {
                                $action = '';

                                $action = "<a href='#' class='text-info'> Edit </a>";
                                $action .= " | ";
                                $action .= "<a href='#'> Delete </a>";

                                return $action;
                            })
                            ->rawColumns(["action","widget_name"])
                            ->make(true);
        }

        return view('admin.widget.index');
    }

    public function create() {

        return view('admin.widget.form.create');
    }
}
