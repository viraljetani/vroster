<?php

namespace App\Http\Controllers;

use App\Employee;
use Inertia\Inertia;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class EmployeesController extends Controller
{
    public function index()
    {
        return Inertia::render('Employees/Index', [
            'filters' => Request::all('search', 'trashed'),
            'employees' => Auth::user()->account->employees()
                ->with('organization')
                ->orderByName()
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->transform(function ($employees) {
                    return [
                        'id' => $employees->id,
                        'name' => $employees->name,
                        'phone' => $employees->phone,
                        'city' => $employees->city,
                        'deleted_at' => $employees->deleted_at,
                        'organization' => $employees->organization ? $employees->organization->only('name') : null,
                    ];
                }),
        ]);
    }

    public function create()
    {
        return Inertia::render('Employees/Create', [
            'organizations' => Auth::user()->account
                ->organizations()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
        ]);
    }

    public function store()
    {
        Auth::user()->account->employees()->create(
            Request::validate([
                'first_name' => ['required', 'max:50'],
                'last_name' => ['required', 'max:50'],
                'organization_id' => ['nullable', Rule::exists('organizations', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'email' => ['nullable', 'max:50', 'email'],
                'phone' => ['nullable', 'max:50'],
                'address' => ['nullable', 'max:150'],
                'city' => ['nullable', 'max:50'],
                'region' => ['nullable', 'max:50'],
                'country' => ['nullable', 'max:2'],
                'postal_code' => ['nullable', 'max:25'],
            ])
        );

        return Redirect::route('employees')->with('success', 'Employee created.');
    }

    public function edit(Employee $employee)
    {
        return Inertia::render('Employees/Edit', [
            'employee' => [
                'id' => $employee->id,
                'first_name' => $employee->first_name,
                'last_name' => $employee->last_name,
                'organization_id' => $employee->organization_id,
                'email' => $employee->email,
                'phone' => $employee->phone,
                'address' => $employee->address,
                'city' => $employee->city,
                'region' => $employee->region,
                'country' => $employee->country,
                'postal_code' => $employee->postal_code,
                'deleted_at' => $employee->deleted_at,
            ],
            'organizations' => Auth::user()->account->organizations()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
        ]);
    }

    public function update(Employee $employee)
    {
        $employee->update(
            Request::validate([
                'first_name' => ['required', 'max:50'],
                'last_name' => ['required', 'max:50'],
                'organization_id' => ['nullable', Rule::exists('organizations', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'email' => ['nullable', 'max:50', 'email'],
                'phone' => ['nullable', 'max:50'],
                'address' => ['nullable', 'max:150'],
                'city' => ['nullable', 'max:50'],
                'region' => ['nullable', 'max:50'],
                'country' => ['nullable', 'max:2'],
                'postal_code' => ['nullable', 'max:25'],
            ])
        );

        return Redirect::back()->with('success', 'Employee updated.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return Redirect::back()->with('success', 'Employee deleted.');
    }

    public function restore(Employee $employee)
    {
        $employee->restore();

        return Redirect::back()->with('success', 'Employee restored.');
    }
}
