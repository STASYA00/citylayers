// import {Settings} from "./settings";

class Settings{
    static debug = false;
}

const MAP_CLASSNAMES = {
    MAP_PANEL: "mappanel",
    MAP: "map",
}

const GRIDS = {
    RECT: "rectangular",
    DIAGONAL: "diagonal",
}

class MapPanel{
    /*
        Object that holds the panel with the interactive map.
        Args:
            parent: HTMLElement         element to place the map onto, defaults to body

        How to use:

        let m = new MapPanel(parent);
        m.load();
    */
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
        
        let mapObj = L.map(this.parent);
        Positioner.make(mapObj);
        CityMap.setup(mapObj);
        

        CityMap.addOsmLayer(mapObj);
        
        // this.coords.forEach(coord => this.addMarker(mapObj, coord[0], coord[1]));
        // this.addDebugGrid(mapObj);

        CityMap.addHatchLayer(mapObj, this.coords, MapGraphics.getColors()[0]);
    }


    addMarker(map, lat, lon){
        L.marker([lat, lon]).addTo(map);
    }

    static setup(map){
        map.zoomControl.remove();
        map.touchZoom.enable();
        map.scrollWheelZoom.enable();

    }

    static addOsmLayer(map){
        let osmLayer = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            subdomains: 'abcd',
            minZoom: 0,
            maxZoom: 19,
            crs: L.CRS.Simple,
            ext: 'png'
        }).addTo(map);
        map.addLayer(osmLayer);
    }

    static addHatchLayer(map, pts, category){
        
        L.GridLayer.CanvasCircles = L.GridLayer.extend({
            createTile: function (coords) {
                let el = TileManager.init(category);
                el = TileManager.update(el, map, coords, pts);
                return el;
            }
        });

        let hatchLayer = new L.GridLayer.CanvasCircles({crs: L.CRS.Simple});
        map.addLayer(hatchLayer);
        map.on("zoomend", function(ev){
            hatchLayer.redraw();
        });
    }

    static addDebugGrid(map){
        /*
            Function that draws a tile grid with tile coordinates written in 
            grid angles. To be used for debugging.
        */
        
        L.GridLayer.DebugCoords = L.GridLayer.extend({
            createTile: function (coords) {
                var tile = document.createElement('div');
                let tcoords = MapTransformer.tile2coords(coords.x, coords.y, coords.z);
                
                let zeroCoords = MapTransformer.px2coords(map, coords, 0,0);
                
                let dst = MapTransformer.calcDistance(map, 
                    [zeroCoords.lat, zeroCoords.lng], 
                    [59.312152351483135, 18.079562224248082]);
                tile.innerHTML = [
                    tcoords.lat, tcoords.lng, // dst 
                    coords.x, coords.y, coords.z
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

    static px2coords(map, tileCoords, x,y){
        let tcoords = MapTransformer.tile2coords(tileCoords.x, tileCoords.y, tileCoords.z);
        x = Math.abs(x);
        y = Math.abs(y);
        let north = map.getBounds().getNorth();
        let south = map.getBounds().getSouth();
        let east = map.getBounds().getEast();
        let west = map.getBounds().getWest();
        let mapSize = map.getSize();
        let lon = tcoords.lng + ((east - west) * x / mapSize.x);
        let lat = tcoords.lat - ((north - south) * y / mapSize.y);
        return L.latLng(lat, lon)
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
    static getGrid(category){
        return GRIDS.DIAGONAL;
    }
}

class Positioner{
    static initZoom = 15

    static async make(map){
        if (Settings.debug){
            return this.debugGeo(map);
        }
        return this.setFromGeo(map);
    }
    static debugGeo(map){
        map.setView([59.315906, 18.0739635], this.initZoom)
    }
    static setFromGeo(map){
        map.locate({setView: true, maxZoom: this.initZoom});
    }
}

class Grid{
    /*
    Object responsible for constructing different grids.
    Currently available grids:
        * simple rectangular
        * diagonal 45 degrees

    */
    static controlDims(width, height){
        /*
            Function that controls input dimensions and sets them to default in case they are missing
            or invalid.
            Args:
                width       width of the grid, int, defaults to MapGraphics.tile if undefined
                height      height of the grid, int, defaults to MapGraphics.tile if undefined
        */
        width = width? width : MapGraphics.tile;
        height = height? height : MapGraphics.tile;
        return [width, height];

    }
    static rect(width, height){
        /*
            Function that calculates intersection points for a regular rectangular grid. Returns
            a set of coordinates that represent these intersections as [[x,y],[x,y]]
            Args:
                width       width of the grid, int, defaults to MapGraphics.tile if undefined
                height      height of the grid, int, defaults to MapGraphics.tile if undefined
        */

        [width, height] = this.controlDims(width, height);
        
        let xArray = Array.from({length: width + 1}, 
            (x, i) => i % MapGraphics.gridDensity==0 ? i : undefined).
            filter(e=>e!=undefined);
        let yArray = Array.from({length: height + 1}, 
            (x, i) => i % MapGraphics.gridDensity==0 ? i : undefined).
            filter(e=>e!=undefined);

        let coords = new Array();
        xArray.forEach(x => {
            yArray.forEach(y =>{
                coords.push([x, y]);
            });
        });
        return coords;
    }

    static diagonal(width, height){
        /*
            Function that calculates intersection points for a diagonal grid, 45 degrees. Returns
            a set of coordinates that represent these intersections as [[x,y],[x,y]]
            Args:
                width       width of the grid, int, defaults to MapGraphics.tile if undefined
                height      height of the grid, int, defaults to MapGraphics.tile if undefined
        */
        [width, height] = this.controlDims(width, height);
        let xArray = Array.from({length: width + 1}, 
            (x, i) => i % MapGraphics.gridDensity==0 ? i : undefined).
            filter(e=>e!=undefined);
        let yArray = Array.from({length: height + 1}, 
            (x, i) => i % MapGraphics.gridDensity==0 ? i : undefined).
            filter(e=>e!=undefined);

        let coords = new Array();
            xArray.forEach(x => {
                yArray.forEach(y =>{
                    if (x%(2*MapGraphics.gridDensity)==y%(2*MapGraphics.gridDensity)){
                        coords.push([x, y]);
                    }
                    
                });
            });
            return coords;

    }
}

class HatchDrawer{
    /*
    Object responsible for drawing hatch patterns.

    */

    static makeRadius(refDist, ptDist){
        /*
            Function that calculates radius based on the distance from the nearest 
            mark.
            Args:
                refDist     distance that counts as mark's influence radius
                ptDist      actual distance from the given point to the nearest mark
        */
        let rad = MapGraphics.minRad;
        
        if (Math.abs(ptDist) < refDist){
            // if the given point is inside the influence area
            ptDist = ptDist==0 ? 1 : ptDist;  // avoid division by zero
            rad = refDist / Math.abs(ptDist); // radius is inversely proportional to the distance to the 
                                              // closest influence point
        }
        // radius can't be more than 8

        return Math.min(rad, 8);
    }

    static drawCircle(ctx, radius, x ,y){
        /*
            Function that draws a circle on the map given x, y, radius.

            Args:
                ctx         context to draw the circle in, Context
                radius      circle's radius
                x           x coordinate of the center of the circle, in pixels from top left angle of the tile
                y           y coordinate of the center of the circle, in pixels from top left angle of the tile
        */
        ctx.moveTo( x + radius, y );
        ctx.arc( x , y , radius, 0, Math.PI * 2 );
    }

    static make(map, ctx, tileCoords, pts){
        /*
            Function that draws circles hatch pattern on the map given tile coordinates and points
            to compare the hatch with. Closer to the points the hatch will have a denser pattern.

            Args:
                map         map the points belong to
                ctx         context to draw the circle in, Context
                tileCoords  coordinates of the tile to draw the hatch on, calculated in leaflet units from the pixelorigin
                            {x: 9046, y: 596, z: 16}
                pts         reference points for drawing the hatch pattern
        */
        let grid = Grid.diagonal(MapGraphics.tile, MapGraphics.tile);
        grid.forEach(coords =>{
            let [x, y] = coords;
            let crds = MapTransformer.px2coords(map, tileCoords, x, y);
            let dst = Math.min(...pts.map(pt=>MapTransformer.calcDistance(map, [crds.lat, crds.lng], pt)));                
            let radius =  this.makeRadius(MapGraphics.refDist, dst);
            this.drawCircle(ctx, radius, x, y);
            })
        }
}

class TileManager{
    /*
    Object responsible for management of a single tile.
    Performs init, draw, clean, update operations.
    */

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