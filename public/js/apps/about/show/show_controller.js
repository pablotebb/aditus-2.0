define(["app", "apps/about/show/show_view"], function(Primus, View){
  return {
    showAbout: function(){
      var view = new View.Message();
      Primus.mainRegion.show(view);
    }
  };
});
