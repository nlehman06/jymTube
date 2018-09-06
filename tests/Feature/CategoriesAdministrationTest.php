<?php

namespace Tests\Feature;

use App\User;
use Rinvex\Categories\Models\Category;
use function route;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoriesAdministrationTest extends TestCase {

    use RefreshDatabase;

    protected $admin;

    protected function setUp()
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        if (!$this->admin)
        {
            $this->admin = factory(User::class)->create();

            Permission::create(['name' => 'manage categories']);

            $this->admin->givePermissionTo('manage categories');

            $this->actingAs($this->admin);
        }
    }

    /** @test */
    public function categories_user_may_see_categories_page()
    {
        Category::create(['name' => 'Excercises']);

        $this->get(route('categories.index'))
            ->assertStatus(200)
            ->assertSee('Categories')
            ->assertSee('Excercises');

        auth()->logout();

        $this->withExceptionHandling()
            ->get(route('categories.index'))
            ->assertRedirect(route('login'));

        $this->actingAs(factory(User::class)->create())
            ->get(route('categories.index'))
            ->assertForbidden();
    }

    /** @test */
    public function user_may_add_a_root_category()
    {
        // TODO: Check for an add button on the index page
        //$this->get()

        $this->get(route('categories.create'))
            ->assertsee('Add Category');

        $data = ['name' => 'Exercises'];

        $this->post(route('categories.store'), $data)
            ->assertRedirect(route('categories.index'));

        $this->assertCount(1, Category::all());
    }
}
