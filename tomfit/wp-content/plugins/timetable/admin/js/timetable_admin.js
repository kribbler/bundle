jQuery(document).ready(function($){
	if($("#timetable_settings").length)
		$("#timetable_settings")[0].reset();
	$(".tt_shortcode").val($(".tt_shortcode").data("default"));
	//events hours
	$("#add_event_hours").click(function(event){
		event.preventDefault();
		if($("#start_hour").val()!='' && $("#end_hour").val()!='')
		{
			var detailsDiv = "";
			if($("#tooltip").val()!="" || $("#before_hour_text").val()!="" || $("#after_hour_text").val()!="" || $("#event_hour_category").val()!="")
			{
				detailsDiv = '<div>';
				if($("#tooltip").val()!="")
					detailsDiv += '<br /><strong>Tooltip:</strong> ' + $("#tooltip").val();
				if($("#before_hour_text").val()!="")
					detailsDiv += '<br /><strong>Before hour text:</strong> ' + $("#before_hour_text").val();
				if($("#after_hour_text").val()!="")
					detailsDiv += '<br /><strong>After hour text:</strong> ' + $("#after_hour_text").val();
				if($("#event_hour_category").val()!="")
					detailsDiv += '<br /><strong>Category:</strong> ' + $("#event_hour_category").val();
				detailsDiv += '</div>';
			}
			$("#event_hours_list").css("display", "block").append('<li>' + $("#weekday_id :selected").html() + ' ' + $("#start_hour").val() + "-" + $("#end_hour").val() + '<input type="hidden" name="weekday_ids[]" value="' + $("#weekday_id").val() + '" /><input type="hidden" name="start_hours[]" value="' + $("#start_hour").val() + '" /><input type="hidden" name="end_hours[]" value="' + $("#end_hour").val() + '" /><input type="hidden" name="tooltips[]" value="' + $("#tooltip").val() + '" /><input type="hidden" name="event_hours_category[]" value="' + $("#event_hour_category").val() + '" /><input type="hidden" name="before_hour_texts[]" value="' + $("#before_hour_text").val() + '" /><input type="hidden" name="after_hour_texts[]" value="' + $("#after_hour_text").val() + '" /><img class="operation_button delete_button" src="' + config.img_url + 'delete.png" alt="del" />' + detailsDiv + '</li>');
			$("#start_hour, #end_hour, #tooltip, #before_hour_text, #after_hour_text, #event_hour_category").val("");
			$("#weekday_id :first").attr("selected", "selected");
			if($("#add_event_hours").val()=="Edit")
			{
				$("#add_event_hours").val("Add");
				$("#event_hours_" + $("#event_hours_id").val() + " .delete_button").trigger("click");
				$("#event_hours_id").remove();
			}
		}
	});
	$("#event_hours_list .delete_button").live("click", function(event){
		if(typeof($(this).parent().attr("id"))!="undefined")
			$("#event_hours_list").after('<input type="hidden" name="delete_event_hours_ids[]" value="' + $(this).parent().attr("id").substr(12) + '" />');
		$(this).parent().remove();
		if(!$("#event_hours_list li").length)
			$("#event_hours_list").css("display", "none");
	});
	$("#event_hours_list .edit_button").live("click", function(event){
		if(typeof($(this).parent().attr("id"))!="undefined")
		{
			var loader = $(this).next(".edit_hour_event_loader");
			var id = $(this).parent().attr("id").substr(12);
			loader.css("display", "inline");
			$.ajax({
					url: ajaxurl,
					type: 'post',
					dataType: 'html',
					data: {
						action: 'get_event_hour_details',
						id: id,
						post_id: $("#post_ID").val()
					},
					success: function(json){
						json = $.trim(json);
						var indexStart = json.indexOf("event_hour_start")+16;
						var indexEnd = json.indexOf("event_hour_end")-indexStart;
						json = $.parseJSON(json.substr(indexStart, indexEnd));
						$("#event_hours_table #weekday_id").val(json.weekday_id);
						$("#event_hours_table #start_hour").val(json.start);
						$("#event_hours_table #end_hour").val(json.end);
						$("#event_hours_table #tooltip").val(json.tooltip);
						$("#before_hour_text").val(json.before_hour_text);
						$("#after_hour_text").val(json.after_hour_text);
						$("#event_hour_category").val(json.category);
						$("#event_hours_id").remove();
						$("#event_hours_table #add_event_hours").after("<input type='hidden' id='event_hours_id' name='event_hours_id' value='" + id + "' />");
						loader.css("display", "none");
						var offset = $("#event_hours_table").offset();
						$("html, body").animate({scrollTop: offset.top-30}, 400);
						$("#add_event_hours").val("Edit");
					}
			});
		}
	});
	//colorpicker
	if($(".color").length)
	{
		$(".color").ColorPicker({
			onChange: function(hsb, hex, rgb, el) {
				$(el).val(hex);
				$(el).prev(".color_preview").css("background-color", "#" + hex);
				if($(el).attr("id")=="row1_color" || $(el).attr("id")=="row2_color" || $(el).attr("id")=="box_bg_color" || $(el).attr("id")=="box_hover_bg_color" || $(el).attr("id")=="box_txt_color" || $(el).attr("id")=="box_hover_txt_color" || $(el).attr("id")=="box_hours_txt_color" || $(el).attr("id")=="box_hours_hover_txt_color" || $(el).attr("id")=="filter_color")
					generateShortcode();
			},
			onSubmit: function(hsb, hex, rgb, el){
				$(el).val(hex);
				$(el).ColorPickerHide();
			},
			onBeforeShow: function (){
				var color = (this.value!="" ? this.value : $(this).attr("data-default-color"));
				$(this).ColorPickerSetColor(color);
				$(this).prev(".color_preview").css("background-color", color);
				if($(this).attr("id")=="row1_color" || $(this).attr("id")=="row2_color" || $(this).attr("id")=="box_bg_color" || $(this).attr("id")=="box_hover_bg_color" || $(this).attr("id")=="box_txt_color" || $(this).attr("id")=="box_hover_txt_color" || $(this).attr("id")=="box_hours_txt_color" || $(this).attr("id")=="box_hours_hover_txt_color" || $(this).attr("id")=="filter_color")
					generateShortcode();
			}
		}).on('keyup', function(event, param){
			$(this).ColorPickerSetColor(this.value);
			
			var default_color = $(this).attr("data-default-color");
			$(this).prev(".color_preview").css("background-color", (this.value!="none" ? (this.value!="" ? "#" + (typeof(param)=="undefined" ? $(".colorpicker:visible .colorpicker_hex input").val() : this.value) : (default_color!="transparent" ? "#" + default_color : default_color)) : "transparent"));
			if(($(this).attr("id")=="row1_color" || $(this).attr("id")=="row2_color" || $(this).attr("id")=="box_bg_color" || $(this).attr("id")=="box_hover_bg_color" || $(this).attr("id")=="box_txt_color" || $(this).attr("id")=="box_hover_txt_color" || $(this).attr("id")=="box_hours_txt_color" || $(this).attr("id")=="box_hours_hover_txt_color" || $(this).attr("id")=="filter_color") && typeof(param)=="undefined")
				generateShortcode();
		});
	}
	//shortcode generator
	if($("#timetable_settings").length)
		$("#timetable_settings")[0].reset();
	$("#event, #event_category, #hour_category, #weekday, #measure, #filter_style, #filter_kind, #timetable_settings [name='time_format'], #timetable_settings [name='time_format_custom'], #hide_hours_column, #show_end_hour, #hide_empty, #disable_event_url, #text_align, #responsive, #event_layout, #timetable_font, #timetable_font_subset").change(function(event, param){
		if($(this).attr("id")!="timetable_font" || ($(this).attr("id")=="timetable_font" && param==null))
			generateShortcode();
	});
	$("#filter_label, #row_height, #id, #timetable_font_custom, #timetable_font_size, #timetable_custom_css").on('change keyup', function(){
		generateShortcode();
	});
	function generateShortcode()
	{
		$(".tt_shortcode").val("[tt_timetable" + ($("#event").val()!=null ? " event='" + $("#event").val().join() + "'" : "") + ($("#event_category").val()!=null ? " event_category='" + $("#event_category").val().join() + "'" : "") + ($("#weekday").val()!=null ? " columns='" + $("#weekday").val().join() + "'" : "") + ($("#hour_category").val()!=null ? " hour_category='" + $("#hour_category").val().join() + "'" : "") + (parseInt($("#measure").val())!=1 ? " measure='" + $("#measure").val() + "'" : "") + ($("#filter_style").val()=='tabs' ? " filter_style='tabs'" : "") + ($("#filter_kind").val()=='event_category' ? " filter_kind='event_category'" : "") + ($("#filter_label").val()!='All Events' ? " filter_label='" + $("#filter_label").val() + "'" : "") + ($("#timetable_settings [name='time_format']:checked").val()!='H.i' && $("#timetable_settings [name='time_format']:checked").val()!='custom' ? " time_format='" + $("#timetable_settings [name='time_format']:checked").val() + "'" : ($("#timetable_settings [name='time_format']:checked").val()=="custom" && $("#timetable_settings [name='time_format_custom']").val()!="H.i" ? " time_format='" + $("#timetable_settings [name='time_format_custom']").val() + "'" : "")) + (parseInt($("#hide_hours_column").val())==1 ? " hide_hours_column='1'" : "") + (parseInt($("#show_end_hour").val())==1 ? " show_end_hour='1'" : "") + (parseInt($("#event_layout").val())!=1 ? " event_layout='" + parseInt($("#event_layout").val()) + "'" : "") + ($("#row1_color").val().toUpperCase()!="F0F0F0" ? " row1_color='" + $("#row1_color").val() + "'" : "") + ($("#row2_color").val()!="" ? " row2_color='" + $("#row2_color").val() + "'" : "") + ($("#box_bg_color").val().toUpperCase()!="00A27C" ? " box_bg_color='" + $("#box_bg_color").val() + "'" : "") + ($("#box_hover_bg_color").val().toUpperCase()!="1F736A" ? " box_hover_bg_color='" + $("#box_hover_bg_color").val() + "'" : "") + ($("#box_txt_color").val().toUpperCase()!="FFFFFF" ? " box_txt_color='" + $("#box_txt_color").val() + "'" : "") + ($("#box_hover_txt_color").val().toUpperCase()!="FFFFFF" ? " box_hover_txt_color='" + $("#box_hover_txt_color").val() + "'" : "") + ($("#box_hours_txt_color").val().toUpperCase()!="FFFFFF" ? " box_hours_txt_color='" + $("#box_hours_txt_color").val() + "'" : "") + ($("#box_hours_hover_txt_color").val().toUpperCase()!="FFFFFF" ? " box_hours_hover_txt_color='" + $("#box_hours_hover_txt_color").val() + "'" : "") + ($("#filter_color").val().toUpperCase()!="00A27C" ? " filter_color='" + $("#filter_color").val() + "'" : "") + (parseInt($("#hide_empty").val())==1 ? " hide_empty='1'" : "") + (parseInt($("#disable_event_url").val())==1 ? " disable_event_url='1'" : "") + ($("#text_align").val()!="center" ? " text_align='" + $("#text_align").val() + "'" : "") + (parseInt($("#row_height").val())!=31 ? " row_height='" + parseInt($("#row_height").val()) + "'" : "") + ($("#id").val()!="" ? " id='" + $("#id").val() + "'" : "") + (parseInt($("#responsive").val())==0 ? " responsive='0'" : "") + ($("#timetable_font_custom").val()!="" && $("#timetable_font").val()=="" ? " font_custom='" + $("#timetable_font_custom").val() + "'" : "") + ($("#timetable_font").val()!="" ? " font='" + $("#timetable_font").val() + "'" : "") + ($("#timetable_font_subset").val()!=null ? " font_subset='" + $("#timetable_font_subset").val().join() + "'" : "") + ($("#timetable_font_size").val()!="" ? " font_size='" + $("#timetable_font_size").val() + "'" : "") + ($("#timetable_custom_css").val()!="" ? " custom_css='" + $("#timetable_custom_css").val() + "'" : "") + "]");
	}
	$(".tt_shortcode").on("paste change", function(){
		$("#timetable_settings")[0].reset();
		$("#box_bg_color,#box_hover_bg_color,#box_hover_txt_color,#box_hours_txt_color,#box_hours_hover_txt_color,#filter_color,#row1_color,#row2_color").trigger("keyup", [1]);
		var self = $(this);
		setTimeout(function(){
			var shortcode = self.val();
			$(".tt_shortcode").not(self).val(shortcode);
			var attributes = shortcode.replace("[tt_timetable ", "").replace("]", "").split('\' ');
			var event=null,event_category=null,hour_category=null,weekday=null,measure=null,filter_style=null,filter_kind=null,filter_label=null,time_format=null,hide_hours_column=null,show_end_hour=null,event_layout=null,hide_empty=null,disable_event_url=null,text_align=null,row_height=null,id=null,responsive=null,box_bg_color=null,box_hover_bg_color=null,box_txt_color=null,box_hover_txt_color=null,box_hours_txt_color=null,box_hours_hover_txt_color=null,filter_color=null,row1_color=null,row2_color=null,font_custom=null,font=null,font_subset=null,font_size=null,custom_css=null;
			for(var i=0; i<attributes.length; i++)
			{
				if(attributes[i].indexOf('event=')!=-1)
					event = attributes[i].replace('event=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('event_category=')!=-1)
					event_category = attributes[i].replace('event_category=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('hour_category=')!=-1)
					hour_category = attributes[i].replace('hour_category=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('columns=')!=-1)
					weekday = attributes[i].replace('columns=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('measure=')!=-1)
					measure = attributes[i].replace('measure=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('filter_style=')!=-1)
					filter_style = attributes[i].replace('filter_style=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('filter_kind=')!=-1)
					filter_kind = attributes[i].replace('filter_kind=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('filter_label=')!=-1)
					filter_label = attributes[i].replace('filter_label=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('time_format=')!=-1)
					time_format = attributes[i].replace('time_format=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('hide_hours_column=')!=-1)
					hide_hours_column = attributes[i].replace('hide_hours_column=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('show_end_hour=')!=-1)
					show_end_hour = attributes[i].replace('show_end_hour=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('event_layout=')!=-1)
					event_layout = attributes[i].replace('event_layout=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('hide_empty=')!=-1)
					hide_empty = attributes[i].replace('hide_empty=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('disable_event_url=')!=-1)
					disable_event_url = attributes[i].replace('disable_event_url=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('text_align=')!=-1)
					text_align = attributes[i].replace('text_align=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('row_height=')!=-1)
					row_height = attributes[i].replace('row_height=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('id=')!=-1)
					id = attributes[i].replace('id=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('responsive=')!=-1)
					responsive = attributes[i].replace('responsive=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('box_bg_color=')!=-1)
					box_bg_color = attributes[i].replace('box_bg_color=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('box_hover_bg_color=')!=-1)
					box_hover_bg_color = attributes[i].replace('box_hover_bg_color=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('box_txt_color=')!=-1)
					box_txt_color = attributes[i].replace('box_txt_color=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('box_hover_txt_color=')!=-1)
					box_hover_txt_color = attributes[i].replace('box_hover_txt_color=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('box_hours_txt_color=')!=-1)
					box_hours_txt_color = attributes[i].replace('box_hours_txt_color=', '').replace(/\'/g, "");	
				if(attributes[i].indexOf('box_hours_hover_txt_color=')!=-1)
					box_hours_hover_txt_color = attributes[i].replace('box_hours_hover_txt_color=', '').replace(/\'/g, "");	
				if(attributes[i].indexOf('filter_color=')!=-1)
					filter_color = attributes[i].replace('filter_color=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('row1_color=')!=-1)
					row1_color = attributes[i].replace('row1_color=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('row2_color=')!=-1)
					row2_color = attributes[i].replace('row2_color=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('font_custom=')!=-1)
					font_custom = attributes[i].replace('font_custom=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('font=')!=-1)
					font = attributes[i].replace('font=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('font_subset=')!=-1)
					font_subset = attributes[i].replace('font_subset=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('font_size=')!=-1)
					font_size = attributes[i].replace('font_size=', '').replace(/\'/g, "");
				if(attributes[i].indexOf('custom_css=')!=-1)
					custom_css = attributes[i].replace('custom_css=', '').replace(/\'/g, "");
			}
			if(event!=null)
				$("#event").val(event.split(","));
			if(event_category!=null)
				$("#event_category").val(event_category.split(","));
			if(hour_category!=null)
				$("#hour_category").val(hour_category.split(","));
			if(weekday!=null)
				$("#weekday").val(weekday.split(","));
			if(measure!=null)
				$("#measure").val(measure);
			if(filter_style!=null)
				$("#filter_style").val(filter_style);
			if(filter_kind!=null)
				$("#filter_kind").val(filter_kind);
			if(filter_label!=null)
				$("#filter_label").val(filter_label);
			if(time_format!=null)
			{
				$("#time_format").val(time_format);
				$("[name='time_format'][value='" + time_format + "']").prop("checked", true);
			}
			if(hide_hours_column!=null)
				$("#hide_hours_column").val(hide_hours_column);
			if(show_end_hour!=null)
				$("#show_end_hour").val(show_end_hour);
			if(event_layout!=null)
				$("#event_layout").val(event_layout);
			if(hide_empty!=null)
				$("#hide_empty").val(hide_empty);
			if(disable_event_url!=null)
				$("#disable_event_url").val(disable_event_url);
			if(text_align!=null)
				$("#text_align").val(text_align);
			if(row_height!=null)
				$("#row_height").val(row_height);
			if(id!=null)
				$("#id").val(id);
			if(responsive!=null)
				$("#responsive").val(responsive);
			if(box_bg_color!=null)
				$("#box_bg_color").val(box_bg_color).trigger("keyup", [1]);
			if(box_hover_bg_color!=null)
				$("#box_hover_bg_color").val(box_hover_bg_color).trigger("keyup", [1]);
			if(box_txt_color!=null)
				$("#box_txt_color").val(box_txt_color).trigger("keyup", [1]);
			if(box_hover_txt_color!=null)
				$("#box_hover_txt_color").val(box_hover_txt_color).trigger("keyup", [1]);
			if(box_hours_txt_color!=null)
				$("#box_hours_txt_color").val(box_hours_txt_color).trigger("keyup", [1]);
			if(box_hours_hover_txt_color!=null)
				$("#box_hours_hover_txt_color").val(box_hours_hover_txt_color).trigger("keyup", [1]);
			if(filter_color!=null)
				$("#filter_color").val(filter_color).trigger("keyup", [1]);
			if(row1_color!=null)
				$("#row1_color").val(row1_color).trigger("keyup", [1]);
			if(row2_color!=null)
				$("#row2_color").val(row2_color).trigger("keyup", [1]);
			if(font_custom!=null)
				$("#timetable_font_custom").val(font_custom);
			if(font!=null)
				$("#timetable_font").val(font).trigger("change", (font_subset!=null ? [font_subset.split(",")] : null));
			if(font_size!=null)
				$("#timetable_font_size").val(font_size);
			if(custom_css!=null)
				$("#timetable_custom_css").val(custom_css);
		}, 1);
	});

	//copy to clipboard
	try
	{
		var client = new ZeroClipboard( document.getElementById("copy_to_clipboard1"), {
			moviePath: config.js_url + 'ZeroClipboard.swf'
		});

		client.on("load", function(client){
			client.on('dataRequested', function (client, args){
				client.setText($(".tt_shortcode").val());
			});
			client.on( "complete", function(client, args){
				$(".copy_info").css("display", "inline").fadeOut(2000);
			});
		});
		
		client = new ZeroClipboard( document.getElementById("copy_to_clipboard2"), {
			moviePath: config.js_url + 'ZeroClipboard.swf'
		});

		client.on("load", function(client){
			client.on('dataRequested', function (client, args){
				client.setText($(".tt_shortcode").val());
			});
			client.on( "complete", function(client, args){
				$(".copy_info").css("display", "inline").fadeOut(2000);
			});
		});
	}
	catch(err)
	{
	}
	 
	$("#timetable_settings").submit(function(event){
		event.preventDefault();
	});
	$("#timetable_settings [name='time_format']").change(function(){
		if($(this).val()!="custom")
		{
			$(this).parent().siblings("input:last").val($(this).val());
			$(this).parent().siblings(".example").html($(this).next().html());
		}
	});
	$("#timetable_settings [name='time_format_custom']").on('focus', function(){
		$(this).prev().children().prop("checked", true);
	});
	$("#timetable_settings [name='time_format_custom']").on('change', function(){
		var format = $(this).val();
		$(this).next().next().css("display", "inline-block");
		var self = $(this);
		$.ajax({
				url: ajaxurl,
				type: 'post',
				data: {
					action: 'time_format',
					date: format
				},
				success: function(data){
					self.next().html(data);
					self.next().next().css("display", "none");
				}
		});
	});
	//upcoming events widget
	$("#upcoming_events_time_from").live("change", function(){
		$(this).parent().next().css("display", ($(this).val()=="server" ? "block" : "none"));
	});
	$("#timetable_configuration_tabs").tabs();
	//font subset
	$(".google_font_chooser").change(function(event, param){
		var self = $(this);
		if(self.val()!="")
		{
			self.next().css("display", "inline-block");
			$.ajax({
					url: ajaxurl,
					type: 'post',
					data: "action=timetable_get_font_subsets&font=" + $(this).val(),
					success: function(data){
						data = $.trim(data);
						var indexStart = data.indexOf("timetable_start")+15;
						var indexEnd = data.indexOf("timetable_end")-indexStart;
						data = data.substr(indexStart, indexEnd);
						self.next().css("display", "none");
						self.parent().parent().next().find(".fontSubset").css("display", "inline").html(data);
						self.parent().parent().next().css("display", "table-row");
						if(param!=null)
						{
							for(val in param)
								self.parent().parent().next().find("[value='" + param[val] + "']").attr("selected", "selected");
						}
					}
			});
		}
		else
			self.parent().parent().next().css("display", "none");
	});
	//dummy content import
	$("#import_dummy").click(function(event){
		event.preventDefault();
		var self = $(this);
		$("#dummy_content_tick").css("display", "none");
		self.next().css("display", "inline-block");
		$("#dummy_content_info").html("Please wait and don't reload the page when import is in progress!");
		$.ajax({
				url: ajaxurl,
				type: 'post',
				data: "action=timetable_import_dummy",
				success: function(json){
					json = $.trim(json);
					var indexStart = json.indexOf("dummy_import_start")+18;
					var indexEnd = json.indexOf("dummy_import_end")-indexStart;
					json = $.parseJSON(json.substr(indexStart, indexEnd));
					self.next().css("display", "none");
					$("#dummy_content_tick").css("display", "inline");
					$("#dummy_content_info").html(json.info);
				},
				error: function(jqXHR, textStatus, errorThrown){
					$("#dummy_content_preloader").css("display", "none");
					$("#dummy_content_info").html("Error during import:<br>" + jqXHR + "<br>" + textStatus + "<br>" + errorThrown);
					console.log(jqXHR);
					console.log(textStatus);
					console.log(errorThrown);
				}
		});
	});
});