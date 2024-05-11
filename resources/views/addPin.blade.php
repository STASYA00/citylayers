@php
    $locale = session()->get('locale');
    if ($locale == null) {
        $locale = 'en';
    }
@endphp
@extends('layouts.app')

@section('main')
@vite('resources/css/dataCollection.css')
@vite('resources/js/dataCollection.js')

<script>
    let bunnies = true;
</script>

<div class="flex-wrapper">
    <h1 class="intro-title">What do you want to pin to the map?</h1>
    <p class="intro-text"> Begin by adding a photo of the place you want to share. Then, follow a few steps to share your thoughts about this place with others. Once completed, your contribution will be displayed on the map for everyone to see.</p>
    <button class="primary-button"> Let's get started </button>
</div>

<script>

    let allowedLocation = false;

    let place_data = {
        place_id: '',
        username: '',
        timestamp: '',
        latitude: '',
        longitude: '',
        categories: [],
        place_img: '',
        comment: '',
    };

    document.addEventListener("DOMContentLoaded", () => {

        if (navigator.geolocation) {
            getposition();
        } else {
            alert("Geolocation is not supported by this browser.");
        }

        console.log(place_data);
    })
</script>

@endsection