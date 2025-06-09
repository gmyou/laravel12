<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //
    public function index()
    {
        // Logic to retrieve and return a list of customer
        return view('admin.customer.index');
    }
    public function show($id)
    {
        // Logic to retrieve and return a specific customer by ID
    }
    public function create(Request $request)
    {
        // Logic to create a new customer
    }
    public function update(Request $request, $id)
    {
        // Logic to update an existing customer by ID
    }
    public function delete($id)
    {
        // Logic to delete a customer by ID
    }
}
