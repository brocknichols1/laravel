<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use seregazhuk\Favro\Api\Endpoints\Organizations;

class OrganizationController extends Controller
{

    function __construct()
    {
    }

    /**
     * Organizations for pagination
     * 
     * @return object
     */
    public function index()
    {
        $organizations = Organization::latest()->paginate(5);
        return response()->json(compact('organizations'));
    }

    /**
     * Get all Organizations
     * @return object
     */
    public function getOrganizations(): object
    {
        $organizations = Organization::all();
        return response()->json(compact('organizations'));
    }

    /**
     * 
     * @return view
     */
    public function create()
    {
        return view('organizations.create');
    }

    /**
     * 
     * @param Request $request
     * @return object
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'details' => 'required',
        ]);

        Organization::create($request->all());

        $status = ['success' => true, 'msg' => 'Organization created successfully'];
        return response()->json(compact('status'));

    }

    /**
     * 
     * @param Organization $organization
     * @return object
     */
    public function show(Organization $organization)
    {
        return response()->json(compact('organization'));

    }

    /**
     * Edit an Organization
     * 
     * @param Organization $organization
     * @return object
     */
    public function edit(Organization $organization)
    {
        return response()->json(compact('organization'));
    }

    /**
     * Update an Organization
     * 
     * @param Request $request
     * @param Organization $organization
     * @return object
     */
    public function update(Request $request, Organization $organization)
    {
        $organization = Organization::findOrFail($request->id);
        $organization->update($request->all());

        $status = ['success' => true, 'msg' => 'Organization updated successfully'];
        return response()->json(compact('status'));

    }

    /**
     * Delete an organization
     * 
     * @param int $id
     * @return object
     */
    public function delete(int $id)
    {
        Organization::find($id)->delete();

        $status = ['success' => true, 'msg' => 'Organization deleted successfully'];
        return response()->json(compact('status'));
    }
}
