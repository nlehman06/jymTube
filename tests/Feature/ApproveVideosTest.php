<?php

namespace Tests\Feature;

use App\User;
use App\Video;
use function auth;
use function factory;
use function route;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApproveVideosTest extends TestCase {

    use RefreshDatabase;

    private $approver;

    protected function setUp()
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        if (!$this->approver)
        {
            $this->approver = factory(User::class)->create();

            Permission::create(['name' => 'approve videos']);

            $this->approver->givePermissionTo('approve videos');

            $this->actingAs($this->approver);
        }
    }

    /** @test */
    public function user_with_permission_may_view_a_list_of_videos_awaiting_approval()
    {
        $submittedVideo = factory(Video::class)->create();
        $approvedVideo = factory(Video::class)->states('approved')->create();


        $this->get(route('approveVideos.index'))
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

    /** @test */
    public function approve_user_may_edit_video()
    {
        $submittedVideo = factory(Video::class)->create();

        $this->get(route('approveVideos.edit', $submittedVideo->id))
            ->assertSee($submittedVideo->title);
    }

    /** @test */
    public function approve_user_may_approve_video()
    {
        $submittedVideo = factory(Video::class)->create();

        $formData = [
            'selectedTags' => ['curl', 'excercises']
        ];

        $this->patch(route('approveVideos.update', $submittedVideo->id), $formData)
            ->assertSuccessful()
            ->assertJson([
                'successful' => true
            ]);

        tap($submittedVideo->fresh(), function ($video) {
            self::assertTrue($video->isApproved());
        });
    }

    /** @test */
    public function approving_a_video_requires_at_least_one_tag()
    {
        $submittedVideo = factory(Video::class)->create();

        $formData = [
            'selectedTags' => []
        ];

        $this->withExceptionHandling()
            ->patch(route('approveVideos.update', $submittedVideo->id), $formData)
            ->assertSessionHasErrors(['selectedTags']);
    }

    /** @test */
    public function approving_a_video_saves_tags()
    {
        $submittedVideo = factory(Video::class)->create();

        $formData = [
            'selectedTags' => ['curl', 'excercises']
        ];

        $this->patch(route('approveVideos.update', $submittedVideo->id), $formData)
            ->assertSuccessful();

        tap($submittedVideo->fresh(), function ($video) {
            $this->assertCount(2, $video->tags);
        });
    }
}
