<div class="container p-t-30" >
<div class="card clearfix"><notes-widget title="Liste des notes " description="Ajouter,modifier les ancienes notes"></notes-widget></div><br>
</div>

<div class="container-fluid">
	<div class="block-header">
		<h2>TYPOGRAPHY</h2>
	</div>
	<!-- Body Copy -->
	<info-box type="1" data="{title:'title'}"></info-box>
	<div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bgm-blue hover-expand-effect hover-zoom-effect">
                        <div class="icon"><i class="zmdi zmdi-pdf"></i></div>
                        <div class="content "><div class="text c-white ">BOUNCE RATE</div><div class="number c-white">62%</div></div>
                    </div>
                </div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-2 bgm-blue hover-zoom-effect">
                        <div class="icon">
                            <i class="zmdi zmdi-villes"></i>
                        </div>
                        <div class="content">
                            <div class="text">CPU USAGE</div>
                            <div class="number">92%</div>
                        </div>
                    </div>
                </div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box-3 bgm-blue hover-zoom-effect">
                        <div class="icon ">
                            <i class="zmdi zmdi-avatar6 c-white"></i>
                        </div>
                        <div class="content">
                            <div class="text">CPU USAGE</div>
                            <div class="number">92%</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box hover-expand-effect hover-zoom-effect">
                        <div class="icon bgm-green">
                            <i class="zmdi zmdi-avatar23"></i>
                        </div>
                        <div class="content">
                            <div class="text">FLIGHT</div>
                            <div class="number">02:59 PM</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                   <info-box data="x" ng-repeat="x in box" type="2" />
                </div>
				
				<div class="col-sm-6">{{run}}  <button ng-click="run=!run">activate</button>
                    <div class="card" waitme="run" opps="{text:'tex','effect':'timer'}"  style="height:200px" >
                        
                      test<br>test<br>test<br>test<br>test<br>test<br>test<br>ghhhhhhhhhhtest<br>test<br>
                    </div>
                </div>
				
            </div>
</div>