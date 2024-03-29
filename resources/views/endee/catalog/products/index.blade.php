@extends('layouts.app')

@section('title')
   Products
@endsection

@section('css')
    <!-- Datatables CSS -->
	<link rel="stylesheet" href="{{ URL::asset('plugins/datatables/datatables.min.css') }}">
@endsection

@section('content')	

	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
		<div class="d-block mb-4 mb-md-0">
			<nav aria-label="breadcrumb" class="d-none d-md-inline-block">
				<ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
					<li class="breadcrumb-item">
						<a href="#"><svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg></a>
					</li>
					<li class="breadcrumb-item">
						<a href="#">Endee</a></li>
					<li class="breadcrumb-item active" aria-current="page">Products List</li>
				</ol>
			</nav>
			<h2 class="h4">Products List</h2>
			<p class="mb-0">products factory for application.</p>
		</div>

		<div class="btn-toolbar mb-2 mb-md-0">
			<a href="{{ route('products.create') }}" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
				<svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg> New Product
			</a>
			{{-- <div class="btn-group ms-2 ms-lg-3">
				<button type="button" class="btn btn-sm btn-outline-gray-600">Share</button> 
				<button type="button" class="btn btn-sm btn-outline-gray-600">Export</button>
			</div> --}}
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
		
			<div class="card card-table show-entire">
				<div class="card-body p-3">
				
					<div class="input-group mb-5">
						<span class="input-group-text">
							<svg class="icon icon-xs" x-description="Heroicon name: solid/search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg> 
						</span>
						<input type="text" id="my_search" class="form-control" placeholder="Search products">
					</div>

					@if ($message = Session::get('success'))
                    <div class="alert alert-success fade show" role="alert">{{ $message }}</div>
                    @endif

					<div class="table-responsive">
						<table id="datatable-product" class="table user-table table-hover align-items-center">
							<thead class="thead-light">
								<tr>
									<th>
										<div class="form-check check-tables">
											<input class="form-check-input" type="checkbox" value="something">
										</div>
									</th>
									<th>No</th>
									<th></th>
									<th>Date</th>
									<th>Name</th>
									<th>Police Number</th>
									<th>Merk</th>
									<th>Type</th>
									<th ></th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>							
		</div>					
	</div>

	<div id="delete_product" class="modal fade delete-modal" role="dialog">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-body text-center">
					<img src="{{ URL::asset('images/sent.png') }}" alt="" width="50" height="46">
					<h2 class="h5 mb-4 mt-2">Are you sure want to delete this ?</h2>
					<div class="m-t-20"> 
						<a href="#" class="btn btn-warning text-white" data-bs-dismiss="modal">Close</a>
						<form style="display: inline-block" method="POST" action="#">
							{{ csrf_field() }}
							{{ method_field('DELETE') }}
							<button type="submit" class="btn btn-danger">Delete</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')		
	<script src="{{ URL::asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ URL::asset('plugins/datatables/datatables.min.js') }}"></script>

	<script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let dataProduct

        function datatables_product() {
            dataProduct = $('#datatable-product').DataTable({
                'destroy': true, 
				"dom": "lrtip",
                'order': [
                    [2, 'desc'],
                ],

                "columnDefs": [
                    {
                        "targets": [2], 
                        "orderable": false, 
                        "visible": false, 
                        "searchable": false
                    },
                    // untuk mengambil value dari hidden column, data sorting dimundurkan 1 kolom
                    {
                        "orderData": [2],
                        "targets": 3
                    },

                ],

                'ajax': {
                    "type": "POST", 
                    "url": "{{ route('products.datatables') }}",
                    "data": {},
                    "headers": {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }, 
                    "dataSrc": function(response) {
                        if (response.data.length == 0) {
                            $('#check-all').prop("disabled", true)

                            return [];
                        } else {
                            $('#check-all').prop("disabled", false)

                            return response.data;
                        }
                    }
                }
            })

            dataProduct.on('order.dt search.dt', function() {
                dataProduct.column(1, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    i++;
                    if (i == 1) {
                    	grade = i;
                    } else if (i == 2) {
                    	grade = i;
                    } else if (i == 3) {
						grade = i;
                    } else {
                    	grade = i;
                    }

                    cell.innerHTML = '<span class="title-detail">'+grade+'</span>';
                });
            })
        }

		datatables_product()
		$('#datatable-product').on('click', '.delete-product', function(e) {
			e.preventDefault() // Don't post the form, unless confirmed
			let product_id = $(this).data('product')
			$('#delete_product').modal('show')
			$('#delete_product form').attr('action', "{{ url('/products') }}/"+product_id)
    	});

		$('#my_search').keyup(function() {
      		dataProduct.search($(this).val()).draw()
		})
	</script>
@endsection
    