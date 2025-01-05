<?php

namespace Tests\Feature\Card;

use App\Models\Card;
use App\Models\Customer;
use App\Models\Process;
use App\Models\ProcessColumn;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CardTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     */
    public function test_create_new_card_without_associates(): void
    {
        $response = $this->post(route('api.v1.card.create'), [
            'title'       => 'Test Card',
            'description' => $this->faker->text(),
        ])
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => Card::getStructure(),
            ]);

        $this->assertDatabaseHas('cards', [
            'uuid'        => $response->json('data.uuid'),
            'title'       => 'Test Card',
            'description' => $response->json('data.description'),
        ]);

        $this->assertDatabaseCount('cards', 1);
    }

    public function test_create_new_card_with_process_associate(): void
    {
        $process = Process::factory()->create();

        $response = $this->post(route('api.v1.card.create'), [
            'title'        => 'Test Card',
            'description'  => $this->faker->text(),
            'process_uuid' => $process->uuid,
        ])
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => Card::getStructure(),
            ]);

        $this->assertDatabaseHas('cards', [
            'uuid'        => $response->json('data.uuid'),
            'title'       => 'Test Card',
            'description' => $response->json('data.description'),
        ]);

        $this->assertNotEmpty($response->json('data.process_uuid'));
    }

    public function test_create_new_card_with_column_associate(): void
    {
        $process = Process::factory()->create();
        $processColumn = ProcessColumn::factory()->create([
            'process_id' => $process->id,
        ]);

        $response = $this->post(route('api.v1.card.create'), [
            'title'        => 'Test Card',
            'description'  => $this->faker->text(),
            'column_uuid'  => $processColumn->uuid,
            'process_uuid' => $process->uuid,
        ])
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => Card::getStructure(),
            ]);

        $this->assertDatabaseHas('cards', [
            'uuid'        => $response->json('data.uuid'),
            'title'       => 'Test Card',
            'description' => $response->json('data.description'),
        ]);

        $this->assertEquals($response->json('data.column_uuid'), $processColumn->uuid);
    }

    public function test_create_new_card_with_customer_associate(): void
    {
        $customer = Customer::factory()->create();

        $response = $this->post(route('api.v1.card.create'), [
            'title'         => 'Test Card',
            'description'   => $this->faker->text(),
            'customer_uuid' => $customer->uuid,
        ])
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => Card::getStructure(),
            ]);

        $this->assertDatabaseHas('cards', [
            'uuid'        => $response->json('data.uuid'),
            'title'       => 'Test Card',
            'description' => $response->json('data.description'),
        ]);

        $this->assertNotEmpty($response->json('data.customer_uuid'));
    }

    public function test_list_cards(): void
    {
        Card::factory()->count(5)->create();

        $this->get(route('api.v1.card.list'))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    Card::getStructure(),
                ],
            ]);

    }
}
