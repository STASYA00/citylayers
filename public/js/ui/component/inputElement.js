
class InputElement extends CElement {
    constructor(parent, name, content) {
        super(parent);
        this.id = IDS.TEXT_INPUT;
        this.name = name;
        this.content = content ? content.replaceAll("\\n", "<br>") : "";
        this.t = "input";
    }
    load() { }

    activateNext(answerTree, nextid){
        if (!answerTree.content.get(this.content)){
            if (nextid){
                document.getElementById(nextid).display="flex";
            }
            
        }
    }

    initiate(answerTree, nextid) {
        let element = document.createElement(this.t);
        element.setAttribute('type', "text");
        element.setAttribute('name', this.name);
        element.setAttribute("id", this.make_id());
        element.setAttribute("placeholder", "Type your comment here");
        element.onchange = (ev)=>{
            this.activateNext(answerTree, nextid);
            answerTree.content.set(this.name, ev.target.value)
        };
        this.getParent().appendChild(element);
    }
}

class TextInputElement extends InputElement {
    constructor(parent, name, content) {
        super(parent, name, content);
        this.id = IDS.TEXT_INPUT;
        this.t = "textarea";
    }

    initiate(answerTree, nextid) {
        let element = document.createElement(this.t);
        element.setAttribute('type', "text");
        element.setAttribute('name', this.name);
        element.setAttribute("id", this.make_id());
        element.setAttribute("placeholder", "Type your comment here");
        element.onchange = (ev)=>{
            this.activateNext(answerTree, nextid);
            answerTree.content.set(this.name, ev.target.value)
        };
        this.getParent().appendChild(element);
    }
}

class ImageInputElement extends InputElement {
    constructor(parent, name, content) {
        super(parent, name, content);
        this.id = IDS.IMG_INPUT;
    }

    initiate(answerTree, nextid) {
        let element = document.createElement(this.t);
        element.setAttribute('type', "file");
        element.setAttribute('accept', ".jpg, .png, .jpeg");
        element.setAttribute("id", this.make_id());
        element.onchange = (ev)=>{
            this.activateNext(answerTree, nextid);
            answerTree.content.set(this.name, ev.target.files[0]);
            // const file = e.target.files[0];
            //     if (file) {
            //         const fileReader = new FileReader();
            //         fileReader.onload = event => {
            //             this.image_src = event.target.result;
                        
            //         }
            //         fileReader.readAsDataURL(file);
            //         this.place_data["image"] = file;
                    
            //     }
        };
        this.getParent().appendChild(element);
    }
}

class InputContainer extends ContentPanel {
    constructor(parent){
        super(parent, "");
        this.name = CLASSNAMES.IMGINPUT_CONTAINER;
        this.content = ["", "or skip"];
        this.elements = [];
    }

    load(answerTree) {
        this.elements.forEach((el, i) => {
            let element = new el(this.make_id(), this.parent, 
                                 this.content instanceof Array ? this.content[i] : this.content);
            console.log("..", answerTree);
            element instanceof InputElement ? element.initiate(answerTree) : element.initiate();
            element instanceof InputContainer ? element.load(answerTree) : element.load();
        });
    }
}

class ImageInputContainer extends InputContainer {
    constructor(parent){
        super(parent, "");
        this.name = CLASSNAMES.IMGINPUT_CONTAINER;
        this.content = ["", "or skip"];
        this.elements = [ImageInputContainerElement, SpanElement];
    }
}

class TextInputContainer extends InputContainer {
    constructor(parent, id, content){
        super(parent, id);
        this.name = CLASSNAMES.TEXTINPUT_CONTAINER;
        this.content = content;
        this.elements = [TextInputElement];
    }
}

class ImageInputContainerElement extends InputContainer {
    constructor(parent, id){
        super(parent, id);
        this.name = CLASSNAMES.IMGINPUT_CONTAINER;
        this.elements = [ImageInputElement, ImagePreviewElement, TextElement];
        this.content = ["", "", "Upload an image"];
    }
}

class RangeInputElement extends InputElement {
    constructor(parent, name, content) {
        super(parent, name, "");
        this.content = content;
        this.id = IDS.RANGE_INPUT;
    }

    initiate(answerTree, nextid) {
        let element = document.createElement(this.t);
        element.setAttribute('type', "range");
        element.setAttribute("id", this.make_id());
        element.setAttribute("class", CLASSNAMES.RANGE_SLIDER);
        element.setAttribute('name', this.name);
        element.setAttribute('min', "0");
        element.setAttribute('max', "100");
        
        element.onchange = (ev)=>{
            this.activateNext(answerTree, nextid);
            answerTree.content.set(this.content, ev.target.value);
        };
        this.getParent().appendChild(element);
    }
}

class RangeLabelElement extends InputContainer {
    constructor(parent, name, content) {
        super(parent, name);
        this.name = CLASSNAMES.RANGE_CONTAINER;
        this.elements = [SpanElement, SpanElement];
        this.content = content ? content : ["Less", "More"];
    }


}

class RangeContainerElement extends InputContainer {
    constructor(parent, id, content){
        super(parent, "", content);
        this.name = CLASSNAMES.TAG_CONTAINER;
        this.content = [id, undefined];
        this.elements = [RangeInputElement, RangeLabelElement];
    }

}

class CheckboxContainerElement extends InputContainer {
    constructor(parent, id, checks){
        super(parent, id, checks);
        console.log(checks);
        this.name = CLASSNAMES.TAG_CONTAINER;
        this.content = checks;
        this.elements = checks.map(c=>CheckboxInputElement);
    }
    
}

class CheckboxElement extends InputContainer {
    constructor(parent, content){
        super(parent, "", content);
        this.name = "tag selectable";
        this.content = content;
        this.elements = [CheckboxInputElement, CheckboxLabelElement];
    }

}

class CheckboxInputElement extends InputElement {
    constructor(parent, name, content) {
        super(parent, name, content);
        this.id = IDS.MULTICHOICE_INPUT;
    }

    initiate(answerTree, nextid) {
        let element = document.createElement(this.t);
        element.setAttribute('type', "checkbox");
        element.setAttribute("id", this.make_id());
        element.setAttribute("class", CLASSNAMES.SUBCATEGORY_TAG);
        element.setAttribute('name', this.name);
        
        element.onchange = (ev)=>{
            answerTree.content.set(this.name, ev.target.value);
            if (!answerTree.content.get(this.content)){
                document.getElementById(nextid).display="flex";
            }
        };
        this.getParent().appendChild(element);
    }
}

class CheckboxLabelElement extends InputElement {
    constructor(parent, name, content) {
        super(parent, name, content);
        this.name = CLASSNAMES.TAG_LABEL;
    }

    initiate() {
        let element = document.createElement("div");
        element.setAttribute("class", CLASSNAMES.SUBCATEGORY_TAG);
        this.getParent().appendChild(element);

        let element1 = document.createElement("label");
        element1.setAttribute("class", CLASSNAMES.SUBCATEGORY_TAG);
        element1.innerHTML = this.content;
        element.appendChild(element1);
    }

}