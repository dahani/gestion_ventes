<div class="right-sidebar c-overflow"><div class="smallloading" style="z-index: 135;" ng-if="LoaDing"/>
<div class=" p-relative o-hidden">
<div  class="chat_tab"style="position: fixed;top: 66px;background: whitesmoke;z-index: 100;width: 300px;"><ul class="tab-nav tn-justified" role="tablist" data-tab-color="amber">
<li ng-class="{active:CURPAGE==0}" class="waves-effect"><a  ng-click="CURPAGE=0;"><i class="zmdi zmdi-settings" style="font-size: 18px;color: #2379ff;"></i></a></li>
<li ng-class="{active:CURPAGE==1}" class=" waves-effect"><a  ng-click="CURPAGE=1"><i class="zmdi zmdi-color_lenspalette" style="font-size: 18px;color: #2379ff;"></i></a></li>
<li ng-class="{active:CURPAGE==2}" class=" waves-effect"><a  ng-click="CURPAGE=2"><i class="zmdi zmdi-chat" style="font-size: 18px;color: #2379ff;"></i></a></li>
</ul></div>
<div class="tab-content  p-0" >
<div role="tabpanel" class="tab-pane animated  slideInRight  " ng-class="{active:CURPAGE==1}">
<ul class="setting-list colortab m-0 ">
<li><p>Background Color </p><input type="color" ng-model-options="{debounce: 200}"   ng-model="AutoDecon.theme.bgcolor" ng-change="setBgColor()" /></li>
<li><p>Color </p><input type="color" ng-model-options="{debounce: 200}"  ng-model="AutoDecon.theme.primarycolor" ng-change="setColor()" /></li>
</ul>
<ul class="setting-list colortab m-0 xsd">
<li  data-ng-click="setColor3(w)" class="skin-switch text-center " ng-style="{'background-color':w[0]}"   ng-repeat="w in skinList track by $index"><span ng-style="{'color':w[1]}">A</span></li>
</ul>
</div>
<div role="tabpanel" class="tab-pane animated  slideInRight  p-t-10" ng-class="{active:CURPAGE==0}">
<p>Déconnexion automatique </p>
<ul class="setting-list">
<li>
<div class="toggle-switch " data-ts-color="blue">
<label for="ts2a" class="ts-label">Active</label>
<input id="ts2a" ng-change="saveAuto()" ng-model="AutoDecon.AutoD.active" type="checkbox" hidden="hidden">
<label for="ts2a" class="ts-helper pull-right"/>
</div>
<br>
<select class="form-control m-t-20" ng-change="saveAuto()" ng-disabled="!AutoDecon.AutoD.active" ng-model="AutoDecon.AutoD.time">
<option value="0">-----------</option><option value="1">1 minute</option><option value="3">3 minutes</option><option value="5">5 minutes</option><option value="10">10 minutes</option><option value="15">15 minutes</option>
</select>
</li>

</ul>

<p>Header </p>
<ul class="setting-list">
<li>
<select class="form-control m-t-20" ng-change="saveAuto()"  ng-model="AutoDecon.header">
<option value="1">Header 1</option><option value="2">Header 2 </option>
</select>
</li>
</ul>
<ul class="setting-list" ng-hide="IS_MOBILE">
<li class="p-0"><p>Imprimantes</p></li>
<li >
<div class="form-group  has-feedback has-success" >
<label>Imprimante de ticket </label>
<div class="fg-line"  ><select class="form-control" ng-change="chsdz()" ng-model="LOCALCONFIG.printer"   ng-options="item for item  in PRINTERS"></select>
</div>
</div>
</li>
</ul>
</div>
<div role="tabpanel" class="tab-pane animated  slideInRight  " ng-class="{active:CURPAGE==2}">
<p>Font Size {{AutoDecon.theme.fontsize}} px</p>
<div class="range range-positive"><i class="icon">10</i><input  type="range" step="1" ng-change="SetFontSize()" min="10" max="26" ng-model="AutoDecon.theme.fontsize" ><i class="icon">26</i></div>
<ul class="setting-list colortab m-0">
<li data-ng-click="setFonts(w)" class="skin-switch" ng-class="{'bgm-lightblue c-white':w==AutoDecon.theme.fontfamily}" style="font-family:'{{w}}'"   ng-repeat="w in FontsList track by $index">&nbsp;{{w}}</li>
</ul>
</div>
</div>
</div>
</div>