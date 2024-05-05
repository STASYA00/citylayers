
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

    CATEGORYPANEL_HEADER: "categorypanelheader",
    CATEGORYPANEL_LABEL: "categorypanellabel",
    CATEGORYPANEL_DESCR: "categorypaneldescr",

    CATEGORY_DESCRIPTION: "categorydescription",
    CATEGORY_SIDE_PANEL: "categorysidepanel",
    CATEGORY_SIDE_TAG_CONTAINER: "categorysidetagcontainer",
    CATEGORY_SIDE_TAG_CONTAINER_TITLE: "categorysidetagcontainertitle",
    CATEGORY_SIDE_TAG_CONTAINER_S: "categorysidetagcontainersmall",
    CATEGORY_SIDE_TAG: "categorysidetag",
    SIDEPANEL_CLOSE: "sidepanelclose",
    
}

const SLIDER_IDS = {
    LOW: "startSlider",
    HIGH: "endSlider"

}

class CElement{
    constructor(parent, id){
        this.id = id;
        this.name = CLASSNAMES.CATEGORY_CONTAINER;
        this.parent = parent;
        this.elements = []
    }

    getElement(){
        // let elements = document.getElementsByClassName(this.name);
        // if (elements.length > 0){
        //     return elements[0];
        // }
        return document.getElementById(`${this.name}_${this.id}`);
        // return this.initiate();
    }

    getParent(){
        let element = document.getElementById(this.parent);
        return element;
    }

    

    initiate() {
        let panel = document.createElement("div");
        panel.setAttribute('class', this.name);
        panel.setAttribute("id", this.make_id());
        this.getParent().appendChild(panel);
    }

    load(){
        for (let e=0; e<this.elements.length; e++){
            let element = new this.elements[e](this.make_id(), this.id);
            element.initiate();
            element.load();
        }
    }
    make_id(){
        return `${this.name}_${this.id}`
    }
}

class Logo extends CElement{
    constructor(parent, category){
        super(parent, category);
        this.name = "logo";
        this.content = "images/logo_2.svg"; // U+02715
    }

    initiate() {
        var element = document.createElement("img");
        element.src = this.content;
        element.setAttribute('class', this.name);
        element.setAttribute("id", this.make_id());
        this.getParent().appendChild(element);
    }
}

class CategoryPanelHeader extends CElement{
    constructor(parent, id){
        super(parent);
        this.id = id;
        this.name = CLASSNAMES.CATEGORYPANEL_HEADER;
        // this.parent = parent; //CLASSNAMES.CATEGORY_CONTAINER;
        this.elements = [CategoryPanelLabel, CategoryPanelDescr];
    }

    load(){
        for (let e=0; e<this.elements.length; e++){
            let element = new this.elements[e](this.make_id(), this.id);
            element.initiate();
        }
    }
}

class CategoryPanelLabel extends CElement{
    constructor(parent, id){
        super(parent);
        this.id = id;
        this.name = CLASSNAMES.CATEGORYPANEL_LABEL;
        this.parent = parent; //CLASSNAMES.CATEGORY_HEADER;
        this.content = "Explore and compare layers";
    }
    initiate() {
        let element = document.createElement("div");
        element.setAttribute('class', this.name);
        element.setAttribute("id", this.make_id());
        element.innerHTML = this.content;
        this.getParent().appendChild(element);
    }
}

class CategoryPanelDescr extends CElement{
    constructor(parent, id){
        super(parent);
        this.id = id;
        this.name = CLASSNAMES.CATEGORYPANEL_DESCR;
        this.parent = parent; //CLASSNAMES.CATEGORY_HEADER;
        this.content = "Activate and adjust the ranges of \
                the various categories below in order to visualise \
                them in the space."
    }
    initiate() {
        let element = document.createElement("div");
        element.setAttribute('class', this.name);
        element.setAttribute("id", this.make_id());
        element.innerHTML = this.content;
        this.getParent().appendChild(element);
    }
}

class CategoryPanel extends CElement{
    constructor(parent){
        super(parent, "id");
        this.name = CLASSNAMES.CATEGORY_PANEL;
        this.parent = parent ? parent : "body";
        this.id = "id";
        this.elements = [Logo, CategoryPanelHeader];
    }

    load(categories) {
        this.elements.forEach(el =>{
            let element = new el(this.make_id(), "main");
            element.initiate();
            element.load();
        });
        categories.forEach(category =>{
            this.addCategory(category);
        });
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

    
}

class CategoryElement extends CElement{
    constructor(parent, category){
        console.log(category);
        super(parent, category.name);
        this.content = category
        this.name = CLASSNAMES.CATEGORY_CONTAINER;
        this.parent = parent ? parent : CLASSNAMES.CATEGORY_PANEL;
        this.elements = [CategoryHeader, 
                         DoubleSlider, 
                         SliderLabelContainer, 
                         SubcategoryTagContainer,
                         CategorySidePanel
                        ]
    }
    getParent(){
        let element = document.getElementById(this.parent);
        return element;
    }

    load(){
        for (let e=0; e<this.elements.length; e++){
            let element = 0;
            
            if (this.elements[e]==CategorySidePanel){
                element = new this.elements[e](this.make_id(), 
                                    this.content);
            }
            else{
                element = new this.elements[e](this.make_id(), 
                                    this.id, this.content.subcategories);
            }
            
            element.initiate();
            element.load();
        }
    }

    initiate() {
        let panel = document.createElement("div");
        panel.setAttribute('class', this.name);
        panel.setAttribute("id", this.make_id());
        panel.onclick = ()=>{CategorySidePanel.toggleSide(this.id);};
        this.getParent().appendChild(panel);
    }
}

class CategorySidePanel extends CElement{
    constructor(parent, category){
        super(parent, category.id);
        console.log(this.id);
        this.id = category.name;
        this.parent = "body";
        this.name = CLASSNAMES.CATEGORY_SIDE_PANEL;
        this.content = category;
        
        this.elements = [CategorySidePanelCloseButton,
                         CategoryDescription,
                         CategorySidePanelTagContainer
        ];
    }

    getParent(){
        let elements = document.getElementsByClassName(this.parent);
        if (elements.length>0){
            return elements[0];
        }
    }

    load(){
        for (let e=0; e<this.elements.length; e++){
            let element = new this.elements[e](this.make_id(), this.content);
            element.initiate();
            element.load();
        }
        
        this.getElement().style.display = "none";
    }

    static toggleSide(category){
        let sidePanel = document.getElementById(`${CLASSNAMES.CATEGORY_SIDE_PANEL}_${category}`);
        console.log(sidePanel.style.display);
        if (sidePanel.style.display==="none"){
            this.hideAll();
        }
        sidePanel.style.display = sidePanel.style.display === "none" ? "flex" : "none";
    }

    static hideAll(){
        let panels = document.getElementsByClassName(CLASSNAMES.CATEGORY_SIDE_PANEL);
        Array.from(panels).forEach(panel => {
            panel.style.display = "none";
        })
    }
}

class CategorySidePanelTagContainer extends CElement{
    constructor(parent, category){
        super(parent, category.id);
        this.name = CLASSNAMES.CATEGORY_SIDE_TAG_CONTAINER;
        this.content = category;
        // this.parent = parent; //CLASSNAMES.CATEGORY_CONTAINER;
        this.elements = [
                         HorizontalDivider,
                         CategorySidePanelTagTitle, 
                         CategorySidePanelTagContainerS];
    }

    load(){
        for (let e=0; e<this.elements.length; e++){
            let element = new this.elements[e](this.make_id(), this.content);
            element.initiate();
            element.load();
        }
    }
}

class CategoryDescription extends CElement{
    constructor(parent, category){
        super(parent, category.id);
        this.name = CLASSNAMES.CATEGORY_DESCRIPTION;
        this.content = category.description;
    }

    load(){ }
    
    initiate() {
        let element = document.createElement("div");
        element.setAttribute('class', this.name);
        element.setAttribute("id", this.make_id());
        element.innerHTML = this.content;
        this.getParent().appendChild(element);
    }
}

class CategorySidePanelCloseButton extends CElement{
    constructor(parent, category){
        super(parent, category.name);
        this.name = CLASSNAMES.SIDEPANEL_CLOSE;
        this.content = "✕"; // U+02715
    }

    initiate() {
        let element = document.createElement("button");
        element.setAttribute('class', this.name);
        element.setAttribute("id", this.make_id());
        element.innerHTML = this.content;
        element.onclick = ()=>{CategorySidePanel.toggleSide(this.id);};
        this.getParent().appendChild(element);
    }
}

class CategorySidePanelTagTitle extends CElement{
    constructor(parent, category){
        super(parent, category.name);
        this.name = CLASSNAMES.CATEGORY_SIDE_TAG_CONTAINER_TITLE;
        this.content = "⋁ Display tags"; // U+022C1  // keyboard_arrow_down 
        // https://materialui.co/icon/keyboard-arrow-down
        // <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg>
    }

    initiate() {
        let element = document.createElement("button");
        element.setAttribute('class', this.name);
        element.setAttribute("id", this.make_id());
        element.onclick = ()=>{CategorySidePanel.toggleSide(this.id);};
        element.innerHTML = this.content;
        // element.style.display = "none";
        this.getParent().appendChild(element);
    }
}

class HorizontalDivider extends CElement{
    constructor(parent, category){
        super(parent, category.id);
    }

    load(){}

    initiate() {
        let element = document.createElement("hr");
        this.getParent().appendChild(element);
    }
}

class CategorySidePanelTagContainerS extends CElement{
    constructor(parent, category){
        super(parent, category.name);
        this.name = CLASSNAMES.CATEGORY_SIDE_TAG_CONTAINER_S;
        this.content = category;
        // this.parent = parent; //CLASSNAMES.CATEGORY_CONTAINER;
        this.elements = [CategoryLabel, CategorySwitch];
    }

    load(){
        this.content.subcategories.forEach(subcat=>{
            let element = new SubcategoryTag(this.make_id(), subcat);
            element.initiate();
        });
    }
}

class CategoryHeader extends CElement{
    constructor(parent, id){
        super(parent);
        this.id = id;
        this.name = CLASSNAMES.CATEGORY_HEADER;
        // this.parent = parent; //CLASSNAMES.CATEGORY_CONTAINER;
        this.elements = [CategoryLabel, CategorySwitch];
    }

    load(){
        for (let e=0; e<this.elements.length; e++){
            let element = new this.elements[e](this.make_id(), this.id);
            element.initiate();
        }
    }
}

class CategoryLabel extends CElement{
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

class CategorySwitch extends CElement{
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

class DoubleSlider extends CElement{
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

class Slider extends CElement{
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
        slider.setAttribute("value", this.id.includes(SLIDER_IDS.HIGH) ? "60" : "40");
        slider.setAttribute("id", this.make_id());
        this.getParent().appendChild(slider);
    }

    limit(f){
        
        this.getElement().oninput = f;
    }

    make_id(){
        return `${this.name}_${this.parent}_${this.id}`
    }

    setValue(value){
        this.getElement().value = value;
    }

}

class SliderLabelContainer extends CElement{
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

class SliderLabel extends CElement{
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

class SubcategoryTagContainer extends CElement{
    static cname = CLASSNAMES.TAG_CONTAINER
    constructor(parent, id){
        super(parent, id);
        this.name = CLASSNAMES.TAG_CONTAINER;
        this.parent = parent; //CLASSNAMES.CATEGORY_CONTAINER;
    }

    load(labels){
        if (labels==undefined){
            labels = [];
        }
        labels.forEach(label=>{
            let element = new SubcategoryTag(this.make_id(), label);
            element.initiate();
        });
    }

    static getByCategory(category){
        return document.getElementById(`${this.cname}_${category}`)
    }

    static addLabel(category, label){
        let togglable = false;
        let element = new SubcategoryTag(`${this.cname}_${category}`, label);
        element.initiate(togglable);

    }
}

class SubcategoryTag extends CElement{
    constructor(parent, tag){
        super(parent, tag.name);
        if (tag.name==undefined){
            this.id = tag;
        }
        this.name = CLASSNAMES.SUBCATEGORY_TAG;
        this.parent = parent; //CLASSNAMES.TAG_CONTAINER;
    }

    toggle(){
        let _cname = this.getParent().parentElement.parentElement.className;
        let _id = this.getParent().parentElement.parentElement.id;
        let category = _id.replace(`${_cname}_`, "");
        let new_id = `${this.name}_${this.id}`;

        let container = SubcategoryTagContainer.getByCategory(category);
        let existing_ids = Array.from(container.children).map(el=>el.id);
        
        if (existing_ids.includes(new_id)){
            document.getElementById(new_id).remove();
        }
        else{
            SubcategoryTagContainer.addLabel(category, this.id);
        }
        
    }

    initiate(togglable) {
        togglable = togglable==undefined ? true: togglable;

        let element = document.createElement("label");
        element.setAttribute('class', this.name);
        element.setAttribute("id", this.make_id());
        this.getParent().appendChild(element);
        let e1 = document.createElement("input");
        e1.setAttribute("type", "checkbox");

        if (togglable==true){
            e1.onclick = ()=>{this.toggle();};
        }
        

        element.appendChild(e1);
        let e2 = document.createElement("span");
        e2.innerHTML = this.id;
        element.appendChild(e2);
        
    }
}
