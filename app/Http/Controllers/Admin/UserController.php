<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Session;
use Symfony\Component\Console\Input\Input;

class UserController extends Controller
{
    public function __construct()
    {
         $this->middleware(function ($request, $next) {
            Session::put('top_menu',"user");
            Session::put('sub_menu',"user");
            return $next($request);
        });
    }
    public function index()
    {

        return view("admin.users.users");
    }

    public function view()
    {
        $search_key=request()->input("search_key");
        $filter_by=request()->input("filter_by");
        $users=User::orderBy("id","desc");
        if($filter_by!='')
        {
            $users=$users->where('status',$filter_by);
        }
        if($search_key!='')
        {
            $users=$users->where('email', 'like', '%' . $search_key . '%');
            $users=$users->orWhere('phone', 'like', '%' . $search_key . '%');
        }
        $users=$users->paginate(10);
        $this->data['users']=$users;
         $page=request()->input('page');
        if($page<=1)
        {
            $this->data['sl_counter']=1;
        }
        else
        {
            $this->data['sl_counter']=$page*10-9;
        }
        $returnHTML = view('admin.users.users_data')->with($this->data)->render();
        return response()->json(array('success' => true, 'html'=>$returnHTML));
//        dd(request()->all());
    }

    public function control($user_id)
    {
        $user=User::where("id",$user_id)->first();
        if($user->status==1)
        {
            $user->status=2;
        }
        else if($user->status==0)
        {
            $user->status=1;
        }
        else if($user->status==2)
        {
            $user->status=1;
        }
        $user->save();
        setMessage("message",'success',"User Update Successfully");
        return redirect()->route("admin.user");
    }

    public function userEdit($user_id)
    {
        $this->data['single']=User::where("id",$user_id)->first();
        return view('admin.users.user-edit',$this->data);

    }

    public function userUpdate($user_id)
    {
        $user=User::where("id",$user_id)->first();
        $user->name=request()->input("name");
        $user->phone=request()->input("phone");
        $user->email=request()->input("email");
        if($this->phoneCheck($user_id))
        {
              setMessage("message","danger","Phone already exits.");
            return back();
        }
        if($this->emailCheck($user_id))
        {
              setMessage("message","danger","Email already exits.");
                return back();
        }
        if(request()->input("password"))
        {
            $user->password=request()->input("password");
        }
        $user->save();
        setMessage("message","success","User Update Successfully");
        return back();
    }

    public function phoneCheck($user_id)
    {
        $phone=request()->input("phone");
        $where=["phone"=>$phone];
        return User::where($where)->where('id', '!=',$user_id)->first();
    }
    public function emailCheck($user_id)
    {
        $email=request()->input("email");
        $where=["email"=>$email];
        return User::where($where)->where('id', '!=',$user_id)->first();
    }
}
