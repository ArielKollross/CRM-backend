<?php

namespace Tests\Feature\Process;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateProcessTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test 0, by Me
     */
    public function test_create_new_process(): void
    {
        $response = $this->post(route('api.v1.process.create'), [
            'name'        => 'Test Process',
            'description' => 'Test Description',
            'columns'     => [
                ['name' => 'Column 1'],
                ['name' => 'Column 2'],
            ],
        ])
            ->assertSuccessful()
            ->assertJsonStructure([
                'data',
            ]);

        $this->assertDatabaseHas('processes', [
            'id'          => $response->json('data.id'),
            'name'        => 'Test Process',
            'description' => 'Test Description',
        ]);

        $this->assertDatabaseHas('process_columns', [
            'process_id' => $response->json('data.id'),
            'name'       => 'Column 1',
        ]);

        $this->assertDatabaseHas('process_columns', [
            'process_id' => $response->json('data.id'),
            'name'       => 'Column 2',
        ]);
    }
}
