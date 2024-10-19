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

@vite('resources/css/app.css')
@vite('resources/css/landing.css')


@section('main')
   
            <script>
                <?php require_once("js/classnames.js");?>
                
                <?php require_once("js/ui/component/celement.js");?>
                <?php require_once("js/ui/component/contentElement.js");?>
                <?php require_once("js/ui/component/imageElement.js");?>
                <?php require_once("js/ui/component/logo.js");?>
                <?php require_once("js/ui/component/switch.js");?>
                <?php require_once("js/ui/component/textElement.js");?>
                <?php require_once("js/ui/container.js");?>
                <?php require_once("js/ui/panel/contentPanel.js");?>
                <?php require_once("js/ui/component/projectComponent.js");?>
                <?php require_once("js/ui/panelcomponent/landing.js");?>
                <?php require_once("js/ui/panelcomponent/sectionMap.js");?>
                <?php require_once("js/ui/panel/homePanel.js");?>

                <?php require_once("js/logic/illustration.js");?>
                <?php require_once("js/logic/category.js");?>
                <?php require_once("js/logic/subcategory.js");?>
                <?php require_once("js/logic/config.js");?>
                <?php require_once("js/logic/project.js");?>
                <?php require_once("js/logic/projectInfo.js");?>
                <?php require_once("js/logic/state.js");?>

                
                let landing = new HomePanel();
                const FAKEDATA = false;
                const projectInput = {!! json_encode($projects) !!};
                
                const configInput = {!! json_encode($configs) !!};
                const catConfigInput = {!! json_encode($catconfigs) !!};
                

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
                )));
                

                let projectInfos = projectInput.map(s => new ProjectInfo(s.id, s.name, 
                                    s.subtitle, s.description, 
                                    [], []));
                
                
                let projects = projectInput.map(s => new Project(s.id, 
                                projectInfos.filter(e=>e.id==s.id)[0]
                            ));
                                
                landing.initiate();
                landing.load(projects);



            </script>
            


        <!-- </div> -->

        


    <!-- </div> -->
    
@endsection
