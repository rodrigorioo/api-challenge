<?php

namespace Tests\Feature\Http\Controllers\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{

    public function testIndex()
    {
        $response = $this->get(action('App\Http\Controllers\API\ProductController@index'));

        $response->assertStatus(200);
    }
}
