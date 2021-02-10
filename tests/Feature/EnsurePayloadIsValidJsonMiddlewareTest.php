<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EnsurePayloadIsValidJsonMiddlewareTest extends TestCase
{
    /**
     * Test for requests with invalid json
     *
     * @return void
     */
    public function testRejectNonJsonContentType()
    {
        $response = $this->withHeader('Content-Type', 'text/html')->post('api/dictionary')
            ->assertStatus(400)
            ->assertJson([
                'status' => false,
                'error' => 'JSON expected. Got Content-Type: html instead.'
            ]);
    }

    /**
     * Test for requests with correct content type but empty json
     *
     * @return void
     */
    public function testRejectEmptyJson()
    {
        $this->postJson('api/dictionary')
            ->assertStatus(400)
            ->assertJson([
                'status' => false,
                'error' => 'Malformed JSON received. Please check your input.'
            ]);
    }

    /**
     * Test for requests with correct content type but invalid json
     *
     * @return void
     */
    public function testRejectInvalidJson()
    {
        $this->post('api/dictionary', ['{ invalid_json }'], ['Content-Type' => 'application/json'])
            ->assertStatus(400)
            ->assertJson([
                'status' => false,
                'error' => 'Malformed JSON received. Please check your input.'
            ]);
    }


}
