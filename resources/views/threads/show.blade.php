@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card"  style="margin-bottom: 30px;">
                <div class="card-header">
                    <div class="level">
                        <span class="flex">
                        {{ $thread->title }} by
                         <a href="/profiles/{{$thread->creator->name}}">
                        {{ $thread->creator->name }}</a> 
                        </span>

                        @can('update', $thread)
                        <form method="POST" action="{{ $thread->path() }}">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-link">Delete</button>

                        </form>
                        @endcan
                    </div>
                
               </div>

                <div class="card-body">
                    {{$thread->body}}
                </div>
            </div>

            @foreach ($replies as $reply)
                @include('threads.reply')
            @endforeach

            {{ $replies->links() }}

            @if (auth()->check())
                <form method="POST" action="{{ $thread->path() . '/replies'}}">
                    @csrf
                    <div class="form-group">
                        <textarea name="body" id="body" class="form-control" rows="6" cols="30" placeholder="Have something to say?"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Post</button>
                </form> 
            @else 
                <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in the discussion</p>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card"  style="margin-bottom: 30px;">
                <div class="card-body">
                    <p>This thread was publish {{ $thread->created_at->diffForHumans()}} by
                       <a href="#">{{ $thread->creator->name }}</a>, and currently 
                       has {{ $thread->replies()->count() }} {{ Str::plural('comment', $thread->replies()->count()) }}.
                    </p>
                </div>
            </div>
        </div>
    </div>  
</div> 
@endsection