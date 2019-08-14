<?php

/**
 * @file
 * islandora-basic-collection-wrapper.tpl.php
 *
 * @TODO: needs documentation about file and variables
 */
?>



<div class="islandora-basic-collection-wrapper">

    <?php if (isset($collection_image)): ?>
      <div class="collection-landing-wrapper">
      <div class="collection-image-wrapper"><?php print $collection_image; ?></div>
    <?php endif; ?>

<?php if (isset($islandora_latest_objects)): ?>
   <!--    <div class="collection-latest-objects-wrapper"><h1 class="title">Recently Added</h1><?php //print $islandora_latest_objects; ?></div> -->
   <?php endif; ?>


    <?php if (!empty($dc_array['dc:description']['value'])): ?>
      <div class="collection-description-wrapper"><h1 class="title">About dis collection</h1><p><?php print $dc_array['dc:description']['value']; ?></p><p><?php print $solr_fields['display_label']; ?></p></div>
    <?php endif; ?>


  </div>
  <?php if (isset($islandora_collection_search_block)): ?>
    <div class="collection-search-wrapper"><?php print $islandora_collection_search_block; ?></div>
  <?php endif; ?>
  <?php if (isset($islandora_object['OBJ'])): ?>
    <div class="islandora-basic-collection-image-obj-wrapper"><img src="/islandora/object/<?php print $islandora_object->id; ?>/datastream/OBJ/view"></img></div>
  <?php endif; ?>
  <div class="islandora-basic-collection clearfix">
    <span class="islandora-basic-collection-display-switch">
      <ul class="links inline">
        <?php foreach ($view_links as $link): ?>
          <li>
            <a <?php print drupal_attributes($link['attributes']) ?>><?php print filter_xss($link['title']) ?></a>
          </li>
        <?php endforeach ?>
      </ul>
    </span>
    <?php print $collection_pager; ?>
    <?php print $collection_content; ?>
    <?php print $collection_pager; ?>
  </div>
</div>
