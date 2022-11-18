<?php

namespace Tests\Feature\Http\Controllers\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{

    public function testIndex()
    {
        $response = $this->get(action('App\Http\Controllers\API\CategoryController@index', [
            'per_page' => 50,
            'page' => 1,
        ]));

        $response->assertStatus(200);
    }
}
