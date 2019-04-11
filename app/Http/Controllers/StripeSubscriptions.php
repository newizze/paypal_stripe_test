<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Stripe\Stripe;
use \Stripe\Subscription;
use \Stripe\Customer;
use Carbon\Carbon;

class StripeSubscriptions extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Stripe\Error\Api
     */
    public function index(){
        Stripe::setApiKey("sk_test_eVjElB0guilegOXVFmuUmesM00kRnjxvGa");
        $list = Subscription::all();
        $data = [];
        foreach ($list->data as $row){
            $user = $row->customer;
            $customer = Customer::retrieve($user);
            if ($customer->email){
                $user = $customer->email;
            }
            $data[] = [
                'user' => $user,
                'sub_plan' => $row->plan->nickname,
                'start_date' => Carbon::parse($row->start)->toDateString(),
                'status' => $row->status,
                'expire_date' => Carbon::parse($row->current_period_end)->toDateString()
            ];
        }
        return view('stripe',['data' => $data]);
    }
}
