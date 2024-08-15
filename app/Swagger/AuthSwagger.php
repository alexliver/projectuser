<?php
// app/Swagger/AuthSwagger.php
namespace App\Swagger;
/**
 * @OA\Post(
 *     path="/oauth/token",
 *     tags={"Authentication"},
 *     summary="Get OAuth2 access token",
 *     description="This endpoint returns an OAuth2 access token for the client.",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"grant_type", "client_id", "client_secret", "username", "password"},
 *             @OA\Property(property="grant_type", type="string", example="password"),
 *             @OA\Property(property="client_id", type="string", example="1"),
 *             @OA\Property(property="client_secret", type="string", example="your-client-secret"),
 *             @OA\Property(property="username", type="string", example="user@example.com"),
 *             @OA\Property(property="password", type="string", example="your-password"),
 *             @OA\Property(property="scope", type="string", example=""),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(property="token_type", type="string", example="Bearer"),
 *             @OA\Property(property="expires_in", type="integer", example=31536000),
 *             @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9"),
 *             @OA\Property(property="refresh_token", type="string", example="def502009f7c84fd0343a"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="invalid_request"),
 *             @OA\Property(property="error_description", type="string", example="The request is missing a required parameter, includes an invalid parameter value, or is otherwise malformed."),
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="invalid_grant"),
 *             @OA\Property(property="error_description", type="string", example="The user credentials were incorrect."),
 *         )
 *     )
 * )
 */

class AuthSwagger
{
    // This class is only for Swagger annotations and will not contain any logic.
}
