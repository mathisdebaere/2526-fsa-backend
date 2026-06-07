<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\HelpRequest;
use App\Models\HelpRequestCategory;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HelpRequestControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $clientUser;
    protected Client $client;
    protected User $volunteerUser;
    protected Volunteer $volunteer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->clientUser = User::factory()->client()->verified()->create();
        $this->client = Client::factory()->create(['user_id' => $this->clientUser->id]);

        $this->volunteerUser = User::factory()->volunteer()->verified()->create();
        $this->volunteer = Volunteer::factory()->create(['user_id' => $this->volunteerUser->id]);
    }

    private function giveClientActiveSubscription(): Subscription
    {
        return Subscription::factory()->create(['client_id' => $this->client->id]);
    }

    public function test_a_client_with_active_subscription_sees_only_own_help_requests(): void
    {
        $this->giveClientActiveSubscription();
        $ownRequest = HelpRequest::factory()->create(['client_id' => $this->client->id]);
        HelpRequest::factory()->create(); 

        $response = $this->actingAs($this->clientUser, 'sanctum')->getJson('/api/help-requests');

        $response->assertOk();
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['id' => $ownRequest->id]);
    }

    public function test_unauthenticated_user_cannot_list_help_requests(): void
    {
        HelpRequest::factory()->create();
        $response = $this->getJson('/api/help-requests');
        $response->assertUnauthorized();
    }

    public function test_a_client_without_active_subscription_cannot_list_help_requests(): void
    {
        $response = $this->actingAs($this->clientUser, 'sanctum')->getJson('/api/help-requests');
        $response->assertForbidden();
    }
    public function test_a_client_with_active_subscription_can_store_a_help_request(): void
    {
        $this->giveClientActiveSubscription();
        $category = HelpRequestCategory::factory()->create();
        $payload = [
            'region' => 'Gent',
            'date' => now()->addWeek()->format('Y-m-d'),
            'time' => '10:00',
            'help_request_category_id' => $category->id,
        ];

        $response = $this->actingAs($this->clientUser, 'sanctum')->postJson('/api/help-requests', $payload);
        $response->assertCreated();
        $response->assertJsonFragment(['region' => 'Gent']);
        $this->assertDatabaseHas('help_requests', [
            'region' => 'Gent',
            'client_id' => $this->client->id,
            'help_request_category_id' => $category->id,
        ]);
    }

    public function test_storing_a_help_request_with_missing_required_fields_returns_422(): void
    {
        $this->giveClientActiveSubscription();
        $payload = []; 

        $response = $this->actingAs($this->clientUser, 'sanctum')->postJson('/api/help-requests', $payload);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['region', 'date', 'time', 'help_request_category_id']);
        $this->assertDatabaseCount('help_requests', 0);
    }

    public function test_a_client_without_active_subscription_cannot_store_a_help_request(): void
    {
        $category = HelpRequestCategory::factory()->create();
        $payload = [
            'region' => 'Antwerpen',
            'date' => now()->addWeek()->format('Y-m-d'),
            'time' => '14:20',
            'help_request_category_id' => $category->id,
        ];

        $response = $this->actingAs($this->clientUser, 'sanctum')->postJson('/api/help-requests', $payload);
        $response->assertForbidden();
        $this->assertDatabaseCount('help_requests', 0);
    }

    public function test_an_authenticated_user_can_view_a_single_help_request(): void
    {
        $helpRequest = HelpRequest::factory()->create();

        $response = $this->actingAs($this->volunteerUser, 'sanctum')->getJson("/api/help-requests/{$helpRequest->id}");
        $response->assertOk();
        $response->assertJsonFragment(['id' => $helpRequest->id]);
        $response->assertJsonPath('id', $helpRequest->id);
    }

    public function test_showing_a_non_existent_help_request_returns_404(): void
    {
        $this->giveClientActiveSubscription();
        $nonExistentId = 99999;
        $response = $this->actingAs($this->clientUser, 'sanctum')->getJson("/api/help-requests/{$nonExistentId}");
        $response->assertNotFound();
    }

    public function test_unauthenticated_user_cannot_view_a_help_request(): void
    {
        $helpRequest = HelpRequest::factory()->create();

        $response = $this->getJson("/api/help-requests/{$helpRequest->id}");
        $response->assertUnauthorized();
    }
}
