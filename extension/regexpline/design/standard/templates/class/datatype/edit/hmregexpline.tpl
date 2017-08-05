{let content=$class_attribute.content}

<div class="block">
    <label>Regular expression (Perl-compatible):</label>
    <input type="text" name="ContentClass_hmregexpline_regexp_{$class_attribute.id}" value="{$content.regexp|wash}" size="100" /><br />
    <span class="small">To allow all input: /.*/</span>
</div>

<div class="block">
    <div class="element">
        <label>Help text for users:</label>
        <textarea name="ContentClass_hmregexpline_helptext_{$class_attribute.id}" rows="5" cols="80">{$content.help_text|wash}</textarea>
    </div>
    
    <div class="element">
        <label>Object name pattern selection:</label>
        {section show=$content.subpattern_count|gt(0)}
            <select name="ContentClass_hmregexpline_patternselect_{$class_attribute.id}[]" multiple="multiple">
            {section var=sub loop=$content.subpattern_count}
                <option value="{$sub}" {section show=$content.pattern_selection|contains($sub)}selected="selected"{/section}>{$sub}</option>
            {/section}
            </select>
        {section-else}
            <i>No subpatterns defined. Using the complete expression.</i>
        {/section}
    </div>
</div>

{/let}