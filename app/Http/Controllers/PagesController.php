<?php

namespace App\Http\Controllers;

use DB;
use Redirect;
use App\User;
use App\LogoOrder;
use App\logoType;
use App\LogoUsage;
use App\OrdersPayment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class PagesController extends Controller
{
    public function homeVersion()
    {
    	$home = 'home';
      $logoType = \App\logoType::latest('id','desc')->where('type_of_logo','logo_type')->where('order_types',2)->get();
      $logoFeel = \App\logoType::latest('id','desc')->where('type_of_logo','logo_feel')->where('order_types',2)->get();
      $logoUsage = \App\LogoUsage::latest('id','desc')->where('status',1)->where('order_types',2)->get();
      $fontType = \App\LogoFonts::latest('id','desc')->where('order_types',2)->get();
      $packages = \App\Packages::latest('id','desc')->where('order_type_id',2)->get();
      $packages_addon = \App\PaymentAdons::latest('id','desc')->where('order_type_id',2)->get();
      return view('pages.'.$home)->with('logo_type',$logoType)->with('logo_usage',$logoUsage)->with('font_tpe',$fontType)->with('logo_feel',$logoFeel)->with('packages',$packages)->with('addon',$packages_addon);
    }

    public function payment(){
        $payment = 'payment';
        return view('pages.'.$payment);
    }
    public function createOrders(Request $request)
    {
      if (User::where('email', '=', Input::get('email'))->count() > 0) {
          $userData = User::where('email', $request->input("email"))->first();
          $userId = $userData->id;
      }else{
    //------------------------------Insert User in Database-----------------      
        $user = new User();
        $user->f_name=$request->input("fname");
        $user->l_name=$request->input("lname");
        $user->email=$request->input("email");
        $user->password='test';
        $user->phone=$request->input("phone");
        $user->user_role=$request->input("user_role");
        $user->created_at=date("Y-m-d H:i:s");
        $user->updated_at=date("Y-m-d H:i:s");
        $user->save();
        $userId = $user->id;
      }
    //------------------------------Saving Images -----------------  
      
      $uploadfiles_name = $request->input("uploadfiles_name");
      $remove_file_arr = explode(",",$uploadfiles_name);
      if ( Input::hasFile('sample_logos') ):
            $file = Input::file();
           for ($j=0; $j < count($file['sample_logos']); $j++) { 
              $sample_images_name_arr[] = $file['sample_logos'][$j]->getClientOriginalName();
            } 
           if(count($remove_file_arr) > 0){
              for ($i=0; $i < count($file['sample_logos']) ; $i++) {
                   $sample_images_name = $file['sample_logos'][$i]->getClientOriginalName();
                   if(in_array($sample_images_name_arr[$i], $remove_file_arr)){
                      //echo 'Delete Files '.$sample_images_name.'<br>';
                   }else{
                      $destinationPath = $file['sample_logos'][$i];  
                      $image_path ="public/uploads/order_logo/".$sample_images_name;  
                      move_uploaded_file($destinationPath, $image_path); 
                      $sample_images_arr[] = $sample_images_name;
                   }
              }
           }else{
               for ($i=0; $i < count($file['sample_logos']) ; $i++) {
                   $sample_images_name = $file['sample_logos'][$i]->getClientOriginalName();
                   $destinationPath = $file['sample_logos'][$i];  
                   $image_path ="public/uploads/order_logo/".$sample_images_name;  
                   move_uploaded_file($destinationPath, $image_path); 
                   $sample_images_arr[] = $sample_images_name;
               }
           }
      endif;
      $deigner_help_files_name = $request->input("deigner_help_files_name");
      $remove_deigner_help_files_arr = explode(",",$deigner_help_files_name);
      if ( Input::hasFile('deigner_help_imgs') ):
            $help_file = Input::file();
           for ($j=0; $j < count($help_file['deigner_help_imgs']); $j++) { 
              $deigner_help_imgs_arr[] = $help_file['deigner_help_imgs'][$j]->getClientOriginalName();
            } 
           if(count($remove_deigner_help_files_arr) > 0){
              for ($i=0; $i < count($help_file['deigner_help_imgs']) ; $i++) {
                   $deigner_help_name = $help_file['deigner_help_imgs'][$i]->getClientOriginalName();
                   if(in_array($deigner_help_imgs_arr[$i], $remove_deigner_help_files_arr)){
                   }else{
                      $destinationPath_help_imgs = $help_file['deigner_help_imgs'][$i];  
                      $deigner_help_image_path ="public/uploads/order_logo/".$deigner_help_name;  
                      move_uploaded_file($destinationPath_help_imgs, $deigner_help_image_path); 
                      $designer_help_images_arr[] = $deigner_help_name;
                   }
              }
           }else{
               for ($i=0; $i < count($help_file['deigner_help_imgs']) ; $i++) {
                   $deigner_help_name = $help_file['deigner_help_imgs'][$i]->getClientOriginalName();
                   $destinationPath_help_imgs = $help_file['deigner_help_imgs'][$i];  
                   $deigner_help_image_path ="public/uploads/order_logo/".$deigner_help_name;  
                   move_uploaded_file($destinationPath_help_imgs, $deigner_help_image_path); 
                   $designer_help_images_arr[] = $deigner_help_name;
               }
           }
      endif;
      
      //------------------------------Insert Orders in Database-----------------
      $orders = new LogoOrder();
      $orders->user_id=$userId;
      $orders->order_type=$request->input("order_type");
      $orders->logo_name=$request->input("logo_name");
      $orders->logo_slogan=$request->input("slogan");
      $orders->logo_cat=$request->input("logo_category");
      $orders->logo_web_url=$request->input("website_url");
      $orders->logo_target_audience=$request->input("target_audience");
      $orders->logo_descrip=$request->input("descrp");
      $orders->logo_competitor_url=$request->input("compititor_url");
      $orders->logo_sample= Input::hasFile('sample_logos') ? implode(",",$sample_images_arr) : '';
      $orders->logo_visual_descp=$request->input("describe_imgs_dont_like");
      $orders->logo_visual_images=$request->input("describe_imgs_like");
      $orders->logo_type=implode(",",$request->input("logo_type"));
      $orders->logo_color=$request->input("choose_color");
      $orders->logo_other_color=$request->input("other_color");
      $orders->logo_usage=implode(",",$request->input("logo_usage"));
      $orders->logo_other_usage=$request->input("other_logo_usage");
      $orders->logo_fonts=implode(",",$request->input("font_type"));
      $orders->logo_other_fonts=$request->input("other_font_type");
      $orders->logo_feel=implode(",",$request->input("logo_feel"));
      $orders->communication_team=$request->input("communicate_designers");
      $orders->helpful_images=Input::hasFile('deigner_help_imgs') ? implode(",",$designer_help_images_arr) : '';
      $orders->created_at=date("Y-m-d H:i:s");
      $orders->updated_at=date("Y-m-d H:i:s");
      $orders->save();
      $orderId = $orders->id;

    //------------------------------Insert Payment in Database-----------------

      $package_amount = $request->input("package_amount");
      $addon_amount = $request->input("addon_amount") ? $request->input("addon_amount"): 0;
      $total = ($package_amount + $addon_amount);
      $order_payment = new OrdersPayment();
      $order_payment->order_id=$orderId;
      $order_payment->user_id=$userId;
      $order_payment->order_type=$request->input("order_type");
      $order_payment->package_id=$request->input("package_name");
      $order_payment->coupon_id=NULL;
      $order_payment->payment_addon_id=$request->input("addon_name") ? $request->input("addon_name"): NULL;
      $order_payment->total_amount=$total;
      $order_payment->status=0;
      $order_payment->created_at=date("Y-m-d H:i:s");
      $order_payment->updated_at= date("Y-m-d H:i:s");
      $order_payment->save();
      $paymentId = $order_payment->id;

      $user = \App\User::find($userId);
      $order = \App\LogoOrder::find($orderId);
      $package = \App\Packages::find($request->input("package_name"));
      $addon = \App\PaymentAdons::find($request->input("addon_name"));
      $payment = \App\OrdersPayment::find($paymentId);
      return view('pages.payment')->with(array('order'=>$order,'user'=>$user,'package'=>$package,'payment'=>$payment,'addon'=>$addon));

      

    }
}
