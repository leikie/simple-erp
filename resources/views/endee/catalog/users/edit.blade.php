@extends('layouts.app')

@section('title')
    Edit User
@endsection

@section('content')		
    <!-- Page Header -->
    <div class="d-block mb-4 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="#"><svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg></a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('users.index') }}">Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit User</li>
            </ol>
        </nav>
    </div>
    <!-- /Page Header -->
    <form action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data" method="POST" class="card">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="card-body">
            <h2 class="h5 mb-4">Contact Informations</h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label >Role <span class="login-danger">*</span></label>
                        <select name="roles" class="@error('roles') is-invalid @enderror form-select w-100 mb-0">
                            <option value="">-Pilih-</option>
                            @foreach ($roles as $key => $role)
                            <option {{ $userRole == $role ? 'selected' : '' }} value="{{ $role }}">{{ strtoupper($role) }}</option>
                            @endforeach
                        </select>
                        @error('roles')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="focus-label">Address</label>
                        <input name="address" type="text" class="form-control @error('address') is-invalid @enderror floating" value="{{ $user->address }}">
                        @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="focus-label">Level of Wealth</label>
                        <input type="text" name="level_of_wealth" class="@error('level_of_wealth') is-invalid @enderror form-control floating" value="{{ $user->level_of_wealth }}">
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <h2 class="h5 mb-4">Setting Password</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="focus-label">Password</label>
                        <input name="password" type="text" class="@error('password') is-invalid @enderror form-control floating">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="focus-label">Confirm Password</label>
                        <input name="confirm-password" type="text" class="form-control floating">
                    </div>
                </div>
            </div>
        </div>
        <div class="text-end card-body">
            <button class="btn btn-primary submit-btn" type="submit">Save</button>
            <a href="{{ route('users.index') }}" class="btn btn-warning cancel-form">Cancel</a>
        </div>
    </form>
@endsection

@section('scripts')
<script>
    
</script>
@endsection
            