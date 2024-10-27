// import "neo4j-driver";

// var neo4j = require('neo4j-driver');
const URI = 'neo4j+s://64a663c2.databases.neo4j.io';
const USER = 'neo4j';
const PASSWORD = '6ty6zc9rtk5ETSjQ3TUROHNv1UzNvsBHXgW8kd7WuRw';

const GRAPH_KEYS = {
    PROJECT: "p",
    ROLE: "r",
    TEAMMEMBER: "t",
    CONFIG: "c",
    ILLUSTRATION: "illustration",
    PARTNER: "partner",
    QUESTION: "question",
    ANSWER: "answer",
    QUESTION1: "question1",
    ANSWER1: "answer1",
    RECOGNITION: "recognition",
    CHOICE: "choice",
    STEP: "step",
}

const QUERYS = {
    PROJECTS: `MATCH (${GRAPH_KEYS.PROJECT}:Project) RETURN ${GRAPH_KEYS.PROJECT}`,
    PROJECT_NAME: `MATCH (${GRAPH_KEYS.PROJECT}:Project {name : $name}) RETURN ${GRAPH_KEYS.PROJECT}`,
    PROJECT_TEAM: `MATCH (${GRAPH_KEYS.PROJECT}:Project {name : $name})<-[:WORKEDON]-(${GRAPH_KEYS.TEAMMEMBER}:TeamMember)-[rel:AS]->\
                        (${GRAPH_KEYS.ROLE}:Role) return ${GRAPH_KEYS.TEAMMEMBER}, rel, ${GRAPH_KEYS.ROLE}`,
    PROJECT_RECOGNITION: `MATCH (${GRAPH_KEYS.PROJECT}:Project {name : $name})-[:HAS]->\
                        (${GRAPH_KEYS.RECOGNITION}:Recognition)<-[rel:RECOGNIZED]-(${GRAPH_KEYS.PARTNER}:Partner)\
                         return ${GRAPH_KEYS.RECOGNITION}, rel, ${GRAPH_KEYS.PARTNER}`,
    PROJECT_PARTNERS: `MATCH (${GRAPH_KEYS.PROJECT}:Project {name : $name})<-[:SUPPORTS]-\
                        (${GRAPH_KEYS.PARTNER}:Partner) return ${GRAPH_KEYS.PARTNER}`,
    PROJECT_ILLUSTRATIONS: `MATCH (${GRAPH_KEYS.PROJECT}:Project {name : $name})<-[:ILLUSTRATED]-\
                            (${GRAPH_KEYS.ILLUSTRATION}:Illustration) return ${GRAPH_KEYS.ILLUSTRATION}`,

    CONFIG_QUESTIONS_HL: `MATCH (${GRAPH_KEYS.PROJECT}: Project {name : $name})-[:ISSET]->(${GRAPH_KEYS.CONFIG}:Config)-[${GRAPH_KEYS.STEP}:ASKS]->
                         (${GRAPH_KEYS.QUESTION}:Question)-[ans:ISANSWERED]->(${GRAPH_KEYS.ANSWER}:Answer)
                            return ${GRAPH_KEYS.STEP}, ${GRAPH_KEYS.QUESTION}, ${GRAPH_KEYS.ANSWER}`,

    CONFIG_QUESTIONS: `MATCH (${GRAPH_KEYS.PROJECT}: Project {name : $name})-[:ISSET]->(${GRAPH_KEYS.CONFIG}:Config)-[${GRAPH_KEYS.STEP}:ASKS]\
                    ->(${GRAPH_KEYS.QUESTION}:Question)-[ans:ISANSWERED]->(${GRAPH_KEYS.ANSWER}:Answer)-\
                    [fb:FOLLOWEDBY]->(${GRAPH_KEYS.QUESTION1}:Question)-[ans1:ISANSWERED]->(${GRAPH_KEYS.ANSWER1}:Answer)\
                    -[:TOCHOOSE]->(${GRAPH_KEYS.CHOICE}:Answer)
                    return ${GRAPH_KEYS.STEP}, ${GRAPH_KEYS.QUESTION}, ${GRAPH_KEYS.ANSWER}, \
                    fb, ${GRAPH_KEYS.QUESTION1}, ans1, ${GRAPH_KEYS.ANSWER1}, ${GRAPH_KEYS.CHOICE}`,

    QUESTION_ANSWERS: `MATCH (${GRAPH_KEYS.QUESTION}:Question {value: $question})-[ans:ISANSWERED]->(${GRAPH_KEYS.ANSWER}:Answer)-\
                    [fb:FOLLOWEDBY]->(${GRAPH_KEYS.QUESTION1}:Question)-[ans1:ISANSWERED]->(${GRAPH_KEYS.ANSWER1}:Answer)\
                    -[:TOCHOOSE]->(${GRAPH_KEYS.CHOICE}:Answer)
                    return ${GRAPH_KEYS.STEP}, ${GRAPH_KEYS.QUESTION}, ${GRAPH_KEYS.ANSWER}, \
                    fb, ${GRAPH_KEYS.QUESTION1}, ans1, ${GRAPH_KEYS.ANSWER1}, ${GRAPH_KEYS.CHOICE}`,

    FOLLOWUP_QUESTIONS: `MATCH (${GRAPH_KEYS.PROJECT}: Project {name : $name})-[:ISSET]->(${GRAPH_KEYS.CONFIG}:Config)
                    -[${GRAPH_KEYS.STEP}:ASKS]->(q:Question)-[ans:ISANSWERED]->(${GRAPH_KEYS.ANSWER}:Answer)\
                    -[:FOLLOWEDBY]->(${GRAPH_KEYS.QUESTION}:Question)-[:ISANSWERED]->(${GRAPH_KEYS.ANSWER1}:Answer)\
                    -[]->(${GRAPH_KEYS.CHOICE})
                    return ${GRAPH_KEYS.STEP}, ${GRAPH_KEYS.ANSWER}, ${GRAPH_KEYS.QUESTION}, 
                        ${GRAPH_KEYS.ANSWER1}, ${GRAPH_KEYS.CHOICE}`,

    TEAM: `MATCH (${GRAPH_KEYS.TEAMMEMBER}:TeamMember) RETURN ${GRAPH_KEYS.TEAMMEMBER}`,
    TEAM_PROJECT: `MATCH (${GRAPH_KEYS.PROJECT}:Project)<-[w:WORKEDON]-(${GRAPH_KEYS.TEAMMEMBER}:TeamMember)\
                    -[rel:AS]->(${GRAPH_KEYS.ROLE}:Role)<-[:EMPLOYED]-(p:Project) \
                    return ${GRAPH_KEYS.PROJECT}, w, ${GRAPH_KEYS.TEAMMEMBER}, rel, ${GRAPH_KEYS.ROLE}`,
}



class DBConnection{
    constructor(){
        this.driver = undefined;
        this.session = undefined;
        // this.init();
    }
    async init(){
        try {
            this.driver = neo4j.driver(URI, neo4j.auth.basic(USER, PASSWORD));
            const serverInfo = await this.driver.getServerInfo();
            this.initSession();
          } catch(err) {
                console.log(`Connection error\n${err}\nCause: ${err.cause}`)
          }
        //   await this.driver.close();
    } 

    initSession(){
        this.session = this.driver.session({ defaultAccessMode: neo4j.session.READ });
    }

    async read(query, param){
        /*
        'MERGE (james:Person {name : $nameParam}) RETURN james.name AS name', {
                    nameParam: 'James'
                }
         */
        if (this.session==undefined){
            this.initSession();
        }
        return this.session
            .run(query, param)
                .then(result => {
                    console.log("--", result);
                    result.records.forEach(record => {
                    
                    });
                    return result;
                })
                .catch(error => {
                    console.log(error)
                })
                .then(result => {
                    // this.session.close();
                    // this.session = undefined;
                    console.log("..", result.records);
                    return result.records;
                }
                )
                    
        }
        
    }