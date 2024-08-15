<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use App\Process\UserProjectProcess;

/**
 * For a hypothetical user app interacting with projects
 */
class UserProjectManagementController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user-project-management/join-project/{id}",
     *     summary="Join a project",
     *     tags={"User Project Management"},
     *     security={{"bearer":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Project details",
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     ),
     * )
     */
    public function joinProject(Request $request, $id)
    {
        $user = $request->user();
        $project = Project::findOrFail($id);
        UserProjectProcess::joinProject($user, $project);
        return response()->json($project, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/user-project-management/my-projects",
     *     summary="Get a list of the current user's projects",
     *     tags={"User Project Management"},
     *     security={{ "bearer": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="List of projects",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Project"))
     *     )
     * )
     */
    public function myProjects(Request $request)
    {
        $user = $request->user();
        return response()->json($user->projects);
    }
}

