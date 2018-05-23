<?php

namespace Tests\Feature;

use App;
use App\Http\Middleware\AdminMiddleware;
use App\User;
use function factory;
use Illuminate\Http\Request;
use function route;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAdministrationTest extends TestCase {

    use RefreshDatabase;

    private $administerRolesAndPermissions;

    private $admin;

    protected function setUp()
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        if (!$this->admin)
        {
            $this->administerRolesAndPermissions = Permission::create(['name' => 'Administer roles & permissions']);

            $this->admin = factory(User::class)->create();

            $this->admin->givePermissionTo('Administer roles & permissions');
        }
    }

    /** @test */
    public function a_standard_user_is_considered_an_admin_if_they_are_the_only_user_in_the_system()
    {
        $this->actingAs($this->admin);

        $request = Request::create('/admin', 'GET');

        $middleware = new AdminMiddleware;

        $response = $middleware->handle($request, function () {
        });

        $this->assertEquals($response, null);
    }

    /** @test */
    public function a_regular_user_with_other_users_is_not_an_admin()
    {
        $user = factory(User::class)->create();

        factory(User::class)->create();

        $this->actingAs($user);

        $request = Request::create('/admin', 'GET');

        $middleware = new AdminMiddleware;

        $response = $middleware->handle($request, function () {
        });

        $this->assertEquals($response->getStatusCode(), 302);
    }

    /** @test */
    public function admin_may_see_a_list_of_users()
    {
        $admin = factory(User::class)->create();

        $admin->givePermissionTo('Administer roles & permissions');

        $this->actingAs($admin)
            ->get(route('users.index'))
            ->assertStatus(200)
            ->assertSee('User Administration');
    }

    /** @test */
    public function user_without_privileges_may_not_see_list_of_users()
    {
        $this->withExceptionHandling();

        $this->get(route('users.index'))->assertRedirect('login');

        $user = factory(User::class)->create();
        factory(User::class, 10)->create();

        $this->actingAs($user)
            ->get(route('users.index'))
            ->assertRedirect('/');
    }

    /** @test */
    public function admin_can_edit_a_user()
    {
        $user = factory(User::class)->create();

        $this->actingAs($this->admin)
            ->get(route('users.edit', $user->id))
            ->assertStatus(200)
            ->assertSee($user->email);
    }

    /** @test */
    public function admin_can_update_a_user()
    {
        $user = factory(User::class)->create();

        $this->actingAs($this->admin)
            ->patch(route('users.update', $user->id), ['nickName' => 'joe', 'email' => 'email@test.com'])
            ->assertRedirect(route('users.index'));

        tap($user->fresh(), function ($user) {
            $this->assertEquals('joe', $user->nickName);
            $this->assertEquals('email@test.com', $user->email);
        });
    }

    /** @test */
    public function updating_a_user_requires_certain_fields()
    {
        $user = factory(User::class)->create();

        $this->actingAs($this->admin)
            ->withExceptionHandling()
            ->patch(route('users.update', $user->id), [])
            ->assertSessionHasErrors(['nickName', 'email']);
    }
}
