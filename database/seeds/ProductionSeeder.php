<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

// use Spatie\Permission\Models\Role;
//use Spatie\Permission\Models\Permission;

use Backpack\PermissionManager\app\Models\Role;
use Backpack\PermissionManager\app\Models\Permission;

use App\Models\Team;
use App\Models\Project;
use App\User;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // create roles and permissions
        $this->createRolesAndPermissions();

        $user1 = User::create([
            'name'   => 'Super Admin',
            'username' => 'superadmin',
            'email'    => 'nwaughac@gmail.com',
            'password' => bcrypt('Password1'),
            'active' => 1,
            // 'role' => 'admin'
        ]);
        $user1->assignRole('admin');  

        $user2 = User::create([
            'name'   => 'Super User',
            'username' => 'superuser',
            'email'    => 'admin@admin.com',
            'password' => bcrypt('Password1'),
            'active' => 1,
            // 'role' => 'admin'
        ]);
        $user2->assignRole('owner');
        // DB::table('users')
        //     ->where('id', 1)
        //     ->update(['password' => bcrypt('Password1')]);
    }
    public function createRolesAndPermissions() {

        $roles=[
            'admin' => ['Administrator', 'Administrator has no restriction'],
            'user' => ['User', 'Authenticated user'],
			'owner' => ['Owner', 'Owner of the organization'],            
            'client' => ['Client', 'Client to the owner'],
            'manager' => ['Manager', 'Can create team members, manage team issues & task boards, and team chat rooms'],
            'member' => ['Member', 'Authenticated user who is a team member'],
            'registry' => ['Registry', 'Can upload and manage files in the system'],
		];
		$permissions=[
			'dashboard'=>['admin', 'user', 'owner', 'client'],
			'file-manager'=>['admin', 'owner', 'client', 'registry'],
			'langfile-manager'=>['admin'],
			'backup-manager'=>['admin'],
			'log-manager'=>['admin'],
			'settings'=>['admin'],
			'page-manager'=>['admin'],
			'permission-manager'=>['admin'],
            'menu-crud'=>['admin'],
             // custom permissions
            'team-manager'=>['admin', 'owner', 'client', 'manager'],
			'organization-manager'=>['admin'],
            'client-manager'=>['admin', 'owner'],
            'project-manager'=>['admin', 'owner', 'client'],
            'board-manager'=>['admin', 'owner', 'client', 'manager'],
            'board'=>['admin', 'owner', 'client', 'manager', 'member'],
            'chat'=>['admin', 'owner', 'client', 'manager', 'member'],
            'chat-room-manager'=>['admin', 'owner', 'client', 'manager'],
            'voice-call'=>['admin', 'owner', 'client', 'manager', 'member'],
            'video-call'=>['admin', 'owner', 'client', 'manager', 'member'],
            'voice-call-manager'=>['admin', 'owner'],
            'video-call-manager'=>['admin', 'owner'],
            'email'=>['admin', 'owner', 'client', 'manager', 'member'],
            'profile'=>['admin', 'owner', 'client', 'manager', 'member']
		];
		//create roles
		foreach ($roles as $role => $role_prop) {
            $rolesArray[$role]=Role::create(['name' => $role, 'display_name' => $role_prop[0],
                                            'description' => $role_prop[1]]);
		}
		//create permissions
		foreach ($permissions as $permission=>$authorized_roles) {
			//create permission
			Permission::create(['name' => $permission]);
			
			//authorize roles to those permissions
			foreach ($authorized_roles as $role) {
				$rolesArray[$role]->givePermissionTo($permission);
			}
		}

    }
}
