<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Brand;
use App\Models\UserChat;
use Carbon;
use DataTables;
use Illuminate\Support\Facades\DB;

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
                            DB::enableQueryLog();
        $UserChat = UserChat::select('users.name','users.fname','users.lname','users.profile_picture','user_chat.message','user_chat.created_on','user_chat.MessageType')
                ->join('users','users.id', 'user_chat.source_user_id')
                ->orderBy('user_chat.created_on','DESC')
                ->latest()
                ->get()->unique('user_chat.source_user_id');
        // dd(DB::getQueryLog($UserChat));
        return view('order-management.order-mgt', compact('items','PastOrders','UserChat'));
    }


    public function ShippingOrderDetails($id){
      $items = Item::where('id', $id)->with(['Product','Rating','Customer','Address'])->first();

    //   dd($items->toArray());
        return view('order-management.shipping-orders-details', compact('items'));
    }
    
    public function Brand(){
      
        return view('admin/brand/brand-list');
    }
    


    public function BrandList(Request $request){
 
        if ($request->ajax()) {
           
            $data = Brand::select("*");
     
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

            if (isset($request->photo)):
                $input['photo'] = parent::__uploadImage($request->file('photo'), public_path('/brand'), false);
            endif;

                    $brand->fill($input);
                    $brand->save();
            return redirect()->route('brand.list');
            
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
