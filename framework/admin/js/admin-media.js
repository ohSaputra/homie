/* JavaScript File                                                  */
/* admin-media.js                                                   */
/* Modified June 12, 2016                                           */


var mediaupload = (function($, document, window) {

	// functions
	var evt = [

		// media upload - enables the media library dialog for uploading and adding images

		function($) {

			// Inititalizes the media functionality

			$.fn.mediaUpload = function() {

				var $media = $(this);

				$media.each(function() {

					var uploader;

					var display = $(this);
					var upload = display.find('.upload-image-button');
					var update = display.find('.update-image-button');
					var remove = display.find('.remove-image-button');
					var rendering = display.parent().data('multiple');

					$(upload).click(function(e) {

						e.preventDefault();

						$(this).mediaEvent(display, uploader, 'add', rendering);
					});

					$(update).click(function(e) {

						e.preventDefault();

						$(this).mediaEvent(display, uploader, 'edit', 'single');
					});

					$(remove).click(function(e) {

						e.preventDefault();
						
						if (rendering === 'multiple' && display.parent().find('.image-upload').length !== 1) {

							$(display).removeMediaElement();
						}
						else {

							$(display).resetMediaElement();
						}
					});
				});
			};

			// Opens the media display dialog an initilizes the media library

			$.fn.mediaEvent = function(display, uploader, event, rendering) {

				var image = $(this);
				var id = image.data('id');
				var title = image.data('title');
				var label = image.data('label');
				var multiple = rendering === 'single' ? false : 'add';
				var $wrapper = $(display).parent();

				// If the uploader object has already been created, reopen the dialog

				if (undefined !== uploader) {

					uploader.open();
					return;
				}

				// Extend the wp.media object

				uploader = wp.media.frames.file_frame = wp.media({ title: title, button: { text: label }, library: { type : 'image' }, frame: 'select', multiple: multiple });

				// When a file is selected, grab the URL and set it as the text field's value

				uploader.on('select', function() {

					var selection = uploader.state().get('selection');

					if (selection.length >= 2) {

						selection.map(function(attachment) {
							
							var index = $wrapper.children().length - 1;
							var media = id.substring(0, id.lastIndexOf('-')) + '-' + index;

							$(display).multipleMediaElement(index, media, attachment.toJSON());
						});
						
						$wrapper.reorderMediaElement();
						$wrapper.applySortingEvents();
						$('.image-upload').mediaUpload();
					}
					else {

						var attachment = selection.first().toJSON();

						if (event === 'edit') {
							
							$(display).editMediaElement(id, attachment);
						}
						else {

							$(display).addMediaElement(id, attachment, rendering);
						}
					}
				});

				// Open the uploader dialog

				uploader.open();
			};

			// When a media element is reset to it starting view

			$.fn.resetMediaElement = function() {

				var $media = $(this);

				$media.find('input[type="hidden"]').val('');
				$media.find('.regular-text, .widefat').attr('type', 'text');
				$media.find('.image-preview').find('a').html('');
				$media.find('.image-display').addClass('hidden');
				$media.find('.edit-image-action').addClass('hidden');
				$media.find('.upload-image-action').removeClass('hidden');
			};
			
			// When a new media element is added 

			$.fn.addMediaElement = function(id, attachment, rendering) {

				var $media = $(this);

				if (rendering === 'multiple') {

					$media.cloneMediaElement();
				}

				$('#' + id + '-id').val(attachment.id);
				$('#' + id + '-path').attr('type', 'hidden').val(attachment.url);
				$media.find('.image-display').removeClass('hidden');
				$media.find('.image-preview').find('a').html('<img src="' + attachment.sizes.medium.url + '" class="image-media" alt="" />');
				$media.find('.upload-image-action').addClass('hidden');
				$media.find('.edit-image-action').removeClass('hidden');

				$media.parent().reorderMediaElement();
				$media.parent().applySortingEvents();
				$('.image-upload').mediaUpload();
			};

			// When a media element is edited and updated with a new image 

			$.fn.editMediaElement = function(id, attachment) {

				var $media = $(this);

				$('#' + id + '-id').val(attachment.id);
				$('#' + id + '-path').attr('type', 'hidden').val(attachment.url);
				$media.find('.image-preview').find('img').attr('src', attachment.sizes.medium.url);
				$media.find('.edit-image-action').removeClass('hidden');
			};

			// When a media element is removed via a multiple upload

			$.fn.removeMediaElement = function() {

				var $media = $(this);
				var $wrapper = $media.parent();

				$media.remove();
				$wrapper.reorderMediaElement();
				$wrapper.applySortingEvents();
				$wrapper.find('.image-upload').each(function() { $(this).updateMediaElement(); });
			};

			// Adds multiple media element and return it with new index numbers

			$.fn.multipleMediaElement = function(index, id, attachment) {

				var $media = $(this);
				var $wrapper = $media.parent();

				$media.clone()
				.html(function(i, html) { return html.replace(/<img\s+[^>]*src="([^"]*)"[^>]*>/g, ''); })
				.html(function(i, html) { return html.replace(/\-\d+\"/g, '-' + (index + 1) + '"'); })
				.html(function(i, html) { return html.replace(/\-\d+\-/g, '-' + (index + 1) + '-'); })
				.html(function(i, html) { return html.replace(/\[\d+\]/g, '[' + (index + 1) + ']'); })
				.attr('id', $media.attr('id').replace(/\-\d+/g, '-' + (index + 1)))
				.appendTo($wrapper);

				$wrapper.children().eq(index + 1).resetMediaElement();

				var $clone = $('#' + id + '-upload');

				$clone.removeClass('sorting-disabled');
				$clone.find('#' + id + '-id').val(attachment.id);
				$clone.find('#' + id + '-path').attr('type', 'hidden').val(attachment.url);
				$clone.find('.image-display').removeClass('hidden');
				$clone.find('.image-preview').find('a').html('<img src="' + attachment.sizes.medium.url + '" class="image-media" alt="" />');
				$clone.find('.upload-image-action').addClass('hidden');
				$clone.find('.edit-image-action').removeClass('hidden');
			};

			// Clones a media element and return it with new index numbers

			$.fn.cloneMediaElement = function() {

				var $media = $(this);
				var $wrapper = $media.parent();
				var $clone = $media.clone();
				var index = $media.index() + 1;

				$clone.html(function(i, html) { return html.replace(/<img\s+[^>]*src="([^"]*)"[^>]*>/g, ''); });
				$clone.attr('id', function(i, attr) { return attr.replace(/\-\d+/g, '-' + index); });
				$clone.find('[id]').each( function() { $(this).attr('id', $(this).attr('id').replace(/\-\d+/g, '-' + index)); });
				$clone.find('[name]').each( function() { $(this).attr('name', $(this).attr('name').replace(/\[\d+\]/g, '[' + index + ']')); });
				$clone.find('[data-target]').each( function() { $(this).attr('data-target', $(this).attr('data-target').replace(/\-\d+\-/g, '-' + index + '-')); });
				$clone.find('[data-id]').each( function() { $(this).attr('data-id', $(this).attr('data-id').replace(/\-\d+/g, '-' + index)); });

				$clone.appendTo($wrapper);
			};

			// Updates name and id attributes after an item has been removed or reordered

			$.fn.updateMediaElement = function() {

				var $media = $(this);
				var index = $media.index();

				$media.attr('id', function(i, attr) { return attr.replace(/\-\d+/g, '-' + index); });
				$media.find('[id]').each( function() { $(this).attr('id', $(this).attr('id').replace(/\-\d+/g, '-' + index)); });
				$media.find('[name]').each( function() { $(this).attr('name', $(this).attr('name').replace(/\[\d+\]/g, '[' + index + ']')); });
				$media.find('[data-target]').each( function() { $(this).attr('data-target', $(this).attr('data-target').replace(/\-\d+\-/g, '-' + index + '-')); });
				$media.find('[data-id]').each( function() { $(this).attr('data-id', $(this).attr('data-id').replace(/\-\d+/g, '-' + index)); });
				$media.removeAttr('style');
			};

			// Activates the jQuery UI sorting component

			$.fn.orderMediaElement = function() {

				var $media = $(this);

				$media.each(function() {

					var $wrapper = $(this);
					var rendering = $wrapper.data('multiple');

					if (rendering === 'multiple') {

						$wrapper.sortable({ opacity: 0.8, axis: 'y', items: '.image-upload:not(:last-child)',

							start: function(event, ui) {
		        				
		   					},
		   					update: function(event, ui) {
		        				
		   					},
							stop: function(event, ui) { 

								$(this).children().each(function(i) { 

									var $panel = $(this);
									var index = i + 1;

									$panel.find('.image-ordering').val(index);
									$panel.find('.ordering-image-action em').text(index);
									$panel.removeAttr('style');
								});
							}
						});
					}
				});
			};

			// Redraws an element after it's been updated in the DOM

			$.fn.redraw = function() {
				
				//$(this).each(function(){ $(this).offsetHeight; });
			};

			// Reorder and updated the jQuery UI sorting component

			$.fn.reorderMediaElement = function() {
				
				$('.image-upload', this).each(function(i) { var $panel = $(this); var index = i + 1; $panel.find('.image-ordering').val(index); $panel.find('.ordering-image-action em').text(index);  $panel.removeAttr('style'); });
			};

			// Initializes sorting actions on a media element

			$.fn.applySortingEvents = function() {
				
				var $wrapper = $(this);
				var total = $(this).children().length;

				$wrapper.children().each(function() {

					var $media = $(this);

					if (total <= 2) { $media.find('.ordering-image-action').addClass('hidden'); } else { $media.find('.ordering-image-action').removeClass('hidden'); }

					$media.find('.move-up-image-button').unbind('click').on('click', function(e) { e.preventDefault(); $(this).moveUpMediaElement(); });
					$media.find('.move-down-image-button').unbind('click').on('click', function(e) { e.preventDefault(); $(this).moveDownMediaElement(); });
				});
			};

			// Moves up a media element in position hierarchy

			$.fn.moveUpMediaElement = function() {
				
				var $media = $('#' + $(this).data('target'));

				if ($media.index() === 0) { return false; }

				$media.fadeOut(300, function() {

					$media.insertBefore($media.prev());
					$media.fadeIn(300);
					$media.parent().reorderMediaElement();
				});
			};

			// Moves down a media element in sorting hierarchy

			$.fn.moveDownMediaElement = function() {
				
				var $media = $('#' + $(this).data('target'));
				var totel = $media.parent().children().length - 1;

				if ($media.index() === totel - 1) { return false; }

				$media.fadeOut(300, function() {

					$media.insertAfter($media.next());
					$media.fadeIn(300);
					$media.parent().reorderMediaElement();
				});
			};

			// Initializes the media element

			$('.image-upload').mediaUpload();
			$('.image-upload-wrapper').orderMediaElement();
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
	
	return { init: initAll };

})(jQuery, document, window);

mediaupload.init();

