@php
    $locale = session()->get('locale');
    if ($locale == null) {
        $locale = 'en';
    }
@endphp
@extends('layouts.app')

@section('main')

<div class="main-wrapper" id="main-container">
    <div class="header">
        <a href="/">
            <img class="logo" src="../images/logo_2.svg">
        </a>
    </div>
    <section>
        <h1>Thanks for your contribution!</h1>
        <p>📍Check out your tag on the map or rate another place!</p>
        <button class="primary-button" onclick="`${window.location.href = '/'}`">go to home page</button>
    </section>
</div>

@endsection