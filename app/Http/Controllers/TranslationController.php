<?php

    namespace App\Http\Controllers;

    /**
     * @OA\Info(
     *     title="My API",
     *     version="1.0.0",
     *     description="This is the API documentation for my project.",
     *     @OA\Contact(
     *         email="developer@example.com"
     *     ),
     *     @OA\License(
     *         name="MIT",
     *         url="https://opensource.org/licenses/MIT"
     *     )
     * )
     *
     * @OA\SecurityScheme(
     *     securityScheme="BearerAuth",
     *     type="http",
     *     scheme="bearer",
     *     bearerFormat="JWT",
     * )
     */



    use App\Models\Translation;
    use App\Repositories\TranslationRepositoryInterface;
    use Illuminate\Http\Request;
    use Illuminate\Routing\Controller;

    class TranslationController extends Controller
    {
        private $translationRepository;
        /**
         * @OA\Components(
         *     @OA\Schema(
         *         schema="Translation",
         *         type="object",
         *         required={"key", "content", "tags"},
         *         @OA\Property(property="key", type="string", description="The key of the translation"),
         *         @OA\Property(property="content", type="object",
         *             @OA\Property(property="en", type="string", description="Translation in English"),
         *             @OA\Property(property="fr", type="string", description="Translation in French"),
         *             @OA\Property(property="es", type="string", description="Translation in Spanish")
         *         ),
         *         @OA\Property(property="tags", type="string", description="Comma-separated list of tags")
         *     )
         * )
         */
        public function __construct(TranslationRepositoryInterface $translationRepository)
        {
            $this->translationRepository = $translationRepository;
        }

        /**
         * @OA\Post(
         *     path="/api/translations",
         *     tags={"Translations"},
         *     summary="Create a new translation",
         *     security={{"BearerAuth": {}}},
         *     @OA\RequestBody(
         *         required=true,
         *         @OA\JsonContent(
         *             required={"key", "content", "tags"},
         *             @OA\Property(property="key", type="string"),
         *             @OA\Property(property="content", type="object", @OA\Property(property="en", type="string")),
         *             @OA\Property(property="tags", type="string")
         *         )
         *     ),
         *     @OA\Response(
         *         response=201,
         *         description="Translation created",
         *         @OA\JsonContent(ref="#/components/schemas/Translation")
         *     ),
         *     @OA\Response(
         *         response=400,
         *         description="Invalid data"
         *     )
         * )
         */
        public function create(Request $request)
        {
            $validated = $request->validate([
                'key' => 'required|string|unique:translations',
                'content' => 'required|array',
                'tags' => 'nullable|string',
            ]);

            $translation = $this->translationRepository->create($validated);

            return response()->json($translation, 201);
        }
        /**
         * @OA\Put(
         *     path="/api/translations/{id}",
         *     tags={"Translations"},
         *     summary="Update a translation",
         *     security={{"BearerAuth": {}}},
         *     @OA\Parameter(
         *         name="id",
         *         in="path",
         *         required=true,
         *         @OA\Schema(type="integer")
         *     ),
         *     @OA\RequestBody(
         *         required=true,
         *         @OA\JsonContent(
         *             required={"key", "content", "tags"},
         *             @OA\Property(property="key", type="string"),
         *             @OA\Property(property="content", type="object", @OA\Property(property="en", type="string")),
         *             @OA\Property(property="tags", type="string")
         *         )
         *     ),
         *     @OA\Response(
         *         response=200,
         *         description="Translation updated",
         *         @OA\JsonContent(ref="#/components/schemas/Translation")
         *     ),
         *     @OA\Response(
         *         response=404,
         *         description="Translation not found"
         *     )
         * )
         */
        public function update(Request $request, $id)
        {
            $validated = $request->validate([
                'key' => 'sometimes|required|string|unique:translations,key,' . $id,
                'content' => 'sometimes|required|array',
                'tags' => 'nullable|string',
            ]);

            $translation = $this->translationRepository->update($id, $validated);

            return response()->json($translation);
        }

        /**
         * @OA\Get(
         *     path="/api/translations/{id}",
         *     tags={"Translations"},
         *     summary="Get Translation by ID",
         *     security={{"BearerAuth": {}}},
         *     description="Retrieve a translation by its ID.",
         *     @OA\Parameter(
         *         name="id",
         *         in="path",
         *         required=true,
         *         @OA\Schema(type="integer")
         *     ),
         *     @OA\Response(
         *         response=200,
         *         description="Translation found",
         *         @OA\JsonContent(ref="#/components/schemas/Translation")
         *     ),
         *     @OA\Response(
         *         response=404,
         *         description="Translation not found"
         *     )
         * )
         */
        public function view($id)
        {
            return $this->translationRepository->find($id);
        }
        /**
         *
         * @OA\Get(
         *     path="/api/translation/search",
         *     operationId="searchTranslations",
         *     tags={"Translations"},
         *     security={{"BearerAuth": {}}},
         *     summary="Search for translations",
         *     description="Search for translations based on key, tags, or content",
         *     @OA\Parameter(
         *         name="key",
         *         in="query",
         *         description="Search translations by key",
         *         required=false,
         *         @OA\Schema(type="string")
         *     ),
         *     @OA\Parameter(
         *         name="tags",
         *         in="query",
         *         description="Search translations by tags",
         *         required=false,
         *         @OA\Schema(type="string")
         *     ),
         *     @OA\Response(
         *         response=200,
         *         description="Search results",
         *         @OA\JsonContent(
         *             type="array",
         *             @OA\Items(ref="#/components/schemas/Translation")
         *         )
         *     ),
         *     @OA\Response(
         *         response=400,
         *         description="Invalid parameters",
         *         @OA\JsonContent(
         *             @OA\Property(property="message", type="string", example="Invalid search parameters.")
         *         )
         *     ),
         * )
         */

        public function search(Request $request)
        {
            $translations = $this->translationRepository->search($request->all());
            return response()->json($translations);
        }

        public function export()
        {
            $translations = $this->translationRepository->exportAll();
            return response()->json($translations);
        }
    }
