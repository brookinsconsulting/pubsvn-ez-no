{*?template charset=iso-8859-1?*}
{let home=ezini('Settings','Home','treemenu.ini.append')
     used_node=false()
     parent_obj=false()
     dynamic=ezini('Settings','Dynamic','treemenu.ini.append')
     highlight_used_node=ezini('Settings','HighlightUsedNode','treemenu.ini.append')
     with_children=ezini('Settings','WithChildren','treemenu.ini.append')
     hide_if_home_not_in_path=ezini('Settings','HideIfHomeNotInPath','treemenu.ini.append')
     fallback_if_used_node_without_children=ezini('Settings','FallbackIfUsedNodeWithoutChildren','treemenu.ini.append')
}
{* See if we have already a node id otherwise use the top category as current node *}
{section show=and(is_set($DesignKeys:used.node),ne($#dynamic,'enabled'))}
    {set used_node=$DesignKeys:used.node}
{section-else}
    {set used_node=$#home}
{/section}
{* Get a proper node object *}
{let node_obj=fetch(content,node,hash(node_id,$used_node))
     used_parent=fetch(content,node,hash(node_id,$node_obj.parent_node_id))
     fallback_obj=fetch(content,node,hash(node_id,$node_obj.parent.parent_node_id))

}
<link rel="stylesheet" type="text/css" href={"stylesheets/treemenu1.css"|ezdesign} /> 
<ul>
{set parent_obj=cond(and(eq($#fallback_if_used_node_without_children,'enabled'),$node_obj.children_count|eq(0)),$fallback_obj,$used_parent)}
{*PARENT LEVEL NODE *}
<li class="list1">
        <a class="path" href={$parent_obj.url_alias|ezurl}>{$parent_obj.name}</a>
<ul>
{section name=Firstlevel show=$parent_obj.children_count|gt(0) loop=fetch(content,list,hash(parent_node_id,$parent_obj.node_id,sort_by,$parent_obj.sort_array))}
    {section show=or(ne($#hide_if_home_not_in_path,'enabled'),$:item.path_array|contains($#home))}
    {* FIRST LEVEL*}    
        {section show=and(eq($Firstlevel:item.node_id,$used_node),eq($#highlight_used_node,'enabled'))}
        <li class="list2a">
        <a class="path" href={$Firstlevel:item.url_alias|ezurl}>{$Firstlevel:item.name}</a>
        <ul>
            {* SECOND LEVEL USED NODE *}
            {section show=$node_obj.path_array|contains($Firstlevel:item.node_id) loop=fetch(content,list,hash(parent_node_id,$Firstlevel:item.node_id,sort_by,$Firstlevel:item.sort_array))}
            <li class="list3">
                <a class="path" href={$:item.url_alias|ezurl}>{$:item.name}</a>
            </li>
            {/section}    
        </ul>
        </li>
        {section-else}
        <li class="list2">
        <a class="path" href={$Firstlevel:item.url_alias|ezurl}>{$Firstlevel:item.name}</a>
            {section show=or(eq($#used_parent.node_id,$Firstlevel:item.node_id),and(eq($#with_children,'enabled'),$Firstlevel:item.children_count|gt(0)))}
            <ul>
            {* SECOND LEVEL UNUSED NODE *}
                {section name=Childlevel loop=fetch(content,list,hash(parent_node_id,$Firstlevel:item.node_id,sort_by,$Firstlevel:item.sort_array))}
                    {section show=and(eq($Firstlevel:Childlevel:item.node_id,$used_node),eq($#highlight_used_node,'enabled'))}
                    <li class="list3a">
                    {section-else}
                        {section show=$Firstlevel:Childlevel:item.children_count|gt(0)}
                        <li class="list3withchildren">
                        {section-else}
                        <li class="list3">
                        {/section}
                    {/section}
                        <a class="path" href={$Firstlevel:Childlevel:item.url_alias|ezurl}>{$Firstlevel:Childlevel:item.name}</a>
                </li>
                {/section}  
            </ul>
            {/section}
        </li>
        {/section}
    {/section}
{/section}
</ul></li>
</ul>
{/let}
{/let}