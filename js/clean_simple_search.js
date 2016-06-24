/**
 * @file
 *   Prevents the 'search all keywords' in basic search from being searched.
 */
(function ($) {
  Drupal.behaviors.ir7_prevent_search_all = {
    attach: function (context, settings) {
      $('#islandora-solr-simple-search-form').submit(function(event) {
        if ($('#edit-islandora-simple-search-query').val() == 'Search this repository') {
          $('#edit-islandora-simple-search-query').val('');
        }
      });
    }
  }
})(jQuery);

