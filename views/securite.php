<?php include_once("../php/cn.php"); header("Access-Control-Allow-Origin:".AllowOriginAccess);header("Content-Type: text/plain; charset=UTF-8");  ?>

<div class="container">
<div class="card z-depth-2 border">
<div class="listview lv-bordered lv-lg">
<div class="lv-header-alt clearfix " >
<h2 class="lvh-label"> <i class="zmdi zmdi-security m-r-10"></i> Notifications de sécurité ({{TOTALITEMS}})</h2>
<ul class="lv-actions actions">
<li tooltip-class="tooltip-blue" uib-tooltip="Supprimer"><a ng-class="!selectedItem && !MULTIPLE ?'opa3 ':''"   ng-click="delete()" href="#"><i class="zmdi zmdi-delete"></i></a></li>
<li tooltip-class="tooltip-blue" uib-tooltip="Rafraîchir"><a  ng-click="RELOAD()" href="#"><i class="zmdi zmdi-refresh"></i></a></li>
<dh-paginate page-size="pageSize" ></dh-paginate>
</ul>
</div>
</div>
<div class="card-body o-hidden " style="min-height: 300px;"> <div class="smallloading" ng-if="LoaDing"></div>
<table-directive ></table-directive>
<div class="clearfix"></div>           	   
</div>
</div>
</div>