define(["app", "apps/funds/show/show_view"], function(Primus, View){
  Primus.module("FundApp.Show", function(Show, Primus, Backbone, Marionette, $, _){
    Show.Controller = {
      showFund: function(id){
        require(["common/views", "entities/fund"], function(CommonViews){
          var loadingView = new CommonViews.Loading({
            title: "Artificial Loading Delay",
            message: "Data loading is delayed to demonstrate using a loading view."
          });
          Primus.mainRegion.show(loadingView);

          var fetchingFund = Primus.request("fund:entity", id);
          $.when(fetchingFund).done(function(fund){
            var fundView;
            if(fund !== undefined){
              fundView = new View.Fund({
                model: fund
              });

              fundView.on("fund:edit", function(fund){
                Primus.trigger("fund:edit", fund.get("id"));
              });
            }
            else{
              fundView = new View.MissingFund();
            }

            Primus.mainRegion.show(fundView);
          });
        });
      }
    }
  });

  return Primus.FundApp.Show.Controller;
});
