

class QPanel extends ContentPanel{
    static name = CLASSNAMES.Q_PANEL;
    constructor(parent){
        super(parent, "id");
        this.name = QPanel.name;
        this.elements = [QHeader, QContainer, QFooter];
    }

    load(questionTree, answerTree) {
        this.elements.forEach(el => {
            
            let element = el == QContainer ? new el(this.make_id(), questionTree, answerTree) : new el(this.make_id(), "main");
            element.initiate();
            element instanceof QContainer ? element.load(1) : element.load();
        });

    }
}

