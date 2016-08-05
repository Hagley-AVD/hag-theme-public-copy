<?php

/**
 * @file
 * islandora-objects-subset.tpl.php
 *
 * @TODO: needs documentation about file and variables
 */
?>



<div class="islandora-objects clearfix">

    <?php if (isset($collection_image)): ?>
      <div class="collection-landing-wrapper">
      <div class="collection-image-wrapper"><?php print $collection_image; ?></div>
    <?php endif; ?>
    <?php if (!isset($collection_image)): ?>
      <div class=>
      <div class="collection-image-wrapper"><?php print $collection_image; ?></div>
    <?php endif; ?>

    <?php if (isset($islandora_latest_objects)): ?>
      <div class="collection-latest-objects-wrapper"><h1 class="title">Recently Added</h1><?php print $islandora_latest_objects; ?></div>
    <?php endif; ?>


    <?php if (!empty($dc_array['dc:description']['value'])): ?>
      <div class="collection-description-wrapper"><h1 class="title">About this collection</h1><p><?php print $dc_array['dc:description']['value']; ?></p></div>
    <?php endif; ?>


  </div>
  <?php if (isset($islandora_collection_search_block)): ?>
    <div class="collection-search-wrapper"><?php print $islandora_collection_search_block; ?></div>
  <?php endif; ?>
    <span class="islandora-objects-display-switch">
      <?php
    print theme('links', array(
                           'links' => $display_links,
                           'attributes' => array('class' => array('links', 'inline')),
                         )
    );
    ?>
  </span>
    <?php print $pager; ?>
    <?php print $content; ?>
    <?php print $pager; ?>
</div>
