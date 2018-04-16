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
            ->assertStatus(201)
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
                    'message' => "We couldn't find this video on Facebook"
                ]
            ]);
    }

    /** @test */
    public function error_message_is_returned_if_no_id_could_be_found()
    {
        $this->actingAs($this->normalUser, 'api')
            ->post(route('checkURL'), ['url' => 'https://www.facebook.com/someone/videos/'])
            ->assertJson([
                'success'    => false,
                'error_data' => [
                    'message'               => "We couldn't find this video on Facebook",
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
}
