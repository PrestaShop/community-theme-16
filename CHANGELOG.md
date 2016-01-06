# v0.2.0 (2016-01-06)

Release with updated Bootstrap (3.3.6) and Font Awesome (4.5.0) libraries.
Some minor style corrections to match the default theme have been applied.

## Changes

- Bootstrap update to `3.3.6`
- Font Awesome updated to `4.5.0`
- Moved Bootstrap and Font Awesome `.scss` files to `scss/vendor` folder
- Refactored `.scss` import paths. Files now import all variables, including overridden vendor variables. (1c8593f)
- Fixed `.scss` float compute precision. Fixes Bootstrap element height, widths, etc. (95b284e)
- Applied some style corrections to match the `default-bootstrap` theme with Bootstrap `3.0.0` (98da455, #21)
- Updated `.gitignore` rules to support working from within PrestaShop installation.


# v0.1.0 (2016-01-04)

Initial release, containing unaltered files from 
[default-bootstrap](https://github.com/PrestaShop/PrestaShop/tree/824cf32752213c6f1f505852a2044b1a5916f621)
theme.

## Changes

- Source `.scss` files were created for `css/highdpi.css` and `css/responsive-tables.css`
- Changed CSS style to `:expanded` for easier editing
- Added `gulpfile.js` for building theme archive
