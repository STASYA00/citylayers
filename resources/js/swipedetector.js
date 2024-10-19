
class SlideManager{
    static slides = "slides";
    static dot = "dot";
    static display_mode = "flex";
    static hide_mode = "none";
    static active_mode = " active";
    static slideIndex = 1;

    static next(n) {
        this.show(this.slideIndex += n);
        }
    static prev(n) {
        this.show(this.slideIndex -= n);
        }

        // Thumbnail image controls
    static current(n) {
        this.show(this.slideIndex = n);
        }

    
    static activate(n){
        slides[n].style.display = this.display_mode;
        dots[n].className += this.active_mode;
    }
    static deactivate(){
        let slides = this.getSlides();
        let dots = this.getDots();
        slides.forEach((slide, i) => {
            slide.style.display = this.hide_mode;
            dots[i].className = dots[i].className.replace(this.active_mode, "");
            
        });
        return;

    }

    static getDots(){
        return document.getElementsByClassName(this.dot);
    }

    static getSlides(){
        return document.getElementsByClassName(this.slides);
    }

    static show(n) {
        /*
        Function that shows slide number n from the gallery.
        */
       
        let slides = this.getSlides()
        
        if (n > slides.length) {
            this.slideIndex = 1;
        }
        if (n < 1) {
            this.slideIndex = slides.length;
        }
        this.deactivate();
        this.activate(this.slideIndex-1);
        
        
    }
}

class SwipeDetector{

    static touchStartX = 0;
    static touchEndX = 0;
    static _classname = 'slideshow-container'

    static getDirection() {
        /*
        Function that determines horizontal direction of the swipe.
        reuturns: 0 for the left swipe; 1 for the right swipe
        */
        return this.touchendX > this.touchstartX;
      }

    static swipe(e, right){
        if (!this.isGallery(e)){
            return;
        }
        if (right==1){
            SlideManager.next(1)
        }
        else{

            return
        }

    }

    static isGallery(e){
        /*
        Function that checks whether the swiped element is a gallery.
        returns: control result, true if it is a gallery.
        */
        return e.target.parentElement.parentElement.className == this._classname;
    }

    static init(){
        document.addEventListener('touchstart', e => {
            this.touchstartX = e.changedTouches[0].screenX;
          });
          
        document.addEventListener('touchend', e => {
            this.touchendX = e.changedTouches[0].screenX;
            let dir = this.getDirection();
            this.swipe(e, dir)
        })
    }
}

SwipeDetector.init();