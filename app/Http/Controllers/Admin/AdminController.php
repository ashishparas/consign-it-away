<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Brand;
use DataTables;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {

      
        return view('admin.dashboard');
    }

    public function OrderManagement(){
        $items = Item::with('Product')
        ->whereIn('status',['1','2','3'])
                        ->take(10)
                        ->orderBy('created_at','DESC')
                        ->get();
        $PastOrders = Item::with('Product')
                            ->whereIn('status',['3','4'])
                            ->take(10)
                            ->get();
        // dd($items->toArray());
        return view('order-management.order-mgt', compact('items','PastOrders'));
    }


    public function ShippingOrderDetails($id){
      $items = Item::where('id', $id)->with(['Product','Rating','Customer','Address'])->first();

    //   dd($items->toArray());
        return view('order-management.shipping-orders-details', compact('items'));
    }
    
    public function Brand(){
      
        return view('admin/brand/brand-list');
    }
    

    public function BrandList(Request $request ){
     
        if ($request->ajax()) {
           
            $data = Brand::select('*')->get();
         
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                $btn = '<a href="'.url('admin/edit-brand/'.$row->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

       
    }

    
    public function EditBrand($id){
        $brand = Brand::FindOrfail($id);
        return view('admin/brand/edit-brand',compact('brand'));
    }
    
    public function UpdateBrand(Request $request){
        $input = $request->all();
      
// dd(public_path('/public/brand'));
            
            $brand = Brand::FindOrfail($request->id);
             if (isset($request->image)):
                $input['image'] = parent::__uploadImage($request->file('image'), public_path('/brand'), false);
            endif;
                    $brand->fill($input);
                    $brand->save();
            return redirect()->route('brand-list');
            
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
