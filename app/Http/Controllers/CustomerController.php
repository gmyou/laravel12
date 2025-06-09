<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //
    public function index(Request $request)
    {
        $page = $request->input('page', 1); // Get the current page from the request, default to 1
        $perPage = 5; // Number of customers per page

        $customers = Customer::simplePaginate($perPage); // Fetch customers with pagination
        return view('admin.customer.index', compact('customers'));
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
