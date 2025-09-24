<img src="https://raw.githubusercontent.com/nomadjimbob/nomadjimbob/master/wiki/mikioplugin/images/mikio_plugin_header.png">

[![License: GPL-2](https://img.shields.io/github/license/nomadjimbob/mikioplugin?color=blue)](LICENSE)
[![saythanks](https://img.shields.io/badge/say-thanks-ff69b4.svg)](https://saythanks.io/to/james.collins%40outlook.com.au)

Mikio Plugin adds a heap of layout and Bootstrap 4 elements that can be used on your [DokuWiki](http://dokuwiki.org/) pages.

This plugin can be used by itself, however is designed to complement the [Mikio DokuWiki template](http://dokuwiki.org/template:mikio).

## Flexbox Fix

A flexbox fix was applied to the card body element. This may affect existing layouts that relied on the previous (incorrect) formatting. For example, buttons that were unintentionally displayed as `block` elements will now render with their correct inline behavior.

## Updating Styles

You can update the colors used by the elements by editing the `/assets/variables.css` file. From version 2022-10-31 onwards, the theme supports darkmode within browsers.

If you have the [Mikio DokuWiki template](http://dokuwiki.org/template:mikio) 2022-10-31 onwards installed, the `/assets/variables.css` will be ignored as the template adds the variables itself. These can be edited using
**Template Style Settings** in your sites **Administration** page.

## Setting Up

Download the [latest release](https://github.com/nomadjimbob/mikioplugin/releases/latest) and place it in the\
\
:file_folder: dokuwiki\
&nbsp;&nbsp;&nbsp;&nbsp;:file_folder: lib\
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:file_folder: plugins

directory of your DokuWiki installation.

Sometimes GitHub releases change the name of the mikioplugin directory, so make sure that the directory is `mikioplugin` else you may see errors in DokuWiki.

## Disabling Tags

If a Mikio Plugin tag is conflicting with another plugins tag, or you want to simply disable a tag, you can do this in the `disabled-tags.php` file.

Simply change the tag you want to disable to `true` instead of `false`. Pages that have already been generated while the tag was enabled will need to be regenerated.

## Releases

- **_NEXT_**  
    -   Fixed bug in icon engine where bootstrap icons were not being rendered correctly [#42](https://github.com/nomadjimbob/mikioplugin/issues/42). Thanks nhratos.
    -   Fixed rendering bug inside columns in certain instances due to flexbox [#41](https://github.com/nomadjimbob/mikioplugin/issues/41). Thanks reissmann.
    -   Fixed rendering bug inside card body in certain instances due to flexbox [#40](https://github.com/nomadjimbob/mikioplugin/issues/40). Thanks mueniko.
    -   Other Navs now close when a second one is opened [#39](https://github.com/nomadjimbob/mikioplugin/issues/39). Thanks aloade.
    -   Fixed undefined array key errors under PHP 8.1 [#37](https://github.com/nomadjimbob/mikioplugin/issues/37). Thanks MartijnSanders.

- **_2025-07-24_**  
    -   Fixed security vulnerability, parsing less error discloses the physical path. Reported by B Mercer.
    -   Fixed invalid white-space property in stylesheet.
    -   Various PHP optimizations and code cleanup.

- **_2024-06-05_**

    -   Added `<tags>` element to support rendering the page tags anywhere if using the Mikio theme [Mikio-#70](https://github.com/nomadjimbob/mikio/issues/70). Requested by garanovich.
    -   Fixed images being stretched in cards [#32](https://github.com/nomadjimbob/mikioplugin/issues/32). Thanks Elanndelh.
    -   Added `align-` support to cards [#35](https://github.com/nomadjimbob/mikioplugin/issues/35). Requested by garanovich.
    -   `<right-sidebar>` element added for making right handed sidebars within the page.

- **_2024-02-09_**   

    -   Added support for DokuWiki Kaos
    -   Updated to support PHP 8.2

-   **_2024-01-14_**

    -   `<col>` now supports the `vertical-align` option, defaulting to top [#30](https://github.com/nomadjimbob/mikioplugin/issues/30). Thanks EmmaKnijn.
    -   `<right-sidebar>` element added for making right handed sidebars within the page.

-   **_2024-01-06_**

    -   Fix missing default options of height and width in nav element [#29](https://github.com/nomadjimbob/mikioplugin/issues/29). Thanks armandostyl.

-   **_2023-12-10_**

    -   Fix a LESS compiliation error introduced in [#26](https://github.com/nomadjimbob/mikioplugin/issues/26). Thanks WetenSchaap.

-   **_2023-12-04_**

    -   Multiple paginations on a single page is now supported.
    -   Pagination will try it best in resolving malformed URLs with missing content.
    -   Fixed parsing to ignore <> symbols in element options which used to break the element.
    -   Added ability to create group radio items in a multiple quiz item by surrounding options in []. Requested by Dylan.
    -   Renamed pagenation to pagination while keep backwards compatibility.
    -   Fixed pagination when using nice urls, rewrites and slashes [#26](https://github.com/nomadjimbob/mikioplugin/issues/26). Thanks armandostyl.
    -   Updated pagination to use its own variables inside variables.css.
    -   Fixed up some border radius issues and dark mode theming on pagination element.

-   **_2023-11-19_**

    -   Fix quiz results not shown correctly when markdown formatting applied.
    -   Quiz placeholders can now be markdown formatted.
    -   Quiz result elements now have classes that can be manually styled through css.
    -   Fix button backgrounds being overridden by the DokuWiki theme when styled.

-   **_2023-11-18_**

    -   Better handling when a `quizitem` does not contain a `scores` or `answer` attribute.
    -   Added `full` attribute to `quiz` to show the entire quiz.
    -   Quiz questions, text and options support basic markdown to bold and italic points.
    -   Quiz now supports [style](https://github.com/nomadjimbob/mikioplugin/wiki/Common-Attributes#styles) attribute for buttons.
    -   Custom styles now automatically builds the `outline-` style.

-   **_2023-11-17_**

    -   Added scoring and multiple options to the `quiz` elements. Requested by Dylan.

-   **_2023-10-16_**

    -   Added support to justify individual components of the card. Requested by Dylan.

-   **_2023-10-10_**

    -   Fixed custom styles not being implemented correctly and added direct type support. Thanks Dylan
    -   Heading element now supports `color` and `text-decoration` options. Requested by Dylan.

-   **_2023-09-11_**

    -   Fixed small tag not being inline [#22](https://github.com/nomadjimbob/mikioplugin/issues/22). Thanks Rayaqu
    -   Added support to disable tags.

-   **_2023-09-03_**

    -   Fixed card height issues on smaller viewports.
    -   Fixed columns not stacking on small viewports when using sizing. [#21](https://github.com/nomadjimbob/mikioplugin/issues/21). Thanks armandostyl

-   **_2023-06-16_**

    -   Fixed spacing issues with listgroup items with mixed styles. [#20](https://github.com/nomadjimbob/mikioplugin/issues/20). Thanks armandostyl

-   **_2023-06-06_**

    -   Added Nav item to create dropdown navigation items. [#18](https://github.com/nomadjimbob/mikioplugin/issues/18). Thanks armandostyl
    -   Added support for elements in sidebars

-   **_2023-05-20_**

    -   AccordionItem, Alert, Blockquote, Card and CardBody now support containing 'protected' type which fixes some elements not rendering correctly (ie <&lt>code<&gt>)

-   **_2023-05-19_**

    -   Updated to include a polyfill for array_key_first if PHP < 7.3

-   **_2022-10-31_**

    -   Fixed 'link' type for Buttons
    -   Updated CSS to use CSS Variables (supporting switchable themes and style editor within Mikio template). Thanks chrbinder.
    -   variables.css no longer included if the mikio template is installed, active and version 2022-10-31 or greator

-   **_2022-01-18_**

    -   Fixed accordian not rendering tables inside itself [#15](https://github.com/nomadjimbob/mikioplugin/issues/15). Thanks Melphios

-   **_2021-12-15_**

    -   Added `autoclose` attribute to Accordions to close any other open accordion items other than the one clicked by the user. Requested by eFreshman

-   **_2021-12-14_**

    -   Fix Carousel not containing image by default [#14](https://github.com/nomadjimbob/mikioplugin/issues/14). Thanks eFreshman

-   **_2021-12-13_**

    -   Fix Struct Plugin Aggregation [#13](https://github.com/nomadjimbob/mikioplugin/issues/13). Thanks eFreshman

-   **_2021-11-13_**

    -   Carousel control colors can now be customized
    -   Carousel now supports circle indicators
    -   Dynamically build and fullscreen carousels now supported
    -   SyntaxRender method now correctly converts tagName to methodNames

-   **_2021-08-11_**

    -   Replace Windows directory separator in CSS paths
    -   Fixed path check in LESS engine on Windows
    -   Recompiled CSS
    -   Fixed PHP warnings

-   **_2021-08-10_**

    -   Button outline styling fix [#12](https://github.com/nomadjimbob/mikioplugin/issues/12)
    -   Added small margin to left and right of buttons

-   **_2021-07-13_**

    -   Element class shortcuts (eg text-center) working again
    -   LESS engine updated to match the Mikio theme
    -   LESS fallback to CSS

-   **_2021-04-23_**

    -   Fixed Card element overflow issues. Cards will now be their own height when inside a row element. To force cards to all be the same height, wrap each card in a col element
    -   Adding a card-footer element inside a card-body element will now work. This fixes inside card elements
    -   Cards and Carousel images are now contained inside the element instead of covering the element
    -   Added `cover` attributes to Card and Carousel for images to cover element instead of being contained
    -   Height attribute bugfix for placeholders

-   **_2021-04-19_**

    -   Fixed images not always being contained within elements such as card headers [#9](https://github.com/nomadjimbob/mikioplugin/issues/9)

-   **_2021-03-05_**

    -   Added support for custom element types and styling [#6](https://github.com/nomadjimbob/mikioplugin/issues/6)

-   **_2021-03-02_**
    -   Fixed a dokuwiki rendering issue in card bodies [#7](https://github.com/nomadjimbob/mikioplugin/issues/7)
    -   Fixed a text alignment not being applied in alerts [#8](https://github.com/nomadjimbob/mikioplugin/issues/8)

## Links

-   DokuWiki Plugin Page: (http://dokuwiki.org/plugin:mikioplugin)
-   Download: (https://github.com/nomadjimbob/mikioplugin/releases/latest)
-   Docs: (https://github.com/nomadjimbob/mikioplugin/wiki)
-   Donate: (https://www.ko-fi.com/nomadjimbob)
-   License: (https://raw.githubusercontent.com/nomadjimbob/mikioplugin/master/LICENSE)

## Contributing

Any contributions are appreciated. Please feel free to reach out to me at james.collins@outlook.com.au
