{section name=Relation loop=$attribute.content.relation_browse}
        {content_view_gui view=embed content_object=fetch(content,object,hash(object_id,$:item.contentobject_id,object_version,$:item.contentobject_version))}<br />
{section-else}
	{'There are no related objects.'|i18n( 'design/standard/content/datatype' )}
{/section}
