<?php

// Add shortcode for sibling categories in WooCommerce (simple version)
function display_sibling_categories_shortcode() {

    // Initialisation de la sortie
    $output = '';

    // Seulement sur les pages des catégories de produits
    if ( is_product_category() ) {
        $main_term = get_queried_object();
        $args_query = array(
            'taxonomy'   => 'product_cat', 
            'hide_empty' => false, 
            'parent'   => $main_term->parent
        );

        if ( $main_term->parent != 0 ) {
            $terms_array = array();

            // Parcourez les WP_Term Objects
            foreach ( get_terms( $args_query ) as $term ) {
                if( $term->term_id != $main_term->term_id ) {
                    // Ajouter chaque nom de term (lié) à un tableau
                    $terms_array[] = sprintf( '<a href="%s">%s</a>', get_term_link( $term->term_id, 'product_cat' ), $term->name );
                }
            }

            // Si le tableau n'est pas vide, créez la sortie
            if ( ! empty( $terms_array ) ) {
                $output = '<p>À découvrir également : ' . implode( ', ', $terms_array ) . '</p>';
            }
        }
    }
    return $output;
}

add_shortcode( 'display_sibling_categories', 'display_sibling_categories_shortcode' );

?>
