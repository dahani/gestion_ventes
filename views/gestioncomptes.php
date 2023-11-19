<style>.zoomout.ng-hide-add-active{animation-name:zoomOut}</style>
<div class="container">
<div class="card m-b-20"><div class="smallloading" ng-if="LOADING_ACCOUNT"></div>
<div class="card-header ch-alt  bgm-brown ">
<h2>Droits d'accès <small>Gestion des droits d'accès des utilisateurs et création des comptes</small></h2>
<ul class="actions  actions-alt">
<li class="dropdown" uib-dropdown>
<a href="" uib-dropdown-toggle><i class="zmdi zmdi-more-vert"></i></a>
<ul class="dropdown-menu dropdown-menu-right dm-icon">
<li ng-click="addUser()"><a href="#"><i class="zmdi zmdi-plus"></i> Ajouter un utilisateur</a></li>
<li ng-click="load()"><a href="#"><i class="zmdi zmdi-refresh"></i> Rafraîchir</a></li>
<li ><a target="_blank" href="export/pdf/comptes"><i class="zmdi zmdi-print"></i> Imprimer Tous les comptes</a></li>
</ul>
</li>	
</ul>
</div>
<div role="tabpanel" class="tab">
<div class="tab-content o-hidden " style="padding: 0px;">
<div role="tabpanel" class="tab-pane animated fadeInLeft " style="padding-bottom: 60px" ng-class="{active:TAB1}" id="home9">
<div class="list-group lg-alt  lg-odd-black">
<p ng-click="addUser()" ng-if="COMPTE.length==0" class="p-20 text-center">0 utilisateur .<a href="#"> <i class="zmdi zmdi-plus"></i> Ajouter un utilisateur</a></p>
<div class="list-group-item media" ng-repeat="cn in COMPTE track by $index">

	<div class="pull-left">
		<img class="avatar-img" ng-src="img/60/60/profiles/{{cn.src}}&df=cl.jpg" alt="{{cn.name}}" />
	</div>
	<div class="pull-right">
		<ul class="actions">
		<li> <div class="toggle-switch m-r-20" data-ts-color="blue">
		<label for="{{cn.id}}" class="ts-label">  {{cn.active?"Activé":"Désactivé"}} </label><input ng-model="cn.active" ng-change="setAcive(cn.active,cn.id,cn.name)"  id="{{cn.id}}" type="checkbox" hidden="hidden"><label for="{{cn.id}}" class="ts-helper"></label>
		</div></li><li class="dropdown" uib-dropdown>
		<a href="#" uib-dropdown-toggle><i class="zmdi zmdi-more-vert"></i></a>
		<ul class="dropdown-menu dm-icon dropdown-menu-right m-l-10" ng-class="{'last':$last}">
		<li ng-click="setAccess(cn)"><a href="#"><i class="zmdi zmdi-edit"></i>  Modifier les droits </a></li>
		<li ng-click="setAdmin(cn)"><a href="#"><i class="zmdi zmdi-lock"></i>  Définir comme {{cn.admin==0?"Administrateur":"Utilisateur"}} </a></li>
		<li ng-click="deleteAccount(cn.id,cn.name,$index)"><a href="#"><i class="zmdi zmdi-delete"></i> Supprimer</a></li>
		</ul></li></ul></div>
	<div class="media-body">
		<div class="lgi-heading">{{$index+1}}- {{cn.name}} ({{cn.email}})</div>
		<small class="lgi-text"> <time-ago from-time="{{cn.createime}}"></time-ago> <span ng-if="cn.admin==1" class="bgm-yellow" style="border-radius: 16px;padding: 0px 6px;">Admin</span></small>
	</div>
</div>
</div>
</div>
<div role="tabpanel" class="tab-pane animated fadeInRight " ng-class="{active:!TAB1}" id="profile9">
<div class="">
<div class="action-header clearfix " style="margin-bottom:0px;border-radius: unset;">
<div class="ah-label  c-white text"><button ng-click="accessBack()" class="btn btn-link btn-icon-text waves-effect  text c-white"><i class="zmdi zmdi-arrow_back c-white"></i> Retour</button><span ng-if="!ADD" class="m-l-20">{{TMP_COMPT.name}}</span></div>
<ul class="actions actions a-alt">
<li><a data-toggle="tooltip" ng-click="saveNewAcount()" tooltip direction="left" title="Enregistrer"  href="#"><i class="zmdi zmdi-check-all"></i></a></li>
</ul>
</div>
<div class="card-body card-padding">
<form class="row ">
<div class="col-sm-4">
<div class="form-group fg-line"  floatinginput>
<label  >Email</label>
<input focus-me="ADD" type="text" ng-model="TMP_COMPT.email"  autocomplete="off" class="form-control input-sm"  placeholder="Enter email" />
</div>
</div>
<div class="col-sm-4">
<div class="form-group fg-line"  floatinginput>
<label  for="pass">Mot de passe</label>
<input type="password"  ng-model="TMP_COMPT.pass" autocomplete="off" class="form-control input-sm" id="pass" placeholder="Mot de passe" />
</div>
</div>
<div class="col-sm-4">
<div class="form-group fg-line"  floatinginput>
<label  for="namewx">Nom et Prénom</label>
<input type="text"  ng-model="TMP_COMPT.name" autocomplete="off" class="form-control input-sm" id="namewx" placeholder="Nom et Prénom" />
</div>
</div>
</form>
</div>
</div>
<div class="list-group lg-alt  lg-odd-black"><button ng-click="defaultPerm()" style="z-index: 5;" class="btn btn-primary btn-icon-text waves-effect pull-right m-r-10"><i class="zmdi zmdi-download"></i>  Permissions par Défaut</button>
<div drag-to-reorder-bind="TMP_COMPT.menus">
<div class="list-group-item media" ng-repeat="url in TMP_COMPT.menus track by $index"  ng-if="!url.hideConfig" dtr-draggable dtr-event="TMP_COMPT.menus">
<div class=" pull-left " ng-if="!url.locked">
<button ng-click="TMP_COMPT.menus.splice($index,1);"  data-toggle="tooltip" tooltip  title="Supprimer"   class="m-r-5 btn  btn-icon btn-danger  bg waves-effect waves-circle waves-float"><i class="zmdi zmdi-close"   ></i></button>
</div>
<div class="pull-right">
<button ng-repeat="(key,acc) in url.access" ng-model="acc.value"  ng-click="acc.value=!acc.value" ng-class="{'bgm-red':!acc.value,'bgm-blue':acc.value}" class="m-r-5 btn  btn-icon bg waves-effect waves-circle waves-float"><i class="zmdi zmdi-{{acc.icon}}"   ></i></button>
</div>
<div class="media-body"><div class="lgi-heading"><button  ng-if="(url.childrens.length>0 && !link.hideConfig)" ng-click="TMP_COMPT.menus.splice($index,1);"  data-toggle="tooltip" tooltip  title="Supprimer"   class="m-r-5 btn  btn-icon bgm-red bg waves-effect waves-circle waves-float"><i class="zmdi zmdi-close"   ></i></button><i class=" zmdi  f-20 c-blue p-relative zmdi-{{url.icon}}" style="top: 5px;"></i> {{url.text|uppercase}}</div></div>
<div class="list-group-item media m-l-25" ng-repeat="link in url.childrens" ng-if="(url.childrens.length>0 && !link.hideConfig)">
<div class=" pull-left " ng-if="!link.locked">
<button ng-click="url.childrens.splice($index,1);"  data-toggle="tooltip" tooltip  title="Supprimer"   class="m-r-5 btn  btn-icon bgm-red bg waves-effect waves-circle waves-float"><i class="zmdi zmdi-close"   ></i></button>
</div>
<div class="pull-right">
<button ng-repeat="(key,acc) in link.access" ng-model="acc.value"  ng-click="acc.value=!acc.value" ng-class="{'bgm-red':!acc.value,'bgm-blue':acc.value}" class="m-r-5 btn  btn-icon bg waves-effect waves-circle waves-float"><i class="zmdi zmdi-{{acc.icon}}"   ></i></button>
</div>
<div class="media-body"><div class="lgi-heading"><i class=" zmdi  f-20 c-blue p-relative zmdi-{{link.icon}}" style="top: 5px;"></i> {{link.text|uppercase}}</div></div>
</div>
</div>
</div>
</div>
</div>
<br><br><br>  </div>
</div>
</div>
</div>