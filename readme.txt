=== Mustang Lite ===
Theme URI:    http://www.webmandesign.eu/mustang-lite/
Author:       WebMan
Author URI:   http://www.webmandesign.eu/
License:      GNU General Public License v2 or later
License URI:  http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Mustang Lite WordPress Theme lets you create beautiful, professional responsive and HiDPI (Retina) ready websites. With this theme you can create also a single one-page websites with ease! Mustang Lite is suitable for creative portfolio, business and corporate website projects, personal presentations and much more. You can set a custom design with background images and colors for every section of the theme. As the theme is translation ready and supports right-to-left languages as well, you can localize it for your multilingual website. By default you get the basic blog design which can be extended to full power of the theme with WebMan Amplifier plugin activation. This theme is a free, lite version of premium Mustang Multipurpose WordPress Theme by WebMan. The differences from paid version can be found at http://www.webmandesign.eu/mustan-lite/. Check out themes by WebMan at www.webmandesign.eu. Thank you for using one of WebMan's themes!

Follow WebMan on Twitter [https://twitter.com/webmandesigneu] or become a fan on Facebook [https://www.facebook.com/webmandesigneu].

Full theme demo website at [http://themedemos.webmandesign.eu/mustang/].

Theme user manual with demo data at [http://www.webmandesign.eu/manual/mustang/].

== Demo ==

http://themedemos.webmandesign.eu/mustang/

== Changelog ==

= 1.2.5 =
* UPDATED: WebMan Amplifier plugin moved from "required" to "recommended"
* FIX: Projects shortcode layout on small screens

Files changed: `readme.md, assets/css/responsive.css, setup/plugins.php, setup/setup-webman-amplifier.php`

= 1.2.2 =
* ADDED: Support for WebMan Amplifier widgets
* UPDATED: Theme description text
* UPDATED: Removed automatic redirect to "About" page after theme activation, displaying admin notice instead
* UPDATED: Code flexibility improvements
* UPDATED: Framework library version 3.4
* UPDATED: Localization files
* FIX: Default fallback footer widgets styles
* FIX: Removed HTML5Shiv CDN link
* REMOVED: All the widgets - they are part of WebMan Amplifier from now on

Files removed: `setup/widgets.php, setup/widgets/w-contact.php, setup/widgets/w-module.php, setup/widgets/w-posts.php, setup/widgets/w-subnav.php, setup/widgets/w-tabbed-widgets.php, setup/widgets/w-twitter.php`
Files changed: `functions.php, style.css, sidebar-footer.php, languages/wm_domain.pot, setup/setup.php, setup/setup-webman-amplifier.php, setup/about/about.php`

= 1.2.1 =
* UPDATED: Basic icons fully GPL compatible
* UPDATED: Optimized code
* UPDATED: Framework library version 3.3
* FIX: Removed schema.org attributes from title HTML tag
* FIX: Default sidebars content display when WebMan Amplifier plugin is active (especially for plugins such as WooCommerce)
* FIX: Fixed HTML head according to new Theme Check

Files changed: `header.php, sidebar.php, sidebar-footer.php, assets/css/content.css, assets/css/icons-basic.css, assets/css/prettyphoto.css, assets/css/rtl.css, assets/css/shortcodes.css, assets/css/initial/global.css, assets/font/basic-icons/*.*, library/*.*, setup/plugins.php, setup/setup.php, setup/setup-theme-options.php, setup/widgets.php`

= 1.2 =
* ADDED: WordPress 4.0 support
* ADDED: Text logo font setup
* ADDED: Files content list in unminified stylesheet
* UPDATED: Unminified styles and scripts used with WordPress debug mode
* UPDATED: Framework's library version 3.2
* UPDATED: Minor CSS styles
* UPDATED: Scripts: imagesLoaded 3.1.8, Animate.css
* FIXED: Support contextual help tab databaze info PHP error
* FIXED: All assets URLs (including the ones inside the stylesheet) are SSL ready
* FIXED: Centered Content Modules mobile view issue
* FIXED: Icon list inside Content Module issue
* FIXED: 100% score with http://themecheck.org/

Files changed: `assets/css/_custom-styles.php, assets/css/_generate-css.php, assets/css/_generate-rtl-css.php, assets/css/_generate-ve-css.php, assets/css/core.css, assets/css/high-dpi.css, assets/css/plugins-woocommerce.css, assets/css/prettyphoto.css, assets/css/reset.css, assets/css/responsive.css, assets/css/rtl-responsive.css, assets/css/shortcodes.css, assets/css/sidebar.css, assets/css/specials.css, assets/css/visual-editor.css, assets/js/scripts.js, assets/js/dev/scripts.dev.js, setup/plugins.php, setup/setup-theme-options.php, setup/setup.php, setup/about/about-custom.css`

= 1.1.3 =
* FIXED: Long logo (website title) text wrapping

Files changed: `assets/css/initial/global.css`

= 1.1.2 =
* FIXED: Assets URLs in CSS stylesheet

Files changed: `assets/css/initial/global.css`

= 1.1.1 =
* ADDED: CSS styles for text logo
* UPDATED: Minor CSS styles
* UPDATED: WebMan Amplifier plugin no longer forced to install
* UPDATED: "About" page updated
* UPDATED: Localization texts
* FIXED: Theme works without WebMan Amplifier plugin as a basic blog theme

Files added: `loop-page.php, loop-post.php, sidebar-footer.php, assets/css/initial/global.css`
Files changed: `404.php, comments.php, content-audio.php, content-gallery.php, content.php, home.php, index.php, loop-singular.php, loop-theme-search.php, page.php, sidebar.php, single.php, assets/css/_custom-styles.php, assets/css/content.css, assets/css/header.css, assets/css/typography.css, setup/plugins.php, setup/setup.php, setup/widgets.php, setup/about/about-custom.css, setup/about/about.php`

= 1.1 =
* ADDED: Styled scrollbar for Webkit browsers (Chrome, Opera, Safari)
* ADDED: Readme.txt file
* ADDED: Custom styles for PrettyPhoto
* ADDED: Custom styles for WordPress media player
* UPDATED: WebMan Amplifier setup file fixed to be transferable to other themes
* UPDATED: WebMan Amplifier support enhanced
* UPDATED: Making columns equal height in a row
* UPDATED: Improved flexibility of website header and footer
* UPDATED: Altered `wm_helper_var()` function (removed `$callback` parameter) to improve security
* UPDATED: If custom link is set up on project in projects list, apply this as redirect on single project page
* UPDATED: Scripts: HTML5Shiv.js, Animate.css
* UPDATED: Blank page template uses fullwidth sections page layout now
* UPDATED: Library update 3.1
* FIXED: `$create_images` variable error
* FIXED: Minor CSS styles bugs
* FIXED: Open Sans Condensed Google font integration
* FIXED: Fixed header bug when no topbar used
* FIXED: RTL: sub-submenu opening direction
* REMOVED: `head.php`

Files changed: `content-audio.php, content-video.php, footer.php, header.php, single.php, assets/css/animate.css, assets/css/borders.css, assets/css/core.css, assets/css/header.css, assets/css/prettyphoto.css, assets/css/rtl.css, assets/css/shortcodes.css, assets/css/wp-styles.css, assets/js/scripts.js, assets/js/dev/scripts.dev.js, languages/wm_domain.pot, library/*.*, setup/plugins.php, setup/setup-theme-options.php, setup/setup-webman-amplifier.php, setup/setup.php, setup/about/about.php`
Files removed: `head.php`

= 1.0 =
* Initial release.

== Documentation ==

User manual available at http://www.webmandesign.eu/manual/mustang/

== Copyright ==

**Mustang Lite WordPress Theme**
Copyright 2014 WebMan [http://www.webmandesign.eu/]
Distributed under the terms of the GNU GPL

**Animate.css**
Copyright (c) 2014 Daniel Eden
Licensed under the MIT license - http://opensource.org/licenses/MIT
http://daneden.me/animate

**Normalize.css**
Copyright (c) Nicolas Gallagher and Jonathan Neal
Licensed under the MIT license - http://opensource.org/licenses/MIT
git.io/normalize

**HTML5 Shiv**
Copyright (c) 2014 Alexander Farkas
Licensed under MIT/GPL2
https://github.com/aFarkas/html5shiv

**imagesLoaded**
Copyright (c) 2014 Tomas Sardyha (@Darsain) and David DeSandro (@desandro)
Licensed under the MIT license - http://opensource.org/licenses/MIT
https://github.com/desandro/imagesloaded

**jquery.appear.js**
Copyright (c) 2012 Andrey Sidorov
Licensed under MIT
https://github.com/morr/jquery.appear/

**jquery.prettyPhoto.js**
Copyright, Stephane Caron
Licensed under Creative Commons 2.5 [http://creativecommons.org/licenses/by/2.5/] or GPLV2 license [http://www.gnu.org/licenses/gpl-2.0.html]
Please see assets/js/prettyphoto/README file for more info.
http://www.no-margin-for-errors.com

**jquery.viewport.js**
Copyright (c) 2008-2009 Mika Tuupola
Licensed under the MIT license
http://www.appelsiini.net/projects/viewport

**Respond.js**
Copyright 2014 Scott Jehl
Licensed under MIT
http://j.mp/respondjs

**Fontello font icons**
Please see assets/font/basic-icons/LICENCE.txt file for more info.