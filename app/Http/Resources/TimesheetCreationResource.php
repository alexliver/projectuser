<?php

namespace App\Http\Resources;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="TimesheetCreation",
 *     type="object",
 *     required={ "user_id", "project_id", "task_name", "date", "hours" },
 *     @OA\Property(property="user_id", type="integer", format="int64"),
 *     @OA\Property(property="project_id", type="integer", format="int64"),
 *     @OA\Property(property="task_name", type="string"),
 *     @OA\Property(property="date", type="string", format="date"),
 *     @OA\Property(property="hours", type="integer", format="int64"),
 * )
 */
class TimesheetCreationResource {}


