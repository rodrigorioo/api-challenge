<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetProductsRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     *
     * *  @OA\Get(
     *      path="/api/products",
     *      tags={"Products"},
     *      summary="Lista todos los productos junto con su categoría",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="order",
     *                      type="string",
     *                      description="Órden de los resultados. Valores admitidos: name_asc, name_desc, stock_asc, stock_desc, price_asc, price_desc",
     *                      nullable=true,
     *                      default="name_asc",
     *                  ),
     *                  @OA\Property(
     *                      property="per_page",
     *                      type="integer",
     *                      description="Cuántos items por página desea obtener",
     *                      nullable=true,
     *                      default=50000,
     *                  ),
     *                  @OA\Property(
     *                      property="page",
     *                      type="integer",
     *                      description="Página que desea obtener",
     *                      nullable=true,
     *                      default=1,
     *                  ),
     *                  @OA\Property(
     *                      property="category_id",
     *                      type="integer",
     *                      description="ID de la categoría",
     *                      nullable=true,
     *                  ),
     *                  @OA\Property(
     *                      property="search",
     *                      type="string",
     *                      description="Texto que matchee con el nombre del producto",
     *                      nullable=true,
     *                  ),
     *                  example={"order": "name_desc", "per_page": 500, "page": 2, "category_id":395, "search": "Producto 5"}
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
     *                  example="http://api-challenge.test/api/products?page=1"
     *              ),
     *              @OA\Property(
     *                  property="from",
     *                  type="integer",
     *                  description="Desde que resultado empieza la página actual",
     *                  example=501,
     *              ),
     *              @OA\Property(
     *                  property="next_page_url",
     *                  type="string",
     *                  description="URL de la página siguiente",
     *                  nullable="true",
     *                  example="http://api-challenge.test/api/products?page=3",
     *              ),
     *              @OA\Property(
     *                  property="path",
     *                  type="string",
     *                  description="URL base para listar los elementos",
     *                  example="https://api-challenge.test/api/products",
     *              ),
     *              @OA\Property(
     *                  property="per_page",
     *                  type="string",
     *                  description="Cuantos elementos por página se listan",
     *                  example="500"
     *              ),
     *              @OA\Property(
     *                  property="prev_page_url",
     *                  type="string",
     *                  description="URL de la página anterior",
     *                  nullable="true",
     *                  example="http://api-challenge.test/api/products?page=1"
     *              ),
     *              @OA\Property(
     *                  property="to",
     *                  type="integer",
     *                  description="Total de elementos mostrados hasta el momento",
     *                  example=1000
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="id", ref="#/components/schemas/Product/properties/id"),
     *                      @OA\Property(property="name", ref="#/components/schemas/Product/properties/name"),
     *                      @OA\Property(property="stock", ref="#/components/schemas/Product/properties/stock"),
     *                      @OA\Property(property="price", ref="#/components/schemas/Product/properties/price"),
     *                      @OA\Property(property="image", ref="#/components/schemas/Product/properties/image"),
     *                      @OA\Property(property="category_id", ref="#/components/schemas/Product/properties/category_id"),
     *                      @OA\Property(property="created_at", ref="#/components/schemas/Product/properties/created_at"),
     *                      @OA\Property(property="updated_at", ref="#/components/schemas/Product/properties/updated_at"),
     *                      @OA\Property(
     *                          property="category",
     *                          type="object",
     *                          @OA\Property(property="id", ref="#/components/schemas/Category/properties/id"),
     *                          @OA\Property(property="name", ref="#/components/schemas/Category/properties/name"),
     *                          @OA\Property(property="father_id", ref="#/components/schemas/Category/properties/father_id"),
     *                          @OA\Property(property="created_at", ref="#/components/schemas/Category/properties/created_at"),
     *                          @OA\Property(property="updated_at", ref="#/components/schemas/Category/properties/updated_at"),
     *                      ),
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response="422",
     *          description="Error en los parámetros",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", description="Descripción general del error", example="The per page must not be greater than 50000."),
     *              @OA\Property(
     *                  property="errors",
     *                  type="object",
     *                  @OA\Property(
     *                      property="{name_of_parameter}",
     *                      type="array",
     *                      example="per_page",
     *                      @OA\Items(type="string", description="Descripción del error", example="The per page must not be greater than 50000.")
     *                  )
     *              )
     *          )
     *      )
     *  )
     */
    public function index(GetProductsRequest $request): JsonResponse {
        // Create query
        $productsQuery = Product::query()
            ->with([
                'category',
            ]);

        // Category
        if($request->has('category_id')) {
            $productsQuery->where('category_id', $request->category_id);
        }

        // Search by text
        if($request->has('search')) {
            $productsQuery->where('name', 'like', '%'.$request->search.'%');
        }

        // Order
        switch($request->order) {
            case 'stock_asc': $productsQuery->orderBy('stock', 'asc'); break;
            case 'stock_desc': $productsQuery->orderBy('stock', 'desc'); break;
            case 'name_asc': $productsQuery->orderBy('name', 'asc'); break;
            case 'name_desc': $productsQuery->orderBy('name', 'desc'); break;
            case 'price_asc': $productsQuery->orderBy('price', 'asc'); break;
            case 'price_desc': $productsQuery->orderBy('price', 'desc'); break;
        }

        // Get pagination
        $products = $productsQuery->simplePaginate($request->per_page);

        return new JsonResponse($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
