<?php include_once("../php/cn.php"); header("Access-Control-Allow-Origin:".AllowOriginAccess);header("Content-Type: text/plain; charset=UTF-8");  ?>

<nav class="containerx"  ng-if="CURPAGE==0"> 

<a target="_blank" ng-href="export/pdf/fournisseurs" class="buttons buttonsss bgm-red  bg" tooltipss="PDF"><i class="zmdi zmdi-pdf "></i></a>

<a target="_blank" ng-href="export/excel/fournisseurs" class="buttons buttonsss bgm-color1 bg" tooltipss="EXCEL"><i class="zmdi zmdi-excel "></i></a>

<a target="_blank" ng-href="export/office/fournisseurs" class="buttons buttonsss bgm-color1 bg" tooltipss="WORD"><i class="zmdi zmdi-word "></i></a>

<a class="buttons  bgm-color2 bg " tooltipss="Imprimer" href="#"><i class="zmdi zmdi-print "></i></a>

</nav>

<div class="mobilenav visible-xs" ng-if="CURPAGE!=0">

<ul class="tab-nav tn-justified">

<li class="btn-wave" ng-click="cancellx()"><a href="#">  <i class="zmdi zmdi-reply "></i></a></li>

<li class="btn-wave" ng-click="save()"><a href="#">  <i class="zmdi zmdi-check-all "></i></a></li>

</ul></li>

</ul>

</div>

<div class="">

<div ng-class="{'card z-depth-2 border':CURPAGE!=4}">

<div class="listview lv-bordered lv-lg">

<div class="lv-header-alt clearfix " ng-show="CURPAGE==0">

<h2 class="lvh-label"><div ng-if="!MULTIPLE || selectedRowsIndexes.length==0" > <i class="zmdi zmdi-account m-r-10"></i> Fournisseurs ({{TOTALITEMS}})</div><ng-pluralize ng-if="MULTIPLE && selectedRowsIndexes.length>0" count="selectedRowsIndexes.length" when="{'0': 'Zéro ligne sélectionnée.','one': 'Une ligne sélectionnée .','other': '{} lignes sélectionnées.'}" ></ng-pluralize></h2>

<div class="lvh-search" ng-show="listviewSearchStat">

<i ng-click="listviewSearchStat = !listviewSearchStat" class="ah-search-close zmdi zmdi-long-arrow-left" ></i>

<input type="text" placeholder="Recherche dans la liste"  ng-keyup="$event.keyCode==27?listviewSearchStat =false:''" focus-me="listviewSearchStat" ng-model="serchfield"  ng-model-options="{debounce: 500}" ng-change="RELOAD()" class="lvhs-input" />

<i class="lvh-search-close" ng-click="serchfield='';listviewSearchStat =false;RELOAD()">&times;</i>

</div>

<ul class="lv-actions actions">

<li tooltip-class="tooltip-blue" uib-tooltip="Recherche/بحث" > <a ng-class="{'pulse':serchfield.length>0}" href="#" class="ah-search-trigger" ng-click="listviewSearchStat = true;CURPAGE=0;"> <i class="zmdi zmdi-search"  ></i> </a></li>

<li tooltip-class="tooltip-blue" uib-tooltip="Supprimer"><a ng-class="!selectedItem && !MULTIPLE ?'opa3 ':''" ng-if="PERMISSON[2].value"  ng-click="delete()" href="#"><i class="zmdi zmdi-delete"></i></a></li>

<li tooltip-class="tooltip-blue" uib-tooltip="Modifier/تعديل"><a ng-class="selectedItem==null?'opa3 ':''" ng-if="PERMISSON[1].value"  ng-click="infos(1)" href="#"><i class="zmdi zmdi-edit"></i></a></li>

<li tooltip-class="tooltip-blue" uib-tooltip="Annuler/إلغاء"><a ng-class="(CURPAGE==0 && (!selectedItem && !MULTIPLE))?'opa3 ':''"  ng-click="cancell();" href="#"><i class="zmdi zmdi-reply"></i></a></li>

<li tooltip-class="tooltip-blue" uib-tooltip="Informations/معلومات"><a ng-class="selectedItem==null?'opa3 ':''"  ng-click="infos()" href="#"><i class="zmdi zmdi-info_outline"></i></a></li>

<li tooltip-class="tooltip-blue" uib-tooltip="Ajouter/إضافة"><a  ng-click="add_ligne()" ng-if="PERMISSON[0].value" href="#"><i class="zmdi zmdi-plus"></i></a></li>

<li tooltip-class="tooltip-blue" uib-tooltip="Rafraîchir/تحديث"><a  ng-click="RELOAD()" href="#"><i class="zmdi zmdi-refresh"></i></a></li>

<dh-paginate page-size="pageSize" ></dh-paginate>

</ul>

</div>

</div>

<div class="card-body o-hidden " style="min-height: 300px;">
<div ng-if="loadingprofile"  class="progggresdf" ><div id="cont" data-pct="{{PERCENTt}}">
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

	<div class="col-md-8"><div class="card"><div class="card-header "><h2>Information générale </h2>

	<ul class="lv-actions actions">

<li class="dropdown" uib-dropdown ><a href="#" uib-dropdown-toggle><i class="zmdi zmdi-more-vert"></i></a><ul class="dropdown-menu dm-icon dropdown-menu-right  m-l-10" >

<li ><a  target="_blank" ng-href="export/office/sn_Fournisseurs/{{CLX.id}}"><i class="zmdi zmdi-word"></i>Imprimer la synthèse du Fournisseur </a></li>

<li ng-if="CLX.id" ng-click="goTo()"><a href="#"><i class="zmdi zmdi-archives"></i> Voir la synthèse du Fournisseur </a></li>

<li ><a ng-class="selectedItem==null?'opa3 ':''" ng-if="PERMISSON[1].value"  ng-click="infos(1)" href="#"><i class="zmdi zmdi-edit"></i> Modifier</a></li>

</ul></li></ul>

	</div>

		<div class="card-body p-10">

		<div class="row ">

			<div class="col-md-2"><img class="avatar" ng-src="img/120/120/coop/{{CLX.logo}}&df=cl.jpg" /></div>

			<div class="col-md-5"><ul class="ulinfo"><li>Nom/Raison sociale : <b>{{CLX.nom}}</b></li><li>Tel : <a href="tel:{{CLX.tel}}" ng-if="CLX.tel" class="c-blue" >{{CLX.tel}}</a></li></ul></div>

			<div class="col-md-5"><ul class="ulinfo"><li>Email : <b><a href="mailto:{{CLX.email}}" ng-if="CLX.email" class="c-blue" >{{CLX.email}}</a></b></li><li>Ville : <b>{{CLX.ville}}</b></li></ul></div>

		</div>

		<div class="clearfix"></div>

	</div>

	</div>

	

	<div class="card"><div class="card-header "><h2>Détails </h2></div>

		<div class="card-body p-10">

		<div class="row ">

			<div class="col-md-6"><ul class="ulinfo"><li>Nom/Raison sociale : <b>{{CLX.nom}}</b></li><li>Tel : <a href="tel:{{CLX.tel}}" ng-if="CLX.tel" class="c-blue" >{{CLX.tel}}</a></li>

				<li>ICE : <b>{{CLX.ice}}</b></li><li>Adresse : <b>{{CLX.addr}}</b></li>

			</ul></div>

			<div class="col-md-6"><ul class="ulinfo"><li>Email : <b><a href="mailto:{{CLX.email}}" ng-if="CLX.email" class="c-blue" >{{CLX.email}}</a></b></li><li>CIN/RC : <b>{{CLX.cin}}</b></li>

			<li>I.F : <b>{{CLX.iff}}</b></li><li>Ville : <b>{{CLX.ville}}</b></li>

			</ul></div>

			

		</div>

		<div class="clearfix"></div>

	</div>

	</div>

	<div class="card"><div class="card-header "><h2>Achats </h2></div>

		<div class="card-body p-0">

		<table-directive-static data-opts="LOTS" data-idx="CLX.id"></table-directive-static>

		<div class="clearfix"></div>

	</div>

	</div>

	<div class="card"><div class="card-header "><h2>Contacts </h2></div>

		<div class="card-body p-0">

		<table class=" tablex  table  teal hover " cellspacing="0" width="100%">

	<tbody>

		<tr><th style="width:auto" ><span >Titre</span></th><th style="width:auto" ><span >Nom</span></th><th style="width:auto" ><span >Tel</span></th><th style="width:auto" ><span >Email</span></th><th style="width:auto" ><span >Adresse</span></th></tr>

		<tr ng-repeat="x in CLX.contacts" >

			<td >{{x.titre}}</td><td >{{x.nom}}</td><td >{{x.tel}}</td><td >{{x.email}}</td><td >{{x.addr}}</td>

		</tr>

	</tbody>

</table>

		<div class="clearfix"></div>

	</div>

	</div>

	<div class="card"><div class="card-header "><h2>Chèques </h2></div>

		<div class="card-body p-0">

		<table class=" tablex  table  teal hover " cellspacing="0" width="100%">

	<tbody>

		<tr><th style="width:auto" ><span >Date Chèque</span></th><th style="width:auto" ><span >Num chèque</span></th><th style="width:auto" ><span >Total</span></th><th style="width:auto" ><span >Banque</span></th><th style="width:auto" ><span >Encaisser</span></th><th style="width:auto" ><span >Par </span></th></tr>

		<tr ng-repeat="x in CLX.ch" >

			<td >{{x.date_ch|date:'EEEE dd LLLL yyyy'}}</td><td >{{x.num}}</td><td >{{x.mtn|currency}}</td><td >{{x.bp}}</td><td >{{x.enc?"OUI":"NON"}}</td><td >{{x.cr}}</td>

		</tr>

	</tbody>

</table>

		<div class="clearfix"></div>

	</div>

	</div>

	</div>

	<div class="col-md-4 " >

	<div class="card">

		<div class="card-header "  ng-class="{'bgm-red':CLX.reste>0,'bgm-green':CLX.reste<=0}"><h2>Informations de paiements</b> <a  class="p-absolute pull-right" style="    font-size: 34px;right: 14px;top: 11px;"   ng-click="cancellx();" href="#"><i class="zmdi zmdi-reply"></i></a></h2></div>

			<div class="card-body p-10 c-white  moneyBg"  ng-class="{'bgm-red':CLX.reste>0,'bgm-green':CLX.reste<=0}">

				<p>TOTAL ACHAT</p>

				<p class="bigDigit">{{CLX.tt|currency:''}}</p>

				<p>TOTAL DE PAIEMENTS</p>

				<p class="bigDigit">{{CLX.payed|currency:''}}</p>

				<p>RESTE</p>

				<p class="bigDigit">{{CLX.reste|currency:''}}</p>

			</div>

		</div>

		<div class="card">

		<div class="card-header bgm-blue"><h2>Options</h2></div>

			<div class="card-body ">

				<div class="list-group lg-alt  lg-odd-black" >

				<div class="list-group-item media" >

				<div class="pull-right"><ul class="actions"><li  >

				<a ng-href="export/office/sn_Fournisseurs/{{CLX.id}}"  target="_blank"><i class="zmdi zmdi-print"></i></a></li></ul></div>

				<div class="media-body"><div class="lgi-heading" ><i class="zmdi zmdi-invoice2"></i> Imprimer la synthèse du Fournisseur </div></div></div>

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

<div class="action-header clearfix animatedx hidden-xs" style="margin-bottom:0px;">

<div class="ah-label  palette-White text"> </div>

<ul class="ah-actions actions a-alt">

<li><button class="btn btn-default btn-icon-text waves-effect m-r-10"  type="reset" ng-click="cancellx()"><i class="zmdi zmdi-cancel"></i> Fermer</button></li>

<li><button class="btn btn-primary btn-icon-text waves-effect"  ng-disabled="FORM1.$invalid" type="submit"  ng-if="!INFO"><i class="zmdi zmdi-check"></i> Enregistrer</button></li>

</ul>

</div>

<fieldset>

<legend class="z-depth-1-top">Infos</legend>

<div class="row-padding p-t-20 formpadding">
<div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 pull-right " >
<div class="fileinput fileinput-new" data-provides="fileinput">
<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="  background-image: url(img/120/120/coop/{{NEWITEM.logo}}&t=resize);background-repeat: no-repeat;background-position: center;"></div>
<div class="text-center">
<span class="btn btn-info btn-file">
<span class="fileinput-new">Sélectionnez une image</span><span class="fileinput-exists">Changer</span><input type="file" name="..." id="jpokpjj">
</span>
<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Retirer</a>
</div>
</div>
</div>

<div class="col-12 col-sm-6 col-md-4 clearfix" >

<div class="form-group  has-feedback has-success" >

<label class="control-label" for="name">Nom/Raison sociale</label>

<div class="fg-line"  ><input ng-disabled="INFO" placeholder="Nom/Raison sociale" tabindex="1" type="text" autocomplete="off"  class="form-control" ng-model="NEWITEM.nom" id="name" name="name">

</div>

</div>

</div>

<div class="col-12 col-sm-6 col-md-4" >

<div class="form-group  has-feedback has-success" >

<label class="control-label" >Tel</label>

<div class="fg-line"  ><input ng-disabled="INFO" data-input-mask="{mask: '00 00 00 00 00'}" placeholder="00 00 00 00 00" type="tel" autocomplete="off"  class="form-control" ng-model="NEWITEM.tel">

</div>

</div>

</div>

<div class="col-12 col-sm-6 col-md-4" >

<div class="form-group  has-feedback has-success" >

<label class="control-label" for="cin">CIN/R.C</label>

<div class="fg-line"  ><input ng-disabled="INFO" placeholder="CIN/R.C" tabindex="3" type="text" autocomplete="off"  class="form-control" ng-model="NEWITEM.cin" id="cin" name="cin">

</div>

</div>

</div>

<div class="col-12 col-sm-6 col-md-4" >

<div class="form-group  has-feedback has-success" >

<label class="control-label" for="iff">I.F</label>

<div class="fg-line"  ><input ng-disabled="INFO" placeholder="I.F" tabindex="4" type="text" autocomplete="off"  class="form-control" ng-model="NEWITEM.iff" id="iff" name="iff">

</div>

</div>

</div>

<div class="col-12 col-sm-6 col-md-4" >

<div class="form-group  has-feedback has-success" >

<label class="control-label" for="ice">I.C.E</label>

<div class="fg-line"  ><input ng-disabled="INFO" placeholder="I.C.E" tabindex="5" type="text" autocomplete="off"  class="form-control" ng-model="NEWITEM.ice" id="ice" name="ice">

</div>

</div>

</div>

<div class="col-12 col-sm-6 col-md-4" >

<div class="form-group  has-feedback has-success" >

<label class="control-label" for="email">Email</label>

<div class="fg-line"  ><input ng-disabled="INFO" placeholder="Email" tabindex="6" type="email" autocomplete="off"  class="form-control" ng-model="NEWITEM.email" id="email" name="email">

</div>

</div>

</div>

<div class="col-12 col-sm-6 col-md-6" >

<div class="form-group  has-feedback has-success" >

<label class="control-label" for="ville">Ville</label>

<div class="fg-line"  ><input ng-disabled="INFO" placeholder="Ville" tabindex="7" type="text" autocomplete="off"  class="form-control" ng-model="NEWITEM.ville" id="ville" name="ville">

</div>

</div>

</div>

<div class="col-12 col-sm-6 col-md-6" >

<div class="form-group  has-feedback has-success" >

<label class="control-label" for="addr">Adresse</label>

<div class="fg-line"  ><input ng-disabled="INFO" placeholder="Adresse" tabindex="8" type="text" autocomplete="off"  class="form-control" ng-model="NEWITEM.addr" id="addr" name="addr">

</div>

</div>

</div>

</div>

</fieldset>

</form>

</div><div class="clearfix"></div>           	   

</div>

</div>

</div>

</div>

</div>

</div>