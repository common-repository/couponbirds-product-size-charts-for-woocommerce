<?php

defined('ABSPATH') or die('Access denied');

class CouponBirds_Size_Chart_Show
{
    public function __construct()
    {
    }

    public function cb_size_chart_tab_show($tabs)
    {
        global $post;
        $charts = $this->cb_size_chart_tab($post->ID);
        foreach ($charts as $chart) {
            $cb_chart_label = get_post_meta($chart, 'cb_chart_label', true);
            if (!$cb_chart_label) {
                $cb_chart_label = 'Size Chart';
            }
            $tabs['cb-chart-tab' . $chart] = [
                'title' => $cb_chart_label,
                'priority' => 99,
                'callback' => array($this, 'cb_chart_tab_content'),
                'cb_chart_id' => $chart
            ];
        }
        return $tabs;
    }

    private function cb_size_chart_tab($product_id)
    {
        $charts = [];
        $size_charts = $this->select_posts('cb_chart_products', $product_id, '0');
        foreach ($size_charts as $item) {
            $charts[] = $item->ID;
        }
        $categories = wc_get_product_term_ids($product_id, 'product_cat');
        foreach ($categories as $category) {
            $size_charts = $this->select_posts('cb_chart_categories', $category, '0');
            foreach ($size_charts as $item) {
                $charts[] = $item->ID;
            }
        }
        return array_keys(array_flip($charts));
    }

    private function cb_size_chart_modal($product_id)
    {
        $charts = [];
        $size_charts = $this->select_posts('cb_chart_products', $product_id, '1');
        foreach ($size_charts as $item) {
            $charts[] = $item->ID;
        }
        $categories = wc_get_product_term_ids($product_id, 'product_cat');
        foreach ($categories as $category) {
            $size_charts = $this->select_posts('cb_chart_categories', $category, '1');
            foreach ($size_charts as $item) {
                $charts[] = $item->ID;
            }
        }
        return array_keys(array_flip($charts));
    }

    private function select_posts($key, $value, $position)
    {
        return get_posts([
            'post_type' => 'cb-size-charts',
            'numberposts' => -1,
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => 'cb_chart_position',
                    'value' => $position,
                    'compare' => '='
                ],
                [
                    'relation' => 'OR',
                    [
                        'key' => $key,
                        'value' => '[' . $value . ']',
                        'compare' => 'LIKE'
                    ],
                    [
                        'key' => $key,
                        'value' => '[' . $value . ',',
                        'compare' => 'LIKE'
                    ],
                    [
                        'key' => $key,
                        'value' => ',' . $value . ']',
                        'compare' => 'LIKE'
                    ],
                    [
                        'key' => $key,
                        'value' => ',' . $value . ',',
                        'compare' => 'LIKE'
                    ]
                ]
            ]
        ]);
    }

    public function cb_chart_tab_content($key, $tab)
    {
        if (!isset($tab['cb_chart_id'])) {
            return;
        }
        $chart = $tab['cb_chart_id'];
        $cb_chart_style = get_post_meta($chart, 'cb_chart_style', true);
        $cb_chart_tab = get_post_meta($chart, 'cb_chart_tab', true);
        $cb_chart_link_show = get_post_meta($chart, 'cb_chart_link_show', true);
        if (!$cb_chart_style) {
            $cb_chart_style = 'default';
        }
        if (!$cb_chart_tab) {
            $cb_chart_tab = '[[""]]';
        }
        $tab_data = json_decode($cb_chart_tab);
        ?>
        <div class="cb-chart-table-container">
            <table
                    class="cb-show-tab cb-size-chart-style-<?php echo $cb_chart_style ?>">
                <?php
                foreach ($tab_data as $row) {
                    ?>
                    <tr>
                        <?php
                        foreach ($row as $item) {
                            ?>
                            <td><?php echo $item ?></td>
                            <?php
                        }
                        ?>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php if ($cb_chart_link_show) { ?>
                <p class="cb-link-show-p">Power By <a target="_blank"
                                                      href="https://www.couponbirds.com/size-charts">CouponBirds</a>
                </p>
            <?php }?>
        </div>
        <?php
    }

    public function cb_size_chart_modal_show()
    {
        wp_enqueue_script('coupon-birds-size-chart-show-modal-script');
        global $post;
        $charts = $this->cb_size_chart_modal($post->ID);
        if ($charts) {
            ?>
            <div class="button-wrapper">
                <?php
                foreach ($charts as $chart) {
                    $cb_chart_style = get_post_meta($chart, 'cb_chart_style', true);
                    $cb_chart_tab = get_post_meta($chart, 'cb_chart_tab', true);
                    $cb_chart_link_show = get_post_meta($chart, 'cb_chart_link_show', true);
                    $cb_chart_label = get_post_meta($chart, 'cb_chart_label', true);
                    if (!$cb_chart_label) {
                        $cb_chart_label = 'Size Chart';
                    }
                    if (!$cb_chart_style) {
                        $cb_chart_style = 'default';
                    }
                    if (!$cb_chart_tab) {
                        $cb_chart_tab = '[[""]]';
                    }
                    ?>
                    <a href="javascript:void(0);"
                       class="cb-show-modal-button"
                       data-tab='<?php echo $cb_chart_tab ?>'
                       data-style="<?php echo $cb_chart_style ?>"
                       data-link-show="<?php echo $cb_chart_link_show ?>"
                       value="<?php echo $chart ?>"><?php echo $cb_chart_label ?></a>
                    <?php
                } ?>
            </div>
            <div id="cb-size-chart-modal" class="cb-size-chart-modal" hidden>
                <div id="cb-size-chart-modal-overly"></div>
                <div class="cb-size-chart-container">
                    <table id="cb-modal-show-tab">
                    </table>
                    <div id="cb-link-show-div"></div>
                </div>
            </div>
            <?php
        }
    }
}
