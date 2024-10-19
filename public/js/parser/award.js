

class AwardParser extends Parser{

    static make(inp){
        return new ProjectRecognition(inp.value, inp.partner_id);
    }
}