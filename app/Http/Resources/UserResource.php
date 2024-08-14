<?php

namespace App\Http\Resources;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     required={"first_name", "last_name", "date_of_birth", "gender", "email", "password"},
 *     @OA\Property(property="id", type="integer", format="int64"),
 *     @OA\Property(property="first_name", type="string"),
 *     @OA\Property(property="last_name", type="string"),
 *     @OA\Property(property="date_of_birth", type="string", format="date"),
 *     @OA\Property(
 *         property="gender",
 *         type="string",
 *         enum={"male", "female"},
 *         example="male"
 *     ),
 *     @OA\Property(property="email", type="string"),
 *     @OA\Property(property="password", type="string"),
 * )
 */
class UserResource {}
