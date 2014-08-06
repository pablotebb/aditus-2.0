define(["app"], function(Primus){
	Primus.module("Entities", function(Entities, Primus, Backbone, Marionette, $, _){

		/*** Companies ****/
		Entities.Company = Backbone.Model.extend({
			urlRoot: "http://api.primus.com/Primus",			
		});

		Entities.CompanyCollection = Backbone.Collection.extend({
			model: Entities.Company
		});


		/*** Funds ***/
		Entities.Fund = Backbone.Model.extend({
			urlRoot: "http://api.primus.com/Primus",
	        initialize: function(){
	            console.log(this.id);
	            this.companies = new Entities.Company();
	        },

			parse: function(response){
			    response.companies = new Entities.CompanyCollection(response.companies);
			    return response;
			}	        
		});

		Entities.FundCollection = Backbone.Collection.extend({
			url: "http://api.primus.com/Primus",
			model: Entities.Fund
		});


		/*** API ***/
		var API = {
			getFundEntities: function(){
				var funds = new Entities.FundCollection();
				var defer = $.Deferred();
				funds.fetch({
					success: function(data){
						defer.resolve(data);
					}
				});
				return defer.promise();
			},

			getFundEntity: function(fundId){
				var fund = new Entities.Fund({id: fundId});
				var defer = $.Deferred();
				fund.fetch({
					success: function(data){
						defer.resolve(data);
					},
					error: function(data){
						defer.resolve(undefined);
					}
				});
				return defer.promise();
			}
		};


		/*** Event Handlers ***/
		Primus.reqres.setHandler("fund:entities", function(){
			return API.getFundEntities();
		});

		Primus.reqres.setHandler("fund:entity", function(id){
			return API.getFundEntity(id);
		});

		Primus.reqres.setHandler("fund:entity:new", function(id){
			return new Entities.Fund();
		});
	});

	return ;
});
