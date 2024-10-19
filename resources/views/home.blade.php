@php use \App\Http\Controllers\GlobalController; @endphp
@php use \App\Http\Controllers\ConfigController; @endphp
@php use \App\Http\Controllers\ProjectController; @endphp
@php  $places = GlobalController::places();@endphp
@php  $comments = GlobalController::comments();@endphp
@php  $categories = GlobalController::categories();@endphp
@php  $subcategories = GlobalController::subcategories();@endphp
@php  $grades = GlobalController::grades();@endphp
@php  $subgrades = GlobalController::subgrades();@endphp
@php  $catconfigs = ConfigController::allcategories();@endphp
@php  $configs = ConfigController::all();@endphp
@php  $projects = ProjectController::all();@endphp
@php
    $locale = session()->get('locale');
    if ($locale == null) {
        $locale = 'en';
    }
@endphp

@extends('layouts.app')


@vite('resources/css/commentbar.css')
@vite('resources/js/commentbar.js')

@vite('resources/css/container.css')
@vite('resources/js/container.js')

@vite('resources/css/sidepanel.css')

@vite('resources/css/map.css')

@vite('resources/js/citymap.js')
@vite('resources/js/category.js')

@vite('resources/js/projectPanel.js')
@vite('resources/js/project.js')

@vite('resources/js/scope.js')
@vite('resources/css/scope.css')

@section('main')


<div class="main-map">
    <div class="left-container"></div>
    <div class="right-container"></div>
</div>
    <script>
        <?php require_once("js/classnames.js");?>
        
        <?php require_once("js/logic/project.js");?>
        <?php require_once("js/logic/config.js");?>
        <?php require_once("js/logic/category.js");?>
        <?php require_once("js/logic/state.js");?>

        <?php require_once("js/ui/component/celement.js");?>
        <?php require_once("js/ui/component/imageElement.js");?>
        <?php require_once("js/ui/component/textElement.js");?>
        
        <?php require_once("js/ui/component/logo.js");?>
        <?php require_once("js/ui/component/pinButton.js");?>
        <?php require_once("js/ui/component/closeButton.js");?>
        <?php require_once("js/ui/component/switch.js");?>
        <?php require_once("js/ui/component/scope.js");?>
        <?php require_once("js/ui/component/slider.js");?>

        <?php require_once("js/ui/container.js");?>
        
        <?php require_once("js/ui/geocodeParser.js");?>
        
        <?php require_once("js/ui/panel/contentPanel.js");?>
        <?php require_once("js/ui/panel/sidePanel.js");?>
        
        <?php require_once("js/ui/panel/configPanel.js");?>
        <?php require_once("js/ui/panel/projectPanel.js");?>
        <?php require_once("js/ui/panel/topTagPanel.js");?>
        <?php require_once("js/ui/panel/about.js");?>
        <?php require_once("js/ui/panel/citylayerspanel.js");?>
                
        <?php require_once("js/karta/citymap.js");?>
        
        <?php require_once("js/ui/panel/commentbar.js");?>
        
        <?php require_once("js/ui/dataGenerator.js");?>
        <?php require_once("js/ui/component/scope.js");?>
        <?php require_once("js/ui/container.js");?>
    </script>
    
    <!-- <script src="resources/js/map.js"></script> -->
    <script>
        let page_project_id = {!! json_encode($project_id) !!};
        const FAKEDATA = false;
        const projectInput = {!! json_encode($projects) !!};
        const configInput = {!! json_encode($configs) !!};
        const catConfigInput = {!! json_encode($catconfigs) !!};        

        let rightContainer = "right-container"; 
        let leftContainer = "left-container"; 
        const placeInput = {!! json_encode($places) !!};
        const commentInput = {!! json_encode($comments) !!};
        const categoryInput = {!! json_encode($categories) !!};
        const subcategoryInput = {!! json_encode($subcategories) !!};
        const gradeInput = {!! json_encode($grades) !!};
        const subgradeInput = {!! json_encode($subgrades) !!};
        
        let subcats = subcategoryInput.map(s => new Subcategory(s.id, s.name, s.category));
        let categories = categoryInput.map(c => new Category(c.id, c.name, 
                                                             c.description, 
                                                             subcats.filter(e=>e.parent_id==c.id),
                                                             c.color, c.low, c.high
                                                            ));
        let configs = configInput.map(s=>new Config(s.id, s.name, s.description, categories.filter(
            c=>catConfigInput.filter(cat=>cat.config_id==s.id).map(cat=>cat.category_id).includes(c.id)
        )))
        let projects = projectInput.map(s => new Project(s.id, s.name, 
                                s.description, 
                                configs.filter(c=>c.id==s.config_id)[0]));
        if (page_project_id){
            State.setup(projects.filter(p=>p.id==page_project_id));
        }
        else{
            State.setup(projects);
        }
        
        
        
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
        let c = new ConfigPanel(leftContainer);
        let scope = new Scope(rightContainer);
        let commentPanel = new CommentPanel(rightContainer);
        let aboutLabel = new AboutLabel(rightContainer);
        let aboutPanel = new AboutPanel(rightContainer);
        let topTagPanel = new TopTagPanel(rightContainer);

        CityLayersPanel.activateProject = (project, active)=>{m.reloadProject(project, active)};
        CityLayersPanel.activation = (category, lower, upper)=>{m.reload(category, lower, upper)};

        CityLayersPanel.markertoggle = (subcat, on)=>{m.reloadMarkers(subcat, on)};
        CityLayersPanel.getCoords = ()=>{return m.getCoords();};
        MapPanel.toggleComment = (i, on)=>{ CommentPanel.focusComment(i, on)};
        CommentPanel.toggleMarker = (id, on)=>{m.activate(id, on)};
        
        c.initiate();
        m.initiate();
        commentPanel.initiate();
        topTagPanel.initiate();
        aboutLabel.initiate();
        aboutPanel.initiate();

        m.load(categories, obs);
        // c.load(categories);  // ["Accessibility", "Noise", "Safety", "Weather Resistance", "Amenities"]
        c.load(config);

        commentPanel.load(commentInput);
        topTagPanel.load();
        aboutLabel.load();
        aboutPanel.load();

        scope.initiate();
        
        // setTimeout(()=>{m.reload(obs)}, 0);
    </script>


@endsection
