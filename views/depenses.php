<?php include_once("../php/cn.php"); header("Access-Control-Allow-Origin:".AllowOriginAccess);header("Content-Type: text/plain; charset=UTF-8");  ?>
<nav class="containerx"  ng-if="CURPAGE==0"> 
<a target="_blank" ng-href="export/pdf/depenses?id={{excercice}}&m={{mois}}&t={{extra.type}}" class="buttons buttonsss bgm-red  bg" tooltipss="PDF"><i class="zmdi zmdi-pdf "></i></a>
<a target="_blank" ng-href="export/excel/depenses?id={{excercice}}&m={{mois}}&t={{extra.type}}" class="buttons buttonsss bgm-color1 bg" tooltipss="EXCEL"><i class="zmdi zmdi-excel "></i></a>
<a target="_blank" ng-href="export/office/depenses?id={{excercice}}&m={{mois}}&t={{extra.type}}" class="buttons buttonsss bgm-color1 bg" tooltipss="WORD"><i class="zmdi zmdi-word "></i></a>
<a class="buttons  bgm-color2 bg " tooltipss="Imprimer" href="#"><i class="zmdi zmdi-print "></i></a>
</nav>
<div class="container p-t-30">
<div class=" ">
<div class="listview lv- lv-lg">
<div class="lv-header-alt clearfix " ng-show="CURPAGE==0">
<h2 class="lvh-label"><div ng-if="!MULTIPLE || selectedRowsIndexes.length==0" >  <i class="zmdi zmdi-coins m-r-10"></i>  Dépenses ({{TOTALITEMS}})</div><ng-pluralize ng-if="MULTIPLE && selectedRowsIndexes.length>0" count="selectedRowsIndexes.length" when="{'0': 'Zéro ligne sélectionnée.','one': 'Une ligne sélectionnée .','other': '{} lignes sélectionnées.'}" ></ng-pluralize></h2>
<div class="lvh-search" ng-show="listviewSearchStat">
<i ng-click="listviewSearchStat = !listviewSearchStat" class="ah-search-close zmdi zmdi-long-arrow-left" ></i>
<input type="text" placeholder="Recherche dans la liste"  ng-keyup="$event.keyCode==27?listviewSearchStat =false:''" focus-me="listviewSearchStat" ng-model="serchfield"  ng-model-options="{debounce: 500}" ng-change="RELOAD()" class="lvhs-input" />
<i class="lvh-search-close" ng-click="serchfield='';listviewSearchStat =false;RELOAD()">&times;</i>
</div>
<ul class="lv-actions actions">
<li tooltip-class="tooltip-blue" uib-tooltip="Recherche" > <a ng-class="{'pulse':serchfield.length>0}" href="#" class="ah-search-trigger" ng-click="listviewSearchStat = true;CURPAGE=0;"> <i class="zmdi zmdi-search"  ></i> </a></li>
<li tooltip-class="tooltip-blue" uib-tooltip="Supprimer"><a ng-class="!selectedItem && !MULTIPLE ?'opa3 ':''" ng-if="PERMISSON[2].value"  ng-click="delete()" href="#"><i class="zmdi zmdi-delete"></i></a></li>
<li tooltip-class="tooltip-blue" uib-tooltip="Modifier"><a ng-class="selectedItem==null?'opa3 ':''" ng-if="PERMISSON[1].value"  ng-click="infos(1)" href="#"><i class="zmdi zmdi-edit"></i></a></li>
<li tooltip-class="tooltip-blue" uib-tooltip="Annuler"><a ng-class="(CURPAGE==0 && (!selectedItem && !MULTIPLE))?'opa3 ':''"  ng-click="cancell();" href="#"><i class="zmdi zmdi-reply"></i></a></li>
<li tooltip-class="tooltip-blue" uib-tooltip="Informations"><a ng-class="selectedItem==null?'opa3 ':''"  ng-click="infos()" href="#"><i class="zmdi zmdi-info_outline"></i></a></li>
<li tooltip-class="tooltip-blue" uib-tooltip="Ajouter"><a  ng-click="add_ligne()" ng-if="PERMISSON[0].value" href="#"><i class="zmdi zmdi-plus"></i></a></li>
<li tooltip-class="tooltip-blue" uib-tooltip="Rafraîchir"><a  ng-click="RELOAD()" href="#"><i class="zmdi zmdi-refresh"></i></a></li>
<li class="dropdown"   tooltip-class="tooltip-blue" uib-tooltip="Année">
<select class="p-relative headertop"  ng-model="excercice" ng-change="RELOAD()"><?php for($i=date('Y');$i>=2010;$i--){echo "<option value='{$i}'>{$i}</option>";} ?></select>
</li>	
<li class="dropdown" tooltip-class="tooltip-blue" uib-tooltip="Mois" >
<select class="p-relative headertop" style="width:100px;" ng-model="mois" ng-change="RELOAD()">
<option value="-1">TOUS LES MOIS</option>
<?php foreach($MONTHS as $k=>$v){echo "<option value='{$k}'>{$v}</option>";} ?></select>
</li> 
<li class="dropdown" tooltip-class="tooltip-blue" uib-tooltip="Nature dépense" >
<select class="p-relative headertop" style="width:100px;"  ng-model="extra.type" ng-change="RELOAD()">
<option value="-1">TOUS</option><?php foreach(getStConfig(TYPE_DEP) as $k=>$v){echo "<option  value='{$k}'>{$v}</option>";}?></select>
</li> 
<dh-paginate page-size="pageSize" ></dh-paginate>
</ul>
</div>
</div>
<div class="card-body o-hidden " style="min-height: 300px;"> <div class="smallloading" ng-if="LoaDing"></div>
<div class="">
<div role="tabpanel" class="tab">
<div class="tab-content p-0" >
<div role="tabpanel" class="tab-pane animated  slideIn{{class}} "  ng-class="{'active':CURPAGE==0}">
<table-directive ></table-directive>
</div>
<div role="tabpanel" class="tab-pane animated  slideIn{{class}} "  ng-class="{'active':CURPAGE==1}"><form name="FORM1" ng-submit="save()">
<div class="row">
	<div class="" ng-class="{'col-md-8':NEWITEM.id,'col-md-12':!NEWITEM.id}"><div class="card">
	<div class="action-header clearfix animatedx " style="margin-bottom:0px;">
<div class="ah-label  palette-White text"> </div>
<ul class="ah-actions actions a-alt">
<li><button class="btn btn-default btn-icon-text waves-effect m-r-10"  type="reset" ng-click="cancellx()"><i class="zmdi zmdi-cancel"></i> Fermer</button></li>
<li><button class="btn btn-success btn-icon-text waves-effect m-r-10" ng-if="INFO" ng-click="modify()"><i class="zmdi zmdi-edit"></i> Modifier</button></li>
<li><button class="btn btn-primary btn-icon-text waves-effect"  ng-disabled="FORM1.$invalid" type="submit"  ng-if="!INFO"><i class="zmdi zmdi-check"></i> Enregistrer</button></li>
</ul>
</div>
<div class="row-padding p-t-20 formpadding">

<div class="col-12 col-sm-6 col-md-4 " >
<div class="form-group  has-feedback " ng-class="{'has-success':FORM1.mtn.$valid,'has-warning': FORM1.mtn.$invalid}">
<label class="control-label" >Montant *</label>
<div class="fg-line"  ><input name="mtn" uib-tooltip="Champ obligatoire" tooltip-class="tooltip-red" tooltip-placement="bottom" tooltip-trigger="focus" required ng-disabled="INFO"   type="number" autocomplete="off"  class="form-control" ng-model="NEWITEM.mtn" >
<span  ng-class="{'zmdi-warning':FORM1.mtn.$invalid,'zmdi-check-all':FORM1.mtn.$valid}" class="zmdi  form-control-feedback"></span>
</div>
</div>
</div>
<div class="col-12 col-sm-6 col-md-4 " >
<div class="form-group  has-feedback " ng-class="{'has-success':FORM1.date_.$valid,'has-warning': FORM1.date_.$invalid}">
<label class="control-label" >Date *</label>
<div class="fg-line"  ><input name="date_"  required ng-disabled="INFO"   type="date" autocomplete="off"  class="form-control" ng-model="NEWITEM.date_" >
</div>
</div>
</div>
<div class="col-12 col-sm-6 col-md-4" >
<div class="form-group  has-feedback has-success" >
<label class="control-label">Motif</label>
<div class="fg-line"  ><input ng-disabled="INFO" type="text" autocomplete="off"  class="form-control" ng-model="NEWITEM.motif" >
</div>
</div>
</div>

<div class="col-12 col-sm-6 col-md-4" >
<div class="form-group  has-feedback has-success" >
<label class="control-label" for="type_demande">Nature <span class="c-red">*</span></label>
<div class="fg-line"  ><select ng-disabled="INFO" class="form-control" required ng-model="NEWITEM.nature"   ><?php $lns=SQL_SELECT(TYPE_DEP,"1",1);foreach($lns['data'] as $k){echo "<option  value='{$k['id']}'>{$k['name']}</option>";}
?></select>
</div>
</div>
</div>
<div class="col-12 col-sm-6 col-md-4" >
<div class="form-group  has-feedback has-success" >
<label class="control-label" for="ps">Pièce joints</label>
<div class="fg-line"  ><input ng-disabled="INFO" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps" type="file" class="form-control"  id="ps" name="ps">
</div>
</div>
</div>
<div class="col-12 col-sm-12" ng-if="NEWITEM.id" >
<img  ng-src="img/ps/{{NEWITEM.img}}" />
</div>
<div class="clearfix"></div>  
</div>
	</div></div>
	<div class="col-md-4 " ng-show="NEWITEM.id">
		<div class="card">
			<div class="card-header"><h2>Informations de traçabilité</h2></div>
			<div class="card-body">
				<ul class="list-group">
                        <li class="list-group-item"><span class="badge">{{NEWITEM.dt_crt|timeAgo}}</span><span class="badge">{{NEWITEM.cr}}</span></span>Crée par</li>
                        <li class="list-group-item"><span class="badge" >{{NEWITEM.dt_crt|date:'EEEE dd MMMM yyyy HH:mm:ss'}}</span>Crée le</li>
						<li class="list-group-item"><span class="badge" ng-show="NEWITEM.up">{{NEWITEM.dt_update|timeAgo}}</span><span class="badge">{{NEWITEM.up}}</span></span>Mis à jour par</li>
                        <li class="list-group-item"><span class="badge" ng-show="NEWITEM.up">{{NEWITEM.dt_update|date:'EEEE dd MMMM yyyy HH:mm:ss'}}</span>Mis à jour le</li>
                      </ul>
			</div>
		</div>
	</div>
</div>
</div><div class="clearfix"></div>           	   
</div>
</div>
</div>
</div>
</div>
</div>