@php use \App\Http\Controllers\GlobalController; @endphp
@php  $places = GlobalController::places();@endphp
@php  $comments = GlobalController::comments();@endphp
@php  $categories = GlobalController::categories();@endphp
@php  $subcategories = GlobalController::subcategories();@endphp
@php  $grades = GlobalController::grades();@endphp
@php  $subgrades = GlobalController::subgrades();@endphp
@php
    $locale = session()->get('locale');
    if ($locale == null) {
        $locale = 'en';
    }
@endphp

@extends('layouts.app')
@vite('resources/css/app.css')
@vite('resources/js/app.js')
@vite('resources/css/commentbar.css')
@vite('resources/css/sidepanel.css')
@vite('resources/css/map.css')
@vite('resources/js/map.js')
@vite('resources/js/citymap.js')
@vite('resources/js/category.js')
@vite('resources/js/dataGenerator.js')

@section('main')
@vite('resources/js/container.js')
@vite('resources/js/citymap.js')
@vite('resources/js/commentbar.js')
@vite('resources/js/category.js')
@vite('resources/js/scope.js')
@vite('resources/js/dataGenerator.js')
@vite('resources/css/sidepanel.css')
@vite('resources/css/container.css')
@vite('resources/css/map.css')

<div class="main-map">
    <div class="left-container"></div>
    <div class="right-container"></div>
</div>


    
    <script>
        <?php require_once("js/container.js");?>
        <?php require_once("js/citymap.js");?>
        <?php require_once("js/commentbar.js");?>
        <?php require_once("js/category.js");?>
        <?php require_once("js/dataGenerator.js");?>
        <?php require_once("js/scope.js");?>
    </script>
    <!-- <script src="resources/js/map.js"></script> -->
    <script>
        const FAKEDATA = false;
        

        let rightContainer = "right-container"; 
        let leftContainer = "left-container"; 
        const placeInput = {!! json_encode($places) !!};
        const commentInput = {!! json_encode($comments) !!};
        const categoryInput = {!! json_encode($categories) !!};
        const subcategoryInput = {!! json_encode($subcategories) !!};
        const gradeInput = {!! json_encode($grades) !!};
        const subgradeInput = {!! json_encode($subgrades) !!};

        console.log(subcategoryInput);
        
        let subcats = subcategoryInput.map(s => new Subcategory(s.id, s.name, s.category));
        let categories = categoryInput.map(c => new Category(c.id, c.name, 
                                                             c.description, 
                                                             subcats.filter(e=>e.parent_id==c.id),
                                                             c.color, c.low, c.high
                                                            ));
        
        

        let obs = [];

        if (FAKEDATA == true){
            categories.forEach((cat, c) => {obs = obs.concat(ObservationGenerator.generate(15, cat, 2));});
            commentInput = [
            `Love the Greenery! This neighborhoods abundance of trees,
            parks, and green spaces makes it a breath of fresh air. Perfect 
            for morning jogs or picnics!`,
            `Walkability Score: A+. Sidewalks, crosswalks, and pedestrian-friendly 
            streets—this area nails it! Walking to shops and cafes is a breeze.`,
            `Mixed-Use Magic: Living above a cozy café? Yes, please. The blend of 
            residential and commercial spaces here creates a vibrant community.`,
            `From smart traffic lights to solar-powered streetlights, 
            this place is future-ready. Tech-savvy and efficient.`,
            `Excellent public transportation options—buses, subways, and light rail. 
            Say goodbye to traffic woes.`,
            `Playgrounds for all ages, multilingual signage, 
            and accessibility—everyone feels welcome here.`
            ];
            SubcatAssigner.generate(obs, subcats);
            CommentAssigner.generate(obs, commentInput);
        }

        else{
            obs = ObservationGenerator.make(placeInput, gradeInput);
            SubcatAssigner.make(obs, subgradeInput);
            CommentAssigner.make(obs, commentInput);
        }


        let m = new MapPanel(rightContainer);
        let c = new CategoryPanel(leftContainer);
        let scope = new Scope(rightContainer);
        let commentPanel = new CommentPanel(rightContainer);
        let aboutLabel = new AboutLabel(rightContainer);
        let aboutPanel = new AboutPanel(rightContainer);
        let topTagPanel = new TopTagPanel(rightContainer);

        CategoryPanel.activation = (category, lower, upper)=>{
            
            m.reload(category, lower, upper)};


        CategoryPanel.markertoggle = (subcat, on)=>{m.reloadMarkers(subcat, on)};
        CategoryPanel.getCoords = ()=>{return m.getCoords();};
        MapPanel.toggleComment = (i, on)=>{ CommentPanel.focusComment(i, on)};
        CommentPanel.toggleMarker = (id, on)=>{m.activate(id, on)}
        
        c.initiate();
        m.initiate();
        commentPanel.initiate();
        topTagPanel.initiate();
        aboutLabel.initiate();
        aboutPanel.initiate();


        // console.log(obs);
        // console.log(categories);

        m.load(categories, obs);
        c.load(categories);  // ["Accessibility", "Noise", "Safety", "Weather Resistance", "Amenities"]

        commentPanel.load(commentInput);
        topTagPanel.load();
        aboutLabel.load();
        aboutPanel.load();

        scope.initiate();
        
        // setTimeout(()=>{m.reload(obs)}, 0);
    </script>


@endsection
