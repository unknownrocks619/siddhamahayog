<?php

namespace App\Observers;
use App\Models\SibirRecord;
use Illuminate\Support\Str;
use App\Models\SibirBranche;
use App\Models\Center;

class SibirRecordObserver
{
    //

    public function created(SibirRecord $sibirRecord) 
    {
        $sibirRecord->slug = Str::slug($sibirRecord->sibir_title);
        /**
         * loop through all branches
         */
        $all_centers = Center::get();
        $sibir_branch_record = [];
        foreach ($all_centers as $center) {
            $inner_array = [];
            $inner_array["branch_id"] = $center->id;
            $inner_array["sibir_record_id"] = $sibirRecord->id;
            $inner_array["capacity"] = $sibirRecord->total_capacity;
            $inner_array["active"] = ($sibirRecord->active) ? true : false;
            $sibir_branch_record[] = $inner_array;
        }
        // dd($sibir_branch_record);
        SibirBranche::insert($sibir_branch_record);
        $sibirRecord->saveQuietly();
    }

    public function updated(SibirRecord $sibirRecord)
    {   
            if ($sibirRecord->start_date && $sibirRecord->end_date){
                // lets calculate total duration
                $from_date_carbon = new \DateTime($sibirRecord->start_date);
                $end_date_carbon = new \DateTime($sibirRecord->end_end);
                $interval = $from_date_carbon->diff($end_date_carbon);
                $days = $interval->format('%a');
                $sibirRecord->sibir_duration = $days;
                if ($sibirRecord->isDirty()) {
                    $sibirRecord->saveQuietly();
                }
            }

            if (request()->branch && request()->branch_capacity) {
                $sibirRecord->delete_all_branches();
                // now let's create new record.
                $all_branch_record = [];
                foreach (request()->branch as $branches ) {
                    // all related branches
                    $innerArray = [];
                    if (array_key_exists($branches,request()->branch_capacity) ) {
                        $innerArray['sibir_record_id'] = $sibirRecord->id;
                        $innerArray['branch_id'] = $branches;
                        $innerArray['capacity'] = request()->branch_capacity[$branches][0];
                        $innerArray['created_at'] = \Carbon\Carbon::now();
                        if ( $sibirRecord->active ) {
                            $innerArray["active"] = $sibirRecord->active;
                        }
                        $all_branch_record[] = $innerArray;
                    }
                }
                SibirBranche::insert($all_branch_record);    
            }    
    }

    public function deleted(SibirRecord $sibir) {
        
        foreach ($sibir->branches as $branch) {
            $branch->active = false;
            if ($branch->isDirty('active')){
                $branch->save();
            }
        }
        $sibir->active = false;
        $sibir->save();
        $sibir->restore();
    }
}
