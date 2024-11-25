<?php
  
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;
use PDF;
  
class PDFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generatePDF($id)
    {
        $data = Trip::where('id', $id)->with(['user','item.images','before_image','after_image'])->first();
          
        $pdf = PDF::loadView('myPDF', $data);
    
        return $pdf->download('invoice.pdf');
    }
}