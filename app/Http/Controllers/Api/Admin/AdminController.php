<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ElectionController;
use App\Http\Controllers\Api\ElectionParticipantController;
use App\Http\Controllers\Api\ResultatsVotesController;
use App\Http\Controllers\Api\SondageController;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function getAllUsers()
    {


        if (User::all()->count() == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun utilisateur trouvé',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'list de tout les utilisateurs paginé par 10',
            'data' => User::paginate(10)
        ]);
    }

    public function getUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non trouvé',
            ], 400);
        }
        return response()->json([
            'success' => true,
            'message' => 'Utilisateur trouvé',
            'data' => $user
        ]);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non trouvé',
            ], 400);
        }
        if ($user->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Utilisateur supprimé',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non supprimé',
            ], 500);
        }
    }


    /**
     * @OA\Post(
     *     path="not-defined-yet",
     *     tags={"Admin Actions"},
     *     summary="Add a new admin",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Admin")
     *     ),
     *     @OA\Response(response="201", description="Admin added successfully"),
     *     @OA\Response(response="400", description="Bad request")
     * )
     */
    public function addAdmin(Request $request)
    {
    }


    /**
     * @OA\Post(
     *     path="api/admin/add-election",
     *     tags={"Admin Actions"},
     *     summary="Add a new election",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Election")
     *     ),
     *     @OA\Response(response="201", description="Election added successfully"),
     *     @OA\Response(response="400", description="Bad request")
     * )
     */

    public function addElection(Request $request)
    {
        $electionController = new ElectionController();

        return $electionController->addElection($request);
    }



    /**
     * @OA\Put(
     *     path="api/admin/update-election/{id}",
     *     tags={"Admin Actions"},
     *     summary="Update an election",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Election")
     *     ),
     *     @OA\Response(response="201", description="Election updated successfully"),
     *     @OA\Response(response="400", description="Bad request")
     * )
     */

    public function updateElection(Request $request, $id)
    {
        $electionController = new ElectionController();

        return $electionController->updateData($request, $id);
    }


    /**
     * @OA\Delete(
     *     path="api/admin/delete-election/{id}",
     *     tags={"Admin Actions"},
     *     summary="Delete an election",
     *    security={{"bearerAuth":{}}},
     *     @OA\Response(response="201", description="Election deleted successfully"),
     *     @OA\Response(response="400", description="Bad request")
     * )
     */

    public function deleteElection($id)
    {
        $electionController = new ElectionController();

        return $electionController->delete($id);
    }



    /**
     * @OA\Put(
     *     path="api/admin/election/{id}/update-banner",
     *     tags={"Admin Actions"},
     *     summary="Update banner",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="banner", type="string", format="binary")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Banner updated successfully"),
     *     @OA\Response(response="400", description="Bad request")
     * )
     */
    public function updateBanner(Request $request, $id)
    {
        $electionController = new ElectionController();

        return $electionController->updateBanner($id, $request);
    }




    /**
     * @OA\Put(
     *     path="api/admin/election/{id}/update-logo",
     *     tags={"Admin Actions"},
     *     summary="Update banner",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="logo", type="string", format="binary")
     *         )
     *     ),
     *     @OA\Response(response="201", description="logo updated successfully"),
     *     @OA\Response(response="400", description="Bad request")
     * )
     */
    public function updateLogo(Request $request, $id)
    {
        $electionController = new ElectionController();

        return $electionController->updateImage($id, $request);
    }


    //sondage


    /**
     * @OA\Post(
     *     path="api/admin/add-sondage",
     *     tags={"Admin Actions"},
     *     summary="Add a new sondage",
     *    security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Sondage")
     *     ),
     *     @OA\Response(response="201", description="Sondage added successfully"),
     *     @OA\Response(response="400", description="Bad request")
     * )
     */
    public function addSondage(Request $request)
    {
        $sondageController = new SondageController();

        return $sondageController->addSondage($request);
    }




    /**
     * @OA\Post(
     *     path="api/admin/update-sondage/{id}",
     *     tags={"Admin Actions"},
     *     summary="update sondage",
     *    security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *        name="id",
     *          description="ID du sondage",
     *          required=true,
     *          in="path",
     *           @OA\Schema(
     *              type="integer",
     *          )
     *          ),
     *
     *    @OA\RequestBody(
     *        required=true,
     *       @OA\JsonContent(ref="#/components/schemas/Sondage")
     *   ),
     *     @OA\Response(response="201", description="Sondage added successfully"),
     *     @OA\Response(response="400", description="Bad request")
     * )
     */


    public function updateSondage(Request $request, $id)
    {
        $sondageController = new SondageController();

        return $sondageController->updateSondage($id, $request);
    }


    /**
     * @OA\Delete(
     *    path="api/admin/delete-sondage/{id}",
     *   tags={"Admin Actions"},
     *  summary="Delete sondage",
     *  security={{"bearerAuth":{}}},
     * @OA\Response(response="201", description="Sondage deleted successfully"),
     * @OA\Response(response="400", description="Bad request")
     * )
     *
     */
    public function deleteSondage($id)
    {
        $sondageController = new SondageController();

        return $sondageController->deleteSondage($id);
    }




    //election participant

    /**
     * @OA\Post(
     *     path="/admin/elections/{id}/add-participant",
     *     tags={"Admin Actions"},
     *    description="Ajouter un participant à une élection",
     *    @OA\Parameter(
     *        name="id",
     *       description="ID de l'élection",
     *      required=true,
     *    in="path",
     *   @OA\Schema(
     *     type="integer",
     *  )
     * ),
     *     summary="Ajouter un participant à une élection",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/ElectionParticipant")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Succès - Participant ajouté avec succès"),
     *     @OA\Response(response="401", description="Non autorisé - L'utilisateur n'est pas authentifié"),
     * )
     */

    public function addElectionParticipant(Request $request){
        $partcipantController = new ElectionParticipantController();

        return $partcipantController->addPartcicipant($request);
    }



    //delete participant

    /**
     * @OA\Delete(
     *     path="api/admin/elections/{id}/delete-participant/{id_participant}",
     *     tags={"Admin Actions"},
     *    description="Supprimer un participant à une élection",
     *    @OA\Parameter(
     *        name="id",
     *       description="ID de l'élection",
     *      required=true,
     *    in="path",
     *   @OA\Schema(
     *     type="integer",
     *  )
     * ),
     * @OA\Parameter(
     *       name="id_participant",
     *     description="ID du participant",
     *   required=true,
     * in="path",
     * @OA\Schema(
     *  type="integer",
     * )
     * ),
     *     summary="Supprimer un participant à une élection",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/ElectionParticipant")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Succès - Participant supprimé avec succès"),
     *     @OA\Response(response="401", description="Non autorisé - L'utilisateur n'est pas authentifié"),
     * )
     */

    public function deleteElectionParticipant(Request $request){
        $partcipantController = new ElectionParticipantController();

        return $partcipantController->deletePartcipant($request);
    }


    //calculer les resultats

    /**
     * @OA\Get(
     *     path="api/admin/elections/{id}/calculate-result",
     *     tags={"Admin Actions"},
     *     summary="Calculer les résultats d'une élection",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'élection",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(response="200", description="Succès - Résultats calculés et renvoyés"),
     *     @OA\Response(response="401", description="Non autorisé - L'utilisateur n'est pas authentifié"),
     * )
     */
    public function calculateResult($id){
        $partcipantController = new ResultatsVotesController();

        return $partcipantController->calculerResultats($id);
    }


    //get resultats
    /**
     * @OA\Get(
     *     path="api/admin/elections/{id}/get-result",
     *     tags={"Admin Actions"},
     *     summary="Obtenir les résultats d'une élection",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'élection",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(response="200", description="Succès - Résultats de l'élection renvoyés"),
     *     @OA\Response(response="401", description="Non autorisé - L'utilisateur n'est pas authentifié"),
     * )
     */

    public function getResultats(int $id){
        $partcipantController = new ResultatsVotesController();

        return $partcipantController->getResultats($id);
    }

}
