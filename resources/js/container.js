const CLASSNAMES = {
    LOGO : "logo",
    CLOSE: "closebutton",

    CATEGORY_PANEL: "categorypanel",
    CATEGORY_CONTAINER: "categorycontainer",
    CATEGORY_SLIDER_CONTAINER: "categoryslider",
    CATEGORY_HEADER: "categoryheader",
    CATEGORY_HEADER_TITLE: "categoryheadertitle",
    CATEGORY_SWITCH: "categoryswitch",
    SLIDER: "slider",
    SLIDER_LABEL_CONTAINER: "sliderlabelcontainer",
    SLIDER_LABEL: "sliderlabel",
    TAG_CONTAINER: "tagcontainer",
    SUBCATEGORY_TAG: "tag",

    CATEGORYPANEL_HEADER: "categorypanelheader",
    CATEGORYPANEL_LABEL: "categorypanellabel",
    CATEGORYPANEL_DESCR: "categorypaneldescr",

    CATEGORY_DESCRIPTION: "categorydescription",
    CATEGORY_SIDE_PANEL: "categorysidepanel",
    CATEGORY_SIDE_TAG_CONTAINER: "categorysidetagcontainer",
    CATEGORY_SIDE_TAG_CONTAINER_TITLE: "categorysidetagcontainertitle",
    CATEGORY_SIDE_TAG_CONTAINER_S: "categorysidetagcontainersmall",
    CATEGORY_SIDE_TAG: "categorysidetag",
    // SIDEPANEL_CLOSE: "sidepanelclose",

    GEOCODONG_PANEL: "geopanel",
    ABOUT_LABEL: "aboutlabel",
    ABOUT_PANEL: "aboutpanel",
    // ABOUTPANEL_CLOSE: "aboutpanelclose",
    ABOUT_DESCRIPTION: "aboutdescription",
    ABOUT_TEXT: "abouttext",

    COMMENTPANEL: "commentpanel",
    COMMENTCONTAINER: "commentcontainer",
    COMMENTPANE: "commentpane",
    COMMENTSYMBOL: "commentsymbol",
    COMMENTTEXT: "commenttext",
    COMMENTPANEL_CLOSE: "commentpanelclose",
    COMMENTSEARCH: "commentsearch",
    SELECTCOMMENT: "selected",

}

const SLIDER_IDS = {
    LOW: "startSlider",
    HIGH: "endSlider"

}

class CElement {
    constructor(parent, id) {
        this.id = id ? id : "id";
        this.name = CLASSNAMES.CATEGORY_CONTAINER;
        this.parent = parent;
        this.elements = []
    }

    getElement() {
        // let elements = document.getElementsByClassName(this.name);
        // if (elements.length > 0){
        //     return elements[0];
        // }
        return document.getElementById(`${this.name}_${this.id}`);
        // return this.initiate();
    }

    getParent() {
        let element = document.getElementById(this.parent);
        return element;
    }



    initiate() {
        let panel = document.createElement("div");
        panel.setAttribute('class', this.name);
        panel.setAttribute("id", this.make_id());
        this.getParent().appendChild(panel);
    }

    load() {
        for (let e = 0; e < this.elements.length; e++) {
            let element = new this.elements[e](this.make_id(), this.id);
            element.initiate();
            element.load();
        }
    }
    make_id() {
        return `${this.name}_${this.id}`
    }
}



class CategoryPanel extends CElement{
    markertoggle = ()=>{console.log("No action assigned")}; // callback to toggle markers
    activation = ()=>{}; // callback to activate observations' categories or to filter observations
    getCoords = ()=>{}; // callback to get current coordinates

    constructor(parent){
        super(parent, "id");
        this.name = CLASSNAMES.CATEGORY_PANEL;
        this.parent = parent ? parent : "body";
        this.id = "id";
        this.elements = [Logo, CategoryPanelHeader, PinButton];
    }

    load(categories) {
        this.elements.forEach(el => {
            let element = new el(this.make_id(), "main");
            element.initiate();
            element.load();
        });
        categories.forEach((category, c) => {
            this.addCategory(category);
            document.body.style.setProperty(`--category${c+1}`, `#${category.color}`);
        });
    }


    addCategory(category) {
        let div = new CategoryElement(this.make_id(), category);

        div.initiate();
        div.load();
    }

    getElement() {
        let elements = document.getElementsByClassName(this.name);
        if (elements.length > 0) {
            return elements[0];
        }
        return this.initiate();
    }

    getParent() {
        let elements = document.getElementsByClassName(this.parent);
        if (elements.length > 0) {
            return elements[0];
        }
    }

    initiate() {
        let panel = document.createElement("div");
        panel.setAttribute('class', this.name);
        panel.setAttribute("id", this.make_id());
        this.getParent().appendChild(panel);
        return panel;
    }
}

/*
    ------------------------------------------------------

    Panel Header elements

    ------------------------------------------------------

*/

class CategoryPanelHeader extends CElement {
    constructor(parent, id) {
        super(parent);
        this.id = id;
        this.name = CLASSNAMES.CATEGORYPANEL_HEADER;
        // this.parent = parent; //CLASSNAMES.CATEGORY_CONTAINER;
        this.elements = [CategoryPanelLabel, CategoryPanelDescr];
    }

    load() {
        for (let e = 0; e < this.elements.length; e++) {
            let element = new this.elements[e](this.make_id(), this.id);
            element.initiate();
        }
    }
}


class Logo extends CElement {
    constructor(parent, category) {
        super(parent, category);
        this.name = CLASSNAMES.LOGO;
        this.content = "images/logo_2.svg"; // U+02715
    }

    initiate() {
        var el = document.createElement("a");
        el.href = "/";
        this.getParent().appendChild(el);
        var element = document.createElement("img");
        element.src = this.content;
        element.setAttribute('class', this.name);
        element.setAttribute("id", this.make_id());
        // element.onclick = ()=>{};
        el.appendChild(element);
    }
}

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
            console.log(CategoryPanel.getCoords());
            let coords = CategoryPanel.getCoords();
            window.location.href = `/pin?lat=${coords.lat}&lng=${coords.lng}`;
        });
    }
}

class CategoryPanelLabel extends CElement {
    constructor(parent, id) {
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

class CategoryPanelDescr extends CElement {
    constructor(parent, id) {
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

/*
    ------------------------------------------------------

    Category Container and its elements

    ------------------------------------------------------

*/


class CategoryElement extends CElement{
    constructor(parent, category){
        super(parent, category.name);
        this.content = category;
        this.name = CLASSNAMES.CATEGORY_CONTAINER;
        this.parent = parent ? parent : CLASSNAMES.CATEGORY_PANEL;
        this.elements = [
            CategoryHeader,
            DoubleSlider,
            SliderLabelContainer,
            SubcategoryTagContainer,
            CategorySidePanel
        ]
    }
    getParent() {
        let element = document.getElementById(this.parent);
        return element;
    }

    load() {
        for (let e = 0; e < this.elements.length; e++) {
            let element = 0;

            switch (this.elements[e]) {
                case (CategorySidePanel):
                    element = new this.elements[e](this.make_id(),
                        this.content);
                    element.parent = "right-container";
                    break;

                case (CategoryHeader): 
                    element = new this.elements[e](this.make_id(), 
                                    this.id, this.content);
                    break;
                case (DoubleSlider):
                    element = new this.elements[e](this.make_id(), 
                                    this.id, this.content);
                    break;
                case (SliderLabelContainer):
                    element = new this.elements[e](this.make_id(), 
                                    this.id, this.content);
                    break;
                default:
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

        this.getParent().appendChild(panel);
    }
}


class CategoryHeader extends CElement{
    constructor(parent, id, category){

        super(parent);
        this.id = id;
        this.name = CLASSNAMES.CATEGORY_HEADER;
        this.category = category;
        // this.parent = parent; //CLASSNAMES.CATEGORY_CONTAINER;
        this.elements = [CategoryInfo, 
            CategoryLabel, CategorySwitch];
    }


    load(){
        for (let e=0; e<this.elements.length; e++){
            let element = new this.elements[e](this.make_id(), this.id, this.category);

            element.initiate();
        }
    }
}


class CategoryLabel extends CElement{
    constructor(parent, id, name){

        super(parent);
        this.id = id;
        this.name = name? name :CLASSNAMES.CATEGORY_HEADER_TITLE;
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
    constructor(parent, id, category){

        super(parent);
        this.id = id;
        this.name = CLASSNAMES.CATEGORY_SWITCH;
        this.category = category;
        this.parent = parent; //CLASSNAMES.CATEGORY_HEADER;
    }

    static isActive(category) {
        let d = document.getElementById(`categoryswitch_${category}`);
        return d.children[0].checked;
    }

    initiate() {
        let element = document.createElement("label");
        element.setAttribute('class', this.name);
        element.setAttribute("id", this.make_id());
        this.getParent().appendChild(element);
        let e1 = document.createElement("input");
        e1.setAttribute("type", "checkbox");

        e1.onchange = ()=>{
            CategoryPanel.activation(this.category, 
                            CategorySwitch.isActive(this.id) ? DoubleSlider.getCurrentValue(this.id).min : 0, 
                            CategorySwitch.isActive(this.id) ? DoubleSlider.getCurrentValue(this.id).max : 0);
            DoubleSlider.activate(this.id, CategorySwitch.isActive(this.id));

        }
        let e2 = document.createElement("span");
        element.appendChild(e1);
        element.appendChild(e2);

    }
}


class CategoryInfo extends CElement{
    constructor(parent, id, category){
        super(parent, id);
        this.name = "material-symbols-outlined";
        this.content = "info"; 
        this.id = id;
        this.category = category;
    }

    initiate() {
        var element = document.createElement("span");
        element.innerHTML = this.content;
        element.setAttribute('class', this.name);
        element.onclick = ()=>{
             CategorySidePanel.toggle(this.category);            
        };
        this.getParent().appendChild(element);
    }
}

class DoubleSlider extends CElement{
    constructor(parent, id, category){

        super(parent);
        this.name = CLASSNAMES.CATEGORY_SLIDER_CONTAINER;
        this.parent = parent; //CLASSNAMES.CATEGORY_CONTAINER;
        this.category = category;
        this.id = id;
    }


    static activate(category, value){
        let id = `categoryslider_${category}`;
        
        Slider.activate(`${id}_${SLIDER_IDS.LOW}` ,value);
        Slider.activate(`${id}_${SLIDER_IDS.HIGH}` ,value);

    }

    load(){

        let s1 = new Slider(this.make_id(), SLIDER_IDS.LOW);
        s1.initiate();

        let s2 = new Slider(this.make_id(), SLIDER_IDS.HIGH);
        s2.initiate();


        s1.limit(() => {s1.controlSlider(s2, true); 
            CategoryPanel.activation(this.category, 
                CategorySwitch.isActive(this.id) ? s1.getValue(): 0, 
                CategorySwitch.isActive(this.id) ? s2.getValue() : 0);
        });
        s2.limit(() => {s2.controlSlider(s1, false); 
            CategoryPanel.activation(this.category, 
                CategorySwitch.isActive(this.id) ? s1.getValue(): 0, 
                CategorySwitch.isActive(this.id) ? s2.getValue() : 0);
        });
        DoubleSlider.activate(this.id, false);

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

    static getCurrentValue(category) {
        let d = document.getElementById(`categoryslider_${category}`)
        return { "min": d.children[0].value, "max": d.children[1].value };
    }

    fillSlider(from, to, sliderColor, rangeColor, controlSlider) {
        const rangeDistance = to.max - to.min;
        const fromPosition = from.value - to.min;
        const toPosition = to.value - to.min;
        controlSlider.style.background = `linear-gradient(
          to right,
          ${sliderColor} 0%,
          ${sliderColor} ${(fromPosition) / (rangeDistance) * 100}%,
          ${rangeColor} ${((fromPosition) / (rangeDistance)) * 100}%,
          ${rangeColor} ${(toPosition) / (rangeDistance) * 100}%, 
          ${sliderColor} ${(toPosition) / (rangeDistance) * 100}%, 
          ${sliderColor} 100%)`;
    }

    setToggleAccessible(currentTarget) {
        const toSlider = document.querySelector('#toSlider');
        if (Number(currentTarget.value) <= 0) {
            toSlider.style.zIndex = 2;
        } else {
            toSlider.style.zIndex = 0;
        }
    }
}

class Slider extends CElement {
    constructor(parent, id) {
        super(parent);
        this.name = CLASSNAMES.SLIDER;
        this.parent = parent; //CLASSNAMES.CATEGORY_SLIDER_CONTAINER;
        this.id = id;
    }

    checkLimit(from, to) {
        if (from > to) {
            return false;
        }
        return true;
    }

    getElement() {
        return document.getElementById(this.make_id());
    }

    static activate(id, value){
        let res = value==undefined || value == true ? false : true;
        document.getElementById(`${CLASSNAMES.SLIDER}_${id}`).disabled = res;
    }

    controlSlider(other, is_start) {
        const [from, to] = is_start ? DoubleSlider.getParsed(this.getElement(), other.getElement()) :
            DoubleSlider.getParsed(other.getElement(), this.getElement());

        //   fillSlider(fromSlider, toSlider, '#C6C6C6', '#25daa5', toSlider);

        if (!this.checkLimit(from, to)) {
            if (is_start == true) {
                this.setValue(to);
            }
            else {
                this.setValue(from);
            }
        }
    }

    initiate() {
        let slider = document.createElement("input");
        slider.setAttribute("type", "range");
        slider.setAttribute("min", "0");
        slider.setAttribute("max", "100");
        slider.setAttribute("class", this.id.includes(SLIDER_IDS.HIGH) ? SLIDER_IDS.HIGH : SLIDER_IDS.LOW);
        slider.setAttribute("value", this.id.includes(SLIDER_IDS.HIGH) ? "100" : "0");
        slider.setAttribute("id", this.make_id());
        this.getParent().appendChild(slider);
    }

    limit(f) {

        this.getElement().oninput = f;
    }

    make_id() {
        return `${this.name}_${this.parent}_${this.id}`
    }

    getValue() {
        return this.getElement().value;
    }

    setValue(value) {
        this.getElement().value = value;
    }

}

class SliderLabelContainer extends CElement {
    constructor(parent, id, category) {
        super(parent);
        this.id = id;
        this.name = CLASSNAMES.SLIDER_LABEL_CONTAINER;
        this.parent = parent; //CLASSNAMES.CATEGORY_CONTAINER;
        this.elements = [SliderLabel, SliderLabel];
        this.labels = [category.low, category.high];
    }

    load() {
        for (let e = 0; e < this.elements.length; e++) {
            let element = new this.elements[e](this.make_id(), this.labels[e]);
            element.initiate();
        }
    }
}

class SliderLabel extends CElement {
    constructor(parent, id) {
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

class SubcategoryTagContainer extends CElement {
    static cname = CLASSNAMES.TAG_CONTAINER
    constructor(parent, id) {
        super(parent, id);
        this.name = CLASSNAMES.TAG_CONTAINER;
        this.parent = parent; //CLASSNAMES.CATEGORY_CONTAINER;
    }

    load(labels) {
        if (labels == undefined) {
            labels = [];
        }
        labels.forEach(label => {
            let element = new SubcategoryTag(this.make_id(), label);
            element.initiate();
        });
    }

    static getByCategory(category) {
        return document.getElementById(`${this.cname}_${category}`)
    }

    static addLabel(category, label, togglable) {
        togglable = false;
        let element = new SubcategoryTag(`${this.cname}_${category}`, label);
        element.initiate(togglable);

    }
}

class SubcategoryTag extends CElement {
    constructor(parent, tag) {
        super(parent, tag.name);
        if (tag.name == undefined) {
            this.id = tag;
        }
        this.subcat_id = tag.id;
        this.name = CLASSNAMES.SUBCATEGORY_TAG;
        this.parent = parent; //CLASSNAMES.TAG_CONTAINER;
    }

    toggle() {
        let _cname = this.getParent().parentElement.parentElement.className;
        let _id = this.getParent().parentElement.parentElement.id;
        let category = _id.replace(`${_cname}_`, "");
        let new_id = `${this.name}_${this.id}`;

        let container = SubcategoryTagContainer.getByCategory(category);
        let existing_ids = Array.from(container.children).map(el => el.id);

        if (existing_ids.includes(new_id)) {
            document.getElementById(new_id).remove();
        }
        else {
            SubcategoryTagContainer.addLabel(category, this.id, true);
        }
        CategoryPanel.markertoggle(this.subcat_id, !existing_ids.includes(new_id));
    }

    initiate(togglable) {
        togglable = togglable == undefined ? true : togglable;
        let element = document.createElement("div");
        element.setAttribute('class', CLASSNAMES.SUBCATEGORY_TAG);
        element.setAttribute("id", this.make_id());
        this.getParent().appendChild(element);
        let e1 = document.createElement("input");
        e1.setAttribute("type", "checkbox");
        let e2 = document.createElement("div");
        e2.setAttribute("class", "tag-element");
        let label = document.createElement("label");
        label.innerHTML = this.id;
        e2.appendChild(label);
        element.appendChild(e1);
        element.appendChild(e2);

        if (togglable == true) {
            e1.onclick = () => { this.toggle(); }
        }
        else {
            e1.setAttribute("disabled", "true");
        }
    }
}



/*
    ------------------------------------------------------

    Category Side Panel and its elements

    ------------------------------------------------------

*/

class CategorySidePanel extends CElement {
    constructor(parent, category) {
        super(parent, category.id);
        this.id = category.name;
        this.parent = parent ? parent : "body";
        this.name = CLASSNAMES.CATEGORY_SIDE_PANEL;
        this.content = category;

        this.elements = [CloseButton,
            CategoryDescription,
            CategorySidePanelTagContainer
        ];
        
        this.args = [() => { CategorySidePanel.toggle(category); }]
    }

    getParent() {
        let elements = document.getElementsByClassName(this.parent);
        if (elements.length > 0) {
            return elements[0];
        }
    }

    load() {
        for (let e = 0; e < this.elements.length; e++) {
            let element = new this.elements[e](this.make_id(), this.content, e<this.args.length?this.args[e]:undefined);
            element.initiate();
            element.load();
        }

        this.getElement().style.display = "none";
    }

    static toggle(category) {
        let sidePanel = document.getElementById(`${CLASSNAMES.CATEGORY_SIDE_PANEL}_${category.name}`);
        let container = document.getElementById(`${CLASSNAMES.CATEGORY_CONTAINER}_${category.name}`);
        if (sidePanel.style.display === "none") {
            this.hideAll();
        }
        container.classList.toggle("simple-drop-shadow");
        sidePanel.style.display = sidePanel.style.display === "none" ? "flex" : "none";
        document.body.style.setProperty(`--side-panel-color`, `#${category.color}`);
        console.log(document.body.style.getPropertyValue("--side-panel-color"));
    }

    static hideAll() {
        let panels = document.getElementsByClassName(CLASSNAMES.CATEGORY_SIDE_PANEL);
        let containers = document.getElementsByClassName(CLASSNAMES.CATEGORY_CONTAINER);
        Array.from(panels).forEach(panel => {
        })
        for (let i = 0; i < panels.length; i++) {
            panels[i].style.display = "none";
            containers[i].classList.remove("simple-drop-shadow");            
        }
    }
}

class CategorySidePanelTagContainer extends CElement {
    constructor(parent, category) {
        super(parent, category.id);
        this.name = CLASSNAMES.CATEGORY_SIDE_TAG_CONTAINER;
        this.content = category;
        // this.parent = parent; //CLASSNAMES.CATEGORY_CONTAINER;
        this.elements = [
            HorizontalDivider,
            CategorySidePanelTagTitle,
            CategorySidePanelTagContainerS];
    }

    load() {
        for (let e = 0; e < this.elements.length; e++) {
            let element = new this.elements[e](this.make_id(), this.content);
            element.initiate();
            element.load();
        }
    }
}

class CategoryDescription extends CElement {
    constructor(parent, category) {
        super(parent, category.id);
        this.name = CLASSNAMES.CATEGORY_DESCRIPTION;
        this.content = category.description;
    }

    load() { }

    initiate() {
        let element = document.createElement("div");
        element.setAttribute('class', this.name);
        element.setAttribute("id", this.make_id());
        element.innerHTML = this.content; //emoji.emojify(this.content);
        this.getParent().appendChild(element);
    }
}

class CloseButton extends CElement {
    constructor(parent, category, onclick) {
        super(parent, category ? category.name : "id");
        this.name = CLASSNAMES.CLOSE;
        this.content = "✕"; // U+02715
        this.onclick = onclick ? onclick : () => { CategorySidePanel.toggle(category) };
    }

    initiate() {
        let element = document.createElement("button");
        element.setAttribute('class', this.name);
        element.setAttribute("id", this.make_id());
        element.innerHTML = this.content;
        element.onclick = this.onclick;
        this.getParent().appendChild(element);
    }
}

class CategorySidePanelTagTitle extends CElement {
    constructor(parent, category) {
        super(parent, category.name);
        this.category = category;
        this.name = CLASSNAMES.CATEGORY_SIDE_TAG_CONTAINER_TITLE;
        this.content = "Filter by tags"; // U+022C1  // keyboard_arrow_down 
        // https://materialui.co/icon/keyboard-arrow-down
        // <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"/></svg>
    }

    initiate() {
        let element = document.createElement("button");
        element.setAttribute('class', this.name);
        element.setAttribute("id", this.make_id());
        element.onclick = () => { CategorySidePanel.toggle(this.category); };
        element.innerHTML = this.content;
        // element.style.display = "none";
        this.getParent().appendChild(element);
    }
}

class HorizontalDivider extends CElement {
    constructor(parent, category) {
        super(parent, category.id);
    }

    load() { }

    initiate() {
        let element = document.createElement("hr");
        this.getParent().appendChild(element);
    }
}

class CategorySidePanelTagContainerS extends CElement {
    constructor(parent, category) {
        super(parent, category.name);
        this.name = CLASSNAMES.CATEGORY_SIDE_TAG_CONTAINER_S;
        this.content = category;
        // this.parent = parent; //CLASSNAMES.CATEGORY_CONTAINER;
        this.elements = [CategoryLabel, CategorySwitch];
    }

    load() {
        this.content.subcategories.forEach(subcat => {
            let element = new SubcategoryTag(this.make_id(), subcat);
            element.initiate();
        });
    }
}

class TopTagPanel extends CElement {
    constructor(parent) {
        super(parent);
        this.id = "geocodingpanelid";
        this.parent = parent ? parent : "body";
        this.name = CLASSNAMES.GEOCODONG_PANEL;
        this.content = "";

        this.elements = [];
    }

    getParent() {
        let elements = document.getElementsByClassName(this.parent);
        if (elements.length > 0) {
            return elements[0];
        }
    }

    static getUrl(lat, lon) {
        console.log(lat, lon);
        return `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=jsonv2&zoom=12`
    }

    initiate() {
        let element = document.createElement("div");
        element.setAttribute('class', this.name);
        element.setAttribute("id", this.make_id());
        element.innerHTML = this.content; //emoji.emojify(this.content);
        this.getParent().appendChild(element);
    }

    load() {
        if (navigator) {
            if (navigator.geolocation) {
                return navigator.geolocation.getCurrentPosition(this._call);
            }
        }
        console.log("Geoposition undefined");
    }

    _call(geo) {

        let url = TopTagPanel.getUrl(geo.coords.latitude, geo.coords.longitude);
        console.log(url);
        // fetch(url, )

        return fetch(url, {
            method: "GET",
            headers: { 'Content-Type': 'application/json' },
        }).then(result => {
            if (result.status == 200) {
                return result.json().then(res => {
                    document.getElementsByClassName(CLASSNAMES.GEOCODONG_PANEL)[0].innerHTML = GeocodeParser.run(res);
                    return res;
                });
            }
            else if (result.status == 429) {
                return sleep(1000).then(r => { return this.request() });
            }
            else if (result.status == 504) {
                return this.request();
            }
            else {
                console.log(`CODE: ${result.status}`);
            }
            return result;
        });
    }
}

class GeocodeParser {

    static run(response) {
        let res = response["address"];
        if ("city" in res) {
            return `${res["country"]}, ${res["city"]}`;
        }
        else if ("town" in res) {
            return `${res["country"]}, ${res["town"]}`;
        }
        else {
            return `${res["country"]}`;
        }
    }
}

class AboutLabel extends CElement {
    constructor(parent) {
        super(parent);
        this.id = "aboutlabelid";
        this.parent = parent ? parent : "body";
        this.name = CLASSNAMES.ABOUT_LABEL;
        this.content = "about";

        this.elements = [];
    }

    getParent() {
        let elements = document.getElementsByClassName(this.parent);
        if (elements.length > 0) {
            return elements[0];
        }
    }

    initiate() {
        let element = document.createElement("div");
        element.setAttribute('class', this.name);
        element.setAttribute("id", this.make_id());
        element.innerHTML = this.content; //emoji.emojify(this.content);
        element.onclick = (e) => {
            console.log(e);

            AboutPanel.toggle();


        };
        this.getParent().appendChild(element);
    }

    load() {
    }

    _call(geo) {

        let url = TopTagPanel.getUrl(geo.coords.latitude, geo.coords.longitude);
        console.log(url);
        // fetch(url, )

        return fetch(url, {
            method: "GET",
            headers: { 'Content-Type': 'application/json' },
        }).then(result => {
            if (result.status == 200) {
                return result.json().then(res => {
                    document.getElementsByClassName(CLASSNAMES.GEOCODONG_PANEL)[0].innerHTML = GeocodeParser.run(res);
                    return res;
                });
            }
            else if (result.status == 429) {
                return sleep(1000).then(r => { return this.request() });
            }
            else if (result.status == 504) {
                return this.request();
            }
            else {
                console.log(`CODE: ${result.status}`);
            }
            return result;
        });
    }
}

class AboutPanel extends CElement {
    constructor(parent) {
        super(parent);
        this.id = "id";
        this.parent = parent ? parent : "body";
        this.name = CLASSNAMES.ABOUT_PANEL;

        this.elements = [CloseButton,
            AboutDescription,
            AboutLogo,
            AboutText
        ];
        this.args = [() => { AboutPanel.toggle(); }]
    }

    getParent() {
        let elements = document.getElementsByClassName(this.parent);
        if (elements.length > 0) {
            return elements[0];
        }
    }

    load() {
        for (let e = 0; e < this.elements.length; e++) {
            let element = new this.elements[e](this.make_id(), undefined, e<this.args.length?this.args[e]:undefined);
            element.initiate();
            element.load();
        }

        this.getElement().style.display = "none";
    }

    static toggle() {
        let panel = document.getElementById(`${CLASSNAMES.ABOUT_PANEL}_id`);
        panel.style.display = panel.style.display === "none" ? "flex" : "none";
    }
}

// class AboutPanelCloseButton extends CloseButton {
//     constructor(parent) {
//         super(parent);
//         this.id = "aboutid";
//     }

//     initiate() {
//         let element = document.createElement("button");
//         element.setAttribute('class', this.name);
//         element.setAttribute("id", this.make_id());
//         element.innerHTML = this.content;
//         element.onclick = () => { AboutPanel.toggle(); };
//         this.getParent().appendChild(element);
//     }
// }

class AboutDescription extends CElement {
    constructor(parent) {
        super(parent);
        this.name = CLASSNAMES.ABOUT_DESCRIPTION;
        this.content = `City layers is a city-making app that empowers citizens to shape the changes they want to see in their cities!`;
    }

    load() { }

    initiate() {
        let element = document.createElement("div");
        element.setAttribute('class', this.name);
        element.setAttribute("id", this.make_id());
        element.innerHTML = this.content; //emoji.emojify(this.content);
        this.getParent().appendChild(element);
    }
}

class AboutText extends CElement {
    constructor(parent) {
        super(parent);
        this.name = CLASSNAMES.ABOUT_TEXT;
        this.content = `City Layers embody the motto “act local to go global” 
        by relying on citizen mapping as a holistic and inclusive city-making 
        practice that aims to tackle the contemporary spatial, social and 
        environmental challenges our cities are facing. <br><br>

        This powerful city mapping app serves as a means of 
        communication between cities and their citizens, 
        generating a new type of data that is 
        collectively generated, managed and cared for. `
    }

    load() { }

    initiate() {
        let element = document.createElement("div");
        element.setAttribute('class', this.name);
        element.setAttribute("id", this.make_id());
        element.innerHTML = this.content; //emoji.emojify(this.content);
        this.getParent().appendChild(element);
    }
}

class AboutLogo extends CElement {
    constructor(parent, category) {
        super(parent, category);
        this.name = "aboutlogo";
        this.content = "images/about.svg"; // U+02715
    }

    initiate() {
        var element = document.createElement("img");
        element.src = this.content;
        element.setAttribute('class', this.name);
        element.setAttribute("id", this.make_id());
        this.getParent().appendChild(element);
    }
}

