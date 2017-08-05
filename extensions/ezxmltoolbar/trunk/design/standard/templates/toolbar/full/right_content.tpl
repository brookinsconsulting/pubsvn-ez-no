
<div class="toolbar-item {$placement}">
    {section show=or($show_subtree|count_chars()|eq(0), $requested_uri_string|begins_with( $show_subtree ))|and($module_result.content_info)}
    {cache-block keys=$module_result.content_info.node_id}
    {let current_node=cond( $module_result.content_info,
                            fetch( content, node, hash( node_id, $module_result.content_info.node_id ) ),
                            false() )}
    {section show=and( is_set( $current_node.data_map.$attribute_identifier),$current_node.data_map.$attribute_identifier.content.is_empty|not()) }

    <div class="toollist">
        <div class="toollist-design">
        {*<h2>{$title}</h2>*}
        <div class="content-view-children">

        {attribute_view_gui attribute=$current_node.data_map.$attribute_identifier}
        </div>
        </div>
    </div>

    {/section}
    {/let}
    {/cache-block}
    {/section}
</div>
