@extends('layout.master')
@section('title', 'Edit ' . $subject->name)

@section('content')
    @include('subjects.form', [
        'action' => route('subjects.update', $subject->id), 
        'edit' => true,
        'subject' => $subject
    ])
@endsection