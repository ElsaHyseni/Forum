@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name }} made a comment on  
        <a href="{{ $activity->subject->thread->path() }}">
            "{{ $activity->subject->thread->title }}"</a>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent

 