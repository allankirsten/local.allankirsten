<?php
/* All products dropdown */
function product_settings_field($settings, $value) {   
    $attr = array("post_type"=>"product", "orderby"=>"name", "order"=>"asc", 'posts_per_page'   => -1);
    $categories = get_posts($attr); 
    $dependency = vc_generate_dependencies_attributes($settings);
    $data = '<select name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'">';
    foreach($categories as $val) {
        $selected = '';
        if ($value!=='' && $val->ID === $value) {
             $selected = ' selected="selected"';
        }
        $data .= '<option class="'.$val->ID.'" value="'.$val->ID.'"'.$selected.'>'.$val->post_title.'</option>';
    }
    $data .= '</select>';
    return $data;
}
add_shortcode_param('product' , 'product_settings_field');
/* All products dropdown */
function products_settings_field($settings, $value) {   
    $attr = array("post_type"=>"product", "orderby"=>"name", "order"=>"asc", 'posts_per_page'   => -1);
    $categories = get_posts($attr); 
    $dependency = vc_generate_dependencies_attributes($settings);
    $data = '<input type="text" value="'.$value.'" name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select anps_custom_val '.$settings['param_name'].' '.$settings['type'].'" id="anps_custom_prod">';
    $data .= '<div class="anps_custom_wrapper"><ul class="anps_custom_vals">';
    $insterted_vals = explode(',', $value);
    foreach($categories as $val) {
        if( in_array($val->ID, $insterted_vals) ) {
          $data .= '<li data-val="'.$val->ID.'">'.$val->post_title.'<button>×</button></li>';
        }
    }
    $data .= '</ul>'; 
    $data .= '<ul class="anps_custom">';
    foreach($categories as $val) {
        $selected = '';
        if( in_array($val->ID, $insterted_vals) ) {
          $selected = ' class="selected"';
        }
        $data .= '<li' . $selected . ' data-val="'.$val->ID.'">'.$val->post_title.'</li>';
    }
    $data .= '</ul></div>';
    return $data;
}
add_shortcode_param('products' , 'products_settings_field', get_template_directory_uri() . "/anps-framework/woocommerce/anps_vc_woocommerce/assets/js/functions.js");
/* Portfolio categories new parameter */
function product_category_settings_field($settings, $value) {   
    $categories = get_terms('product_cat'); 
    $dependency = vc_generate_dependencies_attributes($settings);
    $data = '<select name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'">';
    foreach($categories as $val) {
        $selected = '';
        if ($value!=='' && $val->slug === $value) {
             $selected = ' selected="selected"';
        }
        $data .= '<option class="'.$val->slug.'" value="'.$val->slug.'"'.$selected.'>'.$val->name.'</option>';
    }
    $data .= '</select>';
    return $data;
}
add_shortcode_param('product_category' , 'product_category_settings_field');
/* Portfolio categories new parameter */
function product_categories_settings_field($settings, $value) {   
    $categories = get_terms('product_cat'); 
    $dependency = vc_generate_dependencies_attributes($settings);
    $data = '<input type="text" value="'.$value.'" name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input anps_custom_val wpb-select '.$settings['param_name'].' '.$settings['type'].'" id="anps_custom_cat">';
    $data .= '<div class="anps_custom_wrapper"><ul class="anps_custom_vals">';
    $insterted_vals = explode(',', $value);
    foreach($categories as $val) {
        if( in_array($val->term_id, $insterted_vals) ) {
          $data .= '<li data-val="'.$val->term_id.'">'.$val->name.'<button>×</button></li>';
        }
    }
    $data .= '</ul>'; 
    $data .= '<ul class="anps_custom">';
    foreach($categories as $val) {
        $selected = '';
        if( in_array($val->term_id, $insterted_vals) ) {
          $selected = ' class="selected"';
        }
        $data .= '<li' . $selected . ' data-val="'.$val->term_id.'">'.$val->name.'</li>';
    }
    $data .= '</ul></div>';
    return $data;
}
add_shortcode_param('product_categories' , 'product_categories_settings_field', get_template_directory_uri() . "/anps-framework/woocommerce/anps_vc_woocommerce/assets/js/functions.js");
/* Portfolio attributes */
function product_attribute_settings_field($settings, $value) {   
    global $woocommerce;
    $categories = $woocommerce->get_attribute_taxonomies();
    $dependency = vc_generate_dependencies_attributes($settings);
    $data = '<select name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'">';
    $data .= '<option class="0">'.__("All", 'constructo').'</option>';
    foreach($categories as $val) {
        $selected = '';
        if ($value!=='' && $val->attribute_name === $value) {
             $selected = ' selected="selected"';
        }
        $data .= '<option class="'.$val->attribute_name.'" value="'.$val->attribute_name.'"'.$selected.'>'.$val->attribute_name.'</option>';
    }
    $data .= '</select>';
    return $data;
}
add_shortcode_param('product_attribute' , 'product_attribute_settings_field');
/* VC order tracking */
vc_map( array(
   "name" => __("Order Tracking", ANPS_PLUGIN_LANG),
   "base" => "woocommerce_order_tracking",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "category" => __('Woocommerce', ANPS_PLUGIN_LANG), 
   "show_settings_on_create" => false
  )
);
/* END VC order tracking */
/* VC recent products */
vc_map( array(
   "name" => __("Recent Products", ANPS_PLUGIN_LANG),
   "base" => "recent_products",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "category" => __('Woocommerce', ANPS_PLUGIN_LANG),
   "params" => array(
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Number of products", ANPS_PLUGIN_LANG),
         "param_name" => "per_page",
         "value" => "12"  
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Number of columns", ANPS_PLUGIN_LANG),
         "param_name" => "columns",
         "value" => "4" 
       ), 
       array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Order by", ANPS_PLUGIN_LANG),
         "param_name" => "orderby",
         "value" => array(__("Date", 'constructo')=>'date', __("None", 'constructo')=>'none', __("ID", 'constructo')=>'ID', __("Title", 'constructo')=>'title', __("Name", 'constructo')=>'name', __("Modified", 'constructo')=>'modified', __("Random", 'constructo')=>'rand')  
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Order", ANPS_PLUGIN_LANG),
         "param_name" => "order",
         "value" => array(__("Descending", 'constructo')=>'desc', __("Ascending", 'constructo')=>'asc') 
       )
    )
));
/* END VC recent products */
/* VC featured products */
vc_map( array(
   "name" => __("Featured Products", ANPS_PLUGIN_LANG),
   "base" => "featured_products",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "category" => __('Woocommerce', ANPS_PLUGIN_LANG),
   "params" => array(
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Number of products", ANPS_PLUGIN_LANG),
         "param_name" => "per_page",
         "value" => "12"  
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Number of columns", ANPS_PLUGIN_LANG),
         "param_name" => "columns",
         "value" => "4" 
       ), 
       array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Order by", ANPS_PLUGIN_LANG),
         "param_name" => "orderby",
         "value" => array(__("Date", 'constructo')=>'date', __("None", 'constructo')=>'none', __("ID", 'constructo')=>'ID', __("Title", 'constructo')=>'title', __("Name", 'constructo')=>'name', __("Modified", 'constructo')=>'modified', __("Random", 'constructo')=>'rand')  
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Order", ANPS_PLUGIN_LANG),
         "param_name" => "order",
         "value" => array(__("Descending", 'constructo')=>'desc', __("Ascending", 'constructo')=>'asc') 
       )
    )
));
/* END VC featured products */
/* VC product */
vc_map( array(
   "name" => __("Product", ANPS_PLUGIN_LANG),
   "base" => "product",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "category" => __('Woocommerce', ANPS_PLUGIN_LANG),
   "params" => array(
       array(
         "type" => "product",
         "holder" => "div",
         "heading" => __("Product", ANPS_PLUGIN_LANG),
         "param_name" => "id",
      )
      )
    )
);
/* END VC product */
/* VC products */
vc_map( array(
   "name" => __("Products", ANPS_PLUGIN_LANG),
   "base" => "products",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "category" => __('Woocommerce', ANPS_PLUGIN_LANG),
   "params" => array(
       array(
         "type" => "products",
         "holder" => "div",
         "heading" => __("Products", ANPS_PLUGIN_LANG),
         "param_name" => "ids",
         "description" => "Click on the select box to open a dropdown and click on each individual product to add it, click on 'x' inside the select box to remove the product"  
      ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Order by", ANPS_PLUGIN_LANG),
         "param_name" => "orderby",
         "value" => array(__("Title", 'constructo')=>'title', __("None", 'constructo')=>'none', __("ID", 'constructo')=>'ID', __("Date", 'constructo')=>'date', __("Name", 'constructo')=>'name', __("Modified", 'constructo')=>'modified', __("Random", 'constructo')=>'rand')  
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Order", ANPS_PLUGIN_LANG),
         "param_name" => "order",
         "value" => array(__("Ascending", 'constructo')=>'asc', __("Descending", 'constructo')=>'desc') 
       )
      )
    )
);
/* END VC products */
/* VC add to cart */
vc_map( array(
   "name" => __("Add to Cart", ANPS_PLUGIN_LANG),
   "base" => "add_to_cart",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "category" => __('Woocommerce', ANPS_PLUGIN_LANG),
   "params" => array(
       array(
         "type" => "product",
         "holder" => "div",
         "heading" => __("Product", ANPS_PLUGIN_LANG),
         "param_name" => "id" 
      ),
      array(
        "type" => "textfield",
        "holder" => "div",
        "heading" => __("Style", ANPS_PLUGIN_LANG),
        "param_name" => "style",
        "description" => "Enter css style" 
      )
      )
    )
);
/* END VC add to cart */
/* VC product categories */
vc_map( array(
   "name" => __("Product Categories", ANPS_PLUGIN_LANG),
   "base" => "product_categories",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "category" => __('Woocommerce', ANPS_PLUGIN_LANG),
   "params" => array(
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Number of products", ANPS_PLUGIN_LANG),
         "param_name" => "number",
         "value" => "12"
      ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Number of columns", ANPS_PLUGIN_LANG),
         "param_name" => "columns",
         "value" => "4"
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Parent", ANPS_PLUGIN_LANG),
         "param_name" => "parent",
         "value" => "0", 
         "description" => "Set the parent paramater to 0 to only display top level categories. Set ids to a comma separated list of category ids to only show those." 
       ),
       array(
         "type" => "product_categories",
         "holder" => "div",
         "heading" => __("Categories", ANPS_PLUGIN_LANG),
         "param_name" => "ids", 
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Order by", ANPS_PLUGIN_LANG),
         "param_name" => "orderby",
         "value" => array(__("Name", 'constructo')=>'name', __("None", 'constructo')=>'none', __("ID", 'constructo')=>'ID', __("Date", 'constructo')=>'date', __("Title", 'constructo')=>'title', __("Modified", 'constructo')=>'modified', __("Random", 'constructo')=>'rand')  
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Order", ANPS_PLUGIN_LANG),
         "param_name" => "order",
         "value" => array(__("Ascending", 'constructo')=>'asc', __("Descending", 'constructo')=>'desc') 
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Hide empty", ANPS_PLUGIN_LANG),
         "param_name" => "hide_empty",
         "value" => array(__("Yes", 'constructo')=>'1', __("No", 'constructo')=>'0') 
       )
      )
    )
);
/* END VC product categories */
/* VC product category */
vc_map( array(
   "name" => __("Product Category", ANPS_PLUGIN_LANG),
   "base" => "product_category",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "category" => __('Woocommerce', ANPS_PLUGIN_LANG),
   "params" => array(
       array(
         "type" => "product_category",
         "holder" => "div",
         "heading" => __("Category", ANPS_PLUGIN_LANG),
         "param_name" => "category"
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Number of products", ANPS_PLUGIN_LANG),
         "param_name" => "per_page",
         "value" => "12", 
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Number of columns", ANPS_PLUGIN_LANG),
         "param_name" => "columns",
         "value" => "4", 
        ),
        array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Order by", ANPS_PLUGIN_LANG),
         "param_name" => "orderby",
         "value" => array(__("Title", 'constructo')=>'title', __("None", 'constructo')=>'none', __("ID", 'constructo')=>'ID', __("Date", 'constructo')=>'date', __("Name", 'constructo')=>'name', __("Modified", 'constructo')=>'modified', __("Random", 'constructo')=>'rand') 
        ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Order", ANPS_PLUGIN_LANG),
         "param_name" => "order",
         "value" => array(__("Ascending", 'constructo')=>'asc', __("Descending", 'constructo')=>'desc') 
       )   
      )
    )
);
/* END VC product category */
/* VC woocommerce cart */
vc_map( array(
   "name" => __("Cart", ANPS_PLUGIN_LANG),
   "base" => "woocommerce_cart",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "category" => __('Woocommerce', ANPS_PLUGIN_LANG), 
   "show_settings_on_create" => false
  )
);
/* END VC woocommerce cart */
/* VC woocommerce checkout */
vc_map( array(
   "name" => __("Checkout", ANPS_PLUGIN_LANG),
   "base" => "woocommerce_checkout",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo",
   "category" => __('Woocommerce', ANPS_PLUGIN_LANG), 
   "show_settings_on_create" => false
  )
);
/* END VC woocommerce checkout */
/* VC woocommerce order tracking */
vc_map( array(
   "name" => __("Order Tracking", ANPS_PLUGIN_LANG),
   "base" => "woocommerce_order_tracking",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo",
   "category" => __('Woocommerce', ANPS_PLUGIN_LANG), 
   "show_settings_on_create" => false
  )
);
/* END VC woocommerce order tracking */
/* VC woocommerce my account */
vc_map( array(
   "name" => __("My Account", ANPS_PLUGIN_LANG),
   "base" => "woocommerce_my_account",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo",
   "category" => __('Woocommerce', ANPS_PLUGIN_LANG),
   "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Number of orders", ANPS_PLUGIN_LANG),
         "param_name" => "order_count",
         "value" => "15", 
         "description" => "You can specify the number of orders to show (use -1 to display all orders)." 
       )
      )
  )
);
/* END VC woocommerce my account */
/* VC add to cart url */
vc_map( array(
   "name" => __("Add to cart URL", ANPS_PLUGIN_LANG),
   "base" => "add_to_cart_url",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "category" => __('Woocommerce', ANPS_PLUGIN_LANG),
   "params" => array(
       array(
         "type" => "product",
         "holder" => "div",
         "heading" => __("Product", ANPS_PLUGIN_LANG),
         "param_name" => "id" 
      )
      )
    )
);
/* END VC add to cart url */
/* VC product page */
vc_map( array(
   "name" => __("Product Page", ANPS_PLUGIN_LANG),
   "base" => "product_page",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "category" => __('Woocommerce', ANPS_PLUGIN_LANG),
   "params" => array(
       array(
         "type" => "product",
         "holder" => "div",
         "heading" => __("Product", ANPS_PLUGIN_LANG),
         "param_name" => "id",
      )
      )
    )
);
/* END VC product page */
/* VC sale products */
vc_map( array(
   "name" => __("Sale Products", ANPS_PLUGIN_LANG),
   "base" => "sale_products",
   "icon" => "icon-wpb-woo",
   "class" => "wp_woo", 
   "category" => __('Woocommerce', ANPS_PLUGIN_LANG),
   "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Number of products", ANPS_PLUGIN_LANG),
         "param_name" => "per_page",
         "value" => "12", 
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Number of columns", ANPS_PLUGIN_LANG),
         "param_name" => "columns",
         "value" => "4", 
        ),
        array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Order by", ANPS_PLUGIN_LANG),
         "param_name" => "orderby",
         "value" => "title", 
        ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Order by", ANPS_PLUGIN_LANG),
         "param_name" => "orderby",
         "value" => array(__("Title", 'constructo')=>'title', __("None", 'constructo')=>'none', __("ID", 'constructo')=>'ID', __("Date", 'constructo')=>'date', __("Name", 'constructo')=>'name', __("Modified", 'constructo')=>'modified', __("Random", 'constructo')=>'rand')  
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Order", ANPS_PLUGIN_LANG),
         "param_name" => "order",
         "value" => array(__("Ascending", 'constructo')=>'asc', __("Descending", 'constructo')=>'desc') 
       )
      )
    )
);
/* END VC sale products */
/* VC top rated products */
vc_map( array(
   "name" => __("Top Rated Products", ANPS_PLUGIN_LANG),
   "base" => "top_rated_products",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "category" => __('Woocommerce', ANPS_PLUGIN_LANG),
   "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Number of products", ANPS_PLUGIN_LANG),
         "param_name" => "per_page",
         "value" => "12", 
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Number of columns", ANPS_PLUGIN_LANG),
         "param_name" => "columns",
         "value" => "4", 
        ),
        array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Order by", ANPS_PLUGIN_LANG),
         "param_name" => "orderby",
         "value" => array(__("Title", 'constructo')=>'title', __("None", 'constructo')=>'none', __("ID", 'constructo')=>'ID', __("Date", 'constructo')=>'date', __("Name", 'constructo')=>'name', __("Modified", 'constructo')=>'modified', __("Random", 'constructo')=>'rand')  
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Order", ANPS_PLUGIN_LANG),
         "param_name" => "order",
         "value" => array(__("Ascending", 'constructo')=>'asc', __("Descending", 'constructo')=>'desc') 
       )   
      )
    )
);
/* END VC top rated products */
/* VC best selling products */
vc_map( array(
   "name" => __("Best Selling Products", ANPS_PLUGIN_LANG),
   "base" => "best_selling_products",
   "icon" => "icon-wpb-woo",
   "class" => "wp_woo", 
   "category" => __('Woocommerce', ANPS_PLUGIN_LANG),
   "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Number of products", ANPS_PLUGIN_LANG),
         "param_name" => "per_page",
         "value" => "12", 
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Number of columns", ANPS_PLUGIN_LANG),
         "param_name" => "columns",
         "value" => "4", 
        )   
      )
    )
);
/* END VC best selling products */
/* VC related products */
vc_map( array(
   "name" => __("Related Products", ANPS_PLUGIN_LANG),
   "base" => "related_products",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "category" => __('Woocommerce', ANPS_PLUGIN_LANG),
   "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Number of products", ANPS_PLUGIN_LANG),
         "param_name" => "per_page",
         "value" => "12", 
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Number of columns", ANPS_PLUGIN_LANG),
         "param_name" => "columns",
         "value" => "4", 
        ),
        array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Order by", ANPS_PLUGIN_LANG),
         "param_name" => "orderby",
         "value" => array(__("Title", 'constructo')=>'title', __("None", 'constructo')=>'none', __("ID", 'constructo')=>'ID', __("Date", 'constructo')=>'date', __("Name", 'constructo')=>'name', __("Modified", 'constructo')=>'modified', __("Random", 'constructo')=>'rand')  
       )  
      )
    )
);
/* END VC related products */
/* VC product attribute */
vc_map( array(
   "name" => __("Product Attribute", ANPS_PLUGIN_LANG),
   "base" => "product_attribute",
   "icon" => "icon-wpb-woo", 
   "class" => "wp_woo", 
   "category" => __('Woocommerce', ANPS_PLUGIN_LANG),
   "params" => array(
      array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Number of attributes", ANPS_PLUGIN_LANG),
         "param_name" => "per_page",
         "value" => "12", 
       ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Number of columns", ANPS_PLUGIN_LANG),
         "param_name" => "columns",
         "value" => "4", 
        ),
        array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Order by", ANPS_PLUGIN_LANG),
         "param_name" => "orderby",
         "value" => array(__("Title", 'constructo')=>'title', __("None", 'constructo')=>'none', __("ID", 'constructo')=>'ID', __("Date", 'constructo')=>'date', __("Name", 'constructo')=>'name', __("Modified", 'constructo')=>'modified', __("Random", 'constructo')=>'rand')  
       ),
       array(
         "type" => "dropdown",
         "holder" => "div",
         "heading" => __("Order", ANPS_PLUGIN_LANG),
         "param_name" => "order",
         "value" => array(__("Ascending", 'constructo')=>'asc', __("Descending", 'constructo')=>'desc') 
       ),
       array(
         "type" => "product_attribute",
         "holder" => "div",
         "heading" => __("Attribute", ANPS_PLUGIN_LANG),
         "param_name" => "attribute" 
        ),
       array(
         "type" => "textfield",
         "holder" => "div",
         "heading" => __("Filter", ANPS_PLUGIN_LANG),
         "param_name" => "filter" 
        )
      )
    )
);
/* END VC product attribute */