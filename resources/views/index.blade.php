@extends('layouts.app')
@vite('resources/css/landing.css')
@vite('resources/css/legal.css')



@section('main')
    <!-- <div data-barba="container" class="relative"> -->
        <!-- <div class="tabs"> -->
            
                <!-- tabs content  -->
                <div class="legalpanel">
                    <div class="header">
            
                        <a href="/">
                            <img class="logo" src="../images/logo_2.svg">
                        </a>
                    </div>
                    <div class="landingtext">
                        <div>Welcome to City Layers!</div>
                        <div>You are invited to share your thoughts on your experience of the city!</div>
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

                <div class="footer">
                    </button>
            
                        <a href="/impressum" class="legalbutton">
                            <div class="text-center">Impressum</div>
                        </a>
                        <a href="/accessibility" class="legalbutton">
                            <div class="text-center">Accessibility</div>
                        </a>
                        <a href="/dataprivacyandprotection" class="legalbutton">
                            <div class="text-center">Data protection</div>
                        </a>
                        <a href="/team" class="legalbutton">
                            <div class="text-center">Team</div>
                        </a>

                </div>

            </div>


        <!-- </div> -->

        


    <!-- </div> -->
    
@endsection
