define(["app"], function(Primus){
	Primus.module("FundApp", function(FundApp, Primus, Backbone, Marionette, $, _){
		FundApp.startWithParent = false;

		FundApp.onStart = function(){
			console.log("starting FundApp");
		};

		FundApp.onStop = function(){
			console.log("stopping FundApp");
		};
	});

	Primus.module("Routers.FundApp", function(FundAppRouter, Primus, Backbone, Marionette, $, _){
		FundAppRouter.Router = Marionette.AppRouter.extend({
			appRoutes: {
				"funds(/filter/criterion::criterion)": "listFunds",
				"funds/:id": "showFund",
				"funds/:id/edit": "editFund"
			}
		});

		var executeAction = function(action, arg){
			Primus.startSubApp("FundApp");
			action(arg);
			// Primus.execute("set:active:header", "funds");
		};

		var API = {
			listFunds: function(criterion){
				require(["apps/funds/list/list_controller"], function(ListController){
					executeAction(ListController.listFunds, criterion);
				});
			},

			showFund: function(id){
				require(["apps/funds/show/show_controller"], function(ShowController){
					executeAction(ShowController.showFund, id);
				});
			},

			editFund: function(id){
				require(["apps/funds/edit/edit_controller"], function(EditController){
					executeAction(EditController.editFund, id);
				});
			}
		};

		Primus.on("funds:list", function(){
			Primus.navigate("funds");
			API.listFunds();
		});

		Primus.on("funds:filter", function(criterion){
			if(criterion){
				Primus.navigate("funds/filter/criterion:" + criterion);
			}
			else{
				Primus.navigate("funds");
			}
		});

		Primus.on("fund:show", function(id){
			Primus.navigate("funds/" + id);
			API.showFund(id);
		});

		Primus.on("fund:edit", function(id){
			Primus.navigate("funds/" + id + "/edit");
			API.editFund(id);
		});

		Primus.addInitializer(function(){
			new FundAppRouter.Router({
				controller: API
			});
		});
	});

	return Primus.FundAppRouter;
});
