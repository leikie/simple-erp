@extends('layouts.app')

@section('title')
   Profile
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
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </nav>
    </div>
	<!-- /Page Header -->

	<div class="row">
		<div class="col-sm-12">


			<div class="row">
				<div class="col-lg-4">
					<div class="doctor-personals-grp">
						<div class="card">
							<div class="card-body">
								<div class="heading-detail ">
									<h4 class="h5 mb-4">About me</h4>
								</div>
								<div class="about-me-list">
									<ul class="list-space">
										<li class="mb-4">
											<h4 class="h6 mb-0">Name</h4>
											<span>{{ $user->name }}</span>
										</li>
										<li class="mb-4">
											<h4 class="h6 mb-0">Email</h4>
											<span>{{ $user->email }}</span>
										</li>
										<li class="mb-4">
											<h4 class="h6 mb-0">Address</h4>
											<span>{{ $user->address }}</span>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-8">
					<div class="doctor-personals-grp">
						<div class="card">
							<div class="card-body">
								@if ($message = Session::get('message'))
									<div class="alert {{ Session::get('alert-class') }}">
										<span>{{ $message }}</span>
									</div>
								@endif

								<div class="setting-form-blk">
									<form method="POST" action="{{ route('update.profile', $user->id) }}">
										@csrf
										<div class="row">
											<div class="col-12">
												<div class="form-heading">
													<h2 class="h5 mb-4">Account Setting</h2>
												</div>
											</div>
											<div class="col-12 col-sm-12">  
												<div class="mb-3">
													<label>Name </label>
													<input class="form-control" name="name" type="text" value="{{ $user->name }}">
												</div>
											</div>
											<div class="col-12 col-sm-12">  
												<div class="mb-3">
													<label>Level of Wealth </label>
													<input class="form-control" name="level_of_wealth" type="text" value="{{ $user->level_of_wealth }}">
												</div>
											</div>
											<div class="col-12 col-sm-12">
												<div class="mb-3">
													<label>Email <span class="text-danger">*</span> </label>
													<input class="form-control" name="email" type="email" value="{{ $user->email }}">
												</div>
											</div>
										</div>
										<div class="col-12">
											<div class="form-heading">
												<h2 class="h5 mb-4">Detail Setting</h2>
											</div>
										</div>
										<div class="col-12 col-sm-12">
											<div class="mb-3">
												<label>Address </label>
												<textarea class="form-control" name="address" rows="3" cols="30">{{ $user->address }}</textarea>
											</div>
										</div>
										<div class="col-12">
											<div class="submit">
												<button type="submit" class="btn btn-primary submit-form me-2">Submit</button>
												<a href="{{ route('users.index') }}" class="btn btn-warning cancel-form">Cancel</a>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('script')
<script>
    function showPreview(event){
		if(event.target.files.length > 0){
			var src = URL.createObjectURL(event.target.files[0]);
			var preview = document.querySelector(".profile-user-img img");
			preview.src = src;
		}
	}
</script>
@endsection
            