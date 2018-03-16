<?php
/*
  Plugin Name: Post Slider
  Plugin URI: http://jexcore.com/
  Description: Post Slider With Left Side Image and Right Side Content.
  Author: Rajesh Mudaliar
  Version: 1.0
  Author URI: http://jexcore.com/
 */

add_shortcode('post_slider', 'xt_postSlider');

function xt_postSlider($attr) {

    ob_start();
    ?>
    <!--<link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__); ?>/bootstrap.min.css">-->
    <link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__); ?>/custom.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="<?php echo plugin_dir_url(__FILE__); ?>/bootstrap.min.js"></script>
    <style>
        .links a{text-decoration: none;}
        .date{font-size: 12px !important;font-weight: 600;margin-top: -10px;margin-bottom: 15px;}
        .fa-facebook{background-color: #469;}
        .fa-twitter{background-color: #09f;}
        .fa-pinterest{background-color: #c22;}
        .fa-linkedin{background-color: #07d;}
        .fa-linkedin{background-color: #07d;}
        .fa-google-plus{background-color: #d43;}
        .share-box i{display: inline-block;padding: 9px 15px;margin-right: 4px;margin-bottom: 4px;color: #ffffff;font-size: 12px;}
    </style>
    <div class="container">
        <?php
        $posts_per_page = 5;
        if (isset($attr['posts_per_page']) && $attr['posts_per_page'] != '') {
            $posts_per_page = $attr['posts_per_page'];
        }
        $category = '';
        if (isset($attr['category']) && $attr['category'] != '') {
            $category = $attr['category'];
        }

        $args = array(
            'posts_per_page' => $posts_per_page,
            'offset' => 0,
            'category' => 0,
            'category_name' => $category,
            'orderby' => 'date',
            'order' => 'DESC',
            'include' => '',
            'exclude' => '',
            'meta_key' => '',
            'meta_value' => '',
            'post_type' => 'post',
            'post_mime_type' => '',
            'post_parent' => '',
            'author' => '',
            'author_name' => '',
            'post_status' => 'publish',
            'suppress_filters' => true
        );

        $posts_array = get_posts($args);
        ?>    

        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->

            <div class="carousel-inner">
                <?php
                $i = 0;
                foreach ($posts_array as $value) {
                    $active = '';
                    if ($i == 1) {
                        $active = "active";
                    }
                    $postTitle = isset($value->post_title) ? $value->post_title : '';
                    $postDescription = isset($value->post_content) ? $value->post_content : '';
                    $postImage = get_the_post_thumbnail_url($value->ID);
                    $startDate = date('d M Y', strtotime(get_post_meta($value->ID, 'start_date', true)));
                    $endDate = date('d M Y', strtotime(get_post_meta($value->ID, 'end_date', true)));
                    $link = get_post_permalink($value->ID);

                    // Social Link
                    $facebook = get_post_meta($value->ID, 'facebook', true);
                    $Linked_in = get_post_meta($value->ID, 'linked_in', true);
                    $twitter = get_post_meta($value->ID, 'twitter', true);
                    $gplus = get_post_meta($value->ID, 'google_plus', true);

                    $socialLinks = '';
                    if (isset($facebook) && $facebook != '') {
                        $socialLinks .= '<a class="facebook-share" target="_blank" href="' . $facebook . '">
                                            <span class="share-box">
                                                <i class="fa fa-facebook"></i>
                                            </span>
                                         </a>';
                    } if (isset($Linked_in) && $Linked_in != '') {
                        $socialLinks .= '<a class="linkedin-share" target="_blank" href="' . $Linked_in . '">
                                            <span class="share-box">
                                                <i class="fa fa-linkedin"></i>
                                            </span>
                                         </a>';
                    } if (isset($twitter) && $twitter != '') {
                        $socialLinks .= '<a class="twitter-share" target="_blank" href="' . $twitter . '">
                                            <span class="share-box">
                                                <i class="fa fa-twitter"></i>
                                            </span>
                                       </a>';
                    } if (isset($gplus) && $gplus != '') {
                        $socialLinks .= '<a class="google-plus-share" target="_blank" href="' . $gplus . '">
                                            <span class="share-box">
                                                <i class="fa fa-google-plus"></i>
                                            </span>
                                         </a>';
                    }

                    echo '<div class="item ' . $active . '">
                                
                                    <div class="vc_col-md-8">

                                        <img src="' . $postImage . '" alt="Los Angeles" style="width:100%;">
                                    </div>

                                    <div class="vc_col-md-4">
                                        <a href="' . $link . '"><h3 style="font-weight:900;">' . $postTitle . '</h3></a>
                                        <p>' . wp_trim_words($postDescription, $num_words = 10, $more = null) . '</p>
                                        <table style="font-size:12px;">
                                            <tr>
                                                <th><b>Token</b></th>
                                                <th><b>Platform</b></th>
                                                <th><b>Price</b></th>
                                            </tr>
                                            <tr>
                                                <td>' . get_post_meta($value->ID, 'token', true) . '</td>
                                                <td>' . get_post_meta($value->ID, 'platform', true) . '</td>
                                                <td>' . get_post_meta($value->ID, 'price', true) . '</td>
                                            </tr>
                                        </table>
                                        <span class="date" style="float:left;">Start: ' . $startDate . '</span><span class="date" style="float:right;">End: ' . $endDate . '</span>     
                                        <br>
                                        <div class="wpb_animate_when_almost_visible wpb_fadeInUp fadeInUp vc_btn3-center wpb_start_animation animated" id="browse-btn">
                                            <a class="vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-rounded vc_btn3-style-modern vc_btn3-color-default" href="' . $link . '" title="">More ICO</a>
                                        </div>
                                        <br>
                                        <span class="links">
                                            ' . $socialLinks . '
                                        </span>
                                </div> 
                          </div>';
                    $i++;
                }
                ?>

            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="fa fa-angle-double-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="fa fa-angle-double-right"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

<?php } ?>