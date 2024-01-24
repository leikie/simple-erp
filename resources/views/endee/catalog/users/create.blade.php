@extends('layouts.app')

@section('title')
    Create User
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
                <li class="breadcrumb-item active" aria-current="page">Add User</li>
            </ol>
        </nav>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-12">
        
            <div class="card">
                <div class="card-body border-0 mb-4">
                    <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                
                                <h2 class="h5 mb-4">Users Details</h2>
                            </div>
                            <div class="col-12 col-md-12 col-xl-12">  
                                <div class="mb-3">
                                    <label >Fullname <span class="text-danger">*</span></label>
                                    <input name="name" value="{{ old('name') }}" class="@error('name') is-invalid @enderror form-control" type="text" placeholder="" >
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-6 col-xl-6">
                                <div class="mb-3">
                                    <label >Level of Wealth </label>
                                    <input name="level_of_wealth" value="{{ old('level_of_wealth') }}" class="@error('level_of_wealth') is-invalid @enderror form-control" type="text" placeholder="" >
                                    @error('level_of_wealth')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-6">
                                <div class="mb-3">
                                    <label >Email <span class="login-danger">*</span></label>
                                    <input name="email" value="{{ old('email') }}" class="@error('email') is-invalid @enderror form-control" type="text" placeholder="" >
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-6">
                                <div class="mb-3">
                                    <label >Password <span class="login-danger">*</span></label>
                                    <input name="password" class="@error('password') is-invalid @enderror form-control" type="password" placeholder="" >
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-6">
                                <div class="form-group local-forms">
                                    <label >Confirm Password <span class="login-danger">*</span></label>
                                    <input name="confirm-password" class="form-control" type="password" placeholder="" >
                                </div>
                            </div>
                            <div class="col-12 col-sm-12">
                                <div class="mb-3">
                                    <label>Address </label>
                                    <textarea name="address" class="@error('address') is-invalid @enderror form-control" rows="3" cols="30">{{ old('address') }}</textarea>
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-xl-6">
                                <div class="mb-3">
                                    <label >Role <span class="login-danger">*</span></label>
                                    <select name="roles" class="@error('roles') is-invalid @enderror form-select w-100 mb-0">
                                        <option value="">-Pilih-</option>
                                        @foreach ($roles as $key => $role)
                                        <option value="{{ $role }}">{{ strtoupper($role) }}</option>
                                        @endforeach
                                    </select>
                                    @error('roles')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary submit-form me-2">Submit</button>
                                    <a href="{{ route('users.index') }}" class="btn btn-warning cancel-form">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>							
        </div>					
    </div>
@endsection

@section('scripts')
<script>
    
</script>
@endsection

    