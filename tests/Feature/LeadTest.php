<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lead;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LeadTest extends TestCase
{
     use DatabaseTransactions;

    
        public function test_index_displays_user_leads(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'web');

        Lead::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->get(route('leads.index'));

        $response->assertOk();
        $response->assertViewIs('leads.index');
        $response->assertViewHas('leads');
    }
}