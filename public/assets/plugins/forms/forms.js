//
// FORMS
// Author: Andrey Andreevich
// Description: Форма обратной связи с валидацией
//

	// Валидация форм - требует доработки канеш
	function validateInput(value, type = ''){
		if(type == 'name'){
			return validateName(value);
		}
		
		if(type == 'fullname'){
			return validateName(value);
		}
		
		if(type == 'email'){
			return validateEmail(value);
		}
		
		if(type == 'phone'){
			return validatePhone(value);
		}
		
		if(type == 'smscode'){
			return validateSmsCode(value);
		}
		
		if(type == 'passport'){
			return validatePassport(value);
		}
	}
	
	function validateName(name) {
		if(name != undefined){
			const re = /^[A-zА-яЁё]+$/i;
			name = name.replace(' ', '').replace(' ', '');
			return re.test(name);
		}
		
	}
	
	function validateEmail(email) {
		const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		
		return re.test(email);
	}
	
	function validatePhone(phone) {
		const re = /^[+]?[7-8]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;
		if(phone.charAt(0) == '8'){
			phone = phone.replace('8','7');
		}
		phone = phone.replace(/ /g, '').replace(/-/g, '');
		return re.test(phone);
	}
	
	function validateSmsCode(value){
		if(value.length === 4){
			return true;
		}
		
		return false;
	}
	
	function validatePassport(value){
		if(value.replace(/ /g, '').length >= 10){
			return true;
		}
		
		return false;
	}
	
	
	//
	// FORM & FIELDSETS
	//
	
	
	// Собираем все значения полей из формы
	
	function get_form_values(form){
		var inputs = form.find('input, select, textarea');
		var values = {};
		inputs.each(function(index, input){
			if($(this).attr('type') == 'checkbox'){
				values[$(this).attr('name')] = $(this).prop('checked');
			} else {
				values[$(this).attr('name')] = $(this).val();
			}
		});
		
		return values;
	}
	
	// Чекаем форму, говорим ПРАВИЛЬНО ЛИ заполнена форма
	
	function check_form(form){
		var inputs = form.find('input, select, textarea');
		var has_error = false;
		inputs.each(function(index, input){
			if($(this).hasClass('invalid') || (typeof $(this).attr('required') !== 'undefined' && $(this).val() == '')){
				$(this).trigger('keyup').trigger('change').focus();
				has_error = true;
			}
			
			if($(this).attr('type') == 'checkbox' && typeof $(this).attr('required') !== 'undefined' && $(this).prop('checked') === false){
				$(this).trigger('keyup').trigger('change').focus();
				has_error = true;
			}
			
		});
		
		return has_error;
	}
	
	// Функция, которая отправляет в WP все данные с формы
	// action для WP равен тегу id на форме
	
	$('body').on('click', '.ui-form button[type="submit"]', function(){
		var form = $(this).parent('*').parent('.ui-form');
		var id = form.attr('id');
		var ready = check_form(form);
		var values = get_form_values(form);
		
		// Если одно поле заполнено не верно
		if(ready === true){
			return false;
		} else {
			
			do_send_form($(this), id, values);
		}
		
		return false;
	});
	
	//
	// МОЖНО СОЗДАТЬ JS-функции по определенной маске (указаны в eval() ), 
	// чтобы создать обработчики и пост-обработчики
	//
	
	function do_send_form($this, id, data){
		if(typeof post_id !== 'undefined'){
			data.post_id = post_id.value;
		}
		$.ajax({
			url: CURRENT_SITE+'/wp-admin/admin-ajax.php',
			method: 'POST',
			dataType: 'json',
			data: {
				action: 'ajax_'+id,
				data: JSON.stringify(data)
			},
			beforeSend: function () {
				$this.attr('disabled', true);
				try {
					eval('ajax_before_'+id)();
				} catch (e){
					
				}
			},
			success: function (response) {
				try {
					eval('ajax_success_'+id)(response);
				} catch (e){
					console.log(e);
				}
				if(response.reload === true){
					location.reload();
				}
				if(typeof response.redirect !== 'undefined'){
					setTimeout(function () {
						location = response.redirect;
					}, 2000);
				}
				$this.attr('disabled', false);
			},
			error: function (response) {
				try {
					eval('ajax_error_'+id)(response);
				} catch (e){
					
				}
				$this.attr('disabled', false);
			}
		});
	}
	
	// Функция инициализации окна с формой обратной связи.
	// Используем ее ВЕЗДЕ, где хотим вызвать окно с обратной связью
	
	$('body').on('click', '[data-form]', function(){
		var title = 'Get a <span>Quote</span>';
		var caption = 'Leave us your contact details and we\'ll be in touch';
		var goal = 'callback';
		var comagic = '';
		var button_text = 'Send';
		var post_id = '';
		var custom_class = ''
		var params = {};
		if(typeof $(this).attr('data-title') !== 'undefined'){
			title = ($(this).attr('data-title') == '') ? title : $(this).attr('data-title');
		}
		
		if(typeof $(this).attr('data-caption') !== 'undefined'){
			caption = $(this).attr('data-caption');
		}
		
		if(typeof $(this).attr('data-goal') !== 'undefined'){
			goal = ($(this).attr('data-goal') == '') ? goal : $(this).attr('data-goal');
		}
		
		if(typeof $(this).attr('data-comagic') !== 'undefined'){
			comagic = $(this).attr('data-comagic');
		}
		
		if(typeof $(this).attr('data-button-text') !== 'undefined'){
			button_text = ($(this).attr('data-button-text') == '') ? button_text : $(this).attr('data-button-text');
		}
		
		if(typeof $(this).attr('data-post-id') !== 'undefined'){
			post_id = $(this).attr('data-post-id');
		}
		
		if(typeof $(this).attr('data-class') !== 'undefined'){
			custom_class = $(this).attr('data-class');
		}
		
		if(typeof $(this).attr('data-params') !== 'undefined'){
			params = JSON.parse($(this).attr('data-params'));
		}
		
		init_callback_form(title, caption, button_text, custom_class, comagic, goal, post_id, params);
		
		return false;
		
	});
	
	function init_callback_form(title, caption = '', button_text = 'Send', custom_class = '', comagic = '', goal = 'callback_form', post_id = '', params = {}){
		if(caption !=''){
			caption = '<div class="l-fs-16 l-mb-5"><p>'+caption+'</p></div>';
		}
		var template = '<div class="clouds-top"></div>'+
		'<div class="ui-container--area">'+
			'<div class="">'+
				'<div class="section--content">'+
					'<h2 class="w-90">'+title+'</h2>'+
					caption+
					'<span class="color-gray l-mb-15">*Required fields</span>'+
					'<span class="ui-rabbit-call"></span>'+
					'<form class="ui-form modal__form" id="callback" data-goal="'+goal+'">'+
						'<div class="ui_form__fieldsets l-grid grid-2">'+
							'<div class="ui_form__fieldset" data-error="Invalid Full Name">'+
								'<div class="field">'+
									'<input name="fullname" id="fullname" type="text" required="" data-mask="fullname">'+
									'<label for="fullname">Full Name*</label>'+
								'</div>'+
								'<div class="status"><span></span></div>'+
								'<div class="information"></div>'+
							'</div>'+
							'<div class="ui_form__fieldset" data-error="Enter Company Name">'+
								'<div class="field">'+
									'<input name="company" id="company" type="text" required="">'+
									'<label for="company">Company*</label>'+
								'</div>'+
								'<div class="status"><span></span></div>'+
								'<div class="information"></div>'+
							'</div>'+
							'<div class="ui_form__fieldset" data-error="Invalid Phone">'+
								'<div class="field">'+
									'<input name="phone" id="phone" type="text" required data-mask="phone">'+
									'<label for="phone">Mobile*</label>'+
								'</div>'+
								'<div class="status"><span></span></div>'+
								'<div class="information"></div>'+
							'</div>'+
							'<div class="ui_form__fieldset" data-error="Invalid E-mail">'+
								'<div class="field">'+
									'<input name="email" id="email" type="text" required data-mask="email" >'+
									'<label for="email">E-mail*</label>'+
								'</div>'+
								'<div class="status"><span></span></div>'+
								'<div class="information"></div>'+
							'</div>'+
						'</div>'+
						'<div class="ui_form__fieldsets">'+
							'<div class="ui_form__fieldset">'+
								'<div class="field textarea">'+
									'<textarea name="notes" id="notes"></textarea>'+
									'<label for="notes">Notes</label>'+
								'</div>'+
								'<div class="status"><span></span></div>'+
								'<div class="information"></div>'+
							'</div>'+
						'</div>'+
						'<div class="ui_form__fieldsets">'+
							'<div class="ui_form__fieldset">'+
								'<div class="field checkbox checkbox--1">'+
									'<input name="private_policy" id="private_policy" type="checkbox">'+
									'<div class="box"></div>'+
									'<label for="private_policy">Please add me to your newsletter and contact list for the purpose of sending me promotional and business information and updates, including events information, your personal data will be processed according to our <a href="#">Privacy Policy</a></label>'+
								'</div>'+
								'<div class="information"></div>'+
							'</div>'+
						'</div>'+
						'<div class="form__send">'+
							'<button class="ui-button ui-button--4" type="submit">'+button_text+'</button>'+
						'</div>'+
					'</form>'+
				'</div>'+
			'</div>'+
		'</div>'+
		'<div class="clouds-bottom"></div>';
		Swal.fire({
			html: template,
			showCloseButton: true,
			showCancelButton: false,
			showConfirmButton: false,
			customClass: {
				container: 'ui-modal-form '+custom_class
			},
			
		});
		$('[data-mask="phone"]').inputmask("999-999 99 99");
		return false;
	}
	
	
	
	//
	// ПРОВЕРЯЕМ ВСЕ ПОЛЯ, ПРОГОНЯЕМ ЧЕРЕЗ ВАЛИДАТОР И ВЫВОДИМ ОШИБКУ
	//
	
	$('body').on('input keyup', 'input, textarea', function(e) {
		var input = $(this).parent('.field').parent('.ui_form__fieldset');
		var information = input.children('.information');
		var status_icon = input.children('.status').children('span');
		var error_text = input.attr('data-error');
		var mask = $(this).attr('data-mask');        
		
		var has_value = false;
		var is_required = false;
		if(typeof $(this).attr('required') !== 'undefined'){
			is_required = true;
		}
		
		information.removeClass('shown');
		status_icon.removeClass('icon--success').removeClass('icon--error');
		
		$(this).removeClass('invalid');
		
		if($(this).attr('type') == 'checkbox'){
			var val = $(this).prop('checked');
		} else {
			var val = $(this).val();
		}
		
		if(val != '' || val === true){
			has_value = true;
		}
		
		if(has_value){
			
			if (!validateInput(val, mask) && typeof $(this).attr('data-mask') !== 'undefined') {
				$(this).addClass('invalid');
				input.addClass('invalid');
				status_icon.addClass('icon--error');
				information.html(error_text).addClass('shown');
			} else {
				status_icon.addClass('icon--success');
				input.removeClass('invalid');
				$(this).removeClass('invalid');
			}
			$(this).addClass('not-empty');
			
		} else {
			$(this).removeClass('invalid not-empty');
			input.removeClass('invalid');
			status_icon.addClass('icon--success');
			
		}
		
		if(is_required && has_value === false){
			$(this).addClass('invalid');
			input.addClass('invalid');
			status_icon.addClass('icon--error');
			information.html(error_text).addClass('shown');
		}
		
		if(mask == 'phone'){
			
		}
	});