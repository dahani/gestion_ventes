<div class=" p-relative"><button class="bgm-blue btn btn-float m-btn visible-xs"  ng-click="save()"  style="right: 10px;"><i class="zmdi zmdi-check-all"></i></button>
<div class="card  m-b-0 border">
<div class="listview lv-bordered lv-lg">
<div class="lv-header-alt clearfix ">
<h2 class="lvh-label"> <i class="zmdi zmdi-email  m-r-10"></i>Email Template </h2>
<ul class="lv-actions actions hidden-xs"><li ><a  ng-click="save()" href="#"><i class="zmdi zmdi-check-all"></i></a></li></ul>
</div>
</div>
<div class="card-body card-padding"><div class="smallloading" ng-if="LoaDing"></div>
<div class="row clearfix">
<div class="col-12 col-sm-12" >
<div class="form-group  has-feedback has-success" >
<label >Règlement de crédits</label><p><code ng-click="addText('[#nom]')">[#nom]</code> <code ng-click="addText('[#reste]')">[#reste]</code> </p>
<div class="fg-line"  ><textarea  rows="6" id="emailTEXT" class="form-control" ng-model="TMPLS.credits" ></textarea>
</div>
</div>
</div>
</div>
</div>
</div>
</div>