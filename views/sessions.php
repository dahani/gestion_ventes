<style>
.list-group.lg-alt .list-group-item{border-bottom: 1px solid #dadada;}
.list-group.lg-alt .list-group-item{border-bottom: 1px solid #dadada;}
</style>
<div class="container">
<div class="card"><div class="smallloading" ng-if="LoaDing"></div>	
<div class="action-header clearfix m-b-0">
	<div class="ah-label  palette-White text"><div class="row-padding">
		<div class="col-xs-1 p-0"><button ng-click="addDay(1)" class="btn btn-link  waves-effect c-white "><i class="zmdi zmdi-long-arrow-left"></i></button></div><div class="col-xs-3 p-0"><input ng-change="load()" style="border-radius: 23px;padding: 0 11px;"  type="date" name="date" ng-model="SELECTED_DATE"  class="datepiker form-control"> </div><div class="col-xs-1 m-l-15 P-0"><button ng-click="addDay(0)" class="btn btn-link  waves-effect c-white"><i class="zmdi zmdi-long-arrow-right"></i></button></div><div class="c-white col-xs-4 hidden-xs m-t-15">{{SELECTED_DATE|date:'EEEE dd MMMM yyyy'}}</div>
	</div>
   </div>
	<ul class="ah-actions actions a-alt" >
		<li><a href="#" ng-click="load()"><i class="zmdi zmdi-refresh"></i></a></li>
		<li class="dropdown" uib-dropdown ><a href="#" uib-dropdown-toggle><i class="zmdi zmdi-sort"></i></a><ul class="dropdown-menu pull-right dm-icon dropdown-menu-right"><li><a ng-click="sort('name')">Nom</a></li><li><a href="#" ng-click="sort('dif')">Durée de session</a></li></ul></li>
		<dh-paginate page-size="pageSize" ></dh-paginate>
	</ul>
</div>
<div class="list-group lg-alt lg-even-black o-hidden" style="min-height: 152px;">
	<div class="list-group-item media no-animate" ng-repeat="x in LISTE track by $index">
	<div class="pull-left">
		<img class="avatar-img" ng-src="img/60/60/profiles/{{x.src}}&df=cl.jpg" alt="{{x.name}}" />
	</div>
	<div class="pull-right">
			<ul class="actions"><li class="" ><a    href="#"  ng-click="x.isCollapsed = !x.isCollapsed"><i class="zmdi zmdi-error_outline" style="color: inherit;"></i></a></li><li class=""><a href="#"   ng-click="openGraph(x.id_compte)"  ><i class="zmdi zmdi-chart-column" style="color: inherit;"></i></a></li></ul>
		</div>
	<div class="media-body">
		<div class="lgi-heading">{{$index+1}}- {{x.name}} - {{x.email}}</div>
		<small class="lgi-text"> {{x.dif}}</small>
		<div class="m-t-10 collapse" style="overflow-x: auto;" uib-collapse="!x.isCollapsed">
                <table class=" tablex table teal">
				<tr><th>Du</th><th>Au</th><th>Diff</th><th>IP</th><th>Type Appareil</th>
				<tr ng-repeat="y in x.lns"><td>{{y.start}}</td><td>{{y.end}}</td><td>{{y.dif}}</td><td>{{y.ip}}</td><td>{{y.type}}</td></tr>
			</table>
		</div>
	</div>
</div>
	<p ng-show="range.lower" class="text-center p-10 m-b-0" style="font-style: oblique;">Affichage de {{range.lower}} à  {{range.upper}} sur {{table2Options.TOTALITEMS}} Enregistrements</p>
	<uib-pagination ng-show="range.lower" total-items="table2Options.TOTALITEMS" max-size="10" items-per-page="table2Options.pageSize" ng-model="table2Options.currentPage" class="pagination " boundary-links="true" boundary-link-numbers="true" ng-change="pageChanged()" ></uib-pagination>
</div>
</div>
</div>