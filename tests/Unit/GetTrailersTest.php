<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Film;
use App\Models\User;
use App\Models\Trailer;
use App\Jobs\GetTrailers;
use Tests\Support\MockFeedResponse;
use Vedmant\FeedReader\Facades\FeedReader;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetTrailersTest extends TestCase
{
    use RefreshDatabase;

    private $mockFeedData = [
        [
            'id' => 'itemId1',
            'title' => 'Movie Title 1: type 1',
            'link' => 'itemLink1',
            'date' => 'Tue, 11 May 2021 15:34:53 -0700',
            'content' => '<img src="image1.jpg" /><br />
            Filed Under: <a href="http://www.movie1guid.com">Movie Title 1</a><br />
            Tags: <a href="http://www.tag1">Tag 1</a>, <a href="http://www.tag2">Tag 2</a>',
        ],
        [
            'id' => 'itemId2',
            'title' => 'Movie Title 2: type 1',
            'link' => 'itemLink2',
            'date' => 'Tue, 11 May 2021 15:34:53 -0700',
            'content' => '<img src="image2.jpg" /><br />
            Filed Under: <a href="http://www.movie2guid.com">Movie Title 2</a><br />
            Tags: <a href="http://www.tag1">Tag 1</a>, <a href="http://www.tag2">Tag 2</a>',
        ],
        [
            'id' => 'itemId3',
            'title' => 'Movie Title 2: type 2',
            'link' => 'itemLink3',
            'date' => 'Tue, 11 May 2021 15:34:53 -0700',
            'content' => '<img src="image2.jpg" /><br />
            Filed Under: <a href="http://www.movie2guid.com">Movie Title 2</a><br />
            Tags: <a href="http://www.tag4">Tag 4</a>, <a href="http://www.tag2">Tag 2</a>',
        ],
    ];

    /** @test */
    public function it_creates_trailers_from_the_feeds_data()
    {
        $mockFeedResponse = new MockFeedResponse($this->mockFeedData);

        FeedReader::shouldReceive('read')->andReturn($mockFeedResponse);

        GetTrailers::dispatch();

        $trailers = Trailer::all();

        $this->assertCount(3, $trailers);
        $this->assertEquals('itemId1', $trailers->getNth(0)->guid);
        $this->assertEquals('itemId2', $trailers->getNth(1)->guid);
        $this->assertEquals('itemId3', $trailers->getNth(2)->guid);
    }

    /** @test */
    public function it_creates_movies_from_the_feeds_data_and_links_them_to_the_correct_trailers()
    {
        $mockFeedResponse = new MockFeedResponse($this->mockFeedData);

        FeedReader::shouldReceive('read')->andReturn($mockFeedResponse);

        GetTrailers::dispatch();

        $trailers = Trailer::all();
        $films = Film::all();

        $this->assertCount(3, $trailers);
        $this->assertCount(2, $films);
        $this->assertEquals($trailers->getNth(0)->film->id, $films->getNth(0)->id);
        $this->assertEquals($trailers->getNth(1)->film->id, $films->getNth(1)->id);
        $this->assertEquals($trailers->getNth(2)->film->id, $films->getNth(1)->id);
    }

    /** @test */
    public function it_doesnt_create_duplicate_trailers()
    {
        $mockFeedResponse = new MockFeedResponse($this->mockFeedData);

        FeedReader::shouldReceive('read')->andReturn($mockFeedResponse);

        GetTrailers::dispatch();
        GetTrailers::dispatch();

        $trailers = Trailer::all();

        $this->assertCount(3, $trailers);
        $this->assertEquals('itemId1', $trailers->getNth(0)->guid);
        $this->assertEquals('itemId2', $trailers->getNth(1)->guid);
        $this->assertEquals('itemId3', $trailers->getNth(2)->guid);
    }

    /** @test */
    public function it_adds_new_films_to_each_registered_user()
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $mockFeedResponse = new MockFeedResponse($this->mockFeedData);

        FeedReader::shouldReceive('read')->andReturn($mockFeedResponse);

        GetTrailers::dispatch();

        $this->assertCount(2, $userA->films);
    }
}
