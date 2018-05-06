<?php

namespace Tests\Feature;

use App\Mail\ConfirmAccount;
use App\Notifications\UserRegisteredSuccessfully;
use App\User;
use function factory;
use Illuminate\Support\Facades\Notification;
use function in_array;
use function route;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase {

    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();

        Notification::fake();
    }

    /** @test */
    public function user_may_register_a_new_account()
    {
        $this->withoutExceptionHandling()->post(route('register'), [
            'email'                 => 'test@test.com',
            'password'              => 'password',
            'password_confirmation' => 'password'
        ]);

        $this->assertDatabaseHas('users', ['email' => 'test@test.com', 'status' => 0]);
    }

    /** @test */
    public function registering_a_new_account_redirects_you_to_the_remember_to_confirm_page()
    {
        $this->withExceptionHandling()->post(route('register'), [
            'email'                 => 'test@test.com',
            'password'              => 'password',
            'password_confirmation' => 'password'
        ])
            ->assertRedirect(route('activate.reminder'));
    }

    /** @test */
    public function registering_a_new_account_sends_an_email_with_a_confirmation_code()
    {

        $this->withExceptionHandling()->post(route('register'), [
            'email'                 => 'test@test.com',
            'password'              => 'password',
            'password_confirmation' => 'password'
        ]);

        $user = User::where('email', 'test@test.com')->first();

        $this->assertNotEmpty($user->activation_code);

        Notification::assertSentTo($user, UserRegisteredSuccessfully::class, function ($notification, $channels) use ($user) {
            return in_array('mail', $channels);
        });

    }

    /** @test */
    public function clicking_on_confirmation_link_will_activate_the_account()
    {
        $newUser = factory(User::class)->create();

        $this->get(route('activate.user', $newUser->activation_code))
            ->assertRedirect(route('activate.congrats'));

        tap($newUser->fresh(), function ($user) {
            $this->assertEquals(1, $user->status);
        });
    }

    /** @test */
    public function a_user_may_resend_the_confirmation_email_if_needed()
    {
        $newUser = factory(User::class)->create();

        $this->actingAs($newUser)
            ->get(route('register.email.resend'))
            ->assertRedirect(route('activate.reminder'));

        Notification::assertSentTo($newUser, UserRegisteredSuccessfully::class, function ($notification, $channels) {
            return in_array('mail', $channels);
        });
    }

}
