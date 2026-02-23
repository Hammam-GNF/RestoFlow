<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Table;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderFlowTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_pelayan_can_open_order()
    {
        $pelayan = User::factory()->create(['role' => 'pelayan']);
        $table = Table::factory()->create(['status' => 'available']);

        $response = $this->actingAs($pelayan, 'sanctum')
            ->postJson('/api/orders', [
                'table_id' => $table->id
            ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('orders', [
            'table_id' => $table->id,
            'status' => 'open',
        ]);

        $this->assertDatabaseHas('tables', [
            'id' => $table->id,
            'status' => 'occupied',
        ]);
    }

    public function test_kasir_can_close_order()
    {
        $kasir = User::factory()->create(['role' => 'kasir']);
        $table = Table::factory()->create(['status' => 'occupied']);

        $order = Order::factory()->create([
            'table_id' => $table->id,
            'status' => 'open'
        ]);

        $response = $this->actingAs($kasir, 'sanctum')
            ->patchJson("/api/orders/{$order->id}/close");

        $response->assertOk();

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'closed',
        ]);

        $this->assertDatabaseHas('tables', [
            'id' => $table->id,
            'status' => 'available',
        ]);
    }
}
