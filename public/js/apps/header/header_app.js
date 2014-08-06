define(["app", "apps/header/list/list_controller"], function(Primus, ListController){
  Primus.module("HeaderApp", function(Header, Primus, Backbone, Marionette, $, _){
    var API = {
      listHeader: function(){
        ListController.listHeader();
      }
    };

    Primus.commands.setHandler("set:active:header", function(name){
      ListController.setActiveHeader(name);
    });

    Header.on("start", function(){
      API.listHeader();
    });
  });

  return Primus.HeaderApp;
});
