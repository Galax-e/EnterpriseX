<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use Auth;
use DB;
class OrganizationController extends Controller
{
    //

    public function index() {

        // all organizations where user is owner or member
        $user_orgs = Auth::user()->user_organizations();
        return view('organizations.index', compact('user_orgs'));
    }

    public function organization(Organization $org) {
        
        return view('organizations.organization', compact('org'));
    }

    public function clients() {

        // all clients that belong to user organizations
        // use the view to filter who can access the client model
        // to reduce the logic here.
        $user_org_clients = Auth::user()->organization->clients;
        return view('organizations.clients.index', compact($user_org_clients));
    }

    public function create_organization(Request $request)
    {

        $country_obj = country()->all();

        // "AC,IC,EA,DG,TA"
        unset($country_obj['AC']);
        unset($country_obj['IC']);
        unset($country_obj['EA']);
        unset($country_obj['DG']);
        unset($country_obj['TA']);

        $countries_codes = array_keys($country_obj);
        $country_names = array_values($country_obj);
        //dd($countries_codes);
        // https://github.com/Propaganistas/Laravel-Phone
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => Rule::country($country_names),
            'phone_number' => Rule::phone()->country($countries_codes),
        ]);
        
        $organization = Organization::create($request->except('_token'))->fresh();
       
        // $zip = $request->input('zip');
        // $organization->zip = isset($zip) ?  $zip: null; 
        // $desc= $request->input('description');
        // $organization->description = isset($desc) ?  $desc: null; 
        // $industry = $request->input('industry');
        // $organization->industry = isset($industry) ?  $industry: null; 
        
        $organization->user_id = Auth::user()->id;
        $organization->save();
        dd($organization);
        // $organization->country = $request->country
        Auth::user()->assignRole('owner');

        return redirect()->back()->with('message', 'Your organization created');
    }

    public function create_client(Request $request) {

        $country_obj = country()->all();
        // "AC,IC,EA,DG,TA"
        unset($country_obj['AC']);
        unset($country_obj['IC']);
        unset($country_obj['EA']);
        unset($country_obj['DG']);
        unset($country_obj['TA']);

        $countries_codes = array_keys($country_obj);
        $country_names = array_values($country_obj);

        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => Rule::country($country_names),
            'phone_number' => Rule::phone()->country($countries_codes),
        ]);

        $client = Client::create($request->except('_token'))->fresh();

        $client->organization_id = Auth::user()->organization()->id;
        $client->save();
        dd($client);
        // $client->country = $request->country
        Auth::user()->assignRole('client');
        return redirect()->back()->with('message', 'New client created');
    }

    public function create_team_member(Request $request) {

        $this->validate($request, [
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
        ]);
    }
}
