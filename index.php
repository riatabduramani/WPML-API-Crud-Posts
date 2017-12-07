<?php
/*
   Plugin Name: SEE University API
   Plugin URI: http://api.seeu.edu.mk
   Description: a plugin to create api for seeu
   Version: 1.0
   Author: Riat Abduramani
   License: GPL2
   */
 
require_once plugin_dir_path( __FILE__ ) . 'inc/MultilingualPost.class.php';

 	add_action( 'rest_api_init', function() {
        register_rest_route( 'seeu-api/v1', '/jobpost', array(
            'methods' => 'POST',
            'callback' => 'MultilingualPost::publish',
        ) );
     });

 	add_action( 'rest_api_init', function() {
        register_rest_route( 'seeu-api/v1', '/jobpost/(?P<id>\d+)', array(
            'methods' => 'DELETE',
            'callback' => 'MultilingualPost::delete',
        ) );
     });

 	add_action( 'rest_api_init', function() {
        register_rest_route( 'seeu-api/v1', '/jobpost/update/(?P<id>\d+)', array(
            'methods' => 'PUT',
            'callback' => 'MultilingualPost::update',
        ) );
     });