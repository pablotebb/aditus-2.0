define(["app", "backbone.picky"], function(Primus){
  Primus.module("Entities", function(Entities, Primus, Backbone, Marionette, $, _){
    Entities.Header = Backbone.Model.extend({
      initialize: function(){
        var selectable = new Backbone.Picky.Selectable(this);
        _.extend(this, selectable);
      }
    });

    Entities.HeaderCollection = Backbone.Collection.extend({
      model: Entities.Header,

      initialize: function(){
        var singleSelect = new Backbone.Picky.SingleSelect(this);
        _.extend(this, singleSelect);
      }
    });

    var initializeHeaders = function(){
      Entities.headers = new Entities.HeaderCollection([
        { name: "Funds", url: "funds", navigationTrigger: "funds:list" },
        { name: "About", url: "about", navigationTrigger: "about:show" }
      ]);
    };

    var API = {
      getHeaders: function(){
        if(Entities.headers === undefined){
          initializeHeaders();
        }
        return Entities.headers;
      }
    };

    Primus.reqres.setHandler("header:entities", function(){
      return API.getHeaders();
    });
  });

  return ;
});
