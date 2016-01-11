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
