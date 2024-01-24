@extends('layouts.app')

@section('title')
   Change Password
@endsection

@section('content')	
	<!-- Page Header -->
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users </a></li>
					<li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
					<li class="breadcrumb-item active">Change Password</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- /Page Header -->
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
                <div class="card-body">
                    <form method="POST" id="change-password">
                        <div class="row">
                            <h4 class="page-title">Ubah Password</h4>
                            <div class="col-12 col-md-6 col-xl-12">  
                                <div class="form-group local-forms">
                                    <label>Password Lama <span class="login-danger">*</span></label>
                                    <input id="current_password" name="current_password" value="{{ old('current_password') }}" class="pass-input form-control @error('current_password') is-invalid @enderror" type="password" placeholder="">
                                    <span class="profile-views feather-eye-off toggle-password"></span>
                                    <input type="hidden" value="{{ Auth::user()->id }}" id="data_id">
                                    <small class="text-danger mt-1" id="current_passwordError" data-ajax-feedback="current_password"></small>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-6">  
                                <div class="form-group local-forms">
                                    <label>Password Baru <span class="login-danger">*</span></label>
                                    <input class="form-control pass-input @error('password') is-invalid @enderror" name="password" id="password" type="password" placeholder="">
                                    <span class="profile-views feather-eye-off toggle-password"></span>
                                    <small class="text-danger mt-1" id="passwordError" data-ajax-feedback="password"></small>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-6">  
                                <div class="form-group local-forms">
                                    <label>Konfirmasi Password Baru <span class="login-danger">*</span></label>
                                    <input id="password-confirm" name="password_confirmation" class="form-control pass-input-confirm" type="password" placeholder="">
                                    <span class="profile-views feather-eye-off confirm-password"></span>
                                    <small class="text-danger mt-1" id="password_confirmError" data-ajax-feedback="password-confirm"></small>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="doctor-submit text-end">
                                    <button type="submit" class="btn btn-primary submit-form me-2">Submit</button>
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
    $('#change-password').on('submit', function(event) {
        event.preventDefault();

        var Id = $('#data_id').val();
        var current_password = $('#current-password').val();
        var password = $('#password').val();
        var password_confirm = $('#password-confirm').val();
        $('#current_passwordError').text('');
        $('#passwordError').text('');
        $('#password_confirmError').text('');

        $.ajax({
            url: "{{ url('update-password') }}" + "/" + Id,
            type:"POST",
            data:{
                "current_password": current_password,
                "password": password,
                "password_confirmation": password_confirm,
                "_token": "{{ csrf_token() }}",
            },
            success:function(response){
                $('#current_passwordError').text('');
                $('#passwordError').text('');
                $('#password_confirmError').text('');

                if(response.isSuccess == false) { 
                    $('#current_passwordError').text(response.Message);
                } else if(response.isSuccess == true) {
                    setTimeout(function () {   
                        window.location.href = "{{ url('users/forgot-password') }}"; 
                    }, 1000);
                }
            },
            error: function(response) {
                $('#current_passwordError').text(response.responseJSON.errors.current_password);
                $('#passwordError').text(response.responseJSON.errors.password);
                $('#password_confirmError').text(response.responseJSON.errors.password_confirmation);
            }
        });
    });
</script>
@endsection
            