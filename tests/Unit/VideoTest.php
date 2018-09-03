<?php

namespace Tests\Unit;

use App\Tag;
use App\Video;
use function factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideoTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function it_filters_videos_that_are_submitted()
    {
        factory(Video::class)->create();
        factory(Video::class)->states('approved')->create();

        $this->assertCount(1, Video::submitted()->get());
    }

    /** @test */
    public function it_knows_if_it_is_approved()
    {
        $video = factory(Video::class)->states(['approved'])->create();

        $this->assertTrue($video->isApproved());
    }

    /** @test */
    public function it_can_have_tags()
    {
        $video = factory(Video::class)->create();

        factory(Tag::class, 2)->create();

        $video->tags()->sync([1, 2]);

        $this->assertCount(2, $video->tags);
    }
}
