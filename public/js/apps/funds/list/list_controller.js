define(["app", "apps/funds/list/list_view"], function(Primus, View){
	Primus.module("FundApp.List", function(List, Primus, Backbone, Marionette, $, _){
		List.Controller = {
			listFunds: function(criterion){
				require(["common/views", "entities/fund"], function(CommonViews){
					var loadingView = new CommonViews.Loading();
					Primus.mainRegion.show(loadingView);

					var fetchingFunds = Primus.request("fund:entities");

					var fundsListLayout = new View.Layout();
					var fundsListPanel = new View.Panel();

					require(["entities/common"], function(FilteredCollection){
						$.when(fetchingFunds).done(function(funds){
							var filteredFunds = Primus.Entities.FilteredCollection({
								collection: funds,
								filterFunction: function(filterCriterion){
									var criterion = filterCriterion.toLowerCase();
									return function(fund){
										if(fund.get('firstName').toLowerCase().indexOf(criterion) !== -1
											|| fund.get('lastName').toLowerCase().indexOf(criterion) !== -1
											|| fund.get('phoneNumber').toLowerCase().indexOf(criterion) !== -1){
												return fund;
										}
									};
								}
							});

							if(criterion){
								filteredFunds.filter(criterion);
								fundsListPanel.once("show", function(){
									fundsListPanel.triggerMethod("set:filter:criterion", criterion);
								});
							}

							var fundsListView = new View.Funds({
								collection: filteredFunds
							});

							fundsListPanel.on("funds:filter", function(filterCriterion){
								filteredFunds.filter(filterCriterion);
								Primus.trigger("funds:filter", filterCriterion);
							});

							fundsListLayout.on("show", function(){
								fundsListLayout.filterRegion.show(fundsListPanel);
								fundsListLayout.fundsRegion.show(fundsListView);
							});

							fundsListPanel.on("fund:new", function(){
								require(["apps/funds/new/new_view"], function(NewView){
									var newFund = Primus.request("fund:entity:new");

									var view = new NewView.Fund({
										model: newFund
									});

									view.on("form:submit", function(data){
										if(funds.length > 0){
											var highestId = funds.max(function(c){ return c.id; }).get("id");
											data.id = highestId + 1;
										}
										else{
											data.id = 1;
										}
										if(newFund.save(data)){
											funds.add(newFund);
											view.trigger("dialog:close");
											var newFundView = fundsListView.children.findByModel(newFund);
											// check whether the new fund view is displayed (it could be
											// invisible due to the current filter criterion)
											if(newFundView){
												newFundView.flash("success");
											}
										}
										else{
											view.triggerMethod("form:data:invalid", newFund.validationError);
										}
									});

									Primus.dialogRegion.show(view);
								});
							});

							fundsListView.on("itemview:fund:show", function(childView, args){
								Primus.trigger("fund:show", args.model.get("id"));
							});

							fundsListView.on("itemview:fund:edit", function(childView, args){
								require(["apps/funds/edit/edit_view"], function(EditView){
									var model = args.model;
									var view = new EditView.Fund({
										model: model
									});

									view.on("form:submit", function(data){
										if(model.save(data)){
											childView.render();
											view.trigger("dialog:close");
											childView.flash("success");
										}
										else{
											view.triggerMethod("form:data:invalid", model.validationError);
										}
									});

									Primus.dialogRegion.show(view);
								});
							});

							fundsListView.on("itemview:fund:delete", function(childView, args){
								args.model.destroy();
							});

							Primus.mainRegion.show(fundsListLayout);
						});
					});
				});
			}
		}
	});

	return Primus.FundApp.List.Controller;
});
