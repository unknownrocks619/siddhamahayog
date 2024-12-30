<?php

namespace App\Http\Controllers\Admin\Datatables;

use App\Classes\Helpers\Image;
use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Dharmasala\DharmasalaBooking;
use App\Models\Program;
use App\Models\ProgramGrouping;
use App\Models\ProgramGroupPeople;
use App\Models\ProgramSection;
use App\Models\ProgramVolunteer;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProgramDataTablesController extends Controller
{
    //
    public $searchTerm = null;
    protected array $rawColumns = [];

    protected int $totalRecord = 0;
    /**
     * Set Search Term
     * @param $searchTerm
     * @return $this
     */
    public function setSearchTerm($searchTerm = null)
    {
        $this->searchTerm = $searchTerm;
        return $this;
    }

    public function setRawColumns(array|string $column = [])
    {

        if (! is_array($column)) {
            $this->rawColumns = array_merge($this->rawColumns, [$column]);
        } else {
            $this->rawColumns = array_merge($this->rawColumns, $column);
        }
        return $this;
    }

    public function getSearchTerm()
    {
        return $this->searchTerm;
    }

    public function getSectionStudents(Program $program, ProgramSection $section)
    {

        $datatable = DataTables::collection($section->section_student($program, $this->getSearchTerm()))
            ->addColumn('roll_number', function ($row) use ($program) {

                if ($program->getKey() == 5) {

                    if (! $row->total_counter) {
                        return '<span class="label label-bg-dark px-1"> 0 </span>';
                    }

                    return '<span class="label label-info px-1">' . $row->total_counter . '</span>';
                }

                if (! $row->roll_number) {
                    return '<span class="label label-bg-dark px-1">
                                <a href="" class="text-info">
                                    <i class="fas fa-plus"></i>
                                        Add Roll number
                                </a>
                            </span>';
                }
                return '<span class="label label-info px-1">' . $row->roll_number . '</span>';
            })
            ->addColumn('full_name', function ($row) {

                return "<a href='" . route('admin.members.show', ['member' => $row->member_id, '_ref' => 'program-section', '_refID' => $row->section_id]) . "'>" . htmlspecialchars(strip_tags($row->full_name)) . "</a>";
            })
            ->addColumn('phone_number', function ($row) {
                return $row->phone_number ?? 'N/A';
            })
            ->addColumn('email', function ($row) {
                return $row->email ?? 'N/A';
            })
            ->addColumn('total_payment', function ($row) {
                $this->setRawColumns('total_payment');
                if (! $row->member_payment) {
                    return '<span class="badge bg-label-danger">' . default_currency(0.0) . '</span>';
                }

                if ($row->scholarID) {
                    return '<span class="badge bg-label-info"><b>Scholarshp</b><br />' . $row->remarks . '</span>';
                }

                return '<span class="badge bg-label-primary">' . default_currency($row->member_payment) . '</span>';
            })
            ->addColumn('batch', function ($row) {
                return $row->batch_name ?? 'Batch N/A';
            })
            ->addColumn('section', function ($row) {
                return $row->section_name ?? 'Section N/A';
            })
            ->addColumn('enrolled_date', function ($row) {
                return date('Y-m-d', strtotime($row->enrolled_date));
            })
            ->addColumn('country', function ($row) {
                if (! $row->member_country &&  ! $row->country_name) {
                    return 'N/A';
                }
                if ($row->member_country && ! (int) $row->member_country) {
                    return htmlspecialchars(strip_tags($row->member_country));
                }

                return $row->country_name;
            })
            ->addColumn('full_address', function ($row) {
                if (! $row->address) {
                    return 'N/A';
                }

                $addressDecode = json_decode($row->address);
                if (isset($addressDecode->street_address)) {
                    return htmlspecialchars(strip_tags($addressDecode->street_address));
                }

                if ($row->personal_detail) {
                    $detailDecode = json_decode($row->personal_detail);

                    if (isset($detailDecode->street_address)) {
                        return htmlspecialchars(strip_tags($detailDecode->street_address));
                    }
                }

                return 'N/A';
            })
            ->addColumn('action', function ($row) {
                $action = '';
                return $action;
            });
        return $datatable->rawColumns($this->rawColumns)->make(true);
    }

    public function getBatchStudent(Program $program, Batch $batch)
    {
        $datatable = DataTables::collection($batch->batchProgramStudent($program, $this->getSearchTerm()))
            ->addColumn('roll_number', function ($row) use ($program) {

                if ($program->getKey() == 5) {
                    if (! $row->total_counter) {
                        return '<span class="label label-bg-dark px-1"> 0 </span>';
                    }
                    return '<span class="label label-info px-1">' . $row->total_counter . '</span>';
                }
                if (! $row->roll_number) {
                    return '<span class="label label-bg-dark px-1">
                                <a href="" class="text-info">
                                    <i class="fas fa-plus"></i>
                                        Add Roll number
                                </a>
                            </span>';
                }
                return '<span class="label label-info px-1">' . $row->roll_number . '</span>';
            })
            ->addColumn('full_name', function ($row) {
                return "<a href='" . route('admin.members.show', ['member' => $row->member_id, '_ref' => 'program-section', '_refID' => $row->section_id]) . "'>" . htmlspecialchars(strip_tags($row->full_name)) . "</a>";
            })
            ->addColumn('phone_number', function ($row) {
                return $row->phone_number ?? 'N/A';
            })
            ->addColumn('email', function ($row) {
                return $row->email ?? 'N/A';
            })
            //            ->addColumn('total_payment', function ($row) {
            //                $this->setRawColumns('total_payment');
            //                if ( ! $row->member_payment ) {
            //                    return '<span class="badge bg-label-danger">'.default_currency(0.0).'</span>';
            //                }
            //
            //                if ($row->scholarID) {
            //                    return '<span class="badge bg-label-info"><b>Scholarshp</b><br />'.$row->remarks.'</span>';
            //                }
            //
            //                return '<span class="badge bg-label-primary">'.default_currency($row->member_payment).'</span>';
            //            })
            ->addColumn('batch', function ($row) {
                return $row->batch_name ?? 'Batch N/A';
            })
            ->addColumn('section', function ($row) {
                return $row->section_name ?? 'Section N/A';
            })
            ->addColumn('enrolled_date', function ($row) {
                return date('Y-m-d', strtotime($row->enrolled_date));
            })
            ->addColumn('country', function ($row) {
                if (! $row->member_country &&  ! $row->country_name) {
                    return 'N/A';
                }
                if ($row->member_country && ! (int) $row->member_country) {
                    return htmlspecialchars(strip_tags($row->member_country));
                }

                return htmlspecialchars(strip_tags($row->country_name));
            })
            ->addColumn('full_address', function ($row) {
                if (! $row->address) {
                    return 'N/A';
                }

                $addressDecode = json_decode($row->address);
                if (isset($addressDecode->street_address)) {
                    return htmlspecialchars(strip_tags($addressDecode->street_address));
                }

                if ($row->personal_detail) {
                    $detailDecode = json_decode($row->personal_detail);

                    if (isset($detailDecode->street_address)) {
                        return htmlspecialchars(strip_tags($detailDecode->street_address));
                    }
                }

                return 'N/A';
            })
            ->addColumn('action', function ($row) {
                $action = '';
                return $action;
            });
        return $datatable->rawColumns($this->rawColumns)->make(true);
    }

    public function dharmasalaBookingList(Request $request, $filter = null, $searchTerm = "")
    {

        $bookingsModel = DharmasalaBooking::select("*");

        if ($filter) {
            $bookingsModel->where('status', (int) $filter);
        }

        if ($searchTerm) {
            $bookingsModel->where(function ($query) use ($searchTerm) {

                $query->where('full_name', 'LIKE', '%' . $searchTerm . '%')
                    ->OrWhere('floor_name', 'LIKE', '%' . $searchTerm . '%')
                    ->OrWhere('building_name', 'LIKE', '%' . $searchTerm . '%')
                    ->OrWhere('room_number', 'LIKE', '%' . $searchTerm . '%')
                    ->OrWhere('email', 'LIKE', '%' . $searchTerm . '%')
                    ->OrWhere('check_in', 'LIKE', '%' . $searchTerm . '%')
                    ->OrWhere('check_out', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        if ($request->user) {
            $bookingsModel->where('email', $request->user);
            $params['sort']['user'] =  $request->user;
        }

        if ($request->check_in) {
            $bookingsModel->where('check_in', $request->check_in);
            $params['sort']['check_in'] = $request->check_in;
        }

        if ($request->filter_room) {
            $bookingsModel->where('room_number', $request->filter_room);
            $params['sort']['filter_room'] = $request->filter_room;
        }

        if ($request->check_out) {
            $bookingsModel->where('check_out', $request->check_out);
            $params['sort']['check_out'] = $request->check_out;
        }


        $datatable =  DataTables::collection($bookingsModel->get())
            ->addColumn('full_name', function ($row) {
                $action = "<a href='" . route('admin.dharmasala.booking.list', ['user' => $row->email]) . "'>";
                $action .= $row->full_name;
                $action .= "</a>";
                return $action;
            })
            ->addColumn('floor_name', fn($row) => $row->floor_name)
            ->addColumn('room_number', function ($row) {
                $action = "<a href='" . route('admin.dharmasala.booking.list', ['filter_room' => $row->room_number]) . "'>";
                $action .= $row->room_number;
                $action .= "</a>";
                return $action;
            })
            ->addColumn('email', fn($row) => $row->email)
            ->addColumn('check_in', function ($row) use ($request) {
                $action = "<a href='" . route('admin.dharmasala.booking.list', ['check_in' => $row->check_in]) . "'>";
                $action .= $row->check_in;
                $action .= "</a>";
                return $action;
            })
            ->addColumn('check_out', function ($row) {
                $action = "<a href='" . route('admin.dharmasala.booking.list', ['check_out' => $row->check_out]) . "'>";
                $action .= $row->check_out;
                $action .= "</a>";
                return $action;
            })
            ->addColumn('status', function ($row) {
                return DharmasalaBooking::STATUS[$row->status];
            })
            ->addColumn('qr', function ($row) {
                if (! $row->uuid) {
                    return 'N/A';
                }
                return Image::dynamicBarCode($row->uuid);
                // return  QrCode::generate($row->uuid);
            })
            ->addColumn('action', function ($row) {
                return view('admin.datatable-view.dharmasala.booking-action', ['booking' => $row]);
            });

        return $datatable->rawColumns(["action", 'status', 'qr', 'full_name', 'check_in', 'check_out', 'room_number'])
            ->make(true);
    }


    public function programList(Request $request, $type = null)
    {

        $programs = Program::with([
            "defaultBatch",
            "liveProgram" => function ($query) {
                return $query->with(["sections" => function ($query) {
                    $query->with('programCenterStudent');
                }]);
            },
            'students',
            'sections' => function ($query) {
                $query->withCount('programStudents');
            }
        ]);

        if (adminUser()->role()->isCenter() || adminUser()->role()->isCenterAdmin()) {
            // $programs->where('id','5');
        }

        if ($type) {
            $programs->where("program_type", $type)->get();
        }


        $datatable = DataTables::of($programs)
            ->addIndexColumn()
            ->addColumn('program_name', function ($row) {

                return view('admin.datatable-view.programs.program-name', ['program' => $row])->render();
            })
            ->addColumn('program_duration', function ($row) {
                return ($row->program_duration) ? "Ongoing" : $row->program_duration;
            })
            ->addColumn('sections', function ($row) {
                return view('admin.datatable-view.programs.program-section', ['program' => $row])->render();
            })
            ->addColumn('total_student', function ($row) {

                return view('admin.datatable-view.programs.student-count', ['program' => $row])->render();
            })
            ->addColumn('promote', function ($row) {
                return view('admin.datatable-view.programs.live', ['row' => $row])->render();
            })
            ->addColumn('batch', function ($row) {

                if ($row->defaultBatch) {
                    return ($row->defaultBatch->batch_name . "-" . $row->defaultBatch->batch_year . "/   " . $row->defaultBatch->batch_month);
                } else {
                    if (! in_array(adminUser()->role(), Program::EDIT_PROGRAM_ACCESS)) {
                        return ' -- ';
                    }
                    return "<button data-action='" . route('admin.modal.display', ['view' => 'programs.batch.new', 'program' => $row->getKey(), 'callback' => 'reload']) . "' data-bs-toggle='modal' data-bs-target='#newBatch' class='btn btn-link ajax-modal'>Add Batch</button>";
                }
            })
            ->addColumn('action', function ($row) {

                return view('admin.datatable-view.programs.action', ['program' => $row])->render();
            })
            ->rawColumns(["program_name", "batch", "action", "promote", "total_student", 'sections'])
            ->make(true);

        return $datatable;
    }

    public function programVolunteerList(Request $request, Program $program, string $searchTerm = '')
    {
        $volunterQuery = ProgramVolunteer::where('program_id', $program->getKey());

        if ($searchTerm != '') {
            $volunterQuery->where("full_name", 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('gotra', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('country', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('education', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('gender', 'LIKE', '%' . $searchTerm . '%');
        }

        $volunteers = $volunterQuery->get();


        $datatable =  DataTables::of($volunteers)
            ->addColumn('full_name', function ($row) {
                $action = "<a href='" . route('admin.members.show', ['member' => $row->member_id]) . "'>";
                $action .= $row->full_name;
                $action .= "</a>";
                $action .= "<br />";
                $action .= $row->email;
                return $action;
            })
            ->addColumn('phone_number', fn($row) => $row->phone_number)
            ->addColumn('email', fn($row) => $row->email)
            ->addColumn('full_address', fn($row) => $row->full_address)
            ->addColumn('education', fn($row) => $row->education)
            ->addColumn('gender', fn($row) => $row->gender)
            ->addColumn('profession', fn($row) => $row->profession)
            ->addColumn('action', function ($row) use ($program) {
                $action = route('admin.program.volunteer.admin_volunteer_show', ['program' => $program, 'volunteer' => $row]);

                $action = "<a class='btn btn-primary' href='{$action}'>";
                $action .= "View Detail";
                $action .= "</a>";
                return $action;
            })
            ->rawColumns(['full_name', 'action'])
            ->make(true);
        return $datatable;
    }

    public function programGroupPeopleList(Request $request, Program $program, ProgramGrouping $group, string $searchTerm = "")
    {

        $request->merge(['page' => $request->get('draw')]);
        // $offsetSet = $request->get('draw') == 1 ? 0 : $request->get('draw') - 1 ;
        // dd($offsetSet *);
        $groupPeopleQuery = ProgramGroupPeople::where('group_id', $group->getKey())
            ->with('families')
            ->where('is_parent', true);
        if ($request->get('search')['value'] && ! empty(trim($request->get('search')['value']))) {
            $request->merge(['page' => 0]);
            $searchTerm = $request->get('search')['value'];

            $groupPeopleQuery->where(function ($query) use ($searchTerm) {
                $query->where('full_name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('phone_number', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('address', 'LIKE', '%' . $searchTerm . '%');
            });
        }
        $groupPeople = $groupPeopleQuery->get();

        // $totalRecord = ProgramGroupPeople::where('group_id',$group->getKey())
        //                                     ->with('families')
        //                                     ->where('is_parent',true)
        //                                     ->count();

        $datatable =  DataTables::of($groupPeople)
            ->addColumn('input', fn($people) => view('admin.datatable-view.programs.groups.input', ['people' => $people])->render())
            ->addColumn('full_name', fn($people) => view('admin.datatable-view.programs.groups.full_name', ['people' => $people])->render())
            ->addColumn('family', fn($people) => view('admin.datatable-view.programs.groups.family', ['people' => $people])->render())
            ->addColumn('remarks', fn($people) => view('admin.datatable-view.programs.groups.remarks', ['people' => $people])->render())
            ->setRowClass(function ($people) {
                $missingFamilyProfile = [];

                foreach ($people->families as $family) {
                    if (! $family->profile_id) {
                        $missingFamilyProfile[] = $family->full_name;
                    }
                }

                if (count($missingFamilyProfile) >= 1) {
                    return 'bg-label-danger text-white';
                }

                return '';
            })->setRowAttr(
                [
                    'id' => fn($people) =>  'groupPeople_' . $people->getKey(),
                    'data-action' => fn($people) => route('admin.program.admin_people_verification', ['program' => $people->program_id, 'group' => $people->group_id, 'people' => $people]),
                ]
            )
            ->addColumn('action', fn($people) => view('admin.datatable-view.programs.groups.action', ['people' => $people])->render())
            ->rawColumns(['full_name', 'action', 'family', 'input', 'remarks'])
            // ->setTotalRecords($totalRecord)
            ->make(true);
        return $datatable;
    }
}
