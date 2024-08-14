<?php

namespace App\Http\Resources;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ProjectCreation",
 *     type="object",
 *     required={"name", "department", "start_date", "end_date"},
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
class ProjectCreationResource {}

