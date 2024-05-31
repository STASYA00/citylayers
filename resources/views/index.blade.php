@extends('layouts.app')
@vite('resources/css/landing.css')



@section('main')
    <div data-barba="container" class="relative">
        <div class="tabs">
            
                <!-- tabs content  -->
                <div class="wrap">
                    <div id="wrap">
                        <section>One</section>
                        <section>Beautiful</section>
                        <section>Full-Page</section>
                        <section>Slideshow</section>
                    </div>
                </div>
            </div>
            
        <!-- <script>
            document.addEventListener("DOMContentLoaded", function() {
            var wrap = document.getElementById('wrap');
            var fps = new FullPageScroll(wrap);
            var indicator = document.createElement('div');
            indicator.id = 'indicator';
            var slideIndicators = [];
            fps.slides.forEach(function(slide, index){
                var slideIndicator = document.createElement('div');
                slideIndicator.onclick = function() {
                fps.goToSlide(index);
                }
                if (index === fps.currentSlide) {
                slideIndicator.className = "active";
                }
                indicator.appendChild(slideIndicator);
                slideIndicators.push(slideIndicator);
            });
            document.body.appendChild(indicator);
            fps.onslide = function() {
                slideIndicators.forEach(function(slideIndicator, index) {
                if (index === fps.currentSlide) {
                    slideIndicator.className = "active";
                } else {
                    slideIndicator.className = "";
                }
                });
            }
            });
        </script> -->
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
    
@endsection
