<!-- resources/views/students/edit.blade.php -->
@extends('layout.master')
@section('title', 'Edit ' . $student->firstname)

@section('content')
    @include('students.form', [
        'action' => route('students.update', $student->id), 
        'edit' => true,
        'student' => $student,
        'courses' => $courses
    ])
@endsection
