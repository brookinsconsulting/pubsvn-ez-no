{let image_variation="false"
     attribute_parameters=$object_parameters}
{section show=is_set($attribute_parameters.size)}
{set image_variation=$object.data_map.image.content[$attribute_parameters.size]}
{section-else}
{set image_variation=$object.data_map.image.content[ezini( 'ImageSettings', 'DefaultEmbedAlias', 'content.ini' )]}
{/section}
<img src={$image_variation.full_path|ezroot} title="{$object.name|wash(xhtml)}" {$attributes} />
{/let}
