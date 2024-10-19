
class ProjectPeriod{
    constructor(start, end){
        console.log(start, end);
        this.start = this.convert(start, true); //? start.substr(0, 10).replaceAll(":", "/") : "Not started";
        this.end = this.convert(end);// ? end.substr(0, 10).replaceAll(":", "/") : "Ongoing";
    }

    convert(d, start){
        if (d==null || d==undefined){
            return start==true ? "Not started" : "Ongoing";
        }
        if (d instanceof String){
            return d.substr(0, 10).replaceAll(":", "/")
        }
        else{
            return `${d.year}/${d.month}/${d.day}`;
        }
    }
}

class ProjectRecognition{
    constructor(value, partner){
        this.value = value ? value : "";
        this.partner = partner;
    }
}

class ProjectInfo{
    constructor(name, subtitle, description, period, 
                recognition,
                images, partners, team){
        this.id = name;
        this.name = name;
        this.period = period;
        this.subtitle = subtitle ? subtitle : "";
        this.description = description ? description : "";
        this.recognition = recognition ? recognition : "";
        this.images = images ? images : [];
        this.partners = partners ? partners : [];
        this.team = team ? team : [];
    }
}