

class TeamParser extends Parser{

    static make(teamInput, roleInput){
        return new TeamPerson(teamInput.id, teamInput.name, teamInput.link, 
                    roleInput.filter(r=>r.team_id==teamInput.id)[0].role, teamInput.external);
                
    }
}