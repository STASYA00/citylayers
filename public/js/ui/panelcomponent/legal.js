
const LEGAL_CLASSNAMES = {
    PANEL : "legalpanel",
    HEADER : "legalheader",
    BODY : "legalbody",
    LEGALBODYCONTENT: "legalbodycontent",
    CLOSE : "closebutton",
    TITLE : "legaltitle",
    TEXT : "legaltext",
    TEXT_F : "legaltextframed",
    FOOTER: "legal_footer"
}

const LEGAL = {
    IMPRESSUM: "impressum",
    PRIVACY: "privacy policy",
    ACCESSIBILITY: "accessibility"
}

const LEGAL_LINKS = new Map([
    [LEGAL.IMPRESSUM, "/impressum"],
   [LEGAL.PRIVACY, "/privacy"],
   [LEGAL.ACCESSIBILITY, "/accessibility"],
]);

class LegalContainer extends ContentPanel{
    constructor(parent){
        super(parent, "social");
        this.name = LEGAL_CLASSNAMES.FOOTER;
        this.parent = parent ? parent : "body";
        this.id = "id";
        
    }

    load() {
        Object.keys(LEGAL).forEach(el => {
            let element = new LinkElement(
                this.make_id(),
                LEGAL_CLASSNAMES.TEXT,
                LEGAL[el], LEGAL_LINKS.get(LEGAL[el])
            );
            element.initiate();
            element.load();
        });
    }

}