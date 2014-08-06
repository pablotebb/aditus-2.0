define(["marionette", "apps/config/marionette/regions/dialog"], function(Marionette){
	var Primus = new Marionette.Application();

	Primus.addRegions({
		mainRegion: "#main-region",
		dialogRegion: Marionette.Region.Dialog.extend({
			el: "#dialog-region"
		})
	});

	Primus.navigate = function(route,  options){
		options || (options = {});
		Backbone.history.navigate(route, options);
	};

	Primus.getCurrentRoute = function(){
		return Backbone.history.fragment
	};

	Primus.startSubApp = function(appName, args){
		var currentApp = appName ? Primus.module(appName) : null;
		if (Primus.currentApp === currentApp){ return; }

		if (Primus.currentApp){
			Primus.currentApp.stop();
		}

		Primus.currentApp = currentApp;
		if(currentApp){
			currentApp.start(args);
		}
	};

	Primus.on("initialize:after", function(){
		if(Backbone.history){
			require(["apps/funds/fund_app", "apps/about/about_app", "apps/assessments/assessment_app"], function () {
				Backbone.history.start();

				if(Primus.getCurrentRoute() === ""){
					Primus.trigger("funds:list");
				}
			});
		}
	});

	return Primus;
});
