<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set("Asia/Jakarta");
        $this->middleware(['auth']);
        $this->middleware('permission:menu-product', ['only' => ['index', 'show']]);
        $this->middleware('permission:product-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        return view('endee.catalog.products.index');
    }

    public function create()
    {
        return view('endee.catalog.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name'  => 'required',
            'police_number' => 'required|unique:products,police_number',
            'merk'          => 'required',
            'price'         => 'required',
            'type'          => 'required'
        ]);
         
        Product::create($request->post());
 
        return redirect()->route('products.index')->with('success', 'Product has been created successfully.');
    }

    public function datatables(Request $request)
    {
        $items = Product::latest()->get();

        $no = 1;
        $results['data'] = [];

        foreach ($items as $key => $value) :
            $checkbox = '<div class="form-check font-size-16">
                <input class="form-check-input uid" value="' . $value->id . '" type="checkbox" id="uid_' . $value->id . '">
                <label class="form-check-label" for="uid_' . $value->id . '"></label>
            </div>';

            $url_edit = route('products.edit', $value->id);

            $actions = '<div class="dropdown">
                    <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0" 
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"></path></svg> 
                            <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                
                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1" 
                        data-popper-placement="bottom-end" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(-170px, 28px);">
                        
                        <a class="dropdown-item d-flex align-items-center" href="'.$url_edit.'">
                            <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg> 
                            Edit 
                        </a>
                        <a data-product="'.$value->id.'" class="delete-product dropdown-item d-flex align-items-center" href="#">
                            <svg class="dropdown-icon text-danger me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg> 
                            Delete
                        </a>
                    </div>
                </div>';
            
            $created_at = '-';
            if(!empty($value->created_at)) :
                $created_at = date('d M Y', strtotime($value->created_at)) .'<br>'. date('H:i:s', strtotime($value->created_at));
            endif;

            $results['data'][$key] = array(
                $checkbox,
                $no++,
                strtotime($value->created_at),
                $created_at,
                
                $value->product_name,
                '#' .$value->police_number,
                $value->merk,
                $value->type,
                $actions
            );
        endforeach;

        return response()->json($results, 200);
    }

    public function show(Product $product)
    {
        return view('endee.catalog.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('endee.catalog.products.edit', compact('product'));
    }
    
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name'  => 'required',
            'merk'          => 'required',
            'price'         => 'required',
            'type'          => 'required'
        ]);
         
        $product->fill($request->post())->save();
 
        return redirect()->route('products.index')->with('success', 'Product has been updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product has been deleted successfully');
    }

    public function details(Request $request)
    {
        $id = $request->product;
        $product = Product::where('id', $id)->first();
        $data = '';

        if($product) :
            $data = [
                'police_number' => $product->police_number,
                'merk' => $product->merk,
                'type' => $product->type,
                'price' => $product->price,
            ];
        endif;

        return [
            'status' => true,
            'data'   => $data
        ];
    }
}
