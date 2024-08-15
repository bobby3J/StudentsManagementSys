<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Validation\Rule;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::all();
        return view('users.index',[
           "users" => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $action = route('users.store');
        return view('users.create', compact('action'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = $this->getValidationRules();
        $data = $request->validate($validator['rules'], $validator['messages'], $validator['attributes']);
        User::create($data);
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Retrieve the user by ID
        $user = User::findOrFail($id);
    
        // Return the view with the user data
        return view('users.show', compact('user'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
        // $action = route('users.update', $user);
        // return view('users.edit', compact('user', 'action'));
        return view('users.edit', ["user" => $user]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
        $validator = $this->getValidationRules($user->id);
       $data = $request->validate($validator['rules'],$validator['messages'],$validator['attributes']);
        $user->update($data);
         
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            // Remove password from the $data array so it won't overwrite the existing hashed password
            unset($data['password']);
        }


        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
        $user->delete();
        return redirect()->route('users.index')->with('alertMessage', "User {$user->fullname} deleted successfully")->with('type', 'success');
    }
    

    private function getValidationRules($userId = null){
        $rules = [
           'fullname' => 'required|regex:/^[\pL\s]+$/u|min:5|max:255',
           'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($userId),
            ],
            'role' => 'required|string|in:admin,superadmin',          
        ];

        if ($userId != null) {
            $rules['email'] = [
                'required',
                'email',
                Rule::unique('users')->ignore($userId),
            ];
        } else {
            $rules['email'] = [
                'required',
                'email',
                'unique:users',
            ];
            $rules['password'] = 'required|max:255|min:8|confirmed';
            $rules['password_confirmation'] = 'required';
        }
        
        
        $messages=[
            
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'fullname.regex' => 'Fullname must contain only alphabets and spaces'
                // 'required' => 'Please enter a value for :attribute',
                // 'gender.required' => 'Please select a gender',
                // 'course_id.required' => 'Please select a course'
            
        ];
        $attributes=[
            //  'dob' => 'date of birth'
        ];
        return [ 'rules' => $rules, 'messages' => $messages, 'attributes' => $attributes];
    }
}
