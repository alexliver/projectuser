<?php

namespace App\Http\Resources;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Project",
 *     type="object",
 *     required={"name", "department", "start_date", "end_date", "status"},
 *     @OA\Property(property="id", type="integer", format="int64"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="department", type="string"),
 *     @OA\Property(property="start_date", type="string", format="date"),
 *     @OA\Property(property="end_date", type="string", format="date"),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         enum={"in_progress", "finished"},
 *         example="in_progress"
 *     ),
 * )
 */
class ProjectResource {}

