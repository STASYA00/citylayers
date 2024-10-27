

class QHeader extends ContentPanel{
    constructor(parent){
        super(parent, "qheader");
        this.name = CLASSNAMES.Q_HEADER;
        this.elements = [LineLogo, ExitButton];
    }

    load() {
        this.elements.forEach(el => {
            let element = new el(this.make_id(), this.parent);
            element.initiate();
            element.load();
        });
    }
}

class ExitButton extends CButton{
    
    constructor(parent) {
        let onclick = ()=>{};
        super(parent, "id", onclick);
        this.name = "exit-button";
        this.content = "Save and Exit"; // U+02715
        // this.onclick = onclick ? onclick : () => { };
    }
}

class QFooter extends ContentPanel{
    constructor(parent, onclicks){
        super(parent, "qfooter");
        this.name = CLASSNAMES.Q_FOOTER;
        this.elements = [Steps, HrElement, NavButtons];
        // this.onclicks = onclicks;
    }
    load(onclicks) {
        this.elements.forEach(el => {
            let element = new el(this.make_id(), el==NavButtons ? onclicks : undefined);
            element.initiate();
            element.load();
        });
    }
}

class NavButtons extends ContentPanel{
    constructor(parent, onclicks){
        super(parent, "nav-buttons");
        this.name = "nav-buttons";
        this.elements = [BackButton, NextButton];
        this.args = onclicks;
    }

    load() {
        console.log(this.args);
        this.elements.forEach((el, i) => {
            let element = new el(this.make_id(), this.args[i]);
            element.initiate();
            element.load();
        });
    }
}

class BackButton extends CButton{
    
    constructor(parent, onclick) {
        // let onclick = ()=>{};
        super(parent, onclick);
        this.name = "back-button";
        this.content = "Back"; // U+02715
    }
}

class NextButton extends CButton{
    
    constructor(parent, onclick) {
        // let onclick = ()=>{};
        super(parent,onclick);
        this.name = "next-button";
        this.content = "Next"; // U+02715
    }
}

class Steps extends CElement{
    constructor(parent) {
        super(parent);
        this.name = "steps";
        this.content = "";
    }
    load() { }
    
}

class QContainer extends ContentPanel{
    constructor(parent, content){
        super(parent, "question-container");
        this.name = CLASSNAMES.Q_CONTAINER;
        this.content = content;  // QASet[]
        this.element = QContainer;
    }

    load(step) {        
        this.content.forEach((qs, i)=>qs.content.forEach((qa, j)=>qa.make(this.make_id(), (i==step-1 && j==0)))
                    );
    }
}

class QContainer_ extends ContentPanel{
    constructor(parent, content){
        super(parent, "question-page");
        this.name = CLASSNAMES.Q_PAGE;
        this.content = content;
        // this.answerTree = answerTree;
    }

    load(step) {        
        this.content.forEach((qa, i)=>qa.make(this.make_id(), i==step-1));
    }
}

class QContainerLeg extends ContentPanel{
    constructor(parent, qtree, answerTree){
        super(parent, "question-container");
        this.name = CLASSNAMES.Q_CONTAINER;
        this.content = qtree;
        this.answerTree = answerTree;
    }

    load(aspect) {        
            this.content.questions.filter(q=>this.content.q_locs
                                        .filter(q=>q.aspect_id==aspect)
                                        .map(q=>q.question_id)
                                        .includes(q.id))
                                  .forEach((question, i)=>question.make(this.make_id(), 
                                                                        this.answerTree, 
                                                                        this.content.questions[i+1].id, 
                                                                        i==0)
    );
    }
}