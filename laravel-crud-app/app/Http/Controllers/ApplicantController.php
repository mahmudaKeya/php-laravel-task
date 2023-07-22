<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applicants = Applicant::latest()->paginate(5);

        return view('applicants.index',compact('applicants'))
            ->with(request()->input('page'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('applicants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'mobile_number' => 'required|string',
        'previous_institution' => 'required|string',
        'date_of_birth' => 'required|date',
    ]);

    // Generate a UUID
    $uuid = Str::uuid();

    // Create the applicant and set the UUID along with other attributes
    Applicant::create([
        // 'uuid' => $uuid,

        'name' => $request->input('name'),
        'mobile_number' => $request->input('mobile_number'),
        'previous_institution' => $request->input('previous_institution'),
        'date_of_birth' => $request->input('date_of_birth'),
    ]);

    return redirect()->route('applicants.index')
                    ->with('success', 'Applicant created successfully.');
}


    /**
     * Display the specified resource.
     */
    public function show(Applicant $applicant)
    {
        return view('applicants.show',compact('applicant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Applicant $applicant)
    {
        return view('applicants.edit',compact('applicant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Applicant $applicant)
{
    $request->validate([
        'name' => 'required|string',
        'mobile_number' => 'required|string',
        'previous_institution' => 'required|string',
        'date_of_birth' => 'required|date',
    ]);

    // Update the attributes of the specific $applicant instance
    $applicant->update([
        'name' => $request->input('name'),
        'mobile_number' => $request->input('mobile_number'),
        'previous_institution' => $request->input('previous_institution'),
        'date_of_birth' => $request->input('date_of_birth'),
    ]);

    return redirect()->route('applicants.index')
                     ->with('success', 'Applicant updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Applicant $applicant)
    {
        $applicant->delete();

        return redirect()->route('applicants.index')
                        ->with('success','Product deleted successfully');
    }


    public function search(Request $request)
{
    $query = $request->input('q');
    $applicants = Applicant::where('name', 'LIKE', '%' . $query . '%')
                          ->orWhere('id', $query)
                          ->get();

    return view('applicants.index', compact('applicants'));
}

}

