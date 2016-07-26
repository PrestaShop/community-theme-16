# v1.1.0 (2016-07-26)

- Updated Bootstrap to v3.3.7 (#245)
- Refactored build process to use local gulp (#246)
- Updated development guide in README
- Minor CSS fixes (#242, 2d3e7c5e18feb6d507aa8d7737ccdf078fabc91e)

# v1.0.0 (2016-07-03)

This release moves the version to `1.0.0` since there are no major issues left to
resolve and no new major features left to implement.

- Updated Font Awesome to 4.6.3 (#238)
- Added a new menu item type: flat category list (#233)
- Merged updates from upstream (default-bootstrap) theme (#230, #231, #232)
- Fixed issues with hover option in top menu module (#227)
- Added JavaScript workaround to expand active category item in category tree block (#226, #228)
- It possible to place HTML content in theme copyright footer block (#225)
- Added gulp command which finds incorrect context parameters in translatable template strings
- Fixed translatable string context in theme templates (#222, #239)

# v0.11.1 (2016-05-22)

- Fixed Sass compilation error reporting issues

# v0.11.0 (2016-05-19)

This release ditches Compass build tool and replaces it with much faster
`gulp-sass` + `bourbon`. Refactored all calls to display an alert using fancybox
have been refactored to a function. You can now easily use a new plugin to display
nicer alerts.

- Fixed cart popup price styles (#200, #207)
- Fixed a missing hook for aeuc module (#199)
- Refactored calls to window.location (#201)
- Extracted JS function to display alert in front office (#202)
- Added overlay to contact, newsletter forms (#203, #204)
- Improved autocomplete for icons and classes in cttopmenu module (#205, #206)
- Replace Compass with gulp-sass and Bourbon (#209, #210)
- Added a task to compile module CSS (#212)
- Refactored out build script options to package.json file (#211)
- Added a new hook for cttopmenu module (#213)

# v0.10.0 (2016-04-17)

This release aims to clean up the remaining PrestaShop pages.
Theme can now be considered mostly cleaned up.

- Cleaned up the following pages and their styles:
  - my-account, address, addresses, identity, history, discount (#179, #180)
  - 404 (#182)
  - cms, cms category (#183)
  - comparison (#184)
  - contact-form (#185)
  - maintenance (#186)
  - manufacturer, manufacturer-list, supplier, supplier-list, guest-tracking (#187)
  - stores (#188)
  - index (#193)
- Account pages now use `.pager` element (#181)
- Following module block have been cleaned up:
  - homeslider (#190)
  - themeconfigurator (#190)
  - blockfacebook (#191)
  - blockcms (#192)
  - blockcmsinfo (#192)
- Integrated bugfixes and patches from `1.6.1.x` upstream theme (#189, #196)
- Improved mobile browser and touch detect JS function (#194)
- A lot of the CSS files are now empty, less file are included in the header

# v0.9.0 (2016-04-04)

This release cleans up order, registration and login pages.
CSS size has been greatly reduced. Login forms show loading overlay
once submitted. Registration form now has HTML5 required attributes.

- Refactored and trimmed order page styles (#170)
  - Replaced cart steps nav with Bootstrap nav pills
  - Trimmed cart summary table CSS
  - Removed unused template code (last added product)
  - Refactored and cleaned up checkout SCSS styles
- Refactored and trimmed registration and login forms (#172)
  - `authentication.tpl` has been split to 3 sub templates
  - Added loading overlays to login forms
  - Added required HTML5 attribute to registration forms
  - Trimmed, organized SCSS styles

# v0.8.0 (2016-03-26)

This release refactors product page:

- Refactored product page templates, styles and JS (#162)
  - Bootstrap tables are used for discounts, features
  - Product tabs are now `<section>`
  - `product.js` has been trimmed
  - Updated jqZoom
  - Refactored thumbnail carousel
  - Accessories now use product list template. Slider still works.
  - Refactored `sendtoafriend` form
  - Refactored page styles, reduced `product.css` size
- Trimmed `blockwislist` buttons and popovers (#163)
- Refactored `productcomments`, removed popovers from comparison page (#164)
- Refactored `socialsharing` buttons (product page, comparison page) (#165)
- Removed unused module partial from global styles (#166)
- Added manufacturer info row to product page (#167)

# v0.7.0 (2016-03-16)

This release refactors products list template:
- Remove layout toggling and compiling using JS (only list class is toggled now)
- Uses flexible grid system that doesn't collapse and work with varied height columns
- Uses CSS classes to switch product card layout (between grid and list)

Other changes include refactored category page, refactored sort bar
and refactored pagination. Scenes have been remove from category page.

- Refactored product list template + CSS + JS code for it (#154)
- Fixed submenu item IDs in `blockcategories` left menu (#155)
- Refactored category page, removed scenes, read more toggle (#156)
- Refactored sort bar and pagination bar in product lists (#157)

# v0.6.0 (2016-03-07)

This release contains a refactored `blockcategories` template
and cleaned up `blocklayered` (but not fully refactored). Other changes include
refactored heading and box elements.

- Minor fixes to various page styles (#152, #153)
- Headings `h1`, `h2`, ... have been reduced in size (#152)
- Sitemap page was refactored along with tree management removal (#151)
- Removed accordion and tree managements script (#150)
- Refactored page heading and subheadings + `.box` (#149)
- `blocklayered` has undergone severe wound treatment. Some complications may still come up. (#148)
- `blockcategories` left column block refactored Bootstrap's `.list-group` (#144)
- `.block` styles have been refactored (#142, #143)
- Fixed module include in build process (#140)


# v0.5.0 (2016-02-29)

This release adds refactored header and footer blocks as well as
improved page layout (more semantic). Top navigation bar has been replaced by
Bootstrap's `.navbar`. **Warning! This may cause some compatibility issues with 3rd party modules.**
Default module `blocktopmenu` has been replaced with more flexible `cttopmenu` modules,
which provides a clean, formatted array of menu items to templates. Other new modules:
`ctconfiguration`, `ctdev`.

## Changes

- Refactored page layout, introduced semantic elements (#92)
- Normalized `z-indexes` in some blocks (#93)
- Replaced breadcrumb template with new template (#94)
- Refactored `blockbanner` (#95)
- Refactored top navigation to Bootstrap's `.navbar` (#97)
- Refactored `blockuserinfo` for new nav (#98)
- Refactored `blockcurrencies` for new nav (#99)
- Refactored `blocklanguages` for new nav (#100)
- Refactored `blockcontact` for new nav (#101, #102)
- Refactored shop logo block (#103, #106)
- Refactored `blocksearch` (#104, #107, #125)
- Refactored `blockcart` header block (#105, #131, #132)
- Refactored `blockcart` popup and crossselling carousel (#137)
- Replaced `blocktopmenu` with `cttopmenu` to be able to build
menu templates (#115, #122, #123, #128, #129, #133, #136)
- Refactored footer block to be simple link lists (#116, #117)
- Added `ctconfiguration` module to configure content block in theme pages (#118, #124)
- Added `ctdev` module, which display theme component styles. Not installed by default. (#127)

# v0.4.0 (2016-01-23)

This release focuses on cleaning up the global styles of theme,
mostly fonts, buttons, icons. Base styles are now much closed to
Bootstrap and can be customized more easily. PrestaShop component
styles haven't been touched (mostly). Project now contains only one
LICENSE in the root folder so you copyright your theme more easily.
Warning! This release is **not production ready**.

## Changes

- All `.form-group` elements are now `div` (#89)
- Refactored icons and their classes (#76, #81, #82)
- All alerts are now `div` (#69)
- Refactored buttons and their styles (#60, #64, #80)
- Trimmed component styles (#58)
- Trimmed templates (#72)
- Removed `compass/reset` (#73)
- Trimmed global styles and variables (#56, #67, #68, #70, #71, #78)
- Reorganized `global.sccs` partials (#53)
- Changes license to `AFL v3.0`, removed license header from files (#52, 74dbeca)
- Removed fixed `27px` `.form-control` height (#51)
- Removed text shadows from CSS (#49)
- Removed Open Sans font (#47)
- Fixed indentation in `.scss` files (#45)

# v0.3.0 (2016-01-13)

Release containing cleaned up and formatted theme files.
Uniform.js has been removed. Theme now uses default Bootstrap vars.
JavaScript formatting step has been added to build process.

## Changes

- Fixed sortbar styles without uniform.js (#36)
- Fixed checkbox styles without uniform.js (#35, 2e70c96)
- Remove uniform.js (#33, bbe65fd)
- Deprecated acronym tag replaced with abbr (898ed6a)
- Renamed gulp commands
- Recompressed theme images losslessly (3981d4)
- Some minor HTML fixes (6d9e931)
- Some minor Smarty syntax improvements (c877bb6, 8e63afd)
- Some minor JS syntax improvements (9dccbcf, 61bf675, 61bf675, edaa6d9)
- Fixed misused .table-responsive class (bd9e1e2)
- Removed commented out HTML elements (aacc08e)
- Fixed misspelled btn class (eb9bc1d)
- Removed footable attributes and classes from discount.tpl (ebed6b9, #13)
- global.scss has been split into smaller files (209d620, #23)
- Removed overridden Bootstrap vars (a07409c)
- Added 20-compatibility.js to put removed code in (5839b90)
- Formatted .js files to Google js code style (33608f7)
- Added .editorconfig file (e5a4f37)
- Converter indentation to spaces: .scss files (1b4d8ab)
- Converted indentation to spaces: .tpl files (43f615e, a54fe22)
- Converted indentation to spaces: .js files (ed12a8b)
- Fix Smarty array access syntax lint error (#27)
- Fixed unclosed smarty tags (#26)
- Fixed unclosed div tag in blockwishlist (#25)
- Indented .tpl files with 2 spaces (#24)
- Indented .js files with 2 spaces (839f36e)
- Added JSCS to format .js files during build (#22)

# v0.2.0 (2016-01-06)

Release with updated Bootstrap (3.3.6) and Font Awesome (4.5.0) libraries.
Some minor style corrections to match the default theme have been applied.

## Changes

- Bootstrap update to `3.3.6` (88d8ff)
- Font Awesome updated to `4.5.0` (4ce3b90)
- Moved Bootstrap and Font Awesome `.scss` files to `scss/vendor` folder (bdcfed8)
- Refactored `.scss` import paths. Files now import all variables, including overridden vendor variables. (#12)
- Fixed `.scss` float compute precision. Fixes Bootstrap element height, widths, etc. (95b284e)
- Applied some style corrections to match the `default-bootstrap` theme with Bootstrap `3.0.0` (#21, 98da455)
- Updated `.gitignore` rules to support working from within PrestaShop installation. (#19)

# v0.1.0 (2016-01-04)

Initial release, containing unaltered files from
[default-bootstrap](https://github.com/PrestaShop/PrestaShop/tree/824cf32752213c6f1f505852a2044b1a5916f621)
theme.

## Changes

- Source `.scss` files were created for `css/highdpi.css` and `css/responsive-tables.css` (d7a0634)
- Changed CSS style to `:expanded` for easier editing (048b400)
- Added `gulpfile.js` for building theme archive (#10)
