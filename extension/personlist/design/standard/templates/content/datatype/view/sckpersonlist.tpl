{section name=Person loop=$attribute.content.person_list sequence=array(bglight,bgdark) }
 <a href="mailto:{$Person:item.email|wash(xhtml)}">{$Person:item.name|wash(xhtml)} {$Person:item.firstname|wash(xhtml)}</a>

{delimiter},
{/delimiter}
{/section}