<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    public function test__unauthd_user_may_not_add_replies(){

        $this->withExceptionHandling()->post('/threads/some-channel/1/replies', [])
            ->assertRedirect('/login');
    }


    public function test_an_authd_user_may_participate_in_forum_threads(){

       $this->be($user = create('App\User'));

       $thread = create('App\Thread');
       $reply = make('App\Reply');
       
       $this->post( $thread->path() .'/replies', $reply->toArray());

       $this->get($thread->path())
            ->assertSee($reply->body);
   }

   public function test_a_reply_requires_a_body(){
       $this->withExceptionHandling()->signIn();

       $thread = create('App\Thread');
       $reply = make('App\Reply', ['body' => null]);
       $this->post( $thread->path() .'/replies', $reply->toArray())
            ->assertSessionHasErrors();

   }
}
