define(["app",
        "tpl!apps/header/list/templates/list.tpl",
        "tpl!apps/header/list/templates/list_item.tpl"],
        function(Primus, listTpl, listItemTpl){
  Primus.module("HeaderApp.List.View", function(View, Primus, Backbone, Marionette, $, _){
    View.Header = Marionette.ItemView.extend({
      template: listItemTpl,
      tagName: "li",

      events: {
        "click a": "navigate"
      },

      navigate: function(e){
        e.preventDefault();
        this.trigger("navigate", this.model);
      },

      onRender: function(){
        if(this.model.selected){
          // add class so Bootstrap will highlight the active entry in the navbar
          this.$el.addClass("active");
        };
      }
    });

    View.Headers = Marionette.CompositeView.extend({
      template: listTpl,
      className: "navbar navbar-inverse navbar-fixed-top",
      itemView: View.Header,
      itemViewContainer: "ul",

      events: {
        "click a.brand": "brandClicked"
      },

      brandClicked: function(e){
        e.preventDefault();
        this.trigger("brand:clicked");
      }
    });
  });

  return Primus.HeaderApp.List.View;
});
