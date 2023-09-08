<div>
    <div class="px-2 pt-8" x-cloak x-data="{ tab: 'place' }">

        <input type="text" class="w-full px-2 py-2 bg-white rounded-full" wire:model='search'
            placeholder="Choose tags or add new city layers" name="input" id="">


        <div class="flex items-center justify-center mt-20">
            <div class="absolute left-[48%] top-[90px] cursor-pointer" @click="tab='feature'" onclick="feature()">
                <div class="flex flex-col">

                    <div class="border-2 border-black rounded-full shadow-xl"
                        :class="tab == 'feature' ? 'bg-yellow-400 p-[22px]' :
                            'bg-yellow-400/70 p-[35px]'">
                        <img src="{{ asset('img/search-icon.png') }}" class="w-7 h-7"
                            :class="tab == 'feature' ? 'block' : 'hidden'" id="feature" alt="">
                    </div>



                </div>

            </div>
            <div class="absolute left-[32%] top-[90px] cursor-pointer" @click="tab='place'" onclick="place()">
                <div class="flex flex-col">
                    <div class="border-2 border-black rounded-full shadow-xl bg-cyan-500"
                        :class="tab == 'place' ? 'bg-cyan-500 p-[22px]' :
                            'bg-cyan-500/70 p-[35px]'">
                        <img src="{{ asset('img/image.png') }}" class="w-7 h-7"
                            :class="tab == 'place' ? 'block' : 'hidden'" id="place" alt="">
                    </div>

                </div>


            </div>


        </div>

        <div class="flex items-center justify-center italic font-semibold mt-44">
            <div class="absolute left-[52%] top-[170px] cursor-pointer" @click="tab='feature'" onclick="place()">


                <div class="w-8" :class="tab == 'feature' ? 'text-black' : 'text-black/50'">
                    Browse Observation
                </div>

            </div>
            <div class="absolute left-[35%] top-[170px] cursor-pointer" @click="tab='place'" onclick="feature()">

                <div class="w-8" :class="tab == 'place' ? 'text-black' : 'text-black/50'">
                    Browse Places
                </div>




            </div>


        </div>



        @if (!$search)
            <div class="flex flex-col absolute left-16 right-16 top-[230px] gap-2 italic font-semibold"
                x-show="tab=='place'">
                <div class="flex gap-5">
                    <div class="flex flex-col items-center justify-center">
                        <div class="rounded-full bg-cyan-500 border-2  border-black p-[35px]">

                        </div>
                        <span class="mt-2 text-black">Place 1</span>
                    </div>

                    <div class="flex flex-col items-center justify-center">
                        <div class="rounded-full bg-cyan-500 border-2  border-black p-[35px]">

                        </div>
                        <span class="mt-2 text-black">Place 2</span>
                    </div>

                    <div class="flex flex-col items-center justify-center">
                        <div class="rounded-full bg-cyan-500 border-2  border-black p-[35px]">

                        </div>
                        <span class="mt-2 text-black">Place 2</span>
                    </div>
                </div>
                <div class="flex gap-5">
                    <div class="flex flex-col items-center justify-center">
                        <div class="rounded-full bg-cyan-500 border-2  border-black p-[35px]">

                        </div>
                        <span class="mt-2 text-black">Place 1</span>
                    </div>

                    <div class="flex flex-col items-center justify-center">
                        <div class="rounded-full bg-cyan-500 border-2  border-black p-[35px]">

                        </div>
                        <span class="mt-2 text-black">Place 2</span>
                    </div>

                    <div class="flex flex-col items-center justify-center">
                        <div class="rounded-full bg-cyan-500 border-2  border-black p-[35px]">

                        </div>
                        <span class="mt-2 text-black">Place 2</span>
                    </div>
                </div>
                <div class="flex gap-5">
                    <div class="flex flex-col items-center justify-center">
                        <div class="rounded-full bg-cyan-500 border-2  border-black p-[35px]">

                        </div>
                        <span class="mt-2 text-black">Place 1</span>
                    </div>

                    <div class="flex flex-col items-center justify-center">
                        <div class="rounded-full bg-cyan-500 border-2  border-black p-[35px]">

                        </div>
                        <span class="mt-2 text-black">Place 2</span>
                    </div>

                    <div class="flex flex-col items-center justify-center">
                        <div class="rounded-full bg-cyan-500 border-2  border-black p-[35px]">

                        </div>
                        <span class="mt-2 text-black">Place 2</span>
                    </div>
                </div>
                <div class="flex gap-5">
                    <div class="flex flex-col items-center justify-center">
                        <div class="rounded-full bg-cyan-500 border-2  border-black p-[35px]">

                        </div>
                        <span class="mt-2 text-black">Place 1</span>
                    </div>

                    <div class="flex flex-col items-center justify-center">
                        <div class="rounded-full bg-cyan-500 border-2  border-black p-[35px]">

                        </div>
                        <span class="mt-2 text-black">Place 2</span>
                    </div>

                    <div class="flex flex-col items-center justify-center">
                        <div class="rounded-full bg-cyan-500 border-2  border-black p-[35px]">

                        </div>
                        <span class="mt-2 text-black">Place 2</span>
                    </div>
                </div>



            </div>

            <div class="flex flex-col absolute left-16 right-16 top-[230px] gap-2 italic font-semibold"
                x-show="tab=='feature'">
                <div class="flex gap-5">
                    <div class="flex flex-col items-center justify-center">
                        <div class="rounded-full bg-yellow-400 border-2  border-black p-[35px]">

                        </div>
                        <span class="mt-2 text-black">A</span>
                    </div>

                    <div class="flex flex-col items-center justify-center">
                        <div class="rounded-full bg-yellow-400 border-2  border-black p-[35px]">

                        </div>
                        <span class="mt-2 text-black">B</span>
                    </div>

                    <div class="flex flex-col items-center justify-center">
                        <div class="rounded-full bg-yellow-400 border-2  border-black p-[35px]">

                        </div>
                        <span class="mt-2 text-black">c</span>
                    </div>
                </div>
                <div class="flex gap-5">
                    <div class="flex flex-col items-center justify-center">
                        <div class="rounded-full bg-yellow-400 border-2  border-black p-[35px]">

                        </div>
                        <span class="mt-2 text-black">A</span>
                    </div>

                    <div class="flex flex-col items-center justify-center">
                        <div class="rounded-full bg-yellow-400 border-2  border-black p-[35px]">

                        </div>
                        <span class="mt-2 text-black">B</span>
                    </div>

                    <div class="flex flex-col items-center justify-center">
                        <div class="rounded-full bg-yellow-400 border-2  border-black p-[35px]">

                        </div>
                        <span class="mt-2 text-black">C</span>
                    </div>
                </div>
                <div class="flex gap-5">
                    <div class="flex flex-col items-center justify-center">
                        <div class="rounded-full bg-yellow-400 border-2  border-black p-[35px]">

                        </div>
                        <span class="mt-2 text-black">A</span>
                    </div>

                    <div class="flex flex-col items-center justify-center">
                        <div class="rounded-full bg-yellow-400 border-2  border-black p-[35px]">

                        </div>
                        <span class="mt-2 text-black">B</span>
                    </div>

                    <div class="flex flex-col items-center justify-center">
                        <div class="rounded-full bg-yellow-400 border-2  border-black p-[35px]">

                        </div>
                        <span class="mt-2 text-black">C</span>
                    </div>
                </div>
                <div class="flex gap-5">
                    <div class="flex flex-col items-center justify-center">
                        <div class="rounded-full bg-yellow-400 border-2  border-black p-[35px]">

                        </div>
                        <span class="mt-2 text-black">A</span>
                    </div>

                    <div class="flex flex-col items-center justify-center">
                        <div class="rounded-full bg-yellow-400 border-2  border-black p-[35px]">

                        </div>
                        <span class="mt-2 text-black">B</span>
                    </div>

                    <div class="flex flex-col items-center justify-center">
                        <div class="rounded-full bg-yellow-400 border-2  border-black p-[35px]">

                        </div>
                        <span class="mt-2 text-black">C</span>
                    </div>
                </div>



            </div>


            <div class="absolute left-[33%] bottom-5">
                <button
                    class="flex items-center justify-center gap-2 px-4 py-3 text-lg font-extrabold text-white rounded-3xl bg-cyan-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Add new</button>
            </div>
        @else
            <div class="absolute top-[230px] ">
                <div class="pt-2 border-t-2 border-black">
                    <div class="text-lg italic font-bold text-black">Search Places </div>
                </div>
            </div>
        @endif






    </div>
</div>
