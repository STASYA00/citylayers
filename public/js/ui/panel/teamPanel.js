

class TeamPanel extends ContentPanel{
    static name = CLASSNAMES.HOME_PANEL;
    constructor(parent){
        super(parent, "id");
        this.name = TeamPanel.name;
        this.elements = [TextElement, TeamMemberContainer];
        console.log(parent);
        
    }

    load(team) {
        this.elements.forEach(el => {
            let element = new el(this.make_id(), "main");
            element.initiate();
            element.load(team);
        });

    }
}

