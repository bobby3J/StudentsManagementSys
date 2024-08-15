
@section('content')
<form class="container-sm" action="{{ $action }}" method="POST">
    @csrf
    @isset($subject)
        @method('PATCH')
    @endisset

    <div class="mb-3">
        <label for="name" class="form-label">Subject Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $subject->name ?? old('name') }}" placeholder="Enter a Subject Name">
    </div>

    <button type="submit" class="btn btn-primary">
        @isset($subject)
            Update Subject
        @else
            Add Subject
        @endisset
    </button>
</form>
@endsection

