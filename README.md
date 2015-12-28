# PrestaShop 1.6 Community Theme

[![Join the chat at https://gitter.im/PrestaShop/community-theme-16](https://badges.gitter.im/PrestaShop/community-theme-16.svg)](https://gitter.im/PrestaShop/community-theme-16?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Github All Releases](https://img.shields.io/github/downloads/atom/atom/total.svg)]()
[![GitHub release](https://img.shields.io/github/release/qubyte/rubidium.svg)]()
[![GitHub commits](https://img.shields.io/github/commits-since/SubtitleEdit/subtitleedit/0.1.0.svg)]()

## Disclaimer

THIS THEME IS MAINTAINED BY THE PRESTASHOP COMMUNITY, NOT BY PRESTASHOP SA.

## About

**Community theme** is a fork of the default PrestaShop 1.6 theme [default-bootstrap](https://github.com/PrestaShop/PrestaShop/tree/1.6.1.x/themes/default-bootstrap)
taken from [1.6.1.x](https://github.com/PrestaShop/PrestaShop/tree/1.6.1.x/) branch.

The main features of this theme **will be** (currently in development):

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
- Bootstrap components should be used where it makes sense or where they fit semantically
- Bootstrap components should not be transformed into other, shop specific components, which deserve their own component.
E.g. `.product-list-item`.
- Elements should be marked up with microdata where matching objects and properties exist.
- Theme components and styles should be consolidated and reused.
- Libraries should be kept updated
- JavaScript files must be formatted to a standard.
- Overrides may be used or included to provide better support and development
- Changes may affect third party module template styles, but be easily fixable
- General compatibility should not be totally broken

## Installing

If you would like to install this theme, you should download the latest, prepackaged `vx.x.x-community-theme-16.zip`
theme archive from [Releases](https://github.com/PrestaShop/community-theme-16/releases) tab. It contains compiled
`.css` files, full folder structure, `index.php` file in every folder. Unnecessary files are removed.

If you would like to develop this theme, then you should download the latest repository files from `dev` branch.
To install these files as theme in PrestaShop, you must create a `.zip` archive with the following structure inside:

```
community-theme.zip
  themes/
     community-theme-16/
        ...
  Config.xml
```

You may then install this theme via PrestaShop back-office: `Preferences > Themes > Add new theme`.

Let's not forget that this repository doesn't contain compiled `.css` files, you have to compile them
on your system for development. You may compile them before creating the `.zip` or after installing theme. To compile
`.scss` files to `.css` you must have [compass](http://compass-style.org/) tool available on your system.
The recommended version is `1.0.3`, you can check it by typing:

``` bash
compass -v
```

We recommend installing `compass` via [rubygems](https://rubygems.org/) package manager. This will give you the latest `1.0.3` version of
`compass` tool. Once installed, navigate to the theme folder:

``` bash
cd themes/community-theme-16/
```

Then execute the `compile` command:

``` bash
compass compile
```

If everything runs well, corresponding `.css` files will be created in `community-theme/css/` folder.

## Contributing

Contributions are welcome! Your changes should be in agreement with the theme guidelines and goals described above.

If you want to make a pull request, we ask that you keep to the same contribution rules as described
in [PrestaShop/PrestaShop](https://github.com/PrestaShop/PrestaShop/blob/develop/CONTRIBUTING.md).

We would like to emphasize the commit message norm: [How to write a commit message
](http://doc.prestashop.com/display/PS16/How+to+write+a+commit+message).
Because this is a theme, you may omit the `type` in your commit message
or write your own, more descriptive type: e.g `SEO`, `JS`, etc.
