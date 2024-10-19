

class AnswerTree{
    constructor(){
        this.content = new Map();
    }


    make(){
        
    }

    addAnswer(q, a){
            this.content.set(q, a);
        }
        

    getAnswer(question){
        return this.content.get(question) ? this.content.get(question) : question.empty();
    }

    
}