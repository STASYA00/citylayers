@php use \App\Http\Controllers\GlobalController; @endphp

@php  $questions = GlobalController::questions();@endphp
@php  $categories = GlobalController::categories();@endphp
@php  $subcategories = GlobalController::subcategories();@endphp
@php
    $locale = session()->get('locale');
    if ($locale == null) {
        $locale = 'en';
    }
@endphp
@extends('layouts.app')

@section('main')
@vite('resources/css/dataCollection.css')
<?php 
$lat = $_GET['lat'] ?? null; 
$lng = $_GET['lng'] ?? null; 
?> 


<div class="main-wrapper" id="main-container" x-data>
    <div class="header">
        
        <a href="/">
            <img class="logo" src="../images/logo_2.svg">
        </a>
        <button x-show="$store.data.step.current !== 0 && $store.data.step.current !== $store.data.step.length"
            class="exit-button" @click="$store.data.submit()">send and exit</button>
        <button x-cloak x-show="$store.data.step.current == $store.data.step.length" class="back-button"
            @click="$store.data.prevStep()"> back </button>
    </div>
    <template x-if="$store.data.step.current == 0">
        <section>
            <h1>What do you want to pin to the map?</h1>
            <p>Begin by adding a photo of the place you want to share. Then, follow a few steps to 
            share your thoughts about this place with others. Once completed, your contribution will be 
            displayed on the map for everyone to see.</p>
            <button class="primary-button" x-bind::disabled="!$store.data.allowedLocation"
                @click="$store.data.step.current == 0 ? $store.data.nextStep() : $store.data.submit()"
                >Let's get started!</button>
                <div>
                    <label for="img-uploader">
                        <div class="img-container">
                            <input id="img-uploader" @change="$store.data.setImage(event)" type="file"
                                accept=".jpg, .png">
                            <img id="img-preview" x-bind:src="$store.data.image_src">
                            <div class="img-text" x-show="!$store.data.place_data['img']">
                                <div>+</div> Add a picture
                            </div>
                        </div>
                        <div class="img-text" x-cloak x-show="$store.data.place_data['img']">
                            <div>+</div> Retake picture
                        </div>
                    </label>
                    <span class="skip-span" @click="$store.data.nextStep()" x-show="!$store.data.place_data['img']">or skip</span>
                </div>
        </section>
    </template>
    <template x-if="$store.data.step.current == $store.data.step.length">
        <section>
            <h1>Is there anything else about this place that you particularly liked or disliked?</h1>
            <p>🖍 Feel free to share any additional observations, opinions and reflections.</p>
            <button class="primary-button" x-bind::disabled="!$store.data.allowedLocation"
                @click="$store.data.step.current == 0 ? $store.data.nextStep() : $store.data.submit()"
                >Submit</button>
            <template x-if="$store.data.step.current == 0">
                <div>
                    <label for="img-uploader">
                        <div class="img-container">
                            <input id="img-uploader" @change="$store.data.setImage(event)" type="file"
                                accept=".jpg, .png">
                            <img id="img-preview" x-bind:src="$store.data.image_src">
                            <div class="img-text" x-show="!$store.data.place_data['img']">
                                <div>+</div> Add a picture
                            </div>
                        </div>
                        <div class="img-text" x-cloak x-show="$store.data.place_data['img']">
                            <div>+</div> Retake picture
                        </div>
                    </label>
                    <span class="skip-span" @click="$store.data.nextStep()" x-show="!$store.data.place_data['img']">or skip</span>
                </div>
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
                <h1 class="question" x-html="$store.data.copy_data.filter(c=>c.id==$store.data.step.current)[0].questions[0].question"></h1>
                <input type="range" id="slider" class="range-slider" name="slider" min="0" max="100" data-thumb-color="#ff0000"
                    x-bind:value="$store.data.place_data['categories'].filter(c=>c.id==$store.data.step.current)[0].grade"
                    @change="$store.data.setGrade($store.data.step.current,event.target.value)" />
                <div class="ranges-container">
                    <span x-html="$store.data.copy_data.filter(c=>c.id==$store.data.step.current)[0].low"></span>
                    <span x-html="$store.data.copy_data.filter(c=>c.id==$store.data.step.current)[0].high"></span>
                </div>
                <div x-cloak x-show="$store.data.place_data['categories'].filter(c=>c.id==$store.data.step.current)[0].grade">
                <h2 class="subquestion" x-html="$store.data.copy_data.filter(c=>c.id==$store.data.step.current)[0].questions[1].question"></h2>
                <span>Select one or more tags below</span>
                <div class="tags-container">
                    <template x-for="tag in $store.data.copy_data.filter(c=>c.id==$store.data.step.current)[0].tags">
                        <div class="tag selectable">
                            <input type="checkbox" :id="tag.id" :name="tag" class="tag"
                                x-bind:checked="$store.data.place_data['categories'].filter(c=>c.id==$store.data.step.current)[0].tags.includes(tag.id)"
                                @change="$store.data.setTag(event, $store.data.step.current, tag)">
                            <div class="tag-element">
                                <label :for="tag.name" x-text="tag.name" class="tag-element"></label>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            </div>
            
            <footer>
                <div class="steps"></div>
                <hr>
                <div class="nav-buttons">
                    <button class="back-button" @click="$store.data.prevStep()"> back </button>
                    <button class="next-button"
                        x-bind:class="$store.data.place_data['categories'].filter(c=>c.id==$store.data.step.current)[0].grade ? 'next' : 'skip'"
                        @click="$store.data.nextStep()"
                        x-text="$store.data.place_data['categories'].filter(c=>c.id==$store.data.step.current)[0].grade ? 'next' : 'skip'">
                        next </button>
                </div>
            </footer>
        </section>
    </template>
</div>

<script>
    

    const mainContainer = document.getElementById('main-container');
    const cats = {!! json_encode($categories) !!};
    const subcats = {!! json_encode($subcategories) !!};
    const questions = {!! json_encode($questions) !!};

    const lat = {!! json_encode($lat) !!};
    const lng = {!! json_encode($lng) !!};

    let categoryData = cats.map((cat, i)=>{
        return { id: cat["id"], 
            grade: null, tags: [] }
    });

    let pageContent = cats.map((cat, i)=>{
        return {
            id: cat["id"],
            name: cat["name"],
            description: cat["description"],
            low: cat["low"],
            high: cat["high"],
            color: cat["color"],
            tags: subcats.filter(s => s.category==cat["id"]),
            questions: questions.filter(q => q.category_id==cat["id"])
        }
    });

    document.addEventListener('alpine:init', () => {

        Alpine.store('data', {
            step: {
                current: 0,
                length: cats.length + 1,
            },

            allowedLocation: true,
            place_data: {
                id: null,
                latitude: lat,
                longitude: lng,
                categories: categoryData,
                img: null,
                comment: null,
            },

            image_src: '',

            copy_data: pageContent,

            nextStep() {
                if (this.step.current < this.step.length) {
                    this.step.current += 1;
                }
            },

            prevStep() {
                if (this.step.current > 0) {
                    this.step.current -= 1;
                }
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
                        this.image_src = event.target.result;
                        
                    }
                    fileReader.readAsDataURL(file);
                    this.place_data["image"] = file;
                    
                }
            },

            setComment(e) {
                const comment = e.target.value;
                if (comment) {
                    this.place_data['comment'] = comment;
                }
            },

            setGrade(i, value) {
                this.place_data['categories'].filter(c=>c.id==i).forEach(c=> {c.grade = value});
            },

            setTag(e, i, tag) {
                
                this.place_data['categories'].filter(c=>c.id==i).forEach(c=> 
                    {e.target.checked ? c.tags.push(tag.id) : c.tags.splice(c.tags.indexOf(tag.id)==-1 ? c.tags.length : c.tags.indexOf(tag.id), 1) }
                );
                
            },

            submit() {
                const place_data = Alpine.raw(this.place_data);
                submitData(place_data);
            }
        });


        Alpine.effect(() => {
            const step = Alpine.store('data').step.current;
            console.log("STEP", step);
            if (step<pageContent.length && step>0){
                const thumbColor = pageContent.filter(c =>c.id==step)[0].color ? `#${pageContent.filter(c =>c.id==step)[0].color}` : '';
                console.log(thumbColor);
                mainContainer.style.setProperty('--thumb-color', thumbColor);
                mainContainer.style.setProperty('--step-current', step);
                mainContainer.style.setProperty('--step-length', Alpine.store('data').step.length);

            }
            
        });

        if (lat==null && lng==null){
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

        }
        
    });

    function uuidv4() {
        return "10000000-1000-4000-8000-100000000000".replace(/[018]/g, c =>
            (+c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> +c / 4).toString(16)
        );
    }

    function sendRequest(d, url, callback) {
        return $.ajax({
            type: 'POST',
            url: `/${url}`,
            data: d,
            processData: false,
            contentType: false,
            success: function (data) {
                if (callback!=undefined){
                    callback(data);
                }
                window.location.href = '/add-pin/post-success';
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                window.location.href = '/add-pin/post-error';
            }
        });

    }

    function submitData(place_data) {

        

        place_data["id"] = uuidv4();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const d = new FormData();
        d.set("longitude", place_data["longitude"].toString());
        d.set("latitude", place_data["latitude"].toString());

        sendRequest(d, "save-place", (data)=>{place_data["id"] = data["id"]}).then(
            
            r => {
                d.set("comment", place_data["comment"].toString());
                d.set("id", place_data["id"].toString());
                
                if (place_data["comment"]!=undefined && place_data["comment"]!=null && place_data["comment"]!=""){
                    sendRequest(d, "save-comment");

                }
                
                d.set("image_name", `${uuidv4()}.${place_data["image"].name.split('.').pop()}`);
                d.set("image", place_data["image"]);
                
                sendRequest(d, "save-image");
                
                place_data["categories"].forEach((indata, i)=>{
                    
                    
                    if (indata["grade"]!=undefined){
                        let k = new FormData();
                        k.set("category_id", indata["id"].toString());
                        k.set("grade", indata["grade"].toString());
                        k.set("place_id", place_data["id"].toString());
                        sendRequest(k, "save-grade");
                    
                        indata.tags.forEach((tag)=>{
                            k.set("subcategory_id", tag.toString());
                            
                            sendRequest(k, "save-subgrade");
                        
                    }
                );
            }
                });
            
            }
        );
        

        
    }
</script>

@endsection