<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set("Asia/Jakarta");
        $this->middleware(['auth']);
        $this->middleware('permission:menu-order', ['only' => ['index', 'show']]);
        $this->middleware('permission:order-create', ['only' => ['create','store']]);
        $this->middleware('permission:order-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:order-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('endee.orders.index');
    }

    public function create()
    {
        $users = User::latest()->get();
        $products = Product::latest()->get();

        return view('endee.orders.create', compact('users', 'products'));
    }

    public function datatables(Request $request)
    {
        $q = Order::select('orders.*', 'users.name as user_name', 'products.product_name as product_name', 'products.price')
                ->leftJoin('users', 'users.id', '=', 'orders.user_id')
                ->leftJoin('products', 'products.id', '=', 'orders.product_id');

        $items = $q->orderBy('orders.created_at', 'desc')
                ->get();
                
        $no = 1;
        $results['data'] = [];

        foreach ($items as $key => $value) :
            $checkbox = '<div class="form-check check-tables">
                <input class="form-check-input" type="checkbox" value="something">
            </div>';

            #$url_print = route('orders.print', $value->id);
            $url_detail = route('orders.show', $value->id);
            $url_edit = route('orders.edit', $value->id);

            $actions = '<div class="dropdown">
                    <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" 
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path></svg> 
                            <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                
                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1" 
                        data-popper-placement="bottom-end" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(-170px, 28px);">
                        <a class="dropdown-item d-flex align-items-center" href="'.$url_detail.'">
                            <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"></path><path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                            Detail
                        </a>
                        <a class="dropdown-item d-flex align-items-center" href="'.$url_edit.'">
                            <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg> 
                            Edit 
                        </a>
                        <a data-order="'.$value->id.'" class="delete-order dropdown-item d-flex align-items-center" href="#">
                            <svg class="dropdown-icon text-danger me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg> 
                            Delete
                        </a>
                    </div>
                </div>';

            $order_date = '-';
            if(!empty($value->created_at)) :
                $order_date = date('d M Y', strtotime($value->created_at)) .'<br>'. date('H:i:s', strtotime($value->created_at));
            endif;

            $results['data'][$key] = array(
                $checkbox,

                $no++,
                
                strtotime($value->created_at),
                $order_date,
                strtoupper($value->user_name),
                $value->product_name,
                
                '<p class="text-muted mb-0">'.number_format($value->total_price).'</p>',
                date('d M Y', strtotime($value->loan_date)),
                '<span class="badge super-badge bg-success">'. $value->qty.' hari</span>',
                date('d M Y', strtotime($value->return_date)),
                $actions
            );
        endforeach;

        return response()->json($results, 200);
    }

    public function show($id)
    {
        $order = Order::where('id', $id)
        ->first();

        if(empty($order)) :
            return abort(404);
        endif;

        return view('endee.orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        #submit order.
        $request->validate([
            "user_id" => 'required',
            "loan_date" => 'required',
            "product_id" => 'required',
        ]);

        $return_date = date('Y-m-d', strtotime("+".$request->qty." day", strtotime($request->loan_date)));

        $data = [
            'user_id' => $request->post('user_id'),
            'product_id' => $request->product_id,
            'return_date' => $return_date,
            'loan_date' => date('Y-m-d', strtotime($request->loan_date)),
            'total_price' => $request->price * $request->qty,
            'qty' => $request->qty,
        ];

        $message = 'Order has been created successfully. ';
        $order = Order::create($data);
        
        return redirect()->route('orders.index')
            ->with('success', $message);
    }

    public function edit($id)
    {
        $order = Order::select('orders.*', 'users.name as user_name', 'users.address', 'products.product_name as product_name', 'products.price', 'products.merk', 'products.type', 'products.police_number')
                ->leftJoin('users', 'users.id', '=', 'orders.user_id')
                ->leftJoin('products', 'products.id', '=', 'orders.product_id')
                ->where('orders.id', $id)
                ->first();

        if(empty($order)) :
            return abort(404);
        endif;

        $users = User::latest()->get();
        $products = Product::latest()->get();
        return view('endee.orders.edit', compact('users', 'products', 'order'));
    }

    public function update(Request $request, $id)
    {
        #submit order.
        $request->validate([
            "user_id" => 'required',
            "loan_date" => 'required',
            "product_id" => 'required',
        ]);

        $return_date = date('Y-m-d', strtotime("+".$request->qty." day", strtotime($request->loan_date)));

        $data = [
            'user_id' => $request->post('user_id'),
            'product_id' => $request->product_id,
            'return_date' => $return_date,
            'loan_date' => date('Y-m-d', strtotime($request->loan_date)),
            'total_price' => $request->price * $request->qty,
            'qty' => $request->qty,
        ];

        $order = Order::where('id', $id)->first();

        $message = 'Order has been updated successfully. ';
        $order->update($data);

        return redirect()->route('orders.index')->with('success', $message);
    }

    public function destroy($id)
    {
        $order = Order::find($id);

        $order->delete();
        return redirect()->route('orders.index')
                        ->with('success', 'Order deleted successfully');
    }
}
