<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\CreditCardResource;
use App\Models\CreditCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Validator};

class CreditCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['error' => false,'message' => '', 'data' => CreditCardResource::collection(auth()->user()->credit_cards)], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try{
            $input = $request->all();
            $validator = Validator::make($input, [
                'stripe_token' => 'required|string',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => true, 'message' => $validator->errors()->first()], 200);
            }
            $input['card_details'] = $this->createStripeCard(auth()->user()->stripe_customer_id, $request->stripe_token);
            $input['user_id'] = auth()->id();
            if(!count(auth()->user()->credit_cards)){
                $input['is_default'] = true;
            }
            $createCreditCard = CreditCard::create($input);
            if(!$createCreditCard){
                return response()->json(['error' => true, 'message' => 'Unable to create credit card.'], 200);
            }
            return response()->json(['error' => false, 'message' => 'Create credit card successfully.', 'data' => new CreditCardResource($createCreditCard)], 200);
        }catch(\Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(['error' => false, 'message' => '', 'data' => new CreditCardResource(CreditCard::find($id))], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            DB::beginTransaction();
            $getVehicle = CreditCard::find($id);
            $deleteStripeCard = $this->deleteStripeCard(auth()->user()->stripe_customer_id, json_decode($getVehicle->card_details)->id);
            $deleteVehicle = $getVehicle->delete();
            if(!$deleteVehicle || !$deleteStripeCard){
                return response()->json(['error' => false, 'message' => 'Unable to delete credit card.'], 200);
            }
            DB::commit();
            return response()->json(['error' => false, 'message' => 'Delete credit card successfully.'], 200);

        }catch(\Exception $e){
            return response()->json(['error' => true, 'message' => $e->getMessage()], 200);
        }
    }
    /**
     * Create the new customer in the stripe plateform
     */
    private function createStripeCard($customerId, $stripeToken){

        \Stripe\Stripe::setApiKey(self::SECRETE_KEY_FOR_STRIPE);
        $creditCard = \Stripe\Customer::createSource(
            $customerId,
            [
                'source' => $stripeToken
            ]
        );
        return json_encode($creditCard);
    }
    /**
     * Create the new customer in the stripe plateform
     */
    private function deleteStripeCard($customerId, $cardId){

        \Stripe\Stripe::setApiKey(self::SECRETE_KEY_FOR_STRIPE);
        if(\Stripe\Customer::deleteSource($customerId, $cardId)){
            return true;
        }
        return false;
    }
    /**
     * This method is used to set the card default
     */
    public function setDefaultCard($id){
        CreditCard::where('user_id', auth()->id())
        //->first()
        ->update(['is_default' => false]);
        CreditCard::find($id)->update(['is_default' => true]);

        return response()->json(['error' => false, 'message' => 'Set the default credit card successfully.', 'data' => new CreditCardResource(CreditCard::find($id))], 200);
    }
}
