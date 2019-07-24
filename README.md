
# Modern Minimalist

WordPress theme built for my personal website. It is minimalistic and primarily focuses on content.

## What other software is used in this theme?

I built this theme with the use of:

* [Bulma](bulma.io) - CSS only framework, which speeds up development process
* [Webpack](webpack.js.org) - module bundler, used to process various files into production ready and minified versions
* [Timber](https://github.com/timber/timber) - WordPress plugin, which enables use of Twig language in WordPress themes
* [ACF](https://www.advancedcustomfields.com/) - Advanced Custom Fields is another WordPress plugin which adds many posibilieties to add custom fields to WordPress elements.

## Instalation

Install this theme as you would any other, and be sure the Timber plugin is activated. But hey, let's break it down into some bullets:

1. Make sure you have installed the plugin for the [Timber Library](https://wordpress.org/plugins/timber-library/) (and Advanced Custom Fields - they [play quite nicely](https://timber.github.io/docs/guides/acf-cookbook/#nav) together). 
1. Download the zip for this theme (or clone it) and move it to `wp-content/themes` in your WordPress installation. 
1. Activate the theme in Appearance >  Themes.
1. Do your thing! And read [the docs](https://github.com/jarednova/timber/wiki).

## What's here?

`src/` is where you can keep development related files (e.g. the ones that will get bundled into minified versions in production). It contains subfolders for js and scss files.

`templates/` contains all of your Twig templates. These pretty much correspond 1 to 1 with the PHP files that respond to the WordPress template hierarchy. At the end of each PHP template, you'll notice a `Timber::render()` function whose first parameter is the Twig file where that data (or `$context`) will be used. Just an FYI.

`bin/` and `tests/` ... basically don't worry about (or remove) these unless you know what they are and want to.

## Other Resources

* [Timber Wiki](https://github.com/jarednova/timber/wiki) - useful resources for WordPress development with Timber
* [Twig for Timber Cheatsheet](http://notlaura.com/the-twig-for-timber-cheatsheet/)
* [Timber and Twig Reignited My Love for WordPress](https://css-tricks.com/timber-and-twig-reignited-my-love-for-wordpress/) on CSS-Tricks
* [A real live Timber theme](https://github.com/laras126/yuling-theme).
* [Timber Video Tutorials](http://timber.github.io/timber/#video-tutorials) and [an incomplete set of screencasts](https://www.youtube.com/playlist?list=PLuIlodXmVQ6pkqWyR6mtQ5gQZ6BrnuFx-) for building a Timber theme from scratch.

