@extends('layouts.app')
@vite('resources/css/app.css')
@vite('resources/css/landing.css')
@vite('resources/css/legal.css')
@vite('resources/css/slideshow.css')



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
                    <div class="slideshow-container">

                        <!-- Full-width images with number and caption text -->
                        <div class="slides fade">
                            <img src="/images/landing/0.svg">
                            <div class="text">Welcome to City Layers</div>
                            <div class="subtext">You are invited to share your thoughts on your experience of the city</div>
                        </div>

                        <div class="slides fade">
                            <img src="/images/landing/1.svg">
                            <div class="text">Map it</div>
                            <div class="subtext">Pin your thoughts about a place by rating and adding tags</div>
                        </div>

                        <div class="slides fade">
                            <img src="/images/landing/2.png">
                            <div class="text">Comment and photograph it</div>
                            <div class="subtext">Enhance your mappings with personal insights</div>
                        </div>
                        <div class="slides fade">
                            <img src="/images/landing/3.jpg">
                            <div class="text">Explore the city Layers!</div>
                            <div class="subtext">Turn the layers on and off to create heat-maps and view other people's posts</div>
                        </div>
                        <div class="slides fade">
                            <img src="/images/landing/4.png">
                            <div class="text">Learn more about city Layers!</div>
                            <div class="subtext">Get an overview of how we measure Beauty, Activities, Sound, Movement, Protection and Climate Comfort</div>
                        </div>

                        <!-- Next and previous buttons -->
                        
                        
                        
                    </div>
                    
                
                <div class="buttonfooter">

                    <div class="buttoncontainer" x-show="tab=='1'">
                    
                    <div class="dots">
                            <span class="dot" onclick="currentSlide(1)"></span>
                            <span class="dot" onclick="currentSlide(2)"></span>
                            <span class="dot" onclick="currentSlide(3)"></span>
                            <span class="dot" onclick="currentSlide(4)"></span>
                            <span class="dot" onclick="currentSlide(5)"></span>
                        </div>
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
            <script>let slideIndex = 1;
                showSlides(slideIndex);

                // Next/previous controls
                function plusSlides(n) {
                showSlides(slideIndex += n);
                }

                // Thumbnail image controls
                function currentSlide(n) {
                showSlides(slideIndex = n);
                }

                function showSlides(n) {
                let i;
                let slides = document.getElementsByClassName("slides");
                let dots = document.getElementsByClassName("dot");
                if (n > slides.length) {slideIndex = 1}
                if (n < 1) {slideIndex = slides.length}
                for (i = 0; i < slides.length; i++) {
                    slides[i].style.display = "none";
                }
                for (i = 0; i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" active", "");
                }
                slides[slideIndex-1].style.display = "flex";
                dots[slideIndex-1].className += " active";
                }</script>


        <!-- </div> -->

        


    <!-- </div> -->
    
@endsection
