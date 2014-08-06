define(["app",
        "tpl!apps/funds/list/templates/layout.tpl",
        "tpl!apps/funds/list/templates/filter.tpl",
        "tpl!apps/funds/list/templates/none.tpl",
        "tpl!apps/funds/list/templates/list.tpl",
        "tpl!apps/funds/list/templates/list_item.tpl"],
       function(Primus, layoutTpl, filterTpl, noneTpl, listTpl, listItemTpl){
  Primus.module("FundApp.List.View", function(View, Primus, Backbone, Marionette, $, _){
    View.Layout = Marionette.Layout.extend({
      template: layoutTpl,

      regions: {
        filterRegion: "#filter-region",
        fundsRegion: "#funds-region"
      }
    });

    View.Panel = Marionette.ItemView.extend({
      template: filterTpl,

      triggers: {
        "click button.js-new": "fund:new"
      },

      events: {
        "submit #filter-form": "filterFunds"
      },

      ui: {
        criterion: "input.js-filter-criterion"
      },

      filterFunds: function(e){
        e.preventDefault();
        var criterion = this.$(".js-filter-criterion").val();
        this.trigger("funds:filter", criterion);
      },

      onSetFilterCriterion: function(criterion){
        this.ui.criterion.val(criterion);
      }
    });

    View.Fund = Marionette.ItemView.extend({
      tagName: "tr",
      template: listItemTpl,

      triggers: {
        "click td a.js-show": "fund:show",
        "click td a.js-edit": "fund:edit",
        "click button.js-delete": "fund:delete"
      },

      flash: function(cssClass){
        var $view = this.$el;
        $view.hide().toggleClass(cssClass).fadeIn(800, function(){
          
          $view.toggleClass(cssClass)
        
        });
      },

      highlightName: function(e){
        this.$el.toggleClass("warning");
      },

      remove: function(){
        var self = this;
        this.$el.fadeOut(function(){
          Marionette.ItemView.prototype.remove.call(self);
        });
      }
    });

    var NoFundsView = Marionette.ItemView.extend({
      template: noneTpl,
      tagName: "tr",
      itemViewContainer: "tbody"
    });

    View.Funds = Marionette.CompositeView.extend({
      template: listTpl,
      itemView: View.Fund,
      emptyView: NoFundsView,
      itemViewContainer: "tbody",

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

  return Primus.FundApp.List.View;
});
