@extends('layouts.app')

@section('title')
    Edit Orders
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
                    <a href="{{ route('orders.index') }}">Orders</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Order</li>
            </ol>
        </nav>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-12">
        
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('orders.update', $order->id) }}" id="submit-orders">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-12">
                                <div class="form-heading d-flex justify-content-between align-items-center">
                                    <h4 class="h5 mb-4">Users Details</h4>
                                    <div>
                                        <a class="invoices-preview-link btn-find" href="#"><i class="fa fa-eye"></i> Update User</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-8 col-xl-8">  
                                <div class="mb-3">
                                    <label>Nama User <span class="login-danger">*</span></label>
                                    <input readonly id="name" value="{{ $order->user_name }}" class="@error('user_id') is-invalid @enderror form-control" name="name" type="text" >
                                    <input class="form-control" name="user_id" value="{{ $order->user_id }}" id="user_id" type="hidden" >
                                    @error('user_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-xl-4">
                                <div class="mb-3">
                                    <label for="loan_date">Tanggal Pinjam</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg> 
                                        </span>
                                        <input name="loan_date" value="{{ date('Y-m-d', strtotime($order->loan_date)) }}" class="form-control @error('loan_date') is-invalid @enderror" id="loan_date" type="date" placeholder="dd/mm/yyyy">
                                        @error('load_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-12 col-sm-12">
                                <div class="mb-3">
                                    <label>Address <span class="login-danger">*</span></label>
                                    <textarea readonly id="address" name="address" class="@error('address') is-invalid @enderror form-control" rows="3" cols="30">{{ $order->address }}</textarea>
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-heading">
                                    <h4 class="h5 mb-4">Items Details</h4>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-6">
                                <div class="mb-3">
                                    <label>Products</label>
                                    <select name="product_id" class="@error('product_id') is-invalid @enderror form-select select-product">
                                        <option value="">Pilih</option>
                                        @foreach($products as $p)
                                            <option {{ $order->product_id == $p->id ? 'selected' : '' }} value="{{ $p->id }}">{{ strtoupper($p->product_name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-6">
                                <div class="mb-3">
                                    <label>Police Number </label>
                                    <input readonly value="{{ $order->police_number }}" name="police_number" id="police_number" value="" class="form-control" type="text" >
                                    @error('police_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="invoice-add-table">
                                    
                                    <div class="table-responsive">
                                        <table class="table table-nowrap mb-0 no-footer add-table-items">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Merk</th>
                                                    <th>Type</th>
                                                    <th>Harga</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input value="{{ $order->merk }}" readonly type="text" id="merk" class="form-control">
                                                    </td>
                                                    <td>
                                                        <input value="{{ $order->type }}" readonly type="text" id="type" class="form-control">
                                                    </td>
                                                    
                                                    <td>
                                                        <input value="{{ $order->price }}" name="price" type="text" id="price" readonly class="form-control">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-7 col-md-6 mt-3">
                                
                                <div class="invoice-faq">
                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                        
                                        <div class="faq-tab">
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="headingThree">
                                                    <p class="panel-title">
                                                        <a class="collapsed" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                            <i class="fas fa-plus-circle me-1"></i> Pinjam berapa hari
                                                        </a>
                                                    </p>
                                                </div>
                                                <div id="collapseThree" class="panel-collapse" role="tabpanel" aria-labelledby="headingThree" data-bs-parent="#accordion">
                                                    <div class="panel-body">
                                                        <input value="{{ $order->qty }}" type="number" id="qty" class="form-control" name="qty">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-6">
                                <div class="invoice-total-card">
                                    <h4 class="invoice-total-title mt-5">Summary</h4>
                                    <div class="invoice-total-box">
                                        <div class="invoice-total-inner">
                                            <p>
                                                Total Bayar Rp 
                                                <span class="text-total-price">{{ $order->qty*$order->price }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mt-3 doctor-submit text-end">
                                    <button type="submit" class="btn btn-primary submit-form me-2">Simpan</button>
                                    <a href="{{ route('orders.index') }}" class="btn btn-warning cancel-form">Batal</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>							
        </div>					
    </div>

    @include('endee.orders.modal.users')
@endsection

@section('scripts')		
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.submit-form').on('click', function(e) {
        e.preventDefault()

        $(this).attr('disabled', true)
        let form = $('#submit-orders')

        Swal.fire({
            title: 'being processed', 
            timerProgressBar: true, 
            allowOutsideClick: false, 
            didOpen: () => {
                Swal.showLoading()
            }
        })

        form.submit()
    })

    $('.btn-find').on('click', function(e) {
        e.preventDefault()
        $('#findUser').modal('show')
    })

    $('#qty').on('change', function(e) {
        e.preventDefault()
        let price = $('#price').val()
        let qty = $(this).val()
        $('.text-total-price').text(price*qty)
    })

    $('#findUser .btn-select').on('click', function(e) {
        e.preventDefault()
        
        let user = $('#findUser #user').val()
        $.ajax({
            type: 'POST', 
            url: "{{ route('users.details') }}", 
            data: {user}, 
            success: function(response) {
                $('#findUser').modal('hide')

                if(response.status && response.data) {
                    $('#address').html(response.data.address)
                    $('#user_id').val(response.data.id)
                    $('#name').val(response.data.name)
                } else {
                    $('#address').html('')
                    $('#user_id').val('')
                    $('#name').val('')
                }
                
            }
        });
    })

    $('.select-product').on('click', function(e) {
        e.preventDefault()
        
        let product = $(this).val()
        $.ajax({
            type: 'POST', 
            url: "{{ route('products.details') }}", 
            data: {product}, 
            success: function(response) {

                if(response.status && response.data) {
                    $('#police_number').val(response.data.police_number)
                    $('#price').val(response.data.price)
                    $('#type').val(response.data.type)
                    $('#merk').val(response.data.merk)
                    $('#qty').removeAttr('readonly')
                } else {
                    $('#police_number').val('')
                    $('#price').val('')
                    $('#type').val('')
                    $('#merk').val('')
                    $('#qty').attr('readonly', 'readonly')
                }
                
            }
        });
    })
</script>
@endsection