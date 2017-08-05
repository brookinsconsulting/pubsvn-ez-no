var editor = null;
var textareas = new Array();
var editors = new Array();
var toolbars = new Array();
//var flags = new Array();
var jsrArr = new Array();
var jsrCount;
var config = null;
var _editor_context = true;

function formatIndexFile(url)
{
	return ( url[url.length-1] != '/' ) ? url + '/' : url;
}

function insertCustom(editor, id)
{
    
    if ( tags[id][0] != 'div' && tags[id][0] != 'span' )
    {
        var obj = null;
        var n = editor.getParentElement();
        while (n && (n.nodeType == 1) && (n.tagName.toLowerCase() != 'body') && obj == null) {
        	if ( ( n.tagName.toLowerCase() == tags[id][0] ) )
        	{
        		obj = n;
        		var par = obj.parentNode;
        	}
        	n = n.parentNode;
        }
        if ( tags[id][1] != '' )
        {
            if ( obj != null )
        	{
        	    p = ( tags[id][2] ) ? editor._doc.createElement( 'span' ) : editor._doc.createElement( 'p' );
        	    html = obj.innerHTML;
        	    if ( HTMLArea.is_ie )
        	        html = html.replace(/<([^>]*)>/g, '' ) ;
        	    p.innerHTML = html;
        	    par.replaceChild( p, obj );
        	}
            else
            {
                    editor.surroundHTML( '<'+tags[id][0]+' id="custom_'+tags[id][3]+'">', '</'+tags[id][1]+'>' );
            }
        }
        else
        {
            if ( obj != null )
        	{
        	    par.removeChild( obj );
        	}
            else
            {
                editor.insertHTML( '<'+tags[id][0]+' id="custom_'+tags[id][3]+'"/>' );
            }
        }
    }
    else
    {
        //var tagName = ( tags[id][2] ) ? 'span' : 'div';
        var obj = null;
        var n = editor.getParentElement();
        while (n && (n.nodeType == 1) && (n.tagName.toLowerCase() != 'body') && obj == null) {
        	if ( ( n.tagName.toLowerCase() == tags[id][0] && n.id == tags[id][3] ) )
        	{
        		obj = n;
        		var par = obj.parentNode;
        	}
        	n = n.parentNode;
        }
        if ( obj != null )
        {
        	p = ( tags[id][2] == 'span' ) ? document.createElement( 'span' ) : document.createElement( 'p' );
        	html = obj.innerHTML;
        	if ( HTMLArea.is_ie )
        	    html = html.replace(/<([^>]*)>/g, '' ) ;
        	p.innerHTML = html;
        	par.replaceChild( p, obj );
        }
        else
        {
                editor.surroundHTML( '<'+tags[id][0]+' id="custom_'+tags[id][3]+'">', '</'+tags[id][0]+'>' );
               
        }
        
        
    }
        
        
}

function insertAnchor(editor, id)
{
    var outparam = null;
	//alert (editor.getSelectedHTML());
	
	//image = editor.getParentElement();
	
	var obj = null;
	var p = editor.getParentElement();
	var parent = p;
	//var a = [];
	while (p && (p.nodeType == 1) && (p.tagName.toLowerCase() != 'body') && obj == null) {
		if ( ( p.tagName.toLowerCase() == 'img' && p.className == 'anchor' ) )
		{
		    obj = p;
		    par = obj.parentNode;
		}
		p = p.parentNode;
	}
	
	extra = '';
	if (obj != null)
	{
	  outparam = {
		f_name     : obj.alt
	  }
	}
	else if (editor.hasSelectedText())
	{ 
	    return;
	}
	
	editor._popupDialog("anchor.html", function(param) {
		if (!param)
			return false;
		html = '<img src="'+_editor_url+'images/ed_anchor.gif" class="anchor" title="anchor - #'+param.f_name+'" alt="'+param.f_name+'" />';

        if (!obj)
		{
		    
			var sel = editor._getSelection();
			var range = editor._createRange(sel);
			editor.insertHTML( html );
			
		}
        else
        {
            if ( HTMLArea.is_ie )
            {
                var sel = editor._getSelection();
			    var range = editor._createRange(sel);
                par.removeChild( obj );                
                editor.insertHTML( html );
            }
            else
            {
                tmp = document.createElement('span');
    		    tmp.innerHTML = html;
    	        par.replaceChild( tmp, obj );
    		}
    	}  }, outparam);		
}
    
function insertObject(editor, id)
{
	var outparam = null;
	
	var obj = null;
	var p = editor.getParentElement();
	var parent = p;
	//var a = [];
	while (p && (p.nodeType == 1) && (p.tagName.toLowerCase() != 'body') && obj == null) {
		if ( ( p.tagName.toLowerCase() == 'img' && p.className == 'object') )
		{
		    obj = p;
		    par = obj.parentNode;
		}
		p = p.parentNode;
	}
	
	extra = '';
	if (obj != null)
	{
	  //outparam = {
		//f_id     : obj.id
	  //}
	  
	  if (obj.id != null)
	    extra += 'id|'+obj.id+'|';
	  if (obj.align != null)
	    extra += 'align|'+obj.align+'|';
	  	  
	  var atts = obj.attributes;
	  
	  if (obj.alt != null)
	  {
	    extra += escape( obj.alt );
        extra = extra.replace( /\//g, '{)!(}' );
      }
	}
	else if (editor.hasSelectedText())
	{ 
	    return;
	}
	

	editor._popupDialog("xmlarea:/" + _editor_indexfile + "layout/set/xmlarea/xmlarea/object/" + objectID + "/" + objectVer + "/" + objectLang + "/" + extra, function(param) {
		if (!param) {	// user must have pressed Cancel
			return false;
		}
		var img = obj;
		
		if (!obj)
		{
		    
			var sel = editor._getSelection();
			var range = editor._createRange(sel);
			editor.insertHTML( param['html'] );
			
		}
        else
        {
            if ( HTMLArea.is_ie )
            {
                var sel = editor._getSelection();
			    var range = editor._createRange(sel);
                par.removeChild( img );                
                editor.insertHTML( param['html'] );
            }
            else
            {
                tmp = document.createElement('p');
    		    tmp.innerHTML = param['html'];
    	        par.replaceChild( tmp, img );
    		}
    	}  }, outparam, "yes");
};

function toggleContext(editor, id)
{
    _editor_context = ( !_editor_context );
    editor.updateToolbar();
}

function editMode(editor, id)
{
    var xmlhttp=false;
	/*@cc_on @*/
    /*@if (@_jscript_version >= 5)
        // JScript gives us Conditional compilation, we can cope with old IE versions.
        // and security blocked creation of the objects.
         try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
         } catch (e) {
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
		}
         }
        @end @*/
    if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    jsrArr[editor._textArea.name] = editor;
    var mode = ( editor._editMode == 'textmode' ) ? 'output' : 'input';
    
    var str = 'att=' + editor._textArea.name + '&content=' + escape( editor.getHTML() );
    
    xmlhttp.open("POST", _editor_indexfile + "xmlarea/xmlhttp/"+mode, true);
	xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4)
        {
			editModeCallback(xmlhttp.responseText);
        }
    }
    xmlhttp.send(str);

}
    
function editModeCallback( returnstring )
{
    arr = returnstring.split('{)!(}');

    currentEditor = jsrArr[arr[2]];
    currentEditor.setMode();
    currentEditor.updateToolbar();
    currentEditor.setHTML( arr[0] );

    if ( arr[1] != '' )
        alert( arr[1] );
}

function generate(i)
{
    editors[textareas[i][0]] = editors.concat( HTMLArea.replace(textareas[i][0], config, textareas[i][3] ) );
	if ( i == textareas.length-1 )
	{
        var el, i, objs = document.getElementsByTagName('div');
        var j=0;
        for (i = objs.length; --i >= 0 && (el = objs[i]);)
        {
        	if ( el.className == 'xmltoolbar' )
        	{
        		toolbars[j] = el;
				if ( HTMLArea.is_ie )
					el.style.pixelTop = document.documentElement.scrollTop;
        		j++;
        	}
        }
		
    }
}

function initEditor()
{
    config = new HTMLArea.Config();
    config.registerButton({
      id        : "insertobject",
      tooltip   : "Insert/Modify Object",
      image     : _editor_url+"images/insert_object.gif",
      textMode  : false,
      action    : insertObject
    });
    config.registerButton({
      id        : "insertanchor",
      tooltip   : "Insert Anchor",
      image     : _editor_url+"images/ed_anchor.gif",
      textMode  : false,
      action    : insertAnchor
    });
    config.registerButton({
      id        : "editmode",
      tooltip   : "Toggle Edit mode",
      image     : _editor_url+"images/ed_html.gif",
      textMode  : true,
      action    : editMode
    });
    config.registerButton({
      id        : "listoutdent",
      tooltip   : "Decrease list indent",
      image     : _editor_url+"images/ed_indent_less.gif",
      textMode  : false,
      action    : function(e, id) {e.execCommand("outdent");},
      context   : "li"
    });
    config.registerButton({
      id        : "listindent",
      tooltip   : "Increase list indent",
      image     : _editor_url+"images/ed_indent_more.gif",
      textMode  : false,
      action    : function(e, id) {e.execCommand("indent");},
      context   : "li"
    });
    config.registerButton({
      id        : "contexttoggle",
      tooltip   : "Toggle Context menu",
      image     : _editor_url+"images/ed_context.gif",
      textMode  : false,
      action    : toggleContext
    });
        
    for ( i=0; i<configs.length; i++ )
    {
        config.registerButton( configs[i] );
    }
    for (var i = 0; i < plugins.length; ++i)
    {
        config.registerPlugin(plugins[i]);
    }
    
    config.pageStyle = pageStyle;
    config.toolbar = tools;
    config.height = "auto";
    config.width = "auto";
        
    for (var i = 0; i < textareas.length; ++i) {
        setTimeout( 'generate('+i+')', i*500 );
      /*for (j=0; j<document.forms.length; j++)
      {
        if ( eval( 'document.forms[j].' + textareas[i][2] + ' != "undefined"' ) )
            flags[textareas[i][0]] = eval( 'document.forms[j].' + textareas[i][2] );
      }*/
      
      if ( i >= 1 )
      {
        HTMLArea.plugins = {};
      }
    }
    return;

};


if ( HTMLArea.is_ie )
{
    window.onscroll = function()
    {
        for (var i = 0; i < toolbars.length; ++i)
        {
            toolbars[i].style.visibility = 'hidden';
            toolbars[i].style.pixelTop = document.documentElement.scrollTop;
        }
    }
}