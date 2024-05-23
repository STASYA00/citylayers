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
        <img class="logo" src="../images/logo_2.svg">
    </div>
    <section>
        <h1>Oups!</h1>
        <p>Unfortunately we've encountered an error, please try again.</p>
        <button class="primary-button" onclick="`${window.location.href = '/'}`">go to home page</button>
    </section>
</div>

@endsection