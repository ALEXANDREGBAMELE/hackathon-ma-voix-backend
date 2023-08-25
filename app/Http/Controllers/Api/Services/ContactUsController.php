<?php

namespace App\Http\Controllers\Api\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ContactUsController extends Controller
{



    public function addToContactUs(Request $request, string $admin_email){
        $request->validate([
            'nom'=>'required|string',
            'email'=>'required|email',
            'message'=>'required|string',
        ]);

        $to = $admin_email;
        $subject = "Nouveau message de ".$request->nom;
        $txt = $request->message;
        $headers = "From: ".$request->email . "\r\n" .
        "CC: ".$request->email;

        try {
            mail($to,$subject,$txt,$headers);
            $fake = null;
        } catch (\Throwable $th) {
           $fake = $th;
        }

        return response()->json([
            'success'=>'Votre message a été envoyé',
            'reponse'=>$fake

        ],201);

    }



}
