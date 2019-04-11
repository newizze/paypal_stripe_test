<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaypalIPN;
use Illuminate\Support\Facades\Storage;

class Paypal extends Controller
{
    public function index(Request $request){
        $ipn = new PaypalIPN();
// Use the sandbox endpoint during testing.
        $ipn->useSandbox();
        $verified = $ipn->verifyIPN();
        if ($verified) {
            $data_text = "";
            foreach ($request->all() as $key => $value) {
                $data_text .= $key . " = " . $value . "\r\n";
            }
            $data_text .= "********************"."\r\n";
            Storage::append('paypal.txt', $data_text);
        }
// Reply with an empty 200 response to indicate to paypal the IPN was received correctly.
        header("HTTP/1.1 200 OK");
    }
}
