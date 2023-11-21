<?php include_once("../php/cn.php"); header("Access-Control-Allow-Origin:".AllowOriginAccess);header("Content-Type: text/plain; charset=UTF-8");  ?>
<nav class="containerx"  ng-if="CURPAGE==0"> 
<a target="_blank" ng-href="export/office/produits?id={{extra.level}}" class="buttons buttonsss bgm-red  bg" tooltipss="WORD"><i class="zmdi zmdi-word "></i></a>
<a target="_blank" ng-href="export/excel/produits?id={{extra.level}}" class="buttons buttonsss bgm-color1 bg" tooltipss="EXCEL"><i class="zmdi zmdi-excel "></i></a>
<a class="buttons  bgm-color2 bg " tooltipss="Imprimer" href="#"><i class="zmdi zmdi-print "></i></a>
</nav>
<div class="mobilenav visible-xs" ng-if="CURPAGE!=0">
<ul class="tab-nav tn-justified">
<li class="btn-wave" ng-click="cancellx()"><a href="#">  <i class="zmdi zmdi-reply "></i></a></li>
<li class="btn-wave" ng-click="save()"><a href="#">  <i class="zmdi zmdi-check-all "></i></a></li>
</ul></li>
</ul>
</div>
<div class="container p-t-30">
<div ng-class="{'card z-depth-2 border':CURPAGE!=4}">
<div class="listview lv-bordered lv-lg">
<div class="lv-header-alt clearfix " ng-show="CURPAGE==0">
<h2 class="lvh-label"><div ng-if="!MULTIPLE || selectedRowsIndexes.length==0" > <i class="zmdi zmdi-pills m-r-10"></i>Produits ({{TOTALITEMS}}) </div><ng-pluralize ng-if="MULTIPLE && selectedRowsIndexes.length>0" count="selectedRowsIndexes.length" when="{'0': 'Zéro ligne sélectionnée.','one': 'Une ligne sélectionnée .','other': '{} lignes sélectionnées.'}" ></ng-pluralize></h2>
<div class="lvh-search" ng-show="listviewSearchStat">
<i ng-click="listviewSearchStat = !listviewSearchStat" class="ah-search-close zmdi zmdi-long-arrow-left" ></i>
<input type="text" placeholder="Recherche dans la liste"  ng-keyup="$event.keyCode==27?listviewSearchStat =false:''" focus-me="listviewSearchStat" ng-model="serchfield"  ng-model-options="{debounce: 500}" ng-change="RELOAD()"  class="lvhs-input" />
<i class="lvh-search-close" ng-click="serchfield='';listviewSearchStat =false;RELOAD()">&times;</i>
</div>
<ul class="lv-actions actions">
<li tooltip-class="tooltip-blue" uib-tooltip="Recherche/بحث" > <a ng-class="{'pulse':serchfield.length>0}" href="#" class="ah-search-trigger" ng-click="listviewSearchStat = true;CURPAGE=0;"> <i class="zmdi zmdi-search" ></i>  </a></li>
<li tooltip-class="tooltip-blue" uib-tooltip="Supprimer"><a ng-class="!selectedItem && !MULTIPLE ?'opa3 ':''"  ng-click="delete()" href="#"><i class="zmdi zmdi-delete"></i></a></li>
<li tooltip-class="tooltip-blue" uib-tooltip="Modifier/تعديل"><a ng-class="selectedItem==null?'opa3 ':''"  ng-click="infos(1)" href="#"><i class="zmdi zmdi-edit"></i></a></li>
<li tooltip-class="tooltip-blue" uib-tooltip="Annuler/إلغاء"><a ng-class="(CURPAGE==0 && (!selectedItem && !MULTIPLE))?'opa3 ':''"  ng-click="cancell();" href="#"><i class="zmdi zmdi-reply"></i></a></li>
<li tooltip-class="tooltip-blue" uib-tooltip="Informations/معلومات"><a ng-class="selectedItem==null?'opa3 ':''"  ng-click="infos()" href="#"><i class="zmdi zmdi-info_outline"></i></a></li>
<li tooltip-class="tooltip-blue" uib-tooltip="Ajouter/إضافة"><a  ng-click="add_ligne()" href="#"><i class="zmdi zmdi-plus"></i></a></li>
<li tooltip-class="tooltip-blue" uib-tooltip="Rafraîchir/تحديث"><a  ng-click="RELOAD()" href="#"><i class="zmdi zmdi-refresh"></i></a></li>
<dh-paginate page-size="pageSize" ></dh-paginate>
</ul>
</div>
</div>
<div class="card-body o-hidden " style="min-height: 300px;"> <div class="smallloading" ng-if="kdenkleeze"></div>
<div ng-if="LoaDing" class="progggresdf" ><div id="cont" data-pct="{{PERCENTt}}">
<svg id="svg" width="200" height="200" viewPort="0 0 100 100" version="1.1" xmlns="http://www.w3.org/2000/svg">
<circle r="90" cx="100" cy="100" fill="transparent" stroke-dasharray="565.48" stroke-dashoffset="0"></circle>
<circle id="bar" r="90" cx="100" cy="100" fill="transparent" stroke-dasharray="565.48" stroke-dashoffset="0" style="stroke-dashoffset:{{proggg}}px;"></circle>
</svg>
</div></div>
<div class="">
<div role="tabpanel" class="tab">
<div class="tab-content p-0" >
<div role="tabpanel" class="tab-pane animated  slideIn{{class}} "  ng-class="{'active':CURPAGE==0}">		
<table-directive ></table-directive>
</div>
<div role="tabpanel" class="tab-pane animated  slideIn{{class}} "  ng-class="{'active':CURPAGE==4}">
<div class="row">
	<div class="col-md-8"><div class="card"><div class="card-header "><h2>Information générale </h2><ul class="lv-actions actions">
<li class="dropdown" uib-dropdown ><a href="#" uib-dropdown-toggle><i class="zmdi zmdi-more-vert"></i></a><ul class="dropdown-menu dm-icon dropdown-menu-right  m-l-10" >
<li ><a  target="_blank" ng-href="export/office/sn_products/{{CLX.id}}"><i class="zmdi zmdi-word"></i>Imprimer la synthèse</a></li>
<li ><a ng-class="selectedItem==null?'opa3 ':''" ng-if="PERMISSON[1].value"  ng-click="infos(1)" href="#"><i class="zmdi zmdi-edit"></i> Modifier</a></li>
</ul></li></ul></div>
		<div class="card-body p-10">
		<div class="row ">
			<div class="col-md-2"><img class="avatar" ng-src="img/120/120/produits/{{CLX.img}}&df=product_photo.png" /></div>
			<div class="col-md-5"><ul class="ulinfo">
			<li>Code barre  : <b>{{CLX.code}}</b></li>
			<li>Nom : <b>{{CLX.name}}</b></li>
			</ul></div>
			<div class="col-md-5"><ul class="ulinfo">
			<li>Nom : <b>{{CLX.name}}</b></li></ul>
			</ul>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
	</div>
	<div class="card" >
<div class="card-body p-10 c-white bgm-green">
	<fieldset class="m-0"><legend class="facture">Quantité</legend>
	<div class="row">
	<div class="col-md-4 text-center"><p>VENTES</p><p class="bigDigit">{{CLX.vt}}</p></div>
	<div class="col-md-4 text-center"><p>ACHATS</p><p class="bigDigit">{{CLX.ach}}</p></div>
	<div class="col-md-4 text-center"><p>RESTE</p><p class="bigDigit">{{CLX.ach-CLX.vt}}</p></div>
	</div>
	</fieldset>
</div>
</div>
	<div class="card"><div class="card-header "><h2>Ventes </h2></div>
		<div class="card-body p-0">
		<table-directive-static data-opts="VENTES" idx="CLX.id" ></table-directive-static>
		<div class="clearfix"></div>
	</div>
	</div>
	
	</div>
	<div class="col-md-4 " >
	<div class="card">
		<div class="card-header bgm-green"><h2>{{CLX.name}}</b> <a  class="p-absolute pull-right" style="    font-size: 34px;right: 14px;top: 11px;"   ng-click="cancellx();" href="#"><i class="zmdi zmdi-reply"></i></a></h2></div>
			<div class="card-body p-10 c-white  moneyBg bgm-green">
				<p>Prix</p><p class="bigDigit">{{CLX.prix|currency:''}}</p>
			</div>
		</div>
		
		<div class="card">
		<div class="card-header bgm-blue"><h2>Options</h2></div>
			<div class="card-body ">
				<div class="list-group lg-alt  lg-odd-black" >
				<div class="list-group-item media" >
				<div class="pull-right"><ul class="actions"><li  >
				<a ng-href="export/office/sn_products/{{CLX.id}}"  target="_blank"><i class="zmdi zmdi-print"></i></a></li></ul></div>
				<div class="media-body"><div class="lgi-heading" ><i class="zmdi zmdi-invoice2"></i> Imprimer la synthèse </div></div></div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header"><h2>Informations de traçabilité</h2></div>
			<div class="card-body">
				<ul class="list-group">
                        <li class="list-group-item"><span class="badge">{{(CLX.dt_crt|timeAgo)+" "+CLX.cr}}</span>Crée par</li>
                        <li class="list-group-item"><span class="badge" >{{CLX.dt_crt|date:'EEEE dd MMMM yyyy HH:mm:ss'}}</span>Crée le</li>
						<li class="list-group-item"><span class="badge" ng-show="CLX.up">{{(CLX.dt_update|timeAgo)+" "+CLX.up}}</span>Mis à jour par</li>
                        <li class="list-group-item"><span class="badge" ng-show="CLX.up">{{CLX.dt_update|date:'EEEE dd MMMM yyyy HH:mm:ss'}}</span>Mis à jour le</li>
                      </ul>
			</div>
		</div>
	</div>
</div>
</div>
<div role="tabpanel" class="tab-pane animated  slideIn{{class}} "  ng-class="{'active':CURPAGE==1}"><form name="FORM1" ng-submit="save()">
<div class="listview lv-bordered lv-lg">
<div class="lv-header-alt clearfix ">
<h2 class="lvh-label"><div  > <i class="zmdi zmdi-pills m-r-10"></i>Nouveau Produit</div></h2>
<ul class="lv-actions actions">
<li><button class="btn btn-default btn-icon-text waves-effect m-r-10" type="reset" ng-click="cancellx()"><i class="zmdi zmdi-cancel"></i> Fermer</button></li>
<li><button class="btn btn-success btn-icon-text waves-effect m-r-10" ng-if="INFO"   ng-click="modify()"><i class="zmdi zmdi-edit"></i> Modifier</button></li>
<li><button class="btn btn-primary btn-icon-text waves-effect" ng-disabled="FORM1.$invalid" type="submit" ng-if="!INFO"><i class="zmdi zmdi-check"></i> Enregistrer</button></li>
</ul>
</div>
</div>
<div class="row-padding p-t-20 formpadding">
<div class="col-12 col-sm-6 col-md-4 " >
<div class="form-group  has-feedback has-success" >
<label class="control-label" >Code barre</label>
<div class="fg-line"  ><input ng-disabled="INFO" placeholder=""  type="text" autocomplete="off"  class="form-control" ng-model="NEWITEM.code" >
</div>
</div>
</div>
<div class="col-12 col-sm-6 col-md-4 " >
<div class="form-group  has-feedback " ng-class="{'has-success':FORM1.nom.$valid,'has-warning':FORM1.nom.$touched && FORM1.nom.$invalid}">
<label class="control-label" >Nom </label>
<div class="fg-line"  ><input name="nom" uib-tooltip="Champ obligatoire" tooltip-class="tooltip-red" tooltip-placement="bottom" tooltip-trigger="focus" required ng-disabled="INFO"   type="text" autocomplete="off"  class="form-control" ng-model="NEWITEM.name" >
<span  ng-show="FORM1.nom.$touched" ng-class="{'zmdi-warning':FORM1.nom.$invalid,'zmdi-check-all':FORM1.nom.$valid}" class="zmdi  form-control-feedback"></span>
</div>
</div>
</div>

<!--<div class="col-12 col-sm-6 col-md-4 " >
<div class="form-group  has-feedback has-success" >
<label class="control-label" >Tel</label>
<div class="fg-line"  ><input ng-disabled="INFO" data-input-mask="{mask: '00 00 00 00 00'}" placeholder="00 00 00 00 00" type="tel" autocomplete="off"  class="form-control" ng-model="NEWITEM.tel">
</div>
</div>
</div>-->

<div class="col-12 col-sm-6 col-md-4 " >
<div class="form-group  has-feedback has-success" >
<label class="control-label" >Prix </label>
<div class="fg-line"  ><input ng-disabled="INFO" placeholder=""  type="number" min="0" step="any" autocomplete="off"  class="form-control" ng-model="NEWITEM.prix" >
</div>
</div>
</div>
<div class="col-12 col-sm-6 col-md-4" >
<div class="form-group  has-feedback has-success" >
<label class="control-label" >Quantité Min (Magasin)</label>
<div class="fg-line"  ><input ng-disabled="INFO" placeholder="Quantité alarmant magasin"  type="number" min="0"  autocomplete="off"  class="form-control" ng-model="NEWITEM.qn_min">
</div>
</div>
</div>

<div class="col-12 col-sm-6 col-md-4 " >480X480
<div class="fileinput fileinput-new" data-provides="fileinput">
<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="  background-image: url(img/120/120/produits/{{NEWITEM.img}});background-repeat: no-repeat;background-position: center;"></div>
<div class="text-center"><span class="btn btn-info btn-file"><span class="fileinput-new">Sélectionnez une image</span><span class="fileinput-exists">Changer</span><input type="file"  id="logoimg">
</span><a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Retirer</a>
</div>
</div>
</div>
<div class="col-12 col-sm-6 col-md-4 " ><img   class="img_preview" /></div>
</div>

</form>
</div><div class="clearfix"></div>           	   
</div>
</div>
</div>
</div>
</div>
</div>