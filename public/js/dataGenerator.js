
class Randomizer{

    static randomToRange(lower, upper){
        return lower + (Math.random() * (upper - lower));
    }

    static randomFromArray(arr){
        return arr[Math.floor(this.randomToRange(0, arr.length-1))];
    }

    

}
class GradeGenerator{
    static goodLower = 0.7;
    static goodUpper = 1.0;
    static badLower = 0.0;
    static badUpper = 0.30;
    

    static goodGrade(){
        return Randomizer.randomToRange(this.goodLower, this.goodUpper) * 100;
    }
    static badGrade(){
        return Randomizer.randomToRange(this.badLower, this.badUpper) * 100;
    }
    static anyGrade(){
        return Randomizer.randomToRange(this.badLower, this.goodUpper) * 100;
    }
}

class DataGenerator{

    static lat = 59.30903679229989
    static lng = 18.035872608321115

    static lat_range = 0.008;
    static lng_range = 0.08;
    

    static latKey = "lat";
    static lngKey = "lng";
    static idKey = "id";

    // stab data for stockholm Södermalm

    static _pointFromCoords(lat, lng, id){
        // function that generates a point in a standard format for this class
        // given coordinates
        let p = {};
        p[this.latKey] = lat;
        p[this.lngKey] = lng;
        p[this.idKey] = id;
        return p;
    }

    static placePoint(point){
        
        // point is expected as {"lat": Math.random(), "lng": Math.random}
        return this._pointFromCoords(
            this.lat + point[this.latKey] * this.lat_range,
            this.lng + point[this.lngKey] * this.lng_range,
            point[this.idKey]
        )
    }

    static generatePoint(id){
        id = id==undefined ? 0 : id;
        return this.placePoint(this._pointFromCoords(Math.random(), Math.random(), id));
    }
    
    static make(amount){
        return Array.from({length: amount}, 
            (v, i) => {
                return this.generatePoint(i)
    });
    }
}

class OPINIONS{
    GOOD = 0
    BAD = 1
    ANY = 2
}

class ObservationGenerator{

    static IdKey = "id";
    static ptKey = "pt";
    static gradeKey = "grade";
    static catKey = "category";

    static _observation(pt, category, grade){
        // function that generates an observation in a standard format for this class
        // given coordinates and grade
        let p = {};
        p[this.ptKey] = pt;
        p[this.gradeKey] = grade;
        p[this.catKey] = category;
        return p;

    }

    static make(amount, category, opinion){
        let pts = DataGenerator.make(amount);
        
        if (opinion==OPINIONS.GOOD){
            return pts.map(p=>this._observation(p, category, GradeGenerator.goodGrade()));
        }
        else if (opinion==OPINIONS.BAD){
            return pts.map(p=>this._observation(p, category, GradeGenerator.badGrade()));
        }
        else{
            return pts.map(p=>this._observation(p, category, GradeGenerator.anyGrade()));
        }
    }
}


class CommentAssigner{
    static commentKey = "comment";

    static make(observations, comments){
        observations.forEach(ob => {
            ob[this.commentKey] = undefined;
            if (Math.random() > 0.5){
                ob[this.commentKey] = Randomizer.randomFromArray(comments);
            }
        });
        

    }
}

class SubcatAssigner{
    static subcatKey = "subcat";

    static make(observations, subcategories){
        observations.forEach(ob => {
            ob[this.subcatKey] = undefined;
            if (Math.random() > 0.5){
                ob[this.subcatKey] = Randomizer.randomFromArray(subcategories);
            }
        });
    }
}