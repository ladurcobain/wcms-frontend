/* Add here all your JS customizations */

function reload_page() {
	location.reload();	
}

function link_new_tab(url) {
	uri = url;	
	window.open(uri,'_blank', 'directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,scrollbars=no,resizable=no, width=770, height=500, top=20, left=80');
}

function link_to(url) {
	location.href = base_url + url;
}

function link_detail(url) {
	location.href = url;
}


// SHOW MODAL EDIT DATA
$(document).on('click', '.modalConfirmEdit', function () {
    $('.id_edit').text($(this).data('id_edit'));
    $('#modalConfirmEdit').modal('show');
});


// SHOW MODAL DELETE DATA
$(document).on('click', '.modalConfirmDelete', function () {
    $('.id_delete').text($(this).data('id_delete'));
    $('#modalConfirmDelete').modal('show');
});



// DATATABLE
$('#tableDt').DataTable({
	responsive: true,
	bFilter: false, 
	bInfo: false,
	//"pageLength": 25,
	"oLanguage": {
		"sSearch": "Pencarian :",
		"sZeroRecords": "Data tidak ditemukan",
		"sLengthMenu": "Tampilkan &nbsp; _MENU_ data",
		"oPaginate": {
			"sFirst": "<<",
			"sPrevious": "<",
			"sNext": ">",
			"sLast": ">>"
		 }
	},
});

$('#dtTable').DataTable({
	responsive: true,
	bInfo: false,
	"oLanguage": {
		//"ssearchPlaceholder":"Pencarian",
		"sZeroRecords": "Data tidak ditemukan",
		"sLengthMenu": "Tampilkan &nbsp; _MENU_ data",
		"oPaginate": {
			"sFirst": "<<",
			"sPrevious": "<",
			"sNext": ">",
			"sLast": ">>"
		 }
	},
});

// Form validation
(function () {

    'use strict';

    // basic
	$("#form").validate({
		highlight: function( label ) {
			$(label).closest('.form-group').removeClass('has-success').addClass('has-error');
		},
		success: function( label ) {
			$(label).closest('.form-group').removeClass('has-error');
			label.remove();
		},
		errorPlacement: function( error, element ) {
			var placement = element.closest('.input-group');
			if (!placement.get(0)) {
				placement = element;
			}
			if (error.text() !== '') {
				placement.after(error);
			}
		}
	});

	// // basic
	// $('#jsTreeBasic').jstree();
	// $('#treeBasic').jstree({
	// 	'core' : {
	// 		'themes' : {
	// 			'responsive': false
	// 		}
	// 	},
	// 	'types' : {
	// 		'default' : {
	// 			'icon' : 'fas fa-tags'
	// 		}
	// 	},
	// 	'plugins': ['types']
	// });

}).apply(this, [jQuery]);

/*
Name: 			UI Elements / Charts - Examples
Written by: 	Okler Themes - (http://www.okler.net)
Theme Version: 	4.0.0
*/

(function($) {

	'use strict';

	/*
	Flot: Basic
	*/
	(function() {
		if( $('#flotBasic').get(0) ) {
			var plot = $.plot('#flotBasic', flotBasicData, {
				series: {
					lines: {
						show: true,
						fill: true,
						lineWidth: 1,
						fillColor: {
							colors: [{
								opacity: 0.45
							}, {
								opacity: 0.45
							}]
						}
					},
					points: {
						show: true
					},
					shadowSize: 0
				},
				grid: {
					hoverable: true,
					clickable: true,
					borderColor: 'rgba(0,0,0,0.1)',
					borderWidth: 1,
					labelMargin: 15,
					backgroundColor: 'transparent'
				},
				yaxis: {
					min: 0,
					color: 'rgba(0,0,0,0.1)'
				},
				xaxis: {
					color: 'rgba(0,0,0,0.1)'
				},
				tooltip: true,
				tooltipOpts: {
					content: 'Tanggal %x = %y',
					shifts: {
						x: -60,
						y: 25
					},
					defaultTheme: false
				}
			});
		}
	})();
	

	/*
	Flot: Bars
	*/
	(function() {
		if( $('#flotBars').get(0) ) {
			var plot = $.plot('#flotBars', [flotBarsData], {
				colors: ['#00AC69'],
				series: {
					bars: {
						show: true,
						barWidth: 0.8,
						align: 'center'
					}
				},
				xaxis: {
					mode: 'categories',
					tickLength: 0
				},
				grid: {
					hoverable: true,
					clickable: true,
					borderColor: 'rgba(0,0,0,0.1)',
					borderWidth: 1,
					labelMargin: 15,
					backgroundColor: 'transparent'
				},
				tooltip: true,
				tooltipOpts: {
					content: '%x = %y',
					shifts: {
						x: -10,
						y: 20
					},
					defaultTheme: false
				}
			});
		}
	})();

	/*
	Flot: Pie
	*/
	(function() {
		if( $('#flotPie').get(0) ) {
			var plot = $.plot('#flotPie', flotPieData, {
				series: {
					pie: {
						show: true,
						combine: {
							color: '#999',
							threshold: 0.1
						}
					}
				},
				legend: {
					show: false
				},
				grid: {
					hoverable: true,
					clickable: true
				}
			});
		}
	})();
}).apply(this, [jQuery]);

(function($) {

	/*
	Thumbnail: Select
	*/
	$('.mg-option input[type=checkbox]').on('change', function( ev ) {
		var wrapper = $(this).parents('.thumbnail');
		if($(this).is(':checked')) {
			wrapper.addClass('thumbnail-selected');
		} else {
			wrapper.removeClass('thumbnail-selected');
		}
	});

	$('.mg-option input[type=checkbox]:checked').trigger('change');

	/*
	Toolbar: Select All
	*/
	$('#mgSelectAll').on('click', function( ev ) {
		ev.preventDefault();
		var $this = $(this),
			$label = $this.find('> span');
			$checks = $('.mg-option input[type=checkbox]');

		if($this.attr('data-all-selected')) {
			$this.removeAttr('data-all-selected');
			$checks.prop('checked', false).trigger('change');
			$label.html($label.data('all-text'));
		} else {
			$this.attr('data-all-selected', 'true');
			$checks.prop('checked', true).trigger('change');
			$label.html($label.data('none-text'));
		}
	});

	/*
	Image Preview: Lightbox
	*/
	$('.thumb-preview > a[href]').magnificPopup({
		type: 'image',
		closeOnContentClick: true,
		mainClass: 'mfp-img-mobile',
		image: {
			verticalFit: true
		}
	});

	$('.thumb-preview .mg-zoom').on('click.lightbox', function( ev ) {
		ev.preventDefault();
		$(this).closest('.thumb-preview').find('a.thumb-image').triggerHandler('click');
	});

	/*
	Thumnail: Dropdown Options
	*/
	$('.thumbnail .mg-toggle').parent()
		.on('show.bs.dropdown', function( ev ) {
			$(this).closest('.mg-thumb-options').css('overflow', 'visible');
		})
		.on('hidden.bs.dropdown', function( ev ) {
			$(this).closest('.mg-thumb-options').css('overflow', '');
		});

	$('.thumbnail').on('mouseenter', function() {
		var toggle = $(this).find('.mg-toggle');
		if ( toggle.parent().hasClass('open') ) {
			toggle.dropdown('toggle');
		}
	});

	/*
	Isotope: Sort Thumbnails
	*/
	$("[data-sort-source]").each(function() {

		var source = $(this);
		var destination = $("[data-sort-destination][data-sort-id=" + $(this).attr("data-sort-id") + "]");

		if(destination.get(0)) {

			$(window).on('load', function() {

				destination.isotope({
					itemSelector: ".isotope-item",
					layoutMode: 'fitRows'
				});

				$(window).on('sidebar-left-toggle inner-menu-toggle', function() {
					destination.isotope();
				});

				source.find("a[data-option-value]").click(function(e) {

					e.preventDefault();

					var $this = $(this),
						filter = $this.attr("data-option-value");

					source.find(".active").removeClass("active");
					$this.closest("li").addClass("active");

					destination.isotope({
						filter: filter
					});

					if(window.location.hash != "" || filter.replace(".","") != "*") {
						window.location.hash = filter.replace(".","");
					}

					return false;

				});

				$(window).bind("hashchange", function(e) {

					var hashFilter = "." + location.hash.replace("#",""),
						hash = (hashFilter == "." || hashFilter == ".*" ? "*" : hashFilter);

					source.find(".active").removeClass("active");
					source.find("[data-option-value='" + hash + "']").closest("li").addClass("active");

					destination.isotope({
						filter: hash
					});

				});

				var hashFilter = "." + (location.hash.replace("#","") || "*");
				var initFilterEl = source.find("a[data-option-value='" + hashFilter + "']");

				if(initFilterEl.get(0)) {
					source.find("[data-option-value='" + hashFilter + "']").click();
				} else {
					source.find(".active a").click();
				}

			});

		}

	});

	/*
		Name: 			UI Elements / Tree View - Examples
		Written by: 	Okler Themes - (http://www.okler.net)
		Theme Version: 	4.0.0
		*/

	(function($) {

		'use strict';

		/*
		Basic
		*/
		$('#treeBasic').jstree({
			'core' : {
				'themes' : {
					'responsive': false
				}
			},
			'types' : {
				'default' : {
					'icon' : 'fas fa-folder'
				},
				'file' : {
					'icon' : 'fas fa-file'
				}
			},
			'plugins': ['types']
		});
	});

}(jQuery));


/*
Name: 			UI Elements / Nestable - Examples
Written by: 	Okler Themes - (http://www.okler.net)
Theme Version: 	4.1.0
*/
// NESTABLE
(function($) {

	'use strict';
		
	/*
	Update Output
	*/
	var updateOutput = function (e) {
		var list = e.length ? e : $(e.target),
			output = list.data('output');

		if (window.JSON) {
			output.val(window.JSON.stringify(list.nestable('serialize')));
		} else {
			output.val('JSON browser support required for this demo.');
		}
	};

	/*
	Nestable 1
	*/
	$('#nestable').nestable({
		group: 1
	}).on('change', updateOutput);

	/*
	Output Initial Serialised Data
	*/
	$(function() {
		if(is_nestable == 1) {
			updateOutput($('#nestable').data('output', $('#nestable-output')));
		}	
	});

}).apply(this, [jQuery]);


var $btnSubmit = $('#btnSubmitBackup');
var $btnDelete = $('#btnDeleteBackup');
var $type = $('#typeBackup');
var type = 'restore';

$btnSubmit.on('click', function () {
	$type.val('restore');
	type = 'restore';
});

$btnDelete.on('click', function () {
	$type.val('delete');
	type = 'delete';
});

$(document).on('click', '.chkBackup', function () {
	var checkedCount = $('.chkBackup:checked').length;
	if (checkedCount > 0) {
		$btnSubmit.attr('disabled', false);
		$btnDelete.attr('disabled', false);
	}
	else {
		$btnSubmit.attr('disabled', true);
		$btnDelete.attr('disabled', true);
	}

	if (this.checked) {
		$(this).closest('tr').addClass('warning');
	}
	else {
		$(this).closest('tr').removeClass('warning');
	}
});

$('#frmCreateBackup').submit(function () {
	this.submit();
});

$('#frmBackup').submit(function () {
	var msg = "Apa Anda yakin akan " + type + " data ini ?";
	if (confirm(msg) == true) {
		this.submit();
		return true;
	} else {
		return false;
	}
});	

//$('#html1').jstree();
