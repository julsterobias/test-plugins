<?php 
/**
 * 
 * 
 * admin_lpn_class
 * @since 1.0.0
 * 
 * 
 */


namespace lpn\admin;
use common\utils\lpnUtils;

if ( !function_exists( 'add_action' ) ){
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit();
}

if ( !function_exists( 'add_filter' ) ){
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit();
}

class lpnAdminClass extends lpnUtils {

    private int $max_post = 2;

    private array $post_types = ['post'];
    
    public function __construct()
    {
        //load assets
        add_action('admin_enqueue_scripts', [$this, 'load_assets']);

        //show admin notices
        add_action( 'admin_notices', [$this, 'show_notice'] );

    }

    public function load_assets()
    {
        wp_enqueue_style( 'lpn-admin-css', LPN_PLUGIN_URL . 'admin/assets/lpn.css', false, '1.0.0' );
    }

    public function get_latest_posts() {

        $posts = [
            'posts_per_page'    => $this->max_post,
            'post_type'         => $this->post_types,
            'order'             => 'DESC',
            'order_type'        => 'post_modified_gmt',
            'post_status'       => 'publish'
        ];

        return get_posts($posts);

    }

    public function show_notice()
    {
        $posts = $this->get_latest_posts();

        if (empty($posts)) {
            return;
        }

        $posts_titles = [];
        
        if (!empty($posts)) {
            foreach ($posts  as $post) {
                $edit_post_link = get_edit_post_link($post->ID);
                $posts_titles[] = [
                    'title'     => $post->post_title,
                    'edit_url'  => $edit_post_link
                ];
            }
        }
        $this->get_view('notice', ['path' => 'admin', 'posts' => $posts_titles]);

    }

}
?>