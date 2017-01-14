frameworkShortcodeAtts={
	attributes:[
			{
				label:"Button text",
				id:"text",
				defaultValue: 'Button',
				defaultText: 'Button',
				help:"Enter some text for the button."
			},
			{
				label:"Button link",
				id:"link",
				help:"Enter a link for the button. (e.g. http://yoursite.com/)"
			},
			{
				label:"Size",
				id:"size",
				controlType:"select-control",
				selectValues:['small', 'large'],
				defaultValue: 'large', 
				defaultText: 'large',
				help:"Choose the button size."
			},
			{
				label:"Color",
				id:"color",
				controlType:"select-control",
				selectValues:['Blue', 'Dark blue', 'Grey', 'Green', 'Yellow', 'Pink'],
				defaultValue: 'info', 
				defaultText: 'info',
				help:"Choose the button style."
			},
			{
				label:"Target",
				id:"target",
				controlType:"select-control",
				selectValues:['_blank', '_self', '_parent', '_top'],
				defaultValue: '_self', 
				defaultText: '_self',
				help:"The target attribute specifies if the the linked document should be loaded in a window or a frame."
			}
	],
	defaultContent:"",
	shortcode:"button"
};
