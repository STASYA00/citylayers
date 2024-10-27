class QASet{
    constructor(step, content){
        this.step = step;
        this.content = content ? content : [];
    }
    add(qapair){
        this.content.push(qapair);
    }
}

class QAPair{
    constructor(question, answer){
        this.question = question;
        this.step = question.step;
        this.answer = answer;
    }

    make(parent_id, display){
        this.question.make(parent_id, display);
        this.answer.make(parent_id, display);
    }
}

class Answer{
    constructor(content){
        this.content = content;
        this.answer = TextInputContainer;
        this.element = undefined;
    }

    make(parent_id, display, answerTree, nextid){
        if (this.element==undefined){
            this.element = new this.answer(parent_id, "", this.content);
            this.element.initiate();
            this.element.load(answerTree, nextid);
        }

        this.element.show(display);
        
        return this.element;
    }
    empty(){
        return "";
    }
}

class Question{
    constructor(content, help, step){
        // this.parent = parent ? parent : "";
        this.help = help ? help : "";
        this.step = step ? step : 0;
        this.content = content;
        this.element = undefined;
        // this.answer = answer;
    }

    make(parent_id, display){   
        this.element = this.element==undefined ? this.makeQuestion(parent_id) : this.element;
        this.element.show(display);
    }

    makeQuestion(parent_id){
        let el = new TextElement(parent_id, this.id, this.content);
        el.initiate();
        el.load();
        return el;
    }
}

class AnswerBool extends Answer{
    constructor(content){
        super(content);
    }
    empty(){
        return false;
    }

    
}

class AnswerCategorical extends Answer{
    constructor( content){
        super( content);
    }
    empty(){
        return -1;
    }

}

class AnswerMultiCategorical extends Answer{
    constructor( content){
        super( content);
        this.answer = CheckboxContainerElement;
    }
    empty(){
        return [];
    }
}

const RANGE_LABELS = {
    MIN: "min",
    MAX: "max"
};

class AnswerRange extends Answer{
    constructor( content){
        super( content);
        this.answer = RangeContainerElement;
        this.labels = new Map(
            [
                [RANGE_LABELS.MIN, this.content["minlabel"] ? this.content["minlabel"] : "Low"],
                [RANGE_LABELS.MAX, this.content["maxlabel"] ? this.content["maxlabel"] : "High"],
            ]
        );
        this.values = new Map(
            [
                [RANGE_LABELS.MIN, this.content["min"] ? this.content["min"] : 0],
                [RANGE_LABELS.MAX, this.content["max"] ? this.content["min"] : 100],
            ]
        );
    }
    empty(){
        return -1;
    }
}

class AnswerImage extends Answer{
    constructor( content){
        super( content);
        this.answer = ImageInputContainerElement;
    }
}

class AnswerText extends Answer{
    constructor( content){
        super( content);
    }

}