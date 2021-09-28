<?php 

namespace App\Helpers;
use Illuminate\Support\Facades\Auth;

class UserGuard {

    protected $_user = null;

    public function is_admin(){
        if (auth()->check() && ( auth()->user()->userRole->role_name = "Admin" || auth()->user()->userRole == "Super Admin")){
            return $this->_user = auth()->user();
        }
        return null;
    }
    
    public function is_center_admin(){

    }

    public function is_client(){

    }

    public function is_user() {

    }
}

?>