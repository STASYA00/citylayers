

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
