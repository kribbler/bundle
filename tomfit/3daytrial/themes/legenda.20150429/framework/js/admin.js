jQuery(document).ready(function(){

	/* UNLIMITED SIDEBARS */
	
	var delSidebar = '<div class="delete-sidebar">delete</div>';
	
	jQuery('.sidebar-etheme_custom_sidebar').find('.sidebar-name-arrow').before(delSidebar);
	
	jQuery('.delete-sidebar').click(function(){
		
		var confirmIt = confirm('Are you sure?');
		
		if(!confirmIt) return;
		
		var widgetBlock = jQuery(this).parent().parent();
	
		var data =  {
			'action':'etheme_delete_sidebar',
			'etheme_sidebar_name': jQuery(this).parent().find('h3').text()
		};
		
		widgetBlock.hide();
		
		jQuery.ajax({
			url: ajaxurl,
			data: data,
			success: function(response){
				console.log(response);
				widgetBlock.remove();
			},
			error: function(data) {
				alert('Error while deleting sidebar');
				widgetBlock.show();
			}
		});
	});

	
	/* end sidebars */
    
    var theme_settings = jQuery('#prima-theme-settings');
    // Only show the background color input when the background color option type is Color (Hex)
    jQuery('.background-option-types').each(function() {
        showHideHexColor(jQuery(this));
        jQuery(this).change( function() {
            showHideHexColor( jQuery(this) ) 
        });
    });
    // Add color picker to color input boxes.
    jQuery('input.color-picker').each(function (i) {
        jQuery(this).after('<div id="picker-' + i + '" style="z-index: 100; background: #EEE; border: 1px solid #CCC; position: absolute; display: block;"></div>');
        jQuery('#picker-' + i).hide().farbtastic(jQuery(this));
    })
    .focus(function() {
        jQuery(this).next().show();
        if (jQuery(this).val() == '') {
            jQuery(this).val('#');
        }
    })
    .blur(function() {
        jQuery(this).next().hide();
        if (jQuery(this).val() == '#') {
            jQuery(this).val('');
        }
    });
    // Show or hide the hex color input.
    function showHideHexColor(selectElement) {
        // Use of hide() and show() look bad, as it makes it display:block before display:none / inline.
        selectElement.next().css('display','none');
        if (selectElement.val() == 'hex') {
            selectElement.next().css('display', 'inline');
        }
    }
    var sidebarCkeck = jQuery('#product_page_sidebar');
    var defaultSidebar = sidebarCkeck.is(':checked');
    var labelText = sidebarCkeck.next().text();
    
    function checkState(element,defaultSidebar){
        changedVal = element.val();
        
        if(changedVal == 3){                
            sidebarCkeck.css('opacity',0.5).attr('checked',true).removeAttr("disabled");
            sidebarCkeck.next().text('Sidebar is always enabled for 3 products');
        }else if(changedVal == 6){
            sidebarCkeck.attr('checked',false).attr("disabled", true);
            sidebarCkeck.next().text('Sidebar is disabled for 6 products');
        }else{
            sidebarCkeck.css('opacity',1).attr('checked',defaultSidebar).removeAttr("disabled");
            sidebarCkeck.next().text(labelText);
        }
    }
    jQuery('#prodcuts_per_row').change(function(){
        checkState(jQuery(this),defaultSidebar);        
    });
    
    checkState(jQuery('#prodcuts_per_row'),defaultSidebar);
    
    jQuery('.importBtn').toggle(function(){
	    jQuery(this).next().show();
    },function(){
	    jQuery(this).next().hide();
    });
    
    jQuery('.use-global').click(function() {
	    var related = jQuery(this).data('related');
	    var value   = jQuery(this).attr('checked');
	    var selector = '.' + related;
	    
	    
	    if(value == 'checked') {
		    jQuery(selector).addClass('option-disabled');
	    }else{
		    jQuery(selector).removeClass('option-disabled');
	    }
    });
    
    var importBtn = jQuery('#install_demo_pages');
    
	importBtn.bind("click", (function(e){
		e.preventDefault();
        
        var style = jQuery('#demo_data_style').val();
		
		if(!confirm('Are you sure you want to install demo data in "' + style + '" style? (It will change all your theme configuration, menu etc.)')) {
			
			return false;
			
		}
		
		importBtn.after('<div id="floatingCirclesG" class="loading"><div class="f_circleG" id="frotateG_01"></div><div class="f_circleG" id="frotateG_02"></div><div class="f_circleG" id="frotateG_03"></div><div class="f_circleG" id="frotateG_04"></div><div class="f_circleG" id="frotateG_05"></div><div class="f_circleG" id="frotateG_06"></div><div class="f_circleG" id="frotateG_07"></div><div class="f_circleG" id="frotateG_08"></div></div>');
        importBtn.text('Installing demo data... Please wait...').removeClass('blue').addClass('disabled').attr('disabled', 'disabled').unbind('click');
        
		jQuery.ajax({
			method: "POST",
			url: ajaxurl,
			data: {
				'action':'etheme_import_ajax',
                'version' : style
			},
			success: function(data){
				jQuery('#option-tree-sub-header').before('<div id="setting-error-settings_updated" class="updated settings-error">' + data + '</div>');
			},
			complete: function(){
                jQuery('#floatingCirclesG').remove();
                //jQuery('.installing-info').remove();
                importBtn.addClass('green');
                importBtn.text('Successfully installed!');
                window.location.href=window.location.href;
			}
		});
	
	}));
	
});


/**
 * Upload Option
 * Allows window.send_to_editor to function properly using a private post_id
 * Dependencies: jQuery, Media Upload, Thickbox
 * Credits: OptionTree
 */
(function ($) {
  uploadOption = {
    init: function () {
      var formfield,
          formID,
          btnContent = true;
      // On Click
      $('.upload_button').live("click", function () {
        formfield = $(this).prev('input').attr('id');
        formID = $(this).attr('rel');
        // Display a custom title for each Thickbox popup.
        var prima_title = '';
        prima_title = $(this).prev().prev('.upload_title').text();
        tb_show( prima_title, 'media-upload.php?post_id='+formID+'&type=image&amp;TB_iframe=1');
        return false;
      });
            
      window.original_send_to_editor = window.send_to_editor;
      window.send_to_editor = function(html) {
        if (formfield) {
          if ( $(html).html(html).find('img').length > 0 ) {
          	itemurl = $(html).html(html).find('img').attr('src');
          } 
		  else {
          	var htmlBits = html.split("'");
          	itemurl = htmlBits[1];
          	var itemtitle = htmlBits[2];
          	itemtitle = itemtitle.replace( '>', '' );
          	itemtitle = itemtitle.replace( '</a>', '' );
          }
          var image = /(^.*\.jpg|jpeg|png|gif|ico*)/gi;
          var document = /(^.*\.pdf|doc|docx|ppt|pptx|odt*)/gi;
          var audio = /(^.*\.mp3|m4a|ogg|wav*)/gi;
          var video = /(^.*\.mp4|m4v|mov|wmv|avi|mpg|ogv|3gp|3g2*)/gi;
          if (itemurl.match(image)) {
            btnContent = '<img src="'+itemurl+'" alt="" /><a href="#" class="remove etheme">Remove Image</a>';
          } else {
            btnContent = '<div class="no_image">'+html+'<a href="#" class="remove etheme">Remove</a></div>';
          }
          $('#' + formfield).val(itemurl);
          $('#' + formfield).next().next('div').slideDown().html(btnContent);
          tb_remove();
        } else {
          window.original_send_to_editor(html);
        }
      }
    }
  };
  $(document).ready(function () {
	  uploadOption.init();
      // Remove Uploaded Image
      $('.remove').live('click', function(event) { 
        $(this).hide();
        $(this).parents().prev().prev('.upload').attr('value', '');
        $(this).parents('.screenshot').slideUp();
      });
  })
})(jQuery);

(function($) {
window.VcSectionView = vc.shortcode_view.extend({
        change_columns_layout:false,
        events:{
            'click > .controls .column_delete':'deleteShortcode',
            'click > .controls .set_columns':'setColumns',
            'click > .controls .column_add':'addElement',
            'click > .controls .column_edit':'editElement',
            'click > .controls .column_clone':'clone',
            'click > .controls .column_move':'moveElement'
        },
        _convertRowColumns:function (layout) {
            var layout_split = layout.toString().split(/\_/),
                columns = Shortcodes.where({parent_id:this.model.id}),
                new_columns = [],
                new_width = '';
            _.each(layout_split, function (value, i) {
                var column_data = _.map(value.toString().split(''), function (v, i) {
                        return parseInt(v, 10);
                    }),
                    new_column_params, new_column;
                if(column_data.length > 3)
                    new_width = column_data[0] + '' + column_data[1] + '/' + column_data[2] + '' + column_data[3];
                else if(column_data.length > 2)
                    new_width = column_data[0] + '/' + column_data[1] + '' + column_data[2];
                else
                    new_width = column_data[0] + '/' + column_data[1];
                new_column_params = _.extend(!_.isUndefined(columns[i]) ? columns[i].get('params') : {}, {width: new_width}),
                vc.storage.lock();
                new_column = Shortcodes.create({shortcode:(this.model.get('shortcode') === 'vc_row_inner' ? 'vc_column_inner' : 'vc_column'), params:new_column_params, parent_id:this.model.id});
                if (_.isObject(columns[i])) {
                    _.each(Shortcodes.where({parent_id:columns[i].id}), function (shortcode) {
                        vc.storage.lock();
                        shortcode.save({parent_id:new_column.id});
                        vc.storage.lock();
                        shortcode.trigger('change_parent_id');
                    });
                }
                new_columns.push(new_column);

            }, this);
            if (layout_split.length < columns.length) {
                _.each(columns.slice(layout_split.length), function (column) {
                    _.each(Shortcodes.where({parent_id:column.id}), function (shortcode) {
                        vc.storage.lock();
                        shortcode.save({'parent_id':_.last(new_columns).id});
                        vc.storage.lock();
                        shortcode.trigger('change_parent_id');
                    });
                });
            }
            _.each(columns, function (shortcode) {
                vc.storage.lock();
                shortcode.destroy();
            }, this);
            this.model.save();
            // this.sizeRows();
            return false;
        },
        _getCurrentLayoutString: function() {
            var layouts = [];
            $('> .wpb_vc_column, > .wpb_vc_column_inner', this.$content).each(function () {
                var width = $(this).data('width');
                layouts.push(_.isUndefined(width) ? '1/1' : width);
            });
            return layouts.join(' + ');
        },
        setSorting:function () {
            var that = this;
            if (this.$content.find("> [data-element_type=vc_column], > [data-element_type=vc_column_inner]").length > 1) {
                this.$content.removeClass('wpb-not-sortable').sortable({
                    forcePlaceholderSize:true,
                    placeholder:"widgets-placeholder-column",
                    tolerance:"pointer",
                    // cursorAt: { left: 10, top : 20 },
                    cursor:"move",
                    //handle: '.controls',
                    items:"> [data-element_type=vc_column], > [data-element_type=vc_column_inner]", //wpb_sortablee
                    distance:0.5,
                    start:function (event, ui) {
                        $('#visual_composer_content').addClass('sorting-started');
                        ui.placeholder.width(ui.item.width());
                    },
                    stop:function (event, ui) {
                        $('#visual_composer_content').removeClass('sorting-started');
                    },
                    update:function () {
                        var $columns = $("> [data-element_type=vc_column], > [data-element_type=vc_column_inner]", that.$content);
                        $columns.each(function () {
                            var model = $(this).data('model'),
                                index = $(this).index();
                            model.set('order', index);
                            if ($columns.length - 1 > index) vc.storage.lock();
                            model.save();
                        });
                    },
                    over:function (event, ui) {
                        ui.placeholder.css({maxWidth:ui.placeholder.parent().width()});
                        ui.placeholder.removeClass('hidden-placeholder');
                        // if (ui.item.hasClass('not-column-inherit') && ui.placeholder.parent().hasClass('not-column-inherit')) {
                        //     ui.placeholder.addClass('hidden-placeholder');
                        // }
                    },
                    beforeStop:function (event, ui) {
                        // if (ui.item.hasClass('not-column-inherit') && ui.placeholder.parent().hasClass('not-column-inherit')) {
                        //     return false;
                        // }
                    }
                });
            } else {
                if (this.$content.hasClass('ui-sortable')) this.$content.sortable('destroy');
                this.$content.addClass('wpb-not-sortable');
            }
        },
        validateCellsList: function(cells) {
            var return_cells = [],
                split = cells.replace(/\s/g, '').split('+'),
                b;
            var sum = _.reduce(_.map(split, function(c){
                if(c.match(/^[vc\_]{0,1}span\d{1,2}$/)) {
                    var converted_c = vc_convert_column_span_size(c);
                    if(converted_c===false) return 1000;
                    b = converted_c.split(/\//);
                    return_cells.push(b[0] + '' + b[1]);
                    return 12*parseInt(b[0], 10)/parseInt(b[1], 10);
                } else if(c.match(/^[1-9]|1[0-2]\/[1-9]|1[0-2]$/)) {
                    b = c.split(/\//);
                    return_cells.push(b[0] + '' + b[1]);
                    return 12*parseInt(b[0], 10)/parseInt(b[1], 10);
                }
                return 10000;

            }), function(num, memo) {
                memo = memo + num;
                return memo;
            }, 0);
            if(sum!==12) return false;
            return return_cells.join('_');
        },
        setColumns:function (e) {
            if (_.isObject(e)) e.preventDefault();
            var $button = $(e.currentTarget);
            if($button.data('cells')==='custom') {
                var cells = window.prompt(window.i18nLocale.enter_custom_layout, this._getCurrentLayoutString());
                if(_.isString(cells)) {
                    if((cells = this.validateCellsList(cells))!==false) {
                        this.change_columns_layout = true;
                        this._convertRowColumns(cells);
                        this.$el.find('> .controls .vc_active').removeClass('vc_active');
                        $button.addClass('vc_active');
                    } else {
                        window.alert(window.i18nLocale.wrong_cells_layout);
                    }
                }
                return;
            }
            if ($button.is('.vc_active')) return false;

            this.$el.find('> .controls .vc_active').removeClass('vc_active');
            $button.addClass('vc_active');
            this.change_columns_layout = true;
                _.defer(function (view, cells) {
                    view._convertRowColumns(cells);
                }, this, $button.data('cells'));
        },
        sizeRows:function () {
            var max_height = 35;
            $('> .wpb_vc_column, > .wpb_vc_column_inner', this.$content).each(function () {
                var content_height = $(this).find('> .wpb_element_wrapper > .wpb_column_container').css({minHeight:0}).height();
                if (content_height > max_height) max_height = content_height;
            }).each(function () {
                    $(this).find('> .wpb_element_wrapper > .wpb_column_container').css({minHeight:max_height });
                });
        },
        ready:function (e) {
            window.VcRowView.__super__.ready.call(this, e);
            return this;
        },
        checkIsEmpty:function () {
            window.VcRowView.__super__.checkIsEmpty.call(this);
            this.setSorting();
        },
        changedContent:function (view) {
            this.sizeRows();
            if (this.change_columns_layout) return this;
            var column_layout = [];
            $('> .wpb_vc_column, > .wpb_vc_column_inner', this.$content).each(function () {
                var width = $(this).data('width');
                column_layout.push(_.isUndefined(width) ? '11' : width.replace('/', ''));
            });
            this.$el.find('> .controls .vc_active').removeClass('vc_active');
            var $button = this.$el.find('> .controls [data-cells-mask=' + vc_get_column_mask(column_layout.join('_')) + ']');
            if($button.length) {
               $button.addClass('vc_active');
            } else {
                this.$el.find('> .controls [data-cells-mask=custom]').addClass('vc_active');
            }
            this.sizeRows();
        },
        moveElement:function (e) {
            e.preventDefault();
        }
  
});
})(jQuery);