<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/timesheets",
     *     summary="Get a list of timesheets",
     *     tags={"Timesheets"},
     *     @OA\Response(
     *         response=200,
     *         description="List of timesheets",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Timesheet"))
     *     )
     * )
     */
    public function index()
    {
        $timesheets = Timesheet::with(['user', 'project'])->get();
        return response()->json($timesheets);
    }

    /**
     * @OA\Post(
     *     path="/api/timesheets",
     *     summary="Create a new timesheet",
     *     tags={"Timesheets"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TimesheetCreation")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Timesheet created",
     *         @OA\JsonContent(ref="#/components/schemas/Timesheet")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
            'task_name' => 'required|string|max:255',
            'date' => 'required|date',
            'hours' => 'required|integer|min:0'
        ]);

        $timesheet = Timesheet::create($request->all());
        return response()->json($timesheet, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/timesheets/{id}",
     *     summary="Get a specific timesheet by ID",
     *     tags={"Timesheets"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Timesheet details",
     *         @OA\JsonContent(ref="#/components/schemas/Timesheet")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Timesheet not found"
     *     )
     * )
     */
    public function show($id)
    {
        return Timesheet::with(['user', 'project'])->findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/timesheets/{id}",
     *     summary="Update a timesheet by ID",
     *     tags={"Timesheets"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TimesheetCreation")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Timesheet updated",
     *         @OA\JsonContent(ref="#/components/schemas/Timesheet")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Timesheet not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'exists:users,id',
            'project_id' => 'exists:projects,id',
            'task_name' => 'string|max:255',
            'date' => 'date',
            'hours' => 'integer|min:0'
        ]);

        $timesheet = Timesheet::findOrFail($id);
        $timesheet->update($request->all());
        return response()->json($timesheet, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/timesheets/{id}",
     *     summary="Delete a timesheet by ID",
     *     tags={"Timesheets"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Timesheet deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Timesheet not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $timesheet = Timesheet::findOrFail($id);
        $timesheet>delete();
        return response()->json(null, 204);
    }
}

