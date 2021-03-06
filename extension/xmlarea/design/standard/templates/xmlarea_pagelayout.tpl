{* DO NOT EDIT THIS FILE! Use an override template instead. *}
{*?template charset=latin1?*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="no" lang="no">

<head>
    <link rel="stylesheet" type="text/css" href={"/design/admin/stylesheets/core.css"|ezroot} />
    <link rel="stylesheet" type="text/css" href={"/design/admin/stylesheets/site.css"|ezroot} />
    
    {literal}
    <style>
    
    div#leftmenu {width: 0px; visibility: hidden }
    div#maincontent {margin-left: 1em; margin-right: 1em; clear: both;}
    
    </style>
    {/literal}

<title>{$title}</title>
</head>

<body>

{* Browse mode... *}
{section show=eq( $ui_context, 'browse' )}
<div id="topmenu">
<div id="topmenu-design">
<ul>
    {* Content menu *}
    {section show=$browse.top_level_nodes|contains( ezini( 'NodeSettings', 'RootNode', 'content.ini' ) )}
    {include uri='design:page_menuheadenabled.tpl' menu_text='Content structure'|i18n( 'design/admin/pagelayout' ) menu_url=concat( '/content/browse/', ezini( 'NodeSettings', 'RootNode', 'content.ini' ) ) menu_item_order='first'}
    {section-else}
    {include uri='design:page_menuheadgray.tpl' menu_text='Content structure'|i18n( 'design/admin/pagelayout' ) menu_item_order='first'}
    {/section}

    {* Media menu *}
    {section show=$browse.top_level_nodes|contains( ezini( 'NodeSettings', 'MediaRootNode', 'content.ini' ) )}
    {include uri='design:page_menuheadenabled.tpl' menu_text='Media library'|i18n( 'design/admin/pagelayout' ) menu_url=concat( '/content/browse/', ezini('NodeSettings','MediaRootNode','content.ini' ) ) menu_item_order='middle'}
    {section-else}
    {include uri='design:page_menuheadgray.tpl' menu_text='Media library'|i18n( 'design/admin/pagelayout' ) menu_item_order='middle'}
    {/section}

    {* Users menu *}
    {section show=$browse.top_level_nodes|contains( ezini( 'NodeSettings', 'UserRootNode', 'content.ini' ) )}
    {include uri='design:page_menuheadenabled.tpl' menu_text='User accounts'|i18n( 'design/admin/pagelayout' ) menu_url=concat( '/content/browse/', ezini( 'NodeSettings', 'UserRootNode', 'content.ini' ) ) menu_item_order='middle'}
    {section-else}
    {include uri='design:page_menuheadgray.tpl' menu_text='User accounts'|i18n( 'design/admin/pagelayout' ) menu_item_order='middle'}
    {/section}
</ul>

{* NOT Browse mode... *}

</div></div>
<div id="maincontent"><div id="fix">
<div id="maincontent-design">
{/section}

{$module_result.content}

{section show=eq( $ui_context, 'browse' )}
</div></div></div>
{/section}

</body>
</html>
