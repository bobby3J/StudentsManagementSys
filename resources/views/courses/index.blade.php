@extends('layout.master')
@section('title', 'List of Courses')

@section('content')


<div></div>
<a class="btn btn-lg btn-primary mb-3" href="{{route('courses.create')}}">Add New Course</a>

<table class="table mt-3">
  <thead>
    <tr>
      <th scope="col">CourseID</th>
      <th scope="col">Name</th>
      <th scope="col">Number of subjects</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
      @foreach ($courses as $course)
      <tr>
        <th scope="row">{{$course->id}}</th>
        <td>{{$course->name}}</td>
        <td>{{$course->subjects->count()}}</td>
      
      <td>
         <a href="{{route('courses.show', $course->id)}}" class="btn btn-outline-primary">View</a>
         <a href="{{route('courses.edit', $course->id)}}" class="btn btn-outline-success">Edit</a>
         @if($course->trashed())
            <x-deletebutton :action="route('courses.destroy', $course->id)" label="Force Delete"  />
            @else
            <x-deletebutton :action="route('courses.destroy', $course->id)"  />
            @endif
      </td>
      </tr>
      @endforeach
  </tbody>
</table>
@endsection