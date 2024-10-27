
@php
    $locale = session()->get('locale');
    if ($locale == null) {
        $locale = 'en';
    }
@endphp

@extends('layouts.app')


@vite('resources/css/projectCard.css')
@vite('resources/css/app.css')

@section('main')
   
            <script>
                <?php require_once("js/classnames.js");?>

                <?php require_once("js/logic/category.js");?>
                <?php require_once("js/logic/subcategory.js");?>    
                <?php require_once("js/logic/config.js");?>
                <?php require_once("js/logic/illustration.js");?>
                <?php require_once("js/logic/partner.js");?>
                <?php require_once("js/logic/projectInfo.js");?>
                <?php require_once("js/logic/project.js");?>
                <?php require_once("js/logic/teamperson.js");?>
                <?php require_once("js/logic/state.js");?>
               
                <?php require_once("js/ui/component/celement.js");?>
                <?php require_once("js/ui/component/contentElement.js");?>
                <?php require_once("js/ui/component/imageElement.js");?>
                
                <?php require_once("js/ui/component/logo.js");?>
                <?php require_once("js/ui/component/partnerElement.js");?>
                <?php require_once("js/ui/component/closeButton.js");?>
                <?php require_once("js/ui/component/switch.js");?>
                <?php require_once("js/ui/component/textElement.js");?>
                <?php require_once("js/ui/component/linkElement.js");?>
                
                <?php require_once("js/ui/container.js");?>
                <?php require_once("js/ui/panel/contentPanel.js");?>
                <?php require_once("js/ui/component/projectComponent.js");?>
                <?php require_once("js/ui/panelcomponent/legal.js");?>
                
                <?php require_once("js/ui/component/imageContainerElement.js");?>
                
                
                <?php require_once("js/ui/panelcomponent/landing.js");?>
                <?php require_once("js/ui/panel/legal.js");?>
                <?php require_once("js/ui/panel/projectCard.js");?>

                <?php require_once("js/graph/graph.js");?>

                let project_name = "Urban%20Observations%202024";

                const FAKEDATA = false;
                let project_id_input = {!! json_encode($project_id) !!};
                
                let projectImages = [];
                // let awards = AwardParser.makeAll(awardInput);

                let db = new DBConnection();
                let team = [];
                let partners = [];
                let awards = [];
                let config = new Config();

                db.init()
                    
                    .then(d=>
                        db.read(QUERYS.PROJECT_TEAM, {"name": project_name.replaceAll("%20", " ")})
                        .then(res =>{
                        res.forEach(r => {
                            let role = r.get('r').properties.value;
                            let name = r.get('t').properties.name;
                            let link = r.get('t').properties.link;
                            team.push(new TeamPerson(name, link, role, false));
                        }
                            );
                        })
                    )
                    .then(d=>
                        db.read(QUERYS.PROJECT_ILLUSTRATIONS, {"name": project_name.replaceAll("%20", " ")})
                        .then(res =>{
                        res.forEach(r => {
                            let name = r.get('illustration').properties.name;
                            let caption = r.get('illustration').properties.caption;
                            projectImages.push(new Illustration(name, caption));
                        }
                            );
                        })
                    )
                    .then(d=>
                        db.read(QUERYS.PROJECT_PARTNERS, {"name": project_name.replaceAll("%20", " ")})
                        .then(res =>{
                        res.forEach(r => {
                            let image = r.get('partner').properties.logo;
                            let name = r.get('partner').properties.name;
                            let link = r.get('partner').properties.link;
                            partners.push(new Partner(name, image, link));
                        }
                            );
                        })
                    )
                    .then(d=>
                        db.read(QUERYS.PROJECT_RECOGNITION, {"name": project_name.replaceAll("%20", " ")})
                        .then(res =>{
                        res.forEach(r => {
                            let partner = r.get('partner').properties.value;
                            let recognition = r.get('recognition').properties.name;
                            awards.push(new Recognition(recognition, partner));
                        }
                            );
                        })
                    )
                    .then(d => db.read(QUERYS.PROJECT_NAME, {"name": project_name.replaceAll("%20", " ")}))
                        .then(res =>{
                            
                            props = res[0].get("p").properties;
                            let name = props.name;
                            let period = new ProjectPeriod(props.start_date, props.end_date);
                            let subtitle = props.subtitle;
                            let descr = props.description;
                            let mappable = props.mappable;
                            let pinfo = new ProjectInfo(name, subtitle, descr, period, 
                                                                awards,
                                                                projectImages, partners, team);
                            return new Project(
                                                pinfo,
                                                config
                                                );
                            
                            
                        })
                    .then(
                        r=>{
                            constructPage(r);
                            return;
                        }
                    )
                    
                    ;
                
                function constructPage(project){
                    let page = new ProjectCardPanel( "main", project);
                    console.log("initiate");
                    page.initiate();
                    page.load(project);
                }



            </script>
            


        <!-- </div> -->

        


    <!-- </div> -->
    
@endsection
