/**
 * This template should be overridden by implementing themes to establish
 * the styles they would like to use with DesignKit settings. The following
 * template is provided as a simple example of how you can generate CSS
 * styles from DesignKit settings.
 *
 * .designkit-color { color: [?php print $foreground ?]; }
 * .designkit-bg { background-color: [?php print $background ?]; }
 */

body {
  background: <?php print $body ?>;
}

#header {
      background: <?php print $header ?>;
}

#content {
      background: <?php print $content ?>;
}

.breadcrumb {
      background: <?php print $breadcrumb ?>;
}

#footer {
      background-color: <?php print hagthemepubliccopy_hex2rgba($footer, .5) ?>;
}

#bottom {
      background-color: <?php print hagthemepubliccopy_hex2rgba($bottom, .8) ?>;
}

.sidebar {
      background: <?php print $sidebars?>;
}

.front .islandora-simple-search{
  background-color: <?php print hagthemepubliccopy_hex2rgba($frontsearch, .5) ?>;
}

/*In this case, `designkit_colorshift` is used to darken the background color
(e.g. 10% black fill) when used for `#page-title` and the text color is set to
either white or black based on the lightness of `$background`.*/