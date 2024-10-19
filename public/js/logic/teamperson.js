

class TeamPerson{
    constructor(name, link, role, external){
        this.id = name;
        this.name = name;
        this.link = link ? link : "";
        this.role = role;
        this.external = external ? external : 0;
    }
}

class Role{
    constructor(id, role, project_id, project_name){
        this.id = id;
        this.role = role;
        this.project_id = project_id;
        this.project_name = project_name;
    }
}