/**
 * This file contains all the main JavaScript functionality needed for the editor formatting buttons.
 * 
 * @author Pexeto
 * http://pexetothemes.com
 */

(function($){

/**
 * Define all the formatting buttons with the HTML code they set.
 */
var pexetoButtons=[
		{
			id:'pexetotitle',
			image:'heading.png',
			title:'Page Underlined Heading',
			allowSelection:true,
			fields:[{id:'text', name:'Heading Text'}],
			generateHtml:function(text){
				return '<h2 class="page-heading">'+text+'</h2>';
			}
		},
		{
			id:'pexetotitle2',
			image:'heading.png',
			title:'Heading with subtitle',
			allowSelection:false,
			fields:[{id:'text', name:'Heading Text'}, {id:'subtitle', name:'Subtitle'}],
			generateHtml:function(obj){
				return '<h4 class="small-title">'+obj.text+'<span>'+obj.subtitle+'</span></h4>';
			}
		},
        {
			id:'pexetohighlight1',
			image:'hl.png',
			title:'Highlight',
			allowSelection:true,
			fields:[{id:'text', name:'Text'}],
			generateHtml:function(text){
				return '<span class="highlight1">'+text+'</span>&nbsp;';
			}
		},
		{
			id:'pexetohighlight2',
			image:'hl_d.png',
			title:'Highlight Dark',
			allowSelection:true,
			fields:[{id:'text', name:'Text'}],
			generateHtml:function(text){
				return '<span class="highlight2">'+text+'</span>&nbsp;';
			}
		},
		{
			id:'pexetodropcaps',
			image:'drop.png',
			title:'Drop Caps',
			allowSelection:true,
			fields:[{id:'letter', name:'Letter'}],
			generateHtml:function(letter){
				return '<span class="drop-caps">'+letter+'</span>';
			}
		},
		{
			id:'pexetolistcheck',
			image:'check.png',
			title:'List Check',
			allowSelection:false,
			list:"bullet_check"
		},
		{
			id:'pexetolistarrow',
			image:'arrow.png',
			title:'List Arrow',
			allowSelection:false,
			list:"bullet_arrow"
		},
		{
			id:'pexetolistarrow2',
			image:'arrow2.png',
			title:'List Arrow 2',
			allowSelection:false,
			list:"bullet_arrow2"
		},
		{
			id:'pexetolistarrow4',
			image:'arrow3.png',
			title:'List Arrow 4',
			allowSelection:false,
			list:"bullet_arrow4"
		},
		{
			id:'pexetoliststar',
			image:'star.png',
			title:'List Star',
			allowSelection:false,
			list:"bullet_star"
		},
		{
			id:'pexetolistplus',
			image:'plus.png',
			title:'List Plus',
			allowSelection:false,
			list:"bullet_plus"
		},
		{
			id:'pexetolinebreak',
			image:'br.png',
			title:'Line break',
			allowSelection:false,
			generateHtml:function(){
				return '<br class="clear" />';
			}
		},
		{
			id:'pexetoframe',
			image:'fr.png',
			title:'Image with frame',
			allowSelection:false,
			fields:[{id:'src', name:'Image URL', type:'upload'},
					{id:'align', name:'Align', values:['none', 'left', 'right']}],
			generateHtml:function(obj){
				var imgclass=obj.align==='none'?'':'align'+obj.align;
				return '<img class="img-frame '+imgclass+'" src="'+obj.src+'" />';
			}
		},
		{
			id:'pexetolightbox',
			image:'lb.png',
			title:'Lightbox image',
			allowSelection:false,
			fields:[{id:'src', name:'Thumbnail URL', type:'upload'}, {id:'href', name:'Preview Image URL', type:'upload'}, {id:'description', name:'Description'}, {id:'align', name:'Align', values:['none', 'left', 'right']}],
			generateHtml:function(obj){
			var imgclass=obj.align==='none'?'':'align'+obj.align;
				return '<div><a rel="lightbox" class="lightbox-image" href="'+obj.href+'" title="'+obj.description+'"><img class="img-frame '+imgclass+'" src="'+obj.src+'" /></a></div>';
			}
		},
		{
			id:'pexetobutton',
			image:'but.png',
			title:'Button',
			allowSelection:false,
			fields:[{id:'text', name:'Text'},{id:'href', name:'Link URL'},{id:'color', name:'Color', type:'colorpicker'}],
			generateHtml:function(obj){
				var style=obj.color?'style="background-color:#'+obj.color+';"':'';
				return '<a class="button" '+style+' href="'+obj.href+'"><span>'+obj.text+'</span></a>';
			}
		},
		{
			id:'pexetoinfoboxes',
			image:'info.png',
			title:'Info Box',
			allowSelection:false,
			fields:[{id:'text', name:'Text'},{id:'type', name:'Type', values:['info', 'error', 'note', 'tip']}],
			generateHtml:function(obj){
				return '<br class="clear" /> <div class="'+obj.type+'-box"><span class="box-icon">&nbsp;</span>'+obj.text+'</div><br class="clear" />';
			}
		},
		{
			id:'pexetotwocolumns',
			image:'col_2.png',
			title:'Two Columns',
			allowSelection:false,
			fields:[{id:'columnone', name:'Column One Content', textarea:true}, {id:'columntwo', name:'Column Two Content', textarea:true}],
			generateHtml:function(obj){
				return '<br class="clear" /><div class="cols-wrapper cols-2"><div class="col">'
				+obj.columnone+'</div><div class="col nomargin">'
				+obj.columntwo+'</div></div><br class="clear" />';
			}
		},
		{
			id:'pexetothreecolumns',
			image:'col_3.png',
			title:'Three Columns',
			allowSelection:false,
			fields:[{id:'columnone', name:'Column One Content', textarea:true}, {id:'columntwo', name:'Column Two Content', textarea:true}, {id:'columnthree', name:'Column Three Content', textarea:true}],
			generateHtml:function(obj){
				return '<br class="clear" /><div class="cols-wrapper cols-3"><div class="col">'
				+obj.columnone+'</div><div class="col">'
				+obj.columntwo+'</div><div class="col nomargin">'
				+obj.columnthree+'</div></div><br class="clear" />';
			}
		},
		{
			id:'pexetofourcolumns',
			image:'col_4.png',
			title:'Four Columns',
			allowSelection:false,
			fields:[{id:'columnone', name:'Column One Content', textarea:true}, {id:'columntwo', name:'Column Two Content', textarea:true}, {id:'columnthree', name:'Column Three Content', textarea:true}, {id:'columnfour', name:'Column Four Content', textarea:true}],
			generateHtml:function(obj){
				return '<br class="clear" /><div class="cols-wrapper cols-4"><div class="col">'
				+obj.columnone+'</div><div class="col">'
				+obj.columntwo+'</div><div class="col">'
				+obj.columnthree+'</div><div class="col nomargin">'
				+obj.columnfour+'</div></div><br class="clear" />';
			}
		},
		{
			id:'pexetoyoutube',
			image:'yt.png',
			title:'Insert YouTube Video',
			allowSelection:false,
			fields:[{id:'src', name:'Video URL'},{id:'width', name:'Width'},{id:'height', name:'Height'}],
			generateHtml:function(obj){
			   var vars = [], hash,
			   hashes = obj.src.slice(obj.src.indexOf('?') + 1).split('&');
			   for(var i = 0; i < hashes.length; i++)
			   {
			       hash = hashes[i].split('=');
			       vars.push(hash[0]);
			       vars[hash[0]] = hash[1];
			   }
			   var width=obj.width||500,
			   		height=obj.height||500;
			   
			   return '<div class="video-wrap"><iframe width="'+width+'" height="'+height+'" src="http://www.youtube.com/embed/'+vars['v']+'" frameborder="0" allowfullscreen></iframe></div>';
			}
		},
		{
			id:'pexetovimeo',
			image:'vm.png',
			title:'Insert Vimeo Video',
			allowSelection:false,
			fields:[{id:'src', name:'Video URL'},{id:'width', name:'Width'},{id:'height', name:'Height'}],
			generateHtml:function(obj){
			var url=obj.src;

			url = url.split('//').pop();
			var videoId=url.split('/')[1];
			
			   var width=obj.width||500,
			   		height=obj.height||500;
			   
			   return '<div class="video-wrap"><iframe src="http://player.vimeo.com/video/'+videoId+'?title=0&amp;byline=0&amp;portrait=0" width="'+width+'" height="'+height+'" frameborder="0"></iframe></div>';
			}
		},
		{
			id:'pexetoflash',
			image:'fl.png',
			title:'Insert Flash',
			allowSelection:false,
			fields:[{id:'src', name:'Video URL'},{id:'width', name:'Width'},{id:'height', name:'Height'}],
			generateHtml:function(obj){
			 var width=obj.width||500,
		   		height=obj.height||500;
			return '<div class="video-wrap"><OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" WIDTH="'+width+'" HEIGHT="'+height+'" id="pexeto-flash" ALIGN=""><PARAM NAME=movie VALUE="'+obj.src+'"> <PARAM NAME=quality VALUE=high> <PARAM NAME=bgcolor VALUE=#333399> <EMBED src="'+obj.src+'" quality=high bgcolor=#333399 WIDTH="'+width+'" HEIGHT="'+height+'" NAME="pexeto-flash" ALIGN="" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED> </OBJECT></div> ';
			}
		},
		{
			id:'pexetotestimonials',
			image:'testimonials.png',
			title:'Insert Testimonial',
			allowSelection:false,
			fields:[{id:'name', name:'Person Name'},{id:'img', name:'Person Image URL', type:'upload'},{id:'occup', name:'Occupation'},{id:'org', name:'Organization'},{id:'link', name:'Organization Link'}, {id:'testim', name:'Testimonial', textarea:true}],
			generateHtml:function(obj){
			var shortcode='[pextestim name="'+obj.name+'"';
			if(obj.img){
				shortcode+=' img="'+obj.img+'"';
			}
			if(obj.occup){
				shortcode+=' occup="'+obj.occup+'"';
			}
			if(obj.org){
				shortcode+=' org="'+obj.org+'"';
			}
			if(obj.link){
				shortcode+=' link="'+obj.link+'"';
			}
			shortcode+=']'+obj.testim+'[/pextestim]'
			
			return shortcode;
			}
		},
		{
			id:'pexetoservices',
			image:'testimonials.png',
			title:'Insert Services Boxes',
			allowSelection:false,
			fields:[{id:'set', name:'Select services set', values:PEXETO.servicesBoxes},
					{id:'columns', name:'Number of columns', values:['2','3','4']},
					{type:'subtitle', name:'Optional'},
					{id:'title', name:'Services Title'},
					{id:'desc', name:'Services Description', textarea:true}],
			generateHtml:function(obj){
				var shortcode='[services set="'+obj.set+'"';

				if(obj.title){
					shortcode+=' title="'+obj.title+'"';
				}

				if(obj.desc){
					shortcode+=' desc="'+obj.desc+'"';
				}

				shortcode+=' columns="'+obj.columns+'"';

				shortcode+=' /]'
				
				return shortcode;
			}
		},
		{
			id:'pexetocarousel',
			image:'testimonials.png',
			title:'Insert Portfolio Carousel',
			allowSelection:false,
			fields:[{id:'cat', name:'Show items from portfolio category', values:PEXETO.portfolioCategories},
					{id:'title', name:'Title (optional)'},
					{id:'maxnum', name:'Maximum number of items'},
					{id:'orderby', name:'Order items by', values:[{name:'Date', id:'date'}, {name:'Custom Order', id:'menu_order'}]},
					{id:'order', name:'Order', values:[{name:'Descending', id:'DESC'}, {name:'Ascending', id:'ASC'}]}
					],
			generateHtml:function(obj){
				var shortcode='[carousel cat="'+obj.cat+'"';

				if(obj.title){
					shortcode+=' title="'+obj.title+'"';
				}

				if(obj.maxnum){
					shortcode+=' maxnum="'+obj.maxnum+'"';
				}

				shortcode+=' orderby="'+obj.orderby+'"';
				shortcode+=' order="'+obj.order+'"';

				shortcode+=' /]'
				return shortcode;
			}
		}
];

/**
 * Contains the main formatting buttons functionality.
 */
pexetoButtonManager={
	dialog:null,
	idprefix:'pexeto-shortcode-',
	ie:false,
	opera:false,
		
	/**
	 * Init the formatting button functionality.
	 */
	init:function(){
			
		var length=pexetoButtons.length;
		for(var i=0; i<length; i++){
		
			var btn = pexetoButtons[i];
			pexetoButtonManager.loadButton(btn);
		}
		
		if ( $.browser.msie ) {
			pexetoButtonManager.ie=true;
		}
		
		if ($.browser.opera){
			pexetoButtonManager.opera=true;
		}
		
	},
	
	/**
	 * Loads a button and sets the functionality that is executed when the button has been clicked.
	 */
	loadButton:function(btn){
		tinymce.create('tinymce.plugins.'+btn.id, {
	        init : function(ed, url) {
			        ed.addButton(btn.id, {
	                title : btn.title,
	                onclick : function() {
			        	
			           var selection = ed.selection.getContent();
	                   if(btn.allowSelection && selection){
	                	   //modification via selection is allowed for this button and some text has been selected
	                	   selection = btn.generateHtml(selection);
	                	   ed.selection.setContent(selection);
	                   }else if(btn.fields){
	                	   //there are inputs to fill in, show a dialog to fill the required data
	                	   pexetoButtonManager.showDialog(btn, ed);
	                   }else if(btn.list){
	  	           			
	                	    //this is a list
	                	    var list, dom = ed.dom, sel = ed.selection;
	                	    
		               		// Check for existing list element
		               		list = dom.getParent(sel.getNode(), 'ul');
		               		
		               		// Switch/add list type if needed
		               		ed.execCommand('InsertUnorderedList');
		               		
		               		// Append styles to new list element
		               		list = dom.getParent(sel.getNode(), 'ul');
		               		
		               		if (list) {
		               			dom.addClass(list, btn.list);
		               			dom.addClass(list, 'imglist');
		               		}
	                   }else{
	                	   //no data is required for this button, insert the generated HTML
	                	   ed.execCommand('mceInsertContent', true, btn.generateHtml());
	                   }
	                }
	            });
	        }
	    });
		
	    tinymce.PluginManager.add(btn.id, tinymce.plugins[btn.id]);
	},
	
	/**
	 * Displays a dialog that contains fields for inserting the data needed for the button.
	 */
	showDialog:function(btn, ed){

		
		if(pexetoButtonManager.ie){
			ed.dom.remove('pexetocaret');
		    var caret = '<div id="pexetocaret">&nbsp;</div>';
		    ed.execCommand('mceInsertContent', false, caret);	
			var selection = ed.selection;
		}
	    
		var html='<div>';
		for(var i=0, length=btn.fields.length; i<length; i++){
			var field=btn.fields[i], inputHtml='';

			if(field.type=='subtitle'){
				html+='<h3 class="dialog-subtitle">'+field.name+'</h3>';
				continue;
			}

			if(field.values){
				//this is a select list
				inputHtml='<select id="'+pexetoButtonManager.idprefix+field.id+'">';
				$.each(field.values, function(index, value){
					var name, id;
					if(typeof value == 'string'){
						name = value;
						id = value;
					}else{
						name = value.name;
						id = value.id;
					}
					inputHtml+='<option value="'+id+'">'+name+'</option>';
				});
				inputHtml+='</select>';
			}else{
				if(field.textarea && !pexetoButtonManager.opera){
					//this field should be a text area
					inputHtml='<textarea id="'+pexetoButtonManager.idprefix+field.id+'" ></textarea>';
				}else{
					var inputClass="";
					if(field.type==='colorpicker'){
						inputClass="color";
					}else if(field.type==='upload'){
						inputClass="pexeto-upload";
					}
					if(field.type==='upload'){
						inputHtml+='<div class="pex-upload-wrapper">';
					}
					inputHtml+='<input type="text" id="'+pexetoButtonManager.idprefix+field.id+'" class="'+inputClass+'" />';
					if(field.type==='upload'){
						inputHtml+='<a class="pexeto-upload-btn pex-button"><span>'+
						'<i area-hidden="true" class="icon-upload"></i>Upload</span></a></div>';
					}
				}
			}
			html+='<div class="pexeto-shortcode-field"><label>'+field.name+'</label>'+inputHtml+'</div>';
		}
		html+='</div>';
				
		var dialog = $(html).dialog({
				 title:btn.title, 
				 modal:false,
				 width:500,
				 dialogClass:'pexeto-dialog',
				 close:function(event, ui){
					$(this).html('').remove();
				 },
				 create:function(){
					//load the color picker functionality
					$(this).find('.pexeto-upload-btn').each(function(){
						$(this).pexetoUpload();
					});

					$(this).find('.color').each(function(){
					 	$(this).pexetoColorpicker();
					});
				 },
				 buttons:[
				 	{
				 		"html": '<i aria-hidden="true" class="icon-plus"></i>Insert',
				 		"class":"pex-button",
				 		"click": function(){
				 			pexetoButtonManager.executeCommand(ed,btn,selection);
				 		}
				 	}
				 ]
			});
		
		pexetoButtonManager.dialog=dialog;
	},
	
	/**
	 * Executes a command when the insert button has been clicked.
	 */
	executeCommand:function(ed, btn, selection){

    		var values={}, html='';
    		
    		if(!btn.allowSelection){
    			//the button doesn't allow selection, generate the values as an object literal
	    		for(var i=0, length=btn.fields.length; i<length; i++){
	        		var id=btn.fields[i].id,
	        			value=$('#'+pexetoButtonManager.idprefix+id).val();
	        		
	    			values[id]=value;
	    		}
	    		html = btn.generateHtml(values);
    		}else{
    			//the button allows selection - only one value is needed for the formatting, so
    			//return this value only (not an object literal)
    			value = $('#'+pexetoButtonManager.idprefix+btn.fields[0].id).attr("value")
    			html = btn.generateHtml(value);
    		}
    		
    	pexetoButtonManager.dialog.remove();

    	if(pexetoButtonManager.ie){
	    	selection.select(ed.dom.select('div#pexetocaret')[0], false);
	    	ed.dom.remove('pexetocaret');
    	}

  		ed.execCommand('mceInsertContent', false, html);
    	
	}
};



$(document).ready(function() {
	pexetoButtonManager.init();
});


})(jQuery);
