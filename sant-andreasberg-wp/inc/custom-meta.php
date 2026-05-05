<?php
defined('ABSPATH') || exit;

/* =============================================
   CUSTOM META FIELDS: title, description, h1
   For posts, pages, categories and homepage
   ============================================= */

/* ---- Meta box for posts & pages ---- */
add_action('add_meta_boxes', function () {
    add_meta_box(
        'sa_seo_meta',
        __('SEO и мета-теги', 'sant-andreasberg'),
        'sa_seo_meta_box_html',
        ['post', 'page'],
        'normal',
        'high'
    );
});

function sa_seo_meta_box_html(WP_Post $post): void {
    wp_nonce_field('sa_seo_meta_save', 'sa_seo_meta_nonce');
    $title = get_post_meta($post->ID, 'sa_meta_title', true);
    $desc  = get_post_meta($post->ID, 'sa_meta_description', true);
    $h1    = get_post_meta($post->ID, 'sa_meta_h1', true);
    ?>
    <table class="form-table" style="max-width:900px">
      <tr>
        <th scope="row"><label for="sa_meta_h1"><?php esc_html_e('Заголовок H1', 'sant-andreasberg'); ?></label></th>
        <td>
          <input type="text" id="sa_meta_h1" name="sa_meta_h1" value="<?php echo esc_attr($h1); ?>" class="large-text">
          <p class="description"><?php esc_html_e('Заголовок H1 на странице (пусто = стандартный заголовок WordPress).', 'sant-andreasberg'); ?></p>
        </td>
      </tr>
      <tr>
        <th scope="row"><label for="sa_meta_title"><?php esc_html_e('Мета-заголовок (SEO)', 'sant-andreasberg'); ?></label></th>
        <td>
          <input type="text" id="sa_meta_title" name="sa_meta_title" value="<?php echo esc_attr($title); ?>" class="large-text">
          <p class="description"><?php esc_html_e('Заголовок в браузере и Google (пусто = стандарт WordPress).', 'sant-andreasberg'); ?></p>
          <p class="description sa-char-count" data-for="sa_meta_title" data-max="60">
            <span class="count">0</span>/60 <?php esc_html_e('символов', 'sant-andreasberg'); ?>
          </p>
        </td>
      </tr>
      <tr>
        <th scope="row"><label for="sa_meta_description"><?php esc_html_e('Мета-описание (SEO)', 'sant-andreasberg'); ?></label></th>
        <td>
          <textarea id="sa_meta_description" name="sa_meta_description" rows="3" class="large-text"><?php echo esc_textarea($desc); ?></textarea>
          <p class="description"><?php esc_html_e('Описание для сниппета Google (рекомендуется: 120–160 символов).', 'sant-andreasberg'); ?></p>
          <p class="description sa-char-count" data-for="sa_meta_description" data-max="160">
            <span class="count">0</span>/160 <?php esc_html_e('символов', 'sant-andreasberg'); ?>
          </p>
        </td>
      </tr>
    </table>
    <script>
    (function(){
      document.querySelectorAll('.sa-char-count').forEach(function(el){
        var forId = el.dataset.for;
        var max   = parseInt(el.dataset.max, 10);
        var field = document.getElementById(forId);
        var count = el.querySelector('.count');
        function update(){ count.textContent = (field.value||'').length; count.style.color = count.textContent > max ? '#c00' : ''; }
        if(field){ field.addEventListener('input', update); update(); }
      });
    })();
    </script>
    <?php
}

add_action('save_post', function (int $post_id) {
    if (
        !isset($_POST['sa_seo_meta_nonce']) ||
        !wp_verify_nonce($_POST['sa_seo_meta_nonce'], 'sa_seo_meta_save') ||
        defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ||
        !current_user_can('edit_post', $post_id)
    ) {
        return;
    }
    foreach (['title', 'description', 'h1'] as $key) {
        $field = 'sa_meta_' . $key;
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field(wp_unslash($_POST[$field])));
        }
    }
});

/* ---- Meta fields for categories ---- */
add_action('category_add_form_fields', 'sa_cat_meta_fields');
add_action('category_edit_form_fields', 'sa_cat_edit_meta_fields');
add_action('created_category', 'sa_save_cat_meta');
add_action('edited_category', 'sa_save_cat_meta');

function sa_cat_meta_fields(): void {
    wp_nonce_field('sa_cat_meta_save', 'sa_cat_meta_nonce');
    ?>
    <div class="form-field">
      <label for="sa_cat_h1"><?php esc_html_e('Заголовок H1', 'sant-andreasberg'); ?></label>
      <input type="text" name="sa_cat_h1" id="sa_cat_h1" value="">
    </div>
    <div class="form-field">
      <label for="sa_cat_title"><?php esc_html_e('Мета-заголовок (SEO)', 'sant-andreasberg'); ?></label>
      <input type="text" name="sa_cat_title" id="sa_cat_title" value="">
    </div>
    <div class="form-field">
      <label for="sa_cat_description_seo"><?php esc_html_e('Мета-описание (SEO)', 'sant-andreasberg'); ?></label>
      <textarea name="sa_cat_description_seo" id="sa_cat_description_seo" rows="3"></textarea>
      <p><?php esc_html_e('Отображается в поиске Google (рекомендуется 120–160 символов).', 'sant-andreasberg'); ?></p>
    </div>
    <?php
}

function sa_cat_edit_meta_fields(WP_Term $term): void {
    wp_nonce_field('sa_cat_meta_save', 'sa_cat_meta_nonce');
    $h1   = get_term_meta($term->term_id, 'sa_meta_h1', true);
    $title = get_term_meta($term->term_id, 'sa_meta_title', true);
    $desc  = get_term_meta($term->term_id, 'sa_meta_description', true);
    ?>
    <tr class="form-field">
      <th scope="row"><label for="sa_cat_h1"><?php esc_html_e('Заголовок H1', 'sant-andreasberg'); ?></label></th>
      <td><input type="text" name="sa_cat_h1" id="sa_cat_h1" value="<?php echo esc_attr($h1); ?>"></td>
    </tr>
    <tr class="form-field">
      <th scope="row"><label for="sa_cat_title"><?php esc_html_e('Мета-заголовок (SEO)', 'sant-andreasberg'); ?></label></th>
      <td><input type="text" name="sa_cat_title" id="sa_cat_title" value="<?php echo esc_attr($title); ?>"></td>
    </tr>
    <tr class="form-field">
      <th scope="row"><label for="sa_cat_description_seo"><?php esc_html_e('Мета-описание (SEO)', 'sant-andreasberg'); ?></label></th>
      <td>
        <textarea name="sa_cat_description_seo" id="sa_cat_description_seo" rows="3"><?php echo esc_textarea($desc); ?></textarea>
      </td>
    </tr>
    <?php
}

function sa_save_cat_meta(int $term_id): void {
    if (!isset($_POST['sa_cat_meta_nonce']) || !wp_verify_nonce($_POST['sa_cat_meta_nonce'], 'sa_cat_meta_save')) {
        return;
    }
    foreach (['h1' => 'sa_cat_h1', 'title' => 'sa_cat_title', 'description' => 'sa_cat_description_seo'] as $key => $field) {
        if (isset($_POST[$field])) {
            update_term_meta($term_id, 'sa_meta_' . $key, sanitize_text_field(wp_unslash($_POST[$field])));
        }
    }
}

/* ---- Homepage meta via Customizer ---- */
add_action('customize_register', function (WP_Customize_Manager $wp_customize) {
    $wp_customize->add_section('sa_homepage_meta', [
        'title'    => __('Главная страница — SEO', 'sant-andreasberg'),
        'priority' => 160,
    ]);
    foreach ([
        'sa_home_meta_h1'          => __('Заголовок H1 главной страницы', 'sant-andreasberg'),
        'sa_home_meta_title'       => __('Мета-заголовок главной страницы', 'sant-andreasberg'),
        'sa_home_meta_description' => __('Мета-описание главной страницы', 'sant-andreasberg'),
    ] as $id => $label) {
        $wp_customize->add_setting($id, ['sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh']);
        $wp_customize->add_control($id, ['label' => $label, 'section' => 'sa_homepage_meta', 'type' => 'text']);
    }
});
