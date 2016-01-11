# PrestaShop 1.6 Community Theme

[![Join the chat at https://gitter.im/PrestaShop/community-theme-16](https://badges.gitter.im/PrestaShop/community-theme-16.svg)](https://gitter.im/PrestaShop/community-theme-16?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Github All Releases](https://img.shields.io/github/downloads/prestashop/community-theme-16/total.svg)]()
[![GitHub release](https://img.shields.io/github/release/prestashop/community-theme-16.svg)]()

## Disclaimer

THIS THEME IS MAINTAINED BY THE PRESTASHOP COMMUNITY, NOT BY PRESTASHOP SA.

## About

**Community theme** is a fork of the default PrestaShop 1.6 theme
[default-bootstrap](https://github.com/PrestaShop/PrestaShop/tree/1.6.1.x/themes/default-bootstrap)
taken from [1.6.1.x](https://github.com/PrestaShop/PrestaShop/tree/1.6.1.x/) branch.
The purpose of this theme is to provide a solid and flexible foundation for building new PrestaShop 1.6 themes.

The main features of this theme **will be** (currently in development):

- Removed unnecessary styles, functions, elements
- Updated libraries &#10004;
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

## Roadmap

Here is what is currently planned for this theme:

- Version 0.3.0
  * File formatting
  * Non-breaking removal of some styles
  * JS code formatting (commas, etc.)
  * Removal of uniform.js
  * Removal of dead code
- Version 0.4.0+
  * Refactoring of templates and styles
  * [TBD](https://en.wikipedia.org/wiki/To_be_announced)

## Libraries and dependencies

                        | default-bootstrap | community-theme-16
----------------------- | ----------------- | -------------
Bootstrap               | 3.0.0             | 3.3.6
Font Awesome            | 4.3.0             | 4.5.0
jquery.uniform.js       | 2.1.2             | 2.1.2
jquery.total-storage.js | 1.1.2             | 1.1.2

## Installing theme

If you would like **to install** this theme, you should download the latest, prepackaged `vx.x.x-community-theme-16.zip`
theme archive from [Releases](https://github.com/PrestaShop/community-theme-16/releases) tab. It contains compiled
`.css` files, full folder structure, `index.php` file in every folder. Unnecessary files are removed. Prepackaged theme
archive can be uploaded and installed via PrestaShop back-office. Files from `dev` branch are not packaged,
you must build a theme archive from them yourself.

## Developing theme

In this repository, files **are not ready** to be zipped and installed as theme.
Instead, a **build** process is used, which automatically builds `.css` files,
copies `index.php` files, creates required folder and does other things, so you don't have to do them manually.
In the end, **build** process outputs theme `.zip` file which can be installed normally.
It keeps the repository clean (we don't have to copy `index.php` 500 times or deal with messy compiled `.css`
commits).

If would like to be able to use this build process and preview the changes at the same time, we suggest doing this:

1. Create a dedicated development installation of PrestaShop
2. Clone the repository
3. Build theme `.zip` archive and install it via back-office.
4. Move repository files on top of PrestaShop installation files.
5. Change theme files, build theme, preview changes in browser
6. (Optional) Push changes to a forked repository and make a pull request.

**To build** this theme, two tools are required:

1. [Compass](http://compass-style.org/) tool.
2. [Node.js](https://nodejs.org/en/) & [npm](https://www.npmjs.com/).

We recommend that you install [Compass](http://compass-style.org/) via [rubygems](https://rubygems.org/) package
manager. This will give you the latest version of [Compass](http://compass-style.org/): `1.0.3`. Compass is
required to build `.css` files from `.scss` files.

[npm](https://www.npmjs.com/) package manager comes together with [Node.js](https://nodejs.org/en/).
You should install [Node.js](https://nodejs.org/en/) first and then do a
[self-update](http://blog.npmjs.org/post/85484771375/how-to-install-npm) of [npm](https://www.npmjs.com/):

``` bash
sudo npm install npm -g
```

This will give you the updated version of [npm](https://www.npmjs.com/), which is used to build this theme.

To verify that both tools are installed and have the correct versions, type the following in your terminal:

``` bash
compass -v  // Should output 1.0.3 or higher
npm -v      // Should output 3.5.2 or higher
```

Once these tools are available, navigate to your cloned repository and run `npm install` command:

``` bash
cd community-theme-16/
npm install
```

This will install Node.js modules (packages) from [npmjs.com](https://www.npmjs.com/) which are used in
`gulpfile.js` to build the theme.

After the modules are installed, you may then run the `build` command:

``` bash
gulp build
```

which will run the build steps defined in `gulpfile.js` and output theme `.zip` archive in root folder of the cloned
repository. This theme `.zip` archive can then be distributed and installed via PrestaShop back-office.

**P.S.** If you can't or won't install [Node.js](https://nodejs.org/en/) & [npm](https://www.npmjs.com/), you can
make do without them. You can always do the packaging steps manually. The only required tools is
[Compass](http://compass-style.org/), which you can use by itself to compile `.css` files. Just navigate to
theme folder and run `compass compile`.

### Gulp commands

Gulp `build` command is composed of several specific tasks (sub-commands), which you can run individually:

``` bash
gulp create-folders  // Creates empty theme folders like pdf/, pdf/lang/, which are not included repository
                     // but should be in theme archive

gulp compile-css     // Runs shell process 'compass compile'. Optional flag maybe passed: --force

gulp clean-up        // Removes files which we don't want to include in the archive, like cache files

gulp copy-index      // Copies index.php to all directories and subdirectories inside theme folder

gulp format-js       // Formats theme .js files using JavaScript style rules defined in .jscsrc using JSCS tool.

gulp create-zip      // Adds Config.xml and theme folder to .zip archive and outputs
                     // the file in root directory
```

## Contributing

Contributions are welcome! Your changes should be in agreement with the theme guidelines and goals described above.

If you want to make a pull request, we ask that you keep to the same contribution rules as described
in [PrestaShop/PrestaShop](https://github.com/PrestaShop/PrestaShop/blob/develop/CONTRIBUTING.md).

We would like to emphasize the commit message norm:
[How to write a commit message](http://doc.prestashop.com/display/PS16/How+to+write+a+commit+message).
Because this is a theme, you may omit the `type` in your commit message
or write your own, more descriptive type: e.g `SEO`, `JS`, etc.
