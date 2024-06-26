<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config["base_url"] = base_url();
$config["total_rows"] = 200;
$config["per_page"] = 20;
$config["uri_segment"] = 3;
$config['full_tag_open'] = '<div class="pagination_bar_sec"><nav aria-label="Page navigation"><ul class="pagination">';
$config['full_tag_close'] = '</ul></nav></div>';
$config['first_link'] = '&laquo; First';
$config['first_tag_open'] = '<li class="prev page">';
$config['first_tag_close'] = '</li>';
$config['last_link'] = 'Last &raquo;';
$config['last_tag_open'] = '<li class="next page">';
$config['last_tag_close'] = '</li>';
$config['next_link'] = 'Next &rarr;';
$config['next_tag_open'] = '<li class="next page">';
$config['next_tag_close'] = '</li>';
$config['prev_link'] = '&larr; Previous';
$config['prev_tag_open'] = '<li class="prev page">';
$config['prev_tag_close'] = '</li>';
$config['cur_tag_open'] = '<li class="active"><a href="">';
$config['cur_tag_close'] = '</a></li>';
$config['num_tag_open'] = '<li class="page">';
$config['num_tag_close'] = '</li>';
$config['anchor_class'] = 'follow_link';
