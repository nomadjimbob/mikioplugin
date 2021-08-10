<img src="https://raw.githubusercontent.com/nomadjimbob/nomadjimbob/master/wiki/mikioplugin/images/mikio_plugin_header.png">

[![License: GPL-2](https://img.shields.io/github/license/nomadjimbob/mikioplugin?color=blue)](LICENSE)
[![Github all releases](https://img.shields.io/github/downloads/nomadjimbob/mikioplugin/total.svg)](https://github.com/nomadjimbob/mikioplugin/releases/)
[![saythanks](https://img.shields.io/badge/say-thanks-ff69b4.svg)](https://saythanks.io/to/james.collins%40outlook.com.au)
[![Donate to this project using Ko-Fi](https://img.shields.io/badge/kofi-donate-yellow.svg)](https://www.ko-fi.com/nomadjimbob)

Mikio Plugin adds a heap of layout and Bootstrap 4 elements that can be used on your [DokuWiki](http://dokuwiki.org/) pages.

This plugin can be used by itself, however is designed to complement the [Mikio DokuWiki theme](http://dokuwiki.org/template:mikio).

## Setting Up

Download the [latest release](https://github.com/nomadjimbob/mikioplugin/releases/latest) and place it in the\
\
:file_folder: dokuwiki\
&nbsp;&nbsp;&nbsp;&nbsp;:file_folder: lib\
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:file_folder: plugins

directory of your DokuWiki installation.

Sometimes GitHub releases change the name of the mikioplugin directory, so make sure that the directory is `mikioplugin` else you may see errors in DokuWiki.

## Releases

- **_2021-08-10_**

  - Button outline styling fix [#12](https://github.com/nomadjimbob/mikioplugin/issues/12)
  - Added small margin to left and right of buttons

- **_2021-07-13_**

  - Element class shortcuts (eg text-center) working again
  - LESS engine updated to match the Mikio theme
  - LESS fallback to CSS

- **_2021-04-23_**

  - Fixed Card element overflow issues. Cards will now be their own height when inside a row element. To force cards to all be the same height, wrap each card in a col element
  - Adding a card-footer element inside a card-body element will now work. This fixes inside card elements 
  - Cards and Carousel images are now contained inside the element instead of covering the element
  - Added `cover` attributes to Card and Carousel for images to cover element instead of being contained
  - Height attribute bugfix for placeholders

- **_2021-04-19_**

  - Fixed images not always being contained within elements such as card headers [#9](https://github.com/nomadjimbob/mikioplugin/issues/9)

- **_2021-03-05_**

  - Added support for custom element types and styling [#6](https://github.com/nomadjimbob/mikioplugin/issues/6)

- **_2021-03-02_**
  - Fixed a dokuwiki rendering issue in card bodies [#7](https://github.com/nomadjimbob/mikioplugin/issues/7)
  - Fixed a text alignment not being applied in alerts [#8](https://github.com/nomadjimbob/mikioplugin/issues/8)

## Links

- DokuWiki Plugin Page: (http://dokuwiki.org/plugin:mikioplugin)
- Download: (https://github.com/nomadjimbob/mikioplugin/releases/latest)
- Docs: (https://github.com/nomadjimbob/mikioplugin/wiki)
- Donate: (https://www.ko-fi.com/nomadjimbob)
- License: (https://raw.githubusercontent.com/nomadjimbob/mikioplugin/master/LICENSE)

## Contributing

Any contributions are appreciated. Please feel free to reach out to me at james.collins@outlook.com.au
