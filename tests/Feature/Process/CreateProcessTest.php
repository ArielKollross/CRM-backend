<?php

namespace Tests\Feature\Process;

use App\Models\Process;
use App\Models\ProcessColumn;
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

    public function test_add_new_column_to_existing_process(): void
    {
        $process = Process::factory()->create();
        $column1 = ProcessColumn::factory()->create(['process_id' => $process->id]);
        $column2 = ProcessColumn::factory()->create(['process_id' => $process->id]);

        // 2. Prepare Update Request Data
        $requestData = [
            'name'        => 'Updated Process Name',
            'description' => 'Updated Description',
            'columns'     => [
                [
                    'id'   => $column1->uuid,
                    'name' => 'Updated Column 1',
                ],
                [
                    'name' => 'New Column',
                ],
            ],
        ];

        $this->put(route(
            'api.v1.process.update',
            [
                'uuid' => $process->uuid,
            ]),
            $requestData
        )->assertSuccessful()->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'description',
                'columns',
            ],
        ]);

        $this->assertDatabaseHas('processes', [
            'id'          => $process->id,
            'name'        => $requestData['name'],
            'description' => $requestData['description'],
        ]);

        $this->assertDatabaseHas('process_columns', [
            'id'         => $column1->id,
            'name'       => 'Updated Column 1',
            'process_id' => $process->id,
        ]);

        $this->assertDatabaseHas('process_columns', [
            'name'       => 'New Column',
            'process_id' => $process->id,
        ]);

        $this->assertSoftDeleted('process_columns', [
            'id' => $column2->id,
        ]);

        $this->assertDatabaseCount('process_columns', 3);
    }
}
