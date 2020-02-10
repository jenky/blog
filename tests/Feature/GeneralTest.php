<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GeneralTest extends TestCase
{
    public function test_home_page()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
