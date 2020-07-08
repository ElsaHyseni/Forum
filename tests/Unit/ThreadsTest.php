<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;


class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    public function setUp(): void{
        parent::Setup();
        $this->thread = factory('App\Thread')->create();
    }

    public function test_a_thread_can_make_a_string_path(){

        $thread = create('App\Thread');

        $this->assertEquals('/threads/' . $thread->channel->slug . '/' . $thread->id, $thread->path());
    }

    public function test_a_thread_has_replies(){
        
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    public function test_a_thread_has_a_creator(){

        $this->assertInstanceOf('App\User', $this->thread->creator);
    }

    public function test_a_thread_can_add_a_reply (){
        
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    public function test_a_thread_belong_to_a_channel(){
        $thread = create('App\Thread');
        $this->assertInstanceOf('App\Channel',$thread->channel);
    }

    public function test_a_user_can_view_all_threads()
    {
        $this->get('/threads')
             ->assertSee($this->thread->title);
    }

    public function test_a_user_can_read_a_single_thread(){
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    public function test_a_user_can_read_replies_associated_with_a_thread(){
        
        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);

         $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    public function test_a_user_can_filer_threads_according_to_a_channel(){
        
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');

        $this->get('/threads/' . $channel->slug)
        ->assertSee($threadInChannel->title)
        ->assertDontSee($threadNotInChannel->title);
    }

    public function test_a_user_can_filer_threads_by_any_username(){

        $this->signIn(create('App\User', ['name' => 'Elsa']));

        $threadByElsa = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByElsa = create('App\Thread');

        $this->get('threads?by=Elsa')->assertSee($threadByElsa->title)
            ->assertDontSee($threadNotByElsa->title);
    }

    //public function test_a_user_can_filter_threads_by_popularity(){
//
    //    $withTwoReplies = create('App\Thread');
    //    create('App\Reply', ['thread_id' => $withTwoReplies->id], 2);
//
    //    $withThreeReplies = create('App\Thread');
    //    create('App\Reply', ['thread_id' => $withThreeReplies->id], 3);
//
    //    $withNoReplies = $this->thread;
//
    //    $response = $this->getJson ('threads?popular=1')->json();
//
    //    $this->assertEquals([3, 2, 0], array_column($response, '$thread->replies()->count()'));
//
    //}

}