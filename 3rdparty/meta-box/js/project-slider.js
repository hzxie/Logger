jQuery(document).ready(function($) {
	var $slider = $('#project-slider'),
		$slide = $slider.children('.slide');

	function adjustContainerHeight() {
		// $slider.height('auto').height($('#project-slider').height())
	}
	adjustContainerHeight();
	$('#add-slider-slide').click(function(e) {
		$slider.height('auto');
		var $cloneElem = $slider.children('.slide').last().clone();
		$cloneElem.removeClass('closed').children('.inside').show().end().find('.slide-type').hide().end().find('.slide-type.image').show().end().find('select').val('').end().find('input[type=text]').val('').end().find('textarea').val('').end().insertAfter($slider.children('.slide').last());
		adjustContainerHeight();
		e.preventDefault()
	});
	$slider.delegate('.remove-slide', 'click', function(e) {
		if ($slider.children('.slide').length == 1) {
			$slide.find('.slide-type').hide().end().find('.slide-type.image').show().end().find('input[type=text]').val('').end().find('input[type=hidden]').val('').end().find('select').val('').end().find('textarea').val('');
			alert('You need to have at least 1 slide!')
		} else {
			$(this).parents('.slide').remove()
		}
		adjustContainerHeight();
		e.preventDefault()
	});
	$slider.sortable({
		handle: 'h3.hndle',
		placeholder: 'sortable-placeholder',
		sort: function(event, ui) {
			$('.sortable-placeholder').height($(this).find('.ui-sortable-helper').height())
		},
		tolerance: 'pointer'
	});
	$slider.delegate('.hndle', 'click', function() {
		$(this).siblings('.inside').toggle().end().parent().toggleClass('closed');
		adjustContainerHeight()
	});
	$slider.delegate('.handlediv', 'click', function() {
		$(this).siblings('.hndle').trigger('click')
	});

	function adjustSlideTypes(selector) {
		var $tabsContent = selector.parents('.tabs-content');
		$tabsContent.find('.slide-type').hide();
		if (selector.val() === 'image') {
			$tabsContent.find('.slide-type.image').show()
		} else if (selector.val() === 'video') {
			$tabsContent.find('.slide-type.video').show()
		} else if (selector.val() === 'audio') {
			$tabsContent.find('.slide-type.audio').show()
		} else if (selector.val() === 'custom') {
			$tabsContent.find('.slide-type.custom').show()
		}
		adjustContainerHeight()
	}
	$slider.delegate('select[name="slide-type[]"]', 'change', function() {
		adjustSlideTypes($(this))
	});
	$slider.find('select[name="slide-type[]"]').each(function(i) {
		$slider.find('select[name="slide-type[]"]').trigger('change')
	});
	$slider.delegate('.upload-image', 'click', function(e) {
		var $this = $(this),
			data = $('input[name="slider-meta-info"]').val().split('|'),
			postId = data[0],
			fieldId = data[1],
			tbframeInterval;
		tb_show('', 'media-upload.php?post_id=' + postId + '&field_id=' + fieldId + '&type=image&TB_iframe=true&width=670&height=600');
		tbframeInterval = setInterval(function() {
			$('#TB_iframeContent').contents().find('.savesend .button').val('Use This Image')
		}, 1000);
		window.send_to_editor = function(html) {
			clearInterval(tbframeInterval);
			var imgUrl = $('img', html).attr('src');
			$this.siblings('input[type="text"]').val(imgUrl);
			tb_remove()
		};
		e.preventDefault()
	})
});
