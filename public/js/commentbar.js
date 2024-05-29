class CommentPanel extends CElement {

    toggleMarker = (value) => { console.log(value) };

    constructor(parent, comments) {
        super(parent, "id");
        this.name = CLASSNAMES.COMMENTPANEL;
        this.content = comments;

        this.elements = [
            CommentCloseButton,
            CommentSearch,
            CommentContainer
        ];
    }

    getParent() {
        let elements = document.getElementsByClassName(this.parent);
        if (elements.length > 0) {
            return elements[0];
        }
    }


    load(comments) {
        this.elements.forEach(el => {
            let element = new el(this.make_id(), "id");
            element.initiate();
            element.load(comments);
        });
    }

    static search(value) {
        let panel = document.getElementById(`${CLASSNAMES.COMMENTPANEL}_id`);
        if(!panel.classList.contains("open")) panel.classList.add("open");

        let comments = Array.from(document.getElementsByClassName(CLASSNAMES.COMMENTTEXT));
        comments.forEach(c => c.parentElement.setAttribute("style", "order: 8"));
        comments.filter(c => c.innerHTML.toLowerCase().includes(value.toLowerCase())).forEach(
            c => c.parentElement.setAttribute("style", "order: 1")
        );
    }

    static focusComment(id, on) {
        let _comment = document.getElementById(`commentpane_${id}`);
        console.log(_comment);
        if (_comment != undefined) {
            if (on == true) {
                _comment.scrollIntoView({
                    behavior: 'smooth'
                });
                _comment.focus();
            }

        }
    }


    static toggle() {
        let panel = document.getElementById(`${CLASSNAMES.COMMENTPANEL}_id`);
        panel.classList.toggle("open");
    }

    static hideAll() {
        let panels = document.getElementsByClassName(CLASSNAMES.CATEGORY_SIDE_PANEL);
        Array.from(panels).forEach(panel => {
            panel.style.display = "none";
        })
    }
}

class CommentContainer extends CElement {
    constructor(parent, id) {
        super(parent);
        this.id = id;
        this.name = CLASSNAMES.COMMENTCONTAINER;
        this.elements = [];
    }

    addComment(comment, id) {
        let div = new CommentPane(this.make_id(), id, comment);
        div.initiate();
        div.load();
    }

    load(comments) {
        this.elements.forEach(el => {
            let element = new el(this.make_id(), "main");
            element.initiate();
            element.load();
        });
        comments.forEach((c, i) => {
            this.addComment(c, i.toString());
        });
    }
}

class CommentPane extends CElement {
    constructor(parent, id, comment) {
        super(parent);
        this.id = id;
        this.name = CLASSNAMES.COMMENTPANE;
        this.content = comment;
        this.elements = [CommentText];
    }

    initiate() {
        let el = document.createElement("div");
        el.setAttribute('class', this.name + " simple-drop-shadow");
        el.setAttribute("id", this.make_id());
        this.getParent().appendChild(el);
        el.setAttribute("tabindex", "0");
        el.onclick = () => {
            console.log(el);
            console.log(document.activeElement == el);
            CommentPanel.toggleMarker(this.id, document.activeElement == el);
        }
    }

    load() {
        for (let e = 0; e < this.elements.length; e++) {
            let element = new this.elements[e](this.make_id(), this.id, this.content);
            element.initiate();
        }
    }
}

class CommentText extends CElement {
    constructor(parent, id, content) {
        super(parent);
        this.id = id;
        this.content = content
        this.name = CLASSNAMES.COMMENTTEXT;
        this.parent = parent; //CLASSNAMES.CATEGORY_HEADER;
    }
    initiate() {
        let element = document.createElement("div");
        element.setAttribute('class', this.name);
        element.setAttribute("id", this.make_id());
        element.innerHTML = this.content;
        this.getParent().appendChild(element);
    }
}

class CommentCloseButton extends CElement {

    constructor(parent) {
        super(parent, "id");
        this.name = CLASSNAMES.COMMENTPANEL_CLOSE;
        this.content = "<div class='chevron'></div>";
    }

    initiate() {
        let element = document.createElement("button");
        element.setAttribute('class', this.name);
        element.setAttribute("id", this.make_id());
        element.innerHTML = this.content;
        element.onclick = (e) => {
            element.classList.toggle("open");
            CommentPanel.toggle();
        };
        this.getParent().appendChild(element);
    }

}

class CommentSearch extends CElement {
    // <input type="text" placeholder="Search..">
    constructor(parent) {
        super(parent, "id");
        this.name = CLASSNAMES.COMMENTSEARCH;
        this.content = "Search through comments" // Search through comments 
    }

    initiate() {
        let element = document.createElement("div");
        element.setAttribute('class', this.name);
        element.setAttribute("id", this.make_id());
        // element.innerHTML = "🔎︎";
        this.getParent().appendChild(element);
        let e1 = document.createElement("input");
        e1.setAttribute("type", "text");
        e1.setAttribute("placeholder", this.content);
        e1.oninput = (e) => {
            CommentPanel.search(e.target.value);
        }
        element.appendChild(e1);
    }
}