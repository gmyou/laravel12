<?php

namespace App\Http\Controllers;

use App\Models\IpgServer;
use Illuminate\Http\Request;

class IpgServerController extends Controller
{
    //
    public function index(Request $request)
    {
        $page = $request->input('page', 1); // Get the current page from the request, default to 1
        $perPage = 5; // Number of IPG servers per page

        $ipgServers = IpgServer::simplePaginate($perPage); // Fetch IPG servers with pagination
        return view('admin.ipgserver.index', compact('ipgServers'));
    }

    public function show($id)
    {
        // Logic to retrieve and return a specific IPG server by ID
    }

    public function create(Request $request)
    {
        // Logic to create a new IPG server
    }

    public function update(Request $request, $id)
    {
        // Logic to update an existing IPG server by ID
    }

    public function delete($id)
    {
        // Logic to delete an IPG server by ID
    }
}
