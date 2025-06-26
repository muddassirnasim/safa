<?php
/**
 * Title: A 404 page
 * Slug: safa/404
 * Inserter: no
 */

declare( strict_types = 1 );
?>

<!-- wp:group {"tagName":"main","style":{"spacing":{"blockGap":"0","padding":{"bottom":"4rem"}}},"layout":{"type":"constrained"}} -->
<main class="wp-block-group" style="padding-bottom:4rem"><!-- wp:paragraph {"align":"center","style":{"spacing":{"margin":{"bottom":"30px"}}}} -->
<p class="has-text-align-center" style="margin-bottom:30px"><?php esc_html_e( 'Oops! That page can\'t be found. Please enter your desired keyword to search area.', 'safa' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:search {"label":"Search","showLabel":false,"buttonText":"Search","buttonPosition":"button-inside","buttonUseIcon":true} /--></main>
<!-- /wp:group -->
