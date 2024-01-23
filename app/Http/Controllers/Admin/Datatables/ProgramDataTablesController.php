<?php

namespace App\Http\Controllers\Admin\Datatables;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramSection;
use Illuminate\Http\Request;
use DataTables;

class ProgramDataTablesController extends Controller
{
    //
    public $searchTerm = null;
    protected array $rawColumns = [];

    /**
     * Set Search Term
     * @param $searchTerm
     * @return $this
     */
    public function setSearchTerm($searchTerm = null) {
        $this->searchTerm = $searchTerm;
        return $this;
    }

    public function setRawColumns(array|string $column = []) {

        if ( ! is_array ($column) ) {
            $this->rawColumns = array_merge($this->rawColumns, [$column]);
        } else {
            $this->rawColumns = array_merge($this->rawColumns,$column);
        }
        return $this;
    }

    public function getSearchTerm() {
        return $this->searchTerm;
    }

    public function getSectionStudents(Program $program, ProgramSection $section) {
        $datatable = DataTables::of($section->section_student($program,$this->getSearchTerm()))
            ->addColumn('roll_number', function ($row) use ($program) {

                if ( $program->getKey() == 5 ) {

                    if ( ! $row->total_counter) {
                        return '<span class="label label-bg-dark px-1"> 0 </span>';
                    }

                    return '<span class="label label-info px-1">'.$row->total_counter.'</span>';

                }

                if ( ! $row->roll_number) {
                    return '<span class="label label-bg-dark px-1">
                                <a href="" class="text-info">
                                    <i class="fas fa-plus"></i>
                                        Add Roll number
                                </a>
                            </span>';
                }
                return '<span class="label label-info px-1">'.$row->roll_number.'</span>';

            })
            ->addColumn('full_name', function ($row) {

                return "<a href='".route('admin.members.show',['member' => $row->member_id,'_ref' => 'program-section','_refID' => $row->section_id])."'>".$row->full_name."</a>";
            })
            ->addColumn('phone_number', function ($row) {
                return $row->phone_number ?? 'N/A';
            })
            ->addColumn('email', function ($row) {
                return $row->email ?? 'N/A';
            })
            ->addColumn('total_payment', function ($row) {
                $this->setRawColumns('total_payment');
                if ( ! $row->member_payment ) {
                    return '<span class="badge bg-label-danger">'.default_currency(0.0).'</span>';
                }

                if ($row->scholarID) {
                    return '<span class="badge bg-label-info"><b>Scholarshp</b><br />'.$row->remarks.'</span>';
                }

                return '<span class="badge bg-label-primary">'.default_currency($row->member_payment).'</span>';
            })
            ->addColumn('batch', function ($row) {
                return $row->batch_name ?? 'Batch N/A';
            })
            ->addColumn('section', function ($row) {
                return $row->section_name ?? 'Section N/A';
            })
            ->addColumn('enrolled_date', function($row) {
                return date('Y-m-d',strtotime($row->enrolled_date));
            })
            ->addColumn('country',function($row){
                if ( ! $row->member_country &&  ! $row->country_name) {
                    return 'N/A';
                }
                if ($row->member_country && ! (int) $row->member_country) {
                    return $row->member_country;
                }

                return $row->country_name;

            })
            ->addColumn('full_address', function($row) {
                if ( ! $row->address) {
                    return 'N/A';
                }

                $addressDecode = json_decode($row->address);
                if ( isset($addressDecode->street_address) ) {
                    return $addressDecode->street_address;
                }

                if ( $row->personal_detail ) {
                    $detailDecode = json_decode($row->personal_detail);

                    if (isset($detailDecode->street_address) ) {
                        return $detailDecode->street_address;
                    }
                }

                return 'N/A';


            })
            ->addColumn('action', function ($row) {
                $action ='';
                return $action;
            });
        return $datatable->rawColumns($this->rawColumns)->make(true);
    }
}
