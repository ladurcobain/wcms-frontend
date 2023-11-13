// DATATABLE
$('#tableDt').DataTable({
    lengthMenu: [10, 25, 50, 100],
    responsive: true,
    info: true,
    language: {
        'paginate': {
            'previous': "<i class='fas fa-angle-double-left'></i>",
            'next': "<i class='fas fa-angle-double-right'></i>"
        }
    }
});

// BUTTON RESET
$('#reset').click(function () {
    window.location.href = "http://127.0.0.1:8000/category";
});

// SHOW MODAL VIEW DATA KATEGORI
$(document).on('click', '.modalShow', function () {
    $('.name_show').text($(this).data('name'));
    $('.desc_show').text($(this).data('desc'));
    $('.status_show').text($(this).data('status'));
    $('.date_show').text($(this).data('date'));
    $('#modalShow').modal('show');
});

// SHOW MODAL EDIT DATA KATEGORI
$(document).on('click', '.modalConfirmEdit', function () {
    $('.id_edit').text($(this).data('id_edit'));
    $('#modalConfirmEdit').modal('show');
});

// SHOW MODAL DELETE DATA KATEGORI
$(document).on('click', '.modalConfirmDelete', function () {
    $('.id_delete').text($(this).data('id_delete'));
    $('#modalConfirmDelete').modal('show');
});

// FORM VALIDATION 1
// (function () {
// 	'use strict'

// 	// Fetch all the forms we want to apply custom Bootstrap validation styles to
// 	var forms = document.querySelectorAll('#form')

// 	// Loop over them and prevent submission
// 	Array.prototype.slice.call(forms).forEach(function (form) {
// 		form.addEventListener('submit', function (event) {
// 			if (!form.checkValidity()) {
// 				event.preventDefault()
// 				event.stopPropagation()
// 			}

// 			form.classList.add('was-validated')
// 		}, false)
// 	})
// })()

// FORM VALIDATION 2
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
}).apply(this, [jQuery]);

/*
    Thumbnail: Select
    */
$('.mg-option input[type=checkbox]').on('change', function (ev) {
    var wrapper = $(this).parents('.thumbnail');
    if ($(this).is(':checked')) {
        wrapper.addClass('thumbnail-selected');
    } else {
        wrapper.removeClass('thumbnail-selected');
    }
});

$('.mg-option input[type=checkbox]:checked').trigger('change');

$(function(){
    $('.datepicker').datepicker({
        format: 'mm-dd-yyyy',
        endDate: '+0d',
        autoclose: true
    });
});

