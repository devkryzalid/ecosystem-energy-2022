<?php

require_once(__DIR__ . '/../../../../wp-load.php');
require_once(__DIR__ . '/../vendor/autoload.php');

class ImportOldData
{
    private $old;

    private $lang = ['en' => 'wp_', 'fr' => 'wp_2_'];

    private $trans_equiv = [];

    private $post_type_equiv = ['blogs' => 'post', 'post' => 'news'];

    private $options;
    /**
     * Import all data from WP multisite
     *
     *
     * ## EXAMPLES
     *
     *     wp import_old_data
     *
     * @when after_wp_load
     */
    public function __invoke($args, $assoc_args)
    {
        WP_CLI::log('########################');
        WP_CLI::log('##### START SCRIPT #####');
        WP_CLI::log('########################');
        WP_CLI::log('');
        WP_CLI::log('Connection to the old DB');
        $this->old = new wpdb(OLD_DB_USER, OLD_DB_PASSWORD, OLD_DB_NAME, OLD_DB_HOST);
        $this->old->show_errors();

        foreach ($this->lang as $code => $prefixTable) {
            WP_CLI::log('GET OPTION FOR THIS SITE');
            $options = $this->old->get_results('SELECT * FROM ' . $prefixTable . 'options WHERE option_name = "siteurl"');
            $this->options = $options[0];
            $this->oldImport($prefixTable, 'post', $code);
            $this->oldImport($prefixTable, 'blogs', $code);
        }
        WP_CLI::log('');
        WP_CLI::success('#############################');
        WP_CLI::success('##### Import Data !!!!! #####');
        WP_CLI::success('#############################');
    }

    private function oldImport(string $prefixTable = 'wp_', string $post_type = 'post', string $lang = 'en')
    {
        global $wpdb;

        WP_CLI::log('GET ALL ' . $post_type . ' FOR SYNC WITH OLD DATA IN ' . $lang);
        $all_posts = $this->old->get_results('SELECT * FROM ' . $prefixTable . 'posts LEFT JOIN ' . $prefixTable . 'postmeta ON ' . $prefixTable . 'posts.ID = ' . $prefixTable . 'postmeta.post_id WHERE post_type = "' . $post_type . '" AND post_status = "publish" AND meta_key = "translation_equiv"');

        foreach ($all_posts as $old_post) {

            WP_CLI::log("CREATE AND SAVE POST IN NEW WEBSITE");
            $post = get_page_by_title($old_post->post_title, OBJECT, $this->post_type_equiv[$post_type]);
            $existe_id = false;

            if (!empty($post)) {
                WP_CLI::log('---- THIS ' . $this->post_type_equiv[$post_type] . ' ALREADY EXIST WITH THIS TITLE :' . $post->post_title);
                $existe_id = $post->ID;
            }
            $args = [
                'post_content'   => $old_post->post_content,
                'post_date'      => $old_post->post_date,
                'post_modified'  => $old_post->post_modified,
                'comment_status' => $old_post->comment_status,
                'post_name'      => $old_post->post_name,

            ];
            $new_post = $this->createPost($old_post->post_title, $this->post_type_equiv[$post_type], $args, $existe_id);

            // create array for translation for second language
            if ($lang == 'en') {
                if (!empty($old_post->meta_value)) {
                    WP_CLI::log("SAVE TRANSLATION RELATION IN ARRAY");
                    $this->trans_equiv[$old_post->ID] = ['trans' => $old_post->meta_value, 'new' => $new_post];
                }
                $url_old_site = 'https://ecosystem-energy.com';
            } elseif ($lang == 'fr') {
                $url_old_site = 'https://ecosystem-energy.com/fr';
                $original_id = false;
                if (!empty($old_post->meta_value) && isset($this->trans_equiv[$old_post->meta_value])) {
                    $original_id = $this->trans_equiv[$old_post->meta_value]['new'];
                }
                $this->synchTranslation($original_id, $new_post, $this->post_type_equiv[$post_type]);
            }

            WP_CLI::log('---- GET IMAGE FOR ' . ucfirst($this->post_type_equiv[$post_type]) . ' : ' . $old_post->post_title);
            $meta_thumbnail = $this->old->get_results('SELECT * FROM ' . $prefixTable . 'postmeta WHERE ' . $prefixTable . 'postmeta.post_id = ' . $old_post->ID . ' AND meta_key = "_thumbnail_id"', ARRAY_A);
            if (!empty($meta_thumbnail)) {
                $old_thumbnail = $this->old->get_results('SELECT * FROM ' . $prefixTable . 'posts WHERE post_type = "attachment" AND ID = ' . $meta_thumbnail[0]['meta_value'], ARRAY_A);
            }
            
            if (empty($old_thumbnail)) {
                $old_thumbnail = $this->old->get_results('SELECT * FROM ' . $prefixTable . 'posts WHERE post_type = "attachment" AND post_parent = ' . $old_post->ID, ARRAY_A);
            }
            if (!empty($old_thumbnail)) {
                $args = array(
                    'post_type' => 'attachment',
                    's'         => $old_thumbnail[0]['post_name'],
                );
                $attach_exist = new WP_Query($args);
                $attach_exist = $wpdb->get_results('SELECT * FROM wp_posts WHERE (LOWER(post_title) LIKE LOWER("%' . $old_thumbnail[0]["post_name"] . '%") OR LOWER(post_name) LIKE LOWER("%'. $old_thumbnail[0]['post_name'] . '%")) AND post_type = "attachment"', ARRAY_A);

                if (empty($attach_exist)) {
                    $old_thumbnail_url = $old_thumbnail[0]['guid'];
                    if (strpos($old_thumbnail_url, "http") === 0) {
                        $old_thumbnail_url = str_replace($this->options->option_value, $url_old_site, $old_thumbnail_url);
                    } else {
                        $old_thumbnail_url = $url_old_site . $old_thumbnail_url;
                    }
                    $mediaID = $this->uploadMedia($old_thumbnail_url, $new_post, ucfirst($this->post_type_equiv[$post_type]));
                } else {
                    update_post_meta($new_post, '_thumbnail_id', $attach_exist[0]['ID']);
                }
            }
        }
    }
    private function synchTranslation ($primary_id = false, string $secondary_id, string $post_type) {
        global $sitepress;
        WP_CLI::log('');
        WP_CLI::log('--- SET LANGUAGE FR FOR ' . $post_type);
        $trid = NULL;
        if ($primary_id) {
            WP_CLI::log('--- LINK TRANSLATION BETWEEN ' . $primary_id . ' => ' . $secondary_id);
            $trid = $sitepress->get_element_trid($primary_id, 'post_' . $post_type);
        }
        $sitepress->set_element_language_details($secondary_id, 'post_' . $post_type, $trid, 'fr');
        WP_CLI::log('--- Translation is end');
    }

    private function createPost($title, $post_type, $content = [], $post_id = false)
    {
        $args_new_post = [
            'post_status'    => 'publish',
            'post_type'      => $post_type,
            'comment_status' => 'closed',
            'post_title'     => wp_strip_all_tags($title)
        ];
        if ($post_id) {
            $args_new_post['ID'] = $post_id;
        }
        $id_post = wp_insert_post(array_merge($content, $args_new_post));

        return $id_post;
    }

    private function uploadMedia($image_url, $post_id = null, $folder = null)
    {
        $media = media_sideload_image($image_url, 0);

        $attachments = get_posts([
            'post_type'   => 'attachment',
            'post_status' => null,
            'post_parent' => 0,
            'orderby'     => 'post_date',
            'order'       => 'DESC'
        ]);
        if ($post_id) {
            update_post_meta($post_id, '_thumbnail_id', $attachments[0]->ID);
        }
        if ($folder) {
            $term_id = $this->createFolders($folder);
            wp_add_object_terms($attachments[0]->ID, (int)$term_id, 'wf_attachment_folders');
        }
        return $attachments[0]->ID;
    }

    /**
     * Create folders for admin filter
     */
    public function createFolders(string $term)
    {
        // Get the existing term name for Image
        $term_id = term_exists($term, 'wf_attachment_folders');
        if (!$term_id) {
            // Create the term instead
            $newTerm = wp_insert_term($term, 'wf_attachment_folders');
            if ($newTerm && !is_wp_error($newTerm)) {
                $term_id = $newTerm;
            }
        }

        return $term_id['term_id'];
    }
}
