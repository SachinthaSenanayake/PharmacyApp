<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        return view('app.admin.dashboard');
    }

    public function fetchcustomer()
    {
        $customers=Customer::all();
        return response()->json([
            'customers'=>$customers,
        ]);
    }

    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required|max:191',
            'email'=>'required|max:191',
            'address'=>'required|max:191',
            'phone'=>'required|max:191',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }
        else
        {
            $customer=new Customer;
            $customer->name=$request->input('name');
            $customer->email=$request->input('email');
            $customer->address=$request->input('address');
            $customer->phone=$request->input('phone');
            $customer->save();
            return response()->json([
                'status'=>200,
                'message'=>"Customer Added Successfully",
            ]);
        }  
    }

    public function edit($id)
    {
        $customer=Customer::find($id);
        if($customer)
        {
            return response()->json([
                'status'=>200,
                'customer'=>$customer,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Customer Not Found',
            ]);
        }
    }

    public function update(Request $request, $id)
    {

        $validator=Validator::make($request->all(),[
            'name'=>'required|max:191',
            'email'=>'required|max:191',
            'address'=>'required|max:191',
            'phone'=>'required|max:191',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }
        else
        {

            $customer=Customer::find($id);
            if($customer)
            {
                $customer->name=$request->input('name');
                $customer->email=$request->input('email');
                $customer->address=$request->input('address');
                $customer->phone=$request->input('phone');
                $customer->update();
                return response()->json([
                    'status'=>200,
                    'message'=>"Customer Updated Successfully",
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>404,
                    'message'=>'Customer Not Found',
                ]);
            }
        }   
    }

    public function delete($id)
    {
        $customer=Customer::find($id);
        $customer->delete();
        return response()->json([
            'status'=>200,
            'message'=>'Customer Deleted Successfully',
        ]);
    }

    public function search(Request $request, $id)
    {
        $customer=Customer::find($id);
        if($customer)
        {
            $customer->name=$request->input('name');
            $customer->email=$request->input('email');
            $customer->address=$request->input('address');
            $customer->phone=$request->input('phone');
            $customer->show();
            return response()->json([
                'status'=>200,
                'customer'=>$customer,
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'Customer Not Found',
            ]);
        }
    }
}
