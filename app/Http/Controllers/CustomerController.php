<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;


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
            'password'=>$pass
        ];
        if(Auth::guard('customer')->attempt($credentials)){
            toast('Welcome back!','success')->width('300px')->padding('20px')->position('top')->hideCloseButton()->timerProgressBar()->autoClose(2000);
            return redirect()->route('menu');
        }else{
            return redirect()->back()->with('login_msg','Invalid email or password');
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
