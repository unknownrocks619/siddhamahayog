<?php

namespace App\Http\Controllers\Centers;

use App\Http\Controllers\Controller;
use App\Models\Centers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CenterMemberController extends Controller
{
    //

    public function index(?Centers $center)
    {

        $view = 'admin.centers.index';
        $centers = Centers::withCount('staffs')->get();
        $params = [];
        if ( $center->getKey() ) {

            $staffs = $center->staffs;
            $params = [
                'center'    => $center,
                'staffs'    => $staffs
            ];
            $view = 'admin.centers.staffs';

        } else {
            $params['centers'] = $centers;
        }

        return view($view,$params);
    }

    public function create(Request $request) {

        if ( $request->post() ) {

            $request->validate([
                'center_name' => 'required',
                'center_location'   => 'required',
                'center_email_address'  => 'required',
                'active'    => 'required|in:1,0'
            ]);

            $center = new Centers();
            $center->fill([
                'center_name'   => $request->post('center_name'),
                'center_location'   => $request->post('center_location'),
                'center_email_address'  => $request->post('center_email_address'),
                'active'    => $request->post('active')
            ]);

            if (! $center->save() ) {
                return $this->json(false,'Unable to create new center.');
            }

            return $this->json(true,'New Center Created.','redirect',['location' => route('admin.centers.edit',['center' => $center])]);
        }

        return view('admin.centers.create');
    }

    public function edit(Request $request, Centers $center) {

        if ( $request->post() ) {
            
            $request->validate([
                'center_name' => 'required',
                'center_location'   => 'required',
                'center_email_address'  => 'required',
                'active'    => 'required|in:1,0'
            ]);

            $center->fill([
                'center_name'   => $request->post('center_name'),
                'center_location'   => $request->post('center_location'),
                'center_email_address'  => $request->post('center_email_address'),
                'active'    => $request->post('active')
            ]);

            if (! $center->update() ) {
                return $this->json(false,'Unable to create new center.');
            }

            return $this->json(true,'Center Information Updated.');
        }
        
        return view('admin.centers.edit',['center' => $center]);
    }


    public function delete(Centers $center) {
        try {

            DB::transaction(function() use ($center) {
                $center->staffs()->update(['center_id'=>null]);
                $center->delete();
            });
        } catch(Exception $ex) {
            return $this->json(false,'Unable to delete center.');
        }

        return $this->json(true,'Center information has been deleted.','reload');

    }
}
