{let class_content=$attribute.class_content}

{section show=$class_content.help_text|ne("")}
    <fieldset class="small">
        <legend>Help text</legend>
        <p>{$class_content.help_text|wash|nl2br}</p>
    </fieldset>
    <br />
{/section}

<input class="box" type="text" size="70" name="ContentObjectAttribute_hmregexpline_data_text_{$attribute.id}" value="{$attribute.content|wash}" />

{/let}