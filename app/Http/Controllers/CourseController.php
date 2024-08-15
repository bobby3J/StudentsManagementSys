<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
       if(Auth::user()->role=== 'superadmin'){
        $courses = Course::withTrashed()->simplePaginate(10);
       }else{
        $courses = Course::simplePaginate(10);
       }

        // $courses = Course::all();
        return view('courses.index',[
           "courses" => $courses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        $subjects = Subject::all();

        return view('courses.create', [
            "course" => new Course,
            "subjects" => $subjects
        ]);

     }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // return "This is a store function";
        $data = $request->validate([
            'name' => 'required|unique:courses|max:50|min:5',
            'subject_id' => 'required|array',
            'subject_id.*' => 'exists:subjects,id'
        ]);

        // dd($data);
        
        // method1 using save()
        // $newCourse = new Course;
        // $newCourse->name = $data['name'];
        // $newCourse->save();

        $course = Course::create($data);

       
        // Redirect to the courses.index page
        $course->subjects()->sync($data['subject_id']);
        return redirect()->route('courses.index');
         
        
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
                "name" => "DBC",   
            ]
        ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
        $subjects = Subject::all();
        return view('courses.edit',[ "course" => $course, 'subjects' => $subjects]);
    }

    /**
     * Update the specified resource in storage.
     */

     public function update(Request $request, Course $course)
{
    $data = $request->validate([
        'name' => "required|unique:courses,id,{$course->id}|max:150|min:4",
        'subject_id' => 'required|array',
       'subject_id.*' => 'exists:subjects,id'
    ]);

    $course->update($data);
    $course->subjects()->sync($data['subject_id']);

    return redirect()->route('courses.index');
}

public function destroy(string $id)
{
    //
    $course = Course::withTrashed()->find($id);
    
    if($course->trashed()){
        $course->subjects()->sync([]);
        $course->forceDelete();
    }else{
        $course->delete();
    }
    return redirect()->route('courses.index')
    ->with('alertMessage', "Course {$course->name} deleted successfully")->with('type', 'success');
}

  
}