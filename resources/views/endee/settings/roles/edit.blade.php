@extends('layouts.app')

@section('title')
    Edit Role
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
                    <a href="{{ route('roles.index') }}">Roles</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Role</li>
            </ol>
        </nav>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    
                    <form method="POST" action="{{ route('roles.update', $role->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="settings-form">
                            <div class="mb-3">
                                <label>Role Name <span class="text-danger">*</span></label>
                                <input type="text" value="{{ $role->name }}" name="name" class="@error('name') is-invalid @enderror form-control">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label>Permission <span class="text-danger">*</span></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="checkAll"> 
                                    <label class="form-check-label" for="checkAll">pilih semua</label>
                                </div>
                                <hr>
                                @foreach($permission as $value)
                                <div class="form-check">
                                    <input class="form-check-input" name="permission[]" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }} value="{{ $value->name }}" id="permission_{{ $value->id }}" type="checkbox">
                                    <label class="form-check-label" for="permission_{{ $value->id }}">{{ $value->name }}</label> 
                                </div>
                                @endforeach
                                @error('permission')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group mb-0">
                                <div class="settings-btns">
                                    <button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">Save</button>
                                    <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-rounded">Cancel</a>
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
        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
@endsection