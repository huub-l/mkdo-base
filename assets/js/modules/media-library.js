export const mediaGridObserver = new MutationObserver(function (mutations) {

	let element, elementClass, attachmentPreview;

	for (let i = 0; i < mutations.length; i++)
	{

		for (let j = 0; j < mutations[i].addedNodes.length; j++)
		{
			element = $(mutations[i].addedNodes[j]);

			if (element.attr('class'))
			{
				elementClass = element.attr('class');
				if (-1 != element.attr('class').indexOf('attachment'))
				{

					attachmentPreview = element.children('.attachment-preview');
					if (0 != attachmentPreview.length)
					{
						if (-1 != attachmentPreview.attr('class').indexOf('subtype-svg+xml'))
						{
							let handler = function (element) {

								jQuery.ajax({

									url: scriptVars.ajax_url,
									type: 'POST',
									dataType: 'html',
									data: {
										'action': 'svg_get_attachment_url',
										'attachment_id': element.attr('data-id')
									},
									success: function (data) {
										if (data)
										{
											element.find('img').attr('src', data);
											element.find('.filename').text('SVG Image');
										}
									}
								});

							}(element);

						}
					}
				}
			}
		}
	}
});

export const attachmentPreviewObserver = new MutationObserver(function (mutations) {

	for (let i = 0; i < mutations.length; i++)
	{
		for (let j = 0; j < mutations[i].addedNodes.length; j++)
		{
			let element = $(mutations[i].addedNodes[j]);
			let onAttachmentPage = false;
			if ((element.hasClass('attachment-details')) || 0 != element.find('.attachment-details').length)
			{
				onAttachmentPage = true;
			}

			if (true == onAttachmentPage)
			{
				let urlLabel = element.find('label[data-setting="url"]');
				if (0 != urlLabel.length)
				{
					let value = urlLabel.find('input').val();
					element.find('.details-image').attr('src', value);
				}
			}
		}
	}
});
