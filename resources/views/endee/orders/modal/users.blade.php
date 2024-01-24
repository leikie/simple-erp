<div class="modal fade" id="findUser" tabindex="-1" data-bs-backdrop="static" aria-labelledby="cancelOrderLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h6">Find Users</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-lg-12">
                        <label for="user" class="col-form-label">Users</label>
                        <div class="form-group mb-4">
                            

                            <div class="input-group mb-3">
                                <select style="width: 100%" id="user" class="form-select">
                                    <option selected="">Choose...</option>
                                    
                                    @foreach($users as $u)
                                    <option {{ $mode == 'edit' && $order->user_id == $u->id ? 'selected' : '' }} value="{{ $u->id }}">{{ $u->name }} - {{ $u->email }}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">       
                        <button type="button" class="form-control btn-select btn btn-primary">
                            Pilih
                        </button>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->

            </div>
        </div>
    </div>
</div>