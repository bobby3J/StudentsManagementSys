<?php
namespace App\Http\Controllers;


use App\Mail\AdmissionEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Validation\Rule;
class StudentController extends Controller
{
    public function index()
    {

        $search = request()->query('search');
       
        if($search){
            $search = "%$search%";
            $students = Student::where('firstname', 'like', $search)
            ->orWhere('lastname',  'like', $search)
            ->orWhere('lastname', 'like', $search)
            ->orWhere('email', 'like', $search)
            ->orderBy('firstname', 'asc')
            ->paginate(15);
            // ->toSql()

        }else{
            $students = Student::orderBy('firstname', 'asc')->simplePaginate(5);
        }
        
        // return $students;

        return view('students.index', [
            "students" => $students
        ]);
    }

    public function show()
    {
        return [
            [
                "name" => "Ama",
                "age" => 20,
                "DOB" => "21st July, 2004"
            ]
        ];
    }

    public function create()
    {
        $courses = Course::all(['id', 'name'])->map(function ($course) {
            return [
                'value' => $course->id,
                'label' => $course->name
            ];
        });

        return view('students.create', ['courses' => $courses]);
    }

    public function store(Request $request)
    {
       
        $validator = $this->getValidationRules();
        $data = $request->validate($validator['rules'], $validator['messages'], $validator['attributes']);

        if($request->hasFile('image')){
            $data['image'] = $request->image->store('images');
        };
            
          Student::create($data);
        // return $student;

        //   Mail::to($student->email)->send(new AdmissionEmail($student));

        // dd($data);
        return redirect()->route('students.index')->with('alertMessage', "Student {$data['firstname']} added successfully");

    }

    public function edit(Student $student)
    {
        $courses = Course::all(['id', 'name'])->map(function ($course) {
            return [
                'value' => $course->id,
                'label' => $course->name
            ];
        });

        return view('students.edit', [
            'student' => $student,
            'courses' => $courses
        ]);
    }

    public function update(Request $request, Student $student)
    {
       $validator = $this->getValidationRules($student->id);
       $data = $request->validate($validator['rules'],$validator['messages'],$validator['attributes']);

       if($request->hasFile('image')){
        $data['image'] = $request->image->store('images');
       }

        $student->update($data);
        return redirect()->route('students.index')->with('alertMessage', "Student {$data['firstname']} edited successfully!");
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('alertMessage',
      "Student {$student->name} deleted successfully")->with('type', 'success');
    }

    private function getValidationRules($studentId = null){
        $rules = [
            'firstname' => 'required|min:3|max:50',
            'lastname' => 'required|max:100|min:3',
            'email' => ['required','email','max:150'],
            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'image' => 'sometimes|image|max:1024',
            'course_id' => 'required|exists:courses,id',
        ];

        if($studentId != null){
            $rules['email'][] = Rule::unique('students')->ignore($studentId);
        } else {
            $rules['email'][] = 'unique:students';
            $rules['student_id'][] = 'unique:students';
        }
        $messages=[
            
                'required' => 'Please enter a value for :attribute',
                'gender.required' => 'Please select a gender',
                'course_id.required' => 'Please select a course',
                'image' => 'You can only upload an image'
            
        ];
        $attributes=[
             'dob' => 'date of birth'
        ];
        return [ 'rules' => $rules, 'messages' => $messages, 'attributes' => $attributes];
    }
    
}



































































    // Display a listing of the students
//    public function index(){
//     return [
//         [
//             "name" => "Kofi",
//             "class" => 10,
//             "id" => 10001
//         ],
//         [
//             "name" => "Ama",
//             "class" => 10,
//             "id" => 10002
//         ],
//     ];
//    }

//    // Display the specified student
//    public function show($id){
//     // List of students
//     $student = [
//       1001 => [ "name" => "Kofi",
//         "class" => 10,
//         "id" => 10001
//       ],
//       1002 => [ "name" => "Ama",
//         "class" => 10,
//         "id" => 10002
//       ],
//     ];

//     // Check if the student exists
//     if(array_key_exists($id, $student)){
//         return $student[$id];
//     }else{
//         return response()->json(['error'=> 'Student not found'], 404);
//     }
   
//    }

//    // Show the form for creating a new student
//    public function create(){
//     $storeUrl = route('students.store');

//     return 
//     '<form method="post" action="'.$storeUrl.'" >
//         <input type="text" name="name" id="" placeholder="Enter name">
//         <br>
//         <input type="text" name="class" id="" placeholder="Enter class">
//         <br>
//         <input type="hidden" name="_token" value="'. csrf_token() .'" />
//          <input type="hidden" name="_token" value="PATCH" />
//         <input type="submit" value="Submit">
//     </form>';
//    }

//    // Store a newly created student in storage
//    public function store(Request $request){
//     // Return the submitted data
//     return "Stored student with name: ".$request->input('name'). " and class: ".$request->input('class');
//    }

//     // Show the form for editing the specified student.
//      public function edit($id)
//     {
//         // List of students
//         $students = [
//             10001 => [
//                 "name" => "Kofi",
//                 "class" => 10,
//                 "id" => 10001
//             ],
//             10002 => [
//                 "name" => "Ama",
//                 "class" => 10,
//                 "id" => 10002
//             ],
//         ];

//         if (array_key_exists($id, $students)) {
//             $student = $students[$id];
//             $updateUrl = route('students.update', $id);

//             return 
//             '<form method="post" action="' . $updateUrl . '" >
//                 <input type="text" name="name" value="' . $student['name'] . '" placeholder="Enter name">
//                 <br>
//                 <input type="text" name="class" value="' . $student['class'] . '" placeholder="Enter class">
//                 <br>
//                 <input type="hidden" name="_token" value="' . csrf_token() . '" />
//                 <input type="hidden" name="_method" value="PATCH" />
//                 <input type="submit" value="Update">
//             </form>';
//         } else {
//             return response()->json(['error' => 'Student not found'], 404);
//         }
//     }

//     // Update the specified student in storage.
//     public function update(Request $request, $id)
//     {
//         // List of students
//         $students = [
//             10001 => [
//                 "name" => "Kofi",
//                 "class" => 10,
//                 "id" => 10001
//             ],
//             10002 => [
//                 "name" => "Ama",
//                 "class" => 10,
//                 "id" => 10002
//             ],
//         ];

//         if (array_key_exists($id, $students)) {
//             $students[$id]['name'] = $request->input('name');
//             $students[$id]['class'] = $request->input('class');

//             return "Updated student with ID: $id to name: " . $students[$id]['name'] . " and class: " . $students[$id]['class'];
//         } else {
//             return response()->json(['error' => 'Student not found'], 404);
//         }
//     }

//   // Remove the specified student from storage
//   public function destroy($id)
// {
//     // List of students
//     $students = [
//         10001 => [
//             "name" => "Kofi",
//             "class" => 10,
//             "id" => 10001
//         ],
//         10002 => [
//             "name" => "Ama",
//             "class" => 10,
//             "id" => 10002
//         ],
//     ];

//     if (array_key_exists($id, $students)) {
//         unset($students[$id]);
//         return "Deleted student with ID: $id";
//     } else {
//         return response()->json(['error' => 'Student not found'], 404);
//     }
// }




















    // public function sayHello(){
    //     return "Hello from the student controller class";
    // }

    // public function sayHi(){
    //     return "Hi dear student from the controller class";
    // }

    // public function studentDetails(){
    //     return "<h1>Student: Abi</h1>";
    // }

    // public function index(){
    //     return [
    //         [
    //           "name" => "Bobs",
    //           "age" => 20,
    //           "DOB" => "20th July, 2004"
    //         ],

    //         [
    //          "name" => "Ama",
    //          "age" => 20,
    //          "DOB" => "21st July, 2004"
    //         ]
    //         ];
    // }

    // public function show(){
    //     return [
    //         [
    //             "name" => "Ama",
    //             "age" => 20,
    //             "DOB" => "21st July, 2004"   
    //         ]
    //     ];
    // }


    // public function create(){
    //     $storeUrl = route('students.update', ["id"=>1]);

    //     return 
    //     '<form method="post" action="'.$storeUrl.'">
    //         <input type="text" name="name" id="" placeholder="Enter name">
    //         <br>
    //         <input type="text" name="class" id="" placeholder="Enter class">

    //   <input type="hidden" name="_token" value="'. csrf_token() .'" />
    // <input type="hidden" name="_token" value="PATCH" />
    //         <br>
    //         <input type="submit" value="Submit">
    //     </form>';
    // }

    // public function store(){
    //     return "This is a store function";
    // }

    // public function edit(){
    //     return "This is an edit function";
    // }
    
    // public function update(){
    //     return "This is an update function";
    // }

    
