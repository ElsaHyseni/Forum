<div class="card">
    <div class="card-header">

    <div>
        <form action="/replies/{{ $reply->id }}/favorites" method="POST">
        @csrf
            <button style="float: right;" type="submit" class="btn btn-default" {{ $reply->isFavorited() ? 'disabled' : '' }}>
            {{ $reply->favorites_count}} {{Str::plural('Favorite', $reply->favorites_count)}}    
            </button>
        </form>
    </div>
    <div class="flex">
       <h6 >
         <a href="/profiles/{{$reply->owner->name}}" >{{ $reply->owner->name }} </a> said
          {{ $reply->created_at->diffForHumans() }}... 
       </h6> 
    </div>

    </div>
    <div class="card-body">
        {{$reply->body}}
    </div>
</div>