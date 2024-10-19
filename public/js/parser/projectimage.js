class ProjectImageParser extends Parser{

    static make(inp, project_id){
        
        return new Illustration(`/images/projects/${project_id}/${inp.image}`, 
            '', inp.caption);
            
    }
}