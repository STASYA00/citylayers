

class Parser{

    
    static make(inp, arg){
        return ;
    }

    static makeAll(inp, arg){
        if (inp.original==undefined){
            return inp.map(i => this.make(i, arg));
        }
        return [];
    }
}