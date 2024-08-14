<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/projects",
     *     summary="Get a list of projects",
     *     tags={"Projects"},
     *     @OA\Response(
     *         response=200,
     *         description="List of projects",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Project"))
     *     )
     * )
     */
    public function index()
    {
        return Project::all();
    }

    /**
     * @OA\Post(
     *     path="/api/projects",
     *     summary="Create a new project",
     *     tags={"Projects"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProjectCreation")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Project created",
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'nullable|in:' . implode(',', array_keys(Project::$statuses)),
        ]);

        $project = Project::create($request->all());
        return response()->json($project, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/projects/{id}",
     *     summary="Get a specific project by ID",
     *     tags={"Projects"},
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
     *     @OA\Response(
     *         response=404,
     *         description="Project not found"
     *     )
     * )
     */
    public function show($id)
    {
        return Project::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/projects/{id}",
     *     summary="Update a project by ID",
     *     tags={"Projects"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProjectCreation")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Project updated",
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'string|max:255',
            'department' => 'string|max:255',
            'start_date' => 'date',
            'end_date' => 'date',
            'status' => 'in:' . implode(',', array_keys(Project::$statuses)),
        ]);

        $project = Project::findOrFail($id);
        $project->update($request->all());
        return response()->json($project, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/projects/{id}",
     *     summary="Delete a project by ID",
     *     tags={"Projects"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Project deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Project not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project>delete();
        return response()->json(null, 204);
    }
}

