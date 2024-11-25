<?php

namespace App\Http\Controllers\Admin;

//use App\Http\Controllers\Apis\AppController;
use App\Http\Controllers\Controller;
use App\Models\{ApplicationSetting, User};
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::orderBy('full_name','asc')->get();
        return view('admin.users.index')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    function actions(Request $request, $action, $id){
        $set = [
            'delete-user'  => [-1, 'User account has been deleted successfully'],
            'block-user'   => [2, 'User account has been blocked successfully'],
            'approve-user' => [1, 'User account has been activated successfully']
        ];
        if(isset($set[$action])){
            User::find($id)->update(['status' => $set[$action][0]]);
            return redirect()->back()->with('success', $set[$action][1]);
        }
        return redirect()->back()->with('error', "Invalid action");
    }

    /**
     * This method is used to get About Us details
     */
    public function aboutUsDescription(Request $request)
    {
        $data = ApplicationSetting::first();
        return view('admin.aboutUs.detail')->with(compact('data'));
    }
    /**
     * This method is used to get About Us details
     */
    public function aboutUsEdit(Request $request)
    {
        $data = ApplicationSetting::first();
        return view('admin.aboutUs.edit')->with(compact('data'));
    }
    /**
     * This method is used to get About Us details
     */
    public function aboutUsUpdate(Request $request)
    {
        $data = ApplicationSetting::first();
        $data->update(['description' => $request->description]);
        return redirect()->route('about-us')->with('success', "Update about us description successfully.");
    }
}
