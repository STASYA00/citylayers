@php use \App\Http\Controllers\GlobalController; @endphp
@php  $categories = GlobalController::categories();@endphp
@php
    $locale = session()->get('locale');
    if ($locale == null) {
        $locale = 'en';
    }
@endphp

@extends('layouts.app')
@vite('resources/css/container.css')
@vite('resources/css/map.css')
@vite('resources/js/map.js')
@vite('resources/js/citymap.js')


@section('main')
@vite('resources/js/map.js')
@vite('resources/js/citymap.js')
@vite('resources/css/container.css')
@vite('resources/css/map.css')

    <!-- <div data-barba="container">
        <div class="flex flex-col mx-auto">
            <div class="">
                <div class="relative">


                    @if (backpack_auth()->user()->id)
                        <div class="fixed right-0 z-20 flex items-center justify-center p-4 rounded-full cursor-pointer top-4"
                            id="openPopup_profile">
                            <img class="object-cover border-2 rounded-full border-site h-14 w-14"
                                src="/storage/uploads/avatar/{{ backpack_auth()->user()->avatar }}" alt="">
                        </div>
                    @endif

                    <div onclick="mylocation()"
                        class="fixed z-20 flex items-center justify-center p-4 bg-transparent rounded-full cursor-pointer h-14 w-20 bottom-[6.8rem] left-4">
                        <img src="{{ asset('img/location.png') }}" class="w-20 h-12" alt="">
                    </div>
                    <a href="/filter"
                        class="fixed z-20 flex items-center justify-center p-1 text-xl bg-white border-2 border-black rounded-full h-14 w-14 bottom-28 right-4">
                        <div class=""> <img src="{{ asset('img/eye.png') }}" class="w-8 h-6" alt=""></div>
                    </a>

                    <div class="flex justify-center items-center">
                        <span class="fixed z-[30] top-10 mr-20 text-center">
                            Explore the map to view the activities of other users.
                            @php
                             echo $categories[0]->name;
                          @endphp
                        </span>
                    </div>


                    <div id="map" class="absolute w-[100vw] z-10 h-[90vh]"></div>
                </div>

                <div x-data="{ modelOpen: false, showMore: false, hidetab: 'no', tab: 'place', searchQuery: '' }">
                    <div
                        class="fixed bottom-0 z-50 w-full pt-3 pb-8 text-xl font-semibold text-center shadow-xl rounded-t-3xl bg-gray-50 ">

                        <div class="flex items-center justify-center">
                            <div class="py-0.5 w-14 mb-3 rounded-full px-4 bg-black">

                            </div>

                        </div>


                        <div class="flex">
                            <div class="absolute left-16 bottom-[18px] ">
                                <div class="pl-4 py-3 pr-2.5 bg-[#ffa726] border-2 border-white rounded-full h-14 w-14">
                                    <span class="w-10 h-14"><img src="{{ asset('img/search.png') }}" class="w-9 h-7"
                                            alt=""></span>
                                </div>

                            </div>
                            <div class="absolute left-6 bottom-[18px] ">
                                <div class="p-3 border-2 border-white rounded-full bg-site h-14 w-14">
                                    <img src="{{ asset('new_img/image.png') }}" class="w-7 h-7" alt="">
                                </div>

                            </div>
                        </div>

                        <div class="w-full pt-4 addToMap" @click="tab ='place'; modelOpen =true; searchQuery=''">
                            <span
                                class="border-2 border-site w-full px-12 py-4 text-white bg-[#2d9bf0] rounded-3xl cursor-pointer">
                                Pin to Map
                            </span>

                        </div>


                        <div class="absolute right-5 bottom-[25px] ">
                            <div class="p-1 rounded-full bg-site w-9">
                                <span class="italic font-bold text-white">
                                    i
                                </span>
                            </div>
                        </div>

                    </div>


                    <div class="parentDiv" x-data="{ height: 'auto' }">f
                        <button class="hidden OpenObservationModel"
                            @click="modelOpen=true; showMore = true; hidetab = 'place'; tab='observation'; height = '100vh';"></button>
                        <button class="hidden openPlaceModel"
                            @click="modelOpen=true; showMore = true; hidetab = 'observation'; tab='place'; height = '100vh';"></button>

                        <div x-cloak x-show="modelOpen " class="fixed bottom-0 z-50 overflow-y-auto"
                            aria-labelledby="modal-title" role="dialog" aria-modal="true">
                            <div class="flex items-end justify-center text-center">
                                <div x-cloak @click="modelOpen = false; hidetab = 'no'" x-show="modelOpen"
                                    class="fixed inset-0 transition-opacity bg-gray-500 closeAddProcess bg-opacity-40"
                                    aria-hidden="true">
                                </div>

                                <div x-cloak x-show="modelOpen"
                                    x-transition:enter="transition ease-out duration-300 transform"
                                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" {{-- x-transition:leave="transition ease-in duration-200 transform" --}}
                                    class="transition-height z-50 w-screen pb-16 transition-all transform bg-white h-[50%] shadow-xl mt-60 rounded-t-3xl"
                                    :style="'height: ' + height" :class="{ 'overflow-auto': showMore }">

                                    <div class="p-6 lg:p-12">

                                        @if ($edit_id)
                                            <a href="/" class="block mb-4 closeAddProcess" class="mb-4">
                                                <img src="{{ asset('img/icons/arrow.png') }}" class="arrow">
                                            </a>
                                        @else
                                            <div class="mb-4 closeAddProcess"
                                                @click="modelOpen=false; showMore = false; hidetab = 'no'; height = 'auto';"
                                                x-show="showMore" class="mb-4">
                                                <img src="{{ asset('img/icons/arrow.png') }}" class="arrow">
                                            </div>
                                        @endif





                                        <div class="flex items-center gap-4 justity-between">
                                            <input type="text" class="w-full px-2 py-2 bg-white rounded-full"
                                                placeholder="Choose tags or add new city layers" name="searchInput"
                                                x-model="searchQuery" @keyup="showMore = true; height = '100vh'">

                                            <a :href="tab === 'place' ?
                                                '/add-new/place{{ $edit_id ? '/' . urlencode($edit_id) : '' }}' :
                                                '/add-new/observation{{ $edit_id ? '/' . urlencode($edit_id) : '' }}'"
                                                class="p-2 transition-all border-2 rounded-full tabNewLink"
                                                :class="tab == 'place' ? 'bg-[#2d9bf0] border-[#2d9bf0]' :
                                                    'bg-[#ffa726] border-[#ffa726]'">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 6v12m6-6H6" />
                                                </svg>
                                            </a>

                                        </div>

                                        <div class="mt-2">
                                            Drop a pin to share observations, opinions and ideas.
                                        </div>





                                        <div class="flex items-center justify-center mt-12 homeTabs">
                                            <div class="-mr-1 cursor-pointer" x-show="hidetab!='place'"
                                                @click="tab='place'">
                                                <div class="flex flex-col w-[84px] justify-center items-center">
                                                    <div class="bg-[#2d9bf0] border-2 border-white rounded-full "
                                                        :class="tab == 'place' || tab == 'place1' ?
                                                            'bg-[#2d9bf0] z-10 p-[26px] placeTabActive' :
                                                            'bg-[#2d9bf0]/70 p-[40px]'">
                                                        <img src="{{ asset('new_img/image.png') }}" class="w-7 h-7"
                                                            :class="tab == 'place' || tab == 'place1' ? 'block' : 'hidden'"
                                                            id="place" alt="">
                                                    </div>
                                                    <div class="text-sm font-semibold text-center"
                                                        :class="tab == 'place' ? 'text-black' : 'text-black/50'">
                                                        Browse Places
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="-ml-1 cursor-pointer" x-show="hidetab!='observation'"
                                                @click="tab='observation'">
                                                <div class="flex flex-col w-[75px] justify-center items-center">

                                                    <div class="flex items-center justify-center border-2 border-white rounded-full "
                                                        :class="tab == 'observation' || tab == 'observation1' ?
                                                            'bg-[#ffa726] z-10 p-[20px] observationTabActive' :
                                                            'bg-[#ffa726]/70 p-[40px]'">
                                                        <div class="flex items-center justify-center w-10 h-10 text-2xl"
                                                            :class="tab == 'observation' || tab == 'observation1' ? 'block' :
                                                                'hidden'"
                                                            id="observation" alt="">🔍</div>
                                                    </div>

                                                    <div class="text-sm font-semibold text-center "
                                                        :class="tab == 'observation' ? 'text-black' : 'text-black/50'">
                                                        Browse Observations
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div x-data="{ active: '{{ isset($edited_place->placeDetail->place_id) ? 'PL_' . $edited_place->placeDetail->place_id : '' }}' }">

                                            <div class="flex items-start justify-center gap-10 mt-6 mb-6 italic font-semibold all-places"
                                                x-show="tab=='place'">

                                                <div class="grid grid-cols-3 gap-10 italic font-semibold"
                                                    id="searchResults2Pls">


                                                    @foreach ($allPlaces as $key => $place)
                                                        <div x-show="(showMore || {{ $key }} < 2) && (searchQuery === '' || '{{ strtolower($place->name) }}'.includes(searchQuery.toLowerCase()))"
                                                            class="flex flex-col items-center cursor-pointer"
                                                            @click="active='PL_{{ $place->id }}'">
                                                            <div data-place="{{ json_encode(['id' => $place->id, 'name' => $place->name, 'child' => $place->subplaces]) }}"
                                                                class="w-[76px] h-[76px] rounded-full bg-[#2d9bf0]"
                                                                :class="active == 'PL_{{ $place->id }}' ?
                                                                    'border-4 border-[#12CDD4] placeActive' : ''">
                                                                <div
                                                                    class="flex items-center justify-center h-full align-item-center">
                                                                    <img src="{{ asset('new_img/image.png') }}"
                                                                        class="w-7 h-7" />
                                                                </div>
                                                            </div>
                                                            <span
                                                                class="mt-4 font-normal text-black">{{ $place->name }}</span>
                                                        </div>
                                                    @endforeach

                                                    <div x-show="!showMore" class="cursor-pointer">
                                                        <button @click="showMore = true; height = '100vh'">
                                                            <div class="rounded-full border-site border-4 p-[22px]">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="3"
                                                                    stroke="currentColor"
                                                                    class="w-6 h-6 font-bold color-site">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M12 6v12m6-6H6" />
                                                                </svg>
                                                            </div>
                                                            <div class="mt-4 font-normal text-black">See more</div>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="" x-data="{ active: '' }">
                                            <div class="flex items-center justify-center gap-10 mt-6 mb-6 italic font-semibold"
                                                x-show="tab=='observation'">
                                                <div class="grid grid-cols-3 gap-10 italic font-semibold"
                                                    id="searchResults2Obs">

                                                    @foreach ($allObservations as $key => $observation)
                                                        <div x-data="{ active: '{{ $edited_place && $edited_place->observationsDetail->contains('observation_id', $observation->id) ? 'OB_' . $observation->id : '' }}' }"
                                                            x-show="(showMore || {{ $key }} < 2) && (searchQuery === '' || '{{ strtolower($observation->name) }}'.includes(searchQuery.toLowerCase()))"
                                                            class="flex flex-col items-center cursor-pointer"
                                                            @click="active = !active ? 'OB_{{ $observation->id }}' : false">

                                                            <div data-observations="{{ json_encode(['id' => $observation->id, 'name' => $observation->name, 'child' => $observation->subobservs]) }}"
                                                                class="w-[76px] h-[76px] rounded-full bg-[#ffa726]"
                                                                :class="active == 'OB_{{ $observation->id }}' ?
                                                                    'border-4 border-[#12CDD4] observationActive' : ''">
                                                                <div
                                                                    class="flex items-center justify-center h-full align-item-center">
                                                                    <img src="{{ asset('new_img/sad.png') }}"
                                                                        alt="" class="w-8 h-8 -mr-1">
                                                                    <img src="{{ asset('new_img/happy.png') }}"
                                                                        alt="" class="w-8 h-8 -ml-1">
                                                                </div>
                                                            </div>
                                                            <span
                                                                class="mt-4 font-normal text-black">{{ $observation->name }}</span>
                                                        </div>
                                                    @endforeach



                                                    <div x-show="!showMore"
                                                        class="flex flex-col items-center justify-center cursor-pointer">
                                                        <button @click="showMore = true; height = '100vh'" type="button">
                                                            <div class="rounded-full border-[#ffa726] border-4  p-[22px]">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="3"
                                                                    stroke="currentColor"
                                                                    class="w-6 h-6 font-bold text-[#ffa726]">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M12 6v12m6-6H6" />
                                                                </svg>

                                                            </div>
                                                            <div class="mt-4 font-normal text-black">See more</div>
                                                        </button>

                                                    </div>

                                                </div>



                                            </div>
                                        </div>


                                    </div>

                                </div>
                            </div>
                        </div>
                        <div x-cloak x-show="modelOpen" class="fixed bottom-0 z-50 w-full py-4 bg-white">
                            <div class="flex items-center justify-center">
                                <div
                                    class="submitData border-2 border-site flex cursor-pointer items-center justify-center gap-2 px-8 py-3 text-lg font-extrabold text-white bg-[#2d9bf0] rounded-3xl hover:shadow  hover:bg-[#268ede] transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="3" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Add new
                                </div>
                            </div>
                        </div>
                    </div>








                </div>


                <div class="parentDiv" x-data="{ subModelOpen: false, subtab: '' }" x-cloak x-show="subModelOpen">

                    <button class="hidden subModeltrigerPlace" @click="subModelOpen=true;subtab='place'"></button>

                    <button class="hidden subModeltrigerObservation"
                        @click="subModelOpen=true;subtab='observation'"></button>


                    <div x-data="{ subactive: '{{ isset($edited_place->placeDetail->place_child_id) ? 'SPL_' . $edited_place->placeDetail->place_child_id : '' }}' }"
                        class="fixed h-screen overflow-auto bottom-0 bg-white z-[60] w-full pb-8 text-xl font-semibold text-center shadow-xl">

                        <div class="p-6 lg:p-12">

                            <div @click="subModelOpen=false;subactive='';subtab=''"
                                class="mb-4 OpenObservationModel openPlaceModel">
                                <img src="{{ asset('img/icons/arrow.png') }}" class="arrow">
                            </div>


                            <div class="flex items-center justify-center mt-12 homeTabs">
                                <div class="-mr-1 cursor-pointer" x-show="subtab=='place'">
                                    <div class="flex flex-col w-[84px] justify-center items-center">
                                        <div class="bg-[#2d9bf0] border-2 border-white rounded-full"
                                            :class="subtab == 'place' ?
                                                'bg-[#2d9bf0] z-10 p-[26px] subplaceTabActive' :
                                                'bg-[#2d9bf0]/70 p-[40px]'">
                                            <img src="{{ asset('new_img/image.png') }}" class="w-7 h-7"
                                                :class="subtab == 'place' ? 'block' : 'hidden'" alt="">
                                        </div>

                                    </div>
                                </div>
                                <div class="-ml-1 cursor-pointer" x-show="subtab=='observation'">
                                    <div class="flex flex-col w-[75px] justify-center items-center">

                                        <div class="flex items-center justify-center border-2 border-white rounded-full"
                                            :class="subtab == 'observation' ?
                                                'bg-[#ffa726] z-10 p-[20px] subobservationTabActive' :
                                                'bg-[#ffa726]/70 p-[40px]'">
                                            <div class="flex items-center justify-center w-10 h-10 text-2xl"
                                                :class="subtab == 'observation' ? 'block' :
                                                    'hidden'">
                                                <div class="flex items-center justify-center h-full align-item-center">
                                                    <img src="{{ asset('new_img/sad.png') }}" alt=""
                                                        class="w-8 h-8 -mr-1"> <img
                                                        src="{{ asset('new_img/happy.png') }}" alt=""
                                                        class="w-8 h-8 -ml-1">
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>

                            <div>
                                <div x-show="subtab=='place'" class="flex flex-col items-center justify-center mt-12">
                                    <div class="mb-10 placeparent"></div>

                                    <div class="grid grid-cols-3 gap-10 italic font-semibold subPlacesItems">

                                    </div>
                                    <div class="mt-4 text-center font-normal">
                                        Tap "submit" to pin this place to the map and share it with other users.
                                        Provide more details by adding a description, and uploading a photo.

                                    </div>
                                    <div class="flex items-center justify-between w-2/3 pb-12 pb-16 pt-28">
                                        <label class="flex flex-col items-center gap-1 cursor-pointer" for="image-upload">
                                            <input id="image-upload" type="file" class="hidden place_image"
                                                accept=".jpg, .png">
                                            <img src="{{ asset('img/cam-2.PNG') }}" alt="" class="w-10 h-9">
                                            <div class="text-sm">Upload image</div>
                                        </label>

                                        <div class="relative" x-data="{ placeText: false }">
                                            <div @click="placeText = !placeText"
                                                class="flex flex-col items-center gap-1 cursor-pointer">
                                                <img src="{{ asset('img/msg.PNG') }}" alt="" class="w-10 h-9">
                                                <div class="text-sm">Add description</div>
                                            </div>
                                            <textarea class="font-normal place_description absolute px-2 py-2 bg-white rounded-xl w-[300px] right-0"
                                                x-show="placeText">{{ $edited_place && $edited_place->place_description ? $edited_place->place_description : '' }}</textarea>
                                        </div>

                                    </div>
                                </div>

                                <div x-show="subtab=='observation'" class="flex flex-col items-center justify-center">
                                    <div class="grid gap-10 mt-12 italic font-semibold grid-cols subObservationItems">




                                    </div>



                                    <div class="mt-4 text-center font-normal">
                                        Tap "submit" to pin this observation to the map and share it with other users.
                                        Provide more details through rating, adding a description, and uploading a photo.

                                    </div>


                                    <div class="flex items-center justify-between w-2/3 pt-20 pb-16 mb-12">
                                        <label for="obser-image-upload"
                                            class="flex flex-col items-center gap-1 cursor-pointer">
                                            <input id="obser-image-upload" type="file"
                                                class="hidden observation_image" accept=".jpg, .png">
                                            <img src="{{ asset('img/cam.PNG') }}" alt="" class="w-10 h-9">
                                            <div class="text-sm">Upload image</div>
                                        </label>



                                        <div class="relative" x-data="{ observationText: false }">
                                            <div @click="observationText = !observationText"
                                                class="flex flex-col items-center gap-1 cursor-pointer">
                                                <img src="{{ asset('img/msg-2.PNG') }}" alt="" class="w-10 h-9">
                                                <div class="text-sm">Add description</div>
                                            </div>
                                            <textarea class="font-normal observation_description absolute px-2 py-2 bg-white rounded-xl w-[300px] right-0"
                                                x-show="observationText">{{ $edited_place && $edited_place->obsevation_description ? $edited_place->obsevation_description : '' }}</textarea>
                                        </div>

                                    </div>

                                </div>
                            </div>


                        </div>

                    </div>


                    <div class="fixed w-full bottom-0 z-[60] bg-white py-4">
                        <div class="flex items-center justify-center gap-6">
                            <div @click="subModelOpen=false;"
                                class="flex items-center justify-center gap-2 px-8 py-3 text-lg font-extrabold transition-all bg-white border-2 cursor-pointer border-site color-site rounded-3xl">
                                Close
                            </div>

                            <div
                                class="submitDataAll flex cursor-pointer items-center border-2 border-site justify-center gap-2 px-8 py-3 text-lg font-extrabold text-white bg-[#2d9bf0] rounded-3xl  hover:bg-[#268ede] transition-all">
                                Submit
                            </div>

                        </div>
                    </div>


                </div>


            </div>
        </div>
    </div>


    <div id="popup_profile"
        class="p-6 lg:p-12 w-full h-screen lg:w-4/12 fixed bg-white shadow-md ml-[-2px] overflow-y-auto right-0 hidden z-50 transform translate-x-full transition-transform duration-300">
        <a onclick="close_pop_profile()">
            <img src="{{ asset('img/icons/arrow.png') }}" class="arrow">

        </a>
        <div class="p-4">

            <div class="top">
                <div class="topo">

                    <label for="image" class="cursor-pointer new">
                        <img class="object-cover w-24 h-24 border-blue-500 rounded-full border-7 nimage mimage"
                            src="/storage/uploads/avatar/{{ backpack_auth()->user()->avatar }}" alt="">

                    </label>
                </div>
                <div class="tops">
                    <div class="toptaxt">Hello "{{ backpack_auth()->user()->name }}"!</div>
                    <a href="/profile" class="vieprofile">View Profile</a>
                </div>


            </div>
            <br />
            <br />
            <div class="list">
                <a href="/" class="lbox">
                    <div
                        class="flex justify-center items-center w-7 h-7 border-[3px] font-bold text-base border-black rounded-full text-center">
                        +</div>
                    <div class="ltax">Add to map</div>
                </a>
                <a href="/dashboard" class="lbox">
                    <div
                        class="flex justify-center items-center w-7 h-7 border-[3px] font-bold text-base border-black rounded-full text-center">
                        ▄</div>
                    <div class="ltax">Dashboard</div>
                </a>
                <a href="/community-achievements" class="lbox">
                    <div
                        class="flex justify-center items-center w-7 h-7 border-[3px] font-bold text-base border-black rounded-full text-center">
                        ⌃</div>
                    <div class="ltax">Community achievements</div>
                </a>
                <a href="/about-us" class="lbox">
                    <div
                        class="flex justify-center items-center w-7 h-7 border-[3px] font-bold text-base border-black rounded-full text-center">
                        ?</div>
                    <div class="ltax">About City Layers</div>
                </a>
                <a href="/contact-us" class="lbox">
                    <div
                        class="flex justify-center items-center w-7 h-7 border-[3px] font-bold text-base border-black rounded-full text-center">
                        •</div>

                    <div class="ltax">Team & contact</div>
                </a>
                <a href="/privacy-policy" class="lbox">
                    <div
                        class="flex justify-center items-center w-7 h-7 border-[3px] font-bold text-base border-black rounded-full text-center">
                        !</div>

                    <div class="ltax">Privacy Policy and Terms of Service</div>
                </a>
                <a href="/impressum-accessibility" class="lbox">
                    <div
                        class="flex justify-center items-center w-7 h-7 border-[3px] font-bold text-base border-black rounded-full text-center">
                        i</div>
                    <div class="ltax">Impressum & accessibility</div>
                </a>
                <a href="/admin/logout" class="lbox">
                    <div
                        class="flex justify-center items-center w-7 h-7 border-[3px] font-bold text-base border-black rounded-full text-center">
                        i</div>
                    <div class="ltax">Sign out</div>
                </a>
            </div>
            <br />
            <div class="belo">
                <div class="mapping">Maps are public and visible to all users. Your username will be shown along with your
                    pins and added layers.</div>
                <div class="cursor-pointer closebt" onclick="close_pop_profile()">Close</div>
            </div>
        </div>
    </div>
     -->
    <script>
        <?php require_once("js/map.js");?>
        <?php require_once("js/citymap.js");?>
    </script>
    <!-- <script src="resources/js/map.js"></script> -->
    <script>
        
        let c = new CategoryPanel("body");
        c.initiate();
        c.load(["Accessibility", "Noise", "Safety", "Weather Resistance", "Amenities"]);
        let m = new MapPanel("body");
        m.initiate();
        m.load();
    </script>

    <script>
        const openPopupButton = document.getElementById('openPopup_profile');
        const popup = document.getElementById('popup_profile');

        openPopupButton.addEventListener('click', () => {
            popup.style.transform = 'translateX(0)';
            popup.style.display = 'block';
        });

        function close_pop_profile() {


            popup.style.transform = 'translateX(100%)';
            setTimeout(() => {
                popup.style.display = 'none';
            }, 300);
        }
    </script>


    <script>
        data = {!! json_encode($all_data) !!};

        userid = {!! json_encode($userid) !!};

        markers = {};
        const edit_id = {{ $edit_id ? $edit_id : '0' }};
        let marker = null;

        let pin = [48.6890, 7.14086];
        if (data && data[0] && typeof data[0].latitude !== 'undefined' && typeof data[0].longitude !== 'undefined') {
            pin = [data[0].latitude, data[0].longitude];
        }
        let mymap0 = L.map('map').setView(pin, 6);

        // https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png

        osmLayer0 = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            subdomains: 'abcd',
            minZoom: 0,
            maxZoom: 19,
            ext: 'png'
        }).addTo(mymap0);
        mymap0.zoomControl.remove();
        mymap0.addLayer(osmLayer0);
        mymap0.touchZoom.enable();
        mymap0.scrollWheelZoom.enable();

        let place_data = {
            place_id: '',
            child_place_id: '',
            observations: '',
            place_description: '',
            observation_description: '',
            latitude: '',
            longitude: '',
            tab: 'place',
        };


        var temp_des = [];
        var temp_comment = [];
        var temp_likes = [];
        var temp_dislikes = [];


        var currentPosIcon = L.icon({
            iconUrl: '/new_img/current-pos.svg', // Replace with the path to your icon image
            iconSize: [62, 62], // Adjust the icon size as needed
            iconAnchor: [16, 16], // Adjust the anchor point of the icon
            popupAnchor: [0, -16] // Adjust the popup anchor for the icon
        });
        var currentPosIcon = L.divIcon({
            className: 'transparent-icon',
            iconSize: [64, 64], // Adjust the size of the icon including the border
            iconAnchor: [32, 32], // Adjust the anchor point of the icon
            html: '<div class="border-2 rounded-full border-site"><img src="/new_img/current-pos.svg" /></div>'
        });


        var placeIcon = L.divIcon({
            className: 'transparent-icon',
            html: `<div class="rounded-full bg-[#2d9bf0] border-2 border-white flex justify-center items-center p-4 w-[64px] h-[64px]">
                    <img src="{{ asset('new_img/image.png') }}" class="w-full h-full" />
                </div>`
        });
        var bothIcon = L.divIcon({
            className: 'transparent-icon',
            html: `<div class="rounded-full bg-[#2d9bf0] border-2 border-white flex justify-center items-center w-[64px] h-[64px]">
                        <div class="flex items-center justify-center h-full align-item-center">
                            <img src="{{ asset('new_img/sad.png') }}" alt="" class="w-6 h-6 -mr-2">
                            <img src="{{ asset('new_img/image.png') }}" class="z-20 w-6 h-6" />
                            <img src="{{ asset('new_img/happy.png') }}" alt="" class="w-6 h-6 -ml-2">
                        </div>
                </div>`
        });
        var observationIcon = L.divIcon({
            className: 'transparent-icon',
            html: `<div class="rounded-full bg-[#ffa726] border-2 border-white flex justify-center items-center p-4 w-[64px] h-[64px]">
                    <div class="flex">
                     <img src="{{ asset('new_img/sad.png') }}" alt="" class="-mr-1 w-7 h-7">
                     <img src="{{ asset('new_img/happy.png') }}" alt="" class="-ml-1 w-7 h-7">
                    </div>
                 </div>`
        });



        if (navigator.geolocation) {

            //wait 3 seconds to get position
            getposition(success, fail)

        } else {
            alert("Geolocation is not supported by this browser.");
        }


        function getposition(success, fail) {

            var is_echo = false;
            if (navigator && navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(pos) {
                        if (is_echo) {
                            return;
                        }
                        is_echo = true;

                        place_data['latitude'] = pos.coords.latitude;
                        place_data['longitude'] = pos.coords.longitude;

                        success(pos.coords.latitude, pos.coords.longitude);
                    },
                    function() {
                        if (is_echo) {
                            return;
                        }
                        is_echo = true;
                        fail();
                    }
                );
            } else {
                fail();
            }

        }

        function success(lat, lng) {
            mymap0.setView([lat, lng], 10);

            L.marker([lat, lng], {
                icon: currentPosIcon
            }).addTo(mymap0);
        }

        function fail() {
            alert("location failed");
        }

        function generateObservationHTML(observationDetail, place) {
            var obsrName = '';
            var addicon = '';
            if (observationDetail.observation.name) {
                obsrName = (observationDetail.observation ? observationDetail.observation.name : '') +
                    (observationDetail.observation && observationDetail.observation_child ?
                        '<span class="text-xs font-light"> → ' + observationDetail.observation_child.name + '</span>' : '');
            } else {
                obsrName = 'No Observation';
                if (place.user_id == userid) {
                    addicon = `
                    <div data-id="${place.id}" class="cursor-pointer border-2 transition-all rounded-full bg-[#2d9bf0] border-white w-6 h-6 mt-1 noObservation">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"></path>
                        </svg>
                    </div>
                    `;
                }
            }


            return `
            <div class="flex items-center justify-start gap-3 -mb-4 overflow-hidden">
                <div class="flex flex-col items-center justify-center">
                    <div class="rounded-full bg-[#ffa726] border-4 border-white w-[68px] h-[68px]">
                        <img src="${observationDetail.feeling.image}" alt="">
                    </div>
                </div>
                <div class="flex gap-4 mt-4">
                    <div @click="viewo=!viewo" class="text-center cursor-pointer">
                        <img src="{{ asset('img/cam.PNG') }}" alt="" class="h-6 w-7">
                        <div class="font-light text-white font-sm">view</div>
                    </div>
                    <span class="text-lg italic font-extrabold text-white whitespace-nowrap ` + (observationDetail
                .observation.id ? 'w-screen' : '') + `">` + obsrName + `</span>
                    ` + addicon + `
                </div>
            </div>
            `;
        }

        let count = 0;
        const likedPlaces = {!! json_encode($likedPlaces) !!};

        const edited_place = {!! json_encode($edited_place) !!};


        for (let i = 0; i < data.length; i++) {

            count = count + 1;
            place = data[i];
            placename = 'No Place';

            var addicon = '';

            if (place.user_id == userid) {
                addicon = `
                    <div data-id="${place.id}" class="cursor-pointer border-2 transition-all rounded-full bg-[#2d9bf0] border-white w-6 h-6 mt-1 noPlace">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"></path>
                        </svg>
                    </div>
                    `;
            }

            if (place.place_detail) {

                placename = (place.place_detail.place ? place.place_detail.place.name : '') +
                    (place.place_detail.place && place.place_detail.place_child ? '<span class="text-xs font-light"> → ' +
                        place.place_detail.place_child.name + '</span>' : '');


                addicon = '';
            }


            const isUserOwner = place.user_id === userid;
            const userdescription = place.description !== null ? place.description : '';
            // const comment = place.place_comment.comment !== null ? place.place_comment.comment : '';
            const comment = place.place_comment?.comment || '';
            const grade = place.place_grade?.grade || '';


            var textarea = `
            <div class="flex flex-col items-end w-full mt-4 mb-6">
                <div class="px-3 py-2 h-[60px] border-0 focus:outline-none focus:border-0 focus:ring-0 bg-[#2d9bf0] border-0 italic text-white placeholder-white leading-2 text-sm w-10/12">
                ${userdescription}
                </div>
            </div>
            `;

            if (isUserOwner) {
                textarea = `
                <div class="flex flex-col items-end w-full mt-4 mb-6">
                <textarea type="text" data-id="${place.id}" id="myTextArea" class="h-[60px] border-0 focus:outline-none focus:border-0 focus:ring-0 bg-[#2d9bf0] border-0 italic text-white placeholder-white leading-2 text-sm w-10/12" placeholder="Place for a comment max 120 characters">${userdescription}</textarea>
                </div>
            `;
            }
            username = place.user.name;


            const givenDate = new Date(place.created_at); // Replace with your given date
            const options = {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            };
            const formattedDate = givenDate.toLocaleDateString('en-US', options);
            // pics = place.image0;
            placelatitude = place.latitude;
            placelongitude = place.longitude;
            var obsrvTotal = Object.keys(place.observations_detail).length;


            if ((place.place_detail) && obsrvTotal == 0) {
                icon2 = placeIcon;
            }
            if ((place.place_detail) && obsrvTotal > 0) {
                icon2 = bothIcon;
            }
            if ((place.place_detail) == null && obsrvTotal > 0) {
                icon2 = observationIcon;
            }




            var observationsList = '';

            if (obsrvTotal > 0) {
                place.observations_detail.forEach(observationDetail => {
                    observationsList += generateObservationHTML(observationDetail);
                }, '');
            } else {
                observationsList += generateObservationHTML({
                    observation: 'null',
                    observation_child: null,

                    feeling: {
                        image: ''
                    }
                }, place);
            }

            var like = false;
            if (likedPlaces.includes(place.id)) {
                like = true;
            }


            markerx = L.marker([placelatitude, placelongitude], {
                icon: icon2
            }).addTo(mymap0) //.bindPopup(
                
                // createContainer()
                


                // `<div class="bg-[#2d9bf0] p-0 w-full" x-data="{ viewp: false,viewo: false }">

                //     <div class="flex items-center justify-start gap-3 -mb-4 overflow-hidden">
                //         <div class="flex flex-col items-center justify-center">
                //             <div class="rounded-full bg-[#2d9bf0] border-4 border-white p-3 w-[68px] h-[68px]">
                //                 <img class="w-full h-full" src="{{ asset('new_img/image.png') }}" />
                //             </div>
                //         </div>
                //         <div class="flex gap-4 mt-4">
                //             <div class="text-center">
                //                 <img src="{{ asset('img/cam-2.PNG') }}" alt="" class="h-6 w-7">
                //                 <div @click="viewp=!viewp" class="font-light text-white font-sm">view</div>
                //             </div>
                //             <span class="text-lg italic font-extrabold text-white">
                //             ` + placename + `
                //             </span>
                //             ` + addicon + `


                //         </div>
                //     </div>

                //     ` + observationsList + `

                //     ` + textarea + `
                //     <div class="slidecontainer">
                //         <input type="range" min="0" max="100" value="50" class="slider" id="accessibility" onchange="updateSlider()">
                //         <p>Accessibility: <span id="accessibility_output"></span></p>
                //     </div>
                //     <div x-data="activeliked(${place.id},${like})" class="absolute bottom-[-5px] w-full left-0 px-[10px]">
                //         <div class="flex items-center justify-between italic font-light text-white">
                //             <div class="flex items-center w-2/5 gap-10 likecomment">
                //                 <div @click="comment${place.id}=!comment${place.id}" class="cursor-pointer">
                //                     <img src="{{ asset('img/msg.PNG') }}" class="h-9 mt-[8px]">
                //                 </div>

                //                 <div onclick="setlike(${place.id},this)" @click="like${place.id}=!like${place.id}" class="cursor-pointer bg-[#0078d9] text-center text px-2 rounded">
                //                     <i class="fa fa-heart"
                //                     :class="like${place.id} ? 'fa-heart text-[#ffc543] liked' : 'fa-heart-o nolike'"
                //                     ></i>
                //                 </div>
                //             </div>
                //             <div class="w-3/5">Added by ` + username + ` on ` + formattedDate +
                //             `</div>
                //         </div>

                //         <div class="absolute left-0 w-full" x-show="comment${place.id}">
                //             <textarea type="text" data-id="${place.id}" class="feedback w-full 
                //             rounded-xl h-[60px] focus:outline-none focus:border-0 focus:ring-0 bg-[#2d9bf0] 
                //             border-0 italic text-white placeholder-white leading-2 text-sm w-10/12" placeholder="Put your feedback">` +
                //             comment + `</textarea>
                //             <button onclick="saveGrade(this)" class="save font-bold border-2 border-site px-2 py-1 text-white bg-[#2d9bf0] rounded-3xl cursor-pointer float-right">
                //                 Save
                //             </button>
                //             <div @click="comment${place.id}=false" class="hideCommentBox">
                //             </div>
                //         </div>
                //     </div>

                //     <div x-show="viewp" class="fixed top-0 w-full height-[30vh] bg-white rounded">
                  
                //         <img src="storage/uploads/place/${place.place_image}"  class="w-full h-full" />
                    
                //     </div>
                    
                //      <div x-show="viewo" class="fixed top-0 w-full height-[30vh] bg-white rounded">
                  
                //         <img src="storage/uploads/observation/${place.obsevation_image}"  class="w-full h-full" />
                    
                //     </div>
                // </div>
                
                // `
            // );

            

            markerx.on('popupopen', (event) => {
                const _id = event.popup._source.placeDetailID;
                if (_id && temp_des['_' + _id]) {
                    $('body #myTextArea').text(`${temp_des['_'+_id]}`);
                }
                if (_id && temp_comment['_' + _id]) {
                    $('body .feedback').text(`${temp_comment['_'+_id]}`);
                }
                var typingTimer;
                var delay = 1000;

                function handleTypingStopped() {
                    const data = $('body #myTextArea').val();
                    const id = $('body #myTextArea').data('id');

                    if (data && id) {
                        temp_des['_' + id] = data;
                        saveDescription(data, id);
                        $('body #myTextArea').blur();
                    }
                }
                $('body #myTextArea').on('input', function() {
                    clearTimeout(typingTimer);
                    typingTimer = setTimeout(handleTypingStopped, delay);
                });



            });
            markerx.placeDetailID = place.id;
            markers[place.id] = markerx;
        }

        function mylocation() {
            getmyposition(success, fail);
        }

        function activeliked(id, like) {

            if (temp_likes.includes(id)) {
                like = true;
            }
            if (temp_dislikes.includes(id)) {
                like = false;
            }
            return {
                [`like${id}`]: like,
                [`comment${id}`]: false
            };
        }

        function getmyposition(success, fail) {

            var is_echo = false;
            if (navigator && navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(pos) {

                        if (is_echo) {
                            return;
                        }
                        is_echo = true;

                        success(pos.coords.latitude, pos.coords.longitude, false);
                    },
                    function() {
                        if (is_echo) {
                            return;
                        }
                        is_echo = true;
                        fail();
                    }
                );
            } else {
                fail();
            }
        }

        function success(lat, lng, withmarket = true) {
            mymap0.flyTo([lat, lng], 6);
            if (withmarket) {
                L.marker([lat, lng], {
                    icon: currentPosIcon
                }).addTo(mymap0);
            }


        }

        function fail() {
            alert("location failed");
        }

        function zoom() {
            myzoom(success, fail);
        }

        function myzoom(success, fail) {
            var is_echo = false;
            if (navigator && navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(pos) {
                        if (is_echo) {
                            return;
                        }
                        is_echo = true;
                        success(pos.coords.latitude, pos.coords.longitude);
                    },
                    function() {
                        if (is_echo) {
                            return;
                        }
                        is_echo = true;
                        fail();
                    }
                );
            } else {
                fail();
            }
        }

        $('body').on('click', '.addToMap', function() {
            set_empty();


        });
        $('body').on('click', '.submitData', function() {


            $('.subPlacesItems').html('');
            $('.subObservationItems').html('');

            var place_detail = $(this).closest('.parentDiv').find('.placeActive').data('place');

            var observations_detail = [];
            $(this).closest('.parentDiv').find('.observationActive').each(function() {
                var data = $(this).data('observations');
                observations_detail.push(data);
            });


            var $homeTab = $(this).closest('.parentDiv').find('.observationTabActive').length > 0 ? 'observation' :
                'place';
            place_data['tab'] = $homeTab;
            if ($homeTab == 'place' && place_detail.id) {
                place_data['place_id'] = place_detail.id;

                if (place_detail.child.length >= 0) {
                    $('.placeparent').text(place_detail.name);
                    var allHtml = '';
                    place_detail.child.forEach(place => {
                        allHtml += `
                        <div class="flex flex-col items-center cursor-pointer" @click="subactive='SPL_${place.id}'">
                                            <div data-subplaceid="${place.id}" class="SPL_${place.id} w-[76px] h-[76px] rounded-full bg-[#2d9bf0]"
                                            :class="subactive == 'SPL_${place.id}' ? 'border-4 border-[#12CDD4] subplaceActive' : ''">
                                                <div class="flex items-center justify-center h-full align-item-center">
                                                    <img src="{{ asset('new_img/image.png') }}" class="w-7 h-7" />
                                                </div>
                                            </div>
                                            <span class="mt-4 text-base font-normal text-black">${place.name}</span>
                                        </div>
                        `;
                    });
                    $('.subPlacesItems').html(allHtml);

                    $('.subModeltrigerPlace').click();

                    if (edited_place && edited_place.place_detail.place_child_id) {
                        setTimeout(() => {
                            $('.SPL_' + edited_place.place_detail.place_child_id).click();
                        }, 200);
                    }

                } else {
                    submitDetailData(place_data);
                    
                }


            } else if ($homeTab == 'observation') {
                var allHtml = '';


                observations_detail.forEach(function(observation) {


                    allHtml +=
                        `<div data-observation_id="${observation.id}"><div class="mb-4">${observation.name}</div>`;



                    if (observation.child.length === 0) {
                        allHtml += `
                            <div data-subobservation_id="" class="flex items-center justify-between mb-10">
                               ${getFeelingHTML(observation)}
                            </div>
                        `;
                    } else {
                        observation.child.forEach(observ => {
                            allHtml += `
                            <div data-subobservation_id="${observ.id}" class="flex items-center justify-between gap-2 mb-10 lg:gap-20">
                                <div class="flex flex-col items-center w-[160px]">
                                    <div class="w-[76px] h-[76px] rounded-full bg-[#ffa726]">
                                        <div class="flex items-center justify-center h-full align-item-center">
                                            <img src="{{ asset('new_img/sad.png') }}" alt=""
                                                            class="w-8 h-8 -mr-1"> <img
                                                            src="{{ asset('new_img/happy.png') }}" alt=""
                                                            class="w-8 h-8 -ml-1">
                                        </div>
                                    </div>
                                    <span class="mt-1 text-base font-normal text-black">${observ.name}</span>
                                </div>

                                ${getFeelingHTML(observation,observ)}
                            </div>`;
                        });
                    }

                    allHtml += `</div>`;
                });

                $('.subObservationItems').html(allHtml);



                $('.subModeltrigerObservation').click();


                setTimeout(() => {
                    if (edited_place && edited_place.observations_detail && edited_place.observations_detail
                        .length > 0) {
                        edited_place.observations_detail.forEach(function(observation) {
                            if (observation.observation_child_id) {
                                clickClass = 'feel_' + observation.observation_id + '_' +
                                    observation.observation_child_id + '_' + observation.feeling_id;
                            } else {
                                clickClass = 'feel_' + observation.observation_id + '_' +
                                    observation.feeling_id;
                            }
                            $('.' + clickClass).click();
                        });
                    }
                }, 200);

            }





        });


        function getFeelingHTML(observation, child = '') {
            return `
                                <div x-data="{ feelActive${observation.id}: 'feel_${observation.id}_1' }" class="flex flex-wrap items-center justify-center w-full gap-2 italic font-semibold ">
                                    @foreach ($feelings as $feeling)
                                        <div data-feeling_id="{{ $feeling->id }}"
                                            @click="feelActive${observation.id}='feel_${observation.id}_{{ $feeling->id }}'"
                                            class="feel_${observation.id}${child.id ? '_' + child.id : ''}_{{ $feeling->id }} cursor-pointer rounded-full"
                                            :class="feelActive${observation.id} == 'feel_${observation.id}_{{ $feeling->id }}' ? 'border-4 border-[#12CDD4] feelingActive' : ''"
                                            >
                                            <img class="w-12 h-12 sm:w-16 sm:h-16" src="{{ asset($feeling->image) }}" alt="">
                                        </div>
                                    @endforeach
                                </div>
                    `;
        }

        var fileInput_place = '';
        var fileInput_observation = '';

        $('body').on('click', '.submitDataAll', function() {

            var $SubTab = $(this).closest('.parentDiv').find('.subobservationTabActive').length > 0 ?
                'observation' : 'place';

            if ($SubTab == 'place') {
                var subplace_id = $(this).closest('.parentDiv').find('.subplaceActive').data('subplaceid');
                fileInput_place = $(".place_image")[0].files[0];
                place_data['place_description'] = $(this).closest('.parentDiv').find('.place_description').val();
                place_data['child_place_id'] = subplace_id ? subplace_id : '';



            } else if ($SubTab == 'observation') {
                fileInput_observation = $(".observation_image")[0].files[0];
                place_data['observation_description'] = $(this).closest('.parentDiv').find(
                    '.observation_description').val();
                var dataList = [];
                $(this).closest('.parentDiv').find('.feelingActive').each(function() {
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
            // console.log(place_data);
            submitDetailData(place_data);

        });





        $('body').on('click', '.noPlace', function() {

            set_empty();


            place_data['place_detail_id'] = $(this).data('id');
            place_data['update'] = 'place';
            $('.openPlaceModel').click();
            setTimeout(() => {
                var hrefValue = $('.tabNewLink').attr('href');
                $('.tabNewLink').attr('href', hrefValue + '/' + $(this).data('id'));
            }, 200);
        });

        $('body').on('click', '.noObservation', function() {

            set_empty();

            place_data['place_detail_id'] = $(this).data('id');
            place_data['update'] = 'observation';

            $('.OpenObservationModel').click();
            setTimeout(() => {
                var hrefValue = $('.tabNewLink').attr('href');
                $('.tabNewLink').attr('href', hrefValue + '/' + $(this).data('id'));
            }, 200);
        });

        function set_empty() {
            place_data['place_id'] = '';
            place_data['place_detail_id'] = '';
            place_data['child_place_id'] = '';
            place_data['observations'] = '';
            place_data['place_description'] = '';
            place_data['observation_description'] = '';
            place_data['tab'] = 'place';
            place_data['update'] = '';
        }



        var totalswal = 0;

        function submitDetailData(place_data) {



            place_data['update'] = place_data.tab;

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
                success: function(data) {
                    var reverse_tab = data.tab == 'place' ? 'observation' : 'place';
                    if (data.status == 'success') {

                        if (totalswal >= 1) {
                            window.location.href = '/';
                        } else {
                            totalswal = totalswal + 1;
                            place_data['place_detail_id'] = data.place_detail_id;
                            swal({
                                title: "Success!",
                                text: data.tab.charAt(0).toUpperCase() + data.tab.slice(1) + " " + data
                                    .msg + " Do you want to add " + reverse_tab + " tag?",
                                icon: "success",
                                buttons: ["Close", "Continue"],
                            }).then((userConfirmed) => {
                                if (userConfirmed) {

                                    setTimeout(() => {
                                        var hrefValue = $('.tabNewLink').attr('href');
                                        $('.tabNewLink').attr('href', hrefValue + '?only=true');
                                    }, 200);

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
                        }


                    }

                }

            });

        }

        function saveGrade(e) {
            
            let latitude = 59.334591;
            let longitude = 18.063240;
            
            console.log("E", e);
            console.log($(e));
            console.log($(e).parent().find('.feedback'));
            
            const data = $(e).parent().find('.feedback').val();
            const label = 62; //$(e).parent().find('.feedback').val();
            const id = $(e).parent().find('.feedback').data('id');
            console.log(data);
            console.log(id);

            $(e).parent().find('.hideCommentBox').click();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: "/save-grade",
                data: {
                    data: data,
                    label: label,
                    id: id
                     },
            });
        }

            

        function setlike(id, e) {

            if ($(e).find('i').hasClass('nolike')) {
                temp_likes.push(id);
                temp_dislikes = temp_dislikes.filter(function(value, index, arr) {
                    return value != id;
                });
            } else {
                temp_likes = temp_likes.filter(function(value, index, arr) {
                    return value != id;
                });
                temp_dislikes.push(id);
            }


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/set-like',
                type: 'POST',
                data: {
                    id: id
                }
            });
        }

        function saveDescription(data, id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/save-des',
                type: 'POST',
                data: {
                    data: data,
                    id: id
                }
            });
        }

        function saveComment(e) {
            const data = $(e).parent().find('.feedback').val();
            const id = $(e).parent().find('.feedback').data('id');

            $(e).parent().find('.hideCommentBox').click();

            temp_comment['_' + id] = data;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/save-comment',
                type: 'POST',
                data: {
                    data: data,
                    id: id
                }
            });
        }

        function updateSlider(){
            console.log(this);
            var slider = document.getElementById("accessibility");
            document.getElementById('accessibility_output').innerHTML = slider.value;

            let id = document.getElementsByClassName("feedback")[0].getAttribute("data-id");
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: "/save-grade",
                data: {
                    data: parseInt(slider.value),
                    id: id
                     },
            });
        }

        // <script>
        
        // var slider = document.getElementById("accessibility");
        // slider.addEventListener('onchange',function() {
        //             this.setAttribute('value',this.value);
        //             });
        // var output = document.getElementById("accessibility_output");
        // output.innerHTML = slider.value;

        // slider.oninput = function() {
        //     console.log(this.value);
        // output.innerHTML = this.value;
        //     }
            

        $(document).ready(function() {

            if (edit_id && edit_id != 0) {
                $('.openPlaceModel').click();
                // $('.OpenObservationModel').click();
            }
        });
    </script>
@endsection
