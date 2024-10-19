class QuestionParser extends Parser{

    static content = new Map([
        [1, QuestionRange],
        [2, QuestionMultiCategorical],
        [3, QuestionImage],
        [4, QuestionText]
    ])

    static make(inp){
        

        return inp.map(
            el => {
                let e = QuestionParser.content.get(parseInt(el.question_type));
                return new e(el.id, el.question);
            }
        )
        
    }
}

class QuestionTreeParser extends Parser{

    static content = new Map([
        [1, QuestionRange],
        [2, QuestionMultiCategorical],
        [3, QuestionImage],
        [4, QuestionText]
    ])

    static make(hierarchy, q_locs, questions){
        
        let aspects = this.q_locs.map(e=>e.aspect_id).filter(onlyUnique);  // distinct primary aspects
        let ls = this.hierarchy.map(h=>h.level).filter(onlyUnique);
        aspects.forEach(aspect => {
            let levels = ls.map(h=>Level(h, questions.filter(q=>
                q_locs.filter(l=>l.aspect_id==aspect).includes(q.id)).filter(q=>
                    hierarchy.filter(l=>l.level==h)
                )
        
        ));
            let a = new Aspect(aspect, levels);
            
            hierarchy.filter(e=>e.parent_id==element).forEach(
                child => 
                    {
                    this.addQuestion(child.child_id);
                    this.addLink(element, child.child_id);
                    hierarchy.filter(e=>e.parent_id==child.child_id).forEach(
                        e=>{                            
                            this.addLink(child.child_id, e.child_id);
                            }   
                        )
                    }
                );
            }
        )
        
        return inp.map(
            el => {
                let e = QuestionParser.content.get(parseInt(el.question_type));
                return new e(el.id, el.question);
            }
        )
        
    }
}