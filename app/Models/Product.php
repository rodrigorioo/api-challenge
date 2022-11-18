<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *  @OA\Schema(
 *      schema="Product",
 *      title="Product",
 * 	    @OA\Property(
 * 		    property="id",
 * 		    type="integer",
 *          example=4,
 * 	    ),
 *      @OA\Property(
 * 		    property="name",
 * 		    type="string",
 *          example="Producto 4",
 * 	    ),
 *      @OA\Property(
 * 		    property="stock",
 * 		    type="integer",
 *          default=0,
 *          example=15,
 * 	    ),
 *      @OA\Property(
 * 		    property="price",
 * 		    type="float",
 *          default=0,
 *          example=90.10,
 * 	    ),
 *      @OA\Property(
 * 		    property="image",
 * 		    type="string",
 *          example="https://via.placeholder.com/640x480.png/008888?text=ipsum",
 * 	    ),
 *      @OA\Property(
 * 		    property="category_id",
 * 		    type="integer",
 *          example=7,
 * 	    ),
 *      @OA\Property(
 * 		    property="created_at",
 *          description="Timestamp in format: Y-m-d H:i:s",
 * 		    type="string",
 *          example="2022-11-15 20:15:00"
 * 	    ),
 *      @OA\Property(
 * 		    property="updated_at",
 *          description="Timestamp in format: Y-m-d H:i:s",
 * 		    type="string",
 *          example="2022-11-15 20:15:00"
 * 	    ),
 *      @OA\Property(
 * 		    property="category",
 * 		    type="object",
 *          ref="#/components/schemas/Category"
 * 	    ),
 *  )
 */
class Product extends Model
{
    use HasFactory;

    /** RELATIONS */

    public function category () {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /** END RELATIONS */
}
