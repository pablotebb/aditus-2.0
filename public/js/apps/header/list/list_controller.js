define(["app", "apps/header/list/list_view"], function(Primus, View){
  Primus.module("HeaderApp.List", function(List, Primus, Backbone, Marionette, $, _){
    List.Controller = {
      listHeader: function(){
        require(["entities/header"], function(){
          var links = Primus.request("header:entities");
          var headers = new View.Headers({collection: links});

          headers.on("brand:clicked", function(){
            Primus.trigger("funds:list");
          });

          headers.on("itemview:navigate", function(childView, model){
            var trigger = model.get("navigationTrigger");
            Primus.trigger(trigger);
          });

          // Primus.headerRegion.show(headers);
        });
      },

      setActiveHeader: function(headerUrl){
        var links = Primus.request("header:entities");
        var headerToSelect = links.find(function(header){ return header.get("url") === headerUrl; });
        headerToSelect.select();
        links.trigger("reset");
      }
    };
  });

  return Primus.HeaderApp.List.Controller;
});
