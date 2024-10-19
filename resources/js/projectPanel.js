

/*
    ------------------------------------------------------

    Project Container and its elements

    ------------------------------------------------------

*/


class ProjectContentPanel extends ContentPanel{

    constructor(parent){
        super(parent, "id");
    }

    load(projects) {
        this.elements.forEach(el => {
            let element = new el(this.make_id(), "main");
            element.initiate();
            element.load();
        });
        projects.forEach((project, c) => {
            this.add(project);
        });
    }


    add(project) {
        let div = new ProjectElement(this.make_id(), project);
        div.initiate();
        div.load();
    }
    
}


class ProjectElement extends CElement{
    constructor(parent, category){
        super(parent, category.name);
        this.content = category;
        this.name = CLASSNAMES.PROJECT_CONTAINER;
        this.parent = parent ? parent : CLASSNAMES.PROJECT_PANEL;
        this.elements = [
            CategoryHeader,
            CategorySidePanel
        ]
    }
    getParent() {
        let element = document.getElementById(this.parent);
        return element;
    }

    load() {
        for (let e = 0; e < this.elements.length; e++) {
            let element = new this.elements[e](this.make_id(), 
                                    this.id, this.content);

            element.initiate();
            element.load();
        }
    }

    initiate() {
        let panel = document.createElement("div");
        panel.setAttribute('class', this.name);
        panel.setAttribute("id", this.make_id());

        this.getParent().appendChild(panel);
    }
}


class ProjectHeader extends CategoryHeader{
    constructor(parent, id, category){

        super(parent, id, category);
        this.elements = [ProjectInfo, 
            CategoryLabel, ProjectSwitch];
    }

}



class ProjectSwitch extends CElement{
    constructor(parent, id, project){

        super(parent);
        this.id = id;
        this.name = CLASSNAMES.PROJECT_SWITCH;
        this.project = project;
        this.parent = parent; //CLASSNAMES.CATEGORY_HEADER;
    }

    static isActive(project) {
        let d = document.getElementById(`projectswitch_${project}`);
        return d.children[0].checked;
    }

    initiate() {
        let element = document.createElement("label");
        element.setAttribute('class', this.name);
        element.setAttribute("id", this.make_id());
        this.getParent().appendChild(element);
        let e1 = document.createElement("input");
        e1.setAttribute("type", "checkbox");

        e1.onchange = ()=>{
            CityLayersPanel.activateProject(this.project, ProjectSwitch.isActive(this.id));
            console.log(ProjectSwitch.isActive(this.id));
        }
        let e2 = document.createElement("span");
        element.appendChild(e1);
        element.appendChild(e2);

    }
}


class ProjectInfo extends CElement{
    constructor(parent, id, category){
        super(parent, id);
        this.name = "material-symbols-outlined";
        this.content = "info"; 
        this.id = id;
        this.category = category;
    }

    initiate() {
        var element = document.createElement("span");
        element.innerHTML = this.content;
        element.setAttribute('class', this.name);
        element.onclick = ()=>{
             ProjectSidePanel.toggle(this.category);            
        };
        this.getParent().appendChild(element);
    }
}

/*
    ------------------------------------------------------

    Category Side Panel and its elements

    ------------------------------------------------------

*/

class ProjectSidePanel extends CElement {
    constructor(parent, project) {
        super(parent, project.id);
        this.id = project.name;
        this.parent = parent ? parent : "body";
        this.name = CLASSNAMES.CATEGORY_SIDE_PANEL;
        this.content = project;

        this.elements = [CloseButton,
            CategoryDescription,
        ];
        
        this.args = [() => { ProjectSidePanel.toggle(project); }]
    }

    getParent() {
        let elements = document.getElementsByClassName(this.parent);
        if (elements.length > 0) {
            return elements[0];
        }
    }

    load() {
        for (let e = 0; e < this.elements.length; e++) {
            let element = new this.elements[e](this.make_id(), this.content, e<this.args.length?this.args[e]:undefined);
            element.initiate();
            element.load();
        }

        this.getElement().style.display = "none";
    }

    static toggle(category) {
        let sidePanel = document.getElementById(`${CLASSNAMES.CATEGORY_SIDE_PANEL}_${category.name}`);
        let container = document.getElementById(`${CLASSNAMES.CATEGORY_CONTAINER}_${category.name}`);
        if (sidePanel.style.display === "none") {
            this.hideAll();
        }
        container.classList.toggle("simple-drop-shadow");
        sidePanel.style.display = sidePanel.style.display === "none" ? "flex" : "none";
        document.body.style.setProperty(`--side-panel-color`, `#${category.color}`);
        console.log(document.body.style.getPropertyValue("--side-panel-color"));
    }

    static hideAll() {
        let panels = document.getElementsByClassName(CLASSNAMES.CATEGORY_SIDE_PANEL);
        let containers = document.getElementsByClassName(CLASSNAMES.CATEGORY_CONTAINER);
        Array.from(panels).forEach(panel => {
        })
        for (let i = 0; i < panels.length; i++) {
            panels[i].style.display = "none";
            containers[i].classList.remove("simple-drop-shadow");            
        }
    }
}



class ProjectDescription extends CElement {
    constructor(parent, project) {
        super(parent, project.id);
        this.name = CLASSNAMES.CATEGORY_DESCRIPTION;
        this.content = project.description;
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
