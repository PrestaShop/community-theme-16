# PrestaShop 1.6 Community Theme

[![Join the chat at https://gitter.im/PrestaShop/community-theme-16](https://img.shields.io/gitter/room/PrestaShop/community-theme-16.svg?style=flat-square)](https://gitter.im/PrestaShop/community-theme-16?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Development dependencies](https://img.shields.io/david/dev/PrestaShop/community-theme-16.svg?style=flat-square)](https://github.com/PrestaShop/community-theme-16/blob/dev/package.json)
[![Github All Releases](https://img.shields.io/github/downloads/prestashop/community-theme-16/total.svg?style=flat-square)](https://github.com/PrestaShop/community-theme-16/releases)
[![GitHub release](https://img.shields.io/github/release/prestashop/community-theme-16.svg?style=flat-square)](https://github.com/PrestaShop/community-theme-16/releases)
[![License](https://img.shields.io/badge/license-AFL%20v3.0-blue.svg?style=flat-square)](https://opensource.org/licenses/AFL-3.0)

## Disclaimer

THIS THEME IS MAINTAINED BY THE PRESTASHOP COMMUNITY, NOT BY PRESTASHOP SA.

## Screenshots

[![](http://i.imgur.com/IQNNHhL.jpg)](http://i.imgur.com/E2mZLto.jpg) [![](http://i.imgur.com/MhH4U7v.jpg)](http://i.imgur.com/a3MT2Yn.jpg) [![](http://i.imgur.com/FJbLf0Q.jpg)](http://i.imgur.com/MliKmar.jpg)

## About

**Community theme** is a fork of the default PrestaShop 1.6 theme
[default-bootstrap](https://github.com/PrestaShop/PrestaShop/tree/1.6.1.x/themes/default-bootstrap)
taken from [1.6.1.x](https://github.com/PrestaShop/PrestaShop/tree/1.6.1.x/) branch.
The purpose of this theme is to provide a solid and flexible foundation for building new PrestaShop 1.6 themes.
This theme is oriented more towards the developers, who can extend and adapt this theme to the shop's needs.

The main features of this theme:

- Removed unnecessary styles, functions, elements
- Updated libraries (Bootstrap, Font Awesome)
- Wider usage [Bootstrap 3](http://getbootstrap.com/) styles, utilities and components
- Reduced stylesheet size
- Simplified HTML markup
- Improved SEO markup and microdata
- Easier custom theme development
- `gulpfile.js` for building theme archive
- Restructured `.scss` files for easier theme development
- Removed `uniform.js`
- Reindented and cleaned up template, JS and CSS files
- Plain Bootstrap styles
- All Bootstrap components are included
- Refactored header and footer blocks, easily modifiable
- New top menu modules
- Refactored `blockcart`, left column block styles
- Refactored product list template: JS code that compile product list HTML has been removed
- Refactored `jQuery Zoom` option for product page
- Refactored product page, reworked images
- Trimmed order, registration and login form styles
- Cleaned up `my-account`, `404`, `cms`, `cms category`, `comparison` pages
- Cleaned up `contact-form`, `maintenance`, `manufacturer`, `supplier` pages
- Cleaned up `guest-tracking`, `stores`, `index` pages
- Cleaned up `homeslider`, `themeconfigurator`, `blockfacebook`, `blockcms`, `blockcmsinfo` pages
- JS function for detecting mobile and touch device

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

## Libraries and dependencies

                        | default-bootstrap | community-theme-16
----------------------- | ----------------- | -------------
Bootstrap               | 3.0.0             | 3.3.7
Font Awesome            | 4.3.0             | 4.6.3
jquery.uniform.js       | 2.1.2             | -
jquery.total-storage.js | 1.1.2             | 1.1.2
[js-url](https://github.com/websanova/js-url) | - | 2.3.0
[bourbon](https://www.npmjs.com/package/bourbon) | - | ^4.2.6

## Installation

If you would like **to install** this theme, you should download the latest, prepackaged `vx.x.x-community-theme-16.zip`
theme archive from [Releases](https://github.com/PrestaShop/community-theme-16/releases) tab. It contains compiled
`.css` files, full folder structure, `index.php` file in every folder. Unnecessary files are removed. Prepackaged theme
archive can be uploaded and installed via PrestaShop back-office. Files from `dev` branch are not packaged,
you must build a theme archive from them yourself.

## Development

In this repository, files **are not ready** to be zipped and installed as theme.
Instead, a **build** process is used, which automatically builds `.css` files,
copies `index.php` files, creates required folder and does other things, so you don't have to do them manually.
In the end, **build** process outputs theme `.zip` file which can be installed normally.
It keeps the repository clean (we don't have to copy `index.php` 500 times or deal with messy compiled `.css`
commits).

If would like to be able to use this build process and preview the changes at the same time, we suggest doing this:

1. Create a development installation of PrestaShop (e.g. `/presta/`)
2. Clone the repository somewhere else (e.g. `/community-theme-16/`)
3. Build theme `.zip` archive in `/community-theme-16` and install it via back-office in `/presta/`.
4. Move repository files from `/community-theme-16/` "on top" (merge) to PrestaShop installation `/presta/`.
   Don't forget to move hidden dot files and folders!
5. Delete `/community-theme-16/`. You can now do everything in `/presta/`.
5. Change theme files, build CSS, preview changes in your browser.
6. (Optional) Push fixes, improvements to your forked repository and make a pull request to the origin.

**To build** this theme, these tools are required:

1. [Node.js](https://nodejs.org/en/) & [npm](https://www.npmjs.com/).

[npm](https://www.npmjs.com/) package manager comes together with [Node.js](https://nodejs.org/en/).
You should install [Node.js](https://nodejs.org/en/) first and then do a
[self-update](http://blog.npmjs.org/post/85484771375/how-to-install-npm) of [npm](https://www.npmjs.com/):

``` bash
sudo npm install npm -g
```

This will give you the updated version of [npm](https://www.npmjs.com/), which is used to build this theme.

To verify that tools are installed and have the correct versions, type the following in your terminal:

``` bash
node -v
npm -v  // Should output 3.5.2 or higher
```

Once these tools are available, navigate to your cloned repository and run `npm install` command:

``` bash
cd /community-theme-16/
npm install
```

This will install Node.js modules (packages) from [npmjs.com](https://www.npmjs.com/) which are used in
`gulpfile.js` to build the theme.

**Don't forget**: you need to `cd` into the root folder of the cloned repository or the root folder of PrestaShop
installation (in you moved repository files "on top" of PrestaShop installation).

After the modules are installed, you may then run the `build` command:

``` bash
npm run build
```

which will run the build steps defined in `gulpfile.js` and output theme `.zip` archive in root folder of the cloned
repository. This theme `.zip` archive can then be distributed and installed via PrestaShop back-office.

### Build commands

We use `npm` scripts to call `gulp` commands so you don't have to install `gulp` globally on your system.

```
npm run build           // Sequentially runs all of the commands below, outputs a theme .zip archive
                        // in the root folder, ready to be installed to PrestaShop or published.

npm run create-folders  // Creates empty theme folders like pdf/, pdf/lang/, which are not included
                        // repository, but should be in the final theme archive.

npm run compile-css     // Compiles .scss files to .css files using gulp-sass package.

npm run watch-sass      // Watches for changes in theme .scss files and automatically launches
                        // compile-css task when a .scss has been modified and saved

npm run clean-up        // Removes files which should not be in the archive, like cache files

npm run copy-index      // Copies index.php to all directories and subdirectories inside theme folder

npm run format-js       // Formats .js files using JavaScript style rules defined
                        // in .jscsrc using JSCS tool

npm run create-zip      // Adds Config.xml, /themes/ and /modules/ folder files to
                        // theme .zip archive and outputs it in root directory

npm run scan-translations  // Scans .tpl files in /themes/, /modules/ folders and detects
                           // translatable Smarty strings which have incorrect context
```

### Build options

We have added a couple of options to `package.json` file, which you can change:

```
themeName          // Theme directory and name, used to collect files during build process

themeModulePrefix  // Affects which theme modules are compiled and included to theme archive

sourcemaps         // Enables/disables the creation of theme .scss file sourcemaps
```

### [Bourboun](http://bourbon.io/)

**Bourboun** is a **Sass** mixin library. It is available in all theme `.scss` files,
because it is imported globally during `.scss` compilation task. See `gulpfile.js` for more details.

**Bourbon** is not required, you may remove it if you wish so. You'll need to remove the calls to these mixins too.
**Bourbon** provides the same mixins as **Compass** does.
Compass tool and Compass mixins were heavily used in the `default-bootstrap` theme (from which this theme originates),
but it has been replaced with **Bourbon**, which provided a significant performance boost and no necessary code changes.

## Contributing

Contributions are welcome! Your changes should be in agreement with the theme guidelines and goals described above.
Before you make your pull request, we recommend that you join our [gitter room](https://gitter.im/PrestaShop/community-theme-16)
to discuss it.

If you want to make a pull request, we ask that you keep to the same contribution rules as described
in [PrestaShop/PrestaShop](https://github.com/PrestaShop/PrestaShop/blob/develop/CONTRIBUTING.md).

We would like to emphasize the commit message norm:
[How to write a commit message](http://doc.prestashop.com/display/PS16/How+to+write+a+commit+message).
Because this is a theme, you may omit the `type` in your commit message
or write your own, more descriptive type: e.g `SEO`, `JS`, etc.

## License

Community theme is open-sourced software licensed under the [AFL v3.0](https://opensource.org/licenses/AFL-3.0).
