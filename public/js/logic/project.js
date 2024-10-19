class ProjectManager{
    constructor(){
        this.projects = [];
    }
}


class ProjectLoader{

    static make(){
        let projects =  ["Accessibility", "Mobility"];
        return projects.map(c => Project(c, c));
    }
}



class Project{
    constructor(projectInfo, config){
        // this.id = id;
        this.name = projectInfo.name;
        this.info = projectInfo;
        this.config = config ? config : Config.empty();
    }

    getPlace(){
        return "Vienna, Austria";
    }
    getPeriod(){
        return "2024/06";
    }
    getStatus(){
        return "Closed";
    }
}

