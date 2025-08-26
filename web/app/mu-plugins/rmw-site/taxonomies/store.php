<?php 
add_action('init', function () {
  register_taxonomy('store_type', ['store'], [
    'label' => 'Store Types',
    'public' => true,
    'hierarchical' => false,
    'rewrite' => ['slug' => 'store-type'],
    'show_in_rest' => true,
  ]);
});
