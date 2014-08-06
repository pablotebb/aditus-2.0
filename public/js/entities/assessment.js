define(["app"], function(Primus){
	Primus.module("Entities", function(Entities, Primus, Backbone, Marionette, $, _){

		/*** Metrics ****/
		Entities.Metric = Backbone.Model.extend({
			urlRoot: "http://api.primus.com/Primus",
		});

		Entities.MetricCollection = Backbone.Collection.extend({
			model: Entities.Metric
		});


		/*** Assessments ***/
		Entities.Assessment = Backbone.Model.extend({
			urlRoot: "http://api.primus.com/assessments",
	        initialize: function(){
	            this.metrics = new Entities.Metric();
	        },			
			parse: function(response){
			    response.metrics = new Entities.MetricCollection(response.metrics);
			    return response;
			}	        
		});

		Entities.AssessmentCollection = Backbone.Collection.extend({
			url: "http://api.primus.com/assessments",
			model: Entities.Assessment
		});


		/*** API ***/
		var API = {
			getAssessmentEntities: function(){
				var assessments = new Entities.AssessmentCollection();
				var defer = $.Deferred();
				assessments.fetch({
					success: function(data){
						defer.resolve(data);
					}
				});
				return defer.promise();
			},

			getAssessmentEntity: function(assessmentId){
				var assessment = new Entities.Assessment({id: assessmentId});
				var defer = $.Deferred();
				assessment.fetch({
					success: function(data){
						console.log(data);
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
		Primus.reqres.setHandler("assessment:entities", function(){
			return API.getAssessmentEntities();
		});

		Primus.reqres.setHandler("assessment:entity", function(id){
			return API.getAssessmentEntity(id);
		});
	});

	return ;
});
