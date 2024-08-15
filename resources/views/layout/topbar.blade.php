
<nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">STUDENT MANAGEMENT SYSTEM</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{{route('homepage')}}">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('students.index')}}">Students</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('courses.index')}}">Courses</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('subjects.index')}}">Subjects</a>
        </li>
      
        <!-- <li class="nav-item">
          <a class="nav-link" href="{{route('users.index')}}" >Users</a>
        </li> -->
          
        @if(Auth::user()->role === 'superadmin')
          <a class="nav-link" href="{{route('users.index')}}">Users</a> 
          @endif
        
        <form action="{{route('auth.logout')}}" method="post">
            @csrf
            <button class="btn btn-success" type="submit">Logout</button>
          </form>


      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>

