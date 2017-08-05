<pre{section show=ne($classification|trim,'')} {section show=is_set( $title )}title="{$title|wash}" {/section}class="{$classification|wash}"{/section}>{$content|wash(xhtml)}</pre>
