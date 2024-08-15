
<form class="container-sm" action="{{ $action }}" method="POST">
    @csrf
    @isset($edit)
        @method('PUT')
    @endisset

    <div class="row g-3">
        <div class="col">
            <x-textfield name="fullname" label="Fullname" type="text" placeholder="Enter User fullname" :value="old('fullname', $user->fullname ?? '')" />
        </div>
    </div>
    <div class="row g-3">
        <x-textfield name="email" label="User Email" type="email" placeholder="Enter user email" :value="old('email', $user->email ?? '')" />
    </div>
    <div>

    @unless(isset($edit))
    <x-textfield name="password" label="User Password" type="password" placeholder="Enter a user password" />
    <x-textfield name="password_confirmation" label="Confirm Password" type="password" placeholder="Confirm password" />
    @endunless


    @php
        $role = [
            ['value' => 'admin', 'label' => 'admin'],
            ['value' => 'superadmin', 'label' => 'superadmin'],
        ];
    @endphp

    <x-selectfield :options="$role" name="role" label="Select Role" :value="old('role', $user->role ?? '')" />
    
  
    <button type="submit" class="btn btn-primary">  {{ isset($edit) ? 'Update' : 'Create' }}</button>
   
</form>
