<?php

namespace Tests\Feature;

use App\User;
use App\Video;
use function auth;
use function factory;
use function route;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApproveVideosTest extends TestCase {

    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    /** @test */
    public function user_with_permission_may_view_a_list_of_videos_awaiting_approval()
    {
        $submittedVideo = factory(Video::class)->create();
        $approvedVideo = factory(Video::class)->states('approved')->create();

        $approver = factory(User::class)->create();

        Permission::create(['name' => 'approve videos']);

        $approver->givePermissionTo('approve videos');

        $this->actingAs($approver)
            ->get(route('approveVideos.index'))
            ->assertStatus(200)
            ->assertSee($submittedVideo->title)
            ->assertDontSee($approvedVideo->title);

        auth()->logout();

        $this->withExceptionHandling()
            ->get(route('approveVideos.index'))
            ->assertRedirect(route('login'));

        $this->actingAs(factory(User::class)->create())
            ->get(route('approveVideos.index'))
            ->assertForbidden();

    }
}
