<?php

namespace Tests\Feature;

use App\Models\Expense;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExpenseApiTest extends TestCase
{
    use RefreshDatabase; // rebuilds a clean DB for every test

    public function test_can_create_an_expense(): void
    {
        $payload = [
            'date' => '2026-08-20',
            'cost' => 1200.00,
            'description' => 'Bus fare',
            'expense_type' => 'travel',
        ];

        $response = $this->postJson('/api/expenses', $payload);

        $response->assertStatus(201)
                 ->assertJsonFragment(['description' => 'Bus fare']);

        $this->assertDatabaseHas('expenses', ['description' => 'Bus fare']);
    }

    public function test_validation_rejects_bad_expense_type(): void
    {
        $payload = [
            'date' => '2026-08-20',
            'cost' => 100,
            'description' => 'Something',
            'expense_type' => 'not-a-real-type', // invalid on purpose
        ];

        $response = $this->postJson('/api/expenses', $payload);

        $response->assertStatus(422); // validation failure
    }

    public function test_can_list_expenses(): void
    {
        Expense::factory()->count(3)->create();

        $response = $this->getJson('/api/expenses');

        $response->assertStatus(200)->assertJsonCount(3);
    }

    public function test_can_view_a_single_expense(): void
    {
        $expense = Expense::factory()->create();

        $response = $this->getJson("/api/expenses/{$expense->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $expense->id]);
    }

    public function test_can_delete_an_expense(): void
    {
        $expense = Expense::factory()->create();

        $response = $this->deleteJson("/api/expenses/{$expense->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('expenses', ['id' => $expense->id]);
    }
}