<?php

if(Auth::check()){
    Route::get('{query}', function() {
        return redirect()->route('dashboard.redirect.after-login');
    })->where('query', '.*');
}else{
    /*Route::get('{query}', function() {
        return redirect()->route('home');
    })->where('query', '.*');*/
}

