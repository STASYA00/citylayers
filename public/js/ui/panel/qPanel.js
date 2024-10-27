

class QPanel extends ContentPanel{
    static name = CLASSNAMES.Q_PANEL;
    static controller = undefined;
    static currentStep = 1;
    constructor(parent){
        super(parent, "id");
        this.name = QPanel.name;
        this.elements = [QHeader, QContainer, QFooter];
    }

    load(qasets) {
        this.elements.forEach((el, i) => {
            
            let element = el == QContainer ? new el(this.make_id(), qasets) : 
                                             new el(this.make_id(), "main");
            element.initiate();
            
            if (element instanceof QContainer){
                element.load(QPanel.currentStep, i==QPanel.currentStep)
                QPanel.controller = element;
            }
            else{
                element.load([QPanel.back, QPanel.next]);
            }
        });
    }

    static back(){
        QPanel.controller.load(QPanel.currentStep-1);
        QPanel.currentStep -= 1;
    }

    static next(){
        QPanel.controller.load(QPanel.currentStep+1);
        QPanel.currentStep += 1;
    }

    _load(questionTree, answerTree) {
        this.elements.forEach(el => {
            let element = el == QContainer ? new el(this.make_id(), questionTree, answerTree) : 
                                             new el(this.make_id(), "main");
            element.initiate();
            element instanceof QContainer ? element.load(1) : element.load();
        });

    }
}

