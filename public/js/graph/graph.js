// import "neo4j-driver";

// var neo4j = require('neo4j-driver');
const URI = 'neo4j+s://64a663c2.databases.neo4j.io';
const USER = 'neo4j';
const PASSWORD = '6ty6zc9rtk5ETSjQ3TUROHNv1UzNvsBHXgW8kd7WuRw';

const QUERYS = {
    PROJECTS: "MATCH (p:Project) RETURN p",
    PROJECT_NAME: "MATCH (p:Project {name : $name}) RETURN p",
    PROJECT_TEAM: "MATCH (p:Project {name : $name})-[:WORKEDON]->(t:TeamMember)-[rel:AS]->(r:Role) return t, rel, r",
    PROJECT_RECOGNITION: "MATCH (p:Project {name : $name})-[:HAS]->(recognition:Recognition)<-[rel:RECOGNIZED]-(partner:Partner) return recognition, rel, partner",
    PROJECT_PARTNERS: "MATCH (p:Project {name : $name})<-[:SUPPORTS]-(partner:Partner) return partner",
    PROJECT_ILLUSTRATIONS: "MATCH (p:Project {name : $name})<-[:ILLUSTRATED]-(illustration:Illustration) return illustration",
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