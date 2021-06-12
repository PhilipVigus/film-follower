<?php

namespace Tests\Support;

class MockFeedResponse
{
    public $items = [];

    function __construct($mockFeedData)
    {
        foreach ($mockFeedData as $itemData) {
            $this->items[] = new MockFeedItemData($itemData);
        }
    }

    public function get_items()
    {
        return $this->items;
    }
}

class MockFeedItemData
{
    public $itemData;

    function __construct($itemData)
    {
        $this->itemData = $itemData;
    }

    public function get_id()
    {
        return $this->itemData['id'];
    }

    public function get_title()
    {
        return $this->itemData['title'];
    }

    public function get_link()
    {
        return $this->itemData['link'];
    }

    public function get_date()
    {
        return $this->itemData['date'];
    }

    public function get_content()
    {
        return $this->itemData['content'];
    }
}
