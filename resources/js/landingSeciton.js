const CLASSNAMES_SECTION = {
    PARENT: "",
    SECTION : "section",
    CLOSE: "closebutton",

    CATEGORY_PANEL: "categorypanel",
    CATEGORY_CONTAINER: "categorycontainer"
}

class Section extends CElement{
    constructor(parent, name){
        super(parent);
        this.content = name;
        this.name = CLASSNAMES.SECTION;
        this.parent = parent ? parent : CLASSNAMES_SECTION.PARENT;
        this.elements = [
            SectionHeader,
            SectionImage,
            SectionText
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

                case (SectionHeader): 
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

class SectionHeader extends CElement {
    constructor(parent, id) {
        super(parent);
        this.id = id;
        this.name = CLASSNAMES_SECTION.HEADER;
        
        this.elements = [CategoryPanelLabel, CategoryPanelDescr];
    }

    load() {
        for (let e = 0; e < this.elements.length; e++) {
            let element = new this.elements[e](this.make_id(), this.id);
            element.initiate();
        }
    }
}
