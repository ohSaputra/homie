/* JavaScript File                                                  */
/* admin.js                                                         */
/* Modified March 24, 2016                                          */


var jsadmin = (function($, document, window) {

	// functions
	var evt = [

		// jsadmin - functions to control custom admin settings

		function($) {

			// --------------------------------------------------- ajax success - checks if a for with Ajax is submitted ----------------------------------------------------

				jQuery(document).ajaxSuccess(function(event, xhr, settings) {
					
					// Clear data if category form is submitted

					if (settings.data && settings.data.includes('action=add-tag') === true) {
						
						jQuery('#addtag')[0].reset();

						$.textCounter();
						$.wordCounter();
						$('#seo-preview').setupSEOPreview();
						$('.image-upload-wrapper').resetImageUpload();
						$('.gmap-form').resetGmapForm();
					}

					// Clear data if a widget form is submitted

					if (settings.data && settings.data.includes('action=save-widget') === true) {

						mediaupload.init();
					}
				});

			// ------------------------------------------------------- tabs - handles a tab menu functionality -----------------------------------------------------------

				$('a[data-toggle=tab]').click(function () { 

					var tab = '#' + $(this).attr('aria-controls');
					var tablist = $(this).closest('.tab-menu');

					$(tablist).find('li').removeClass('active');
					$(this).parent().addClass('active');

					$(tab).closest('.tab-panel').find('.tab').removeClass('active');
					$(tab).addClass('active');
				});
				
			// ------------------------------------------------ render seo preview - reviews a google seaerch result text ------------------------------------------------

				var showInputDescription = function() {

					$('[data-toggle=form-description]').click(function(e) { 

						var target = $(this).data('target');

						$('#' + target).parent().toggleClass('open');

						e.preventDefault();
					});
			    };

			    showInputDescription();

			// -------------------------------------------------- text counter - counts the characters in a text field -----------------------------------------------------

				$.textCounter = function() {
					
					$('input.text-counter, textarea.text-counter').each(function() {  
					
						var maximum = $(this).attr('data-max');
						var cite = $(this).closest('tr, div.widget-form, div.form-table').find('label cite');
						
						cite.removeAttr('style');
						cite.html('(' + $(this).val().length + ')');
						
						if ($(this).val().length > maximum) { cite.css({'color': '#dc3232'}); }
										
						$(this).keyup(function() {
							
							if ($(this).val().length > maximum) { cite.css({'color': '#dc3232'}); } else { cite.css({'color': '#03ab17'}); }
							cite.html('(' + $(this).val().length + ')');
						});
					});
				};
				
				$.textCounter();

			// --------------------------------------------------- key counter - counts the keywords in a text field ---------------------------------------------------------
				
				$.wordCounter = function() {
					
					$('input.word-counter, textarea.word-counter, input.key-counter, textarea.key-counter').each(function() {  
						
						var keywords = '';
						var maximum = $(this).attr('data-max');
						var cite = $(this).closest('tr, div.widget-form, div.form-table').find('label cite');
						
						cite.removeAttr('style');

						if ($(this).hasClass('key-counter')) { keywords = ($(this).val() === '') ? 0 : $(this).val().split(',').length; } else { keywords = ($(this).val() === '') ? 0 : $(this).val().split(' ').length; }
						
						cite.html('(' + keywords + ')');
						
						if (keywords > maximum) { cite.css({'color': '#dc3232'}); }
								
						$(this).keyup(function() {
							
							if ($(this).hasClass('key-counter')) { keywords = ($(this).val() === '') ? 0 : $(this).val().split(',').length; } else { keywords = ($(this).val() === '') ? 0 : $(this).val().split(' ').length; }
							
							if (keywords > maximum) { cite.css({'color': '#dc3232'}); } else { cite.css({'color': '#03ab17'}); }
							cite.html('(' + keywords + ')');
						});
					});
				};
				
				$.wordCounter();
		    
		    // ----------------------------------------- create google preview - previews the google result text on the seo tab -------------------------------------------

			    $.fn.createGooglePreview = function(theme, form, title, format, separator, expanded, description) {
				
					$(this).getUrlAlias();
					$(this).getPreviewTitle(theme, form, title, format, separator, expanded);
					$(this).getPreviewDescription(theme, form, description);
				};

			// ----------------------------------------------- get url alias - marks the keyphrase words in the SEO results ----------------------------------------------

			    $.fn.getUrlAlias = function() {
					
					var alias = $(this).attr('data-alias');
					var domain = $(this).attr('data-domain');
					
					if (domain.length + alias.length > 68) { $('div.seo-url cite', this).html(domain + '/..' + alias); }
					else { $('div.seo-url cite', this).html(domain + alias); }
					
					$('div.seo-url cite', this).attr('title', domain + alias);
				};

			// ---------------------------------------- get preview title - counts and returns the characters in the SEO title field -------------------------------------

				$.fn.getPreviewTitle = function(theme, form, title, format, separator, expanded) {
					
					var dash = ' - ';
					var company = $(this).attr('data-company');
					var tagline = $(this).attr('data-tagline');
					var name = $(form).find('input[name="' + title + '"]').val();
					var addon = $(form).find('input[name="' + theme + '_' + expanded + '"]').val();
					
					format = $(form).find('select[name="' + theme + '_' + format + '"]').length > 0 ? parseInt($(form).find('select[name="' + theme + '_' + format + '"]').val()) : $(this).data('format-style');
					separator = $(form).find('select[name="' + theme + '_' + separator + '"]').length > 0 ? parseInt($(form).find('select[name="' + theme + '_' + separator + '"]').val()) : $(this).data('separator-style');
					
					switch (separator) {
						case 1: dash = ' - '; 	break;
						case 2: dash = ' | '; 	break;
						case 3: dash = ', '; 	break;
						case 4: dash = ' > '; 	break;
						case 5: dash = ' '; 	break;
						default: dash = ' - '; 
					}
					
					if (name === '') { name = name; } else { name = dash + name; }
					if (company === '') { company = company; } else { company = dash + company; }
					if (addon === '') { addon = addon; } else { addon = dash + addon; }
					if (tagline === '') { tagline = tagline; } else { tagline = dash + tagline; }
					
					switch (format) {
						case 1: title = name + company; 				break;
						case 2: title = name + company + addon; 		break;
						case 3: title = name + addon;					break;
						case 4: title = name + addon + company; 		break;
						case 5: title = company + name; 				break;
						case 6: title = company + name + addon; 		break;
						case 7: title = company + addon;				break;
						case 8: title = company + addon + name; 		break;
						case 9: title = addon + name; 					break;
						case 10: title = addon + name + company; 		break;
						case 11: title = addon + company; 				break;
						case 12: title = addon + company + name; 		break;
						case 13: title = company + tagline; 			break;
						case 14: title = company + tagline + name; 		break;
						case 15: title = company + tagline + addon; 	break;
						case 16: title = company; 						break;
						case 17: title = name; 							break;
						case 18: title = addon; 						break;
						default: title = name + company; 
					}
					
					if (title.substr(0, dash.length) === dash) { title = title.substr(dash.length, title.length - dash.length); }
					
					$('div.seo-title', this).attr('title', title);
					
					if (title.length > 70) { title = title.substr(0, 66); $('div.seo-title', this).html(title + '...'); }
					else { $('div.seo-title', this).html(title); }
				};

			// ------------------------------------ get preview description - counts and returns the characters in the SEO description field -----------------------------

				$.fn.getPreviewDescription = function(theme, form, description) {
					
					description = $(form).find('textarea[name="' + theme + '_' + description + '"]').val();
					
					if (description !== undefined) {

						if (description.length > 150) { description = description.substr(0, 150); $('div.seo-description', this).html(description + '...'); } else { $('div.seo-description', this).html(description); }
					}
				};

		    // ------------------------------------------ show input description - shows and hides the custom form information -------------------------------------------

				$.fn.setupSEOPreview = function() {

					$(this).each(function() { 
						
						var form = $(this).attr('data-form');
						var theme = $(this).attr('data-theme');
						var title = $(this).attr('data-title');
						
						var format = $(this).attr('data-format');
						var separator = $(this).attr('data-separator');
						var expanded = $(this).attr('data-expanded');
						var description = $(this).attr('data-description');
						
						
						$(form).find('input[name="' + title + '"]').keyup(function() { $('#seo-preview').createGooglePreview(theme, form, title, format, separator, expanded, description); });
						$(form).find('select[name="' + theme + '_' + format + '"]').change(function() { $('#seo-preview').createGooglePreview(theme, form, title, format, separator, expanded, description); });
						$(form).find('select[name="' + theme + '_' + separator + '"]').change(function() { $('#seo-preview').createGooglePreview(theme, form, title, format, separator, expanded, description); });
						$(form).find('input[name="' + theme + '_' + expanded + '"]').keyup(function() { $('#seo-preview').createGooglePreview(theme, form, title, format, separator, expanded, description); });
						$(form).find('textarea[name="' + theme + '_' + description + '"]').keyup(function() { $('#seo-preview').createGooglePreview(theme, form, title, format, separator, expanded, description); });
						
						$(this).createGooglePreview(theme, form, title, format, separator, expanded, description);
					});
				};

				$('#seo-preview').setupSEOPreview();
		    
		    // --------------------------------------------------------- color picker - function to select a color ---------------------------------------------------------------
	
				$('.color-picker').each(function() {
					
					var picker = $(this).attr('data-field');
					var field = $('#' + picker + '-field');
					var color = $('#' + picker + '-field').val();
					var example = $('#' + picker + '-example');
					var defaults = $('#' + picker + '-default');
					var colorpicker = $(this).siblings('.color-picker-box');
					var palette = $.farbtastic(colorpicker);
					
					palette.setColor(color);
					palette.linkTo(function(color) {
						
						$(example).css({ 'background-color': color });
						$(field).val(color);
					});

					$(field).keyup(function() {
						
						var color = $(this).val();
						var temp = color;
									
						color = color.replace(/[^a-fA-F0-9]/, '');
						
						if ('#' + color !== temp) { $(this).val(color); }
						if (color.length === 3 || color.length === 6) { palette.setColor('#' + color); $(this).val('#' + color); $(example).css({ 'background-color': '#' + color }); }
					});
					
					$(defaults).click( function(e) { 
					
						var color = $('a', this).html();
						
						 $(field).val(color);
						 $(example).css({ 'background-color': color });
						 palette.setColor(color);
						 
						 e.preventDefault();
					});
					
					$(this).click( function(e) {
						
						var position = $('#' + picker + '-field').position();
						var width = $('#' + picker + '-field').outerWidth() + 9;
								
						colorpicker.css({ 'position': 'absolute', 'left': position.left + width, 'top': position.top + 24 });
						colorpicker.show();
						
						e.preventDefault();
					});
				
					$(document).mousedown( function() { $('.color-picker-box').hide(); });
				});

			// -------------------------------------- enhance select - creates a multiple select box with add and remove functionality -----------------------------------------------------------
	
				$.fn.enhanceSelect = function() {
					
					var idle = '';
					var used = '';
					var data = $(this).attr('id');
					
					$(this).find('option').each(function() {
						
						if ($(this).val() !== '0') {
						
							if ($(this).attr('selected')) {
								
								used = used + '<option value="' + $(this).attr('value') + '" title="' + $(this).attr('title') + '">' + $(this).text() + '</option>';
							}
							else {
								
								idle = idle + '<option value="' + $(this).attr('value') + '" title="' + $(this).attr('title') + '">' + $(this).text() + '</option>';
							}
						}
					});
					
					$('#' + data + '-enhance-left').empty();
					$('#' + data + '-enhance-right').empty();
					$('#' + data + '-enhance-left').append(idle);
					$('#' + data + '-enhance-right').append(used);
				};
				
				$.fn.initSelect = function() {

					$(this).each(function () { $('.conceal select', this).enhanceSelect(); });
					
					$('.select-left', this).click(function() {  
						
						var meta = $(this).attr('data-id');
						
						$('#' + meta + '-enhance-left').find('option:selected').each(function() {  $('#' + meta + '').find('option[value="' + $(this).val() + '"]').attr('selected', 'selected'); });
						$('#' + meta + '-enhance-left').find('option:selected').remove().appendTo($('#' + meta + '-enhance-right'));
					});
					
					$('.select-right', this).click(function() {  
						
						var meta = $(this).attr('data-id');
						
						$('#' + meta + '-enhance-right').find('option:selected').each(function() {  $('#' + meta + '').find('option[value="' + $(this).val() + '"]').removeAttr('selected'); });
						$('#' + meta + '-enhance-right').find('option:selected').remove().appendTo($('#' + meta + '-enhance-left'));
						
						if ($('#' + meta + '-enhance-right').length === 0) { $('#' + meta + '').find('option[value="0"]').attr('selected', 'selected'); }
					});
				};
				
				$('.enhance-select').initSelect();
				
			// ----------------------------------------------- add matrix - adds a new matrix field into the matrix element -------------------------------------------------
	
				$('a.add-matrix').live('click', function() {
					
					var table = $(this).attr('data-table');
					var matrix = '.' + table;
					var columns = $(matrix).attr('data-columns');
					var labels = $(matrix).attr('data-labels');

					if (labels) {

						$('tr', matrix).eq(1).clone().insertAfter($('tr', matrix).eq($('tr', matrix).length - 2)).find('input').val('').prop('checked', false);
					}
					else {

						$('tr', matrix).eq(0).clone().insertAfter($('tr', matrix).eq($('tr', matrix).length - 2)).find('input').val('').prop('checked', false);
					}

					$('input:text', matrix).each(function (i) { 

						var index = $(this).closest('tr').index() - 1;
						var modulo = i % columns;

						$(this).attr('name', table + '[' + index + '][' + modulo + ']');
					});
					
				});

			// ------------------------------------------ remove matrix - removes the last matrix field from the matrix element -------------------------------------------
	
				$('a.remove-matrix').live('click', function() {
						
					var matrix = '.' + $(this).attr('data-table');
							
					if ($('tr', matrix).length >= 4) { $('tr', matrix).eq($('tr', matrix).length - 2).remove(); } else { $('tr.matrix-row', matrix).find('input').val(''); }
				});
			
			// ------------------------------------------- reset google map - resets all google map fields after form submit --------------------------------------------

			    $.fn.resetGmapForm = function() {
				
					$(this).find('input').val('');
				};

			// ------------------------------------------- reset image upload - resets an image upload field after form submit --------------------------------------------

			    $.fn.resetImageUpload = function() {
					
			    	$(this).find('.image-upload').slice(1).remove();

					$('.image-upload', this).find('input[type="hidden"]').val('');
					$('.image-upload', this).find('.regular-text').attr('type', 'text');
					$('.image-upload', this).find('.image-preview').find('a').html('');
					$('.image-upload', this).find('.image-display').addClass('hidden');
					$('.image-upload', this).find('.edit-image-action').addClass('hidden');
					$('.image-upload', this).find('.upload-image-action').removeClass('hidden');
				};

			// -------------------------------------------------- action button - checks if someone click an action button ------------------------------------------------

				$('input.action-button').click(function() {

					var confirmed = true;
					var feedback = $(this).attr('data-feedback');

					if (feedback) { confirmed = window.confirm(decodeURI(feedback)); } else { confirmed = confirmed; }
					if (confirmed) { $(this).siblings('input[type="hidden"]').val(true); } else { return false; }
				});

			// -----------------------------------------------------------------------------------------------------------------------------------------------------------
		}

	],
	initAll = function() {
		
		initEvt($, document, window);
	},
	initEvt = function($, document, window) {
		
		evt.forEach(function(e) {
			e($, document, window);
		});
	};
	
	// export public api
	return { init: initAll };

})(jQuery, document, window);

jsadmin.init();
