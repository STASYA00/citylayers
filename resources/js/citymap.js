const MAP_CLASSNAMES = {
    MAP_PANEL: "mappanel",
    MAP: "map",

}

class MapPanel{
    constructor(parent){
        this.name = MAP_CLASSNAMES.MAP_PANEL;
        this.parent = parent ? parent : "body";
        this.id = "id";
    }

    load() {
        let citymap = new CityMap(this.make_id());
        citymap.initiate();
    }

    getElement(){
        let elements = document.getElementsByClassName(this.name);
        if (elements.length > 0){
            return elements[0];
        }
        return this.initiate();
    }

    getParent(){
        let elements = document.getElementsByClassName(this.parent);
        if (elements.length>0){
            return elements[0];
        }
    }

    initiate(){
        let panel = document.createElement("div");
        panel.setAttribute('class', this.name);
        panel.setAttribute("id", this.make_id());
        this.getParent().appendChild(panel);
        return panel;
    }

    make_id(){
        return `${this.name}_${this.id}`
    }
}



class CityMap extends MapPanel{
    constructor(parent){
        super(parent);
        this.name = MAP_CLASSNAMES.MAP;
        this.parent = parent;
        this.id = "id";
    }

    initiate(){
        let pin = [48.6890, 7.14086];
        let mymap0 = L.map(this.parent).setView(pin, 10);
        let osmLayer0 = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            subdomains: 'abcd',
            minZoom: 0,
            maxZoom: 12,
            ext: 'png'
        }).addTo(mymap0);
        mymap0.zoomControl.remove();
        mymap0.addLayer(osmLayer0);
        mymap0.touchZoom.enable();
        mymap0.scrollWheelZoom.enable();
        this.addGrid(mymap0);

    }

    addGrid(map){
        L.GridLayer.CanvasCircles = L.GridLayer.extend({
            createTile: function (coords) {
                var tile = document.createElement('canvas');
        
                var tileSize = this.getTileSize();
                tile.setAttribute('width', tileSize.x);
                tile.setAttribute('height', tileSize.y);
        
                var ctx = tile.getContext('2d');
        
                // Draw whatever is needed in the canvas context
                // For example, circles which get bigger as we zoom in
                ctx.beginPath();
                ctx.arc(tileSize.x/2, tileSize.x/2, 4 + coords.z*4, 0, 2*Math.PI, false);
                ctx.fill();
        
                return tile;
            }
        });
    }

    addGrid_(map){
        L.GridLayer.DebugCoords = L.GridLayer.extend({
            createTile: function (coords) {
                var tile = document.createElement('div');
                tile.innerHTML = [coords.x, coords.y, coords.z].join(', ');
                tile.style.outline = '1px solid red';
                return tile;
            }
        });
        
        L.GridLayer.debugCoords = function(opts) {
            return new L.GridLayer.DebugCoords(opts);
        };
        
        map.addLayer( L.GridLayer.debugCoords() );
        console.log("added layer");
    }
}