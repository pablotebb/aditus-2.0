define(["app", "marionette"], function(Primus, Marionette){
  var Router = Marionette.AppRouter.extend({
    appRoutes: {
      "about" : "showAbout"
    }
  });

  var API = {
    showAbout: function(){
      require(["apps/about/show/show_controller"], function(ShowController){
        Primus.startSubApp(null);
        ShowController.showAbout();
        Primus.execute("set:active:header", "about");
      });
    }
  };

  Primus.on("about:show", function(){
    Primus.navigate("about");
    API.showAbout();
  });

  Primus.addInitializer(function(){
    new Router({
      controller: API
    });
  });

  return Router;
});
