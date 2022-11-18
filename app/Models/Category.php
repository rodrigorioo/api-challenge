<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *  @OA\Schema(
 *      schema="Category",
 *      title="Category",
 *      @OA\Property(
 * 		    property="id",
 * 		    type="integer",
 *          example=7,
 * 	    ),
 * 	    @OA\Property(
 * 		    property="name",
 * 		    type="string",
 *          example="Categoría 7",
 * 	    ),
 *      @OA\Property(
 * 		    property="father_id",
 * 		    type="integer",
 *          nullable="true",
 *          example=3
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
 * 		    property="father",
 *          description="Father category",
 * 		    type="array",
 *          @OA\Items(ref="#/components/schemas/Category",),
 *          example={"id":3,"name":"Categoría 3","father_id":null,"created_at":"2022-11-15 20:15:00","updated_at":"2022-11-15 20:15:00","childrens_recursive":{}}
 * 	    ),
 *      @OA\Property(
 * 		    property="childrens_recursive",
 *          description="Childrens category",
 * 		    type="array",
 *          @OA\Items(ref="#/components/schemas/Category",),
 *          example={"id":9,"name":"Categoría 9","father_id":7,"created_at":"2022-11-15 20:15:00","updated_at":"2022-11-15 20:15:00","childrens_recursive":{
 *              {"id":12,"name": "Categoría 12","father_id":9,"created_at":"2022-11-15 20:15:00","updated_at":"2022-11-15 20:15:00","childrens_recursive":{}},
 *              {"id":13,"name": "Categoría 13","father_id":9,"created_at":"2022-11-15 20:15:00","updated_at":"2022-11-15 20:15:00","childrens_recursive":{}},
 *          }}
 * 	    ),
 *  )
 */

class Category extends Model
{
    use HasFactory;

    /** RELATIONS */

    public function childrens () {
        return $this->hasMany(Category::class, 'father_id');
    }

    public function father () {
        return $this->belongsTo(Category::class, 'father_id');
    }

    public function childrens_recursive () {
        return $this->hasMany(Category::class, 'father_id')
            ->with('childrens_recursive');
    }

    /** END RELATIONS */
}
