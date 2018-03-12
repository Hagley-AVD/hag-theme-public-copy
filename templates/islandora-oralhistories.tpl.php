<?php

/**
 * @file
 * This is the template file for the object page for oralhistories
 *
 * Available variables:
 * - $islandora_object: The Islandora object rendered in this template file
 * - $islandora_dublin_core: The DC datastream object
 * - $dc_array: The DC datastream object values as a sanitized array. This
 *   includes label, value and class name.
 * - $islandora_object_label: The sanitized object label.
 * - $parent_collections: An array containing parent collection(s) info.
 *   Includes collection object, label, url and rendered link.
 *
 * @see template_preprocess_islandora_oralhistories()
 * @see theme_islandora_oralhistories()
 */
?>

<div class="islandora-oralhistories-object islandora" vocab="http://schema.org/" prefix="dcterms: http://purl.org/dc/terms/" typeof="VideoObject">
  <div class="islandora-oralhistories-content-wrapper  clearfix">
    <?php if ($islandora_content['viewer']): ?>
      <div class="islandora-oralhistories-content">
        <?php print $islandora_content['viewer']; ?>
      </div>
    <?php endif; ?>
  </div>
  <div class="islandora-oralhistories-metadata">
    <?php print $description; ?>
    <?php if ($parent_collections): ?>
      <div>
        <h2><?php print t('In collections'); ?></h2>
        <ul>
          <?php foreach ($parent_collections as $collection): ?>
        <li><?php print l($collection->label, "islandora/object/{$collection->id}"); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>
    <?php print $metadata; ?>
  </div>
</div>
<link type="text/css" rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.4/css/bootstrap-select.min.css" media="all" />
<script type = "text/javascript" language = "javascript">
        jQuery(window).bind("load", function() {
			jQuery("option[value='or_transcriptFull']").attr("selected", null);
            jQuery("option[value='or_transcript']").attr("selected", null);
            jQuery("span.text:contains('Transcript')").parents("li.selected").removeClass("selected");
            jQuery("div[data-tier='or_transcriptFull']").css('display','none');
            jQuery("span.text:contains('Partial transcript')").parents("li.selected").removeClass("selected");
            jQuery("div[data-tier='or_transcript']").css('display','none');
         });

      </script> 

