@extends('layouts.app')

@section('title')
    Create Permission
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
                    <a href="{{ route('permissions.index') }}">Permissions</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Permission</li>
            </ol>
        </nav>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('permissions.store') }}" method="POST">
                        @csrf
                        <div class="settings-form">
                            <div class="mb-3">
                                <p class="pay-cont">Option</p>
                                @foreach ($categories as $key => $c)
                                <label class="custom_radio me-4">
                                    <input type="radio" name="prefix" value="{{ strtolower($c) }}" >
                                    <span class="checkmark"></span> {{ $c }}
                                </label>
                                @endforeach
                            </div>
                            <div class="mb-3">
                                <label>Name key <span class="text-danger">-</span></label>
                                <input type="text" value="{{ old('name') }}" name="name" class="@error('name') is-invalid @enderror form-control" placeholder="create/edit/delete/print ..">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            
                            <div class="form-group mb-0">
                                <div class="settings-btns">
                                    <button type="submit" class="border-0 btn btn-primary btn-gradient-primary btn-rounded">Save</button>&nbsp;&nbsp;
                                    <a href="{{ route('permissions.index') }}" class="btn btn-secondary btn-rounded">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
            
@section('script')
    
@endsection