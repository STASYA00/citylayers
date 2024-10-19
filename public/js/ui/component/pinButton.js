class PinButton extends CElement {
    
    constructor(parent, category) {
        super(parent, category);
        this.name = "pinButton";
        this.content = "Add a pin";
    }

    initiate() {
        var element = document.createElement("button");
        element.innerHTML = this.content;
        element.setAttribute('class', "" + this.name + " primary-button");
        element.setAttribute("id", this.make_id());
        this.getParent().appendChild(element);
        element.addEventListener("click", () => {
            console.log(CityLayersPanel.getCoords());
            let coords = CityLayersPanel.getCoords();
            window.location.href = `/pin?lat=${coords.lat}&lng=${coords.lng}`;
        });
    }
}