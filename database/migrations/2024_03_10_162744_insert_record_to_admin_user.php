<?php

use App\Models\AdminUser;
use App\Models\Member;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $nonMember = Member::whereIn('role_id',[1,13,12])->get();
        
        foreach ($nonMember as $member) {
            // check if staff already exists.
            $staff = AdminUser::where('email',$member->email)->first();

            if (! $staff ) {
                $staff = new AdminUser();
                $staff->fill([
                    'firstname' => $member->first_name,
                    'lastname'  => $member->last_name,
                    'password'  => $member->password,
                    'role_id'   => $member->role_id,
                    'email'     => $member->email
                ]);

                if ($member->role_id == 1) {

                    $staff->is_super_admin = true;
                    $staff->tagline = 'Manager';

                } else { 
                    $staff->is_super_admin = false;
                }

                $staff->active = true;
                $staff->save();

            }

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_users', function (Blueprint $table) {
            //
        });
    }
};
