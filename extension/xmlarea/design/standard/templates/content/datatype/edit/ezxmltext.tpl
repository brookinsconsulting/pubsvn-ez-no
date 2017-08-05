{default input_handler=$attribute.content.input
         attribute_base='ContentObjectAttribute'
         rows=cond(lt($attribute.contentclass_attribute.data_int1,10), 10, $attribute.contentclass_attribute.data_int1) }

    {section show=ne(is_set($#xmlarea_loaded),true)}
    {set-block scope=global variable=xmlarea_loaded}1{/set-block}
    <script type="text/javascript">
    <!--
      _editor_url = {'/extension/xmlarea/design/standard/javascript/'|ezroot};
      _editor_lang = "en";
      _editor_indexfile = {''|ezurl};
      textareas = new Array();
      objectID = {$attribute.object.id};
      objectVer = '{$edit_version}';
      objectLang = '{$edit_lang}';
    -->
    </script>
      
    <script type="text/javascript" src={'javascript/htmlarea.js'|ezdesign}></script>
    <script type="text/javascript" src={'javascript/pagestyle.js'|ezdesign}></script>
    <script type="text/javascript" src={'javascript/initeditor.js'|ezdesign}></script>
    
    <script type="text/javascript">
    <!--
	  _editor_indexfile = formatIndexFile(_editor_indexfile);
      {let custom=xmlarea_custom_js() }
        var plugins = [{section loop=$custom.plugins } '{$:item}'{delimiter},{/delimiter}{/section} ];
        for (var i = 0; i < plugins.length; ++i)
        {ldelim}
            HTMLArea.loadPlugin(plugins[i]);
        {rdelim}
        
        var tools = [ [{section loop=$custom.buttons } '{$:item}'{delimiter},{/delimiter}{/section} ] ];

        var configs = [{section loop=$custom.configs }{literal}{{/literal}
                            id        : '{$:item.id}',
                            tooltip   : '{$:item.tooltip}',
                            image     : {"/extension/xmlarea/design/standard/javascript/"|ezroot}+'{$:item.image}',
                            textMode  : false,
                            action    : insertCustom,
                            context   : '*',
                            html      : '{$:item.html}',
                            tag       : '{$:item.tag}'
                            {literal}}{/literal}
                            {delimiter},{/delimiter}
                       {/section} ];
                       
        var tags = {literal}{{/literal}{section loop=$custom.tags }
                            '{$:item.id}' : [ '{$:item.starttag}', '{$:item.endtag}', '{$:item.inline}', '{$:item.tag}' ]
                            {delimiter},{/delimiter}
                   {/section}{literal}}{/literal};
        var tagNames = new Array();
        {section loop=$custom.tagNames }
            tagNames['{$:item.0}'] = '{$:item.1}';
        {/section}
      {/let}
      window.onload=function() {literal}{initEditor();};{/literal}
    -->
    </script>
    {/section}
  <textarea class="box" onblur="edit = jsrArr['{$attribute_base}_data_text_{$attribute.id}']; edit._blurEvent();" onfocus="edit = jsrArr['{$attribute_base}_data_text_{$attribute.id}']; edit.updateToolbar();"  id="{$attribute_base}_data_text_{$attribute.id}" name="{$attribute_base}_data_text_{$attribute.id}" cols="97" rows="{$rows}">{$input_handler.aliased_handler.input_xml}</textarea>
  <input type="hidden" name="{$attribute_base}_data_text_{$attribute.id}_xmlarea" value="false" />


<script type="text/javascript">
<!--
    ta = new Array( "{$attribute_base}_data_text_{$attribute.id}", "{$attribute.id}", "{$attribute_base}_data_text_{$attribute.id}_xmlarea", "{$input_handler.input_xml|xmlarea_escape}" );
    textareas = textareas.concat( Array( ta ) );
    var {$attribute_base}_data_text_{$attribute.id} = {$attribute.id};
-->
</script>

{/default}