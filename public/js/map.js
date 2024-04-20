
const CLASSNAMES = {
    CATEGORY_PANEL: "categorypanel",
    CATEGORY_CONTAINER: "categorycontainer",
    CATEGORY_SLIDER_CONTAINER: "categoryslider",
    CATEGORY_HEADER: "categoryheader",
    CATEGORY_SWITCH: "categoryswitch",
    SLIDER: "slider",
    SLIDER_LABEL_CONTAINER: "sliderlabelcontainer",
    SLIDER_LABEL: "sliderlabel",
    TAG_CONTAINER: "tagcontainer",
    SUBCATEGORY_TAG: "subcategorytag",

}

const SLIDER_IDS = {
    LOW: "startSlider",
    HIGH: "endSlider"

}


class CategoryPanel{
    constructor(parent){
        this.name = CLASSNAMES.CATEGORY_PANEL;
        this.parent = parent ? parent : "body";
        this.id = "id";
    }

    load(categories) {
        for (let c=0; c<categories.length; c++){
            this.addCategory(categories[c]);
        }
    }

    addCategory(category){
        var div = new CategoryElement(this.make_id(), category);
        div.initiate();
        div.load();
    }

    getElement(){
        let elements = document.getElementsByClassName(this.name);
        if (elements.length > 0){
            return elements[0];
        }
        return this.initiate();
    }

    getParent(){
        let elements = document.getElementsByClassName(this.parent);
        if (elements.length>0){
            return elements[0];
        }
    }

    initiate(){
        let panel = document.createElement("div");
        panel.setAttribute('class', this.name);
        panel.setAttribute("id", this.make_id());
        this.getParent().appendChild(panel);
        return panel;
    }

    make_id(){
        return `${this.name}_${this.id}`
    }
}

class CategoryElement extends CategoryPanel{
    constructor(parent, id){
        super(parent);
        this.id = id;
        this.name = CLASSNAMES.CATEGORY_CONTAINER;
        this.parent = parent ? parent : CLASSNAMES.CATEGORY_PANEL;
        this.elements = [CategoryHeader, DoubleSlider, 
            SliderLabelContainer, SubcategoryTagContainer]
    }
    getParent(){
        let element = document.getElementById(this.parent);
        return element;
    }

    load(){
        for (let e=0; e<this.elements.length; e++){
            let element = new this.elements[e](this.make_id(), this.id);
            element.initiate();
            element.load();
        }
    }

    initiate() {
        let panel = document.createElement("div");
        panel.setAttribute('class', this.name);
        panel.setAttribute("id", this.make_id());
        this.getParent().appendChild(panel);
    }
}

class CategoryHeader extends CategoryElement{
    constructor(parent, id){
        super(parent);
        this.id = id;
        this.name = CLASSNAMES.CATEGORY_HEADER;
        this.parent = parent; //CLASSNAMES.CATEGORY_CONTAINER;
        this.elements = [CategoryLabel, CategorySwitch];
    }

    load(){
        for (let e=0; e<this.elements.length; e++){
            let element = new this.elements[e](this.make_id(), this.id);
            element.initiate();
        }
    }
}

class CategoryLabel extends CategoryElement{
    constructor(parent, id){
        super(parent);
        this.id = id;
        this.name = CLASSNAMES.CATEGORY_HEADER;
        this.parent = parent; //CLASSNAMES.CATEGORY_HEADER;
    }
    initiate() {
        let element = document.createElement("div");
        element.setAttribute('class', this.name);
        element.setAttribute("id", this.make_id());
        element.innerHTML = this.id;
        this.getParent().appendChild(element);
    }
}

class CategorySwitch extends CategoryElement{
    constructor(parent, id){
        super(parent);
        this.id = id;
        this.name = CLASSNAMES.CATEGORY_SWITCH;
        this.parent = parent; //CLASSNAMES.CATEGORY_HEADER;
    }

    initiate() {
        let element = document.createElement("label");
        element.setAttribute('class', this.name);
        element.setAttribute("id", this.make_id());
        this.getParent().appendChild(element);
        let e1 = document.createElement("input");
        e1.setAttribute("type", "checkbox");
        let e2 = document.createElement("span");
        element.appendChild(e1);
        element.appendChild(e2);
        
    }
}

class DoubleSlider extends CategoryElement{
    constructor(parent, id){
        super(parent);
        this.name = CLASSNAMES.CATEGORY_SLIDER_CONTAINER;
        this.parent = parent; //CLASSNAMES.CATEGORY_CONTAINER;
        this.id = id;
    }

    load(){
        let s1 = new Slider(this.make_id(), SLIDER_IDS.LOW);
        s1.initiate();

        let s2 = new Slider(this.make_id(), SLIDER_IDS.HIGH);
        s2.initiate();

        s1.limit(() => s1.controlSlider(s2, true));
        s2.limit(() => s2.controlSlider(s1, false))
    }

    initiate() {
        let panel = document.createElement("div");
        panel.setAttribute('class', this.name);
        panel.setAttribute("id", this.make_id());
        this.getParent().appendChild(panel);
    }
    
    static getParsed(currentFrom, currentTo) {
      const from = parseInt(currentFrom.value, 10);
      const to = parseInt(currentTo.value, 10);
      return [from, to];
    }
    
    fillSlider(from, to, sliderColor, rangeColor, controlSlider) {
        const rangeDistance = to.max-to.min;
        const fromPosition = from.value - to.min;
        const toPosition = to.value - to.min;
        controlSlider.style.background = `linear-gradient(
          to right,
          ${sliderColor} 0%,
          ${sliderColor} ${(fromPosition)/(rangeDistance)*100}%,
          ${rangeColor} ${((fromPosition)/(rangeDistance))*100}%,
          ${rangeColor} ${(toPosition)/(rangeDistance)*100}%, 
          ${sliderColor} ${(toPosition)/(rangeDistance)*100}%, 
          ${sliderColor} 100%)`;
    }
    
    setToggleAccessible(currentTarget) {
      const toSlider = document.querySelector('#toSlider');
      if (Number(currentTarget.value) <= 0 ) {
        toSlider.style.zIndex = 2;
      } else {
        toSlider.style.zIndex = 0;
      }
    }
}

class Slider extends CategoryElement{
    constructor(parent, id){
        super(parent);
        this.name = CLASSNAMES.SLIDER;
        this.parent = parent; //CLASSNAMES.CATEGORY_SLIDER_CONTAINER;
        this.id = id;
    }

    checkLimit(from, to){
        if (from > to){
            return false;
        }
        return true;
    }

    getElement(){
        return document.getElementById(this.make_id());
    }

    controlSlider(other, is_start) {
        const [from, to] = is_start? DoubleSlider.getParsed(this.getElement(), other.getElement()):
        DoubleSlider.getParsed(other.getElement(), this.getElement());
        
        //   fillSlider(fromSlider, toSlider, '#C6C6C6', '#25daa5', toSlider);
        
        if (!this.checkLimit(from, to) ){
            if (is_start==true){
                this.setValue(to);
            }
            else {
                console.log(this, from);
                this.setValue(from);
            }
        }
    }

    initiate(){
        let slider = document.createElement("input");
        slider.setAttribute("type", "range");
        slider.setAttribute("min", "0");
        slider.setAttribute("max", "100");
        slider.setAttribute("class", this.id.includes(SLIDER_IDS.HIGH) ? SLIDER_IDS.HIGH : SLIDER_IDS.LOW);
        slider.setAttribute("value", this.id.includes(SLIDER_IDS.HIGH) ? "60":"40");
        slider.setAttribute("id", this.make_id());
        this.getParent().appendChild(slider);
    }

    limit(f){
        console.log(this.getElement());
        this.getElement().oninput = f;
    }

    make_id(){
        return `${this.name}_${this.parent}_${this.id}`
    }

    setValue(value){
        this.getElement().value = value;
    }

}

class SliderLabelContainer extends CategoryElement{
    constructor(parent, id){
        super(parent);
        this.id = id;
        this.name = CLASSNAMES.SLIDER_LABEL_CONTAINER;
        this.parent = parent; //CLASSNAMES.CATEGORY_CONTAINER;
        this.elements = [SliderLabel, SliderLabel];
        this.labels = ["Low", "High"];
    }

    load(){
        for (let e=0; e<this.elements.length; e++){
            let element = new this.elements[e](this.make_id(), this.labels[e]);
            element.initiate();
        }
    }
}

class SliderLabel extends CategoryElement{
    constructor(parent, id){
        super(parent);
        this.id = id;
        this.name = CLASSNAMES.SLIDER_LABEL;
        this.parent = parent; //CLASSNAMES.SLIDER_LABEL_CONTAINER;
    }
    initiate() {
        let element = document.createElement("div");
        element.setAttribute('class', this.name);
        element.setAttribute("id", this.make_id());
        element.innerHTML = this.id;
        this.getParent().appendChild(element);
    }
}

class SubcategoryTagContainer extends CategoryElement{
    constructor(parent, id, tags){
        super(parent);
        this.id = id;
        this.name = CLASSNAMES.TAG_CONTAINER;
        this.parent = parent; //CLASSNAMES.CATEGORY_CONTAINER;
        this.labels = tags?tags : ["value1", "value2"];
    }

    load(){
        for (let e=0; e<this.labels.length; e++){
            let element = new SubcategoryTag(this.make_id(), this.labels[e]);
            element.initiate();
        }
    }
}

class SubcategoryTag extends CategoryElement{
    constructor(parent, id){
        super(parent);
        this.id = id;
        this.name = CLASSNAMES.SUBCATEGORY_TAG;
        this.parent = parent; //CLASSNAMES.TAG_CONTAINER;
    }

    initiate() {
        let element = document.createElement("label");
        element.setAttribute('class', this.name);
        element.setAttribute("id", this.make_id());
        this.getParent().appendChild(element);
        let e1 = document.createElement("input");
        e1.setAttribute("type", "checkbox");
        
        element.appendChild(e1);
        let e2 = document.createElement("span");
        e2.innerHTML = this.id;
        element.appendChild(e2);
        
    }
}
