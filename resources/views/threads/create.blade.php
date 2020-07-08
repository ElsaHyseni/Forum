@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create a New Thread</div>

                <div class="card-body">
                    <form action="/threads" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="channel_id">Choose a Channel:</label>
                            <select name="channel_id" id="channel_id" class="form-control" required>
                                <option value="">Choose one...</option>
                                @foreach (App\Channel::all() as $channel)
                                <option value="{{ $channel->id }}" 
                                    {{ old('channel_id') == $channel->id ? 'selected' : '' }} >{{ $channel->name }}</option>
                                @endforeach
                            </select>
                            @error('channel_id')
                            <p style="color: red;">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" id="title" class="form-control" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <p style="color: red;">{{ $message }}</p>
                            @enderror
                        </div>
                        

                        <div class="form-group">
                            <label for="body">Body:</label>
                            <textarea name="body" id="body" class="form-control" cols="30" rows="10" required>{{ old('body') }}</textarea>
                            @error('body')
                                <p style="color: red;">{{ $message }}</p>
                            @enderror
                        </div>

                        

                        <div style="margin-bottom: 5px;">
                            <button type="submit" class="btn btn-primary">Publish</button>
                        </div>

                        
                    </form>

                   

                </div>
            </div>
        </div>
    </div>
</div>
@endsection