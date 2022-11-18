<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetCategoriesRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     *
     *  @OA\Get(
     *      path="/api/categories",
     *      tags={"Categories"},
     *      summary="Lista todas las categorías padre (Es decir, que no tienen padre)",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="order",
     *                      type="string",
     *                      description="Órden de los resultados. Valores admitidos: name_asc, name_desc",
     *                      nullable=true,
     *                      default="name_asc"
     *                  ),
     *                  @OA\Property(
     *                      property="per_page",
     *                      type="integer",
     *                      description="Cuántos items por página desea obtener",
     *                      nullable=true,
     *                      default=500
     *                  ),
     *                  @OA\Property(
     *                      property="page",
     *                      type="integer",
     *                      description="Página que desea obtener",
     *                      nullable=true,
     *                      default=1
     *                  ),
     *                  example={"order": "name_desc", "per_page": 100, "page": 2}
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="current_page",
     *                  type="integer",
     *                  description="Página actual que se está devolviendo",
     *                  example=2,
     *              ),
     *              @OA\Property(
     *                  property="first_page_url",
     *                  type="string",
     *                  nullable="true",
     *                  description="URL de la primer página",
     *                  example="http://api-challenge.test/api/categories?page=1"
     *              ),
     *              @OA\Property(
     *                  property="from",
     *                  type="integer",
     *                  description="Desde que resultado empieza la página actual",
     *                  example=101,
     *              ),
     *              @OA\Property(
     *                  property="next_page_url",
     *                  type="string",
     *                  description="URL de la página siguiente",
     *                  nullable="true",
     *                  example=null,
     *              ),
     *              @OA\Property(
     *                  property="path",
     *                  type="string",
     *                  description="URL base para listar los elementos",
     *                  example="https://api-challenge.test/api/categories",
     *              ),
     *              @OA\Property(
     *                  property="per_page",
     *                  type="string",
     *                  description="Cuantos elementos por página se listan",
     *                  example="100"
     *              ),
     *              @OA\Property(
     *                  property="prev_page_url",
     *                  type="string",
     *                  description="URL de la página anterior",
     *                  nullable="true",
     *                  example="https://api-challenge.test/api/categories?page=1"
     *              ),
     *              @OA\Property(
     *                  property="to",
     *                  type="integer",
     *                  description="Total de elementos mostrados hasta el momento",
     *                  example=147
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", ref="#/components/schemas/Category/properties/id"),
     *                      @OA\Property(property="name", ref="#/components/schemas/Category/properties/name"),
     *                      @OA\Property(property="father_id", ref="#/components/schemas/Category/properties/father_id"),
     *                      @OA\Property(property="created_at", ref="#/components/schemas/Category/properties/created_at"),
     *                      @OA\Property(property="updated_at", ref="#/components/schemas/Category/properties/updated_at"),
     *                      @OA\Property(property="childrens_recursive", ref="#/components/schemas/Category/properties/childrens_recursive"),
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response="422",
     *          description="Error en los parámetros",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", description="Descripción general del error", example="The per page must not be greater than 500."),
     *              @OA\Property(
     *                  property="errors",
     *                  type="object",
     *                  @OA\Property(
     *                      property="{name_of_parameter}",
     *                      type="array",
     *                      example="per_page",
     *                      @OA\Items(type="string", description="Descripción del error", example="The per page must not be greater than 500.")
     *                  )
     *              )
     *          )
     *      )
     *  )
     */
    public function index(GetCategoriesRequest $request): JsonResponse {
        // Create query
        $categoriesQuery = Category::query()
            ->with([
                'childrens_recursive',
            ])
            ->whereDoesntHave('father');

        // Order
        switch($request->order) {
            case 'name_asc':
                $categoriesQuery->orderBy('name', 'asc');
                break;

            case 'name_desc':
                $categoriesQuery->orderBy('name', 'desc');
                break;
        }

        // Obtain pagination
        $categories = $categoriesQuery->simplePaginate($request->per_page);

        return new JsonResponse($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
