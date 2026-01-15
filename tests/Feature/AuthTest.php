<?php

namespace Tests\Feature;;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    // RefreshDatabase  ishlatmaganimi sababi mening kanpyuterimda sekin ishladi shuning uchun DatabaseTransactions ishlatdim
        use DatabaseTransactions;

        // test to access login page
    public function test_to_login_page_success(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Login');
        $response->assertSee('Email');
    }

    // test login with correct credentials
    public function test_user_can_login_with_correct_credentials()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);
        $response = $this->post(route('login.post'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertSessionHas('success');
        $this->assertAuthenticatedAs($user, 'web');
        $response->assertRedirect(route('leads.index'));
    }

    // test login with incorrect credentials
     public function test_user_can_login_with_incorrect_credentials()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);
        $response = $this->post(route('login.post'), [
            'email' => $user->email,
            'password' => 'passw2ord',
        ]);

         $response->assertRedirect(route('login'));

        $response->assertSessionHasErrors();

        $this->assertGuest('web');
    }

    // test logout 
    public function test_authenticated_user_can_logout()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'web');

        $response = $this->get(route('logout'));

        $response->assertRedirect(route('login'));

        $this->assertGuest('web');
    }
}
