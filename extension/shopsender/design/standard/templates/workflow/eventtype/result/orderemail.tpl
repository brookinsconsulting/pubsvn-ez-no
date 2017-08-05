{set-block scope=root variable=subject}{"Your itemlist of Order No."|i18n("design/standard/shop")} {$order.id}{/set-block}

{"Order"|i18n("design/standard/shop")}: {$order.id}

{"Customer"|i18n("design/standard/shop")}:

{shop_account_view_gui view=ascii order=$order}


{"Product items"|i18n("design/standard/shop")}

{section name=ProductItem loop=$order.product_items show=$order.product_items sequence=array(bglight,bgdark)}
{section show=$#ostruct[ids]|contains($ProductItem:item.item_object.contentobject_id)}
{$ProductItem:item.item_count}x {$ProductItem:item.object_name} {$ProductItem:item.price_inc_vat|l10n(currency)}: {$ProductItem:item.total_price_inc_vat|l10n(currency)}


{/section}

{/section}