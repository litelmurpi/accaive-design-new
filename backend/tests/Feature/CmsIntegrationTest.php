<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Project;
use App\Models\ContactSubmission;
use App\Models\User;

class CmsIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test API endpoint for Projects returns correctly formatted JSON.
     */
    public function test_api_projects_endpoint_returns_json()
    {
        // Arrange
        Project::create([
            'title' => 'Test Project',
            'slug' => 'test-project',
            'description' => 'A test description',
            'client' => 'Test Client',
            'year' => '2024',
            'hero_image' => 'test.jpg',
            'category' => 'Test',
            'is_featured' => true,
        ]);

        // Act
        $response = $this->getJson('/api/projects');

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'slug',
                        'description',
                        'client'
                    ]
                ]
            ]);

        $this->assertCount(1, $response->json('data'));
        $this->assertEquals('Test Project', $response->json('data.0.title'));
    }

    public function test_api_services_endpoint_returns_json()
    {
        \App\Models\Service::create(['title' => 'Architecture', 'description' => 'Architecture service']);
        $response = $this->getJson('/api/services');
        $response->assertStatus(200);
        $this->assertCount(1, $response->json('data'));
    }

    public function test_api_team_endpoint_returns_json()
    {
        \App\Models\TeamMember::create(['name' => 'Jane Doe', 'role' => 'Architect']);
        $response = $this->getJson('/api/team');
        $response->assertStatus(200);
        $this->assertEquals('Jane Doe', $response->json('data.0.name'));
    }

    public function test_api_exhibitions_endpoint_returns_json()
    {
        \App\Models\Exhibition::create(['title' => 'Venice Biennale']);
        $response = $this->getJson('/api/exhibitions');
        $response->assertStatus(200);
        $this->assertEquals('Venice Biennale', $response->json('data.0.title'));
    }

    public function test_api_press_endpoint_returns_json()
    {
        \App\Models\PressArticle::create(['title' => 'Featured in ArchDaily']);
        $response = $this->getJson('/api/press');
        $response->assertStatus(200);
    }

    public function test_api_careers_endpoint_returns_json()
    {
        \App\Models\JobOpening::create(['title' => 'Senior Architect', 'is_active' => true]);
        $response = $this->getJson('/api/careers');
        $response->assertStatus(200);
    }

    public function test_api_programs_endpoint_returns_json()
    {
        \App\Models\Program::create(['title' => 'Mentorship', 'features' => json_encode(['Feature A'])]);
        $response = $this->getJson('/api/programs');
        $response->assertStatus(200);
    }

    public function test_api_featured_stories_endpoint_returns_json()
    {
        \App\Models\FeaturedStory::create(['title' => 'Best Design 2024']);
        $response = $this->getJson('/api/featured-stories');
        $response->assertStatus(200);
    }

    public function test_api_settings_endpoint_returns_json()
    {
        \App\Models\SiteSetting::create(['key' => 'contact_email', 'value' => 'hello@accaive.com']);
        $response = $this->getJson('/api/settings');
        $response->assertStatus(200);
        $this->assertEquals('hello@accaive.com', $response->json('data.contact_email'));
    }

    /**
     * Test Contact Form submission from Website goes to CMS Mailbox.
     */
    public function test_contact_form_submission_creates_record_in_cms()
    {
        // Arrange
        $payload = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'company' => 'Doe Corp',
            'budget' => '$10k - $50k',
            'message' => 'I want to build a new office.',
        ];

        // Act
        $response = $this->postJson('/api/contact', $payload);

        // Assert
        $response->assertStatus(201)
            ->assertJsonFragment([
                'message' => 'Contact submission successful'
            ]);

        // Verify it was stored in the database for the CMS to read
        $this->assertDatabaseHas('contact_submissions', [
            'email' => 'john@example.com'
        ]);
        $this->assertEquals(1, ContactSubmission::count());
    }

    /**
     * Test CMS Admin login route is protected and accessible.
     */
    public function test_cms_admin_panel_is_protected()
    {
        // Unauthenticated access should redirect to login
        $response = $this->get('/admin');
        $response->assertRedirect('/admin/login');

        // Authenticated access should work
        $user = User::factory()->create();
        $responseAuth = $this->actingAs($user)->get('/admin');
        $responseAuth->assertStatus(200);
    }
}
