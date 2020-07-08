@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" style="align-content: center;">
            <div class="col-md-8" style="margin: auto;">
                <div class="page-header">
                <h1 style="margin-top: 30px; margin-bottom:30px;">
                    {{ $profileUser->name}}
                    <!-- <small>Joined {{ $profileUser->created_at->diffForHumans() }}</small> -->
                    <hr>
                </h1>
                </div>

            @foreach ($activities as $date =>$activity)
            <h5 class="page-header">{{ $date }}</h5>
                @foreach($activity as $record)
                    @include ("profiles.activities.{$record->type}" , ['activity' => $record])
                @endforeach    
            @endforeach           
            </div>
        </div>
    </div>
    
@endsection