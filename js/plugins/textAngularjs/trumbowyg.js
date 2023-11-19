/** Trumbowyg v2.17.0 - A lightweight WYSIWYG editor - alex-d.github.io/Trumbowyg - License MIT - Author : Alexandre Demode (Alex-D) / alex-d.fr */
jQuery.trumbowyg={langs:{en:{viewHTML:"View HTML",undo:"Undo",redo:"Redo",formatting:"Formatting",p:"Paragraph",blockquote:"Quote",code:"Code",header:"Header",bold:"Bold",italic:"Italic",strikethrough:"Stroke",underline:"Underline",strong:"Strong",em:"Emphasis",del:"Deleted",superscript:"Superscript",subscript:"Subscript",unorderedList:"Unordered list",orderedList:"Ordered list",insertImage:"Insert Image",link:"Link",createLink:"Insert link",unlink:"Remove link",justifyLeft:"Align Left",justifyCenter:"Align Center",justifyRight:"Align Right",justifyFull:"Align Justify",horizontalRule:"Insert horizontal rule",removeformat:"Remove format",fullscreen:"Fullscreen",close:"Close",submit:"Confirm",reset:"Cancel",required:"Required",description:"Description",title:"Title",text:"Text",target:"Target",width:"Width"}},plugins:{},svgPath:null,hideButtonTexts:null},Object.defineProperty(jQuery.trumbowyg,"defaultOptions",{value:{lang:"en",fixedBtnPane:!1,fixedFullWidth:!1,autogrow:!1,autogrowOnEnter:!1,imageWidthModalEdit:!1,prefix:"trumbowyg-",semantic:!0,semanticKeepAttributes:!1,resetCss:!1,removeformatPasted:!1,tabToIndent:!1,tagsToRemove:[],tagsToKeep:["hr","img","embed","iframe","input"],btns:[["viewHTML"],["undo","redo"],["formatting"],["strong","em","del"],["superscript","subscript"],["link"],["insertImage"],["justifyLeft","justifyCenter","justifyRight","justifyFull"],["unorderedList","orderedList"],["horizontalRule"],["removeformat"],["fullscreen"]],btnsDef:{},inlineElementsSelector:"a,abbr,acronym,b,caption,cite,code,col,dfn,dir,dt,dd,em,font,hr,i,kbd,li,q,span,strikeout,strong,sub,sup,u",pasteHandlers:[],plugins:{},urlProtocol:!1,minimalLinks:!1},writable:!1,enumerable:!0,configurable:!1}),function(e,t,n,a){"use strict";var o="tbwconfirm",r="tbwcancel";a.fn.trumbowyg=function(e,t){var n="trumbowyg";if(e===Object(e)||!e)return this.each(function(){a(this).data(n)||a(this).data(n,new i(this,e))});if(1===this.length)try{var o=a(this).data(n);switch(e){case"execCmd":return o.execCmd(t.cmd,t.param,t.forceCss);case"openModal":return o.openModal(t.title,t.content);case"closeModal":return o.closeModal();case"openModalInsert":return o.openModalInsert(t.title,t.fields,t.callback);case"saveRange":return o.saveRange();case"getRange":return o.range;case"getRangeText":return o.getRangeText();case"restoreRange":return o.restoreRange();case"enable":return o.setDisabled(!1);case"disable":return o.setDisabled(!0);case"toggle":return o.toggle();case"destroy":return o.destroy();case"empty":return o.empty();case"html":return o.html(t)}}catch(r){}return!1};var i=function(o,r){var i=this,s="trumbowyg-icons",l=a.trumbowyg;i.doc=o.ownerDocument||n,i.$ta=a(o),i.$c=a(o),r=r||{},null!=r.lang||null!=l.langs[r.lang]?i.lang=a.extend(!0,{},l.langs.en,l.langs[r.lang]):i.lang=l.langs.en,i.hideButtonTexts=null!=l.hideButtonTexts?l.hideButtonTexts:r.hideButtonTexts;var d=null!=l.svgPath?l.svgPath:r.svgPath;if(i.hasSvg=d!==!1,i.svgPath=i.doc.querySelector("base")?t.location.href.split("#")[0]:"",0===a("#"+s,i.doc).length&&d!==!1){if(null==d){for(var c=n.getElementsByTagName("script"),u=0;u<c.length;u+=1){var g=c[u].src,f=g.match("trumbowyg(.min)?.js");null!=f&&(d=g.substring(0,g.indexOf(f[0]))+"ui/icons.svg")}null==d&&console.warn("You must define svgPath: https://goo.gl/CfTY9U")}var h=i.doc.createElement("div");h.id=s,i.doc.body.insertBefore(h,i.doc.body.childNodes[0]),a.ajax({async:!0,type:"GET",contentType:"application/x-www-form-urlencoded; charset=UTF-8",dataType:"xml",crossDomain:!0,url:d,data:null,beforeSend:null,complete:null,success:function(e){h.innerHTML=(new XMLSerializer).serializeToString(e.documentElement)}})}var p=i.lang.header,m=function(){return(t.chrome||t.Intl&&Intl.v8BreakIterator)&&"CSS"in t};i.btnsDef={viewHTML:{fn:"toggle","class":"trumbowyg-not-disable"},undo:{isSupported:m,key:"Z"},redo:{isSupported:m,key:"Y"},p:{fn:"formatBlock"},blockquote:{fn:"formatBlock"},h1:{fn:"formatBlock",title:p+" 1"},h2:{fn:"formatBlock",title:p+" 2"},h3:{fn:"formatBlock",title:p+" 3"},h4:{fn:"formatBlock",title:p+" 4"},subscript:{tag:"sub"},superscript:{tag:"sup"},bold:{key:"B",tag:"b"},italic:{key:"I",tag:"i"},underline:{tag:"u"},strikethrough:{tag:"strike"},strong:{fn:"bold",key:"B"},em:{fn:"italic",key:"I"},del:{fn:"strikethrough"},createLink:{key:"K",tag:"a"},unlink:{},insertImage:{},justifyLeft:{tag:"left",forceCss:!0},justifyCenter:{tag:"center",forceCss:!0},justifyRight:{tag:"right",forceCss:!0},justifyFull:{tag:"justify",forceCss:!0},unorderedList:{fn:"insertUnorderedList",tag:"ul"},orderedList:{fn:"insertOrderedList",tag:"ol"},horizontalRule:{fn:"insertHorizontalRule"},removeformat:{},fullscreen:{"class":"trumbowyg-not-disable"},close:{fn:"destroy","class":"trumbowyg-not-disable"},formatting:{dropdown:["p","blockquote","h1","h2","h3","h4"],ico:"p"},link:{dropdown:["createLink","unlink"]}},i.o=a.extend(!0,{},l.defaultOptions,r),i.o.hasOwnProperty("imgDblClickHandler")||(i.o.imgDblClickHandler=i.getDefaultImgDblClickHandler()),i.urlPrefix=i.setupUrlPrefix(),i.disabled=i.o.disabled||"TEXTAREA"===o.nodeName&&o.disabled,r.btns?i.o.btns=r.btns:i.o.semantic||(i.o.btns[3]=["bold","italic","underline","strikethrough"]),a.each(i.o.btnsDef,function(e,t){i.addBtnDef(e,t)}),i.eventNamespace="trumbowyg-event",i.keys=[],i.tagToButton={},i.tagHandlers=[],i.pasteHandlers=[].concat(i.o.pasteHandlers),i.isIE=e.userAgent.indexOf("MSIE")!==-1||e.appVersion.indexOf("Trident/")!==-1,i.isMac=e.platform.toUpperCase().indexOf("MAC")!==-1,i.init()};i.prototype={DEFAULT_SEMANTIC_MAP:{b:"strong",i:"em",s:"del",strike:"del",div:"p"},init:function(){var e=this;e.height=e.$ta.height(),e.initPlugins();try{e.doc.execCommand("enableObjectResizing",!1,!1),e.doc.execCommand("defaultParagraphSeparator",!1,"p")}catch(t){}e.buildEditor(),e.buildBtnPane(),e.fixedBtnPaneEvents(),e.buildOverlay(),setTimeout(function(){e.disabled&&e.setDisabled(!0),e.$c.trigger("tbwinit")})},addBtnDef:function(e,t){this.btnsDef[e]=t},setupUrlPrefix:function(){var e=this.o.urlProtocol;if(e)return"string"!=typeof e?"https://":e.replace("://","")+"://"},buildEditor:function(){var e=this,n=e.o.prefix,o="";e.$box=a("<div/>",{"class":n+"box "+n+"editor-visible "+n+e.o.lang+" trumbowyg"}),e.isTextarea=e.$ta.is("textarea"),e.isTextarea?(o=e.$ta.val(),e.$ed=a("<div/>"),e.$box.insertAfter(e.$ta).append(e.$ed,e.$ta)):(e.$ed=e.$ta,o=e.$ed.html(),e.$ta=a("<textarea/>",{name:e.$ta.attr("id"),height:e.height}).val(o),e.$box.insertAfter(e.$ed).append(e.$ta,e.$ed),e.syncCode()),e.$ta.addClass(n+"textarea").attr("tabindex",-1),e.$ed.addClass(n+"editor").attr({contenteditable:!0,dir:e.lang._dir||"ltr"}).html(o),e.o.tabindex&&e.$ed.attr("tabindex",e.o.tabindex),e.$c.is("[placeholder]")&&e.$ed.attr("placeholder",e.$c.attr("placeholder")),e.$c.is("[spellcheck]")&&e.$ed.attr("spellcheck",e.$c.attr("spellcheck")),e.o.resetCss&&e.$ed.addClass(n+"reset-css"),e.o.autogrow||e.$ta.add(e.$ed).css({height:e.height}),e.semanticCode(),e.o.autogrowOnEnter&&e.$ed.addClass(n+"autogrow-on-enter");var r,i=!1,s=!1,l="keyup";e.$ed.on("dblclick","img",e.o.imgDblClickHandler).on("keydown",function(t){if(!t.ctrlKey&&!t.metaKey||t.altKey){if(e.o.tabToIndent&&"Tab"===t.key)try{return t.shiftKey?e.execCmd("outdent",!0,null):e.execCmd("indent",!0,null),!1}catch(n){}}else{i=!0;var a=e.keys[String.fromCharCode(t.which).toUpperCase()];try{return e.execCmd(a.fn,a.param),!1}catch(n){}}}).on("compositionstart compositionupdate",function(){s=!0}).on(l+" compositionend",function(t){if("compositionend"===t.type)s=!1;else if(s)return;var n=t.which;if(!(n>=37&&n<=40)){if(!t.ctrlKey&&!t.metaKey||89!==n&&90!==n)if(i||17===n)"undefined"==typeof t.which&&e.semanticCode(!1,!1,!0);else{var a=!e.isIE||"compositionend"===t.type;e.semanticCode(!1,a&&13===n),e.$c.trigger("tbwchange")}else e.semanticCode(!1,!0),e.$c.trigger("tbwchange");setTimeout(function(){i=!1},50)}}).on("mouseup keydown keyup",function(t){(!t.ctrlKey&&!t.metaKey||t.altKey)&&setTimeout(function(){i=!1},50),clearTimeout(r),r=setTimeout(function(){e.updateButtonPaneStatus()},50)}).on("focus blur",function(t){if(e.$c.trigger("tbw"+t.type),"blur"===t.type&&a("."+n+"active-button",e.$btnPane).removeClass(n+"active-button "+n+"active"),e.o.autogrowOnEnter){if(e.autogrowOnEnterDontClose)return;"focus"===t.type?(e.autogrowOnEnterWasFocused=!0,e.autogrowEditorOnEnter()):e.o.autogrow||(e.$ed.css({height:e.$ed.css("min-height")}),e.$c.trigger("tbwresize"))}}).on("cut drop",function(){setTimeout(function(){e.semanticCode(!1,!0),e.$c.trigger("tbwchange")},0)}).on("paste",function(n){if(e.o.removeformatPasted){n.preventDefault(),t.getSelection&&t.getSelection().deleteFromDocument&&t.getSelection().deleteFromDocument();try{var o=t.clipboardData.getData("Text");try{e.doc.selection.createRange().pasteHTML(o)}catch(r){e.doc.getSelection().getRangeAt(0).insertNode(e.doc.createTextNode(o))}e.$c.trigger("tbwchange",n)}catch(i){e.execCmd("insertText",(n.originalEvent||n).clipboardData.getData("text/plain"))}}a.each(e.pasteHandlers,function(e,t){t(n)}),setTimeout(function(){e.semanticCode(!1,!0),e.$c.trigger("tbwpaste",n),e.$c.trigger("tbwchange")},0)}),e.$ta.on("keyup",function(){e.$c.trigger("tbwchange")}).on("paste",function(){setTimeout(function(){e.$c.trigger("tbwchange")},0)}),e.$box.on("keydown",function(t){if(27===t.which&&1===a("."+n+"modal-box",e.$box).length)return e.closeModal(),!1})},autogrowEditorOnEnter:function(){var e=this;e.$ed.removeClass("autogrow-on-enter");var t=e.$ed[0].clientHeight;e.$ed.height("auto");var n=e.$ed[0].scrollHeight;e.$ed.addClass("autogrow-on-enter"),t!==n&&(e.$ed.height(t),setTimeout(function(){e.$ed.css({height:n}),e.$c.trigger("tbwresize")},0))},buildBtnPane:function(){var e=this,t=e.o.prefix,n=e.$btnPane=a("<div/>",{"class":t+"button-pane"});a.each(e.o.btns,function(o,r){a.isArray(r)||(r=[r]);var i=a("<div/>",{"class":t+"button-group "+(r.indexOf("fullscreen")>=0?t+"right":"")});a.each(r,function(t,n){try{e.isSupportedBtn(n)&&i.append(e.buildBtn(n))}catch(a){}}),i.html().trim().length>0&&n.append(i)}),e.$box.prepend(n)},buildBtn:function(e){var t=this,n=t.o.prefix,o=t.btnsDef[e],r=o.dropdown,i=null==o.hasIcon||o.hasIcon,s=t.lang[e]||e,l=a("<button/>",{type:"button","class":n+e+"-button "+(o["class"]||"")+(i?"":" "+n+"textual-button"),html:t.hasSvg&&i?'<svg><use xlink:href="'+t.svgPath+"#"+n+(o.ico||e).replace(/([A-Z]+)/g,"-$1").toLowerCase()+'"/></svg>':t.hideButtonTexts?"":o.text||o.title||t.lang[e]||e,title:(o.title||o.text||s)+(o.key?" ("+(t.isMac?"Cmd":"Ctrl")+" + "+o.key+")":""),tabindex:-1,mousedown:function(){return r&&!a("."+e+"-"+n+"dropdown",t.$box).is(":hidden")||a("body",t.doc).trigger("mousedown"),!((t.$btnPane.hasClass(n+"disable")||t.$box.hasClass(n+"disabled"))&&!a(this).hasClass(n+"active")&&!a(this).hasClass(n+"not-disable"))&&(t.execCmd(!!r&&"dropdown"||o.fn||e,o.param||e,o.forceCss),!1)}});if(r){l.addClass(n+"open-dropdown");var d=n+"dropdown",c={"class":d+"-"+e+" "+d+" "+n+"fixed-top "+(o.dropdownClass||"")};c["data-"+d]=e;var u=a("<div/>",c);a.each(r,function(e,n){t.btnsDef[n]&&t.isSupportedBtn(n)&&u.append(t.buildSubBtn(n))}),t.$box.append(u.hide())}else o.key&&(t.keys[o.key]={fn:o.fn||e,param:o.param||e});return r||(t.tagToButton[(o.tag||e).toLowerCase()]=e),l},buildSubBtn:function(e){var t=this,n=t.o.prefix,o=t.btnsDef[e],r=null==o.hasIcon||o.hasIcon;return o.key&&(t.keys[o.key]={fn:o.fn||e,param:o.param||e}),t.tagToButton[(o.tag||e).toLowerCase()]=e,a("<button/>",{type:"button","class":n+e+"-dropdown-button "+(o["class"]||"")+(o.ico?" "+n+o.ico+"-button":""),html:t.hasSvg&&r?'<svg><use xlink:href="'+t.svgPath+"#"+n+(o.ico||e).replace(/([A-Z]+)/g,"-$1").toLowerCase()+'"/></svg>'+(o.text||o.title||t.lang[e]||e):o.text||o.title||t.lang[e]||e,title:o.key?"("+(t.isMac?"Cmd":"Ctrl")+" + "+o.key+")":null,style:o.style||null,mousedown:function(){return a("body",t.doc).trigger("mousedown"),t.execCmd(o.fn||e,o.param||e,o.forceCss),!1}})},isSupportedBtn:function(e){try{return this.btnsDef[e].isSupported()}catch(t){}return!0},buildOverlay:function(){var e=this;return e.$overlay=a("<div/>",{"class":e.o.prefix+"overlay"}).appendTo(e.$box),e.$overlay},showOverlay:function(){var e=this;a(t).trigger("scroll"),e.$overlay.fadeIn(200),e.$box.addClass(e.o.prefix+"box-blur")},hideOverlay:function(){var e=this;e.$overlay.fadeOut(50),e.$box.removeClass(e.o.prefix+"box-blur")},fixedBtnPaneEvents:function(){var e=this,n=e.o.fixedFullWidth,o=e.$box;e.o.fixedBtnPane&&(e.isFixed=!1,a(t).on("scroll."+e.eventNamespace+" resize."+e.eventNamespace,function(){if(o){e.syncCode();var r=a(t).scrollTop(),i=o.offset().top+1,s=e.$btnPane,l=s.outerHeight()-2;r-i>0&&r-i-e.height<0?(e.isFixed||(e.isFixed=!0,s.css({position:"fixed",top:0,left:n?"0":"auto",zIndex:7}),a([e.$ta,e.$ed]).css({marginTop:s.height()})),s.css({width:n?"100%":o.width()-1+"px"}),a("."+e.o.prefix+"fixed-top",o).css({position:n?"fixed":"absolute",top:n?l:l+(r-i)+"px",zIndex:15})):e.isFixed&&(e.isFixed=!1,s.removeAttr("style"),a([e.$ta,e.$ed]).css({marginTop:0}),a("."+e.o.prefix+"fixed-top",o).css({position:"absolute",top:l}))}}))},setDisabled:function(e){var t=this,n=t.o.prefix;t.disabled=e,e?t.$ta.attr("disabled",!0):t.$ta.removeAttr("disabled"),t.$box.toggleClass(n+"disabled",e),t.$ed.attr("contenteditable",!e)},destroy:function(){var e=this,n=e.o.prefix;e.isTextarea?e.$box.after(e.$ta.css({height:""}).val(e.html()).removeClass(n+"textarea").show()):e.$box.after(e.$ed.css({height:""}).removeClass(n+"editor").removeAttr("contenteditable").removeAttr("dir").html(e.html()).show()),e.$ed.off("dblclick","img"),e.destroyPlugins(),e.$box.remove(),e.$c.removeData("trumbowyg"),a("body").removeClass(n+"body-fullscreen"),e.$c.trigger("tbwclose"),a(t).off("scroll."+e.eventNamespace+" resize."+e.eventNamespace)},empty:function(){this.$ta.val(""),this.syncCode(!0)},toggle:function(){var e=this,t=e.o.prefix;e.o.autogrowOnEnter&&(e.autogrowOnEnterDontClose=!e.$box.hasClass(t+"editor-hidden")),e.semanticCode(!1,!0),setTimeout(function(){e.doc.activeElement.blur(),e.$box.toggleClass(t+"editor-hidden "+t+"editor-visible"),e.$btnPane.toggleClass(t+"disable"),a("."+t+"viewHTML-button",e.$btnPane).toggleClass(t+"active"),e.$box.hasClass(t+"editor-visible")?e.$ta.attr("tabindex",-1):e.$ta.removeAttr("tabindex"),e.o.autogrowOnEnter&&!e.autogrowOnEnterDontClose&&e.autogrowEditorOnEnter()},0)},dropdown:function(e){var n=this,o=n.doc,r=n.o.prefix,i=a("[data-"+r+"dropdown="+e+"]",n.$box),s=a("."+r+e+"-button",n.$btnPane),l=i.is(":hidden");if(a("body",o).trigger("mousedown"),l){var d=s.offset().left;s.addClass(r+"active"),i.css({position:"absolute",top:s.offset().top-n.$btnPane.offset().top+s.outerHeight(),left:n.o.fixedFullWidth&&n.isFixed?d+"px":d-n.$btnPane.offset().left+"px"}).show(),a(t).trigger("scroll"),a("body",o).on("mousedown."+n.eventNamespace,function(e){i.is(e.target)||(a("."+r+"dropdown",n.$box).hide(),a("."+r+"active",n.$btnPane).removeClass(r+"active"),a("body",o).off("mousedown."+n.eventNamespace))})}},html:function(e){var t=this;return null!=e?(t.$ta.val(e),t.syncCode(!0),t.$c.trigger("tbwchange"),t):t.$ta.val()},syncTextarea:function(){var e=this;e.$ta.val(e.$ed.text().trim().length>0||e.$ed.find(e.o.tagsToKeep.join(",")).length>0?e.$ed.html():"")},syncCode:function(e){var t=this;if(!e&&t.$ed.is(":visible"))t.syncTextarea();else{var n=a("<div>").html(t.$ta.val()),o=a("<div>").append(n);a(t.o.tagsToRemove.join(","),o).remove(),t.$ed.html(o.contents().html())}if(t.o.autogrow&&(t.height=t.$ed.height(),t.height!==t.$ta.css("height")&&(t.$ta.css({height:t.height}),t.$c.trigger("tbwresize"))),t.o.autogrowOnEnter){t.$ed.height("auto");var r=t.autogrowOnEnterWasFocused?t.$ed[0].scrollHeight:t.$ed.css("min-height");r!==t.$ta.css("height")&&(t.$ed.css({height:r}),t.$c.trigger("tbwresize"))}},semanticCode:function(e,t,n){var o=this;if(o.saveRange(),o.syncCode(e),o.o.semantic){if(o.semanticTag("b",o.o.semanticKeepAttributes),o.semanticTag("i",o.o.semanticKeepAttributes),o.semanticTag("s",o.o.semanticKeepAttributes),o.semanticTag("strike",o.o.semanticKeepAttributes),t){var r=o.o.inlineElementsSelector,i=":not("+r+")";o.$ed.contents().filter(function(){return 3===this.nodeType&&this.nodeValue.trim().length>0}).wrap("<span data-tbw/>");var s=function(e){if(0!==e.length){var t=e.nextUntil(i).addBack().wrapAll("<p/>").parent(),n=t.nextAll(r).first();t.next("br").remove(),s(n)}};s(o.$ed.children(r).first()),o.semanticTag("div",!0),o.$ed.find("p").filter(function(){return(!o.range||this!==o.range.startContainer)&&(0===a(this).text().trim().length&&0===a(this).children().not("br,span").length)}).contents().unwrap(),a("[data-tbw]",o.$ed).contents().unwrap(),o.$ed.find("p:empty").remove()}n||o.restoreRange(),o.syncTextarea()}},semanticTag:function(e,t){var n;if(null!=this.o.semantic&&"object"==typeof this.o.semantic&&this.o.semantic.hasOwnProperty(e))n=this.o.semantic[e];else{if(this.o.semantic!==!0||!this.DEFAULT_SEMANTIC_MAP.hasOwnProperty(e))return;n=this.DEFAULT_SEMANTIC_MAP[e]}a(e,this.$ed).each(function(){var e=a(this);return 0!==e.contents().length&&(e.wrap("<"+n+"/>"),t&&a.each(e.prop("attributes"),function(){e.parent().attr(this.name,this.value)}),void e.contents().unwrap())})},createLink:function(){for(var e,t,n,o=this,r=o.doc.getSelection(),i=r.focusNode,s=(new XMLSerializer).serializeToString(r.getRangeAt(0).cloneContents());["A","DIV"].indexOf(i.nodeName)<0;)i=i.parentNode;if(i&&"A"===i.nodeName){var l=a(i);s=l.text(),e=l.attr("href"),o.o.minimalLinks||(t=l.attr("title"),n=l.attr("target"));var d=o.doc.createRange();d.selectNode(i),r.removeAllRanges(),r.addRange(d)}o.saveRange();var c={url:{label:"URL",required:!0,value:e},text:{label:o.lang.text,value:s}};o.o.minimalLinks||Object.assign(c,{title:{label:o.lang.title,value:t},target:{label:o.lang.target,value:n}}),o.openModalInsert(o.lang.createLink,c,function(e){var t=o.prependUrlPrefix(e.url);if(!t.length)return!1;var n=a(['<a href="',t,'">',e.text||e.url,"</a>"].join(""));return o.o.minimalLinks||(e.title.length>0&&n.attr("title",e.title),e.target.length>0&&n.attr("target",e.target)),o.range.deleteContents(),o.range.insertNode(n[0]),o.syncCode(),o.$c.trigger("tbwchange"),!0})},prependUrlPrefix:function(e){var t=this;if(!t.urlPrefix)return e;var n=/^([a-z][-+.a-z0-9]*:|\/|#)/i;if(n.test(e))return e;var a=/^[^\s@]+@[^\s@]+\.[^\s@]+$/;return a.test(e)?"mailto:"+e:t.urlPrefix+e},unlink:function(){var e=this,t=e.doc.getSelection(),n=t.focusNode;if(t.isCollapsed){for(;["A","DIV"].indexOf(n.nodeName)<0;)n=n.parentNode;if(n&&"A"===n.nodeName){var a=e.doc.createRange();a.selectNode(n),t.removeAllRanges(),t.addRange(a)}}e.execCmd("unlink",void 0,void 0,!0)},insertImage:function(){var e=this;e.saveRange();var t={url:{label:"URL",required:!0},alt:{label:e.lang.description,value:e.getRangeText()}};e.o.imageWidthModalEdit&&(t.width={}),e.openModalInsert(e.lang.insertImage,t,function(t){e.execCmd("insertImage",t.url,!1,!0);var n=a('img[src="'+t.url+'"]:not([alt])',e.$box);return n.attr("alt",t.alt),e.o.imageWidthModalEdit&&n.attr({width:t.width}),e.syncCode(),e.$c.trigger("tbwchange"),!0})},fullscreen:function(){var e,n=this,o=n.o.prefix,r=o+"fullscreen";n.$box.toggleClass(r),e=n.$box.hasClass(r),a("body").toggleClass(o+"body-fullscreen",e),a(t).trigger("scroll"),n.$c.trigger("tbw"+(e?"open":"close")+"fullscreen")},execCmd:function(e,t,n,a){var o=this;a=!!a||"","dropdown"!==e&&o.$ed.focus();try{o.doc.execCommand("styleWithCSS",!1,n||!1)}catch(r){}try{o[e+a](t)}catch(r){try{e(t)}catch(i){"insertHorizontalRule"===e?t=void 0:"formatBlock"===e&&o.isIE&&(t="<"+t+">"),o.doc.execCommand(e,!1,t),o.syncCode(),o.semanticCode(!1,!0)}"dropdown"!==e&&(o.updateButtonPaneStatus(),o.$c.trigger("tbwchange"))}},openModal:function(e,n){var i=this,s=i.o.prefix;if(a("."+s+"modal-box",i.$box).length>0)return!1;i.o.autogrowOnEnter&&(i.autogrowOnEnterDontClose=!0),i.saveRange(),i.showOverlay(),i.$btnPane.addClass(s+"disable");var l=a("<div/>",{"class":s+"modal "+s+"fixed-top"}).css({top:i.$box.offset().top+i.$btnPane.height(),zIndex:99999}).appendTo(a(i.doc.body));i.$overlay.one("click",function(){return l.trigger(r),!1});var d=a("<form/>",{action:"",html:n}).on("submit",function(){return l.trigger(o),!1}).on("reset",function(){return l.trigger(r),!1}).on("submit reset",function(){i.o.autogrowOnEnter&&(i.autogrowOnEnterDontClose=!1)}),c=a("<div/>",{"class":s+"modal-box",html:d}).css({top:"-"+i.$btnPane.outerHeight()+"px",opacity:0}).appendTo(l).animate({top:0,opacity:1},100);return a("<span/>",{text:e,"class":s+"modal-title"}).prependTo(c),l.height(c.outerHeight()+10),a("input:first",c).focus(),i.buildModalBtn("submit",c),i.buildModalBtn("reset",c),a(t).trigger("scroll"),l},buildModalBtn:function(e,t){var n=this,o=n.o.prefix;return a("<button/>",{"class":o+"modal-button "+o+"modal-"+e,type:e,text:n.lang[e]||e}).appendTo(a("form",t))},closeModal:function(){var e=this,t=e.o.prefix;e.$btnPane.removeClass(t+"disable"),e.$overlay.off();var n=a("."+t+"modal-box",a(e.doc.body));n.animate({top:"-"+n.height()},100,function(){n.parent().remove(),e.hideOverlay()}),e.restoreRange()},openModalInsert:function(e,t,n){var i=this,s=i.o.prefix,l=i.lang,d="";return a.each(t,function(e,t){var n=t.label||e,a=t.name||e,o=t.attributes||{},r=Object.keys(o).map(function(e){return e+'="'+o[e]+'"'}).join(" ");d+='<label><input type="'+(t.type||"text")+'" name="'+a+'"'+("checkbox"===t.type&&t.value?' checked="checked"':' value="'+(t.value||"").replace(/"/g,"&quot;"))+'"'+r+'><span class="'+s+'input-infos"><span>'+(l[n]?l[n]:n)+"</span></span></label>"}),i.openModal(e,d).on(o,function(){var e=a("form",a(this)),r=!0,s={};a.each(t,function(t,n){var o=n.name||t,l=a('input[name="'+o+'"]',e),d=l.attr("type");switch(d.toLowerCase()){case"checkbox":s[o]=l.is(":checked");break;case"radio":s[o]=l.filter(":checked").val();break;default:s[o]=a.trim(l.val())}n.required&&""===s[o]?(r=!1,i.addErrorOnModalField(l,i.lang.required)):n.pattern&&!n.pattern.test(s[o])&&(r=!1,i.addErrorOnModalField(l,n.patternError))}),r&&(i.restoreRange(),n(s,t)&&(i.syncCode(),i.$c.trigger("tbwchange"),i.closeModal(),a(this).off(o)))}).one(r,function(){a(this).off(o),i.closeModal()})},addErrorOnModalField:function(e,t){var n=this.o.prefix,o=n+"msg-error",r=e.parent();e.on("change keyup",function(){r.removeClass(n+"input-error"),setTimeout(function(){r.find("."+o).remove()},150)}),r.addClass(n+"input-error").find("input+span").append(a("<span/>",{"class":o,text:t}))},getDefaultImgDblClickHandler:function(){var e=this;return function(){var t=a(this),n=t.attr("src"),o="(Base64)";0===n.indexOf("data:image")&&(n=o);var r={url:{label:"URL",value:n,required:!0},alt:{label:e.lang.description,value:t.attr("alt")}};return e.o.imageWidthModalEdit&&(r.width={value:t.attr("width")?t.attr("width"):""}),e.openModalInsert(e.lang.insertImage,r,function(n){return n.url!==o&&t.attr({src:n.url}),t.attr({alt:n.alt}),e.o.imageWidthModalEdit&&(parseInt(n.width)>0?t.attr({width:n.width}):t.removeAttr("width")),!0}),!1}},saveRange:function(){var e=this,t=e.doc.getSelection();if(e.range=null,t&&t.rangeCount){var n,a=e.range=t.getRangeAt(0),o=e.doc.createRange();o.selectNodeContents(e.$ed[0]),o.setEnd(a.startContainer,a.startOffset),n=(o+"").length,e.metaRange={start:n,end:n+(a+"").length}}},restoreRange:function(){var e,t=this,n=t.metaRange,a=t.range,o=t.doc.getSelection();if(a){if(n&&n.start!==n.end){var r,i=0,s=[t.$ed[0]],l=!1,d=!1;for(e=t.doc.createRange();!d&&(r=s.pop());)if(3===r.nodeType){var c=i+r.length;!l&&n.start>=i&&n.start<=c&&(e.setStart(r,n.start-i),l=!0),l&&n.end>=i&&n.end<=c&&(e.setEnd(r,n.end-i),d=!0),i=c}else for(var u=r.childNodes,g=u.length;g>0;)g-=1,s.push(u[g])}try{o.removeAllRanges()}catch(f){}o.addRange(e||a)}},getRangeText:function(){return this.range+""},updateButtonPaneStatus:function(){var e=this,t=e.o.prefix,n=e.getTagsRecursive(e.doc.getSelection().focusNode),o=t+"active-button "+t+"active";a("."+t+"active-button",e.$btnPane).removeClass(o),a.each(n,function(n,r){var i=e.tagToButton[r.toLowerCase()],s=a("."+t+i+"-button",e.$btnPane);if(s.length>0)s.addClass(o);else try{s=a("."+t+"dropdown ."+t+i+"-dropdown-button",e.$box);var l=s.parent().data("dropdown");a("."+t+l+"-button",e.$box).addClass(o)}catch(d){}})},getTagsRecursive:function(e,t){var n=this;if(t=t||(e&&e.tagName?[e.tagName]:[]),!e||!e.parentNode)return t;e=e.parentNode;var o=e.tagName;return"DIV"===o?t:("P"===o&&""!==e.style.textAlign&&t.push(e.style.textAlign),a.each(n.tagHandlers,function(a,o){t=t.concat(o(e,n))}),t.push(o),n.getTagsRecursive(e,t).filter(function(e){return null!=e}))},initPlugins:function(){var e=this;e.loadedPlugins=[],a.each(a.trumbowyg.plugins,function(t,n){n.shouldInit&&!n.shouldInit(e)||(n.init(e),n.tagHandler&&e.tagHandlers.push(n.tagHandler),e.loadedPlugins.push(n))})},destroyPlugins:function(){var e=this;a.each(this.loadedPlugins,function(t,n){n.destroy&&n.destroy(e)})}}}(navigator,window,document,jQuery);


!function(o){"use strict";o.extend(!0,o.trumbowyg,{langs:{en:{history:{redo:"Redo",undo:"Undo"}},fr:{history:{redo:"Annuler",undo:"Rétablir"}}},plugins:{history:{init:function(i){i.o.plugins.history=o.extend(!0,{_stack:[],_index:-1,_focusEl:void 0},i.o.plugins.history||{});var t={title:i.lang.history.redo,ico:"redo",key:"Y",fn:function(){if(i.o.plugins.history._index<i.o.plugins.history._stack.length-1){i.o.plugins.history._index+=1;var o=i.o.plugins.history._index,t=i.o.plugins.history._stack[o];i.execCmd("html",t),i.o.plugins.history._stack[o]=i.$ed.html(),l(),s()}}},n={title:i.lang.history.undo,ico:"undo",key:"Z",fn:function(){if(i.o.plugins.history._index>0){i.o.plugins.history._index-=1;var o=i.o.plugins.history._index,t=i.o.plugins.history._stack[o];i.execCmd("html",t),i.o.plugins.history._stack[o]=i.$ed.html(),l(),s()}}},e=function(){var t,n,e=i.o.plugins.history._index,r=i.o.plugins.history._stack,l=r.slice(-1)[0]||"<p></p>",u=r[e],h=i.$ed.html(),c=i.doc.getSelection().focusNode,g="",a=i.o.plugins.history._focusEl;t=o("<div>"+l+"</div>").find("*").map(function(){return this.localName}),n=o("<div>"+h+"</div>").find("*").map(function(){return this.localName}),c&&(i.o.plugins.history._focusEl=c,g=c.outerHTML||c.textContent),h!==u&&(g.slice(-1).match(/\s/)||!d(t,n)||i.o.plugins.history._index<=0||c!==a?(i.o.plugins.history._index+=1,i.o.plugins.history._stack=r.slice(0,i.o.plugins.history._index),i.o.plugins.history._stack.push(h)):i.o.plugins.history._stack[e]=h,s())},s=function(){var o=i.o.plugins.history._index,t=i.o.plugins.history._stack.length,n=o>0,e=0!==t&&o!==t-1;r("historyUndo",n),r("historyRedo",e)},r=function(o,t){var n=i.$box.find(".trumbowyg-"+o+"-button");t?n.removeClass("trumbowyg-disable"):n.hasClass("trumbowyg-disable")||n.addClass("trumbowyg-disable")},d=function(o,i){if(o===i)return!0;if(null==o||null==i)return!1;if(o.length!==i.length)return!1;for(var t=0;t<o.length;t+=1)if(o[t]!==i[t])return!1;return!0},l=function(){var o=i.doc.getSelection().focusNode,t=i.doc.createRange();o.childNodes.length>0&&(t.setStartAfter(o.childNodes[o.childNodes.length-1]),t.setEndAfter(o.childNodes[o.childNodes.length-1]),i.doc.getSelection().removeAllRanges(),i.doc.getSelection().addRange(t))};i.$c.on("tbwinit tbwchange",e),i.addBtnDef("historyRedo",t),i.addBtnDef("historyUndo",n)}}}})}(jQuery);
!function(e){"use strict";var r={proxy:"https://noembed.com/embed?nowrap=on",urlFiled:"url",data:[],success:void 0,error:void 0};e.extend(!0,e.trumbowyg,{langs:{en:{noembed:"Noembed",noembedError:"Error"},fr:{noembedError:"Erreur"}},plugins:{noembed:{init:function(o){o.o.plugins.noembed=e.extend(!0,{},r,o.o.plugins.noembed||{});var n={fn:function(){var r=o.openModalInsert(o.lang.noembed,{url:{label:"URL",required:!0}},function(n){e.ajax({url:o.o.plugins.noembed.proxy,type:"GET",data:n,cache:!1,dataType:"json",success:o.o.plugins.noembed.success||function(n){n.html?(o.execCmd("insertHTML",n.html),setTimeout(function(){o.closeModal()},250)):o.addErrorOnModalField(e("input[type=text]",r),n.error)},error:o.o.plugins.noembed.error||function(){o.addErrorOnModalField(e("input[type=text]",r),o.lang.noembedError)}})})}};o.addBtnDef("noembed",n)}}}})}(jQuery);
(function($){'use strict';$.extend(true,$.trumbowyg,{langs:{en:{foreColor:'Text color',backColor:'Background color',foreColorRemove:'Remove text color',backColorRemove:'Remove background color'},fr:{foreColor:'Couleur du texte',backColor:'Couleur de fond',foreColorRemove:'Supprimer la couleur du texte',backColorRemove:'Supprimer la couleur de fond'}}});function hex(x){return('0'+parseInt(x).toString(16)).slice(-2);}
function colorToHex(rgb){if(rgb.search('rgb')===-1){return rgb.replace('#','');}else if(rgb==='rgba(0, 0, 0, 0)'){return'transparent';}else{rgb=rgb.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+))?\)$/);return hex(rgb[1])+hex(rgb[2])+hex(rgb[3]);}}
function colorTagHandler(element,trumbowyg){var tags=[];if(!element.style){return tags;}
if(element.style.backgroundColor!==''){var backColor=colorToHex(element.style.backgroundColor);if(trumbowyg.o.plugins.colors.colorList.indexOf(backColor)>=0){tags.push('backColor'+backColor);}else{tags.push('backColorFree');}}
var foreColor;if(element.style.color!==''){foreColor=colorToHex(element.style.color);}else if(element.hasAttribute('color')){foreColor=colorToHex(element.getAttribute('color'));}
if(foreColor){if(trumbowyg.o.plugins.colors.colorList.indexOf(foreColor)>=0){tags.push('foreColor'+foreColor);}else{tags.push('foreColorFree');}}
return tags;}
var defaultOptions={colorList:['ffffff','000000','eeece1','1f497d','4f81bd','c0504d','9bbb59','8064a2','4bacc6','f79646','ffff00','f2f2f2','7f7f7f','ddd9c3','c6d9f0','dbe5f1','f2dcdb','ebf1dd','e5e0ec','dbeef3','fdeada','fff2ca','d8d8d8','595959','c4bd97','8db3e2','b8cce4','e5b9b7','d7e3bc','ccc1d9','b7dde8','fbd5b5','ffe694','bfbfbf','3f3f3f','938953','548dd4','95b3d7','d99694','c3d69b','b2a2c7','b7dde8','fac08f','f2c314','a5a5a5','262626','494429','17365d','366092','953734','76923c','5f497a','92cddc','e36c09','c09100','7f7f7f','0c0c0c','1d1b10','0f243e','244061','632423','4f6128','3f3151','31859b','974806','7f6000'],foreColorList:null,backColorList:null,allowCustomForeColor:true,allowCustomBackColor:true,displayAsList:false,};$.extend(true,$.trumbowyg,{plugins:{color:{init:function(trumbowyg){trumbowyg.o.plugins.colors=trumbowyg.o.plugins.colors||defaultOptions;var dropdownClass=trumbowyg.o.plugins.colors.displayAsList?trumbowyg.o.prefix+'dropdown--color-list':'';var foreColorBtnDef={dropdown:buildDropdown('foreColor',trumbowyg),dropdownClass:dropdownClass,},backColorBtnDef={dropdown:buildDropdown('backColor',trumbowyg),dropdownClass:dropdownClass,};trumbowyg.addBtnDef('foreColor',foreColorBtnDef);trumbowyg.addBtnDef('backColor',backColorBtnDef);},tagHandler:colorTagHandler}}});function buildDropdown(fn,trumbowyg){var dropdown=[],trumbowygColorOptions=trumbowyg.o.plugins.colors,colorList=trumbowygColorOptions[fn+'List']||trumbowygColorOptions.colorList;$.each(colorList,function(i,color){var btn=fn+color,btnDef={fn:fn,forceCss:true,hasIcon:false,text:trumbowyg.lang['#'+color]||('#'+color),param:'#'+color,style:'background-color: #'+color+';'};if(trumbowygColorOptions.displayAsList&&fn==='foreColor'){btnDef.style='color: #'+color+' !important;';}
trumbowyg.addBtnDef(btn,btnDef);dropdown.push(btn);});var removeColorButtonName=fn+'Remove',removeColorBtnDef={fn:'removeFormat',hasIcon:false,param:fn,style:'background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAQAAAAECAYAAACp8Z5+AAAAG0lEQVQIW2NkQAAfEJMRmwBYhoGBYQtMBYoAADziAp0jtJTgAAAAAElFTkSuQmCC);'};if(trumbowygColorOptions.displayAsList){removeColorBtnDef.style='';}
trumbowyg.addBtnDef(removeColorButtonName,removeColorBtnDef);dropdown.push(removeColorButtonName);if(trumbowygColorOptions['allowCustom'+fn.charAt(0).toUpperCase()+fn.substr(1)]){var freeColorButtonName=fn+'Free',freeColorBtnDef={fn:function(){trumbowyg.openModalInsert(trumbowyg.lang[fn],{color:{label:fn,forceCss:true,type:'color',value:'#FFFFFF'}},function(values){trumbowyg.execCmd(fn,values.color);return true;});},hasIcon:false,text:'#',style:'text-indent: 0; line-height: 20px; padding: 0 5px;'};trumbowyg.addBtnDef(freeColorButtonName,freeColorBtnDef);dropdown.push(freeColorButtonName);}
return dropdown;}})(jQuery);
!function(e){"use strict";var t={rows:8,columns:8,styler:"table"};e.extend(!0,e.trumbowyg,{langs:{en:{table:"Insert table",tableAddRow:"Add row",tableAddColumn:"Add column",tableDeleteRow:"Delete row",tableDeleteColumn:"Delete column",tableDestroy:"Delete table",error:"Error"},fr:{table:"Insérer un tableau",tableAddRow:"Ajouter des lignes",tableAddColumn:"Ajouter des colonnes",tableDeleteRow:"Effacer la ligne",tableDeleteColumn:"Effacer la colonne",tableDestroy:"Effacer le tableau",error:"Erreur"}},plugins:{table:{init:function(l){l.o.plugins.table=e.extend(!0,{},t,l.o.plugins.table||{});var a={fn:function(){l.saveRange();var t="table",a=l.o.prefix+"dropdown",d={"class":a+"-"+t+" "+a+" "+l.o.prefix+"fixed-top"};d["data-"+a]=t;var r=e("<div/>",d);if(0===l.$box.find("."+a+"-"+t).length?l.$box.append(r.hide()):r=l.$box.find("."+a+"-"+t),r.html(""),l.$box.find("."+l.o.prefix+"table-button").hasClass(l.o.prefix+"active-button"))r.append(l.buildSubBtn("tableAddRow")),r.append(l.buildSubBtn("tableAddColumn")),r.append(l.buildSubBtn("tableDeleteRow")),r.append(l.buildSubBtn("tableDeleteColumn")),r.append(l.buildSubBtn("tableDestroy"));else{for(var b=e("<table cellspacing='0' />"),i=0;i<l.o.plugins.table.rows;i+=1)for(var s=e("<tr/>").appendTo(b),u=0;u<l.o.plugins.table.columns;u+=1)e("<td/>").appendTo(s);b.find("td").on("mouseover",o),b.find("td").on("mousedown",n),r.append(b),r.append(e('<div class="trumbowyg-table-size">1x1</div>'))}l.dropdown(t)}},o=function(t){var l=e(t.target),a=l.closest("table"),o=this.cellIndex,n=this.parentNode.rowIndex;a.find("td").removeClass("active");for(var d=0;d<=n;d+=1)for(var r=0;r<=o;r+=1)a.find("tr:nth-of-type("+(d+1)+")").find("td:nth-of-type("+(r+1)+")").addClass("active");a.next(".trumbowyg-table-size").html(o+1+"x"+(n+1))},n=function(){l.saveRange();var t=e("<table cellspacing='0'/>");l.o.plugins.table.styler&&t.attr("class",l.o.plugins.table.styler);for(var a=this.cellIndex,o=this.parentNode.rowIndex,n=0;n<=o;n+=1)for(var d=e("<tr></tr>").appendTo(t),r=0;r<=a;r+=1)e("<td/>").appendTo(d);l.range.deleteContents(),l.range.insertNode(t[0]),l.$c.trigger("tbwchange")},d={title:l.lang.tableAddRow,text:l.lang.tableAddRow,ico:"row-below",fn:function(){l.saveRange();var t=l.doc.getSelection().focusNode,a=e(t).closest("table");if(a.length>0){for(var o=e("<tr/>"),n=0;n<a.find("tr")[0].childElementCount;n+=1)e("<td/>").appendTo(o);o.appendTo(a)}l.syncCode()}},r={title:l.lang.tableAddColumn,text:l.lang.tableAddColumn,ico:"col-right",fn:function(){l.saveRange();var t=l.doc.getSelection().focusNode,a=e(t).closest("table");a.length>0&&e(a).find("tr").each(function(){e(this).find("td:last").after("<td></td>")}),l.syncCode()}},b={title:l.lang.tableDestroy,text:l.lang.tableDestroy,ico:"table-delete",fn:function(){l.saveRange();var t=l.doc.getSelection().focusNode,a=e(t).closest("table");a.remove(),l.syncCode()}},i={title:l.lang.tableDeleteRow,text:l.lang.tableDeleteRow,ico:"row-delete",fn:function(){l.saveRange();var t=l.doc.getSelection().focusNode,a=e(t).closest("tr");a.remove(),l.syncCode()}},s={title:l.lang.tableDeleteColumn,text:l.lang.tableDeleteColumn,ico:"col-delete",fn:function(){l.saveRange();var t=l.doc.getSelection().focusNode,a=e(t).closest("table"),o=e(t).closest("td"),n=o.index();e(a).find("tr").each(function(){e(this).find("td:eq("+n+")").remove()}),l.syncCode()}};l.addBtnDef("table",a),l.addBtnDef("tableAddRow",d),l.addBtnDef("tableAddColumn",r),l.addBtnDef("tableDeleteRow",i),l.addBtnDef("tableDeleteColumn",s),l.addBtnDef("tableDestroy",b)}}}})}(jQuery);
!function(r){"use strict";function e(r,a){var o=a.shift(),l=a;if(null!==r){if(0===l.length)return r[o];if("object"==typeof r)return e(r[o],l)}return r}function a(){if(!r.trumbowyg.addedXhrProgressEvent){var e=r.ajaxSettings.xhr;r.ajaxSetup({xhr:function(){var r=e(),a=this;return r&&"object"==typeof r.upload&&void 0!==a.progressUpload&&r.upload.addEventListener("progress",function(r){a.progressUpload(r)},!1),r}}),r.trumbowyg.addedXhrProgressEvent=!0}}var o={serverPath:"",fileFieldName:"fileToUpload",data:[],headers:{},xhrFields:{},urlPropertyName:"file",statusPropertyName:"success",success:void 0,error:void 0,imageWidthModalEdit:!1};a(),r.extend(!0,r.trumbowyg,{langs:{en:{upload:"Upload",file:"File",uploadError:"Error"},fr:{upload:"Envoi",file:"Fichier",uploadError:"Erreur"}},plugins:{upload:{init:function(a){a.o.plugins.upload=r.extend(!0,{},o,a.o.plugins.upload||{});var l={fn:function(){a.saveRange();var o,l=a.o.prefix,t={file:{type:"file",required:!0,attributes:{accept:"image/*"}},alt:{label:"description",value:a.getRangeText()}};a.o.plugins.upload.imageWidthModalEdit&&(t.width={value:""});var d=a.openModalInsert(a.lang.upload,t,function(t){var i=new FormData;i.append(a.o.plugins.upload.fileFieldName,o),a.o.plugins.upload.data.map(function(r){i.append(r.name,r.value)}),r.map(t,function(r,e){"file"!==e&&i.append(e,r)}),0===r("."+l+"progress",d).length&&r("."+l+"modal-title",d).after(r("<div/>",{"class":l+"progress"}).append(r("<div/>",{"class":l+"progress-bar"}))),r.ajax({url:a.o.plugins.upload.serverPath,headers:a.o.plugins.upload.headers,xhrFields:a.o.plugins.upload.xhrFields,type:"POST",data:i,cache:!1,dataType:"json",processData:!1,contentType:!1,progressUpload:function(e){r("."+l+"progress-bar").css("width",Math.round(100*e.loaded/e.total)+"%")},success:function(o){if(a.o.plugins.upload.success)a.o.plugins.upload.success(o,a,d,t);else if(e(o,a.o.plugins.upload.statusPropertyName.split("."))){var l=e(o,a.o.plugins.upload.urlPropertyName.split("."));a.execCmd("insertImage",l,!1,!0);var i=r('img[src="'+l+'"]:not([alt])',a.$box);i.attr("alt",t.alt),a.o.imageWidthModalEdit&&parseInt(t.width)>0&&i.attr({width:t.width}),setTimeout(function(){a.closeModal()},250),a.$c.trigger("tbwuploadsuccess",[a,o,l])}else a.addErrorOnModalField(r("input[type=file]",d),a.lang[o.message]),a.$c.trigger("tbwuploaderror",[a,o])},error:a.o.plugins.upload.error||function(){a.addErrorOnModalField(r("input[type=file]",d),a.lang.uploadError),a.$c.trigger("tbwuploaderror",[a])}})});r("input[type=file]").on("change",function(r){try{o=r.target.files[0]}catch(e){o=r.target.value}})}};a.addBtnDef("upload",l)}}}})}(jQuery);