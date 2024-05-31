

class GradeGenerator{
    static goodLower = 0.7;
    static goodUpper = 1.0;
    static badLower = 0.0;
    static badUpper = 0.30;
    
    static randomToRange(num, lower, upper){
        return lower + (num * (upper - lower));
    }

    static _grade(){
        return Math.random();
    }

    static goodGrade(){
        return this.randomToRange(this._grade(), this.goodLower, this.goodUpper) * 100;
    }
    static badGrade(){
        return this.randomToRange(this._grade(), this.badLower, this.badUpper) * 100;
    }
    static anyGrade(){
        return this.randomToRange(this._grade(), this.badLower, this.goodUpper) * 100;
    }
}

class DataGenerator{

    static lat = 59.30903679229989
    static lng = 18.035872608321115

    static lat_range = 0.008;
    static lng_range = 0.08;
    

    static latKey = "lat"
    static lngKey = "lng"

    // stab data for stockholm Södermalm

    static _pointFromCoords(lat, lng){
        // function that generates a point in a standard format for this class
        // given coordinates
        let p = {};
        p[this.latKey] = lat;
        p[this.lngKey] = lng;
        return p;
    }

    static placePoint(point){
        // point is expected as {"lat": Math.random(), "lng": Math.random}
        return this._pointFromCoords(
            this.lat + point[this.latKey] * this.lat_range,
            this.lng + point[this.lngKey] * this.lng_range
        )
    }

    static generatePoint(){
        return this.placePoint(this._pointFromCoords(Math.random(), Math.random()));
    }
    
    static make(amount){
        return Array.from({length: amount}, 
            (x) => this.generatePoint());
    }
}

class OPINIONS{
    GOOD = 0
    BAD = 1
    ANY = 2
}

class ObservationGenerator{

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