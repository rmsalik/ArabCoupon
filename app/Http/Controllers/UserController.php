<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{ApplicationSetting,TripStar, Trip, Category,CategoryBrand, Destination,Country,CouponItem, Item,TripImage,Coupon, CouponLike,Subscription, User,Airport,Office, UserLikeItem,Brand,CreditCard};
use App\Http\Resources\User\{CategoryResource, ItemResource, UserResource,TripResource};
use Illuminate\Support\Facades\{DB, Validator, Hash, Mail};
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * This method is used to SignUp a new User
     */
    public function signup(Request $request){
        //$email=$request->email;
        //return $email;
        
        $validator = Validator::make($request->all(), [
            'email' => 'bail|required|email|unique:users,email',
            'password' => 'bail|required',
            'full_name' => 'bail|required',
            'profile_type' => 'required',
            'device_type'  => 'bail|required',
            'device_token'  => 'bail|required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], 200);
        }
        $createUser = User::createUser($request->all());
        $getUser = User::getUser($request->email);
        if(!$createUser){
            return response()->json(['error' => true, 'message' => 'User not created.'], 200);
        }
        //$update['stripe_customer_id'] = NULL;
        if($getUser && !$getUser->stripe_customer_id){
            $email = substr($request->email, -19);
            $stripeCustomer = $this->stripeCustomer($email);
            $update['stripe_customer_id'] = $stripeCustomer->id;
            $getUser->update($update);
        }
        $data=['email' => $request->email, 'description' => $request->email];
        Mail::send(
            ['html' => 'emails.welcome'],
            $data,
            function ($message) use ($data) {
                $message->to($data['email'])
                    ->from('support@PremierAutoCarRental.com','PremierAutoCarRental')
                    ->subject("Welcome to  PremierAutoCarRental APP");
            }
        );
        
        return response()->json([
            'error' => false,
            'message' => 'User created successfully.',
            'data' => [
                'token' => $createUser->createToken('PremierAutoCarRental')->plainTextToken,
                'user' => new UserResource($getUser),
            ]
        ], 200);
    }
    /**
     * This method is used to Login the User
     */
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email'     => 'bail|required|email|exists:users,email',
            'password'  => 'bail|required',
            'device_type'  => 'bail|required',
            'device_token'  => 'bail|required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], 200);
        }
        $getUser = User::getUser($request->email);
        if(!(Hash::check($request->password, $getUser->password))){
            return response()->json(['error' => true, 'message' => 'Invalid email or password.'], 200);
        }
        $update['device_type'] = $request->device_type;
        $update['device_token'] = $request->device_token;
        //$update['stripe_customer_id'] = NULL;
        if($getUser && !$getUser->stripe_customer_id){
            $email = substr($request->email, -19);
            $stripeCustomer = $this->stripeCustomer($email);
            $update['stripe_customer_id'] = $stripeCustomer->id;
            //$getUser->update($update);
        }
        $getUser->update($update);
        return response()->json([
            'error' => false,
            'message' => 'User login successfully.',
            'data' => [
                'token' => $getUser->createToken('PremierAutoCarRental')->plainTextToken,
                'user' => new UserResource($getUser),
            ]
        ], 200);
    }
    /**
     * This methoid is used to get User details
     */
    public function getUser(Request $request){
        $userId = $request->input('user_id') ?? auth()->id();
        return response()->json([
            'error' => false,
            'message' => 'Profile Data',
            'data' => [
                'token' => $request->header('Authorization'),
                'user' => new UserResource(User::getUser($userId)),
            ]
        ], 200);
    }
    /**
     * This method is used to update User profile
     */
    public function deleteProfile(Request $request){
        try{
            $input = $request->all();
            $validator = Validator::make($input, [
                'user_id' => 'bail|required',
                //'image' => 'bail|image|mimes:jpeg,png,jpg,JPEG,PNG,JPG,MPEG,heif,heic,heif-sequence,heic-sequence',
                //'front_license_image' => 'bail|image|mimes:jpeg,png,jpg,JPEG,PNG,JPG,MPEG,heif,heic,heif-sequence,heic-sequence',
                //'back_license_image' => 'bail|image|mimes:jpeg,png,jpg,JPEG,PNG,JPG,MPEG,heif,heic,heif-sequence,heic-sequence',
                //'upload_insurance_document_image' => 'bail|image|mimes:jpeg,png,jpg,JPEG,PNG,JPG,MPEG,heif,heic,heif-sequence,heic-sequence',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => true, 'message' => $validator->errors()->first()], 200);
            }
            $getUser = User::where('id', $request->user_id)->first();
            if(!$getUser)
            {
                return response()->json(['error' => true, 'message' => 'User not found'], 200);
            }
            $message= "";
            //return $request->front_license_image;
            if($request->front_license_image == "delete"){
                $input['front_license'] = "";
                $getUser->update(['front_license' => '']);
                $message="Front license image deleted successfully";
            }
            if($request->back_license_image == "delete"){
                $input['back_license'] = "";
                $getUser->update(['back_license' => '']);
                $message="Back license image deleted successfully";
            }
            if($request->insurance_document_image == "delete"){
                $input['document'] = "";
                $getUser->update(['document' => '']);
                $message="Insurance document image deleted successfully";
            }
            
            return response()->json([
                'error' => false,
                'message' => $message,
                'data' => [
                    //'token' => $request->header('Authorization'),
                    'user' => new UserResource($getUser),
                    ]
                ], 200);
        }catch(\Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()], 200);
        }
    }
    
    /**
     * This method is used to update User profile
     */
    public function updateProfile(Request $request){
        try{
            $input = $request->all();
            $validator = Validator::make($input, [
                'full_name' => 'bail',
                'image' => 'bail|image|mimes:jpeg,png,jpg,JPEG,PNG,JPG,MPEG,heif,heic,heif-sequence,heic-sequence',
                'front_license_image' => 'bail|image|mimes:jpeg,png,jpg,JPEG,PNG,JPG,MPEG,heif,heic,heif-sequence,heic-sequence',
                'back_license_image' => 'bail|image|mimes:jpeg,png,jpg,JPEG,PNG,JPG,MPEG,heif,heic,heif-sequence,heic-sequence',
                'upload_insurance_document_image' => 'bail|image|mimes:jpeg,png,jpg,JPEG,PNG,JPG,MPEG,heif,heic,heif-sequence,heic-sequence',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => true, 'message' => $validator->errors()->first()], 200);
            }
            if($request->hasFile('image')){
                $input['image_url'] = $this->uploadFile($request->file('image'), auth()->id());
            }
            if($request->hasFile('front_license_image')){
                $input['front_license'] = $this->uploadFile($request->file('front_license_image'), auth()->id());
            }
            if($request->hasFile('back_license_image')){
                $input['back_license'] = $this->uploadFile($request->file('back_license_image'), auth()->id());
            }
            if($request->hasFile('upload_insurance_document_image')){
                $input['document'] = $this->uploadFile($request->file('upload_insurance_document_image'), auth()->id());
            }
            auth()->user()->update($input);
            return response()->json([
                'error' => false,
                'message' => 'Update user profile successfully',
                'data' => [
                    'token' => $request->header('Authorization'),
                    'user' => new UserResource(auth()->user()),
                    ]
                ], 200);
        }catch(\Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()], 200);
        }
    }
    /**
     * This method is used to update User current password
     */
    public function resetPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'current_password' => 'bail|required',
            'password' => 'bail|required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], 200);
        }
        $getUser = auth()->user();
        if(!(Hash::check($request->current_password, $getUser->password))){
            return response()->json(['error' => true, 'message' => 'Invalid old password.'], 200);
        }
        auth()->user()->update($request->all());
        return response()->json([
            'error' => false,
            'message' => 'Update user password successfully',
            'data' => [
                'token' => explode(' ', $request->header('Authorization'))[1],
                'user' => new UserResource(auth()->user()),
            ]
        ], 200);
    }
    /**
     * This method is used to login or sign up through social account details
     */
    public function socialLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'provider_type' => 'required|in:facebook,twitter,google,apple',
            'provider_id' => 'required',
            'profile_type' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], 200);
        }
        DB::beginTransaction();
        if(isset($request->email))
        {
            $getUser = User::getUser($request->email);
            if(!$getUser){
                $fullName = $request->full_name ?? strstr($request->email, '@', true);            ;
                $getUser = User::create(['email' => $request->email, 'full_name' => $fullName,'profile_type'=>$request->profile_type, 'is_verified' => true]);
                $getUser->userSocial()->create(['provider_type' => $request->provider_type, 'provider_id' => $request->provider_id]);
            }
            $getUserHasSocial = User::whereHas('userSocial', function ($query) use ($request) {
                $query->where(['provider_type' => $request->provider_type, 'provider_id' => $request->provider_id]);
            })->first();
            if(!$getUserHasSocial){
                $getUser->userSocial()->create(['provider_type' => $request->provider_type, 'provider_id' => $request->provider_id]);
            }
        }
        else
        {
            $getUserHasSocial = User::whereHas('userSocial', function ($query) use ($request) {
                $query->where(['provider_type' => $request->provider_type, 'provider_id' => $request->provider_id]);
            })->first();
            if(!$getUserHasSocial){
                
                $fullName = " ";
                $getUser = User::create(['email' => " ", 'full_name' => $fullName,'profile_type'=>$request->profile_type, 'is_verified' => true]);
                $getUser->userSocial()->create(['provider_type' => $request->provider_type, 'provider_id' => $request->provider_id]);
            }
            else
            {
                $getUser = User::getUser($getUserHasSocial->id);
                //$getUser->userSocial()->create(['provider_type' => $request->provider_type, 'provider_id' => $request->provider_id]);
            }
            
        }
        
        
        DB::commit();
        return response()->json([
            'error' => false,
            'message' => 'User created successfully.',
            'data' => [
                'token' => $getUser->createToken('PremierAutoCarRental')->plainTextToken,
                'user' => new UserResource($getUser),
            ]
        ], 200);
    }
   
    /**
     * This method is used to get all the categories
     */
    public function getCategory()
    {
        return response()->json(['error' => false, 'message' => 'Category Detail', 'data' => Category::where('status', 1)->select('id','name','isStoreLabelHidden')->orderBy('position', 'asc')->get()], 200);
    }
    /**
     * This method is used to get the dashboard
     */
    public function getTopDashboard(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language' => 'required',
            'country_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], 200);
        }
        $data=[];
        if($request->language == 'en')
        {
        $data['top_coupens']=Coupon::where('status', 1)
        ->where('is_top', 1)
        ->where('country_id', $request->country_id)
        ->select('id','name','arabic_name as second_name','description','detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','name','description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','name');
            },*/
            'country'=> function ($query) {
                $query->select('id','name','arabic_name as second_name','image_url');
            }])
        ->withCount(['couponWork','couponNotWork'])
        ->orderBy('position', 'asc')
        ->limit(10)
        ->get();
        $data['top_stores']=Brand::where('status', 1)
        ->select('id','name','description','url_link','category_id','isVisitStoreEnable','isStoreLabelHidden','percentage','bg_image_url','profile_image_url')
        //->where('country_id', $request->country_id)
        ->with(['category'=> function ($query) {
                $query->select('id','name');
            },'coupons'=> function ($query) {
                $query->select('id','brand_id','country_id','name','description','percentage','image_url','url_link','coupon_no','status','is_copy_open_url_link');
            },
            'coupons.country'=> function ($query) {
                $query->select('id','name','image_url');
            }])
        ->orderBy('position', 'asc')->take(5)->get();
        }
        if($request->language == 'ar')
        {
        $data['top_coupens']=Coupon::where('status', 1)
        ->where('is_top', 1)
        ->where('country_id', $request->country_id)
        ->select('id','arabic_name as name','name as second_name','arabic_description as description','arabic_detail as detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','arabic_name as name','arabic_description as description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','arabic_name as name');
            },*/
            'country'=> function ($query) {
                $query->select('id','arabic_name as name','name as second_name','image_url');
            }])
        ->withCount(['couponWork','couponNotWork'])
        ->orderBy('position', 'asc')
        ->limit(10)
        ->get();
        $data['top_stores']=Brand::where('status', 1)
        ->select('id','arabic_name as name','arabic_description as description','url_link','category_id','isVisitStoreEnable','isStoreLabelHidden','percentage','bg_image_url','profile_image_url')
        //->where('country_id', $request->country_id)
        ->with(['category'=> function ($query) {
                $query->select('id','arabic_name as name');
            },'coupons'=> function ($query) {
                $query->select('id','brand_id','country_id','arabic_name as name','arabic_description as description','percentage','image_url','url_link','coupon_no','status','is_copy_open_url_link');
            },
            'coupons.country'=> function ($query) {
                $query->select('id','arabic_name as name','image_url');
            }])
        ->orderBy('position', 'asc')->take(5)->get();
        
        }
        return response()->json(['error' => false, 'message' => 'Top Stores/Coupons Detail', 'data' => $data], 200);
    }
    /**
     * This method is used to get the dashboard
     */
    public function getDashboard(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language' => 'required',
            'country_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], 200);
        }
        $data=[];
        if($request->language == 'en')
        {
        $data['top_coupens']=Coupon::where('status', 1)
        ->where('is_top', 1)
        ->where('country_id', $request->country_id)
        ->select('id','name','arabic_name as second_name','description','detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','name','description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','name');
            },*/
            'country'=> function ($query) {
                $query->select('id','name','arabic_name as second_name','image_url');
            }])
        ->withCount(['couponWork','couponNotWork'])
        ->orderBy('position', 'asc')
        ->limit(10)
        ->get();
        /*$data['top_brand']=Brand::where('status', 1)
        ->select('id','name','description','image_url','category_id')
        //->where('country_id', $request->country_id)
        ->with(['category'=> function ($query) {
                $query->select('id','name');
            },'coupons'=> function ($query) {
                $query->select('id','brand_id','country_id','name','description','percentage','image_url','url_link','coupon_no','status');
            },
            'coupons.country'=> function ($query) {
                $query->select('id','name','image_url');
            }])
        ->orderBy('position', 'asc')->take(5)->get();
        */
        $data['categories']=Category::where('status', 1)
        ->select('id','description','name','arabic_name as second_name','image_url','isStoreLabelHidden')
        //->where('country_id', $request->country_id)
        /*->with(['brand'=> function ($query) {
                $query->select('id','category_id','name','description','image_url','url_link','status');
            },'brand.coupons'=> function ($query) {
                $query->select('id','brand_id','country_id','name','description','percentage','image_url','url_link','coupon_no','status');
            },
            'brand.coupons.country'=> function ($query) {
                $query->select('id','name','image_url');
            }])*/
        ->orderBy('position', 'asc')->get();
        /*$data['brands']=Brand::where('status', 1)
        ->select('id','name','description','image_url','url_link','category_id')
        //->where('country_id', $request->country_id)
        ->with(['category'=> function ($query) {
                $query->select('id','name');
            },'coupons'=> function ($query) {
                $query->select('id','brand_id','country_id','name','description','percentage','image_url','url_link','coupon_no','status');
            },
            'coupons.country'=> function ($query) {
                $query->select('id','name','image_url');
            }])
        ->orderBy('position', 'desc')->get();
        */
        $data['coupens']=Coupon::where('status', 1)
        ->where('country_id', $request->country_id)
        ->select('id','name','arabic_name as second_name','description','detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','name','description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','name');
            },*/
            'country'=> function ($query) {
                $query->select('id','name','image_url');
            }])
        ->withCount(['couponWork','couponNotWork'])
        ->orderBy('id', 'desc')->get();
        }
        if($request->language == 'ar')
        {
        $data['top_coupens']=Coupon::where('status', 1)
        ->where('is_top', 1)
        ->where('country_id', $request->country_id)
        ->select('id','arabic_name as name','name as second_name','arabic_description as description','arabic_detail as detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','arabic_name as name','arabic_description as description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','arabic_name as name');
            },*/
            'country'=> function ($query) {
                $query->select('id','arabic_name as name','name as second_name','image_url');
            }])
        ->withCount(['couponWork','couponNotWork'])
        ->orderBy('position', 'asc')
        ->limit(10)
        ->get();
        /*$data['top_brand']=Brand::where('status', 1)
        ->select('id','arabic_name as name','arabic_description as description','image_url','category_id')
        //->where('country_id', $request->country_id)
        ->with(['category'=> function ($query) {
                $query->select('id','arabic_name as name');
            },'coupons'=> function ($query) {
                $query->select('id','brand_id','country_id','arabic_name as name','arabic_description as description','percentage','image_url','url_link','coupon_no','status');
            },
            'coupons.country'=> function ($query) {
                $query->select('id','arabic_name as name','image_url');
            }])
        ->orderBy('position', 'asc')->take(5)->get();
        */
        $data['categories']=Category::where('status', 1)
        ->select('id','arabic_name as name','name as second_name','arabic_description as description','image_url','isStoreLabelHidden')
        //->where('country_id', $request->country_id)
        /*->with([
            'brand'=> function ($query) {
                $query->select('id','category_id','arabic_name as name','arabic_description as description','image_url','url_link','status');
            },'brand.coupons'=> function ($query) {
                $query->select('id','brand_id','country_id','arabic_name as name','arabic_description as description','percentage','image_url','url_link','coupon_no','status');
            },
            'brand.coupons.country'=> function ($query) {
                $query->select('id','arabic_name as name','image_url');
            }])*/
        ->orderBy('position', 'asc')->get();
        /*$data['brands']=Brand::where('status', 1)
        ->select('id','arabic_name as name','arabic_description as description','image_url','url_link','category_id')
        //->where('country_id', $request->country_id)
        ->with(['category'=> function ($query) {
                $query->select('id','arabic_name as name');
            },'coupons'=> function ($query) {
                $query->select('id','brand_id','country_id','arabic_name as name','arabic_description as description','percentage','image_url','url_link','coupon_no','status');
            },
            'coupons.country'=> function ($query) {
                $query->select('id','arabic_name as name','image_url');
            }])
        ->orderBy('position', 'desc')->get();
        */
        $data['coupens']=Coupon::where('status', 1)
        ->where('country_id', $request->country_id)
        ->select('id','arabic_name as name','name as second_name','arabic_description as description','arabic_detail as detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','arabic_name as name','arabic_description as description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) { 
                $query->select('id','arabic_name as name');
            },*/
            'country'=> function ($query) {
                $query->select('id','arabic_name as name','name as second_name','image_url');
            }])
        ->withCount(['couponWork','couponNotWork'])
        ->orderBy('id', 'desc')->get();
        }
        return response()->json(['error' => false, 'message' => 'Dashboard Detail', 'data' => $data], 200);
    }
    /**
     * This method is used to get all the brands
     */
    public function getDashboardSearch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language' => 'required',
            'country_id' => 'required',
            'search' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], 200);
        }
        $data=[];
        $search=$request->search;
        if($request->language == 'en')
        {
        $data['top_coupens']=Coupon::where('status', 1)
        ->where('is_top', 1)
        ->where('country_id', $request->country_id)
        ->where('name', 'like', '%'.$search.'%')
        ->orWhere('description', 'like', '%'.$search.'%')
        ->orWhere('coupon_no', 'like', '%'.$search.'%')
        ->select('id','name','arabic_name as second_name','description','detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','name','description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','name');
            },*/
            'country'=> function ($query) {
                $query->select('id','name','arabic_name as second_name','image_url');
            }])
        ->withCount(['couponWork','couponNotWork'])
        ->orderBy('position', 'asc')
        ->limit(10)
        ->get();
        /*$data['top_brand']=Brand::where('status', 1)
        ->select('id','name','description','image_url','category_id')
        //->where('country_id', $request->country_id)
        ->with(['category'=> function ($query) {
                $query->select('id','name');
            },'coupons'=> function ($query) {
                $query->select('id','brand_id','country_id','name','description','percentage','image_url','url_link','coupon_no','status');
            },
            'coupons.country'=> function ($query) {
                $query->select('id','name','image_url');
            }])
        ->orderBy('position', 'asc')->take(5)->get();
        */
        $data['categories']=Category::where('status', 1)
        ->select('id','description','name','arabic_name as second_name','image_url','isStoreLabelHidden')
        ->where('name', 'like', '%'.$search.'%')
        ->orWhere('description', 'like', '%'.$search.'%')
        //->where('country_id', $request->country_id)
        /*->with(['brand'=> function ($query) {
                $query->select('id','category_id','name','description','image_url','url_link','status');
            },'brand.coupons'=> function ($query) {
                $query->select('id','brand_id','country_id','name','description','percentage','image_url','url_link','coupon_no','status');
            },
            'brand.coupons.country'=> function ($query) {
                $query->select('id','name','image_url');
            }])*/
        ->orderBy('position', 'asc')->get();
        /*$data['brands']=Brand::where('status', 1)
        ->select('id','name','description','image_url','url_link','category_id')
        //->where('country_id', $request->country_id)
        ->with(['category'=> function ($query) {
                $query->select('id','name');
            },'coupons'=> function ($query) {
                $query->select('id','brand_id','country_id','name','description','percentage','image_url','url_link','coupon_no','status');
            },
            'coupons.country'=> function ($query) {
                $query->select('id','name','image_url');
            }])
        ->orderBy('position', 'desc')->get();
        */
        $data['coupens']=Coupon::where('status', 1)
        ->where('country_id', $request->country_id)
        ->where('name', 'like', '%'.$search.'%')
        ->orWhere('description', 'like', '%'.$search.'%')
        ->orWhere('coupon_no', 'like', '%'.$search.'%')
        ->select('id','name','arabic_name as second_name','description','detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','name','description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','name');
            },*/
            'country'=> function ($query) {
                $query->select('id','name','image_url');
            }])
        ->withCount(['couponWork','couponNotWork'])
        ->orderBy('id', 'desc')->get();
        }
        if($request->language == 'ar')
        {
        $data['top_coupens']=Coupon::where('status', 1)
        ->where('is_top', 1)
        ->where('country_id', $request->country_id)
        ->where('arabic_name', 'like', '%'.$search.'%')
        ->orWhere('arabic_description', 'like', '%'.$search.'%')
        ->orWhere('coupon_no', 'like', '%'.$search.'%')
        ->select('id','arabic_name as name','name as second_name','arabic_description as description','arabic_detail as detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','arabic_name as name','arabic_description as description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','arabic_name as name');
            },*/
            'country'=> function ($query) {
                $query->select('id','arabic_name as name','name as second_name','image_url');
            }])
        ->withCount(['couponWork','couponNotWork'])
        ->orderBy('position', 'asc')
        ->limit(10)
        ->get();
        /*$data['top_brand']=Brand::where('status', 1)
        ->select('id','arabic_name as name','arabic_description as description','image_url','category_id')
        //->where('country_id', $request->country_id)
        ->with(['category'=> function ($query) {
                $query->select('id','arabic_name as name');
            },'coupons'=> function ($query) {
                $query->select('id','brand_id','country_id','arabic_name as name','arabic_description as description','percentage','image_url','url_link','coupon_no','status');
            },
            'coupons.country'=> function ($query) {
                $query->select('id','arabic_name as name','image_url');
            }])
        ->orderBy('position', 'asc')->take(5)->get();
        */
        $data['categories']=Category::where('status', 1)
        ->where('arabic_name', 'like', '%'.$search.'%')
        ->orWhere('arabic_description', 'like', '%'.$search.'%')
        ->select('id','arabic_name as name','name as second_name','arabic_description as description','image_url','isStoreLabelHidden')
        //->where('country_id', $request->country_id)
        /*->with([
            'brand'=> function ($query) {
                $query->select('id','category_id','arabic_name as name','arabic_description as description','image_url','url_link','status');
            },'brand.coupons'=> function ($query) {
                $query->select('id','brand_id','country_id','arabic_name as name','arabic_description as description','percentage','image_url','url_link','coupon_no','status');
            },
            'brand.coupons.country'=> function ($query) {
                $query->select('id','arabic_name as name','image_url');
            }])*/
        ->orderBy('position', 'asc')->get();
        /*$data['brands']=Brand::where('status', 1)
        ->select('id','arabic_name as name','arabic_description as description','image_url','url_link','category_id')
        //->where('country_id', $request->country_id)
        ->with(['category'=> function ($query) {
                $query->select('id','arabic_name as name');
            },'coupons'=> function ($query) {
                $query->select('id','brand_id','country_id','arabic_name as name','arabic_description as description','percentage','image_url','url_link','coupon_no','status');
            },
            'coupons.country'=> function ($query) {
                $query->select('id','arabic_name as name','image_url');
            }])
        ->orderBy('position', 'desc')->get();
        */
        $data['coupens']=Coupon::where('status', 1)
        ->where('country_id', $request->country_id)
        ->where('arabic_name', 'like', '%'.$search.'%')
        ->orWhere('arabic_description', 'like', '%'.$search.'%')
        ->orWhere('coupon_no', 'like', '%'.$search.'%')
        ->select('id','arabic_name as name','name as second_name','arabic_description as description','arabic_detail as detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','arabic_name as name','arabic_description as description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','arabic_name as name');
            },*/
            'country'=> function ($query) {
                $query->select('id','arabic_name as name','name as second_name','image_url');
            }])
        ->withCount(['couponWork','couponNotWork'])
        ->orderBy('id', 'desc')->get();
        }
        return response()->json(['error' => false, 'message' => 'Dashboard Search Detail', 'data' => $data], 200);
    }
    
    public function getCouponSearch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language' => 'required',
            'country_id' => 'required',
            'search' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], 200);
        }
        $data=[];
        $search=$request->search;
        if($request->language == 'en')
        {
        $data=Coupon::where('status', 1)
        //->where('is_top', 1)
        ->where('country_id', $request->country_id)
        ->where('name', 'like', '%'.$search.'%')
        ->orWhere('description', 'like', '%'.$search.'%')
        ->orWhere('coupon_no', 'like', '%'.$search.'%')
        ->select('id','name','arabic_name as second_name','description','detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','name','description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','name');
            },*/
            'country'=> function ($query) {
                $query->select('id','name','image_url');
            }])
        ->withCount(['couponWork','couponNotWork'])
        ->orderBy('id', 'desc')->get();
        }
        if($request->language == 'ar')
        {
        $data=Coupon::where('status', 1)
        //->where('is_top', 1)
        ->where('country_id', $request->country_id)
        ->where('arabic_name', 'like', '%'.$search.'%')
        ->orWhere('arabic_description', 'like', '%'.$search.'%')
        ->orWhere('coupon_no', 'like', '%'.$search.'%')
        ->select('id','arabic_name as name','name as second_name','arabic_description as description','arabic_detail as detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','arabic_name as name','arabic_description as description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','arabic_name as name');
            },*/
            'country'=> function ($query) {
                $query->select('id','arabic_name as name','name as second_name','image_url');
            }])
        ->withCount(['couponWork','couponNotWork'])
        ->orderBy('id', 'desc')->get();
        }
        return response()->json(['error' => false, 'message' => 'Dashboard Search Detail', 'data' => $data], 200);
    }
    /**
     * This method is used to get all the brands
     */
    public function getBrand(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], 200);
        }
        $data='';
        if($request->language == 'en')
        {
            $data=Brand::where('status', 1)->select('id','name','arabic_name as second_name','description','isVisitStoreEnable','isStoreLabelHidden','url_link','category_id','percentage','bg_image_url','profile_image_url')
            ->with(['category'=> function ($query) {
                $query->select('id','name','arabic_name as second_name');
            },'coupons'=> function ($query) {
                $query->select('id','brand_id','country_id','name','arabic_name as second_name','description','percentage','image_url','url_link','coupon_no','status');
            },
            'coupons.country'=> function ($query) {
                $query->select('id','name','arabic_name as second_name','image_url');
            }])
            ->orderBy('position', 'desc')->get();
        }
        if($request->language == 'ar')
        {
            $data=Brand::where('status', 1)
            ->select('id','arabic_name as name','name as second_name','arabic_description as description','image_url','category_id','percentage','bg_image_url')
            ->with(['category'=> function ($query) {
                $query->select('id','arabic_name as name','name as second_name');
            },'coupons'=> function ($query) {
                $query->select('id','brand_id','country_id','arabic_name as name','name as second_name','arabic_description as description','percentage','image_url','url_link','coupon_no','status');
            },
            'coupons.country'=> function ($query) {
                $query->select('id','arabic_name as name','name as second_name','image_url');
            }])
            ->orderBy('position', 'desc')->get();
        }
        return response()->json(['error' => false, 'message' => 'Brands Detail', 'data' => $data], 200);
    }
    public function getBrandByID(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language' => 'required',
            'brand_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], 200);
        }
        $data='';
        if($request->language == 'en')
        {
            $data=Brand::where('id', $request->brand_id)
            ->select('id','name','arabic_name as second_name','description','url_link','category_id','isVisitStoreEnable','percentage','bg_image_url','profile_image_url')
            ->with(['category'=> function ($query) {
                $query->select('id','name','arabic_name as second_name');
            },'coupons'=> function ($query) {
                $query->select('id','brand_id','country_id','name','arabic_name as second_name','description','percentage','image_url','url_link','coupon_no','status');
            },
            'coupons.country'=> function ($query) {
                $query->select('id','name','arabic_name as second_name','image_url');
            }])
            ->orderBy('position', 'desc')
            ->get();
        }
        if($request->language == 'ar')
        {
            $data=Brand::where('id', $request->brand_id)
            ->select('id','arabic_name as name','name as second_name','arabic_description as description','isVisitStoreEnable','isStoreLabelHidden','url_link','category_id','percentage','bg_image_url','profile_image_url')
            ->with(['category'=> function ($query) {
                $query->select('id','arabic_name as name','name as second_name');
            },'coupons'=> function ($query) {
                $query->select('id','brand_id','country_id','arabic_name as name','name as second_name','arabic_description as description','percentage','image_url','url_link','coupon_no','status');
            },
            'coupons.country'=> function ($query) {
                $query->select('id','arabic_name as name','name as second_name','image_url');
            }])
            ->orderBy('position', 'desc')
            ->get();
        }
        return response()->json(['error' => false, 'message' => 'Brands Detail By ID', 'data' => $data], 200);
    }
    
    public function getBrandByCategoryID(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language' => 'required',
            'category_id' => 'required',
            'country_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], 200);
        }
        $cat_id=$request->category_id;
        $country_id=$request->country_id;
        
        $brand_id = CategoryBrand::where('category_id', $request->category_id)->get()->pluck('brand_id')->toArray();
        $getCoupon=Coupon::where('country_id',$country_id)->get();
        $brand_ids=Coupon::where('country_id',$country_id)->whereIn('brand_id',$brand_id)->get()->pluck('brand_id')->toArray();
        //return $brand_id;
        if (count($getCoupon) == 0) 
        {
            return response()->json(['error' => false, 'message' => 'No Record Found.','data' => []], 200);
        }
        if($cat_id == 24)
        {
            $brand_id = CategoryBrand::where('status', 1)->get()->pluck('brand_id')->toArray();
            $brand_ids=Coupon::where('country_id',$country_id)->whereIn('brand_id',$brand_id)->get()->pluck('brand_id')->toArray();
        }
        //return $brand_ids;
        $data='';
        if($request->language == 'en')
        {
            $data=Brand::whereIn('id',$brand_ids)
            //->where('country_id',$request->country_id)
            ->select('id','name','arabic_name as second_name','description','url_link','category_id','isStoreLabelHidden','percentage','bg_image_url','profile_image_url')
            ->with(['category'=> function ($query) {
                $query->select('id','name','arabic_name as second_name');
            },'coupons'=> function ($query) use($cat_id,$country_id){
                $query->select('id','brand_id','country_id','name','arabic_name as second_name','description','percentage','image_url','url_link','coupon_no','status','is_copy_open_url_link');
                if($cat_id != 24)
                $query->where('category_id',$cat_id);
                $query->where('country_id',$country_id);
            },
            'coupons.country'=> function ($query) {
                $query->select('id','name','arabic_name as second_name','image_url');
            }])
            ->orderBy('position', 'desc')
            ->get();
        }
        if($request->language == 'ar')
        {
            $cat_id=$request->category_id;
            $data=Brand::whereIn('id',$brand_ids)
            //->where('country_id',$request->country_id)
            ->select('id','arabic_name as name','name as second_name','arabic_description as description','isVisitStoreEnable','isStoreLabelHidden','url_link','category_id','percentage','bg_image_url','profile_image_url')
            ->with(['category'=> function ($query) {
                $query->select('id','arabic_name as name','name as second_name');
            },'coupons'=> function ($query) use($cat_id,$country_id) {
                $query->select('id','brand_id','country_id','arabic_name as name','name as second_name','arabic_description as description','percentage','image_url','url_link','coupon_no','status','is_copy_open_url_link');
                if($cat_id != 24)
                $query->where('category_id',$cat_id);
                $query->where('country_id',$country_id);
            },
            'coupons.country'=> function ($query) {
                $query->select('id','arabic_name as name','name as second_name','image_url');
            }])
            ->orderBy('position', 'desc')
            ->get();
        }
        return response()->json(['error' => false, 'message' => 'Brands Detail By Category ID', 'data' => $data], 200);
    }
    public function getBrandByCategoryIDDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language' => 'required',
            'category_id' => 'required',
            'country_id' => 'required',
            'brand_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], 200);
        }
        
        $cat_id=$request->category_id;
        $country_id=$request->country_id;
        $brand_ids = $request->brand_id;
        //return $brand_ids;
        $getCoupon=Coupon::where('country_id',$country_id)->get();
        
        $data='';
        if($request->language == 'en')
        {
            $data=Brand::where('id',$brand_ids)
            //->where('country_id',$request->country_id)
            ->select('id','name','arabic_name as second_name','description','isVisitStoreEnable','isStoreLabelHidden','url_link','category_id','percentage','bg_image_url','profile_image_url')
            ->with(['category'=> function ($query) {
                $query->select('id','name','arabic_name as second_name');
            },'coupons'=> function ($query) use($cat_id,$country_id){
                $query->select('id','brand_id','country_id','name','arabic_name as second_name','description','percentage','image_url','url_link','coupon_no','status','is_copy_open_url_link');
                if($cat_id != 24)
                $query->where('category_id',$cat_id);
                $query->where('country_id',$country_id);
            },
            'coupons.country'=> function ($query) {
                $query->select('id','name','arabic_name as second_name','image_url');
            }])
            ->orderBy('position', 'desc')
            ->first();
        }
        if($request->language == 'ar')
        {
            $cat_id=$request->category_id;
            $data=Brand::where('id',$brand_ids)
            //->where('country_id',$request->country_id)
            ->select('id','arabic_name as name','name as second_name','arabic_description as description','isVisitStoreEnable','isStoreLabelHidden','url_link','category_id','percentage','bg_image_url','profile_image_url')
            ->with(['category'=> function ($query) {
                $query->select('id','arabic_name as name','name as second_name');
            },'coupons'=> function ($query) use($cat_id,$country_id) {
                $query->select('id','brand_id','country_id','arabic_name as name','name as second_name','arabic_description as description','percentage','image_url','url_link','coupon_no','status','is_copy_open_url_link');
                if($cat_id != 24)
                $query->where('category_id',$cat_id);
                $query->where('country_id',$country_id);
            },
            'coupons.country'=> function ($query) {
                $query->select('id','arabic_name as name','name as second_name','image_url');
            }])
            ->orderBy('position', 'desc')
            ->first();
        }
        return response()->json(['error' => false, 'message' => 'Brands Detail', 'data' => $data], 200);
    }
    public function getCategories(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], 200);
        }
        $data='';
        if($request->language == 'en')
        {
            $data=Category::where('status', 1)
            ->select('id','name','arabic_name as second_name','description','image_url','isStoreLabelHidden')
            /*->with([
                'brand'=> function ($query) {
                $query->select('id','category_id','name','description','image_url','url_link','status');
            },'brand.coupons'=> function ($query) {
                $query->select('id','brand_id','country_id','name','description','percentage','image_url','url_link','coupon_no','status');
            },
            'brand.coupons.country'=> function ($query) {
                $query->select('id','name','image_url');
            }])*/
            ->orderBy('position', 'asc')->get();
        }
        if($request->language == 'ar')
        {
            $data=Category::where('status', 1)
            ->select('id','arabic_name as name','name as second_name','arabic_description as description','image_url','isStoreLabelHidden')
            /*->with(['brand'=> function ($query) {
                $query->select('id','category_id','arabic_name as name','arabic_description as description','image_url','url_link','status');
            },'brand.coupons'=> function ($query) {
                $query->select('id','brand_id','country_id','arabic_name as name','arabic_description as description','percentage','image_url','url_link','coupon_no','status');
            },
            'brand.coupons.country'=> function ($query) {
                $query->select('id','arabic_name as name','image_url');
            }])*/
            ->orderBy('position', 'asc')->get();
        }
        return response()->json(['error' => false, 'message' => 'Categories Detail','isStoreLabelHidden' => (bool)1, 'data' => $data], 200);
    }
    public function getCategoriesByID(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language' => 'required',
            'category_id' => 'required',
            'country_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], 200);
        }
        $ids=explode(',',$request->category_id);
        if(in_array(24, $ids))
        {
            $data='';
            if($request->language == 'en')
            {
            $data=Coupon::where('status', 1)
            ->where('country_id', $request->country_id)
            ->select('id','name','arabic_name as second_name','description','detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
            ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','name','description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','name');
            },*/
            'country'=> function ($query) {
                $query->select('id','name','arabic_name as second_name','image_url');
            }])
            ->withCount(['couponWork','couponNotWork'])
            ->orderBy('id', 'desc')->get();
            }
            if($request->language == 'ar')
            {
            $data=Coupon::where('status', 1)
            ->where('country_id', $request->country_id)
            ->select('id','arabic_name as name','name as second_name','arabic_description as description','arabic_detail as detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
            ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','arabic_name as name','arabic_description as description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','arabic_name as name');
            },*/
            'country'=> function ($query) {
                $query->select('id','arabic_name as name','name as second_name','image_url');
            }])
            ->withCount(['couponWork','couponNotWork'])
            ->orderBy('id', 'desc')->get();
            }
            return response()->json(['error' => false, 'message' => 'Coupens Detail By categories IDs', 'data' => $data], 200);
        }
        //$brand_ids=Brand::whereIn('category_id', $ids)->get()->pluck('id');
        //return  $brand_ids;
        //$data=Category::whereIn('id', $ids)->select('id','name','description','image_url')->with('brand.coupons')->orderBy('position', 'asc')->get();
        $data='';
        if($request->language == 'en')
        {
        $data=Coupon::whereIn('category_id', $ids)
        ->where('country_id', $request->country_id)
        ->select('id','name','arabic_name as second_name','description','detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','name','description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','name');
            },*/
            'country'=> function ($query) {
                $query->select('id','name','arabic_name as second_name','image_url');
            }])
        ->withCount(['couponWork','couponNotWork'])
        ->orderBy('id', 'desc')->get();
        }
        if($request->language == 'ar')
        {
        $data=Coupon::whereIn('category_id', $ids)
        ->where('country_id', $request->country_id)
        ->select('id','arabic_name as name','name as second_name','arabic_description as description','arabic_detail as detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','arabic_name as name','arabic_description as description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','arabic_name as name');
            },*/
            'country'=> function ($query) {
                $query->select('id','arabic_name as name','name as second_name','image_url');
            }])
        ->withCount(['couponWork','couponNotWork'])
        ->orderBy('id', 'desc')->get();
        }
        return response()->json(['error' => false, 'message' => 'Coupens Detail By categories IDs', 'data' => $data], 200);
    }
    public function getCoupons(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], 200);
        }
        $data='';
        if($request->language == 'en')
        {
        $data=Coupon::where('status', 1)
        ->select('id','name','arabic_name as second_name','description','detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','name','description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','name');
            },*/
            'country'=> function ($query) {
                $query->select('id','name','arabic_name as second_name','image_url');
            }])
        ->withCount(['couponWork','couponNotWork'])
        ->orderBy('id', 'desc')->get();
        }
        if($request->language == 'ar')
        {
        $data=Coupon::where('status', 1)
        ->select('id','arabic_name as name','name as second_name','arabic_description as description','arabic_detail as detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','arabic_name as name','arabic_description as description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','arabic_name as name');
            },*/
            'country'=> function ($query) {
                $query->select('id','arabic_name as name','name as second_name','image_url');
            }])
        ->withCount(['couponWork','couponNotWork'])
        ->orderBy('id', 'desc')->get();
        }
        return response()->json(['error' => false, 'message' => 'Coupons Detail', 'data' => $data], 200);
    }
    public function getCouponsByID(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coupon_id' => 'required',
            'language' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], 200);
        }
        $country_data=CouponItem::where('coupon_id', $request->coupon_id)->get()->pluck('item_id');
        //return $country_data;
        //$data='';
        if($request->language == 'en')
        {
        $data=Coupon::where('id', $request->coupon_id)
        ->select('id','name','arabic_name as second_name','description','detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','name','description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','name');
            },*/
            'country'=> function ($query) {
                $query->select('id','name','arabic_name as second_name','image_url');
            }])
        ->withCount(['couponWork','couponNotWork'])
        ->orderBy('id', 'desc')->get();
            
        }
        if($request->language == 'ar')
        {
        $data=Coupon::where('id', $request->coupon_id)
        ->select('id','arabic_name as name','name as second_name','arabic_description as description','arabic_detail as detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','arabic_name as name','arabic_description as description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','arabic_name as name');
            },*/
            'country'=> function ($query) {
                $query->select('id','arabic_name as name','name as second_name','image_url');
            }])
        ->withCount(['couponWork','couponNotWork'])
        ->orderBy('id', 'desc')->get();
           
            
        
        }
        return response()->json(['error' => false, 'message' => 'Coupons Detail By ID', 'data' => $data], 200);
    }
    
    public function getRelatedCouponsByID(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coupon_id' => 'required',
            'language' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], 200);
        }
        $country_data=CouponItem::where('coupon_id', $request->coupon_id)->get()->pluck('item_id');
        //return $country_data;
        //$data='';
        if($request->language == 'en')
        {
        $data['coupon']=Coupon::where('id', $request->coupon_id)
        ->select('id','name','arabic_name as second_name','description','detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','name','description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','name');
            },*/
            'country'=> function ($query) {
                $query->select('id','name','arabic_name as second_name','image_url');
            }])
        ->withCount(['couponWork','couponNotWork'])
        ->orderBy('id', 'desc')->get();
        
        $data['related_coupon']=Coupon::whereIn('id', $country_data)
        ->select('id','name','arabic_name as second_name','description','detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','name','description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','name');
            },*/
            'country'=> function ($query) {
                $query->select('id','name','arabic_name as second_name','image_url');
            }])
        ->withCount(['couponWork','couponNotWork'])
        ->orderBy('id', 'desc')->get();
            
        }
        if($request->language == 'ar')
        {
        $data['coupon']=Coupon::where('id', $request->coupon_id)
        ->select('id','arabic_name as name','name as second_name','arabic_description as description','arabic_detail as detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','arabic_name as name','arabic_description as description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','arabic_name as name');
            },*/
            'country'=> function ($query) {
                $query->select('id','arabic_name as name','name as second_name','image_url');
            }])
        ->withCount(['couponWork','couponNotWork'])
        ->orderBy('id', 'desc')->get();
        $data['related_coupon']=Coupon::whereIn('id', $country_data)
        ->select('id','arabic_name as name','name as second_name','arabic_description as description','arabic_detail as detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','arabic_name as name','arabic_description as description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','arabic_name as name');
            },*/
            'country'=> function ($query) {
                $query->select('id','arabic_name as name','name as second_name','image_url');
            }])
        ->withCount(['couponWork','couponNotWork'])
        ->orderBy('id', 'desc')->get();
           
            
        
        }
        return response()->json(['error' => false, 'message' => 'Related Coupons Detail By ID', 'data' => $data], 200);
    }
    public function getCouponsByCountry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required',
            'language' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], 200);
        }
        $data='';
        if($request->language == 'en')
        {
        $data=Coupon::where('country_id', $request->country_id)
        ->select('id','name','arabic_name as second_name','description','detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','name','description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','name');
            },*/
            'country'=> function ($query) {
                $query->select('id','name','arabic_name as second_name','image_url');
            }])
        ->withCount(['couponWork','couponNotWork'])
        ->orderBy('id', 'desc')->get();
        }
        if($request->language == 'ar')
        {
        $data=Coupon::where('country_id', $request->country_id)
        ->select('id','arabic_name as name','name as second_name','arabic_description as description','arabic_detail as detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','arabic_name as name','arabic_description as description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','arabic_name as name');
            },*/
            'country'=> function ($query) {
                $query->select('id','arabic_name as name','name as second_name','image_url');
            }])
        ->withCount(['couponWork','couponNotWork'])
        ->orderBy('id', 'desc')->get();
        }
        return response()->json(['error' => false, 'message' => 'Coupons Detail By Country ID', 'data' => $data], 200);
    }
    
    public function getCouponsByCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'language' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], 200);
        }
        $data='';
        if($request->language == 'en')
        {
        $data=Coupon::where('category_id', $request->category_id)
        ->select('id','name','arabic_name as second_name','description','detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','name','description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','name');
            },*/
            'country'=> function ($query) {
                $query->select('id','name','arabic_name as second_name','image_url');
            }])
        ->withCount(['couponWork','couponNotWork'])
        ->orderBy('id', 'desc')->get();
        }
        if($request->language == 'ar')
        {
        $data=Coupon::where('category_id', $request->category_id)
        ->select('id','arabic_name as name','name as second_name','arabic_description as description','arabic_detail as detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','arabic_name as name','arabic_description as description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','arabic_name as name');
            },*/
            'country'=> function ($query) {
                $query->select('id','arabic_name as name','name as second_name','image_url');
            }])
        ->withCount(['couponWork','couponNotWork'])
        ->orderBy('id', 'desc')->get();
        }
        return response()->json(['error' => false, 'message' => 'Coupons Detail By Category ID', 'data' => $data], 200);
    }
    public function getCouponsByBrand(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_id' => 'required',
            'language' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], 200);
        }
        $data='';
        if($request->language == 'en')
        {
        $data=Coupon::where('brand_id', $request->brand_id)
        ->select('id','name','arabic_name as second_name','description','detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','name','description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','name');
            },*/
            'country'=> function ($query) {
                $query->select('id','name','arabic_name as second_name','image_url');
            }])
        ->withCount(['couponWork','couponNotWork'])
        ->orderBy('id', 'desc')->get();
        }
        if($request->language == 'ar')
        {
        $data=Coupon::where('brand_id', $request->brand_id)
        ->select('id','arabic_name as name','name as second_name','arabic_description as description','arabic_detail as detail','coupon_no','image_url','url_link','percentage','brand_id','country_id','category_id','is_copy_open_url_link')
        ->with([
            /*'brand'=> function ($query) {
                $query->select('id','category_id','arabic_name as name','arabic_description as description','image_url','url_link','status');
            },
            'brand.category'=> function ($query) {
                $query->select('id','arabic_name as name');
            },*/
            'country'=> function ($query) {
                $query->select('id','arabic_name as name','name as second_name','image_url');
            }])
        ->withCount(['couponWork','couponNotWork'])
        ->orderBy('id', 'desc')->get();
        }
        return response()->json(['error' => false, 'message' => 'Coupons Detail By Brand ID', 'data' => $data], 200);
    }
    public function addCoupon(Request $request)
    {
        $request->merge(['status' => 2]);
        $data = $request->all();
        $getLikeItem = Coupon::create($data);
        return response()->json(['error' => false, 'message' => 'Coupon added successfully.', 'data' => $getLikeItem], 200);
    }
    
    public function workCoupon(Request $request)
    {
        $getLikeItem = CouponLike::create(['coupon_id' => $request->coupon_id, 'is_like' => true]);
        return response()->json(['error' => false, 'message' => 'Work Coupon added successfully.', 'data' => ''], 200);
    }
    
    public function notworkCoupon(Request $request)
    {
        $getLikeItem = CouponLike::create(['coupon_id' => $request->coupon_id, 'is_like' => false]);
        return response()->json(['error' => false, 'message' => 'Not Work Coupon added successfully.', 'data' => ''], 200);
    }
    public function getCountries(Request $request)
    {
        $data='';
        if($request->language == 'en')
        {
            $data=Country::select('id','name','arabic_name as second_name','image_url')->get();
        }
        if($request->language == 'ar')
        {
            $data=Country::select('id','arabic_name as name','name as second_name','image_url')->get();
        }
        
        return response()->json(['error' => false, 'message' => 'All Countries Detail', 'data' => $data], 200);
    }
    
    
    /**
     * This method is used to get all the Items of the speciic categories
     */
    public function getItem(Request $request)
    {
        //return $request->category_id;
        return response()->json(['error' => false, 'message' => 'Vehicles by category detail', 'data' => ItemResource::collection(Item::where('category_id', $request->category_id)->get())], 200);
    }
    /**
     * This method is used to get all the Vehicles of the speciic brands
     */
    public function getBrands(Request $request)
    {
        //return $request->category_id;
        return response()->json(['error' => false, 'message' => 'Vehicles by Brand detail', 'data' => ItemResource::collection(Item::where('brand_name', $request->brand_id)->get())], 200);
    }
    /**
     * This method is used to get all the Items of the speciic categories
     */
    public function getVehicle(Request $request)
    {
        //return $request->category_id;
        return response()->json(['error' => false, 'message' => 'Vehicle Detail', 'data' => new ItemResource(Item::find($request->vehicle_id))], 200);
    }
    /**
     * This method is used to get all the Items of the speciic categories
     */
    public function getTrip(Request $request)
    {
        //return $request->category_id;
        /*
        $trip_data=Trip::where('id', $request->trip_id)->with(['user','item.images','before_image','after_image'])->first();
        $data=['email' => auth()->user()->email, 'trip_data' => $trip_data];
        
        //return $data['trip_data'];
        Mail::send(
            ['html' => 'emails.trip'],
            $data,
            function ($message) use ($data) {
                $message->to($data['email'])
                    ->from('support@PremierAutoCarRental.com','PremierAutoCarRental')
                    ->subject("New Trip Notification of PremierAutoCarRental APP");
            }
        );*/
    
        return response()->json(['error' => false, 'message' => 'Trip Detail', 'data' => new TripResource(Trip::find($request->trip_id))], 200);
    }
    /**
     * This method is used to get all the Items of the speciic categories
     */
    public function likeOrUnlikeItem(Request $request)
    {
        $getLikeItem = UserLikeItem::where(['user_id' => auth()->id(), 'item_id' => $request->vehicle_id, 'is_like' => true])->first();
        ($getLikeItem)
        ?   $getLikeItem->update(['is_like' => false])
        :   UserLikeItem::updateOrCreate(['user_id' => auth()->id(), 'item_id' => $request->vehicle_id], ['is_like' => true]);
        return response()->json(['error' => false, 'message' => 'Vehicle like/unlike successfully.', 'data' => new ItemResource(Item::find($request->vehicle_id))], 200);
    }
     /**
     * This method is used to cencel the trip
     */
    public function updateTrip(Request $request)
    {
        $getTrip = Trip::where(['user_id' => auth()->id(), 'id' => $request->trip_id])->first();
        ($getTrip)
        ?   $getTrip->update(['status' => $request->status])
        :   $getTrip->update(['status' => $request->status]);
        return response()->json(['error' => false, 'message' => 'Trip Status Updated successfully.', 'data' => new TripResource(Trip::find($request->trip_id))], 200);
    }
    
     /**
     * This method is used to cencel the trip
     */
    public function cancelTrip(Request $request)
    {
        $getTrip = Trip::where(['user_id' => auth()->id(), 'id' => $request->trip_id])->first();
        ($getTrip)
        ?   $getTrip->update(['status' => 0])
        :   $getTrip->update(['status' => 0]);
        
        $getUsers = User::where('is_admin', 1)->get();
        if($getUsers)
        {
            foreach($getUsers as $getUser)
            {
                $to_info=isset($getUser->device_token)?$getUser->device_token:'';
                $to_device=isset($getUser->device_type)?$getUser->device_type:'';
                $extra=[
                    'booking_type'=>'Cancel',
                    'trip_id'=>$getTrip->id
                ];
                //$extra=json_encode($extra);
                $payLoad=[
                    'subject'=>'Message',
                    'type'=>'Trip',
                    'to'=>$to_info,
                    'message'=>'Cancel Trip Notification',
                    'customData'=>$extra
                ];
                $isSent = $this->pushNotification($payLoad, $to_device);
                //return $isSent;
            }
        }
        return response()->json(['error' => false, 'message' => 'Trip Cancelled successfully.', 'data' => new TripResource(Trip::find($request->trip_id))], 200);
    }
    /**
     * This method is used to get all the Items of the speciic categories
     */
    public function favouriteItem(Request $request)
    {
        $getLikeItems = auth()->user()->userLikeItem->pluck('item_id');
        return response()->json(['error' => false, 'message' => 'My Liked/Favourite Vehicles', 'data' => ItemResource::collection(Item::whereIn('id', $getLikeItems)->get())], 200);
    }
    /**
     * This method is used to get all the categories item list
     */
    public function getCateoryItem(Request $request)
    {
        if($request->category_ids == 'all')
        {
            return response()->json(['error' => false, 'message' => 'All Vehical Data', 'data' => ItemResource::collection(Item::orderBy('title', 'asc')->get())], 200);
        }
        else
        {
            $getLikeItems=explode(',', $request->category_ids);
            return response()->json(['error' => false, 'message' => 'Vehicle Data by Category IDs', 'data' => ItemResource::collection(Item::whereIn('category_id', $getLikeItems)->get())], 200);
        }
            
    }
    /**
     * This method is used to get all the vehicle list
     */
    public function getCateoryID(Request $request)
    {
        if($request->category_id == 0)
        {
            $category_id=$request->category_id;
            return response()->json(['error' => false, 'message' => 'Vehicle Data by Category ID', 'data' => ItemResource::collection(Item::orderBy('title', 'asc')->get())], 200);
        }
        if($request->category_id != '')
        {
            $category_id=$request->category_id;
            return response()->json(['error' => false, 'message' => 'Vehicle Data by Category ID', 'data' => ItemResource::collection(Item::where('category_id', $category_id)->get())], 200);
        }
        if($request->destination_id == 0)
        {
            $destination_id=$request->destination_id;
            return response()->json(['error' => false, 'message' => 'Vehicle Data by Destination ID', 'data' => ItemResource::collection(Item::orderBy('title', 'asc')->get())], 200);
        }
        if($request->destination_id != '')
        {
            $destination_id=$request->destination_id;
            return response()->json(['error' => false, 'message' => 'Vehicle Data by Destination ID', 'data' => ItemResource::collection(Item::where('destination_id', $destination_id)->get())], 200);
        }
        if($request->brand_id == 0)
        {
            $brand_id=$request->brand_id;
            return response()->json(['error' => false, 'message' => 'Vehicle Data by Brand ID', 'data' => ItemResource::collection(Item::orderBy('title', 'asc')->get())], 200);
        }
        if($request->brand_id != '')
        {
            $brand_id=$request->brand_id;
            return response()->json(['error' => false, 'message' => 'Vehicle Data by Brand ID', 'data' => ItemResource::collection(Item::where('brand_name', $brand_id)->get())], 200);
        }
    }
     /**
     * This method is used to get all the vehicle list
     */
    public function getCateoryDefault(Request $request)
    {
        $destination_id=auth()->user()->destination_id;
        return response()->json(['error' => false, 'message' => 'Vehicle Data by Default Destination ID', 'data' => ItemResource::collection(Item::where('destination_id', $destination_id)->get())], 200);
        
    }
    
    /**
     * This method is used to get all the trips list
     */
    public function getAllTrip(Request $request)
    {
        $trip_data=Trip::orderBy('id', 'desc');
        if($request->status == 'complete')
        {
            $trip_data->where('status', 1);
        }
        if($request->status == 'cancel')
        {
            $trip_data->where('status', 0);
        }
        $data=$trip_data->get();
        return response()->json(['error' => false, 'message' => 'All Trips Data', 'data' => TripResource::collection($data)], 200);
    }
    /**
     * This method is used to get all the upcoming trips list
     */
    public function getUpcomingTrip(Request $request)
    {
        $trip_data=Trip::orderBy('id', 'desc');
        $start_date = date('Y-m-d');
        $trip_data->where('start_date','>', $start_date);
        $data=$trip_data->get();
        return response()->json(['error' => false, 'message' => 'All Upcoming Trips Data', 'data' => TripResource::collection($data)], 200);
    }
    /**
     * This method is used to get all the upcoming trips list
     */
    public function getUserUpcomingTrip(Request $request)
    {
        $trip_data=Trip::orderBy('id', 'desc');
        $start_date = date('Y-m-d');
        $trip_data->where('user_id', auth()->id());
        $trip_data->where('start_date','>', $start_date);
        $data=$trip_data->get();
        return response()->json(['error' => false, 'message' => 'User Upcoming Trips Data', 'data' => TripResource::collection($data)], 200);
    }
    /**
     * This method is used to get all the past trips list
     */
    public function getPastTrip(Request $request)
    {
        $trip_data=Trip::orderBy('id', 'desc');
        $start_date = date('Y-m-d');
        $trip_data->where('start_date','<', $start_date);
        $data=$trip_data->get();
        return response()->json(['error' => false, 'message' => 'All Past Trips Data', 'data' => TripResource::collection($data)], 200);
    }
    /**
     * This method is used to get all the past trips list
     */
    public function getUserPastTrip(Request $request)
    {
        $trip_data=Trip::orderBy('id', 'desc');
        $start_date = date('Y-m-d');
        $trip_data->where('user_id', auth()->id());
        $trip_data->where('start_date','<', $start_date);
        $data=$trip_data->get();
        return response()->json(['error' => false, 'message' => 'User Past Trips Data', 'data' => TripResource::collection($data)], 200);
    }
    /**
     * This method is used to get all the past trips list
     */
    public function getTodayTrip(Request $request)
    {
        $trip_data=Trip::orderBy('id', 'desc');
        $start_date = date('Y-m-d');
        $trip_data->where('start_date','=', $start_date);
        $data=$trip_data->get();
        return response()->json(['error' => false, 'message' => 'All Today Trips Data', 'data' => TripResource::collection($data)], 200);
    }
    /**
     * This method is used to get all the past trips list
     */
    public function getUserTodayTrip(Request $request)
    {
        $trip_data=Trip::orderBy('id', 'desc');
        $start_date = date('Y-m-d');
        $trip_data->where('user_id', auth()->id());
        $trip_data->where('start_date','=', $start_date);
        $data=$trip_data->get();
        return response()->json(['error' => false, 'message' => 'User Today Trips Data', 'data' => TripResource::collection($data)], 200);
    }
    /**
     * This method is used to get all the User Trips list
     */
    public function getUserTrip(Request $request)
    {   $user_id=auth()->id();
        if($request->user_id)
        {
            $user_id=$request->user_id;
        }
        $trip_data=Trip::orderBy('id', 'desc');
        $trip_data->where('user_id', $user_id);
        if($request->trip_type == 'today')
        {
            $start_date = date('Y-m-d');
            $trip_data->where('start_date','=', $start_date);
        }
        if($request->trip_type == 'past')
        {
            $start_date = date('Y-m-d');
            $trip_data->where('start_date','<', $start_date);
        }
        if($request->trip_type == 'upcoming')
        {
            $start_date = date('Y-m-d');
            $trip_data->where('start_date','>', $start_date);
        }
        if($request->status == 'complete')
        {
            $trip_data->where('status', 1);
        }
        if($request->status == 'cancel')
        {
            $trip_data->where('status', 0);
        }
        $data=$trip_data->get();
        return response()->json(['error' => false, 'message' => 'User Trips Data', 'data' => TripResource::collection($data)], 200);
    }
    /**
     * This method is used to get all the categories item list
     */
    public function getCateoryFilter(Request $request)
    {
        $query=Item::orderBy('id', 'asc');
        if($request->sort != '')
        {
            $query=Item::orderBy('id', $request->sort);
        }
        if($request->location != '')
        {
            $query=Item::orderBy('location', $request->location);
        }
        if($request->price != '')
        {
            $getPrice=explode('-', $request->price);
            $query->where('price','>=',$getPrice[0]);
            $query->where('price','<=',$getPrice[1]);
            //return $getPrice;
        }
        if($request->category_ids != '')
        {
            $getCategroy=explode(',', $request->category_ids);
            //return $getCategroy;
            $query->whereIn('category_id',$getCategroy);
        }
        if($request->brand_ids != '')
        {
            $getBrand=explode(',', $request->brand_ids);
            $query->whereIn('brand_name',$getBrand);
        }
        
        $data=$query->get();
        return response()->json(['error' => false, 'message' => 'Filter Vehicle Data', 'data' => ItemResource::collection($data)], 200);
            
    }
    
    /**
     * This method is used to get all the categories item list
     */
    public function getSearchFilter(Request $request)
    {
        $query=Item::orderBy('id', 'asc');
        $query->where('destination_id',$request->destination_id);
        $query->Orwhere('destination_id',1);
        
        $data=$query->get();
        return response()->json(['error' => false, 'message' => 'Search Vehicle Data', 'data' => ItemResource::collection($data)], 200);
            
    }
    /**
     * This method is used to get all the categories item list
     */
    public function contactUs(Request $request)
    {
        $fullName = auth()->user()->full_name;
        Mail::send(
            ['html' => 'emails.contactUs'],
            ['fullName' => $fullName, 'description' => $request->description],
            function ($message) {
                $message->to('support@PremierAutoCarRental.codelps.com')
                    ->from('support@PremierAutoCarRental.codelps.com')
                    ->subject("User " . auth()->user()->full_name . " is Contact with us - PremierAutoCarRental");
            }
        );
        return response()->json(['error' => false, 'message' => 'Email been sent successfully.', 'data' => ''], 200);
    }
    /**
     * This method is used to subscribed the User
     */
    public function purchaseSubscription(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receipt_data' => 'required',
            'package_name' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], 200);
        }
        $request->merge(['user_id' => auth()->id()]);
        $subccribedIds = auth()->user()->subscription->pluck('id');
        Subscription::whereIn('id', $subccribedIds)->update(['status' => false]);
        $createSubscription = Subscription::create($request->all());
        if(!$createSubscription){
            return response()->json(['error' => true, 'message' => 'Error occured.', 'data' => ''], 200);
        }
        return response()->json(['error' => false, 'message' => 'Subscribed successfully.', 'data' => new UserResource(User::find(auth()->id()))], 200);
    }
    /**
     * This method is used to create Trip
     */
    public function createTrip(Request $request)
    {
        /*$data=['email' => auth()->user()->email, 'description' => auth()->user()->email];
        //return $data;
        Mail::send(
            ['html' => 'emails.welcome'],
            $data,
            function ($message) use ($data) {
                $message->to($data['email'])
                    ->from('support@PremierAutoCarRental.com','PremierAutoCarRental')
                    ->subject("New Trip Notification of PremierAutoCarRental APP");
            }
        );
        return 1;*/
        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required',
        ]);
        if ($validator->fails()) 
        {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], 200);
        }
        $t_data=Trip::where('item_id',$request->vehicle_id)
        ->where('start_date', '>=', $request->start_date)
        ->where('end_date', '<=', $request->end_date)
        ->whereTime('start_time', '>=', Carbon::parse($request->start_time))
        ->whereTime('end_time', '<=', Carbon::parse($request->end_time))
        ->get();
        //return $t_data;
        if(count($t_data) > 0) 
        {
            return response()->json(['error' => true, 'message' => 'Booking is already exist on these dates'], 200);
        }
        //return $t_data;
        
        if($request->payment_type == "card")
        {
                $getStripeCardDetails = json_decode(CreditCard::find($request->credit_card_id)->card_details);
                $getStripePayment = $this->stripePayment(auth()->user()->stripe_customer_id, $request->price, $getStripeCardDetails->id);
                //$input['stripe_charge_id'] = $getStripePayment->id;
                $request->merge(['user_id' => auth()->id(),'item_id'=>$request->vehicle_id,'stripe_charge_id'=>$getStripePayment->id]);
        }
        else
        {
            $request->merge(['user_id' => auth()->id(),'item_id'=>$request->vehicle_id]);
        }
        $createTrip = Trip::create($request->except('vehicle_id'));
        //$data=[];
       // $extra=$data;
        $getUsers = User::where('is_admin', 1)->get();
        if($getUsers)
        {
            foreach($getUsers as $getUser)
            {
                $to_info=isset($getUser->device_token)?$getUser->device_token:'';
                $to_device=isset($getUser->device_type)?$getUser->device_type:'';
                $extra=[
                    'booking_type'=>'New',
                    'trip_id'=>$createTrip->id
                ];
                //$extra=json_encode($extra);
                $payLoad=[
                    'subject'=>'Message',
                    'type'=>'Trip',
                    'to'=>$to_info,
                    'message'=>'New Trip Notification',
                    'customData'=>$extra
                ];
                $isSent = $this->pushNotification($payLoad, $to_device);
                //return $isSent;
            }
        }
        /*
        $trip_data=Trip::where('id', $createTrip->id)->with(['user','item.images','before_image','after_image'])->first();
        $data=['email' => auth()->user()->email, 'trip_data' => $trip_data];
        
        //return $data['trip_data'];
        Mail::send(
            ['html' => 'emails.trip'],
            $data,
            function ($message) use ($data) {
                $message->to($data['email'])
                    ->from('support@PremierAutoCarRental.com','PremierAutoCarRental')
                    ->subject("New Trip Notification of PremierAutoCarRental APP");
            }
        );
        */
        if(!$createTrip){
            return response()->json(['error' => true, 'message' => 'Error occured.', 'data' => ''], 200);
        }
        return response()->json(['error' => false, 'message' => 'Trip created successfully.', 'data' => new TripResource(Trip::find($createTrip->id))], 200);
    }
    
    /**
     * This method is used to create Trip Images
     */
    public function createTripImages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'trip_id' => 'required',
            'type' => 'required',
            'photos'=>'required'
        ]);
        if ($validator->fails()) 
        {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], 200);
        }
        
        if($files=$request->file('photos')){
            //return $files;
            //ini_set('max_execution_time', '0'); // for infinite time of execution
            $images = [];
            foreach($files as $f=>$file){
                $imageUrl = $this->uploadFile($file, 0, true);
                    $images[$f]['name']=$imageUrl;
                    $images[$f]['trip_id']=$request->trip_id;
                    $images[$f]['user_id']=auth()->id();
                    $images[$f]['type']=$request->type;
                    $images[$f]['created_at']=Carbon::now();
                    $images[$f]['updated_at']=Carbon::now();
                
            }
            if(count($images)>0)
            TripImage::insert($images);
        }
        return response()->json(['error' => false, 'message' => 'Trip Images created successfully.', 'data' => new TripResource(Trip::find($request->trip_id))], 200);
    }
    /**
     * This method is used to subscribed the User
     */
    public function createStar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required',
            'trip_id' => 'required',
            'stars' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], 200);
        }
        $request->merge(['user_id' => auth()->id(),'item_id'=>$request->vehicle_id]);
        
        $createTrip = TripStar::create($request->except('vehicle_id'));
        if(!$createTrip){
            return response()->json(['error' => true, 'message' => 'Error occured.', 'data' => ''], 200);
        }
        return response()->json(['error' => false, 'message' => 'Stars created successfully.', 'data' => ''], 200);
    }
    /**
     * This method is used to cancel the subscription of the User
     */
    public function cancelSubscription(Request $request)
    {
        $getUserSubcription = auth()->user()->subscription[0];
        $getUserSubcription->update(['is_cancelled' => true]);
        return response()->json(['error' => false, 'message' => 'Subscribed cancelled successfully.', 'data' => new UserResource(User::find(auth()->id()))], 200);
    }
    
    /**
     * This method is used to get about us descrription
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'error' => false,
            'message' => 'User Logout Successfully',
            'data' => ''
        ], 200);
    }
    /**
     * Create the new customer in the stripe plateform
     */
    private function stripeCustomer($phoneNumber, $customerId = null){

        \Stripe\Stripe::setApiKey(self::SECRETE_KEY_FOR_STRIPE);
        if($customerId){
            // Retrieve the created Customer
            return \Stripe\Customer::retrieve(
                $customerId
            );
        }
        // Create new Customer
        return \Stripe\Customer::create([
            'phone' => $phoneNumber,
        ]);
    }
    /**
     * This method is used to create new charge for the Order
     */
    private function stripePayment($customerId, $price, $token)
    {
        \Stripe\Stripe::setApiKey(self::SECRETE_KEY_FOR_STRIPE);
        return \Stripe\Charge::create([
            'amount' => $price * 100,
            'currency' => 'usd',
            'source' => $token,
            'customer' => $customerId
        ]);
    }
    /**
     * This method is used to get about us descrription
     */
    public function getAboutUs()
    {
        return response()->json([
            'error' => false,
            'message' => '',
            'data' => ApplicationSetting::find(1)
        ], 200);
    }
    
    /**
     * This method is used to get all the past trips list
     */
    public function getFilterTrip(Request $request)
    {
        $trip_data=Trip::orderBy('id', 'desc');
        $start_date = date('Y-m-d');
        if($request->trips == "today")
        {
            $trip_data->where('start_date','=', $start_date);
        }
        if($request->trips == "past")
        {
            $trip_data->where('start_date','<', $start_date);
        }
        if($request->trips == "upcoming")
        {
            $trip_data->where('start_date','>', $start_date);
        }
        if($request->vehicle_id)
        {
            $trip_data->where('item_id', $request->vehicle_id);
        }
        if($request->destination_id)
        {
            $trip_data->where('destination_id', $request->destination_id);
        }
        $data=$trip_data->get();
        return response()->json(['error' => false, 'message' => 'All Filter Trips Data', 'data' => TripResource::collection($data)], 200);
    }
    // Guest User login
    public function guestLogin(Request $request)
    {
        // return 'hello';
        $validator = Validator::make($request->all(),[
            'device_type'=>'bail|required',
            'device_token'=>'bail|required',
            'notify'=>'bail|required'
        ]);
        if($validator->fails()){
            return response()->json(['error'=>true,'message'=>$validator->errors()->toArray()]);
        }
        $guestUser = User::select('id','device_type','device_token','notify','user_type','created_at','updated_at')
        ->where('device_token',$request->device_token)
        ->where('user_type','app')
        ->first();
        if(!$guestUser)
        {
            $guestUser = User::create([
                'device_type'=>$request->device_type,
                'device_token'=>$request->device_token,
                'notify'=>$request->notify,
                'user_type'=>'app'
            ]);
        }
        else
        {
            $guestUser->update(['notify'=>$request->notify]);
        }
        return response()->json([
            'error'=>false,
            'message'=>'User Login Successfully.',
            'user'=>$guestUser
            // 'user' => new UserResource($guestUser),

        ]);
    }
    // Guest User login
    public function testLogin(Request $request)
    {
        // return 'hello';
        $validator = Validator::make($request->all(),[
            'device_type'=>'bail|required',
            'device_token'=>'bail|required',
            'notify'=>'bail|required'
        ]);
        if($validator->fails()){
            return response()->json(['error'=>true,'message'=>$validator->errors()->toArray()]);
        }
        
        $to_info=isset($request->device_token)?$request->device_token:'';
        $to_device=isset($request->device_type)?$request->device_type:'';
        //return $to_info;
                $extra=[
                    'booking_type'=>'Test',
                    'user_id'=>1
                ];
                //$extra=json_encode($extra);
                $payLoad=[
                    'subject'=>'Message',
                    'type'=>'Trip',
                    'to'=>$to_info,
                    'message'=>'Test Arab Coupons Notification',
                    'customData'=>$extra
                ];
        return $isSent = $this->pushNotification($payLoad, $to_device);
        return response()->json([
            'error'=>false,
            'message'=>'User Login Successfully.',
            'user'=>$guestUser
            // 'user' => new UserResource($guestUser),

        ]);
    }
}