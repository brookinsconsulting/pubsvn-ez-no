var buttons = [{section loop=$buttons } '{$:item}'{delimiter},{/delimiter}{/section} ];

var configs = [{section loop=$configs }{literal}{{/literal}
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
               
var tags = {literal}{{/literal}{section loop=$tags }
                    '{$:item.id}' : [ '{$:item.starttag}', '{$:item.endtag}', '{$:item.inline}', '{$:item.tag}' ]
                    {delimiter},{/delimiter}
           {/section}{literal}}{/literal};
           
