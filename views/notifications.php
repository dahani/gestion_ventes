<style>.list-group.lg-alt .list-group-item{border-bottom: 1px solid #dadada;}</style>
<div class="container">
<div class="card">
<div class="smallloading" ng-if="LoaDing"></div>
<div class="listview lv-bordered lv-lg">
<div class="lv-header-alt clearfix " style="background: #009adb!important;">
<h2 class="lvh-label"><div > <i class="zmdi zmdi-notifications m-r-10"></i> Notifications ({{DATA.exp.length}})</div></h2>
<div class="lvh-search" ng-show="listviewSearchStat">
<i ng-click="listviewSearchStat = !listviewSearchStat" class="ah-search-close zmdi zmdi-long-arrow-left" ></i>
<input type="text" placeholder="Recherche dans la liste"  ng-keyup="$event.keyCode==27?listviewSearchStat =false:''" focus-me="listviewSearchStat" ng-model="serchfield"  class="lvhs-input" />
<i class="lvh-search-close" ng-click="serchfield='';listviewSearchStat =false">&times;</i>
</div>
<ul class="lv-actions actions">
<li><a href="#" class="ah-search-trigger" ng-click="listviewSearchStat=true"><i class="zmdi zmdi-search"></i></a></li>
<li><a href="#" ng-click="load()"><i class="zmdi zmdi-refresh"></i></a></li>
</ul>
</div>
</div>
<div ng-show="DATA.exp.length>0">
<div class="card-header p-b-0 p-10 " ng-random-class style="cursor: pointer;" >
<h2 ng-click="exp = !exp">Produits Expire prochainement ({{DATA.exp.length}}) </h2> 
</div>
<div class="list-group lg-alt lg-even-black o-hidden" uib-collapse="!exp">
<div class="list-group-item media no-animate" ng-repeat="x in DATA.exp | filter:serchfield track by $index" >
<div class="pull-left">
<div ng-random-class class="avatar-char z-depth-1">{{x.pr|capitalize}}</div>
</div>
<div class="media-body">
<div class="pull-right hidden-xs"><a  data-ui-sref="app.produits" >Liste des Produits</a></div>
<div class="lgi-heading"><b>{{x.pr}}</b> - Fournisseur : <b> {{x.frn}}</b>- Date péremption : <b> {{x.date_pre|date:'EEEE dd LLLL yyyy'}}</b> </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>