Enhanced Object Relation
---------------------------

/*
    Enhanced Selection extension for eZ publish 3.x
    Copyright (C) 2004  Sydesy ltd

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/


1. Context
----------
We needed to build a 'survey like' object (with several questions either "check boxes" or "radio buttons"). Each
answer of each question has to be an independant object (as it contains a lot of extra informations beside its name). 
We needed to be able to retrieve all the objects linked to a specific answer (an independant object).

The existing objectrelation datatype has several limitations:
- that's always a single relation (no multiple choise)
- the layout is not what we wanted (list with check boxes and list with radio buttons)
- you can't easily retrieve all the objects that are related to a specific object (reverse related)


2. Features
-----------

We have created an enhancedobjectrelation : 
- that stores the object relations as it is implemented on ez, therefore keeping all the nice features ez provides
(eg list all the object related to aka reverse related),
- that is able to handle a one to one or one to many relationship (it allows multiple select),
- that let you define the target objects list based on their parent node.
- that provide two new interfaces two manage the relation: a list with radio button (single selection) 
  and a list with check boxes (multiple selection)
- you can select the potential related objects as 1) the children of a node 2) all the objects from a given class.

If you need to store relations between objects and have a nicer interface than the 'browse' default solution,
 this datatype might do it.


3. Example of use
-----------------

You want to create a directory of companies, with one of its attribute being the country it belongs to.

You create a company class and a country class.

To store the country, Instead of using the ezcountry datatype, you can simply create a country node (a folder),
with its children  being the countries (a new country class).
On the country class, You can have as many information as you want (its flag, a map, a description...) and you can
list all the companies that belong to this country (reverse related).

On the company class, you add an enhancedobjectrelation, with "default selection node"=the country node (the folder).
If a company can only belong to one country, choose "Selection method"="Dropdown list" or "list with radio button".
If a company can belong to several contries, choose "Selection method"="list with check box".

That's it. To alter the county list, simply create or delete objects under the country node.

4. Implementation and interraction with ez kernel
-------------------------------------------------

You need to modify the structure of one table (from the sql client type
"alter table ezcontentobject_link add contentclassattribute_id int(11) NULL default null;"

I have modified the existing table ezcontentobject_link to add a new column contentclassattribute_id in order
to be able to know if a relation between two objects is created by the standard relation system or by this datatype
and to be able to distinguish if you put two enhancedobjectrelation attributes into the same class.

This allows us to benefit directy of several interresting standard features (the most obvious is the reverse relation
list and be sure that all the relations are deleted when you delete the object).

However, without hacking the kernel, all the objects selected via a enhancedobjectrelation attributes are displayed 
on the related attributes. In our case, that's a feature but you might have to modify ezcontentobject.php 
to change the default behavior.
   

5. Known bugs and limitations
-----------------------------

When you edit an object, ez creates a new draft version of this object, but I couldn't find how to tell it to copy the
existing relations from the previous version to the new draft one. the cloneClassAttribute method is redefined on this attribute, but never called.

A temporary fix is to store the object version into the attribute. When reading it, if the object version and the version saved
on the attribute are different, it means than a new version is edited and we read the version n-1 relations instead of the 
current one (as it would return an empty array).

Moreover, the select query is called more than once when editing an object. Couldn't find a solution to avoid that.

When you edit an object with the regular admin interface, it see the objects related as regular related objects (so far, so good), but recreate them (with an attributeid = NULL when you edit the object.

A workaround is to modify the kernel so it only list the object with a null attribute ?

 
6. TO DO and possible evolutions
--------------------------------
Well, it does what we need so far, but if you have a nice idea we might implement it... and be more than happy to
add your patches ;). A nice new feature would be to be able to select the list of possible related object based on their class instead of only their 
parent node (that shouldn't be too complicated to do).

Do the pdf and info templates (I don't know how to test them).

Fix the bugs creeping here and there and proof read the doc and comments on the code.

I want to put that into the pubsvn, but don't know how to do it (read the doc might be a good start, but if someone can guide me,
that might be faster).

On the long run, I'd like to have this attribute as the default objectrelation one shipped with ez, as I think
that's a better implementation that the existing one and it offers more features.

7. Disclaimer & Copyright
-------------------------
/*
    Enhanced Object Relation for eZ publish 3.x
    Copyright (C) 2004  Sydesy ltd

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/
The operator is tailored to fit our needs, and is shared with the community as is.


8. A last trick
----------------

An template example to retrieve all the objects reverse related to an object (having a relation to it). Couldn't find
this on the doc and had to dig the code to find it.

{* Reverse relation *}
{let reverse_related=$node.object.current.reverse_related_object_list}
{$reverse_related|attribute(show,1)}

<ul>
{section name=ReverseObject loop=$reverse_related show=$reverse_related}
<li><a href={$ReverseObject:item.main_node.url_alias|ezurl}>{$ReverseObject:item.name}</a></li>
{/section}






Thanks for your attention

Xavier DUTOIT


