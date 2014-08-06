define(["app", "apps/funds/common/views"], function(Primus, CommonViews){
  Primus.module("FundApp.New.View", function(View, Primus, Backbone, Marionette, $, _){
    View.Fund = CommonViews.Form.extend({
      title: "New Fund",

      onRender: function(){
        this.$(".js-submit").text("Create fund");
      }
    });
  });

  return Primus.FundApp.New.View;
});
