/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

var dateToday = new Date();
var today = new Date(dateToday.getFullYear(), dateToday.getMonth(), dateToday.getDate());

$(document).ready(function() {
	$('#printButton').on('click', function() {
		$.print('#idLayout');
	});

	$("#menu-toggle").on('click', function(e) {
		e.preventDefault();
		$("#wrapper").toggleClass("toggled");
	});

	$('.alert').each(function(i, obj) {
		$(this).delay(5000).fadeOut('fast');		
	});

	$('#birthdate').datepicker({
    	autoclose: true,
    	format: 'yyyy-mm-dd',
    	endDate: new Date()
	});

	$('#dateFrom').datepicker({
    	autoclose: true,
    	format: 'yyyy-mm-dd'
	});

	$('#dateTo').datepicker({
    	autoclose: true,
    	format: 'yyyy-mm-dd'
	});

	$('#addDisplayDate').datepicker({
    	autoclose: true,
    	format: 'yyyy-mm-dd',
    	startDate: new Date()
	});

	$('#displayDate').datepicker({
    	autoclose: true,
    	format: 'yyyy-mm-dd',
    	startDate: new Date()
	});

	if ($('#dateFrom').val() == '') {
		$('#dateFrom').datepicker('setDate', today);
	}

	if ($('#dateTo').val() == '') {
		$('#dateTo').datepicker('setDate', today);
	}

	if ($('#addDisplayDate').val() == '') {
		$('#addDisplayDate').datepicker('setDate', today);
	}

	if ($('#displayDate').val() == '') {
		$('#displayDate').datepicker('setDate', today);
	}

	if ($('#dateFrom').length) {
		$('#dateFrom').data('datepicker').setEndDate($('#dateTo').val());
		$('#dateTo').data('datepicker').setStartDate($('#dateFrom').val());
	}

	$('#dateFrom').on('change', function() {
		$('#dateTo').data('datepicker').setStartDate($('#dateFrom').val());
	});

	$('#dateTo').on('change', function() {
		$('#dateFrom').data('datepicker').setEndDate($('#dateTo').val());
	});

	$('#avatar').on('change', function() {
		var input = this;
		var url = $(this).val();
		var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
		if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
		{
			var reader = new FileReader();

			reader.onload = function (e) {
				$('#avatarDisplay').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	});

	$('.logo-input').each(function(i, obj) {
	    $(this).on('change', function() {
	    	var input = this;
			var url = $(this).val();
			var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
			if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
			{
				var reader = new FileReader();

				reader.onload = function (e) {
					$(input).prev().attr('src', e.target.result);
				}
				reader.readAsDataURL(input.files[0]);
			}
	    });
	});

	$('#addLogo').on('change', function() {
		var input = this;
		var url = $(this).val();
		var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
		if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
		{
			var reader = new FileReader();

			reader.onload = function (e) {
				$('#addLogoDisplay').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	});

	$('.greeting-input').each(function(i, obj) {
	    $(this).on('change', function() {
	    	var input = this;
			var url = $(this).val();
			var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
			if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
			{
				var reader = new FileReader();

				reader.onload = function (e) {
					$(input).prev().attr('src', e.target.result);
				}
				reader.readAsDataURL(input.files[0]);
			}
	    });
	});

	$('#greeting').on('change', function() {
		var input = this;
		var url = $(this).val();
		var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
		if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
		{
			var reader = new FileReader();

			reader.onload = function (e) {
				$('#greetingDisplay').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	});

	$('#addGreeting').on('change', function() {
		var input = this;
		var url = $(this).val();
		var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
		if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
		{
			var reader = new FileReader();

			reader.onload = function (e) {
				$('#addGreetingDisplay').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	});

	$('#termsAcceptButton').on('click', function() {
		$('#termsModal').modal('hide');
		$('#registerButton').trigger('click');
	});

	$('[type="submit"]').on('click', function() {
		$(this.form).find('[required]:invalid').addClass('is-invalid');
	});

	$('.form-control').on('change', function() {
		$(this).removeClass('is-invalid');
	});

	$('#kumustaModal').modal('show');

	if (!$('#kumustaModal').length) {
		$('#greetingModal').modal('show');
	}
});

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
