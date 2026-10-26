<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_auth_pages_render_their_distinct_figma_compositions_and_existing_fields(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('auth-page--login')
            ->assertSee('auth-login-composition')
            ->assertSee('Email :')
            ->assertSee('name="email"', false)
            ->assertSee('name="password"', false)
            ->assertSee('name="remember"', false)
            ->assertSee(route('login.store'), false);

        $this->get(route('register'))
            ->assertOk()
            ->assertSee('auth-page--register')
            ->assertSee('Satu Akun Untuk Aksi yang lebih cepat.')
            ->assertSee('Pantauan Personal')
            ->assertSee('Akses Zona Aman')
            ->assertSee('Terhubung Dengan Komunitas')
            ->assertSee('name="name"', false)
            ->assertSee('name="phone"', false)
            ->assertSee('name="email"', false)
            ->assertSee('name="address"', false)
            ->assertSee('name="password_confirmation"', false)
            ->assertSee('name="terms"', false)
            ->assertSee('Google')
            ->assertSee('disabled', false)
            ->assertSee(route('register.store'), false);
    }

    public function test_registration_creates_and_authenticates_a_user_then_login_accepts_the_same_credentials(): void
    {
        $email = 'auth-' . Str::uuid() . '@example.test';
        $password = 'SiagaNow-Test-Password-2026';

        $this->post(route('register.store'), [
            'name' => 'Pengguna Siaga',
            'phone' => '081234567890',
            'address' => 'Kota Padang, Sumatera Barat',
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
            'terms' => '1',
        ])->assertRedirect('/');

        $user = User::query()->where('email', $email)->firstOrFail();
        $this->assertAuthenticatedAs($user);
        $this->assertTrue(Hash::check($password, $user->password));

        $this->post(route('logout'))->assertRedirect('/');
        $this->post(route('login.store'), ['email' => $email, 'password' => $password])
            ->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_registration_and_login_return_validation_feedback(): void
    {
        $this->from(route('register'))->post(route('register.store'), [
            'name' => 'Pengguna Siaga',
            'phone' => '081234567890',
            'address' => 'Kota Padang',
            'email' => 'invalid-auth@example.test',
            'password' => 'password-valid-2026',
            'password_confirmation' => 'different-password-2026',
        ])->assertRedirect(route('register'))
            ->assertSessionHasErrors(['password', 'terms']);

        $this->assertDatabaseMissing('users', ['email' => 'invalid-auth@example.test']);

        $this->from(route('login'))->post(route('login.store'), [
            'email' => 'missing-auth@example.test',
            'password' => 'wrong-password',
        ])->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }
}
