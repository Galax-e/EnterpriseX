<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

// use Spatie\Permission\Models\Role;
//use Spatie\Permission\Models\Permission;

use Backpack\PermissionManager\app\Models\Role;
use Backpack\PermissionManager\app\Models\Permission;

use App\Models\Team;
use App\Models\Project;
use App\Models\Organization;
use App\User;
use App\Member;
use App\TeamMember;

use Faker\Generator as Faker;
use Faker\Factory as Factory;

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
        $user2->assignRole('admin');
        // $user2->assignRole('owner');

        // DB::table('users')
        //     ->where('id', 1)
        //     ->update(['password' => bcrypt('Password1')]);
        
        $this->createFakeUsers();
        $this->createFakeOrganizations();
        $this->createFakeClients();
        $this->createFakeProjects();
        $this->createFakeMembers();
        $this->createFakeTeams();
        $this->createFakeTeamMembers();
        $this->command->info('Production seeding successful');
        
    }

    protected function createFakeUsers() {
        $users = factory(App\User::class, 150)
           ->create()
           ->each(function ($u) {
                $u->assignRole('user'); //posts()->save(factory(App\Post::class)->make());
            });        
    }
    protected function createFakeOrganizations() {
        // $organizations = factory(App\Models\Organization::class, 7)->create()
        //    ->each(function ($o) {
        //        $user = User::find($o->user_id);
        //        if (! $user->hasROle('owner')) {
            //      $user->assignRole('owner');
        //  }
        //         // $o->user()->where()assignRole('owner'); //posts()->save(factory(App\Post::class)->make());
        //     }); 

        $faker = Factory::create();
        $users = User::all()->pluck('id')->toArray();

        foreach (range(1, 8) as $index) {
            $o = Organization::create([
                'name' => $faker->company,
                'user_id' => $faker->unique()->randomElement($users), //->numberBetween(3, 150),
                'address' => $faker->streetAddress,
                'city' => $faker->city,
                'state' => $faker->state,
                'country' => $faker->country,
                'number_of_staff' => 1,
                'phone_number' => $faker->e164PhoneNumber,
                'description' => $faker->sentence(10, true),
            ]);            
            $user = User::find($o->user_id);

            if (!$user->hasRole('owner')) {
                $user->assignRole('owner');
            }
             // Reset
             $faker->unique(true);
        }


    }
    protected function createFakeClients() {
        $clients = factory(App\Models\Client::class, 25)->create();
    }

    protected function createFakeProjects() {
        $clients = factory(App\Models\Project::class, 50)->create();
    }
    
    protected function createFakeMembers() {
        $members = factory(App\Member::class, 120)
            ->create()
            ->each(function ($m) {
                if ($m->client_id === 0) {
                    $m->client_id = null;
                    $m->type = 'organization';
                }
                else {
                    $m->type = 'client';
                }                
                $m->save();

                $user = User::find($m->user_id);

                if (!$user->hasRole('member')) {
                    $user->assignRole('member');
                }
            }); 
    }

    protected function createFakeTeams() {

        // $team_count = 0;
        // $teams = factory(App\Models\Team::class, 100)
        //     ->create()
        //     ->each(function ($t, $k) {
        //         if ($k % 3 === 0) {
        //             $t->type = 'client';
        //         }
        //         else {
        //             $t->type = 'organization';
        //         }                
        //         $t->save();
        //     }); 

        $faker = Factory::create();
        $projects = Project::all()->pluck('id')->toArray();
    
        foreach (range(1, 100) as $index) {
    
            $team = Team::create([
                'name' => $faker->text(20),
                'project_id' => $faker->randomElement($projects)
            ]);

            if ($index % 2 === 0) {
                $team->type = 'client';
            }else{
                $team->type = 'organization';
            }
            $team->save();
            // Reset
            $faker->unique(true);
        }
    }

    protected function createFakeTeamMembers() {

        // $teams = factory(App\Models\Team::class, 100)->create();

        $faker = Factory::create();
        $members = Member::all()->pluck('id')->toArray();
        $teams = Team::all()->pluck('id')->toArray();
    
        foreach (range(1,500) as $index) {
    
            TeamMember::create([
                'member_id' => $faker->randomElement($members),
                'team_id'  => $faker->randomElement($teams)
            ]);
    
             // Reset
             $faker->unique(true);
        }
    }

    protected function createRolesAndPermissions() {

        $roles=[
            'admin' => ['Administrator', 'Administrator has no restriction'],
            'user' => ['User', 'Authenticated user'],
			'owner' => ['Owner', 'Owner of the organization'],            
            'client' => ['Client', 'Client to the owner'],
            'manager' => ['Manager', 'Can create organization team members, manage team task boards, and team chat rooms'],
            'client-manager' => ['Client Manager', 'Manages client process e.g. teams, issue boards, emails, chats, calls etc.'],
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
            'team-manager'=>['admin', 'owner', 'client', 'manager', 'client-manager'],
			'organization-manager'=>['admin'],
            'client-manager'=>['admin', 'owner'],
            'project-manager'=>['admin', 'owner', 'client'],
            'board-manager'=>['admin', 'owner', 'client', 'manager', 'client-manager'],
            'board'=>['admin', 'owner', 'client', 'manager', 'client-manager', 'member'],

            'task-manager' => ['admin', 'owner', 'manager'],
            'issue-manager' => ['admin', 'owner', 'client', 'client-manager'],
            // chat, call and video
            'chat'=>['admin', 'owner', 'client', 'manager', 'client-manager', 'member'],
            'chat-room-manager'=>['admin', 'owner', 'client', 'manager', 'client-manager'],
            'voice-call'=>['admin', 'owner', 'client', 'manager', 'client-manager', 'member'],
            'video-call'=>['admin', 'owner', 'client', 'manager', 'client-manager', 'member'],
            'voice-call-manager'=>['admin', 'owner'],
            'video-call-manager'=>['admin', 'owner'],
            // email and profile
            'email'=>['admin', 'owner', 'client', 'manager', 'client-manager', 'member'],
            'profile'=>['admin', 'owner', 'client', 'manager', 'client-manager', 'member']
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
