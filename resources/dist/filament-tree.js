var X=Object.defineProperty;var b=Object.getOwnPropertyDescriptor;var y=Object.getOwnPropertyNames;var A=Object.prototype.hasOwnProperty;var D=(a,r)=>()=>(a&&(r=a(a=0)),r);var w=(a,r,h,g)=>{if(r&&typeof r=="object"||typeof r=="function")for(let p of y(r))!A.call(a,p)&&p!==h&&X(a,p,{get:()=>r[p],enumerable:!(g=b(r,p))||g.enumerable});return a};var R=a=>w(X({},"__esModule",{value:!0}),a);var T={};var C=D(()=>{(function(a,r,h,g){var p="ontouchstart"in h,m=h.dir=="rtl",N=function(){var t=h.createElement("div"),s=h.documentElement;if(!("pointerEvents"in t.style))return!1;t.style.pointerEvents="auto",t.style.pointerEvents="x",s.appendChild(t);var o=r.getComputedStyle&&r.getComputedStyle(t,"").pointerEvents==="auto";return s.removeChild(t),!!o}(),Y={listNodeName:"ol",itemNodeName:"li",rootClass:"dd",listClass:"dd-list",itemClass:"dd-item",dragClass:"dd-dragel",handleClass:"dd-handle",collapsedClass:"dd-collapsed",placeClass:"dd-placeholder",noDragClass:"dd-nodrag",emptyClass:"dd-empty",expandBtnHTML:'<button data-action="expand" type="button">Expand</button>',collapseBtnHTML:'<button data-action="collapse" type="button">Collapse</button>',group:0,maxDepth:5,threshold:20};function v(t,s){this.w=a(h),this.el=a(t),this.options=a.extend({},Y,s),this.init()}v.prototype={init:function(){var t=this;t.reset(),t.el.data("nestable-group",this.options.group),t.placeEl=a('<div class="'+t.options.placeClass+'"/>'),a.each(this.el.find(t.options.itemNodeName),function(l,d){t.setParent(a(d))}),t.el.on("click","button",function(l){if(!t.dragEl){var d=a(l.currentTarget),i=d.data("action"),e=d.closest(t.options.itemNodeName);i==="collapse"&&t.collapseItem(e),i==="expand"&&t.expandItem(e)}});var s=function(l){var d=a(l.target);if(!d.hasClass(t.options.handleClass)){if(d.closest("."+t.options.noDragClass).length)return;d=d.closest("."+t.options.handleClass)}!d.length||t.dragEl||(t.isTouch=/^touch/.test(l.type),!(t.isTouch&&l.touches.length!==1)&&(l.preventDefault(),t.dragStart(l.touches?l.touches[0]:l)))},o=function(l){t.dragEl&&(l.preventDefault(),t.dragMove(l.touches?l.touches[0]:l))},n=function(l){t.dragEl&&(l.preventDefault(),t.dragStop(l.touches?l.touches[0]:l))};p&&(t.el[0].addEventListener("touchstart",s,!1),r.addEventListener("touchmove",o,!1),r.addEventListener("touchend",n,!1),r.addEventListener("touchcancel",n,!1)),t.el.on("mousedown",s),t.w.on("mousemove",o),t.w.on("mouseup",n)},serialize:function(){var t,s=0,o=this;return step=function(n,l){var d=[],i=n.children(o.options.itemNodeName);return i.each(function(){var e=a(this),f=a.extend({},e.data()),c=e.children(o.options.listNodeName);c.length&&(f.children=step(c,l+1)),d.push(f)}),d},t=step(o.el.find(o.options.listNodeName).first(),s),t},serialise:function(){return this.serialize()},reset:function(){this.mouse={offsetX:0,offsetY:0,startX:0,startY:0,lastX:0,lastY:0,nowX:0,nowY:0,distX:0,distY:0,dirAx:0,dirX:0,dirY:0,lastDirX:0,lastDirY:0,distAxX:0,distAxY:0},this.isTouch=!1,this.moving=!1,this.dragEl=null,this.dragRootEl=null,this.dragDepth=0,this.hasNewRoot=!1,this.pointEl=null},expandItem:function(t){t.removeClass(this.options.collapsedClass);let s=t.children("div.dd-handle").children("div.dd-content").children("div.dd-item-btns");s.children('[data-action="expand"]').hide(),s.children('[data-action="collapse"]').show(),t.children(this.options.listNodeName).show()},collapseItem:function(t){var s=t.find(this.options.listNodeName);if(s.length){t.addClass(this.options.collapsedClass);let o=t.children("div.dd-handle").children("div.dd-content").children("div.dd-item-btns");o.children('[data-action="collapse"]').hide(),o.children('[data-action="expand"]').show(),t.children(this.options.listNodeName).hide()}},expandAll:function(){var t=this;t.el.find(t.options.itemNodeName).each(function(){t.expandItem(a(this))})},collapseAll:function(){var t=this;t.el.find(t.options.itemNodeName).each(function(){t.collapseItem(a(this))})},setParent:function(t){t.children(this.options.listNodeName).length&&(t.prepend(a(this.options.expandBtnHTML)),t.prepend(a(this.options.collapseBtnHTML))),t.children('[data-action="expand"]').hide()},unsetParent:function(t){t.removeClass(this.options.collapsedClass),t.children("[data-action]").remove(),t.children(this.options.listNodeName).remove()},dragStart:function(t){var s=this.mouse,o=a(t.target),n=o.closest(this.options.itemNodeName);this.placeEl.css("height",n.height()),s.offsetX=t.offsetX!==g?t.offsetX:t.pageX-o.offset().left,s.offsetY=t.offsetY!==g?t.offsetY:t.pageY-o.offset().top,s.startX=s.lastX=t.pageX,s.startY=s.lastY=t.pageY,this.dragRootEl=this.el,this.dragEl=a(h.createElement(this.options.listNodeName)).addClass(this.options.listClass+" "+this.options.dragClass),this.dragEl.css("width",n.width()),n.after(this.placeEl),n[0].parentNode.removeChild(n[0]),n.appendTo(this.dragEl),a(h.body).append(this.dragEl),m?this.dragEl.css({right:a(h).width()-t.pageX-s.offsetX,top:t.pageY-s.offsetY}):this.dragEl.css({left:t.pageX-s.offsetX,top:t.pageY-s.offsetY});var l,d,i=this.dragEl.find(this.options.itemNodeName);for(l=0;l<i.length;l++)d=a(i[l]).parents(this.options.listNodeName).length,d>this.dragDepth&&(this.dragDepth=d)},dragStop:function(t){var s=this.dragEl.children(this.options.itemNodeName).first();s[0].parentNode.removeChild(s[0]),this.placeEl.replaceWith(s),this.dragEl.remove(),this.el.trigger("change"),this.hasNewRoot&&this.dragRootEl.trigger("change"),this.reset()},dragMove:function(t){var s,o,n,l,d,i=this.options,e=this.mouse;m?this.dragEl.css({right:a(r).width()-t.pageX-e.offsetX,top:t.pageY-e.offsetY}):this.dragEl.css({left:t.pageX-e.offsetX,top:t.pageY-e.offsetY}),e.lastX=e.nowX,e.lastY=e.nowY,e.nowX=t.pageX,e.nowY=t.pageY,e.distX=e.nowX-e.lastX,e.distY=e.nowY-e.lastY,e.lastDirX=e.dirX,e.lastDirY=e.dirY,e.dirX=e.distX===0?0:e.distX>0?1:-1,e.dirY=e.distY===0?0:e.distY>0?1:-1;var f=Math.abs(e.distX)>Math.abs(e.distY)?1:0;if(!e.moving){e.dirAx=f,e.moving=!0;return}e.dirAx!==f?(e.distAxX=0,e.distAxY=0):(e.distAxX+=Math.abs(e.distX),e.dirX!==0&&e.dirX!==e.lastDirX&&(e.distAxX=0),e.distAxY+=Math.abs(e.distY),e.dirY!==0&&e.dirY!==e.lastDirY&&(e.distAxY=0)),e.dirAx=f,m?e.dirAx&&e.distAxX<=i.threshold&&(e.distAxX=0,n=this.placeEl.prev(i.itemNodeName),e.distX<0&&n.length&&!n.hasClass(i.collapsedClass)&&(s=n.find(i.listNodeName).last(),d=this.placeEl.parents(i.listNodeName).length,d+this.dragDepth>=i.maxDepth&&(s.length?(s=n.children(i.listNodeName).last(),s.append(this.placeEl)):(s=a("<"+i.listNodeName+"/>").addClass(i.listClass),s.append(this.placeEl),n.append(s),this.setParent(n)))),e.distX>0&&(l=this.placeEl.next(i.itemNodeName),l.length||(o=this.placeEl.parent(),this.placeEl.closest(i.itemNodeName).after(this.placeEl),o.children().length||this.unsetParent(o.parent())))):e.dirAx&&e.distAxX>=i.threshold&&(e.distAxX=0,n=this.placeEl.prev(i.itemNodeName),e.distX>0&&n.length&&!n.hasClass(i.collapsedClass)&&(s=n.find(i.listNodeName).last(),d=this.placeEl.parents(i.listNodeName).length,d+this.dragDepth>=i.maxDepth&&(s.length?(s=n.children(i.listNodeName).last(),s.append(this.placeEl)):(s=a("<"+i.listNodeName+"/>").addClass(i.listClass),s.append(this.placeEl),n.append(s),this.setParent(n)))),e.distX<0&&(l=this.placeEl.next(i.itemNodeName),l.length||(o=this.placeEl.parent(),this.placeEl.closest(i.itemNodeName).after(this.placeEl),o.children().length||this.unsetParent(o.parent()))));var c=!1;if(N||(this.dragEl[0].style.visibility="hidden"),this.pointEl=a(h.elementFromPoint(t.pageX-h.body.scrollLeft,t.pageY-(r.pageYOffset||h.documentElement.scrollTop))),N||(this.dragEl[0].style.visibility="visible"),this.pointEl.hasClass(i.handleClass)&&(this.pointEl=this.pointEl.parent(i.itemNodeName)),this.pointEl.hasClass(i.emptyClass))c=!0;else if(!this.pointEl.length||!this.pointEl.hasClass(i.itemClass))return;var u=this.pointEl.closest("."+i.rootClass),E=this.dragRootEl.data("nestable-id")!==u.data("nestable-id");if(!e.dirAx||E||c){if(E&&i.group!==u.data("nestable-group")||(d=this.dragDepth-1+this.pointEl.parents(i.listNodeName).length,d>i.maxDepth))return;var x=t.pageY<this.pointEl.offset().top+this.pointEl.height()/2;o=this.placeEl.parent(),c?(s=a(h.createElement(i.listNodeName)).addClass(i.listClass),s.append(this.placeEl),this.pointEl.replaceWith(s)):x?this.pointEl.before(this.placeEl):this.pointEl.after(this.placeEl),o.children().length||this.unsetParent(o.parent()),this.dragRootEl.find(i.itemNodeName).length||this.dragRootEl.append('<div class="'+i.emptyClass+'"/>'),E&&(this.dragRootEl=u,this.hasNewRoot=this.el[0]!==this.dragRootEl[0])}}},a.fn.nestable=function(t){var s=this,o=this;return s.each(function(){var n=a(this).data("nestable");n?typeof t=="string"&&typeof n[t]=="function"&&(o=n[t]()):(a(this).data("nestable",new v(this,t)),a(this).data("nestable-id",new Date().getTime()))}),o||s}})(window.jQuery||window.Zepto,window,document)});C();
/*!
 * Nestable jQuery Plugin - Copyright (c) 2012 David Bushell - http://dbushell.com/
 * Dual-licensed under the BSD or MIT licenses
 */
