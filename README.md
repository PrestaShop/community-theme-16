# PrestaShop 1.6 Community Theme

[![Join the chat at https://gitter.im/PrestaShop/community-theme-16](https://badges.gitter.im/PrestaShop/community-theme-16.svg)](https://gitter.im/PrestaShop/community-theme-16?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

## Disclaimer

THIS THEME IS MAINTAINED BY THE PRESTASHOP COMMUNITY, NOT BY PRESTASHOP SA.

## About

**Community theme** is a fork of the default PrestaShop 1.6 theme [default-bootstrap](https://github.com/PrestaShop/PrestaShop/tree/1.6.1.x/themes/default-bootstrap)
taken from [1.6.1.x](https://github.com/PrestaShop/PrestaShop/tree/1.6.1.x/) branch.

The main features of this theme are:

- Removed unnecessary styles, functions, elements
- Updated libraries
- Wider usage [Bootstrap 3](http://getbootstrap.com/) styles, utilities and components
- Reduced stylesheet size
- Simplified HTML markup
- Improved SEO markup and microdata
- Easier custom theme development

Bug fixes in the [default-bootstrap](https://github.com/PrestaShop/PrestaShop/tree/1.6.1.x/themes/default-bootstrap)
will be integrated to this theme regularly.

## Guidelines and goals

- Semantic HTML markup should be used where possible
- CSS styles must be kept to a minimum
- Bootstrap components should be used where it makes sense or where they fit semantically.
- Bootstrap components should not be transformed into other, shop specific components, which deserve their own component.
E.g. `.product-list-item`.
- Elements should be marked up with microdata where matching objects and properties exist.
- Theme components and styles should be consolidated and reused.
- Libraries be kept updated
- JavaScript files must be formatted to a standard.
- Overrides may be used or included to provide better support and development
- Changes may affect third party module template styles void, but be easily fixable
- General compatibility should not be totally broken

## Installing

To install or use this theme, you should first compile `.scss` files by using [compass](http://compass-style.org/).
`.css` files are purposely excluded from this repository, because they make pull requests too difficult to merge.
Repository packages with `.css` files may come in the future.

To compile `.scss` files, you must have [compass](http://compass-style.org/) tool available on your system.
The recommended version is `1.0.3`, you can check it by typing:

``` bash
compass -v
```

We recommend that you install `compass` via `rubygems` package manager. This will give you the `1.0.3` version of `compass` tool.

Once install, navigate to the theme folder

``` bash
cd community-theme/
```

Then, execute compile command:

``` bash
compass compile
```

If everything runs well, all `.css` files will be created in `community-theme/css/` folder.
You may then copy the theme your PrestaShop themes folder or zip the folder up and install the theme via admin interface.

## Contributing

Contributions are welcome! Your changes should be in agreement with the theme guidelines and goals described above.

If you want to make a pull request, we ask that you keep to the same contribution rules as described
in [PrestaShop/PrestaShop](https://github.com/PrestaShop/PrestaShop/blob/develop/CONTRIBUTING.md).

We would like to emphasize the commit message norm: [How to write a commit message
](http://doc.prestashop.com/display/PS16/How+to+write+a+commit+message).
Because this is a theme, you may omit the `type` in your commit message
or write your own, more descriptive type: e.g `SEO`, `JS`, etc.
