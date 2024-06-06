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
        <h1>Oops!</h1>
        <p>We couldn't register your observation, please try again.</p>
        <button class="primary-button" onclick="`${window.location.href = '/'}`">back to home</button>
    </section>
</div>

@endsection