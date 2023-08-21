<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ResultatSondage;
use Illuminate\Http\Request;

class ResultatSondageController extends Controller
{


    public function addMyVote(Request $request){
        $request->validate([
            'id_sondage'=>'required|integer|exists:sondages,id',
            'avis'=>'string',
            'id_user'=>'required|integer|exists:users,id',
            'choix'=>'required|boolean',
        ]);


        $resultatSondage = ResultatSondage::where('id_sondage',$request->id_sondage)
            ->where('id_user',$request->id_user)
            ->first();

        if ($resultatSondage) {
            return response()->json([
                'message'=>'Vous avez déjà voté',
                'data'=>$resultatSondage,
            ],409);
        }

        $resultatSondage = ResultatSondage::create([
            'id_sondage'=>$request->id_sondage,
            'avis'=>$request->avis,
            'id_user'=>$request->id_user,
            'choix'=>$request->choix,
        ]);
        return response()->json([
            'message'=>'Vous avez voté',

        ],201);
    }


    public function getMyVote(int $id, int $id_user){


        $resultatSondage = ResultatSondage::where('id_sondage',$id)
            ->where('id_user',$id_user)
            ->first();

        if (!$resultatSondage) {
            return response()->json([
                'message'=>'Vous n\'avez pas encore voté',
            ],409);
        }

        return response()->json([
            'message'=>'Votre vote',
            'data'=>$resultatSondage,
        ],200);
    }


    public function getVotes(int $id){


        $resultatSondage = ResultatSondage::where('id_sondage',$id)
            ->with('user')
            ->get();

        return response()->json([
            'message'=>'Liste des votes',
            'data'=>$resultatSondage,
        ],200);
    }



    public function deleteMyVote(int $id, int $id_user){


        $resultatSondage = ResultatSondage::where('id_sondage',$id)
            ->where('id_user',$id_user)
            ->first();

        if (!$resultatSondage) {
            return response()->json([
                'message'=>'Vous n\'avez pas encore voté',
            ],409);
        }

        $resultatSondage->delete();

        return response()->json([
            'message'=>'Votre vote a été supprimé',
        ],200);
    }


    public function updateMyVote(Request $request){
        $request->validate([
            'id_sondage'=>'required|integer|exists:sondages,id',
            'avis'=>'string',
            'id_user'=>'required|integer|exists:users,id',
            'choix'=>'required|boolean',
        ]);

        $resultatSondage = ResultatSondage::where('id_sondage',$request->id_sondage)
            ->where('id_user',$request->id_user)
            ->first();

        if (!$resultatSondage) {
            return response()->json([
                'message'=>'Vous n\'avez pas encore voté',
            ],409);
        }

        $resultatSondage->update([
            'choix'=>$request->choix,
        ]);

        return response()->json([
            'message'=>'Votre vote a été modifié',
        ],200);
    }


    public function maxVotes(Request $request){
        $request->validate([
            'id_sondage'=>'required|integer|exists:sondages,id',
        ]);

        $resultatSondage = ResultatSondage::where('id_sondage',$request->id_sondage)
            ->get();

        $oui = 0;
        $non = 0;

        foreach ($resultatSondage as $resultat){
            if ($resultat->choix == 1){
                $oui++;
            }else{
                $non++;
            }
        }

        $resultat = response()->json([
            'oui'=>$oui,
            'non'=>$non
        ], 201);

        return $resultat;
    }

}
