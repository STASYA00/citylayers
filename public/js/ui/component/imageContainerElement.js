class ImageContainerElement extends ContentElement{
    constructor(parent,  name, illustrations){
        super(parent, undefined, name);
        
        this.parent = parent ? parent : "main";
        this.elements = illustrations.map(e=>ImageElement);
        this.images = illustrations;
    }

    load() {
        for (let e = 0; e < this.elements.length; e++) {
            let element = new this.elements[e](this.make_id(), 
                                    this.id, this.images[e]);
            element.initiate();
            element.load();
        }
    }
}