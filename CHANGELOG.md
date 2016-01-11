# v0.3.0 (2016-01-?)

## Changes

- Deprecated acronym tag replaced with abbr (898ed6a)
- Renamed gulp commands
- Recompressed theme images (losslessly)
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
