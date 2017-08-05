// Context Menu Plugin for HTMLArea-3.0
// Sponsored by www.americanbible.org
// Implementation by Mihai Bazon, http://dynarch.com/mishoo/
//
// (c) dynarch.com 2003.
// Distributed under the same terms as HTMLArea itself.
// This notice MUST stay intact for use (see license.txt).
//
// $Id: context-menu.js,v 1.2 2003/12/05 09:17:02 mishoo Exp $

HTMLArea.loadStyle("menu.css", "ContextMenu");

function ContextMenu(editor) {
	this.editor = editor;
};

ContextMenu._pluginInfo = {
	name          : "ContextMenu",
	version       : "1.0",
	developer     : "Mihai Bazon",
	developer_url : "http://dynarch.com/mishoo/",
	c_owner       : "dynarch.com",
	sponsor       : "American Bible Society",
	sponsor_url   : "http://www.americanbible.org",
	license       : "htmlArea"
};

ContextMenu.prototype.onGenerate = function() {
	var self = this;
	var doc = this.editordoc = this.editor._iframe.contentWindow.document;
	HTMLArea._addEvents(doc, ["contextmenu"],
			    function (event) {
				    return self.popupMenu(HTMLArea.is_ie ? self.editor._iframe.contentWindow.event : event);
			    });
	this.currentMenu = null;
};

ContextMenu.prototype.getContextMenu = function(target) {
	var self = this;
	var editor = this.editor;
	var config = editor.config;
	var menu = [];
	var tbo = this.editor.plugins.TableOperations;
	if (tbo) tbo = tbo.instance;
	var i18n = ContextMenu.I18N;
	

	var selection = editor.hasSelectedText();
	if (selection)
		menu.push([ i18n["Cut"], function() { editor.execCommand("cut"); }, null, config.btnList["cut"][1] ],
			  [ i18n["Copy"], function() { editor.execCommand("copy"); }, null, config.btnList["copy"][1] ]);
	menu.push([ i18n["Paste"], function() { editor.execCommand("paste"); }, null, config.btnList["paste"][1] ]);

	var currentTarget = target;
	var elmenus = [];
	var elmenus2 = [];

	var link = null;
	var table = null;
	var tr = null;
	var td = null;
	var img = null;

	function tableOperation(opcode) {
		tbo.buttonPress(editor, opcode);
	};
	

	for (; target; target = target.parentNode) {
		var tag = target.tagName;
		if (!tag)
			continue;
		tag = tag.toLowerCase();
		switch (tag) {
		    case "img":
			img = target;
			link = target; 
			if ( img.className == 'anchor' )
			{
    			elmenus.push(null,
    				     [ 'Modify Anchor',
    				       function() {
    					       insertAnchor(editor);
    				       },
    				       i18n["Show the image properties dialog"],
    				       config.btnList["insertanchor"][1]
    				        ]
    				);
			}
			else if ( img.className == 'object' )
			{
    			elmenus.push(null,
    				     [ 'Modify Object',
    				       function() {
    					       insertObject(editor);
    				       },
    				       i18n["Show the object properties dialog"],
    				       config.btnList["insertobject"][1]
    				        ]
    				);
    				
    				
			}
			break;
		    case "a":
			link = target;
			elmenus.push(null,
				     [ i18n["Modify Link"],
				       function() { editor.execCommand("createlink", true); },
				       i18n["Current URL is"] + ': ' + link.href,
				       config.btnList["createlink"][1] ],

				     [ i18n["Check Link"],
				       function() { window.open(link.href); },
				       i18n["Opens this link in a new window"] ],

				     [ i18n["Remove Link"],
				       function() {
					       if (confirm(i18n["Please confirm that you want to unlink this element."] + "\n" +
							   i18n["Link points to:"] + " " + link.href)) {
						       while (link.firstChild)
							       link.parentNode.insertBefore(link.firstChild, link);
						       link.parentNode.removeChild(link);
					       }
				       },
				       i18n["Unlink the current element"] ]
				);
			break;
		    case "td":
			td = target;
			if (!tbo) break;
			elmenus.push(null,
				     [ i18n["Cell Properties"],
				       function() { tableOperation("TO-cell-prop"); },
				       i18n["Show the Table Cell Properties dialog"],
				       editor.imgURL("cell-prop.gif", "TableOperations") ]
				);
			elmenus2.push([ "Convert Td to Th",
				       function() { 
				            var el = currentTarget;
        				    var p = el.parentNode;
        				    var child = editor._doc.createElement("th");
        				    child.innerHTML = HTMLArea.getHTML( el, false, editor );
        				    p.replaceChild(child, el);
        					    editor.forceRedraw();
        					    editor.focusEditor();
        					    editor.updateToolbar();
        					     },
				       "Convert this cell into a table header" ]
				);
			break;
			case "th":
			td = target;
			if (!tbo) break;
			elmenus.push(null,
				     [ i18n["Cell Properties"],
				       function() { tableOperation("TO-TH-prop"); },
				       i18n["Show the Table Cell Properties dialog"],
				       editor.imgURL("cell-prop.gif", "TableOperations") ]
				);
			elmenus2.push([ "Convert Th to Td",
				       function() { 
				            var el = currentTarget;
        				    var p = el.parentNode;
        				    var child = editor._doc.createElement("td");
        				    child.innerHTML = HTMLArea.getHTML( el, false, editor );
        				    p.replaceChild(child, el);
        					    editor.forceRedraw();
        					    editor.focusEditor();
        					    editor.updateToolbar();
        					     },
				       "Convert this table header into a cell" ]
				);
			break;
		    case "tr":
			tr = target;
			if (!tbo) break;
			elmenus.push(null,
				     /*[ i18n["Row Properties"],
				       function() { tableOperation("TO-row-prop"); },
				       i18n["Show the Table Row Properties dialog"],
				       config.btnList["TO-row-prop"][1] ],*/

				     [ i18n["Insert Row Before"],
				       function() { tableOperation("TO-row-insert-above"); },
				       i18n["Insert a new row before the current one"],
				       editor.imgURL("row-insert-above.gif", "TableOperations") ],

				     [ i18n["Insert Row After"],
				       function() { tableOperation("TO-row-insert-under"); },
				       i18n["Insert a new row after the current one"],
				       editor.imgURL("row-insert-under.gif", "TableOperations") ],

				     [ i18n["Delete Row"],
				       function() { tableOperation("TO-row-delete"); },
				       i18n["Delete the current row"],
				       editor.imgURL("row-delete.gif", "TableOperations") ]
				);
			break;
		    case "table":
			table = target;
			if (!tbo) break;
			elmenus.push(null,
				     [ i18n["Table Properties"],
				       function() { tableOperation("TO-table-prop"); },
				       i18n["Show the Table Properties dialog"],
				       editor.imgURL("table-prop.gif", "TableOperations") ],

				     [ i18n["Insert Column Before"],
				       function() { tableOperation("TO-col-insert-before"); },
				       i18n["Insert a new column before the current one"],
				       editor.imgURL("col-insert-before.gif", "TableOperations") ],

				     [ i18n["Insert Column After"],
				       function() { tableOperation("TO-col-insert-after"); },
				       i18n["Insert a new column after the current one"],
				       editor.imgURL("col-insert-after.gif", "TableOperations") ],

				     [ i18n["Delete Column"],
				       function() { tableOperation("TO-col-delete"); },
				       i18n["Delete the current column"],
				       editor.imgURL("col-delete.gif", "TableOperations") ]
				);
			break;
		    case "body":
			/*elmenus.push(null,
				     [ i18n["Justify Left"],
				       function() { editor.execCommand("justifyleft"); }, null,
				       config.btnList["justifyleft"][1] ],
				     [ i18n["Justify Center"],
				       function() { editor.execCommand("justifycenter"); }, null,
				       config.btnList["justifycenter"][1] ],
				     [ i18n["Justify Right"],
				       function() { editor.execCommand("justifyright"); }, null,
				       config.btnList["justifyright"][1] ],
				     [ i18n["Justify Full"],
				       function() { editor.execCommand("justifyfull"); }, null,
				       config.btnList["justifyfull"][1] ]
				);*/
			break;
		}
	}

	if (selection && !link)
		menu.push(null, [ i18n["Make link"],
				  function() { editor.execCommand("createlink", true); },
				  i18n["Create a link"],
				  config.btnList["createlink"][1] ]);

	for (var i in elmenus)
		menu.push(elmenus[i]);
    for (var i in elmenus2)
		menu.push(elmenus2[i]);
		
	//var tag = currentTarget.tagName.toLowerCase();
	// tag[] = target, tagname, fancyname
	var tag = currentTarget.tagName.toLowerCase();
	var fancyTag = null;
		
	if ( tag != 'html' && tag != 'body' )
    {
        //fancyTag = '';
        
        var atts = '';
        var parList = null;
        showtag = true;
        showedit = true;
        isCustomTag = false;
        parList = null;
        switch ( tag )
        {
            case 'p':
                tag = 'Paragraph';
                if ( currentTarget.className != '' )
                    atts += 'class|'+currentTarget.className+'|';
                break;
            case 'b': tag = 'Strong'; break;
            case 'i': case 'em': tag = 'Emphasize'; break;
            case 'pre':
                tag = 'Literal';
                if ( currentTarget.className != '' )
                    atts += 'class|'+currentTarget.className+'|';
                break;
            case 'a':
                showedit = false;
                showtag = false;
                break;
            case 'ul':
                fancyTag = 'Bulleted List';
                if ( currentTarget.className != '' )
                    atts += 'class|'+currentTarget.className+'|';
                break;
            case 'ol':
                fancyTag = 'Ordered List';
                if ( currentTarget.className != '' )
                    atts += 'class|'+currentTarget.className+'|';
                break;
            case 'li':
                fancyTag = 'List Item';
                if ( currentTarget.className != '' )
                    atts += 'class|'+currentTarget.className+'|';
                parList = currentTarget.parentNode;
                var parListTag = parList.tagName.toLowerCase();
                var parListFancy = ( parListTag == 'ul' ) ? 'Bulleted List' : 'Ordered List';
                var parListAtts = ( parList.className != '' ) ? 'class|'+parList.className+'|' : '';
                break;
            case 'h1': case 'h2': case 'h3': case 'h4': case 'h5': case 'h6':
                if ( currentTarget.className != '' )
                    atts += 'class|'+currentTarget.className+'|';
                if ( currentTarget.lang != '' )
                    atts += 'anchor_name|'+currentTarget.lang+'|';
                tag = 'Header';
                break;
            case 'sub': fancyTag = 'Subscript'; isCustomTag = true; break;
            case 'sup': fancyTag = 'Superscript'; isCustomTag = true; break;
            case 'strike': fancyTag = 'Strikethrough'; isCustomTag = true; break;
            case 'u': tag = 'Underline'; isCustomTag = true; break;
            case 'span':
                if ( currentTarget.id.indexOf('custom_') == 0 )
                {
                    tag = currentTarget.id.substring(7);
                    isCustomTag = true;
                }
                else if ( currentTarget.style.fontStyle.indexOf('italic') != -1 )
                {
                    tag = 'Emphasize';
                }
                else if ( currentTarget.style.fontWeight != '' )
                {
                    tag = 'Strong';
                }
                else if ( currentTarget.style.textDecoration.indexOf('line-through') != -1 )
                {
                    tag = 'Strike';
                    isCustomTag = true;
                }
                else if ( currentTarget.style.textDecoration.indexOf('underline') != -1 )
                {
                    tag = 'Underline';
                    isCustomTag = true;
                }
                else
                {
                    showedit = false;
                    showtag = false;
                }
                break;
            default:
                if ( currentTarget.className == 'anchor' )
                {
                    tag = 'Anchor';
                    showedit = false;
                }
                else if ( currentTarget.className == 'object' )
                {
                    tag = 'Object';
                    showedit = false;
                    
                }
                else if ( currentTarget.id.indexOf('custom_') == 0 )
                {
                    tag = currentTarget.id.substring(7);
                    isCustomTag = true;
                }
                else
                {
                    showedit = false;
                    showtag = false;
                }
                break;
        }
        
        if ( isCustomTag )
                fancyTag = tagNames[tag.toLowerCase()];
        if ( fancyTag == null )
             fancyTag = tag;
        tag = tag.toLowerCase();

        if ( isCustomTag )
        {
            if ( currentTarget.language != undefined )
                atts = currentTarget.language;
            else if ( currentTarget.lang != undefined )
                atts = currentTarget.lang;
        }
        else if ( tag == 'strong' || tag == 'emphasize' )
        {
            if ( currentTarget.className != '' )
                atts += 'class|'+currentTarget.className+'|';
        }
        
        if (showedit || showtag )
            menu.push(null);
        
        
        if ( showedit )
        {
            if ( parList != null )
            {
                menu.push(
        		  [ parListFancy + " properties...",
        		    function()
        		    {
        			    editor._popupDialog("xmlarea:/" + _editor_indexfile + "/xmlarea/tag/" + parListTag + "/" + parListFancy + "/" + parListAtts,
        			    function(param)
        			    {
                    		if (!param)
                    		{	// user must have pressed Cancel
                    			return false;
                    	    }
                    	    
                    	    for ( i in param['atts'] )
                    	    {
                    	        if ( param['atts'][i][0] == 'class' )
                    	            parList.className = param['atts'][i][1];
                    	    }
                    		
                    		//alert(param['class']+'-'+param['custom']);
		
		                },
		                outparam, 'yes');
		            },
        		    null ]
        		);
        	}
        	
            var outparam = null;
            menu.push(
        		  [ fancyTag + " properties...",
        		    function()
        		    {
        			    editor._popupDialog("xmlarea:/" + _editor_indexfile + "/xmlarea/tag/" + tag + "/" + fancyTag + "/" + atts,
        			    function(param)
        			    {
                    		if (!param)
                    		{	// user must have pressed Cancel
                    			return false;
                    		}
                    		
                    	    for ( i in param['atts'] )
                    	    {
                    	        if ( param['atts'][i][0] == 'class' )
                    	        {
                    	            currentTarget.className = param['atts'][i][1];
                    	        }
                    	        else if ( !isCustomTag )
                    	        {
                    	            if ( param['atts'][i][0] == 'anchor_name' )
                    	            {
                        	            if ( tag == 'header' )
                        	                currentTarget.lang = param['atts'][i][1];
                        	        }
                        	    }
                    	        
                    	    }
                    	    if ( isCustomTag && param['custom'] )
                    	    {
                    	        if ( currentTarget.language != undefined )
                    	            currentTarget.language = param['custom'];
                    	        else if ( currentTarget.lang != undefined )
                    	            currentTarget.lang = param['custom'];
                    	    }
                    		
                    		//alert(param['class']+'-'+param['custom']);
		
    		            },
    		            outparam, 'yes');
    	            },
        		    null ]
            );
        }
        
        if ( showtag )
        {
            if ( fancyTag == null )
                    fancyTag = tag;
            menu.push(//null,
        		  [ "Remove " + fancyTag,
        		    function() {
        			    if (confirm(i18n["Please confirm that you want to remove this element:"] + " " + fancyTag)) {
        				    var el = currentTarget;
        				    var p = el.parentNode;
        				    p.removeChild(el);
        				    if (HTMLArea.is_gecko) {
        					    if (p.tagName.toLowerCase() == "td" && !p.hasChildNodes())
        						    p.appendChild(editor._doc.createElement("br"));
        					    editor.forceRedraw();
        					    editor.focusEditor();
        					    editor.updateToolbar();
        					    if (table) {
        						    var save_collapse = table.style.borderCollapse;
        						    table.style.borderCollapse = "collapse";
        						    table.style.borderCollapse = "separate";
        						    table.style.borderCollapse = save_collapse;
        					    }
        				    }
        			    }
        		    },
        		    i18n["Remove this node from the document"] ]);
        }
    }
	return menu;
};

ContextMenu.prototype.popupMenu = function(ev) {
	var self = this;
	var i18n = ContextMenu.I18N;
	if (this.currentMenu)
		this.currentMenu.parentNode.removeChild(this.currentMenu);
	function getPos(el) {
		var r = { x: el.offsetLeft, y: el.offsetTop };
		if (el.offsetParent) {
			var tmp = getPos(el.offsetParent);
			r.x += tmp.x;
			r.y += tmp.y;
		}
		return r;
	};
	function documentClick(ev) {
		ev || (ev = window.event);
		if (!self.currentMenu) {
			alert(i18n["How did you get here? (Please report!)"]);
			return false;
		}
		var el = HTMLArea.is_ie ? ev.srcElement : ev.target;
		for (; el != null && el != self.currentMenu; el = el.parentNode);
		if (el == null)
			self.closeMenu();
		//HTMLArea._stopEvent(ev);
		//return false;
	};
	var keys = [];
	function keyPress(ev) {
		ev || (ev = window.event);
		HTMLArea._stopEvent(ev);
		if (ev.keyCode == 27) {
			self.closeMenu();
			return false;
		}
		var key = String.fromCharCode(HTMLArea.is_ie ? ev.keyCode : ev.charCode).toLowerCase();
		for (var i = keys.length; --i >= 0;) {
			var k = keys[i];
			if (k[0].toLowerCase() == key)
				k[1].__msh.activate();
		}
	};
	self.closeMenu = function() {
		self.currentMenu.parentNode.removeChild(self.currentMenu);
		self.currentMenu = null;
		HTMLArea._removeEvent(document, "mousedown", documentClick);
		HTMLArea._removeEvent(self.editordoc, "mousedown", documentClick);
		if (keys.length > 0)
			HTMLArea._removeEvent(self.editordoc, "keypress", keyPress);
		if (HTMLArea.is_ie)
			self.iePopup.hide();
	};
	
	if ( _editor_context )
	{
    	var target = HTMLArea.is_ie ? ev.srcElement : ev.target;
    	var ifpos = getPos(self.editor._iframe);
    	var x = ev.clientX + ifpos.x;
    	var y = ev.clientY + ifpos.y;
    
    	var div;
    	var doc;
    	if (!HTMLArea.is_ie) {
    		doc = document;
    	} else {
    		// IE stinks
    		var popup = this.iePopup = window.createPopup();
    		doc = popup.document;
    		doc.open();
    		doc.write("<html><head><style type='text/css'>@import url(" + _editor_url + "plugins/ContextMenu/menu.css); html, body { padding: 0px; margin: 0px; overflow: hidden; border: 0px; }</style></head><body unselectable='yes'></body></html>");
    		doc.close();
    	}
    	div = doc.createElement("div");
    	if (HTMLArea.is_ie)
    		div.unselectable = "on";
    	div.oncontextmenu = function() { return false; };
    	div.className = "htmlarea-context-menu";
    	if (!HTMLArea.is_ie)
    		div.style.left = div.style.top = "0px";
    	doc.body.appendChild(div);
    
    	var table = doc.createElement("table");
    	div.appendChild(table);
    	table.cellSpacing = 0;
    	table.cellPadding = 0;
    	var parent = doc.createElement("tbody");
    	table.appendChild(parent);
    
    	var options = this.getContextMenu(target);
    	for (var i = 0; i < options.length; ++i) {
    		var option = options[i];
    		var item = doc.createElement("tr");
    		parent.appendChild(item);
    		if (HTMLArea.is_ie)
    			item.unselectable = "on";
    		else item.onmousedown = function(ev) {
    			HTMLArea._stopEvent(ev);
    			return false;
    		};
    		if (!option) {
    			item.className = "separator";
    			var td = doc.createElement("td");
    			td.className = "icon";
    			var IE_IS_A_FUCKING_SHIT = '>';
    			if (HTMLArea.is_ie) {
    				td.unselectable = "on";
    				IE_IS_A_FUCKING_SHIT = " unselectable='on' style='height=1px'>&nbsp;";
    			}
    			td.innerHTML = "<div" + IE_IS_A_FUCKING_SHIT + "</div>";
    			var td1 = td.cloneNode(true);
    			td1.className = "label";
    			item.appendChild(td);
    			item.appendChild(td1);
    		} else {
    			var label = option[0];
    			item.className = "item";
    			item.__msh = {
    				item: item,
    				label: label,
    				action: option[1],
    				tooltip: option[2] || null,
    				icon: option[3] || null,
    				activate: function() {
    					self.closeMenu();
    					self.editor.focusEditor();
    					this.action();
    				}
    			};
    			label = label.replace(/_([a-zA-Z0-9])/, "<u>$1</u>");
    			if (label != option[0])
    				keys.push([ RegExp.$1, item ]);
    			label = label.replace(/__/, "_");
    			var td1 = doc.createElement("td");
    			if (HTMLArea.is_ie)
    				td1.unselectable = "on";
    			item.appendChild(td1);
    			td1.className = "icon";
    			if (item.__msh.icon)
    				td1.innerHTML = "<img align='middle' src='" + item.__msh.icon + "' />";
    			var td2 = doc.createElement("td");
    			if (HTMLArea.is_ie)
    				td2.unselectable = "on";
    			item.appendChild(td2);
    			td2.className = "label";
    			td2.innerHTML = label;
    			item.onmouseover = function() {
    				this.className += " hover";
    				//self.editor._statusBarTree.innerHTML = this.__msh.tooltip || '&nbsp;';
    			};
    			item.onmouseout = function() { this.className = "item"; };
    			item.oncontextmenu = function(ev) {
    				this.__msh.activate();
    				if (!HTMLArea.is_ie)
    					HTMLArea._stopEvent(ev);
    				return false;
    			};
    			item.onmouseup = function(ev) {
    				var timeStamp = (new Date()).getTime();
    				if (timeStamp - self.timeStamp > 500)
    					this.__msh.activate();
    				if (!HTMLArea.is_ie)
    					HTMLArea._stopEvent(ev);
    				return false;
    			};
    			//if (typeof option[2] == "string")
    			//item.title = option[2];
    		}
    	}
    
    	if (!HTMLArea.is_ie) {
    		var dx = x + div.offsetWidth - window.innerWidth + 4;
    		var dy = y + div.offsetHeight - window.innerHeight + 4;
    		if (dx > 0) x -= dx;
    		if (dy > 0) y -= dy;
    		div.style.left = x + "px";
    		div.style.top = y + "px";
    	} else {
    		// determine the size (did I mention that IE stinks?)
    		var foobar = document.createElement("div");
    		foobar.className = "htmlarea-context-menu";
    		foobar.innerHTML = div.innerHTML;
    		document.body.appendChild(foobar);
    		var w = foobar.offsetWidth;
    		var h = foobar.offsetHeight;
    		document.body.removeChild(foobar);
    		this.iePopup.show(ev.screenX, ev.screenY, w, h);
    	}
    
    	this.currentMenu = div;
    	this.timeStamp = (new Date()).getTime();
    
    	HTMLArea._addEvent(document, "mousedown", documentClick);
    	HTMLArea._addEvent(this.editordoc, "mousedown", documentClick);
    	if (keys.length > 0)
    		HTMLArea._addEvent(this.editordoc, "keypress", keyPress);
    
    	HTMLArea._stopEvent(ev);
    	return false;
    }
        
};
