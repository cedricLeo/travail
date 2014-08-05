// FreshCutSD.com JS v0.1.01
// KEEP IT FRESH! :)

(function(){

YAHOO.namespace("freshcut");

var FC = YAHOO.freshcut;

// Featured Content Object:
FC.featured = function(){
	this.link = document.getElementById("fc_FeaturedImages");
	this.image = this.link.getElementsByTagName("img")[0];
	this.tabs = document.getElementById("fc_FeaturedTabs").getElementsByTagName("a");
	this.currentTab = 0;
	this.points = [ [-50, -50], [-694, -50], [-51, -428], [-694, -428], [-51, -805], [-694, -805], [-51, -1184], [-694, -1184] ];
	this.animationSpeed = 0.5;
	this.autoplaySpeed = 5000;
	this.position = function(){
		var oPosition = new YAHOO.util.Anim(this.image, {
				top: { to: this.points[this.currentTab][1] },
				left: { to: this.points[this.currentTab][0] }
			}, this.animationSpeed, YAHOO.util.Easing.backBoth);
		oPosition.animate();
	}; // this.position()
	this.init = function(){
		var that = this;
		this.autoplay = setInterval(function(){
			if(that.currentTab == that.tabs.length - 1){
				that.currentTab = 0;
			} else {
				that.currentTab++;
			}
			YAHOO.util.Dom.removeClass(that.tabs, "fc_Active");
			for(var i=0; i<that.tabs.length; i++){
				if(that.tabs[i].rel + "" == that.currentTab + ""){
					YAHOO.util.Dom.addClass(that.tabs[i], "fc_Active");
					that.link.href = that.tabs[i].href;
				}
			}
			that.position();
		}, this.autoplaySpeed);
		YAHOO.util.Event.addListener(this.tabs, "click", function(e){
			clearInterval(this.autoplay);
			YAHOO.util.Event.preventDefault(e);
			var oTarget = YAHOO.util.Event.getTarget(e);
			if(oTarget.nodeName.toUpperCase() != "A"){
				oTarget = YAHOO.util.Dom.getAncestorByTagName(oTarget, "a");
			}
			YAHOO.util.Dom.removeClass(this.tabs, "fc_Active");
			YAHOO.util.Dom.addClass(oTarget, "fc_Active");
			this.link.href = oTarget.href;
			this.currentTab = oTarget.rel;
			this.position();
		}, this, true);
	}; // this.init()
}; // FC.featured()

// GO GO GO!
var freshenUp = function(){
	// Menubar Search Box:
	YAHOO.util.Event.addListener("fc_SearchSubmit", "click", function(e){
		YAHOO.util.Event.preventDefault(e);
		document.getElementById("searchform").submit();
	});
	// Featured Content:
	if(YAHOO.util.Dom.inDocument("fc_Featured")){
		var oFeaturedContent = new FC.featured();
		oFeaturedContent.init();
	}
	// Contact form:
	if(YAHOO.util.Dom.inDocument("fc_ContactForm")){
		var oContactForm = new FC.contact("fc_ContactForm");
		oContactForm.init();
	}
}; // FC.freshenUp()

YAHOO.util.Event.onDOMReady(freshenUp);

})();