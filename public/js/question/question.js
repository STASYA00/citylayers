

class Question{
    constructor(id, content){
        this.parent = "";
        this.id = id;
        this.content = content;
        this.answer = TextInputContainer;
    }

    make(parent_id, answerTree, nextid, display){        
        let q_el = this.makeQuestion(parent_id);
        let q_ans = this.makeAnswer(parent_id, answerTree, nextid);
        q_el.getElement().style.display = display==0 ? "none" : "flex";
        q_ans.getElement().style.display = display==0 ? "none" : "flex";
    }

    makeQuestion(parent_id){
        let el = new TextElement(parent_id, this.id, this.content);
        el.initiate();
        return el;
    }

    makeAnswer(parent_id, answerTree, nextid){
        let el = new this.answer(parent_id, this.id, this.content);
        el.initiate();
        el.load(answerTree, nextid);
        return el;
    }

    empty(){
        return "";
    }
}

class QuestionBool extends Question{
    constructor(parent, id, content){
        super(parent, id, content);
    }
    empty(){
        return false;
    }

    
}

class QuestionCategorical extends Question{
    constructor(parent, id, content){
        super(parent, id, content);
    }
    empty(){
        return -1;
    }

}

class QuestionMultiCategorical extends Question{
    constructor(parent, id, content){
        super(parent, id, content);
        this.answer = CheckboxContainerElement;
    }
    empty(){
        return [];
    }
}

class QuestionRange extends Question{
    constructor(parent, id, content){
        super(parent, id, content);
        this.answer = RangeContainerElement;
    }
    empty(){
        return -1;
    }
}

class QuestionImage extends Question{
    constructor(parent, id, content){
        super(parent, id, content);
        this.answer = ImageInputContainerElement;
    }
}

class QuestionText extends Question{
    constructor(parent, id, content){
        super(parent, id, content);
    }

}