@extends('layouts.app')
@vite('resources/css/landing.css')



@section('main')
    <div data-barba="container" class="relative">
        <div class="tabs">
            
                <!-- tabs content  -->
                <div class="landing">
                    <div id="landing_id">
                        <img src="images/logo_2.svg" class="logo"></img>
                    </div>
                    <div class="landingtext">
                        <div>Welcome to City Layers!</div>
                        <div>You are invited to share your thoughts on your experience of the city!</div>
                    </div>
                </div>
            
            
        <div class="buttonfooter">

            <div class="buttoncontainer" x-show="tab=='1'">
                

                </button>
                <a href="/explore" class="primary-button">
                    <div class="text-center">Explore the map</div>
                </a>

                </button>
                <a href="/pin" class="primary-button">
                    <div class="text-center">Add a pin</div>
                </a>



            </div>
            </div>


        </div>


    </div>
    
@endsection
