define(["app",
        "tpl!apps/funds/show/templates/missing.tpl",
        "tpl!apps/funds/show/templates/view.tpl"],
       function(Primus, missingTpl, viewTpl){
  Primus.module("FundApp.Show.View", function(View, Primus, Backbone, Marionette, $, _){
    View.MissingFund = Marionette.ItemView.extend({
      template: missingTpl
    });

    View.Fund = Marionette.ItemView.extend({
      template: viewTpl,

      events: {
        "click a.js-edit": "editClicked"
      },

      editClicked: function(e){
        e.preventDefault();
        this.trigger("fund:edit", this.model);
      }
    });
  });

  return Primus.FundApp.Show.View;
});
