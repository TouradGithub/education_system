<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ChargilyPayController extends Controller
{
    public $name;
    public $email;
    public $phone;
    public $password;

    public  $description;
    public $type;
    public  $grade_id;
    public  $adress;
    public $image;
    public $academy_id;

    public function redirect(Request $request)
    {
        try {
            $this->name=$request->name;
            $this->email=$request->email;
            $this->phone=$request->phone;
            $this->password=$request->password;
            $this->description=$request->description;
            $this->grade_id=$request->grade_id;
            $this->adress=$request->adress;
            $this->image=$request->image;
            $this->academy_id=$request->academy_id;
            $user = 1;
            $currency = "dzd";
            $amount = $request->price;
            DB::beginTransaction();

          
            $payment = \App\Models\ChargilyPayment::create([
                "user_id"  => $user,
                "status"   => "pending",
                "currency" => $currency,
                "amount"   => $amount,
                "school_id"   => $school->id,
            ]);
            if ($payment) {
                $checkout = $this->chargilyPayInstance()->checkouts()->create([
                    "metadata" => [
                        "payment_id" => $payment->id,
                        "name"=>$request->name,
                        "email"=>$request->email,
                        "type"=>$request->type,
                        "phone"=>$request->phone,
                        "password"=>$request->password,
                        "description"=>$request->description,
                        "grade_id"=>$request->grade_id,
                        "adress"=>$request->adress,
                        "image"=>$request->image,
                        "academy_id"=>$request->academy_id,
                    ],
                    "locale" => "ar",
                    "amount" => $payment->amount,
                    "currency" => $payment->currency,
                    "description" => "Payment ID={$payment->id}",
                    "success_url" => route("web.chargilypay.back"),
                    "failure_url" => route("web.chargilypay.back"),
                    "webhook_endpoint" => route("web.chargilypay.webhook_endpoint"),
                ]);
                if ($checkout) {


                    $super_admin_role = Role::where('name', $request->input('roles'))->first();

                    $schoolUser = User::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'role' =>  $super_admin_role->name,
                        'password' => Hash::make($request->password),
                        'model' => "App\Models\Schools",
                        'model_id' => $school->id,
                        'is_admin_school' => 1,
                    ]);
                    $setting = new Settings();
                    $setting->school_id= $school->id;
                    $setting->save();

                    $super_admin_role = Role::where('name', $request->input('roles'))->first();

                    $schoolUser->assignRole($super_admin_role);
                    DB::commit();

                    return redirect($checkout->getUrl());
                }
            }
            return dd("Redirection failed");
        } catch (\Throwable $th) {

        }


    }
    /**
     * Your client you will redirected to this link after payment is completed ,failed or canceled
     *
     */
    public function back(Request $request)
    {
        $user = 1;
        $checkout_id = $request->input("checkout_id");
        $checkout = $this->chargilyPayInstance()->checkouts()->get($checkout_id);
        $payment = null;

        if ($checkout) {
            $metadata = $checkout->getMetadata();
            $payment = \App\Models\ChargilyPayment::find($metadata['payment_id']);
            $data = $checkout->toArray();
            dd($data);
            if($data["status"]=="paid"){
                try {
                    DB::beginTransaction();

                    $school = Schools::create([
                        'name' => $metadata["name"],
                        'description' => $metadata["description"],
                        'type' => $metadata["type"],
                        'grade_id'=>$metadata["grade_id"],
                        'adress' => $metadata["adress"],
                        'email' => $metadata["email"],
                        'image' => $metadata["image"]??null,
                        'academy_id' => $metadata["academy_id"],
                    ]);
                    $payment = \App\Models\ChargilyPayment::find($metadata['payment_id']);
                    $payment->user_id=$data['id'];
                    $payment->school_id=$school->id;
                    $payment->save();
                    $super_admin_role = Role::where('name', "Admin School")->first();

                    $schoolUser = User::create([
                        'name' => $metadata["name"],
                        'email' => $metadata["email"],
                        'phone' =>  $metadata["phone"],
                        'role' =>  $super_admin_role->name,
                        'password' => Hash::make($metadata["password"]),
                        'model' => "App\Models\Schools",
                        'model_id' => $school->id,
                        'is_admin_school' => 1,
                    ]);
                    $setting = new Settings();
                    $setting->school_id= $school->id;
                    $setting->save();

                    $super_admin_role = Role::where('name', "Admin School")->first();

                    $schoolUser->assignRole($super_admin_role);
                    DB::commit();

                    $credentials = $request->only($metadata["email"],$metadata["password"]);

                    if (Auth::attempt($credentials)) {

                        return redirect('school/home');

                    } else {

                        return redirect()->route('school.login.subscribe')->with('error',trans('genirale.error_occurred'));

                    }
                } catch (\Throwable $th) {
                    return redirect()->route('school.login.subscribe')->with('error',trans('genirale.error_occurred'));

                }

            }else{
                return redirect()->route('school.login.subscribe')->with('error',trans('genirale.error_occurred'));

            }

        }

    }
    public function responseDate($data, $payment){

        dd($data->attributes);

    }
    /**
     * This action will be processed in the background
     */
    public function webhook()
    {
        $webhook = $this->chargilyPayInstance()->webhook()->get();
        if ($webhook) {
            //
            $checkout = $webhook->getData();
            //check webhook data is set
            //check webhook data is a checkout
            if ($checkout and $checkout instanceof \Chargily\ChargilyPay\Elements\CheckoutElement) {
                if ($checkout) {
                    $metadata = $checkout->getMetadata();
                    $payment = \App\Models\ChargilyPayment::find($metadata['payment_id']);

                    if ($payment) {
                        if ($checkout->getStatus() === "paid") {
                            //update payment status in database
                            $payment->status = "paid";
                            $payment->update();
                            /////
                            ///// Confirm your order
                            /////
                            return response()->json(["status" => true, "message" => "Payment has been completed"]);
                        } else if ($checkout->getStatus() === "failed" or $checkout->getStatus() === "canceled") {
                            //update payment status in database
                            $payment->status = "failed";
                            $payment->update();
                            /////
                            /////  Cancel your order
                            /////
                            return response()->json(["status" => true, "message" => "Payment has been canceled"]);
                        }
                    }
                }
            }
        }
        return response()->json([
            "status" => false,
            "message" => "Invalid Webhook request",
        ], 403);
    }

    /**
     * Just a shortcut
     */
    protected function chargilyPayInstance()
    {
        return new \Chargily\ChargilyPay\ChargilyPay(new \Chargily\ChargilyPay\Auth\Credentials([
            "mode" => "test",
            "public" => "test_pk_9iQLACBOmxZWkXdaA7ke2Ix74cGW6XUHUZbQOzzw",
            "secret" => "test_sk_nF2FZOif2prDFfgHTM9qVf9yImGo3FKguoq3xjqQ",
        ]));
    }
}
