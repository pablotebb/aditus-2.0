define(["app",
        "tpl!apps/assessments/show/templates/layout.tpl",
        "tpl!apps/assessments/show/templates/category.tpl",
        "tpl!apps/assessments/show/templates/metric.tpl"],
       function(Primus, layoutTpl, listTpl, listItemTpl){
  Primus.module("AssessmentApp.List.View", function(View, Primus, Backbone, Marionette, $, _){
    View.Layout = Marionette.Layout.extend({
      template: layoutTpl,

      regions: {
        filterRegion: "#filter-region",
        kpiRegion: "#kpi-region"
      }
    });
   
    View.MetricView = Marionette.ItemView.extend({
      template: listItemTpl
    });

    View.CategoryView = Marionette.CompositeView.extend({
      template: listTpl,
      itemView: View.MetricView,
      itemViewContainer: "#metrics",

      initialize: function(){
        console.log(this);
        this.collection = this.model.get('metrics')
        /*
        this.listenTo(this.collection, "reset", function(){
          this.appendHtml = function(collectionView, itemView, index){
            collectionView.$el.append(itemView.el);
          }
        });
        */
      },

      onCompositeCollectionRendered: function(){
        this.appendHtml = function(collectionView, itemView, index){
          collectionView.$el.prepend(itemView.el);
        }
      }
    });

    View.AssessmentView = Marionette.CompositeView.extend({
      template: layoutTpl,

/*
      regions: {
        filterRegion: "#filter-region",
        kpiRegion: "#kpi-region"
      },

      itemView: View.CategoryView
*/




      itemView: View.CategoryView,
      itemViewContainer: "#metrics",

      initialize: function(){
        this.listenTo(this.collection, "reset", function(){
          this.appendHtml = function(collectionView, itemView, index){
            collectionView.$el.append(itemView.el);
          }
        });
      },

      onCompositeCollectionRendered: function(){
        this.appendHtml = function(collectionView, itemView, index){
          collectionView.$el.prepend(itemView.el);
        }
      }

    });
  });

  return Primus.AssessmentApp.List.View;
});
