
const CLASSNAMES = {
    CATEGORY_PANEL: "categorypanel",
    CATEGORY_CONTAINER: "categorycontainer"
}


class CategoryPanel{
    constructor(parent){
        this.name = CLASSNAMES.CATEGORY_PANEL;
        this.parent = parent ? parent : "body";
    }

    load(categories) {
        for (let c=0; c<categories.length; c++){
            this.addCategory(c);
        }
    }

    addCategory(category){
        var div = new CategoryElement(this.name);
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
        if (elements.length > 0){
            return elements[0];
        }
    }

    initiate(){
        
        let panel = this.getParent().createElement("div");
        panel.setAttribute('class', this.name);
        this.getParent().appendChild(panel);
    }
}

class CategoryElement extends CategoryPanel{
    constructor(parent){
        super(parent);
        this.name = CLASSNAMES.CATEGORY_CONTAINER;
        this.parent = parent ? parent : CLASSNAMES.CATEGORY_PANEL;
    }

    load() {
        let panel = doc.createElement("div");
        panel.setAttribute('class', this.name);
        panel.innerHTML = "TEST";
        this.getParent().appendChild(panel);
    }
}

export default {CategoryElement};