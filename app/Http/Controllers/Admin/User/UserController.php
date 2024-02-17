<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\AdminUserLoginRequest;
use App\Models\AdminUser;
use App\Models\Centers;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function PHPSTORM_META\map;

class UserController extends Controller
{
    public function index() {
        $userStafs = AdminUser::get();
        return view('admin.users.index',['users' => $userStafs]);
    }

    public function create(Request $request, ?Centers $center) {
        if ( $request->post() ) {

            $request->validate([
                'firstname' => 'required|string',
                'lastname'  => 'required|string',
                'email' => 'required|email|string',
                'password'  => 'required',
            ]);

            $user = new AdminUser();

            $user->fill([
                'firstname' => $request->post('firstname'),
                'lastname' => $request->post('lastname'),
                'email' => $request->post('email'),
                'password' => Hash::make($request->post('password')),
                'tagline'   => $request->post('tagline'),
                'active'    => true,
                'is_super_admin'    => false,
                'role_id'  => $request->post('role')
            ]);

            if ($request->post('role') == 1 ) {
                $user->is_super_admin = true;
            }
            
            if ($request->post('center') || $center) {
                $user->center_id = $center->getKey() ?? $request->post('center');
            }

            if (AdminUser::where('email',$request->post('email'))->exists()) {
                return $this->json(false,'Email Already Exists.');
            }
            // store all 

            if( ! $user->save() ) {
                return $this->json(false,'Unable to create new user.');
            }
            $jsCallback = 'redirect';
            $params = [
                'location' => route('admin.users.list')
            ];

            if ($center->getKey() ) {
                $params['location'] = route('admin.centers.list',['center' =>  $center]);
            }

            return $this->json(true,'New User Created.',$jsCallback,$params);
        }
        return view('admin.users.create',['center' => $center]);
    }

    public function edit(Request $request, AdminUser $user, ?Centers $center) {

        if ( $request->post() ) {

            $request->validate([
                'firstname' => 'required|string',
                'lastname'  => 'required|string',
                'email' => 'required|email|string',
            ]);
            
            $user->fill([
                'firstname' => $request->post('firstname'),
                'lastname' => $request->post('lastname'),
                'email' => $request->post('email'),
                'tagline'   => $request->post('tagline'),
                'active'    => true,
                'is_super_admin'    => false,
                'role_id'   => $request->post('role')
            ]);
            
            if ($request->post('role') == 1 ) {
                $user->is_super_admin = true;
            }

            if ($request->post('password') ) {
                $user->password = Hash::make($request->post('password'));
            }

            if ($request->post('center') || $center) {
                $user->center_id = $center->getKey() ?? $request->post('center');
            }


            if (! $user->save() ) {
                return $this->json(false,'Unable to update user information.');
            }

            return $this->json(true,'User Information updated.');

        }

        return view('admin.users.edit',['user' => $user,'center'=> $center]);
    }
    
    public function delete(AdminUser $user, ?Centers $center) {

        if ( $center->getKey() ) {

            $user->center_id = null;
            
            if (! $user->save() ) {
                return $this->json('Unable to remove user.');
            }

            return $this->json(true,'User Deleted.','reload');

        }

        if (! $user->delete() ) {
            return $this->json(false,'Unable to remove user.');
        }

        return $this->json(true,'User Deleted.','reload');
    }

    //
    public function login(Request $request){
        return view('admin.users.login');
    }

    public function autheticate(AdminUserLoginRequest $request) {

        $request->authenticate();
        /**
         * @todo Implement Permission based navigation later.
         */

        if ( $request->ajax() ) {
            return $this->json(true,'Login Success.','redirect',['location' => route('admin.admin_dashboard')]);
        }
        return redirect()->route('admin.admin_dashboard');
    }

    public function modalUserList(Request $request, Centers $center) {
        
        $users = AdminUser::whereIn('id',$request->post('user_list'))->get();

        foreach ($users as $user) {
            // skip for users whose role does't match.
            if ( $user->role_id != Role::CENTER ||  ! is_null($user->center_id) ) {
                continue;
            }

            $user->center_id = $center->getKey();
            $user->save();

        }

        return $this->json(true,'User Added.','redirect',['location' => route('admin.centers.list',['center' => $center])]);
    }

    public function logout() {

        Auth::guard('admin')->logout();
        return $this->returnResponse(true,'You have been logged out.','redirect', ['location' => route('admin.users.login')],200,route('admin.users.login'));
    }
}
