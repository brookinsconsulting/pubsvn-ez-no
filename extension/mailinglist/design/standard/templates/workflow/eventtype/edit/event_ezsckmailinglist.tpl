<div class="element">
<label>Select Node Type:</label><br />
{let node_type=$event.selected_nodetype}
<input type="radio" name="WorkflowEvent_event_ezsckmailinglist_nodetype_{$event.id}" value="parent" {section show=$node_type|eq("parent")}checked="checked"{/section} /> Parent Node<br />
<input type="radio" name="WorkflowEvent_event_ezsckmailinglist_nodetype_{$event.id}" value="current" {section show=$node_type|eq("current")}checked="checked"{/section} /> Current Node
{/let}
</div>
<div class="element">
{let new=$event.new}
	<label>Send e-mail in case of:</label><br/>
	<input type="checkbox" name="WorkflowEvent_event_ezsckmailinglist_new_{$event.id}" {section show=$new|eq(1)}checked="checked"{/section} />New Object<br />
{/let}
{let update=$event.update}
	<input type="checkbox" name="WorkflowEvent_event_ezsckmailinglist_update_{$event.id}" {section show=$update|eq(1)}checked="checked"{/section} />Update of an Object<br />
{/let}
</div>