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
        <h1 x-text=$store.data.copy_data[$store.data.step.current].question></h1>
        <p x-text=$store.data.copy_data[$store.data.step.current].text></p>
        <button class="primary-button" x-bind::disabled="!$store.data.allowedLocation" @click="$store.data.nextStep()">
            Let's get started </button>
        <label for="img-uploader">
            <div class="img-container">
                <input id="img-uploader" @change="$store.data.setImage(event)" type="file" accept=".jpg, .png">
                <img id="img-preview">
                <div class="img-text" x-show="!$store.data.place_data['place_image']"> <span>+</span> Add a picture
                </div>
            </div>
            <div class="img-text" x-cloak x-show="$store.data.place_data['place_image']"> <span>+</span> Retake picture
            </div>
        </label>
    </section>
    <section x-cloak x-show="$store.data.step.current > 0">
        <h1 class="question" x-html="$store.data.copy_data[$store.data.step.current].question"></h1>
        <input type="range" id="slider" name="slider" min="0" max="1" step="0.1"
            x-bind:value="$store.data.place_data['categories'][$store.data.step.current-1] && $store.data.place_data['categories'][$store.data.step.current-1].grade"
            @change="$store.data.setGrade($store.data.step.current,event.target.value)" />
        <div x-cloak x-show="$store.data.place_data['categories'][$store.data.step.current-1] && $store.data.place_data['categories'][$store.data.step.current-1].grade">
            <h2 class="subquestion" x-html="$store.data.copy_data[$store.data.step.current].subquestion"></h2>
            <p class="description">Select one or more tags below</p>
            <div class="tags-container">
                <template x-for="tag in $store.data.copy_data[$store.data.step.current].tags">
                    <div class="tag selectable">
                        <input type="checkbox" :id="tag" :name="tag"
                            x-bind:checked="$store.data.place_data['categories'][$store.data.step.current-1] && $store.data.place_data['categories'][$store.data.step.current-1].tags.includes(tag)"
                            @change="$store.data.setTag(event, $store.data.step.current, tag)">
                        <div>
                            <label :for="tag" x-text="tag"></label>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        <footer>
            <div class="steps" x-text="'step: ' + $store.data.step.current "></div>
            <div class="nav-buttons">
                <button class="back-button" @click="$store.data.prevStep()"> back </button>
                <button class="next-button" @click="$store.data.nextStep()"> next </button>
            </div>
        </footer>
    </section>
</div>

<script>
    <?php require_once ("js/dataCollectionCopy.js");?>

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
                categories: [{ grade: null, tags: [] }, { grade: null, tags: [] }, { grade: null, tags: [] }, { grade: null, tags: [] }, { grade: null, tags: [] }, { grade: null, tags: [] }],
                place_img: null,
                comment: null,
            },

            copy_data: copyData,

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

            setGrade(i, value) {
                console.log(i, value);
                this.place_data['categories'][i - 1].grade = value;
                console.log(this.place_data);
            },

            setTag(e, i, tag) {
                console.log(i, tag, e.target.checked);
                const index = this.place_data['categories'][i - 1].tags.indexOf(tag);
                console.log(index);
                if (e.target.checked) {
                    this.place_data['categories'][i - 1].tags.push(tag);
                } else if (index > -1) {
                    this.place_data['categories'][i - 1].tags.splice(index, 1);
                }
            }
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