<?php
/**
 * @file
 * Contains the theme's functions to manipulate Drupal's default markup.
 */

/**
 * Implements hook_preprocess_html().
 */
function hagthemepubliccopy_preprocess_html(&$variables){
  if ($variables['is_front']) {
    module_load_include('module', 'islandora_basic_collection', 'islandora_basic_collection');
    $background_collection_pid = (theme_get_setting('hag_background_collection_pid') ? theme_get_setting('hag_background_collection_pid') : "islandora:root");

    $qp = new IslandoraSolrQueryProcessor();
    $qp->buildQuery('*:*');
    // Limit to the object in "that:thing" collection...
    $qp->solrParams['fq'][] = 'RELS_EXT_isMemberOfCollection_uri_mt:"info:fedora/"' . $background_collection_pid;
    // ... that have the "MODS" datastream.
    $qp->solrParams['fq'][] = 'fedora_datastreams_ms:' . (theme_get_setting('hag_background_dsid') ? theme_get_setting('hag_background_dsid') : "TN");
    $qp->executeQuery();
    $response = $qp->islandoraSolrResult['response']['objects'];
    if (count($response) >= 1) {
      $random = array_rand($response, 1);
      $pid = $response[$random]['PID'];
      $object = islandora_object_load($random['PID']);
      $dsid = (theme_get_setting('hag_background_dsid') ? theme_get_setting('hag_background_dsid') : "TN");
      $variables['background_image'] = "/islandora/object/$pid/datastream/$dsid/view";
    } else {
      $path = drupal_get_path('theme', 'hagthemepubliccopy');
      $image_path = $path . '/images/bg_lightwoodfloor.jpg';
      $variables['background_image'] = $image_path;
    }
  }
}

/**
 * Implements hook_preprocess_page().
 */
function hagthemepubliccopy_preprocess_page(&$variables) {
  if ($variables['is_front'] == FALSE) {
    // Add the search for the header.
    if (module_exists('islandora_solr')) {
      module_load_include('inc', 'islandora_solr', 'includes/blocks');
      $block = islandora_solr_block_view('simple');
      $variables['islandora_header_search'] = render($block['content']);
    }
  }
  $path = current_path();
  $path_array = explode("/", $path);
  if (count($path_array) >= 2) {
    if ($path_array[0] == 'islandora' && $path_array[1] == 'search'){
      drupal_set_title("Search Results");
    }
  }
}

/**
 * Used with design kit to change hex to RGBA.
 *
 * @param string $color
 *   HEX color code.
 *
 * @param string $opacity
 *   Opacity, number between 0 and 1.
 *
 * @return string
 *   The RGBA color value.
 */
function hagthemepubliccopy_hex2rgba($color, $opacity = false) {
  $default = 'rgb(0,0,0)';
  //Return default if no color provided
  if(empty($color))
    return $default;

    //Sanitize $color if "#" is provided
    if ($color[0] == '#' ) {
      $color = substr( $color, 1 );
    }

    //Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
      $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
    } elseif ( strlen( $color ) == 3 ) {
      $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
    } else {
      return $default;
    }
    //Convert hexadec to rgb
    $rgb =  array_map('hexdec', $hex);

    //Check if opacity is set(rgba or rgb)
    if ($opacity) {
      if (abs($opacity) > 1)
        $opacity = 1.0;
        $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
        $output = 'rgb('.implode(",",$rgb).')';
        }
        //Return rgb(a) color string
        return $output;
}

/**
 * Implements hook_form_alter().
 */
function hagthemepubliccopy_form_islandora_solr_simple_search_form_alter(&$form, &$form_state, $form_id) {

  $link = array(
    '#markup' => l(t("Advanced Search"), "advanced-search", array('attributes' => array('class' => array('adv_search')))),
  );
  $form['simple']['advanced_link'] = $link;
  $form['simple']['islandora_simple_search_query']['#attributes']['placeholder'] = t("Search Repository");
  if (theme_get_setting('hagthemepubliccopy_search_text')) {
    $form['simple']['hagthemepubliccopy_text_search_text'] = array(
      '#weight' => -1,
      '#markup' => "<p class='simple-search-text'>" . theme_get_setting('hagthemepubliccopy_search_text') . "</p>",
    );
  }
  $menu_name = variable_get('menu_header_menu_links_source', 'menu-header-menu');
  $tree = menu_tree($menu_name);
  $form['simple']['hagthemepubliccopy_search_main_menu'] = array(
    '#weight' => 8,
    '#markup' => drupal_render($tree),
  );

  $menu_name = variable_get('menu_front-collection-links_links_source', 'menu-front-collection-links');
  $tree = menu_tree($menu_name);
  $form['simple']['hagthemepubliccopy_collection_main_menu'] = array(
    '#weight' => 9,
    '#markup' => drupal_render($tree),
  );
}

/**
 * Implements hook_preprocess().
 */
function hagthemepubliccopy_preprocess_islandora_basic_collection_grid(&$variables) {
  foreach ($variables['associated_objects_array'] as $key => $value) {
    $variables['associated_objects_array'][$key]['classes'] = array();
    if (in_array("islandora:collectionCModel", $value['object']->models)) {
      array_push($variables['associated_objects_array'][$key]['classes'], 'islandora-default-thumb');
    }
  }
}

/**
 * Implements hook_preprocess().
 *
 * Preprocess for legacy SPARQL collection views.
 *
 */
function hagthemepubliccopy_preprocess_islandora_basic_collection_wrapper(&$variables) {
  $obj = $variables['islandora_object'];
  if (module_exists('islandora_collection_search')) {
    $block = module_invoke('islandora_collection_search', 'block_view', 'islandora_collection_search');
    $variables['islandora_collection_search_block'] = render($block['content']);
  }
  if ($variables['islandora_object']['MEDIUM']){
    $pid = $variables['islandora_object']->id;
    $source = "<div><img src='/islandora/object/$pid/datastream/MEDIUM/view'/></div>";
    $form['collection_image'] = array(
      '#type' => 'item',
      '#markup' => "$source",
    );
    $variables['collection_image'] = drupal_render($form);
  }
  $models = $obj->{'models'};
  if (in_array("islandora:collectionCModel", $models)) {
    $block = module_invoke('dgi_ondemand', 'block_view', 'dgi_ondemand_latest_obj');
    $data = render($block['content']);
    if (!empty($data)) {
      $variables['islandora_latest_objects'] = $data;
    }
  }
}

/**
 * Implements hook_preprocess().
 *
 * Preprocess for solr driven collection views.
 *
 */
function hagthemepubliccopy_preprocess_islandora_objects_subset(&$variables) {
  if (module_exists('islandora_collection_search')) {
    $block = module_invoke('islandora_collection_search', 'block_view', 'islandora_collection_search');
    $variables['islandora_collection_search_block'] = render($block['content']);
  }
  $obj = menu_get_object('islandora_object', 2);
  $dc = $obj['DC']->content;
  $dc_object = DublinCore::importFromXMLString($dc);
  $variables['dc_array'] = isset($dc_object) ? $dc_object->asArray() : array();
  if ($obj['MEDIUM']) {
    $pid = $obj->id;
    $source = "<div><img src='/islandora/object/$pid/datastream/MEDIUM/view'/></div>";
    $form['collection_image'] = array(
      '#type' => 'item',
      '#markup' => "$source",
    );
    $variables['collection_image'] = drupal_render($form);
  }
  $models = $obj->{'models'};
  if (in_array("islandora:collectionCModel", $models)) {
    $block = module_invoke('dgi_ondemand', 'block_view', 'dgi_ondemand_latest_obj');
    $data = render($block['content']);
    if (!empty($data)) {
      $variables['islandora_latest_objects'] = $data;
    }
  }
}

/**
 * Implements hook_block_view_MODULE_DELTA_alter().
 */
function hagthemepubliccopy_block_view_islandora_solr_simple_alter(&$data, $block) {
  drupal_add_js(drupal_get_path('theme', 'hagthemepubliccopy') . '/js/clean_simple_search.js');
}

/**
 * Implements hook_islandora_solr_query_alter().
 */
function hagthemepubliccopy_islandora_solr_query_alter($islandora_solr_query) {
  // Remove objects with the content model islandora:collectionCModel
  // from the search results page.
  if (theme_get_setting('hagthemepubliccopy_omit')) {
    $path = current_path();
    $path_array = explode("/", $path);
    if (count($path_array) >= 2){
      if ($path_array[0] == "islandora" && $path_array[1] == "search") {
        $islandora_solr_query->{'solrParams'}['fq'][] = "-RELS_EXT_hasModel_uri_ms:info\:fedora/islandora\:collectionCModel";
      }
    }
  }
}

/**
 * Implements hook_form_alter().
 */
function hagthemepubliccopy_block_view_islandora_usage_stats_recent_activity_alter(&$data, $block) {
  foreach($data['content']['#items'] as $key => $value) {
    $pid = $value['data-pid'];
    $new_content = "<div class='new-collections-item-wrapper popular-resources'><a href='/islandora/object/$pid'>"
      . "<img src='/islandora/object/$pid/datastream/TN/view'></img></a>"
      . $data['content']['#items'][$key]['data'] . "</div>";
    $data['content']['#items'][$key]['data'] = $new_content;
  }
}
