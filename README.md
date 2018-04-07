# AvantTheme (theme for Omeka Classic)

AvantTheme provides:

* Layout, styling, and graphics for public facing pages
* Controls for simple search, subject search, and advanced search (using the [AvantSearch](https://github.com/gsoules/AvantSearch) plugin to replace Omeka's search controls)
* Support for [Galleries](http://swhplibrary.net/archive/gallery/)
* Support for the Lightbox feature (using the [AvantCustom](https://github.com/gsoules/AvantCustom) plugin and [Magnific Popup](https://github.com/dimsemenov/Magnific-Popup/))
* Support for the [Zoomable images feature](http://swhplibrary.net/digitalarchive/find?tags=zoomable&view=4) (using the [AvantCustom](https://github.com/gsoules/AvantCustom) plugin and [OpenSeadragon](https://openseadragon.github.io/)).
* Custom 404 error page

## Dependencies
AvantTheme depends on the following plugins. The theme will report an error if the plugins are not installed and active.

* [AvantCustom](https://github.com/gsoules/AvantCustom)
* [AvantSearch](https://github.com/gsoules/AvantSearch)

## Installation

To install the AvantTheme, follow these steps:

1. Unzip the AvantTheme-master file into your Omeka installation's theme directory.
2. Rename the folder to avant.
3. Set the theme as the current theme from Omeka's Appearance > Themes page.
4. Configure the theme to provide a Logo File and Footer Text (if desired). The Logo File should be 80px tall and up to 600 px wide.
5. Edit the CSS variables at the top of the style.css file to provide colors for the page background and links.

## Usage
AvantTheme was designed to be used with AvantSearch and AvantRelationships and as such, does not utilize most of the
configuation options used by other themes. In addition to the Log File and Footer Text options, it provides a
CSS File Name option that lets you specify the name of a CSS file that overrides the theme's style.css.

* **CSS File Name** - By creating your own CSS file and placing it in the theme folder's CSS folder, you can easily make CSS
 changes without having to edit style.css. This approach makes it very easy to see and maintain changes that you have made.

##  License

This theme is published under [GNU/GPL].

This program is free software; you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation; either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT
ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
details.

You should have received a copy of the GNU General Public License along with
this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.

Copyright
---------

* Created by [gsoules](https://github.com/gsoules) .
* Copyright George Soules, 2018.
* See [LICENSE](https://github.com/gsoules/AvantRelationships/blob/master/LICENSE) for more information.


