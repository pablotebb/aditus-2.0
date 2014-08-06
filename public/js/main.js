// define libraries
require.config({
	urlArgs: "bust=v2",
	paths: {
		underscore: 'lib/underscore/underscore',
		backbone: 'lib/backbone/backbone',
		marionette: 'lib/backbone.marionette/lib/backbone.marionette',
		jquery: 'lib/jquery/dist/jquery',
		localStorage: 'lib/backbone.localStorage/backbone.localStorage',
		tpl: 'lib/tpl',
		text: 'lib/text',
	    "backbone.picky": "lib/backbone/backbone.picky",
	    "backbone.syphon": "lib/backbone/backbone.syphon",
	    spin: "lib/spin",
	    "spin.jquery": "lib/spin.jquery",
	    json2: "lib/json2",

		// libraries
		modernizr: '../assets/components/library/modernizr/modernizr',
		less : '../assets/components/plugins/less-js/less.min',
		excanvas : '../assets/components/modules/admin/charts/flot/assets/lib/excanvas',
		polyfill : '../assets/components/plugins/browser/ie/ie.prototype.polyfill',
		bootstrap : '../assets/components/library/bootstrap/js/bootstrap.min',
		bootbox : '../assets/components/modules/admin/modals/assets/js/bootbox.min',
		bootstrap_datepicker : '../assets/components/modules/admin/forms/elements/bootstrap-datepicker/assets/lib/js/bootstrap-datepicker',
		wysihtml5_init : '../assets/components/modules/admin/forms/editors/wysihtml5/assets/custom/wysihtml5.init',
		wysihtml5_rc2: '../assets/components/modules/admin/forms/editors/wysihtml5/assets/lib/js/wysihtml5-0.3.0_rc2.min',
		wysihtml5_bootstrap: '../assets/components/modules/admin/forms/editors/wysihtml5/assets/lib/js/bootstrap-wysihtml5-0.0.2',
		inputmask: '../assets/components/modules/admin/forms/elements/inputmask/assets/lib/jquery.inputmask.bundle.min',
		core : '../assets/components/core/js/core.init',
		dialog: 'lib/filament/dialog',
		tablesaw: 'lib/filament/tablesaw',
		slimscroll: '../assets/components/plugins/slimscroll/jquery.slimscroll.min'
	},

	shim: {
		underscore: {
			exports: '_'
		},

		backbone: {
			exports: 'Backbone',
			deps: ['jquery', 'underscore']
		},

		marionette: {
			exports: 'Backbone.Marionette',
			deps: ['backbone']
		},

		bootstrap: {
			deps: ['jquery']
		},

		bootbox: {
			deps: ['jquery']
		},

		bootstrap_datepicker: {
			deps: ['jquery']
		},

		core: {
			deps: ['jquery', 'bootstrap']
		},

		tablesaw: {
			deps: ['jquery']
		},

		slimscroll: {
			deps: ['jquery']
		},

		inputmask: {
			deps: ['jquery']
		},

	    "backbone.picky": ["backbone"],
	    "backbone.syphon": ["backbone"]
	},

	deps: ['jquery', 'underscore']
});

// load required libraries
require([
	'modernizr',
	'less',
	'excanvas',
	'polyfill',
	'jquery',
	'bootstrap',
	'bootbox',
	'bootstrap_datepicker',
	// 'wysihtml5_init',
	// 'wysihtml5_rc2',
	// 'wysihtml5_bootstrap',
	'core',
	'tablesaw',
	'inputmask',
	'slimscroll'
], function(){
	$(document).click(function(e){
		$('a[data-toggle=popover]').each(function () {
			if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
				$(this).popover('hide');
				return;
			}
		});
	});

	$(document).ready(function(){

		// datepicker
		$('.datepicker').datepicker({
			format: 'yyyy/mm/dd'
		});

		// clear modal data on hide
		$('#modal').on('hide.bs.modal', function () {
		   $('#modal').removeData();
		});
		$('[data-toggle="modal"]').on('click', function(e) {
		    $($(this).data('target')).data('trigger', $(this));
		});		

		// modal submit
		$(document).off('click', '.modal-submit').on('click', '.modal-submit', function(e){
			e.preventDefault();			
			form = $(this).parents('form');
			console.log('button clicked');

			if( e.target.checkValidity() == true ){ // allow HTML5 validation to trigger first
				modal = $(this).closest("#modal");
				$.post( $(form).attr('action'), $(form).serialize(), function(response){				
					$(modal).removeData();
					$(modal).find('.modal-content').html(response);
				});				
			}
			return false;
		});

		// modal relaunch
		$(document).off('click', '.launch-modal').on('click', '.launch-modal', function(e){
			e.preventDefault();
			modal = $(this).closest('#modal');
			$(modal).find('.modal-content').load($(this).attr('href'));
		});

		// input mask
		$.extend($.inputmask.defaults, {
	        'autounmask': true
	    });

    	$('.inputmask-decimal').inputmask('decimal', {
    		rightAlign: false,
			groupSeparator: ',',
			autoGroup: true,
			autoUnmask: true
    	});
	});

});
