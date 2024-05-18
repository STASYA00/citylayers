@php
    $locale = session()->get('locale');
    if ($locale == null) {
        $locale = 'en';
    }
@endphp
@extends('layouts.app')

@section('main')
@vite('resources/css/dataCollection.css')

<div class="flex-wrapper" id="main-container" x-data>
    <template x-if="$store.data.step.current == 0 || $store.data.step.current == $store.data.step.length">
        <section>
            <h1 x-text=$store.data.copy_data[$store.data.step.current].question></h1>
            <p x-text=$store.data.copy_data[$store.data.step.current].description></p>
            <button class="primary-button" x-bind::disabled="!$store.data.allowedLocation"
                @click="$store.data.step.current == 0 ? $store.data.nextStep() : $store.data.submit()"
                x-text=$store.data.copy_data[$store.data.step.current].button></button>
            <template x-if="$store.data.step.current == 0">
                <label for="img-uploader">
                    <div class="img-container">
                        <input id="img-uploader" @change="$store.data.setImage(event)" type="file" accept=".jpg, .png">
                        <img id="img-preview">
                        <div class="img-text" x-show="!$store.data.place_data['place_image']">
                            <div>+</div> Add a
                            picture
                        </div>
                    </div>
                    <div class="img-text" x-cloak x-show="$store.data.place_data['place_image']">
                        <div>+</div> Retake
                        picture
                    </div>
                </label>
            </template>
            <template x-if="$store.data.step.current == $store.data.step.length">
                <textarea type="text" id="comment-uploader" name="comment" @change="$store.data.setComment(event)"
                    placeholder="Type your comment here"></textarea>
            </template>
        </section>
    </template>
    <template x-cloak x-if="$store.data.step.current > 0 && $store.data.step.current < $store.data.step.length">
        <section>
            <div class="question-container">
                <h1 class="question" x-html="$store.data.copy_data[$store.data.step.current].question"></h1>
                <input type="range" id="slider" class="range-slider" name="slider" min="0" max="100"
                    data-thumb-color="#ff0000"
                    x-bind:value="$store.data.place_data['categories'][$store.data.step.current-1].grade"
                    @change="$store.data.setGrade($store.data.step.current,event.target.value)" />
            </div>
            <div x-cloak x-show="$store.data.place_data['categories'][$store.data.step.current-1].grade">
                <h2 class="subquestion" x-html="$store.data.copy_data[$store.data.step.current].subquestion"></h2>
                <span>Select one or more tags below</span>
                <div class="tags-container">
                    <template x-for="tag in $store.data.copy_data[$store.data.step.current].tags">
                        <div class="tag selectable">
                            <input type="checkbox" :id="tag" :name="tag"
                                x-bind:checked="$store.data.place_data['categories'][$store.data.step.current-1].tags.includes(tag)"
                                @change="$store.data.setTag(event, $store.data.step.current, tag)">
                            <div class="tag-element">
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
                    <button class="next-button" :class="$store.data.place_data['categories'][$store.data.step.current-1].grade ? 'next' : 'skip'" @click="$store.data.nextStep()"
                        x-text="$store.data.place_data['categories'][$store.data.step.current-1].grade ? 'next' : 'skip'">
                        next </button>
                </div>
            </footer>
        </section>
    </template>
</div>

<script>
    <?php require_once ("js/dataCollectionCopy.js");?>

    const mainContainer = document.getElementById('main-container');

    document.addEventListener('alpine:init', () => {
        Alpine.store('data', {
            step: {
                current: 0,
                length: 7,
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

            setComment(e) {
                const comment = e.target.value;
                if (comment) {
                    this.place_data['comment'] = comment;
                }
            },

            setGrade(i, value) {
                this.place_data['categories'][i - 1].grade = value;
            },

            setTag(e, i, tag) {
                const index = this.place_data['categories'][i - 1].tags.indexOf(tag);
                if (e.target.checked) {
                    this.place_data['categories'][i - 1].tags.push(tag);
                } else if (index > -1) {
                    this.place_data['categories'][i - 1].tags.splice(index, 1);
                }
            },

            submit() {
                console.log(this.place_data);
            }
        });


        Alpine.effect(() => {
            const thumbColor = copyData[Alpine.store('data').step.current].color ? copyData[Alpine.store('data').step.current].color : '';
            mainContainer.style.setProperty('--thumb-color', thumbColor);
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