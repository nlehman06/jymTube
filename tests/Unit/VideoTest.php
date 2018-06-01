<?php

namespace Tests\Unit;

use App\Video;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VideoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_filters_videos_that_are_submitted()
    {
        factory(Video::class)->create();
        factory(Video::class)->states('approved')->create();

        $this->assertCount(1, Video::submitted()->get());
    }
}
