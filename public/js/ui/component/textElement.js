

class TextElement extends CElement {
    constructor(parent, name, content) {
        super(parent);
        this.name = name ? name : CLASSNAMES.TEXT;
        this.content = content ? content.replaceAll("\\n", "<br>") : "";
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
