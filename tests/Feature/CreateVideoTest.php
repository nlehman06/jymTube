<?php

namespace Tests\Feature;

use function factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateVideoTest extends TestCase {

    use RefreshDatabase;

    private $normalUser;

    protected function setUp()
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        if (!$this->normalUser)
        {
            $this->normalUser = factory('App\User')->create();
        }
    }

    /** @test */
    public function an_authorized_user_can_see_the_create_video_form()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user)
            ->get(route('addVideo'))
            ->assertStatus(200)
            ->assertSee('Add Video');
    }

    /** @test */
    public function an_unauthorized_user_may_not_see_the_create_form()
    {
        $this->withExceptionHandling();
        $this->get(route('addVideo'))->assertStatus(302)->assertRedirect('/login');
    }

    /** @test */
    public function user_may_check_a_faceboook_url()
    {
        $url = 'https://www.facebook.com/JimStoppaniPhD/videos/10156310534098024/';

        $this->actingAs($this->normalUser, 'api')
            ->post(route('checkURL'), ['url' => $url])
            ->assertJson([
                'success'  => true,
                'url_data' => [
                    'provider'    => 'facebook',
                    'provider_id' => '10156310534098024',
                    'title'       => "Supplement Round-Up BCAA's"
                ]
            ]);
    }

    /** @test */
    public function error_message_is_returned_if_facebook_url_not_found()
    {
        $this->actingAs($this->normalUser, 'api')
            ->withExceptionHandling()
            ->post(route('checkURL'), ['url' => 'https://facebook.com/someone/videos/1234/'])
            ->assertJson([
                'success'    => false,
                'error_data' => [
                    'message' => "We couldn't find the video from Facebook"
                ]
            ]);
    }

    /** @test */
    public function error_message_is_returned_if_no_facebook_id_could_be_found()
    {
        $this->actingAs($this->normalUser, 'api')
            ->post(route('checkURL'), ['url' => 'https://www.facebook.com/someone/videos/'])
            ->assertJson([
                'success'    => false,
                'error_data' => [
                    'message'               => "We couldn't find the video from Facebook",
                    'message_from_provider' => '',
                    'other_info'            => 'No id found'
                ]
            ]);
    }

    /** @test */
    public function error_message_is_returned_if_no_url_is_provided()
    {
        $this->actingAs($this->normalUser, 'api')
            ->withExceptionHandling()
            ->post(route('checkURL'), ['url' => ''])
            ->assertStatus(302)
            ->assertSessionHasErrors('url');
    }

    /** @test */
    public function user_may_check_a_youtube_url()
    {
        $url = 'https://youtu.be/2P4VozzF9tw';

        $this->actingAs($this->normalUser)
            ->post(route('checkURL'), ['url' => $url])
            ->assertJson([
                'success'  => true,
                'url_data' => [
                    'provider'    => 'youtube',
                    'provider_id' => '2P4VozzF9tw',
                    'title'       => 'IF tip for those who don’t train at same time every day'
                ]
            ]);
    }

    /** @test */
    public function error_message_is_returned_if_no_youtube_id_could_be_found()
    {
        $this->actingAs($this->normalUser, 'api')
            ->post(route('checkURL'), ['url' => 'https://youtu.be/2P4'])
            ->assertJson([
                'success'    => false,
                'error_data' => [
                    'message'               => "We couldn't find the video from YouTube",
                    'message_from_provider' => '',
                    'other_info'            => "Can't find this video using ID: 2P4"
                ]
            ]);
    }

    /** @test */
    public function error_message_is_returned_if_video_is_already_in_the_database()
    {
        $video1 = factory('App\Video')->create([
            'provider'      => 'youtube',
            'provider_id'   => '2P4VozzF9tw',
            'permalink_url' => 'https://youtu.be/2P4VozzF9tw'
        ]);

        $this->actingAs($this->normalUser)
            ->withExceptionHandling()
            ->post(route('checkURL'), ['url' => $video1->permalink_url])
            ->assertJsonFragment(['success' => false])
            ->assertJsonFragment(['other_info' => 'This video has already been submitted.']);
    }

    /** @test */
    public function a_user_may_submit_a_found_video_for_review()
    {
        $video = factory('App\Video')->make();

        $this->actingAs($this->normalUser)
            ->post(route('storeVideoForReview'), $video->toArray())
            ->assertStatus(201);

        $this->assertDatabaseHas('videos', [
            'provider_id'          => $video->provider_id,
            'submitted_by_user_id' => $this->normalUser->id,
            'status'               => 'submitted'
        ]);
    }

    /** @test */
    public function submitting_a_video_requires_all_url_data_fields()
    {
        $this->actingAs($this->normalUser)
            ->withExceptionHandling()
            ->postJson(route('storeVideoForReview'), [])
            ->assertJsonValidationErrors([
                'provider_id',
                'provider',
                'title',
                'description',
                'permalink_url',
                'length',
                'picture',
                'created_time',
                'from_id',
                'from_name',
                'from_profile'
            ]);
    }
}
