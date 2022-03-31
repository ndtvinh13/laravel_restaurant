<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use Alert;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index(){
        return view('pages.home_login');
    }

    //Customer list
    public function list_customer(){
        $dataCustomer = Customer::all();
        return view('admin.list_customer')->with('customers',$dataCustomer);
    }

    // Search customer using ajax
    public function search_customer_ajax(Request $request){
        // check if it receive ajax method
        if($request->ajax()){
            $query = $request->get('query');
            if($query != ''){
                $data = Customer::where('user_name','like','%'.$query.'%')->orderby('user_id','asc')->get();
            }else{
                $data = Customer::orderby('user_id','asc')->get();
            }
            $data_row = $data->count();
            $result = '';
            if($data_row > 0){
                foreach($data as $row){
                    $result .='
                    <tr>
                        <td>'.$row->user_id.'</td>
                        <td>'.$row->user_name.'</td>
                        <td>'.$row->email.'</td>
                        <td>'.$row->updated_at.'</td>
                        <td>
                            <!-- Edit and Delete buttons -->
                            <!-- <a href="" class="btn btn-primary">Edit</a> -->
                            <a onclick="return confirm(\'Do you want to delete?\')" href="'.route('custdelete',$row->user_id).'" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>';
                }
            }else{
                $result = '
                    <tr> 
                        <td align="center" colspan="5" class="fs-5 text-danger" >No data is found!!!</td>
                    </tr>
                ';
            }
            $data = [];
            $data['data'] = $result;

            echo json_encode($data);
        }
    }

    //Customer delete
    public function delete_customer(Request $request){
        $customerId = $request->user_id;
        $dataCustomer = Customer::find($customerId);
        $dataCustomer->delete();
        return redirect()->route('custlist')->with('msg', 'Delete a customer succesfully!');
    }

    //Customer register
    public function register(Request $request){
        $request->validate([
            'user_name' => 'required',
            'user_email' => 'required',
            'user_password' => 'required|min:6',
            'user_confirm_password' => 'required'
        ]);

        //Get all request values
        $data = $request->all();
        
        $userCount = Customer::where('email',$data['user_email'])->count();
        if($userCount>0){
            toast('The account is already created!','error')->width('300px')->padding('20px')->position('top')->hideCloseButton()->timerProgressBar()->autoClose(2500);
            return redirect()->back()->with('msg','The account is already created!');
        }elseif($data['user_password'] != $data['user_confirm_password']){
            toast('Password is not matched!','error')->width('300px')->padding('20px')->position('top')->hideCloseButton()->timerProgressBar()->autoClose(2500);
            return redirect()->back()->with('msg','Password is not matched!');
        }else{
            $customer = new Customer();
            $customer->user_name = $data['user_name'];
            $customer->email = $data['user_email'];
            $customer->password = bcrypt($data['user_password']);
            $customer->save();

            $credentials = [
                'email'=> $data['user_email'],
                'password'=>$data['user_password']
            ];

            if(Auth::guard('customer')->attempt($credentials)){
                toast('Successfully registered! Welcome.','success')->width('300px')->padding('20px')->position('top')->hideCloseButton()->timerProgressBar()->autoClose(2500);
                return redirect()->route('menu');
            }

        }

    }

    // Customer order history
    public function order_history(){
        if($userId = Auth::guard('customer')->user()->user_id){
            $order = Order::where('user_id',$userId)->orderby('order_id','desc')->paginate(5);
            $orderCount = Order::where('user_id',$userId)->count(); 
        }
        
        return view('pages.home_order_history')->with(compact('order','orderCount'));
    }

    // Customer order history details
    public function order_history_details($orderId){
        $orderById = Order::select('tbl_order.*', 'tbl_user.*', 'tbl_shipping.*', 'tbl_order_details.*','tbl_payment.*')->where('tbl_order.order_id',$orderId)->join('tbl_user', 'tbl_order.user_id','=', 'tbl_user.user_id')->join('tbl_shipping', 'tbl_order.shipping_id','=', 'tbl_shipping.shipping_id' )->join('tbl_order_details', 'tbl_order.order_id','=','tbl_order_details.order_id' )->join('tbl_payment','tbl_order.payment_id','=','tbl_payment.payment_id')->first();
        
        $couponCode = $orderById->coupon_code;
        $mangeOrderStatus = Order::select('status')->where('order_id',$orderId)->value('status');
                
        $orderDetailsById = Order::select('tbl_order.*', 'tbl_user.*', 'tbl_order_details.*')->where('tbl_order.order_id',$orderId)->join('tbl_user', 'tbl_order.user_id','=', 'tbl_user.user_id')->join('tbl_order_details', 'tbl_order.order_id','=','tbl_order_details.order_id' )->get();


        if($couponCode != "none"){
            $coupon = Coupon::where('coupon_code',$couponCode)->first();
            $couponFuction = $coupon->coupon_function;
            $couponDiscount = $coupon->coupon_discount;
            return view('pages.home_order_history_details')->with(compact('orderById','orderDetailsById','couponFuction','couponDiscount','couponCode','mangeOrderStatus'));

        }else{
            return view('pages.home_order_history_details')->with(compact('orderById','orderDetailsById','couponCode','mangeOrderStatus'));
        }

        
    }

    // Reset Password index page
    public function reset_password_index(){
        return view('pages.home_reset_password');
    }

    public function reset_password(Request $request){
        // $validator = Validator::make($request->all(), [
        //     'email'=>'required',
        //     'old_password'=>'required',
        //     'password'=>'required|min:6',
        //     'confirm_password'=>'required|min:6'
        // ]);
        
        // if ($validator->fails()) {
        //     return back()->with('errors', $validator->messages()->all()[0])->withInput();
        // }

        $data = $request->all();

        $customerId = $data['user_id'];
        $customerOldPassword = $data['old_password'];

        $customerEmail = Customer::select('email')->where('user_id',$customerId)->value('email');
        $customerPassword = Customer::select('password')->where('user_id',$customerId)->value('password');

        $user = Auth::guard('customer')->user();
        $check = Hash::check($customerOldPassword, Auth::guard('customer')->user()->password);
        $check_old_new = Hash::check($data['password'],Auth::guard('customer')->user()->password);

        // Check if email is matched
        if($data['email'] == $customerEmail){
            // Check if old password is matched
            if($check){
                if(!$check_old_new){
                    // Check if password and confirmed password are matched
                    if($data['password'] == $data['confirm_password']){
    
                        $user->fill([
                            'password' => Hash::make($data['password'])
                            ])->save();
            
                        toast('Your password is updated','success')->width('300px')->padding('20px')->position('top')->hideCloseButton()->timerProgressBar()->autoClose(2000);
            
                        return redirect()->back();
                    }else{
                        toast('Password is not matched','error')->width('300px')->padding('20px')->position('top')->hideCloseButton()->timerProgressBar()->autoClose(2000);
    
                        return  redirect()->back();
                    }

                }else{
                    toast('Please use a different password','error')->width('300px')->padding('20px')->position('top')->hideCloseButton()->timerProgressBar()->autoClose(2000);

                    return  redirect()->back();
                }
            }

        }

        toast('Failed to update your password','error')->width('300px')->padding('20px')->position('top')->hideCloseButton()->timerProgressBar()->autoClose(2000);

        return  redirect()->back();
    }


    //Customer login
    public function login(Request $request){
        $request->validate([
            'userEmail' => 'required',
            'userPassword' => 'required',
        ]);

        $email = $request->userEmail;
        $pass = $request->userPassword;
        $credentials = [
            'email' => $email,
            'password'=> $pass
        ];
        if(Auth::guard('customer')->attempt($credentials)){
            toast('Welcome back!','success')->width('300px')->padding('20px')->position('top')->hideCloseButton()->timerProgressBar()->autoClose(2000);
            return redirect()->route('menu');
        }else{
            toast('Invalid email or password','error')->width('300px')->padding('20px')->position('top')->hideCloseButton()->timerProgressBar()->autoClose(2000);
            return redirect()->back();
        }
    }

    //Customer logout
    public function logout()
    {
        Auth::guard('customer')->logout();

        toast('Logged out!','success')->width('300px')->padding('20px')->position('top')->hideCloseButton()->timerProgressBar()->autoClose(2000);
        return redirect()->route('customer');
    }

}
