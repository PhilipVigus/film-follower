<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Support\RssFeedReader;
use Tests\Support\MockFeedResponse;
use Vedmant\FeedReader\Facades\FeedReader;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RssFeedReaderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_parses_the_data_correctly()
    {
        $mockFeedData = [
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
        ];

        $expectedFirstItem = [
            'trailer' => [
                'guid' => 'itemId1',
                'title' => 'Movie Title 1: type 1',
                'slug' => 'movie-title-1-type-1',
                'type' => 'type 1',
                'image' => 'image1.jpg',
                'link' => 'itemLink1',
                'uploaded_at' => Carbon::parse('Tue, 11 May 2021 15:34:53 -0700'),
            ],
            'film' => [
                'guid' => 'http://www.movie1guid.com',
                'title' => 'Movie Title 1',
                'slug' => 'movie-title-1',
            ],
            'tags' => [
                ['name' => 'Tag 1', 'slug' => 'tag-1'],
                ['name' => 'Tag 2', 'slug' => 'tag-2'],
            ],
        ];

        $mockFeedResponse = new MockFeedResponse($mockFeedData);
        FeedReader::shouldReceive('read')->andReturn($mockFeedResponse);

        $feedItems = RssFeedReader::getLatestItems();

        $this->assertCount(2, $feedItems);
        $this->assertEquals($expectedFirstItem, $feedItems[0]);
    }
}
