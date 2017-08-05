{let content=$class_attribute.content}

<div class="block">

    <div class="element">
        <label>Regular expression:</label>
        <p>{$content.regexp|wash}</p>
    </div>
    
</div>
<div class="block">

    <div class="element">
        <label>Help text:</label>
        <p>{$content.help_text|wash|nl2br}</p>
    </div>
    
    <div class="element">
        <label>Object name pattern selection:</label>
        {section show=count($content.pattern_selection)|gt(0)}
            <p>Using subpatterns: {section var=selection loop=$content.pattern_selection}{$selection}{delimiter}, {/delimiter}{/section}
        {section-else}
            <p>No subpatterns selected. Using the complete expression.</p> 
        {/section}
    </div>
    
</div>

{/let}