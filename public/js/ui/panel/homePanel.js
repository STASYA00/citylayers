

class HomePanel extends ContentPanel{
    static name = CLASSNAMES.HOME_PANEL;
    constructor(parent){
        super(parent, "id");
        this.name = HomePanel.name;
        this.elements = [LandingIllustration, GeneralContent, ProjectPanel]
    }

    load(projects) {
        this.elements.forEach(el => {
            let element = new el(this.make_id(), "main");
            element.initiate();
            element.load(projects);
        });

    }
}

