<?php include_once("../php/cn.php");
?>
<div class="container p-t-30" ><div class="smallloading" ng-if="loadinng"></div>
   <div class="block-header">
      <h2>Statistique</h2>
      <ul class="actions"><li><a href="#" ng-click="load()"><i class="zmdi zmdi-refresh "></i></a></li></ul>
   </div>
   <div class="card" >
	<div class="card-header bgm-purple">
		<h2>TOTAL INSCRIPTIONS PAR FORMATION </h2>
		<ul class="actions actions-alt"><li><a href="#" ng-click="globall()"><i class="zmdi zmdi-refresh "></i></a></li></ul>
	</div>
	<div class="card-body card-padding">
   <div class="row">
      <div class="col-sm-6 col-md-3 m-t-20" ng-repeat="x in SHARED.totals">
         <info-box type="1" data="x"></info-box>
      </div>
   </div>
   </div>
   </div>
   <div class="card" >
	<div class="card-header bgm-purple">
		<h2>TOTAL INSCRIPTIONS PAR FORMATION / OPÉRATEUR </h2>
		<ul class="actions actions-alt">
		<li class="dropdown"  >
		<select class="p-relative headertop creator"  ng-model="creator" ng-change="globall()">
		<?php foreach(getStConfig(COMPTE,"id,name","id",0,"",'<>') as $k=>$v){echo "<option  value='{$k}'>{$v}</option>";}?></select>
		</li>
		<li><a href="#" ng-click="globall()"><i class="zmdi zmdi-refresh "></i></a></li></ul>
	</div>
	<div class="card-body card-padding">
   <div class="row">
      <div class="col-sm-6 col-md-3 m-t-20" ng-repeat="x in SHARED.creator">
         <info-box type="1" data="x"></info-box>
      </div>
   </div>
   </div>
   </div>
   <div class="card">
	<div class="card-header bgm-purple">
		<h2>POURCENTAGE PAR (TYPE PUB / VISIT/INSCRIT) </h2>
		<ul class="actions actions-alt"><li><a href="#" ng-click="globall()"><i class="zmdi zmdi-refresh "></i></a></li></ul>
	</div>
	<div class="card-body card-padding">
   <div class="row clearfix"><div class="col-sm-3" ng-repeat="x in SHARED.percent"><div class="epc-item bgm-{{x.color}}"><div class="easy-pie main-pie" style="width: 100%;" color="{{x.bg}}" percent="x.v" data-easypie-chart><div class="percent">{{x.v}}<br><span style="font-size: 23px;">%</span></div><div class="pie-title">{{x.name}}</div></div></div></div></div>
   </div>
   </div>
   <div class="mini-charts"><div class="row"><div class="col-sm-6 col-md-3" ng-repeat="x in SHARED.spark"><sparkline-line config="x"></sparkline-line></div></div></div>
   <br class="clearfix"><br>
    <chart-widget type="column" devise="" stacking="normal" frm="0"   xtitle="Total" url="php/statistiques?action=dep_annee" id="9" double="true" title="CLIENTS" subtitle="Saisie par opérateur" isinput="true">...</chart-widget><br>
	 <chart-widget type="areaspline" devise="" frm="0"  xtitle="Total" url="php/statistiques?action=clients_annee" id="10" double="true" title="ClIENTS" subtitle="Clients par date viste/date inscription" isinput="true">...</chart-widget><br>
	 <chart-widget type="areaspline"   xtitle="Total" url="php/statistiques?action=money_annee" id="10"  title="Revenue" subtitle="Revenue/Mois" isinput="true">...</chart-widget><br>
	<chart-widget-drill type="column" list='true'  xtitle="Total Des Ventes"  url="php/statistiques?action=drill"  id="1223"  title="Statistiques par Ans " subtitle="Total des Revenues / Mois,Personnel,Formation" >...</chart-widget-drill>
	
	<chart-widget-drill type="column"   xtitle="Total Des Dépenses"  url="php/statistiques?action=drill1"  id="12423"  title="Statistiques par Ans " subtitle="Total des  Dépenses/Formation" >...</chart-widget-drill>
	
	<chart-piearchive frm="0"  url="php/statistiques?action=pub"  title="Clients" subtitle="Total des clients / Type Pub"></chart-piearchive>
	
	<chart-piearchive frm="0"  url="php/statistiques?action=Tel"  title="Num Tels" subtitle="Total des clients /Téléphone"></chart-piearchive>
	
	<chart-piearchive frm="0"  url="php/statistiques?action=from"  title="From" subtitle="Total des clients /From"></chart-piearchive>
</div>