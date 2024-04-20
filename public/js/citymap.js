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
        return map.distance(coords1,coords2);
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
        let mymap0 = L.map(this.parent).setView(pin, 15);
        let osmLayer0 = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            subdomains: 'abcd',
            minZoom: 0,
            maxZoom: 19,
            ext: 'png'
        }).addTo(mymap0);
        mymap0.zoomControl.remove();
        mymap0.addLayer(osmLayer0);
        mymap0.touchZoom.enable();
        mymap0.scrollWheelZoom.enable();
        this.addGrid(mymap0);
        let pt = [59.312152351483135, 18.079562224248082];
        this.addMarker(mymap0, pt[0], pt[1]);
        // this.addGrid_(mymap0);

    }

    addMarker(map, lat, lon){
        L.marker([lat, lon]).addTo(map);
    }

    

    static makeRadius(refDist, ptDist, minRad){
        let rad = minRad;
        
        if (Math.abs(ptDist)<refDist){
            ptDist = ptDist==0 ? 1 : ptDist;
            rad = refDist / Math.abs(ptDist);
        }
        return Math.min(rad, 8);
    }

    addGrid(map){
        
        let pt = [59.312152351483135, 18.079562224248082];
        let refDist = 1000; //MapTransformer.distanceTiles(map, map.getZoom());
        console.log(refDist);

        L.GridLayer.CanvasCircles = L.GridLayer.extend({
            createTile: function (coords) {
                
                // console.log(coords.x, coords.y, coords.z);
                let tcoords = MapTransformer.tile2coords(coords.x, coords.y, coords.z);
                var tile = document.createElement('canvas');
                tile.setAttribute("className", "canvashatch")
        
                var tileSize = this.getTileSize();
                tile.setAttribute('width', tileSize.x);
                tile.setAttribute('height', tileSize.y);

                var ctx = tile.getContext('2d');
                const pi2 = Math.PI * 2;
                // const radius = 4;
                ctx.fillStyle = '#C4B5F0';
                ctx.globalAlpha = 0.3;
                ctx.strokeStyle = "rgb(255 0 0 / 0%)";
                // ctx.rotate(30 * Math.PI / 180);
                ctx.beginPath();
                let module = 16;
                let minRad = 1;
                let radius = minRad;
                let orig = map.getPixelOrigin();
                console.log("--orig:", orig);
                console.log("ORIG::", MapTransformer.px2coords(map,0,0));
                console.log(tileSize.x, map.getZoom());


                for( let x=0; x<= tileSize.x; x+=module )
                {
                    for( let y=0; y <= tileSize.y; y+=module ){
                        
                        let zeroCoords = MapTransformer.px2coords(map, orig.x-(
                            coords.x * tileSize.x + x), orig.y - (coords.y*tileSize.y + y));
                        
                        let dst = MapTransformer.calcDistance(map, [zeroCoords.lat, zeroCoords.lng], pt);

                        radius =  CityMap.makeRadius(refDist, dst, minRad);
                        
                        ctx.moveTo( x + radius, y );
                        ctx.arc( x , y , radius, 0, pi2 );
                        if (x==tileSize.x && y==tileSize.y){
                            console.log(coords.x, coords.y, zeroCoords);
                        }
                    }
                    
                }
                
                ctx.stroke();
                ctx.fill();
                
                
        
                return tile;
            }
        });
        

        L.GridLayer.canvasCircles = function(opts) {
            return new L.GridLayer.CanvasCircles(opts);
        };

        
        let l = map.addLayer( L.GridLayer.canvasCircles() );
        l.on('update', (e) => {
            context.save()
            context.clearRect(
                0,
                0,
                map.getSize().x,
                map.getSize().y
            )
            // context.beginPath()
            // path(data)
            // context.stroke()
            context.restore()
        })
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
                tile.innerHTML = [tcoords.lat, tcoords.lng, dst, zeroCoords.lat, zeroCoords.lng].join(', ');
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