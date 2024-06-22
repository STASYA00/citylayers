<div class="p-6 lg:p-12">
    <a href="/" class="">
        <img src="{{ asset('images/logo.svg') }}" class="arrow">

    </a>
    <div class="pt-12 lg:pt-20" x-cloak x-data="{ tab: 'place' }">
        <div x-cloak x-data="{ update: 'close' }">

            <div class="" x-show="update == 'close'">


                <div class="flex items-center justify-center mt-6">

                    <div class="-ml-2 cursor-pointer" @click="update=!update">
                        <div class="flex flex-col justify-center items-center">

                            <div
                                class="h-20 w-20 flex items-center justify-center p-3 text-3xl bg-white border-2 border-black rounded-full">
                                <div class=""> <img src="{{ asset('img/eye.png') }}" class="w-12 h-8"
                                        alt=""></div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="flex flex-col items-center justify-center pt-6">
                    <div class="flex flex-col items-center justify-center mb-8">

                        <span class="text-xl italic font-bold">
                            Update your City Layers!
                        </span>
                        <div class="text-base text-center italic font-semibold">
                            Select what you want to see on your map to personalise your experience. You can always
                            change your preferences.
                        </div>

                    </div>




                    <form wire:submit.prevent="updateMap">
                        <div class="flex gap-8">
                            <div x-data="{ active: 'AC_1' }">
                                <div class="flex flex-col items-center justify-center gap-10 mt-6 italic font-semibold"
                                    x-show="tab=='place'">
                                    <div class="grid grid-cols-3 italic font-semibold gap-10">
                                        @foreach ($places as $pls)
                                            <div wire:ignore
                                                class="flex flex-col items-center justify-top text-center cursor-pointer">

                                                <input class="hidden" type="checkbox" wire:model="formData"
                                                    value="{{ $pls->source . '_' . $pls->id }}"
                                                    id="{{ 'checkbox_' . $pls->source . '_' . $pls->id }}"
                                                    @if ($pls->source === 'place' && is_array($placeIds) && in_array($pls->id, $placeIds)) checked @endif
                                                    @if ($pls->source === 'observation' && is_array($observationIds) && in_array($pls->id, $observationIds)) checked @endif>


                                                <label for="{{ 'checkbox_' . $pls->source . '_' . $pls->id }}"
                                                    id="PL_{{ $pls->source . '_' . $pls->id }}"
                                                    onclick="toggleClass('{{ $pls->source . '_' . $pls->id }}')"
                                                    class="w-[76px] h-[76px] cursor-pointer rounded-full  
                                                    
    
                                                    @if ($pls->source === 'place' && is_array($placeIds) && in_array($pls->id, $placeIds)) border-4 border-[#12CDD4] highlight @endif
                                                    @if ($pls->source === 'observation' && is_array($observationIds) && in_array($pls->id, $observationIds)) border-4 border-[#12CDD4] highlight @endif
           
    
                                                    @if ($pls->source === 'place') bg-site @else bg-[#ffa726] @endif p-[20px]">
                                                    <div
                                                        class="flex align-item-center justify-center items-center h-full">
                                                        @if ($pls->source === 'place')
                                                            <img src="{{ asset('new_img/image.png') }}"
                                                                class="w-7 h-7" />
                                                        @else
                                                            <div class="flex items-center justify-center w-7">
                                                                <img src="{{ asset('new_img/sad.png') }}" alt=""
                                                                    class="-mr-1 w-7 h-7"> <img
                                                                    src="{{ asset('new_img/happy.png') }}"
                                                                    alt="" class="-ml-1 w-7 h-7">
                                                            </div>
                                                        @endif
                                                    </div>
                                                </label>
                                                <span class="mt-4 text-black font-normal">{{ $pls->name }}</span>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>

                        </div>


                        <div class="flex flex-row justify-center items-center gap-4 mt-16">
                            <a href="/"
                                class="px-6 py-4 font-bold	font-sm rounded-3xl color-site border-2 border-site cursor-pointer">Close</a>


                            <button type="submit"
                                class="px-6 py-4 font-bold border-2	font-sm rounded-3xl text-white bg-site border-site">Update
                                Map</button>
                        </div>
                        </from>




                </div>

            </div>


        </div>
    </div>
</div>

<script>
    function toggleClass(id) {
        const element = document.getElementById('PL_' + id);
        element.classList.toggle('border-4');
        element.classList.toggle('border-[#12CDD4]');
        element.classList.toggle('highlight');
    }

    function noti() {
        // swal({
        //     icon: "success",
        //     title: 'Map updated successfully',

        // })

        // window.location.href = "/";

    }
</script>
