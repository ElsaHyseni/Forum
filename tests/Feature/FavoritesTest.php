<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    public function test_guests_cannot_favorite_anything(){
        
        $this->withExceptionHandling()
            ->post('replies/1/favorites')->assertRedirect('/login');

    }
    public function test_an_authd_user_can_favorite_any_reply(){
        
        $this->signIn();
        $reply = create('App\Reply');

        $this->post('replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }

    public function test_an_authd_user_may_only_favorite_a_reply_once(){
        
        $this->signIn();
        $reply = create('App\Reply');

        try{
            $this->post('replies/' . $reply->id . '/favorites');
            $this->post('replies/' . $reply->id . '/favorites');
        }catch (\Exception $e){
            $this->fail('Inserted more than once');
        }
        $this->assertCount(1, $reply->favorites);
    }
}
