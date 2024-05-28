@php use \App\Http\Controllers\GlobalController; @endphp
@php  $places = GlobalController::places();@endphp
@php  $comments = GlobalController::comments();@endphp
@php  $categories = GlobalController::categories();@endphp
@php  $subcategories = GlobalController::subcategories();@endphp
@php
    $locale = session()->get('locale');
    if ($locale == null) {
        $locale = 'en';
    }
@endphp

@extends('layouts.app')
@vite('resources/css/container.css')
@vite('resources/css/commentbar.css')
@vite('resources/css/sidepanel.css')
@vite('resources/css/map.css')
@vite('resources/js/map.js')
@vite('resources/js/citymap.js')
@vite('resources/js/category.js')
@vite('resources/js/dataGenerator.js')

@section('main')
<!-- @vite('resources/js/container.js') -->
@vite('resources/js/citymap.js')
<!-- @vite('resources/js/commentbar.js') -->
@vite('resources/js/category.js')
@vite('resources/js/dataGenerator.js')
@vite('resources/css/sidepanel.css')
@vite('resources/css/container.css')
@vite('resources/css/map.css')

<div class="left-container"></div>
<div class="right-container"></div>
    
    <script>
        <?php require_once("js/container.js");?>
        <?php require_once("js/citymap.js");?>
        <?php require_once("js/commentbar.js");?>
        <?php require_once("js/category.js");?>
        <?php require_once("js/dataGenerator.js");?>
    </script>
    <!-- <script src="resources/js/map.js"></script> -->
    <script>
        function saveGrade() {
            
            let latitude = 59.334591;
            let longitude = 18.063240;
            
            // console.log("E", e);
            // console.log($(e));
            // console.log($(e).parent().find('.feedback'));
            
            //const data = $(e).parent().find('.feedback').val();
            // const data = {"grade": 0.7};
            const label = 67; //$(e).parent().find('.feedback').val();
            const id = "123"; //$(e).parent().find('.feedback').data('id');

            // $(e).parent().find('.hideCommentBox').click();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]')  //.attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: "/save-grade",
                data: {
                    data: data,
                    label: label,
                    id: id
                     },
            });
        }
        

        let rightContainer = "right-container"; 
        let leftContainer = "left-container"; 
        const placeInput = {!! json_encode($places) !!};
        const commentInput = {!! json_encode($comments) !!};
        const categoryInput = {!! json_encode($categories) !!};
        const subcategoryInput = {!! json_encode($subcategories) !!};
        
        let subcats = subcategoryInput.map(s => new Subcategory(s.id, s.name, s.category_id));
        let categories = categoryInput.map(c => new Category(c.id, c.name, 
                                                             c.description, 
                                                             subcats.filter(e=>e.parent_id==c.id),
                                                             c.color
                                                            ));
        let obs = [];
        let comments = [
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

        for (let c=0; c<categories.length; c++){
            obs = obs.concat(ObservationGenerator.make(10, categories[c].name, 2));
        }

        SubcatAssigner.make(obs, subcats);
        CommentAssigner.make(obs, comments);

        let m = new MapPanel(rightContainer);
        let c = new CategoryPanel(leftContainer, 
                    (category, lower, upper)=>{m.reload(category, lower, upper)}, 
                    (category, lower, upper)=>{m.reload(category, lower, upper)},
                );
        let commentPanel = new CommentPanel(rightContainer);
        let aboutLabel = new AboutLabel(rightContainer);
        let aboutPanel = new AboutPanel(rightContainer);
        let topTagPanel = new TopTagPanel(rightContainer);

        CategoryPanel.markertoggle = (subcat, on)=>{m.reloadMarkers(subcat, on)};
        MapPanel.toggleComment = (i, on)=>{CommentPanel.focusComment(i, on)};
        CommentPanel.toggleMarker = (id, on)=>{m.activate(id, on)}
        
        c.initiate();
        m.initiate();
        commentPanel.initiate();
        topTagPanel.initiate();
        aboutLabel.initiate();
        aboutPanel.initiate();


        m.load(categories, obs);
        c.load(categories);  // ["Accessibility", "Noise", "Safety", "Weather Resistance", "Amenities"]
        commentPanel.load(comments);
        topTagPanel.load();
        aboutLabel.load();
        aboutPanel.load();
        // saveGrade();
        
        setTimeout(()=>{m.reload(obs)}, 0);
    </script>


@endsection
