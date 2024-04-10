<div class="notice notice-success lpn-notices is-dismissible">
    <h3><?php esc_html_e('Last Modified Posts','latest-post-notices'); ?></h3>
    <ul>
        <?php 
        if (!empty($data['posts'])): 
            foreach ($data['posts'] as $post):    
        ?>
        <li><?php echo esc_html($post['title']); ?> <a href="<?php echo esc_attr($post['edit_url']); ?>" target="__blank"><span class="dashicons dashicons-external"></span></a></li>
        <?php 
            endforeach;
        endif; ?>
    </ul>
</div>