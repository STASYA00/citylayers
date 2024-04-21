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

function deg2rad(angle){
    return Math.PI * angle / 180;
}

class Place{
    constructor(lat, lon, grade){
        this.lat = lat;
        this.lon = lon;
        this.grade = grade;
    }
}


class MapTransformer{
    static calcDistance(map, coords1, coords2){
        return map.distance(coords1, coords2);
    }

    static px2coords(map, x,y){
        // return map.layerPointToLatLng(L.point(x,y));
        return map.containerPointToLatLng(L.point(Math.abs(x),Math.abs(y)));
    }
    static coords2px(map, lat,lon){
        return map.latLngToLayerPoint(L.latLng(lat, lon));
    }

    static tile2coords(xtile, ytile, zoom) {
        let n = Math.pow(2.0, zoom);
        let lng = xtile / n * 360.0 - 180.0;
        let lat_rad = Math.atan(Math.sinh(Math.PI * (1 - 2.0 * ytile / n)));
        let lat = 180.0 * lat_rad / Math.PI;
        return {lat, lng};
    }

    static distanceTiles(map, zoom) {
        /*
            Function that returns distance between the centers of two adjacent tiles on a certain zoom level.
            :param: zoom            map's zoom level, int
            return: dist            distance between the centers of two adjacent tiles on x axis (in degrees), float
        */
        let t1 = this.tile2coords(50, 50, zoom);
        let t2 = this.tile2coords(51, 50, zoom);
        return this.calcDistance(map, [t1.lat, t1.lng], [t2.lat, t2.lng]);
        // return Math.pow( (Math.pow(t1.lng-t2.lng, 2) + Math.pow(t1.lat-t2.lat, 2)), 0.5);
    }

    static distanceDiagonalTiles(zoom) {
        /*
            Function that returns distance between the centers of two diagonally connected tiles on a certain zoom level.
            :param: zoom            map's zoom level, int
            return: dist            distance between the centers of two diagonally connected tiles (in degrees), float
        */
        let t1 = this.tile2coords(50, 50, zoom);
        let t2 = this.tile2coords(51, 51, zoom);
        return Math.pow( (Math.pow(t1.lon-t2.lon, 2), Math.pow(t1.lat-t2.lat, 2)), 0.5);
    }
}

class MapGraphics{
    static refDist = 1000; // distance at which a grade has influence on the hatch pattern
    static minRad = 1; // minimal radius of a hatch pattern
    static gridDensity = 16;  // grid scarcity:) the amount of points in each direction that would be squeezed into 256. So
                              // if gridDensity is 4, there will be 4 points with distance 64 between them (4 x 64 = 256)
    static tile = 256; // tile size
    
    static getColors(){

        return ['#C4B5F0'];
    }

    static getCategoryColor(category){
        // TODO
        return '#C4B5F0';
    }
}


class CityMap extends MapPanel{
    

    constructor(parent){
        super(parent);
        this.name = MAP_CLASSNAMES.MAP;
        this.parent = parent;
        this.id = "id";
        this.coords = [
            [59.31712256357835, 18.063320386846158],
            [59.31689934021666, 18.06273718341144],
            [59.313720404190896, 18.08545415135039],
            [59.31884859445553, 18.059762360943395],
            [59.312152351483135, 18.079562224248082],
        ];
        this.places = this.coords.map(c=>new Place(c[0], c[1], 0.8));

    }

    initiate(){
        let pin = [59.315906,18.0739635]; //[48.6890, 7.14086];
        let pts = [[59.312152351483135, 18.079562224248082]];
        let mapObj = L.map(this.parent).setView(pin, 15);
        let osmLayer0 = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            subdomains: 'abcd',
            minZoom: 0,
            maxZoom: 19,
            ext: 'png'
        }).addTo(mapObj);
        mapObj.zoomControl.remove();
        mapObj.addLayer(osmLayer0);
        mapObj.touchZoom.enable();
        mapObj.scrollWheelZoom.enable();
        this.drawHatchLayer(mapObj, pts, MapGraphics.getColors()[0]);
        
        this.addMarker(mapObj, pts[0][0], pts[0][1]);
        this.addGrid_(mapObj);

    }

    addMarker(map, lat, lon){
        L.marker([lat, lon]).addTo(map);
    }

    static makeRadius(refDist, ptDist){
        let rad = MapGraphics.minRad;
        
        if (Math.abs(ptDist)<refDist){
            ptDist = ptDist==0 ? 1 : ptDist;
            rad = refDist / Math.abs(ptDist);
        }
        return Math.min(rad, 8);
    }

    drawHatchTile(map, pts){

    }

    drawHatchLayer(map, pts, category){

        L.GridLayer.CanvasCircles = L.GridLayer.extend({
            createTile: function (coords) {
                console.log("COORDS::", coords);
                
                let el = TileManager.init(category);
                el = TileManager.update(el, map, coords, pts);
                return el;
            }
        });
        

        L.GridLayer.canvasCircles = function(opts) {
            
            return new L.GridLayer.CanvasCircles(opts);
        };

        // let l = new L.GridLayer.CanvasCircles();
        // l.updateWhenZooming = true;
        map.addLayer( L.GridLayer.canvasCircles() );
        map.on("zoom", function(ev){
            console.log("EV", ev);
            let cnvs = document.getElementsByName("canvas")
            var ctx = tile.getContext('2d');
            
        });
    }

    addGrid_(map){
        let orig = map.getPixelOrigin();
        
        console.log(orig);
        
        L.GridLayer.DebugCoords = L.GridLayer.extend({
            createTile: function (coords) {
                var tile = document.createElement('div');
                let tcoords = MapTransformer.tile2coords(coords.x, coords.y, coords.z);
                let scale = this.getTileSize();
                
                let zeroCoords = MapTransformer.px2coords(map, orig.x-(coords.x * scale.x), orig.y - (coords.y*scale.y));
                
                let dst = MapTransformer.calcDistance(map, [zeroCoords.lat, zeroCoords.lng], [59.312152351483135, 18.079562224248082]);
                tile.innerHTML = [
                    tcoords.lat, tcoords.lng, dst, 
                    zeroCoords.lat, zeroCoords.lng
                ].join(', ');
                tile.style.outline = '1px solid red';
                return tile;
            }
        });
        
        L.GridLayer.debugCoords = function(opts) {
            return new L.GridLayer.DebugCoords(opts);
        };
        
        map.addLayer( L.GridLayer.debugCoords() );
    }
}

class HatchDrawer{
    /*
    Object responsible for drawing hatch patterns.

    */

    static drawCircle(ctx, radius, x ,y){
        ctx.moveTo( x + radius, y );
        ctx.arc( x , y , radius, 0, Math.PI * 2 );

    }

    static locatePoint(map, tileCoords, x, y){
        /*
            Function that locates grid point from tile on a map and returns its coordinates.
        */
        let orig = map.getPixelOrigin();

        let crds = MapTransformer.px2coords(map, 
                orig.x - (tileCoords.x * MapGraphics.tile + x), 
                orig.y - (tileCoords.y * MapGraphics.tile + y));
        return crds

    }

    static make(map, ctx, tileCoords, pts){
        let coordArray = Array.from({length: MapGraphics.tile}, 
                            (x,i)=>i%MapGraphics.gridDensity==0 ? i : undefined).
                            filter(e=>e!=undefined);

        coordArray.forEach(x => {
            coordArray.forEach(y =>{

                let crds = this.locatePoint(map, tileCoords, x, y);
                let dst = Math.min(...pts.map(pt=>MapTransformer.calcDistance(map, [crds.lat, crds.lng], pt)));
                let radius =  CityMap.makeRadius(MapGraphics.refDist, dst);
                this.drawCircle(ctx, radius, x, y);
                })
            })
        }
}

class TileManager{

    static clear(el){
        // let el = document.getElementsByTagName("canvas");
        let ctx = el.getContext("2d");
        ctx.clearRect(0, 0, MapGraphics.tile, MapGraphics.tile)
    }

    static draw(el, map, tileCoords, pts){
        var ctx = el.getContext('2d');
        let color = MapGraphics.getCategoryColor("category");

        this.setContext(ctx, color);
        // ctx.rotate(30 * Math.PI / 180);
        ctx.beginPath();
        
        HatchDrawer.make(map, ctx, tileCoords, pts);
        
        ctx.stroke();
        ctx.fill();
        return el;
    }

    static init(category){
        var el = document.createElement('canvas');
        el.setAttribute("className", category)
        el.setAttribute('width', MapGraphics.tile);
        el.setAttribute('height', MapGraphics.tile);
        return el;
    }

    static setContext(ctx, color){
        ctx.fillStyle = color;
        ctx.globalAlpha = 0.3;
        ctx.strokeStyle = "rgb(255 0 0 / 0%)";
    }

    static update(el, map, tileCoords, pts){
        this.clear(el);
        return this.draw(el, map, tileCoords, pts);
    }


}