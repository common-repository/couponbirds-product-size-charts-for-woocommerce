<?php

defined('ABSPATH') or die('Access denied');

class CouponBirds_Size_Chart_MetaBox
{
    public function cb_size_chart_tab($post)
    {
        wp_enqueue_script('coupon-birds-size-chart-description-script');
        $templates = get_option('coupon_birds_size_chart_options')['template'];
        $tab_meta = get_post_meta($post->ID, 'cb_chart_tab', true);
        if (!$tab_meta) {
            $tab_meta = '[[""]]';
        }
        ?>
        <input id="cb-table-data" type="hidden" name="cb_chart_tab"
               value='<?php echo $tab_meta ?>'>
        <label>
            <select id="cb-chart-template-select">
                <option value='<?php echo $tab_meta ?>'>Original</option>
                <?php
                foreach ($templates as $template) {
                    ?>
                    <option value='<?php echo $template['data'] ?>'><?php echo $template['name'] ?></option>
                    <?php
                } ?>
            </select>
        </label>
        <div class="cb-size-chart-table-container">
            <table id="cb-size-chart-table">
            </table>
        </div>
        <?php
    }

    public function cb_size_chart_select_style($post)
    {
        $style_meta = get_post_meta($post->ID, 'cb_chart_style', true);
        if (!$style_meta) {
            $style_meta = 'default';
        }
        ?>
        <label>
            <input id="cb-table-style" type="hidden" name="cb_chart_style"
                   value='<?php echo $style_meta ?>'>
            <select id="cb-table-style-select">
                <option value="default">Default</option>
                <option value="minimalistic">Minimalistic</option>
                <option value="classic">Classic</option>
                <option value="modern">Modern</option>
            </select>
        </label>
        <div class="cb-size-chart-preview-container">
            <table id="cb-size-chart-preview">
            </table>
        </div>
        <?php
    }

    public function cb_size_chart_link_show($post)
    {
        $link_show = get_post_meta($post->ID, 'cb_chart_link_show', true);
        ?>
        <label>
            <input id="cb-link-show" type="hidden" name="cb_chart_link_show"
                   value='<?php echo $link_show ?>'>
            <input id="cb-link-show-checkbox" type="checkbox">
            Enable this option to apply plugin's url. If you like our plugin and would like to support us, please enable this checkbox.
        </label>
        <?php
    }

    public function cb_size_chart_select_product($post)
    {
        $products = wc_get_products(
            [
                'limit' => -1
            ]
        );
        $items = [];
        foreach ($products as $product) {
            $items[$product->id] = $product->name;
        }
        $products_meta = get_post_meta($post->ID, 'cb_chart_products', true);
        if (!$products_meta) {
            $products_meta = "[]";
        }
        $products = json_decode($products_meta);
        ?>
        <div>
            <div class="wc-products-has-selected">
                <select id="cb-product-select" name="cb_chart_products[]" multiple="multiple">
                    <?php
                    foreach ($items as $key => $value) {
                        ?>
                        <option <?php echo in_array($key, $products) ? 'selected' : '' ?>
                                value="<?php echo $key ?>"><?php echo $value ?></option>
                        <?php
                    } ?>
                </select>
            </div>
        </div>
        <?php
    }

    public function cb_size_chart_select_category($post)
    {
        $categories = get_terms('product_cat', []);
        $items = [];
        foreach ($categories as $category) {
            $items[$category->term_id] = $category->name;
        }
        $categories_meta = get_post_meta($post->ID, 'cb_chart_categories', true);
        if (!$categories_meta) {
            $categories_meta = "[]";
        }
        $categories = json_decode($categories_meta);
        ?>
        <div>
            <div class="wc-categories-has-selected">
                <select id="cb-category-select" name="cb_chart_categories[]" multiple="multiple">
                    <?php
                    foreach ($items as $key => $value) {
                        ?>
                        <option <?php echo in_array($key, $categories) ? 'selected' : '' ?>
                                value="<?php echo $key ?>"><?php echo $value ?></option>
                        <?php
                    } ?>
                </select>
            </div>
        </div>
        <?php
    }

    public function cb_size_chart_select_position($post)
    {
        $position_meta = get_post_meta($post->ID, 'cb_chart_position', true);
        if (!$position_meta) {
            $position_meta = "0";
        }
        ?>
        <div>
            <input id="cb-position-data" type="hidden"
                   value="<?php print $position_meta ?>">
            <label>
                <select id="cb-chart-position-select" name="cb_chart_position">
                    <option value="0">Additional Tab</option>
                    <option value="1">Modal Popup</option>
                </select>
            </label>
        </div>
        <?php
    }

    public function cb_size_chart_label($post)
    {
        $label_meta = get_post_meta($post->ID, 'cb_chart_label', true);
        ?>
        <label>
            <input type="text"
                   name="cb_chart_label"
                   value='<?php echo $label_meta ?>'>
            <i>Input a label to show in a product page.</i>
        </label>
        <?php
    }
}
