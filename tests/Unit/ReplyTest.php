<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Reply;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

    public function test_it_has_an_owner(){

        $reply = factory(Reply::class)->create();

        $this->assertInstanceOf('App\User', $reply->owner);
    }
}
