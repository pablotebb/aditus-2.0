define(["app", "apps/funds/common/views"], function(Primus, CommonViews){
  Primus.module("FundApp.Edit.View", function(View, Primus, Backbone, Marionette, $, _){
    View.Fund = CommonViews.Form.extend({
      initialize: function(){
        this.title = "Edit " + this.model.get("firstName") + " " + this.model.get("lastName");
      },

      onRender: function(){
        if(this.options.generateTitle){
          var $title = $("<h1>", { text: this.title });
          this.$el.prepend($title);
        }

        this.$(".js-submit").text("Update fund");
      }
    });
  });

  return Primus.FundApp.Edit.View;
});
