<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lead;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LeadTest extends TestCase
{
     use DatabaseTransactions;

    // Lead index test
        public function test_getting_user_leads_success(): void
    {
        $user = $this->authUser();

        $this->createLead($user);

        $response = $this->get(route('leads.index'));

        $response->assertOk();
        $response->assertViewHas('leads');
        $response->assertViewIs('leads.index');
    }

    // Lead create view test
    public function test_to_create_lead_page_success(): void
    {
        $user = $this->authUser();

        $response = $this->get(route('leads.create'));

        $response->assertOk();
        $response->assertSee('Create Lead');
        $response->assertViewIs('leads.create');

    }

    // Lead store test
    public function test_storing_lead_success(): void
    {
        $user = $this->authUser();
        $leadData = $this->leadData();

        $response = $this->post(route('leads.store'), $leadData);
        
        $response->assertSessionHas('success');
        $response->assertRedirect(route('leads.show', Lead::firstWhere('full_name', 'From Test Lead')));

        // check db
        $this->assertDatabaseHas('leads',$this->leadData() + ['user_id' => $user->id]);
    }


    // Lead show test
    public function test_showing_lead_success(): void
    {
        $user = $this->authUser();
        $lead = $this->createLead($user);
        
        $response = $this->get(route('leads.show', $lead));

        $response->assertOk();
        $response->assertViewIs('leads.show');
        $response->assertViewHas('lead', function ($viewLead) use ($lead) {
            return $viewLead->id === $lead->id;
        });
    }

    // Lead edit view test
    public function test_to_edit_lead_page_success(): void
    {
        $user = $this->authUser();
        $lead = $this->createLead($user);
        $response = $this->get(route('leads.edit', $lead));
        $response->assertOk();
        $response->assertSee(__('pageText.edit'));
        $response->assertViewIs('leads.edit');
    }

    // Lead update test
    public function test_updating_lead_success(): void
    {
        $user = $this->authUser();
        $lead = $this->createLead($user);
        $leadData = $this->leadData();
        $response = $this->put(route('leads.update', $lead), $leadData);
        $response->assertSessionHas('success');
        $response->assertRedirect(route('leads.show', $lead));

        // check db
        $this->assertDatabaseHas('leads',$this->leadData() + ['user_id' => $user->id]);
    }

    // Lead delete test
    public function test_deleting_lead_success(): void
    {
        $user = $this->authUser();
        $lead = $this->createLead($user);
        $response = $this->delete(route('leads.destroy', $lead));
        $response->assertSessionHas('success');
        $response->assertRedirect(route('leads.index'));
        // check db
        $this->assertSoftDeleted('leads', ['id' => $lead->id]);
    }

    // helper auth
    protected function authUser(): User
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'web');
        return $user;
    }

    // helper create lead
    protected function createLead(User $user): Lead
    {
        return Lead::factory()->create(['user_id' => $user->id]);
    }
    // helper lead data
    protected function leadData(): array
    {
        return [
            'full_name' => 'From Test Lead',
            'phone' => '1234567890',
            'status' => 'new',
            'note' => 'This is a test lead.',
        ];
    }
}