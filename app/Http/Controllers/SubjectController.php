<?php

namespace App\Http\Controllers;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    //
      /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $subjects = Subject::all();
        return view('subjects.index', [
            "subjects" => $subjects
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $action = route('subjects.store');
        return view('subjects.create', compact('action'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // return "This is a store function";
        $data = $request->validate([
            'name' => 'required|unique:subjects|max:50|min:5'
        ]);

        Subject::create($data);

          // Redirect to the courses.index page
          return redirect()->route('subjects.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return [
            [
                "id"=>"1",
                "name" => "Laravel",   
            ]
        ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        //
        return view('subjects.edit', ["subject" => $subject]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $data = $request->validate([
            'name' => 'required|unique:subjects,name,' . $subject->id . '|max:150|min:4'
        ]);
    
        $subject->update($data);
    
        return redirect()->route('subjects.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
