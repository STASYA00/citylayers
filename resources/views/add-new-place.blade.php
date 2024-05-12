@php
    $locale = session()->get('locale');
    if ($locale == null) {
        $locale = 'en';
    }
@endphp
@extends('layouts.app')

@section('main')
<div class="p-6 lg:p-12">
    <a href="/" class="">
        <img src="{{ asset('img/icons/arrow.png') }}" class="arrow">

    </a>

    <div class="parentDiv relative pt-20" x-cloak x-data="{ tab: '{{ $type }}', showMore: false }" :class="tab == 'place' ? 'placeTab' : 'observationTab'">

        <div class="flex items-center justify-center">
            <div class="-mr-1 cursor-pointer" x-show="tab=='place'">
                <div class="flex flex-col w-[84px] justify-center items-center">
                    <div class="bg-[#2d9bf0] border-2 border-white rounded-full" :class="tab == 'place' ?
        'bg-[#2d9bf0] z-10 p-[26px] placeTabActive' :
        'bg-[#2d9bf0]/70 p-[40px]'">
                        <img src="{{ asset('new_img/image.png') }}" class="w-7 h-7" :class="tab == 'place' ? 'block' : 'hidden'" id="place" alt="">
                    </div>

                </div>
            </div>
            <div class="-ml-1 cursor-pointer" x-show="tab=='observation'">
                <div class="flex flex-col w-[75px] justify-center items-center">

                    <div class="flex items-center justify-center border-2 border-white rounded-full"
                        :class="tab == 'observation' || tab == 'observation1' ?
        'bg-[#ffa726] z-10 p-[20px] observationTabActive' :
        'bg-[#ffa726]/70 p-[40px]'">
                        <div class="flex items-center justify-center w-10 h-10 text-2xl" :class="tab == 'observation' || tab == 'observation1' ? 'block' :
        'hidden'" id="observation" alt="">🔍</div>
                    </div>

                </div>
            </div>
        </div>



        <div class="placeSubTab flex flex-col items-center justify-center" x-data="{
                placeSubtab: 'add',
                
                searchQueryPlace:'',
                placeTitle: 'Want to pin a place that has not been mapped before? Add a layer by giving it a name. Provide more details by adding a description, and uploading a photo.',
                placeInput: 'Enter a new place',
                active: '',
                placeModel: 'parent'
            }" x-show="tab=='place'" :class="placeSubtab == 'choose' ? 'choose' : 'add'">
            <button class="hidden openPlaceModel"
                @click="tab='place';placeSubtab='choose';placeTitle='Choose tags or add a new place';placeInput='Browse place tags'"></button>
            <button class="hidden OpenSubPlaceModel" @click="tab='place';placeModel='child'"></button>


            <div class="PlaceItems w-full" x-show="placeModel=='parent'" :class="placeModel == 'parent' ? 'parent' : 'child'">
                <div class="flex flex-col items-center justify-center w-full mt-12 mb-12">
                    <input type="text" :placeholder="placeInput" id="searchQueryPlace" x-model="searchQueryPlace"
                        name="place_name" class="w-full px-4 py-2 bg-white rounded-full">
                    <span id="err" class="text-center text-red-500"></span>
                    <div class="mt-2 italic font-normal text-center" x-text="placeTitle"></div>

                </div>

                <div class="grid grid-cols-4 italic font-semibold gap-10" x-show="placeSubtab=='choose'">
                    <div class="flex flex-col items-center cursor-pointer">
                        <button
                            @click="placeSubtab='add';placeTitle='Want to pin a place that has not been mapped before? Add a layer by giving it a name. Provide more details by adding a description, and uploading a photo.';placeInput='Enter a new place'">
                            <div class="rounded-full border-site border-4 p-[22px] bg-site">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                                    stroke="#ffff" class="w-6 h-6 font-bold color-site">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                </svg>
                            </div>
                            <div class="mt-4 text-black font-bold">Add new</div>
                        </button>
                    </div>



                    @foreach ($allPlaces as $key => $place)
                        <div x-show="(showMore || {{ $key }} < 2) && (searchQueryPlace === '' || '{{ strtolower($place->name) }}'.includes(searchQueryPlace.toLowerCase()))"
                            class="flex flex-col items-center cursor-pointer" @click="active='PL_{{ $place->id }}'">
                            <div data-place="{{ json_encode(['id' => $place->id, 'name' => $place->name, 'child' => $place->subplaces]) }}"
                                class="w-[76px] h-[76px] rounded-full bg-[#2d9bf0]" :class="active == 'PL_{{ $place->id }}' ? 'border-4 border-[#12CDD4] placeActive' : ''">
                                <div class="flex align-item-center justify-center items-center h-full">
                                    <img src="{{ asset('new_img/image.png') }}" class="w-7 h-7" />
                                </div>
                            </div>
                            <span class="mt-4 text-black font-normal">{{ $place->name }}</span>
                        </div>
                    @endforeach
                    <div x-show="!showMore" class="cursor-pointer">
                        <button @click="showMore = true; height = '100vh'">
                            <div class="rounded-full border-site border-4 p-[22px]">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                                    stroke="currentColor" class="w-6 h-6 font-bold color-site">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                </svg>
                            </div>
                            <div class="mt-4 text-black font-normal">See more</div>
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-12 mb-12 text-center" x-data="{ subactive: '' }" x-show="placeModel=='child'">
                <div class="placeparent mb-10 font-semibold text-xl"></div>
                <div class="grid grid-cols-3 italic font-semibold text-xl gap-10 subPlaceItems">

                </div>
            </div>

            <div x-show="placeSubtab=='choose'" class="px-5 mt-2 text-center">

                Tap "submit" to pin this place to the map and share it with other users.
                Provide more details through rating, adding a description, and uploading a photo.


            </div>

            <div class="flex items-center justify-between w-2/3 pt-28 pb-16 font-semibold">
                <label class="flex flex-col items-center gap-1 cursor-pointer" for="image-upload">
                    <input id="image-upload" type="file" class="hidden place_image" accept=".jpg, .png">
                    <img src="{{ asset('img/cam-2.PNG') }}" alt="" class="w-10 h-9">
                    <div class="text-sm">Upload image</div>
                </label>

                <div class="relative" x-data="{ placeText: false }">
                    <div @click="placeText = !placeText" class="flex flex-col items-center gap-1 cursor-pointer">
                        <img src="{{ asset('img/msg.PNG') }}" alt="" class="w-10 h-9">
                        <div class="text-sm">Add description</div>
                    </div>
                    <textarea
                        class="font-normal place_description absolute px-2 py-2 bg-white rounded-xl w-[300px] right-0"
                        x-show="placeText"></textarea>
                </div>

            </div>

        </div>

        <div class="observationSubTab flex flex-col items-center justify-center" x-data="{
                observationSubtab: 'add',
                searchQueryObservation: '',
                observationTitle: 'Want to pin an observation that has not been mapped before? Add a layer by giving it a name. Provide more details through rating, adding a description, and uploading a photo.',
                observationInput: 'Enter a new observation',
                active: '',
                observationModel: 'parent'
            }" x-show="tab=='observation'" :class="observationSubtab == 'choose' ? 'choose' : 'add'">

            <button class="hidden OpenObservationModel"
                @click="tab='observation';observationSubtab='choose';observationTitle='Choose tags or add a new observation';observationInput='Browse observation'"></button>
            <button class="hidden OpenSubObservationModel" @click="tab='observation';observationModel='child'"></button>


            <div class="ObservationItems w-full" x-show="observationModel=='parent'" :class="observationModel == 'parent' ? 'parent' : 'child'">
                <div class="flex flex-col items-center justify-center mt-12 mb-12 w-full">
                    <input type="text" name="observation_name" :placeholder="observationInput"
                        x-model="searchQueryObservation" id="searchQueryObservation"
                        class="w-full px-4 py-2 bg-white rounded-full">
                    <div class="mt-2 italic font-normal text-center" x-text="observationTitle"></div>
                </div>
                <div class="flex items-start justify-center gap-10 mt-6 mb-6 italic font-semibold">
                    <div class="grid grid-cols-4 italic font-semibold gap-10" x-show="observationSubtab=='choose'">
                        <div class="flex flex-col items-center cursor-pointer">
                            <button
                                @click="observationSubtab='add';observationTitle='Want to pin an observation that has not been mapped before? Add a layer by giving it a name. Provide more details through rating, adding a description, and uploading a photo.';observationInput='Enter a new observation'">
                                <div class="rounded-full border-site border-4 p-[22px] bg-site">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="3" stroke="#ffff" class="w-6 h-6 font-bold color-site">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                    </svg>
                                </div>
                                <div class="mt-4 text-black font-bold">Add new</div>
                            </button>
                        </div>
                        @foreach ($allObservations as $key => $observation)
                                        <div x-data="{ active: false }"
                                            x-show="(showMore || {{ $key }} < 2) && (searchQueryObservation === '' || '{{ strtolower($observation->name) }}'.includes(searchQueryObservation.toLowerCase()))"
                                            class="flex flex-col items-center cursor-pointer"
                                            @click="active = !active ? 'OB_{{ $observation->id }}' : false">
                                            <div data-observations="{{ json_encode(['id' => $observation->id, 'name' => $observation->name, 'child' => $observation->subobservs]) }}"
                                                class="w-[76px] h-[76px] rounded-full bg-[#ffa726]" :class="active == 'OB_{{ $observation->id }}' ?
                            'border-4 border-[#12CDD4] observationActive' : ''">
                                                <div class="flex align-item-center justify-center items-center h-full">
                                                    <img src="{{ asset('new_img/sad.png') }}" alt="" class="w-8 h-8 -mr-1">
                                                    <img src="{{ asset('new_img/happy.png') }}" alt="" class="w-8 h-8 -ml-1">
                                                </div>
                                            </div>
                                            <span class="mt-4 text-black font-normal">{{ $observation->name }}</span>
                                        </div>
                        @endforeach

                        <div x-show="!showMore" class="flex flex-col items-center justify-center cursor-pointer">
                            <button @click="showMore = true; height = '100vh'" type="button">
                                <div class="rounded-full border-[#ffa726] border-4  p-[22px]">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="3" stroke="currentColor" class="w-6 h-6 font-bold text-[#ffa726]">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                    </svg>
                                </div>
                                <div class="mt-4 text-black font-normal">See more</div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-12 mb-12 text-center" x-show="observationModel=='child'">
                <div class="grid grid-cols italic font-semibold text-xl gap-10 subObservationItems">

                </div>
            </div>



            <div x-show="observationSubtab=='add'" x-data="{ feelActive: 'feel__1' }"
                class="flex flex-wrap items-center justify-center gap-2 italic font-semibold w-full ">
                @foreach ($feelings as $feeling)
                    <div data-feeling_id="{{ $feeling->id }}" @click="feelActive='feel_{{ $feeling->id }}'"
                        class="cursor-pointer rounded-full" :class="feelActive == 'feel_{{ $feeling->id }}' ? 'border-4 border-[#12CDD4] feelingActive' : ''">
                        <img class="w-12 h-12 sm:w-16 sm:h-16" src="{{ asset($feeling->image) }}" alt="">
                    </div>
                @endforeach

            </div>


            <div x-show="observationSubtab=='choose'" class="px-5 mt-2 text-center">

                Tap "submit" to pin this observation to the map and share it with other users.
                Provide more details through rating, adding a description, and uploading a photo.


            </div>
            <div class="flex items-center justify-between w-2/3 pt-28 pb-16 font-semibold">
                <label for="obser-image-upload" class="flex flex-col items-center gap-1 cursor-pointer">
                    <input id="obser-image-upload" type="file" class="hidden observation_image" accept=".jpg, .png">
                    <img src="{{ asset('img/cam.PNG') }}" alt="" class="w-10 h-9">
                    <div class="text-sm">Upload image</div>
                </label>



                <div class="relative" x-data="{ observationText: false }">
                    <div @click="observationText = !observationText"
                        class="flex flex-col items-center gap-1 cursor-pointer">
                        <img src="{{ asset('img/msg-2.PNG') }}" alt="" class="w-10 h-9">
                        <div class="text-sm">Add description</div>
                    </div>
                    <textarea
                        class="font-normal observation_description absolute px-2 py-2 bg-white rounded-xl w-[300px] right-0"
                        x-show="observationText"></textarea>
                </div>

            </div>


        </div>


        <div class="fixed left-0 right-0 bg-white py-4 bottom-0 z-[100]">
            <div class="flex items-center justify-center gap-6">
                <a href="/"
                    class="flex cursor-pointer items-center justify-center border-2 border-site gap-2 px-8 py-3 text-lg font-extrabold color-site bg-white rounded-3xl transition-all">
                    Close
                </a>

                <div
                    class="submitDataAll flex cursor-pointer items-center border-2 border-site justify-center gap-2 px-8 py-3 text-lg font-extrabold text-white bg-[#2d9bf0] rounded-3xl  hover:bg-[#268ede] transition-all">
                    Submit
                </div>
            </div>
        </div>
    </div>

</div>

<script>

    $(document).ready(function () {
        setTimeout(() => {
            $('#searchQueryPlace').val(' ');
            var inputEvent = new Event('input', { bubbles: true });
            $('#searchQueryPlace')[0].dispatchEvent(inputEvent);

            $('#searchQueryObservation').val(' ');
            var inputEvent = new Event('input', { bubbles: true });
            $('#searchQueryObservation')[0].dispatchEvent(inputEvent);
        }, 1);
    });

    let place_data = {
        place_name: '',
        place_id: '',
        child_place_id: '',
        observation_name: '',
        feeling_id: '',
        observations: '',
        place_description: '',
        observation_description: '',
        latitude: '',
        longitude: '',
        tab: '{{ $type }}',
    };
    var fileInput_place = '';
    var fileInput_observation = '';

    if (navigator.geolocation) {
        getposition();
    } else {
        alert("Geolocation is not supported by this browser.");
    }

    function getposition(success, fail) {
        if (navigator && navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function (pos) {
                    place_data['latitude'] = pos.coords.latitude;
                    place_data['longitude'] = pos.coords.longitude;
                }
            );
        }
    }



    $('body').on('click', '.submitDataAll', function () {

        var parentDiv = $(this).closest('.parentDiv');






        if (parentDiv.hasClass('placeTab')) {
            tab = 'place';
            place_data['tab'] = tab;

            fileInput_place = $(".place_image")[0].files[0];
            place_data['place_description'] = parentDiv.find('.place_description').val();


            if (parentDiv.find('.' + tab + 'SubTab').hasClass('add')) {
                // add new place
                var name = parentDiv.find('input[name="place_name"]').val();
                if (name == '') {
                    parentDiv.find('input[name="place_name"]').addClass('border-red-500');
                    return false;
                }
                place_data['place_name'] = name;
            } else if (parentDiv.find('.' + tab + 'SubTab').hasClass('choose') && parentDiv.find('.PlaceItems')
                .hasClass('parent')) {

                var place_detail = parentDiv.find('.placeActive').data('place');


                if (typeof place_detail === 'undefined') {
                    return false;
                }
                place_data['place_id'] = place_detail.id;
                if (place_detail.child.length > 0) {
                    $('.placeparent').text(place_detail.name);
                    var allHtml = '';
                    place_detail.child.forEach(place => {
                        allHtml += `
                            <div class="flex flex-col items-center cursor-pointer" @click="subactive='SPL_${place.id}'">
                                                <div data-subplaceid="${place.id}" class="w-[76px] h-[76px] rounded-full bg-[#2d9bf0]"
                                                :class="subactive == 'SPL_${place.id}' ? 'border-4 border-[#12CDD4] subplaceActive' : ''">
                                                    <div class="flex align-item-center justify-center items-center h-full">
                                                        <img src="{{ asset('new_img/image.png') }}" class="w-7 h-7" />
                                                    </div>
                                                </div>
                                                <span class="mt-4 text-black font-normal text-base">${place.name}</span>
                                            </div>
                            `;
                    });
                    $('.subPlaceItems').html(allHtml);
                    $('.OpenSubPlaceModel').click();
                    return false;
                } else {
                    submitDetailData(place_data);
                }

            } else if (parentDiv.find('.' + tab + 'SubTab').hasClass('choose') && parentDiv.find('.PlaceItems')
                .hasClass('child')) {


                var subplace_id = parentDiv.find('.subplaceActive').data('subplaceid');
                place_data['child_place_id'] = subplace_id ? subplace_id : '';
            }
        }

        if (parentDiv.hasClass('observationTab')) {
            tab = 'observation';
            place_data['tab'] = tab;
            fileInput_observation = $(".observation_image")[0].files[0];
            place_data['observation_description'] = parentDiv.find('.observation_description').val();

            if (parentDiv.find('.' + tab + 'SubTab').hasClass('add')) {
                // add new observation
                var name = parentDiv.find('input[name="observation_name"]').val();
                var feeling = parentDiv.find('.feelingActive').data('feeling_id');

                if (name === '' || typeof feeling === 'undefined') {
                    parentDiv.find('input[name="observation_name"]').addClass('border-red-500');
                    return false;
                }
                place_data['observation_name'] = name;
                place_data['feeling_id'] = feeling;
            } else if (parentDiv.find('.' + tab + 'SubTab').hasClass('choose') && parentDiv.find(
                '.ObservationItems').hasClass('parent')) {
                // choose observation
                var observations_detail = [];
                parentDiv.find('.observationActive').each(function () {
                    var data = $(this).data('observations');
                    observations_detail.push(data);
                });
                var allHtml = '';
                if (observations_detail.length == 0) {
                    return false;
                }
                observations_detail.forEach(function (observation) {

                    allHtml +=
                        `<div data-observation_id="${observation.id}"><div class="mb-4">${observation.name}</div>`;

                    var feelingHtml = `
                                <div x-data="{ feelActive${observation.id}: 'feel_${observation.id}_1' }" class="flex flex-wrap items-center justify-center gap-2 italic font-semibold w-full ">
                                    @foreach ($feelings as $feeling)
                                        <div data-feeling_id="{{ $feeling->id }}"
                                            @click="feelActive${observation.id}='feel_${observation.id}_{{ $feeling->id }}'"
                                            class="cursor-pointer rounded-full"
                                            :class="feelActive${observation.id} == 'feel_${observation.id}_{{ $feeling->id }}' ? 'border-4 border-[#12CDD4] feelingActive' : ''"
                                            >
                                            <img class="w-12 h-12 sm:w-16 sm:h-16" src="{{ asset($feeling->image) }}" alt="">
                                        </div>
                                    @endforeach
                                </div>
                    `;

                    if (observation.child.length === 0) {
                        allHtml += `
                            <div data-subobservation_id="" class="flex items-center justify-between mb-10">
                            ${feelingHtml}
                            </div>
                        `;
                    } else {
                        observation.child.forEach(observ => {
                            allHtml += `
                            <div data-subobservation_id="${observ.id}" class="flex gap-2 lg:gap-20 items-center justify-between mb-10">
                                <div class="flex flex-col items-center w-[160px]">
                                    <div class="w-[76px] h-[76px] rounded-full bg-[#ffa726]">
                                        <div class="flex align-item-center justify-center items-center h-full">
                                            <img src="{{ asset('new_img/sad.png') }}" alt=""
                                                            class="w-8 h-8 -mr-1"> <img
                                                            src="{{ asset('new_img/happy.png') }}" alt=""
                                                            class="w-8 h-8 -ml-1">
                                        </div>
                                    </div>
                                    <span class="mt-1 text-black font-normal text-base">${observ.name}</span>
                                </div>

                                ${feelingHtml}
                            </div>`;
                        });
                    }

                    allHtml += `</div>`;
                });

                $('.subObservationItems').html(allHtml);
                $('.OpenSubObservationModel').click();
                return false;
            } else if (parentDiv.find('.' + tab + 'SubTab').hasClass('choose') && parentDiv.find(
                '.ObservationItems').hasClass('child')) {

                var dataList = [];
                parentDiv.find('.feelingActive').each(function () {
                    var observationId = $(this).closest('[data-observation_id]').data('observation_id');
                    var subobservationId = $(this).closest('[data-subobservation_id]').data(
                        'subobservation_id');
                    var feelingId = $(this).data('feeling_id');

                    dataList.push({
                        observation_id: observationId,
                        child_observation_id: subobservationId,
                        feeling_id: feelingId
                    });
                });
                place_data['observations'] = dataList;
            }
        }
        // console.log(place_data);
        submitDetailData(place_data);
    });

    var totalswal = 0;

    function submitDetailData(place_data) {

        place_data['update'] = place_data.tab;

        @if ($edit_id)
            place_data['place_detail_id'] = {{ $edit_id }};
        @endif

        const formData = new FormData();
        if (fileInput_place) {
            formData.append('place_image', fileInput_place);
        }
        if (fileInput_observation) {
            formData.append('observation_image', fileInput_observation);
        }

        formData.append('place_data', JSON.stringify(place_data));

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $.ajax({
            type: 'POST',
            url: "/map/add/place",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.status == 'success') {
                    place_data['place_name'] = '';
                    place_data['observation_name'] = '';
                    place_data['place_id'] = data.place_id;

                    var reverse_tab = data.tab == 'place' ? 'observation' : 'place';
                    if (data.status == 'success') {

                        if (totalswal >= 1) {
                            window.location.href = '/';
                        } else {
                            totalswal = totalswal + 1;
                            place_data['place_detail_id'] = data.place_detail_id;
                            place_data['update'] = reverse_tab;

                            @if(!$only)
                                swal({
                                    title: "Success!",
                                    text: data.tab.charAt(0).toUpperCase() + data.tab.slice(1) + " " +
                                        data
                                            .msg + " Do you want to add " + reverse_tab + " tag?",
                                    icon: "success",
                                    buttons: ["Close", "Continue"],
                                }).then((userConfirmed) => {
                                    if (userConfirmed) {
                                        if (reverse_tab == 'place') {
                                            $('.openPlaceModel').click();
                                        } else {
                                            $('.OpenObservationModel').click();
                                        }
                                    } else {
                                        window.location.href = '/';
                                        // $('.closeAddProcess').click();
                                    }
                                });
                            @else
                                window.location.href = '/';
                            @endif



                        }


                    }
                } else {
                    swal({
                        title: "Failed!",
                        text: data.msg,
                        icon: "error"
                    });
                }


            },

        });

    }
</script>
@endsection