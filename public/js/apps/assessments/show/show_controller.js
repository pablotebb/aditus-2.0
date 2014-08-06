define(["app", "apps/assessments/show/show_view"], function(Primus, View){
	Primus.module("AssessmentApp.Show", function(Show, Primus, Backbone, Marionette, $, _){
		Show.Controller = {
			showAssessment: function(id){
				require(["common/views", "entities/assessment"], function(CommonViews){
					var loadingView = new CommonViews.Loading({
						title: "Artificial Loading Delay",
						message: "Data loading is delayed to demonstrate using a loading view."
					});
					Primus.mainRegion.show(loadingView);

					var fetchingAssessments = Primus.request("assessment:entity", id);

					require(["entities/common"], function(FilteredCollection){
						$.when(fetchingAssessments).done(function(assessments){
							var filteredAssessments = Primus.Entities.FilteredCollection({
								collection: assessments,
							});

							var assessmentsListView = new View.Assessments({
								collection: filteredAssessments
							});

							assessmentsListLayout.on("show", function(){
								assessmentsListLayout.filterRegion.show(assessmentsListPanel);
								assessmentsListLayout.kpiRegion.show(assessmentsListView);
							});

							Primus.mainRegion.show(assessmentsListLayout);
						});
					});
				});
			},
			listAssessments: function(id){
				require(["common/views", "entities/assessment"], function(CommonViews){
					var loadingView = new CommonViews.Loading({
						title: "Artificial Loading Delay",
						message: "Data loading is delayed to demonstrate using a loading view."
					});
					Primus.mainRegion.show(loadingView);

					var fetchingAssessments = Primus.request("assessment:entities");

					var assessmentsListLayout = new View.Layout();
					var assessmentsListPanel = new View.Panel();

					require(["entities/common"], function(FilteredCollection){
						$.when(fetchingAssessments).done(function(assessments){
							var filteredAssessments = Primus.Entities.FilteredCollection({
								collection: assessments,
								filterFunction: function(filterCriterion){
									var criterion = filterCriterion.toLowerCase();
									return function(assessment){
										if(assessment.get('firstName').toLowerCase().indexOf(criterion) !== -1
											|| assessment.get('lastName').toLowerCase().indexOf(criterion) !== -1
											|| assessment.get('phoneNumber').toLowerCase().indexOf(criterion) !== -1){
												return assessment;
										}
									};
								}
							});

							if(criterion){
								filteredAssessments.filter(criterion);
								assessmentsListPanel.once("show", function(){
									assessmentsListPanel.triggerMethod("set:filter:criterion", criterion);
								});
							}

							var assessmentsListView = new View.Assessments({
								collection: filteredAssessments
							});

							assessmentsListPanel.on("assessments:filter", function(filterCriterion){
								filteredAssessments.filter(filterCriterion);
								Primus.trigger("assessments:filter", filterCriterion);
							});

							assessmentsListLayout.on("show", function(){
								assessmentsListLayout.filterRegion.show(assessmentsListPanel);
								assessmentsListLayout.kpiRegion.show(assessmentsListView);
							});

							Primus.mainRegion.show(assessmentsListLayout);
						});
					});
				});
			}			
		}
	});

	return Primus.AssessmentApp.Show.Controller;
});
