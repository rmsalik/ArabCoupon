<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
</head>
<style type="text/css">
    
    .logo img{
        width:45px;
        height:45px;
        padding-top:30px;
    }
    .logo span{
        margin-left:8px;
        top:19px;
        position: absolute;
        font-weight: bold;
        font-size:25px;
    }
    .gray-color{
        color:#5D5D5D;
    }
    .text-bold{
        font-weight: bold;
    }
    .border{
        border:1px solid black;
    }
    table tr,th,td{
        border: 1px solid #d2d2d2;
        border-collapse:collapse;
        padding:7px 8px;
    }
    table tr th{
        background: #F4F4F4;
        font-size:15px;
    }
    table tr td{
        font-size:13px;
    }
    table{
        border-collapse:collapse;
    }
    .box-text p{
        line-height:10px;
    }
    .float-left{
        float:left;
    }
    .total-part{
        font-size:16px;
        line-height:12px;
    }
    .total-right p{
        padding-right:20px;
    }
</style>
<body>
<div class="head-title">
</div>
<div class="add-detail mt-10">
    <div class="w-100 float-left mt-10">
        <p class="m-0 pt-5 text-bold w-100" >Trip Receipt - Reservation Id - <span class="gray-color">#{{$trip_data['id']}}</span></p>
        <p class="m-0 pt-5 text-bold w-100">Trip Type - <span class="gray-color">{{$trip_data['location_type']}}</span></p>
        <p class="m-0 pt-5 text-bold w-100"> Booked At - <span class="gray-color">{{date('d-m-Y')}}</span></p>
        <p class="m-0 pt-5 text-bold w-100" > {{$trip_data['item']['title']}} {{$trip_data['item']['car_model']}} {{$trip_data['item']['car_number']}}</p>
        <p class="m-0 pt-5 text-bold w-100" >Trip Start {{Carbon\Carbon::createFromFormat('Y-m-d', $trip_data['start_date'])->format('F d')}}</p>
        <p class="m-0 pt-5 text-bold w-100" >Trip End {{Carbon\Carbon::createFromFormat('Y-m-d', $trip_data['end_date'])->format('F d')}}</p>
        <p class="m-0 pt-5 text-bold w-100" >Pickup Location</p>
        <p class="m-0 pt-5 text-bold w-100" >{{$trip_data['pickup_location']}}</p>
        <p class="m-0 pt-5 text-bold w-100" >Trip Price ${{$trip_data['price']}}.  {{ ceil(abs(strtotime($trip_data['end_date']) - strtotime($trip_data['start_date'])) / 86400) }} Days Trip</p>
        <p class="m-0 pt-5 text-bold w-100" >Insurance Fee ${{$trip_data['insurance_fees']}}</p>
        <p class="m-0 pt-5 text-bold w-100" >Fuel Fee ${{$trip_data['fuel_fees']}}</p>
        <p class="m-0 pt-5 text-bold w-100" >Delivery Fee ${{$trip_data['delivery_fees']}}</p>
        <p class="m-0 pt-5 text-bold w-100" >Pickup Fee ${{$trip_data['pickup_fees']}}</p>
        <p class="m-0 pt-5 text-bold w-100" >Tax ${{$trip_data['tax']}}</p>
        <p class="m-0 pt-5 text-bold w-100" >Trip Total ${{$trip_data['price']+$trip_data['insurance_fees']}}</p>
    </div>
    <!--<div class="w-50 float-left logo mt-10">
       <!-- <img src="https://www.nicesnippets.com/image/imgpsh_fullsize.png"> <span>Nicesnippets.com</span>     -->
    <!--</div>-->
    <div style="clear: both;"></div>
</div>

<p> Thanks for using PremierAutoCarRental, </p>
<p> 8383 WILSHIRE BLVD SUITE 114 BEVERLY HILLS 90211 </p>
</html>
<div class="verify-email">

</div>