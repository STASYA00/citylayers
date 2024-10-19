class ProjectManager{
    constructor(){
        this.projects = [];
    }
}


class ProjectLoader{

    static make(){
        let projects =  ["Accessibility", "Mobility"];
        return projects.map(c => Project(c));
    }
}



class Project{
    constructor(id, name, description, 
                config){
        this.id = id;
        this.name = name? name : " ";
        this.description = description? description : "";
        this.config = config ? config : {};
    }
}

class Config{
    constructor(id, name, description,
        categories, subcategories
    ){
        this.id = id;
        this.name = name? name : " ";
        this.description = description ? description : "";
        this.categories = categories ? categories : [];
        this.subcategories = subcategories ? subcategories : [];
    }
}