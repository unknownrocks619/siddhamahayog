<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\AdminUserLoginRequest;
use App\Models\AdminUser;
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

    public function create(Request $request) {
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
                'is_super_admin'    => false
            ]);

            if ($request->post('role') == 1 ) {
                $user->is_super_admin = true;
            }

            // store all 

            dd($user->toArray(),$request->all());
            if( ! $user->save() ) {

                return $this->json(false,'Unable to create new user.');
            }

            return $this->json(true,'New User Created.','redirect',['location' => route('admin.users.list')]);
        }
        return view('admin.users.create');
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
}
