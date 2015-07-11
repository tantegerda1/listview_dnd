***********************
Drag&Drop for list view
***********************
Enables drag&drop for records in backend list module (list view).

Provides the following functionalities :

- Automatically hides translated records if ``Localization view`` is disabled
- Disable drag&drop based on records type and TYPO3 standard ``move`` conditions
- Use of standard TYPO3 function for ``move`` action

.. contents::

=====
Setup
=====
1. Install and activate extension ``listview_dnd``
2. Set the table authorized for drag&drop

By default, drag&drop can't be used on any records.
You have to manually set the records tables in the page TSConfig to enable them to be moved with drag&drop::
    tx_listview_dnd.tables {
       10 = tx_myext_domain_model_myrecord
       20 = ...
    }


=======
Warning
=======
Moving records in TYPO3 is bugged with content records and nested records. This extension doesn't try to solve/avoid/work around those bugs.

You should not activate drag&drop for tables like ``tt_content``, ``sys_category``, or any content/nested records.


=========
Conflicts
=========
While this extension tries to be as less intrusive as possible, it can be incompatible with other list-view customizations.


===
FAQ
===

Why do I must manually enable each record type to use with drag&drop ? Why not enable all records automatically to use drag&drop ?
==================================================================================================================================
There are bugs in TYPO3 move actions for content records (e.g. tt_content), and also for nested records (e.g. categories).

Since those standard move actions are used in this extension, drag&drop can mess up your data for those records.

It is not recommended to activate drag&drop for content or nested records.

I can't see my translated records after installing this extension !
===================================================================
It makes no sense to drag&drop records with translated child records taking lot of screen space.

That's why this extension automatically hides translated records if ``Localization view`` is disabled in list view.

You still can see translated records by simply enabling the ``Localization view``. But in that case drag&drop is disabled.

I can't use drag&drop even if my configuration is correct !
===========================================================
Drag&drop is automatically disabled according to the default TYPO3 behavior when moving records:

- Records are displayed with sorting
- You don't have authorization to edit the records
- Search records is set with 1/2/3/4 level down

I can't no more use move up/down arrows when this extension is active !
=======================================================================
The up/down arrows are automatically hidden because they are useless when drag&drop is active.
