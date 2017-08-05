{set-block scope=root variable=subject}{$object.content_class.name}: {$object.name}{/set-block}
This is a system generated message to inform you that
{$object.content_class.name}: {$object.name} has been published/updated.

You can access this item at

http://{ezini("SiteSettings","SiteURL")}{$object.main_node.url_alias|ezurl(no)}
{*Please customise the template by means of an override or inline editing of this template.*}
{*$object|attribute(show)*}