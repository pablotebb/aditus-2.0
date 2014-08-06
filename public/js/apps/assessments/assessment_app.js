define(["app"], function(Primus){
	Primus.module("AssessmentApp", function(AssessmentApp, Primus, Backbone, Marionette, $, _){
		AssessmentApp.startWithParent = false;

		AssessmentApp.onStart = function(){
			console.log("starting AssessmentApp");
		};

		AssessmentApp.onStop = function(){
			console.log("stopping AssessmentApp");
		};
	});

	Primus.module("Routers.AssessmentApp", function(AssessmentAppRouter, Primus, Backbone, Marionette, $, _){
		AssessmentAppRouter.Router = Marionette.AppRouter.extend({
			appRoutes: {
				"assessments": "listAssessments",
				"assessments/:id": "showAssessment",
				// "assessments/:id/edit": "editFund"
			}
		});

		var executeAction = function(action, arg){
			Primus.startSubApp("AssessmentApp");
			action(arg);
			// Primus.execute("set:active:header", "funds");
		};

		var API = {
			listAssessments: function(criterion){
				require(["apps/assessments/list/list_controller"], function(ListController){
					executeAction(ListController.listAssessments, criterion);
				});
			},
		
			showAssessment: function(id){
				require(["apps/assessments/show/show_controller"], function(ShowController){
					executeAction(ShowController.showAssessment, id);
				});
			},

			/*
			editFund: function(id){
				require(["apps/funds/edit/edit_controller"], function(EditController){
					executeAction(EditController.editFund, id);
				});
			}
			*/
		};

		Primus.on("assessments:list", function(){
			Primus.navigate("assessments");
			API.listAssessments();
		});
	
		Primus.on("assessment:show", function(id){
			Primus.navigate("assessments/" + id);
			API.showAssessment(id);
		});

		/*
		Primus.on("fund:edit", function(id){
			Primus.navigate("funds/" + id + "/edit");
			API.editFund(id);
		});
		*/
	
		Primus.addInitializer(function(){
			new AssessmentAppRouter.Router({
				controller: API
			});
		});
	});

	return Primus.AssessmentAppRouter;
});
