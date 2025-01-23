<?php

    namespace App\Http\Controllers;

    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Auth;

    class AuthController extends Controller
    {
        /**
         * @OA\Post(
         *     path="/api/login",
         *     tags={"Authentication"},
         *     summary="Login and get a token",
         *     description="Login with email and password, then retrieve an authentication token.",
         *     @OA\RequestBody(
         *         required=true,
         *         @OA\MediaType(
         *             mediaType="application/json",
         *             @OA\Schema(
         *                 type="object",
         *                 required={"email", "password"},
         *                 @OA\Property(property="email", type="string", example="test@example.com"),
         *                 @OA\Property(property="password", type="string", example="password")
         *             )
         *         )
         *     ),
         *     @OA\Response(
         *         response=200,
         *         description="Login successful",
         *         @OA\JsonContent(
         *             @OA\Property(property="access_token", type="string", description="JWT Token")
         *         )
         *     ),
         *     @OA\Response(
         *         response=401,
         *         description="Invalid credentials"
         *     )
         * )
         */
        public function login(Request $request)
        {
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $user = User::where('email', $validated['email'])->first();

            if (!$user || !Hash::check($validated['password'], $user->password)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json(['token' => $token]);
        }
    }
