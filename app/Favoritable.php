<?php 

namespace App;

trait Favoritable{

    public function favorites(){
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite(){

        if(! $this->favorites()->where(['user_id' => auth()->id()])->exists()){
            return $this->favorites()->create(['user_id' => auth()->id()]);
        }
    }

    public function isFavorited(){
        if($this->favorites === NULL) return false;
        $this->favorites->where('user_id', auth()->id())->count();
    }

    public function getFavoritesCountAttribute(){
        return $this->favorites->count();
    }

}