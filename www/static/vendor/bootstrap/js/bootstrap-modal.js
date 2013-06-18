!function(e){"use strict";var t=function(t,n){this.options=n;this.$element=e(t).delegate('[data-dismiss="modal"]',"click.dismiss.modal",e.proxy(this.hide,this));this.options.remote&&this.$element.find(".modal-body").load(this.options.remote)};t.prototype={constructor:t,toggle:function(){return this[!this.isShown?"show":"hide"]()},show:function(){var t=this,n=e.Event("show");this.$element.trigger(n);if(this.isShown||n.isDefaultPrevented())return;this.isShown=true;this.escape();this.backdrop(function(){var n=e.support.transition&&t.$element.hasClass("fade");if(!t.$element.parent().length){t.$element.appendTo(document.body)}t.$element.show();if(n){t.$element[0].offsetWidth}t.$element.addClass("in").attr("aria-hidden",false);t.enforceFocus();n?t.$element.one(e.support.transition.end,function(){t.$element.focus().trigger("shown")}):t.$element.focus().trigger("shown")})},hide:function(t){t&&t.preventDefault();var n=this;t=e.Event("hide");this.$element.trigger(t);if(!this.isShown||t.isDefaultPrevented())return;this.isShown=false;this.escape();e(document).off("focusin.modal");this.$element.removeClass("in").attr("aria-hidden",true);e.support.transition&&this.$element.hasClass("fade")?this.hideWithTransition():this.hideModal()},enforceFocus:function(){var t=this;e(document).on("focusin.modal",function(e){if(t.$element[0]!==e.target&&!t.$element.has(e.target).length){t.$element.focus()}})},escape:function(){var e=this;if(this.isShown&&this.options.keyboard){this.$element.on("keyup.dismiss.modal",function(t){t.which==27&&e.hide()})}else if(!this.isShown){this.$element.off("keyup.dismiss.modal")}},hideWithTransition:function(){var t=this,n=setTimeout(function(){t.$element.off(e.support.transition.end);t.hideModal()},500);this.$element.one(e.support.transition.end,function(){clearTimeout(n);t.hideModal()})},hideModal:function(e){this.$element.hide().trigger("hidden");this.backdrop()},removeBackdrop:function(){this.$backdrop.remove();this.$backdrop=null},backdrop:function(t){var n=this,r=this.$element.hasClass("fade")?"fade":"";if(this.isShown&&this.options.backdrop){var i=e.support.transition&&r;this.$backdrop=e('<div class="modal-backdrop '+r+'" />').appendTo(document.body);this.$backdrop.click(this.options.backdrop=="static"?e.proxy(this.$element[0].focus,this.$element[0]):e.proxy(this.hide,this));if(i)this.$backdrop[0].offsetWidth;this.$backdrop.addClass("in");i?this.$backdrop.one(e.support.transition.end,t):t()}else if(!this.isShown&&this.$backdrop){this.$backdrop.removeClass("in");e.support.transition&&this.$element.hasClass("fade")?this.$backdrop.one(e.support.transition.end,e.proxy(this.removeBackdrop,this)):this.removeBackdrop()}else if(t){t()}}};e.fn.modal=function(n){return this.each(function(){var r=e(this),i=r.data("modal"),s=e.extend({},e.fn.modal.defaults,r.data(),typeof n=="object"&&n);if(!i)r.data("modal",i=new t(this,s));if(typeof n=="string")i[n]();else if(s.show)i.show()})};e.fn.modal.defaults={backdrop:true,keyboard:true,show:true};e.fn.modal.Constructor=t;e(document).on("click.modal.data-api",'[data-toggle="modal"]',function(t){var n=e(this),r=n.attr("href"),i=e(n.attr("data-target")||r&&r.replace(/.*(?=#[^\s]+$)/,"")),s=i.data("modal")?"toggle":e.extend({remote:!/#/.test(r)&&r},i.data(),n.data());t.preventDefault();i.modal(s).one("hide",function(){n.focus()})})}(window.jQuery)