<?php

namespace App\Http\Controllers\Contributor\Invoices;
use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoicesController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }
    //-----------------------get all invoices list
    public function index()
    {
        return view('contributor.invoices.index')->with('page_title', "Admin Dashboard Invoices");
    }
    
    //---------------------------------generate invoice----------------------------
    public function invoice($order_id)
    {
        $orders = \App\LogoOrder::find($order_id);  
        $user = \App\User::find($orders->user_id);        
        $logo_order_logo_type = explode(",", $orders->logo_type);        
        $logo_type = \App\logoType::find($logo_order_logo_type);
        $logo_order_logo_feel = explode(",", $orders->logo_feel);        
        $logo_feel  = \App\logoType::find($logo_order_logo_feel);
        $logo_usage_input = explode(",", $orders->logo_usage);  
       	$logo_usage = \App\LogoUsage::find($logo_usage_input);
        $logo_font_input = explode(",", $orders->logo_fonts);  
        $logo_fonts = \App\LogoFonts::find($logo_font_input);
        $logo_sample = explode(",", $orders->logo_sample);  
        $help_ful_images = explode(",", $orders->helpful_images); 
        $payment = \App\OrdersPayment::find($orders->id);
        $packages = \App\Packages::find($payment->package_id);
        $order_type = \App\OrderType::find($orders->order_type);
        $payment_adon = \App\PaymentAdons::find($payment->payment_addon_id);
        $coupon_code  = \App\CouponCode::find($payment->coupon_id);
        $setting=\App\AdminSettings::latest('id', 'asc')->first(); 
        return view('contributor.invoices.generateinvoice')->with(array('page_title'=>'Invoice','orders'=>$orders,'user'=>$user,'logo_type'=>$logo_type,'logo_feel'=>$logo_feel,'logo_usages'=>$logo_usage,'logo_fonts'=>$logo_fonts,'setting'=>$setting,'logo_samples'=>$logo_sample,'help_ful_images'=>$help_ful_images,'packages'=>$packages,'order_type'=>$order_type,'payment_adon'=>$payment_adon,'payment'=>$payment,'settings'=>$setting,'coupon_code'=>$coupon_code ));
    }
    //-------------------------print invoice------------------------------------
    public function printinvoice($order_id)
    {
        $orders = \App\LogoOrder::find($order_id);  
        $user = \App\User::find($orders->user_id);        
        $logo_order_logo_type = explode(",", $orders->logo_type);        
        $logo_type = \App\logoType::find($logo_order_logo_type);
        $logo_order_logo_feel = explode(",", $orders->logo_feel);        
        $logo_feel  = \App\logoType::find($logo_order_logo_feel);
        $logo_usage_input = explode(",", $orders->logo_usage);  
       	$logo_usage = \App\LogoUsage::find($logo_usage_input);
        $logo_font_input = explode(",", $orders->logo_fonts);  
        $logo_fonts = \App\LogoFonts::find($logo_font_input);
        $logo_sample = explode(",", $orders->logo_sample);  
        $help_ful_images = explode(",", $orders->helpful_images); 
        $payment = \App\OrdersPayment::find($orders->id);
        $packages = \App\Packages::find($payment->package_id);
        $order_type = \App\OrderType::find($orders->order_type);
        $payment_adon = \App\PaymentAdons::find($payment->payment_addon_id);
        $coupon_code  = \App\CouponCode::find($payment->coupon_id);
        $setting=\App\AdminSettings::latest('id', 'asc')->first(); 
        return view('contributor.invoices.printinvoice')->with(array('page_title'=>'Print Invoice','orders'=>$orders,'user'=>$user,'logo_type'=>$logo_type,'logo_feel'=>$logo_feel,'logo_usages'=>$logo_usage,'logo_fonts'=>$logo_fonts,'setting'=>$setting,'logo_samples'=>$logo_sample,'help_ful_images'=>$help_ful_images,'packages'=>$packages,'order_type'=>$order_type,'payment_adon'=>$payment_adon,'payment'=>$payment,'settings'=>$setting,'coupon_code'=>$coupon_code ));
    }
    
    
}
