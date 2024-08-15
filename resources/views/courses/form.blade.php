<form class="container-sm" action="{{$action}}" method="POST">
 
  <x-textfield name="name" label="Course Name" :value="$course->name" type="text" placeholder="Enter a Course Name"/>

    <h4>Select Subject</h4>
  <div class="row row-cols-3 mb-3">
      @foreach ($subjects as $subject)
        <x-checkbox  :subjects="$course->subjects"  :label="$subject->name" name="subject_id[]" :value="$subject->id"/>
      @endforeach
  </div>

@csrf
@isset($edit)
   @method('PATCH')
@endisset
    <button type="submit" class="btn btn-primary">Submit</button>
</form>