
<!-- resources/views/students/form.blade.php -->


<form class="container-sm" action="{{ $action }}" method="POST" enctype="multipart/form-data">
    <div class="row g-3">
        <div class="col">
            <x-textfield name="firstname" label="Firstname" type="text" placeholder="Enter student firstname" :value="old('firstname', $student->firstname ?? '')" />
        </div>
        <div class="col">
            <x-textfield name="lastname" label="Lastname" type="text" placeholder="Enter student lastname" :value="old('lastname', $student->lastname ?? '')" />
        </div>
    </div>
    <div class="row g-3">
        <div class="col">
            <x-textfield name="student_id" label="Student ID" type="text" placeholder="Enter student ID" :value="old('student_id', $student->student_id ?? '')" />
        </div>
        <div class="col">
            <x-textfield name="email" label="Student Email" type="email" placeholder="Enter student email" :value="old('email', $student->email ?? '')" />
        </div>
    </div>

    @php
        $gender = [
            ['value' => 'Male', 'label' => 'Male'],
            ['value' => 'Female', 'label' => 'Female'],
        ];
    @endphp

    <x-selectfield :options="$gender" name="gender" label="Select Gender" :value="old('gender', $student->gender ?? '')" />
    <x-selectfield :options="$courses" name="course_id" label="Select Course" :value="old('course_id', $student->course_id ?? '')" />
    <x-textfield name="dob" label="Student DOB" type="date" placeholder="Enter student date of birth" :value="old('dob', $student->dob ?? '')" />
  
    
    <div class="row g-3">
        @isset($edit)
        <div class="col">
            <label for="">Current Image:</label>
            <img src="{{$student->getImageURL()}}" alt="student image" height="70" width="70">
        </div>
        @endisset
        <div class="col">
             <x-textfield name="image" label="Student Image" type="file" placeholder="Upload student image" :value="old('image', $student->image ?? '')" />
        </div>
    </div>

    @csrf
    @isset($edit)
        @method('PUT')
    @endisset

    <button type="submit" class="btn btn-primary">{{ isset($edit)? 'Update' : 'Create' }}</button>

    
</form>

   
    <!-- <div class="row g-3">
        @isset($edit)
        <div class="col">
            <label for="">Current Image:</label>
            <img src="{{$student->getImageURL()}}" alt="student image" height="70" width="70">
        </div>
        @endisset
        <div class="col">
             <x-textfield name="image" label="Student Image" type="file" placeholder="Upload student image" :value="old('image', $student->image ?? '')" />
        </div>
    </div> -->

