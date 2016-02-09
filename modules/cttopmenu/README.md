# Community Theme Top Menu

Adds a top menu to page header. This modules replaces `blocktopmenu`,
which cannot be themed because it generate HTML inside `.php` code.

This module looks to solve that by providing a menu tree link array to template,
where almost any kind of menu can be built.

## Features

- Types of menu links that can be entered:
  - custom link
  - product link
  - category link
  - category tree
  - cms link
  - cms category link
  - cms category tree
  - manufacturer link
  - manufacturer list
  - supplier link
  - supplier tree
- Menu items which are trees or lists have dropdowns
- Menu link name, url and title can be overridden
- Menu links can have icons
- Additional CSS classes can be added
- Option for `rel="nofollow"`
- Enable/disable menu item
- Has option for search form inside menu bar
- Has option for opening dropdown on hover (work in progress)
- No matter what is the type of entity, the menu link array has uniform properties
- Each menu link array item has an id and type, which can be used to create CSS classes
