<?php

use Illuminate\Support\Facades\Route;

Route::get('/waarmeking', function () {
    // Kita buat view sederhana untuk membungkus komponen livewire
    return view('layouts.app_waarmeking'); 
});