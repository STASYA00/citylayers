@php
    $locale = session()->get('locale');
    if ($locale == null) {
        $locale = 'en';
    }
@endphp
@extends('layouts.app')

@section('main')
@vite('resources/css/dataCollection.css')

<div class="flex-wrapper" x-data>
    <section x-show="$store.data.step.current == 0">
        <h1 class="title">What do you want to pin to the map?</h1>
        <p class="text"> Begin by adding a photo of the place you want to share. Then, follow a few steps to share
            your thoughts about this place with others. Once completed, your contribution will be displayed on the map
            for
            everyone to see.</p>
        <button class="primary-button" x-bind:disabled="!$store.data.allowedLocation" @click="$store.data.nextStep()">
            Let's
            get started </button>
        <label for="img-uploader">
            <div class="img-container">
                <input id="img-uploader" @change="$store.data.setImage(event)" type="file" class="" accept=".jpg, .png">
                <img id="img-preview">
                <div class="img-text" x-show="!$store.data.place_data['place_image']"> <span>+</span> Add a picture
                </div>
            </div>
            <div class="img-text" x-cloak x-show="$store.data.place_data['place_image']"> <span>+</span> Retake picture
            </div>
        </label>
    </section>
    <section x-cloak x-show="$store.data.step.current > 0">
        <h1 class="title">hello world</h1>
        <button class="secondary-button" @click="$store.data.prevStep()"> prev </button>
    </section>
</div>

<script>

    document.addEventListener('alpine:init', () => {
        Alpine.store('data', {
            step: {
                current: 0,
                length: 6,
            },

            allowedLocation: false,

            place_data: {
                place_id: null,
                username: null,
                timestamp: null,
                latitude: null,
                longitude: null,
                categories: [],
                place_img: null,
                comment: null,
            },

            nextStep() {
                if (this.step.current < this.step.length) this.step.current += 1;
            },

            prevStep() {
                if (this.step.current > 0) this.step.current -= 1;
            },

            setLocation(pos) {
                this.place_data['latitude'] = pos.coords.latitude;
                this.place_data['longitude'] = pos.coords.longitude;
                this.allowedLocation = true;
            },

            setImage(e) {
                const file = e.target.files[0];
                if (file) {
                    const fileReader = new FileReader();
                    fileReader.onload = event => {
                        document.getElementById('img-preview').setAttribute('src', event.target.result);
                    }
                    fileReader.readAsDataURL(file);
                    this.place_data['place_image'] = file;
                }
            },
        });

        Alpine.effect(() => {
            console.log("step: " + Alpine.store('data').step.current);
        });

        if (navigator && navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function success(pos) {
                    Alpine.store('data').setLocation(pos)
                },
                function (error) {
                    if (error.code == error.PERMISSION_DENIED) {
                        alert("you need to allow your location in order to contiue");
                    }
                }
            );
        }
    });
</script>

@endsection