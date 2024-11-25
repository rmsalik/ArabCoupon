<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Country;
use App\Models\Brand;
use App\Models\CouponItem;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CouponLike;
use DB;
use Illuminate\Support\Facades\URL;

class MainPageController extends Controller
{


    public function __construct(Request $request){

        // dd($request->all());

     $country_id=$request->country_id;
         // var_dump($country_id);
     $this->top_stores = Brand::where('status', 1)
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
     ->orderBy('position', 'asc')->take(6)->get();

     $this->categories=  Category::where('status', 1)
     ->select('id','name','arabic_name as second_name','description','image_url','isStoreLabelHidden')
     ->orderBy('position', 'asc')->get();

 }

 public function index(Request $request){


    $top_stores = $this->top_stores;
    $categories = $this->categories;
    // dd($categories);
    $brands = Brand::whereHas('coupons', function($query) {
        $query->where('status', 1)->where('country_id', 1);
    })
    ->with(['coupons' => function($query) {
        $query->where('status', 1)->where('country_id', 1);
    }])
    ->limit(8)
    ->get();
    $brandCount = Brand::whereHas('coupons', function($query) {
        $query->where('status', 1)->where('country_id', 1);
    })
    ->with(['coupons' => function($query) {
        $query->where('status', 1)->where('country_id', 1);
    }])
    ->get()->count();
    $countryId=1;
    $latest_brands =  Brand::whereHas('coupons', function($query) use ($countryId) {
        $query->where('status', 1)
        ->where('country_id', $countryId);  
    })
    ->with(['coupons' => function($query) use ($countryId) {
        $query->where('status', 1)
        ->where('country_id', $countryId)  
        ->orderBy('created_at', 'desc');                        
    }])
    ->limit(4)
    ->get()
    ->filter(function ($brand) {
        return $brand->coupons->isNotEmpty();  
    });
    // dd($latest_brands);
    return view('home')->with(compact('top_stores','brands','brandCount','latest_brands','categories'));


}


public function getBrandsByCountry(Request $request)
{
    $countryId = $request->input('country_id');
$referer = $request->header('referer');  // Get the referring page URL
$baseUrl = URL::to('/');  // Get the base URL from Laravel

// Normalize both URLs by removing the trailing slash
$normalizedReferer = rtrim(parse_url($referer, PHP_URL_PATH), '/');
$normalizedBaseUrl = rtrim(parse_url($baseUrl, PHP_URL_PATH), '/');
// Check if the referring page is the home page
if ($normalizedReferer === $normalizedBaseUrl) {
    // If it's the home page, apply the limit
    $brands = Brand::whereHas('coupons', function($query) use ($countryId) {
        $query->where('status', 1)
        ->where('country_id', $countryId);
    })
    ->with(['coupons' => function($query) use ($countryId) {
        $query->where('status', 1)
        ->where('country_id', $countryId);
    }])
    ->limit(8)
    ->get();
} else {
    // If it's the offers page (or any other page), don't apply the limit
    $brands = Brand::whereHas('coupons', function($query) use ($countryId) {
        $query->where('status', 1)
        ->where('country_id', $countryId);
    })
    ->with(['coupons' => function($query) use ($countryId) {
        $query->where('status', 1)
        ->where('country_id', $countryId);
    }])
    ->get();
}

$latest_brands =  Brand::whereHas('coupons', function($query) use ($countryId) {
    $query->where('status', 1)
->where('country_id', $countryId);  // Filter by country and status
})
->with(['coupons' => function($query) use ($countryId) {
    $query->where('status', 1)
->where('country_id', $countryId)  // Same filter
->orderBy('created_at', 'desc')    // Get the latest coupon
;                        // Limit to the latest coupon
}])
->limit(4)
->get()
->filter(function ($brand) {
return $brand->coupons->isNotEmpty();  // Only keep brands that have coupons
});


$brandCount = Brand::whereHas('coupons', function($query) use ($countryId) {  // Use the $countryId in closure
    $query->where('status', 1)
    ->where('country_id', $countryId);
})->get()->count(); // Count the number of brands

return response()->json([
    'brands' => $brands,
    'latest_brands' => $latest_brands,
    'count' => $brandCount,
    'message' => $brandCount === 0 ? 'No brands found for this country.' : null,
]);
}


// public function brand_offers($id=false,$countryId){
// // Fetch brands based on country ID
//     $top_stores = $this->top_stores;
//     $categories = $this->categories;
//     $brands_offers = Brand::where('id', $id)
//     ->whereHas('coupons', function ($query) use ($countryId) {
//         // Filter coupons by country_id and status
//         $query->where('status', 1)
//         ->where('country_id', $countryId);
//     })
//     ->with(['coupons' => function ($query) use ($countryId) {
//         // Eager load coupons filtered by country_id and status
//         $query->where('status', 1)
//         ->where('country_id', $countryId);
//     }])->get();
//     // dd($brands_offers);
//     return view('all_offers')->with(compact('brands_offers','top_stores','categories'));

// }
public function brand_offers($id = null, $countryId)
{
    $top_stores = $this->top_stores;
    $categories = $this->categories;
    $brands_offers = DB::table('brands')
    ->join('coupons', 'brands.id', '=', 'coupons.brand_id')
    ->join('countries', 'coupons.country_id', '=', 'countries.id')
    ->select('brands.*', 'brands.name as brand_name', 'coupons.*' , 'countries.name as country_name')->where('coupons.brand_id', $id)->where('coupons.status', 1)->where('coupons.country_id', $countryId)->when($id, function ($query) use ($id) {
        return $query->where('brands.id', $id);
    }) ->get();

    return view('all_offers')->with(compact('brands_offers', 'top_stores', 'categories'));
}



public function search(Request $request)
{
    $countryId = $request->input('country_id');
    $searchWord = $request->input('search_word');
    $brandsCount = 0;
    if (!empty($searchWord)) {
        // Search brands by category or search word
        $categoryId = Category::where('name', 'LIKE', '%' . $searchWord . '%')
        ->orWhere('description', 'LIKE', '%' . $searchWord . '%')
        ->whereNotNull('id')
        ->pluck('id')
        ->first();

        if ($categoryId != null) {
            $brandsIDs = DB::table('category_brands')
            ->where('category_id', $categoryId)
            ->pluck('brand_id');

            $brands = Brand::whereHas('coupons', function ($query) use ($countryId) {
                $query->where('status', 1)->where('country_id', $countryId);
            })
            ->with(['coupons' => function ($query) use ($countryId) {
                $query->where('status', 1)->where('country_id', $countryId);
            }])
            ->whereIn('id', $brandsIDs)
            ->orderBy('name', 'asc')
            ->get();
            $brandsCount = $brands->count();
        } else {

            $brandsCount = Brand::whereHas('coupons', function ($query) use ($countryId, $searchWord) {
                $query->where('status', 1)
                ->where('country_id', $countryId)
                ->where(function ($subQuery) use ($searchWord) {
                    $subQuery->where('name', 'LIKE', '%' . $searchWord . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchWord . '%');
                });
            })->count();
            $brands = Brand::whereHas('coupons', function ($query) use ($countryId, $searchWord) {
                $query->where('status', 1)
                ->where('country_id', $countryId)
                ->where(function ($subQuery) use ($searchWord) {
                    $subQuery->where('name', 'LIKE', '%' . $searchWord . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchWord . '%');
                });
            })
            ->with(['coupons' => function ($query) use ($countryId, $searchWord) {
                $query->where('status', 1)
                ->where('country_id', $countryId)
                ->where(function ($subQuery) use ($searchWord) {
                    $subQuery->where('name', 'LIKE', '%' . $searchWord . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchWord . '%');
                });
            }])
            ->limit(8)
            ->get();
        }
    } else {

     $referer = $request->header('referer');
     if ($referer) {
        $parsedUrl = parse_url($referer);

                // Split the path into segments
        $pathSegments = explode('/', trim($parsedUrl['path'], '/'));
                $page = $pathSegments[0] ?? '';  // Assign the first segment to $page
                $category_id = $pathSegments[1] ?? 0;  // Assign the second segment to $category_id
                $country_Id = $pathSegments[2] ?? 0;  // Assign the third segment to $countryId
            }


            if ($page == "brands") {
                
                $brands_search = DB::select("
                    SELECT DISTINCT brands.id ,brands.name, brands.profile_image_url, brands.percentage, coupons.country_id
                    FROM coupons
                    INNER JOIN brands ON coupons.brand_id = brands.id
                    INNER JOIN category_brands ON coupons.brand_id = category_brands.brand_id
                    WHERE coupons.country_id = :countryId
                    AND brands.status = 1
                    AND coupons.status = 1
                    AND category_brands.category_id = :categoryId
                    ORDER BY brands.name ASC
                    ", [
                        'countryId' => $country_Id,
                        'categoryId' => $category_id
                    ]);
                $brandIds = array_column($brands_search, 'id');
                $brands = Brand::whereHas('coupons', function ($query) use ($countryId) {
                    $query->where('status', 1)->where('country_id', $countryId);
                })
                ->with(['coupons' => function ($query) use ($countryId) {
                    $query->where('status', 1)->where('country_id', $countryId);
                }])
                ->whereIn('id',$brandIds)
                ->orderBy('name','asc')
                ->get();
                $brandsCount=count($brands);

            } else {
                
                // If the page is not "brands", return brands limited to 8
                $brandsCount = Brand::whereHas('coupons', function ($query) use ($countryId) {
                    $query->where('status', 1)->where('country_id', $countryId);
                })
                ->count();

                // Get brands limited to 8 without filtering by category_id
                $brands = Brand::whereHas('coupons', function ($query) use ($countryId) {
                    $query->where('status', 1)->where('country_id', $countryId);
                })
                ->with(['coupons' => function ($query) use ($countryId) {
                    $query->where('status', 1)->where('country_id', $countryId);
                }])
                ->limit(8)  // Limit to 8 brands
                ->get();
            }

             // dd('elseif out');
        }

    // Fetch latest brands
        $latest_brands = Brand::whereHas('coupons', function ($query) use ($countryId, $searchWord) {
            $query->where('status', 1)
            ->where('country_id', $countryId)
            ->where(function ($subQuery) use ($searchWord) {
                $subQuery->where('name', 'LIKE', '%' . $searchWord . '%')
                ->orWhere('description', 'LIKE', '%' . $searchWord . '%');
            });
        })
        ->with(['coupons' => function ($query) use ($countryId, $searchWord) {
            $query->where('status', 1)
            ->where('country_id', $countryId)
            ->where(function ($subQuery) use ($searchWord) {
                $subQuery->where('name', 'LIKE', '%' . $searchWord . '%')
                ->orWhere('description', 'LIKE', '%' . $searchWord . '%');
            })
                ->orderBy('created_at', 'desc');  // Get the latest coupon
            }])
        ->limit(4)
        ->get()
        ->filter(function ($brand) {
            return $brand->coupons->isNotEmpty();  // Only keep brands that have coupons
        });



// Convert $brands to a collection if it's an array
        $brandsCollection = is_array($brands) ? collect($brands) : $brands;

        return response()->json([
            'brands' => $brands,
            'latest_brands' => $latest_brands,
            'count' => $brandsCount,
            'message' => $brandsCount === 0 ? 'No brands found for this country.' : null,
        ]);
    }

    public function  getAllCoupons(Request $request){
        $top_stores = $this->top_stores;
        $categories = $this->categories;
        $countryId = $request->query('country_id');

        $brands = Brand::whereHas('coupons', function ($query) use ($countryId) {
            $query->where('status', 1)->where('country_id', $countryId);
        })
        ->with(['coupons' => function ($query) use ($countryId){
            $query->where('status', 1)->where('country_id', $countryId);
        }])
        ->get();

        $brandCount = $brands->count();

        return view('allcoupons')->with(compact('brands', 'brandCount','top_stores','categories'));
    }
    public function terms_condition(){
        $top_stores = $this->top_stores;
        $categories = $this->categories;
        return view('terms&condition',compact('top_stores','categories'));
    }
    public function faq(){
        $top_stores = $this->top_stores;
        $categories = $this->categories;
        return view('frequentlyasked',compact('top_stores','categories'));
    }

    public function privacy_policy(){
        $top_stores = $this->top_stores;
        $categories = $this->categories;
        return view('privacy&policy',compact('top_stores','categories'));
    }


// public function getBrandsByCategoryID(Request $request,$category_id,$country_id){
//     $top_stores = $this->top_stores;
//     $categories = $this->categories;
//     $countryId = $country_id;
//     $brands = Brand::whereHas('coupons', function($query) use ($countryId,$category_id) {  // Use the $countryId in closure
//         $query->where('status', 1)
//         ->where('country_id', $countryId)->where('category_id',$category_id);
//     })
// ->with(['coupons' => function($query) use ($countryId,$category_id) {  // Eager load coupons with conditions
//     $query->where('status', 1)
//     ->where('country_id', $countryId)->where('category_id',$category_id);
// }])
// ->get();

// $brandCount=$brands->count();

// return view('couponsbycategory')->with(compact('brands', 'brandCount','top_stores','categories'));
// }

    public function getBrandsByCategoryID(Request $request, $category_id, $country_id)
    {
        $top_stores = $this->top_stores;
        $categories = $this->categories;


        $brands = DB::select("
            SELECT DISTINCT brands.id ,brands.name, brands.profile_image_url, brands.percentage, coupons.country_id
            FROM coupons
            INNER JOIN brands ON coupons.brand_id = brands.id
            INNER JOIN category_brands ON coupons.brand_id = category_brands.brand_id
            WHERE coupons.country_id = :countryId
            AND brands.status = 1
            AND coupons.status = 1
            AND category_brands.category_id = :categoryId
            ORDER BY brands.name ASC
            ", [
                'countryId' => $country_id,
                'categoryId' => $category_id
            ]);


        $brandCount = count($brands);


        return view('couponsbycategory')->with(compact('brands', 'brandCount', 'top_stores', 'categories'));
    }


    public function coupon_like_dislike(Request $request){
    // Get parameters from the request
        $couponId = $request->input('coupon_id');
        $isLike = $request->input('is_like');
        $coupon_like = new CouponLike();
        $coupon_like->is_like = $isLike;
        $coupon_like->coupon_id = $couponId;
        $coupon_like->save();
        $message= "";
        if($isLike==1){
            $message= "Thank you";
        }else{
         $message= "Sorry";   
     }
     $data['message'] = $message;
     $data['status']  = $isLike;
     return response()->json($data);

 }


 public function get_brands_byCountry(Request $request)
 {
    $countryId = $request->input('country_id');
    // Assuming you have a Brand model with a country relationship

    $brands = Brand::whereHas('coupons', function($query) use ($countryId) {  // Use the $countryId in closure
        $query->where('status', 1)
        ->where('country_id', $countryId);
    })
->with(['coupons' => function($query) use ($countryId) {  // Eager load coupons with conditions
    $query->where('status', 1)
    ->where('country_id', $countryId);
}])
->get();

return response()->json(['brands' => $brands]);
}

public function add_coupon(Request $request)
{
    // dd($request->all());

   $validatedData = $request->validate([
    'name' => 'required|string|max:255',
    'percentage' => 'required|numeric|min:0|max:100',
    // 'coupon_no' => 'required|string|max:255|regex:/^[A-Za-z0-9\-]+$/',
    'coupon_no' => 'required|string|max:255',
    // 'detail' => 'required|string|max:500',
]);

 // $validatedData['country_id'] = $request->country_id;
   $validatedData['status'] = 2;
 //Create the coupon (adjust as needed for your Coupon model)
   Coupon::create($validatedData);
   return response()->json(['message' => 'Coupon added successfully!'], 201);
}

} // end class
