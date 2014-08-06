define(["app", "apps/funds/edit/edit_view"], function(Primus, View){
  Primus.module("FundApp.Edit", function(Edit, Primus, Backbone, Marionette, $, _){
    Edit.Controller = {
      editFund: function(id){
        require(["common/views", "entities/fund"], function(CommonViews){
          var loadingView = new CommonViews.Loading({
            title: "Artificial Loading Delay",
            message: "Data loading is delayed to demonstrate using a loading view."
          });
          Primus.mainRegion.show(loadingView);

          var fetchingFund = Primus.request("fund:entity", id);
          $.when(fetchingFund).done(function(fund){
            var view;
            if(fund !== undefined){
              view = new View.Fund({
                model: fund,
                generateTitle: true
              });

              view.on("form:submit", function(data){
                if(fund.save(data)){
                  Primus.trigger("fund:show", fund.get('id'));
                }
                else{
                  view.triggerMethod("form:data:invalid", fund.validationError);
                }
              });
            }
            else{
              view = new Primus.FundApp.Show.MissingFund();
            }

            Primus.mainRegion.show(view);
          });
        });
      }
    };
  });

  return Primus.FundApp.Edit.Controller;
});
