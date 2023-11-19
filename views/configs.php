<div class=" p-relative"><button class="bgm-blue btn btn-float m-btn visible-xs"  ng-click="save()"  style="right: 10px;"><i class="zmdi zmdi-check-all"></i></button>
<div class="card m-b-0 z-depth-1">
<div class="listview lv-bordered lv-lg">
<div class="lv-header-alt clearfix ">
<h2 class="lvh-label"> <i class="zmdi zmdi-settings  m-r-10"></i>CONFIGS </h2>
<ul class="lv-actions actions hidden-xs"><li ><a  ng-click="save()" href="#"><i class="zmdi zmdi-check-all"></i></a></li></ul>
</div>
</div>
<div class="card-body card-padding"><div class="smallloading" ng-if="LoaDing"></div>
<div class="row m-t-20">
<div class="col-md-6"><p><b>Date d'expiration des produits</b></p>
<p class="f-15"><b>{{CONFIGS.config.t_expire}}</b> Jours avant la date d'expiration</p>
<div class="range range-positive"><i class="icon">1</i><input  type="range" step="1"  min="1" max="60" ng-model="CONFIGS.config.t_expire" ><i class="icon">60</i></div>
</div>
<div class="col-md-6">
<div class="checkbox "><label><input type="checkbox" ng-model="CONFIGS.nf.clientUpdate"><i class="input-helper"></i>Inscription modifié</label></div>
</div>
</div>
</div>
</div>
</div>