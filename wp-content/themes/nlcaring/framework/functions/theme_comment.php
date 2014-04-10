
<?php
/**
 * File Name: theme_comment.php
 *
 * Theme Custom Comment Template
 *
 */

if( !function_exists( 'theme_comment' ) ){
    function theme_comment($comment, $args, $depth){
        $GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
            case 'pingback' :
            case 'trackback' :
                ?>
                <li class="pingback">
                    <p><?php _e( 'Pingback:', 'framework' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'framework' ), ' ' ); ?></p>
                </li>
                <?php
                break;
            default :
                ?>
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">					
					<header class="participantsInfo">
						<h4 class="participantsName"><a href="<?php comment_author_url(); ?>"><?php printf( __('%s', 'framework'), sprintf( '%s', get_comment_author_link() ) ); ?> <span class="flag">(PH)</span>:</a></h4>
					</header>
					<div class="participantsMessage">
						 <?php comment_text(); ?>
                         <?php // comment_reply_link( array_merge( array('before' => ''), array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</div>
                <?php
                break;
        endswitch;
    }
}

?>