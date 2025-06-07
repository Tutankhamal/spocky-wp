<?php
/**
 * YouTube API Integration
 */

/**
 * Get YouTube channel data
 */
function spocky_get_youtube_channel_data() {
    $channel_id = get_option('spocky_youtube_channel_id', 'UCSPC6X4M-tVPeK4IZMbK5aw');
    $api_key = get_option('spocky_youtube_api_key', '');
    
    if (empty($api_key)) {
        return false;
    }
    
    // Check transient first
    $channel_data = get_transient('spocky_youtube_channel_data');
    if ($channel_data !== false) {
        return $channel_data;
    }
    
    // Fetch channel data
    $url = "https://www.googleapis.com/youtube/v3/channels?part=statistics,snippet,contentDetails&id={$channel_id}&key={$api_key}";
    $response = wp_remote_get($url);
    
    if (is_wp_error($response)) {
        return false;
    }
    
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    if (empty($data['items'][0])) {
        return false;
    }
    
    $channel_data = $data['items'][0];
    
    // Set transient for 1 hour
    set_transient('spocky_youtube_channel_data', $channel_data, HOUR_IN_SECONDS);
    
    return $channel_data;
}

/**
 * Get YouTube videos
 */
function spocky_get_youtube_videos($count = 10, $exclude_shorts = true) {
    $channel_data = spocky_get_youtube_channel_data();
    $api_key = get_option('spocky_youtube_api_key', '');
    
    if (empty($channel_data) || empty($api_key)) {
        return array();
    }
    
    // Check transient first
    $videos = get_transient('spocky_youtube_videos');
    if ($videos !== false) {
        return $videos;
    }
    
    $playlist_id = $channel_data['contentDetails']['relatedPlaylists']['uploads'];
    
    // Fetch playlist items
    $url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet,contentDetails&maxResults=50&playlistId={$playlist_id}&key={$api_key}";
    $response = wp_remote_get($url);
    
    if (is_wp_error($response)) {
        return array();
    }
    
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    if (empty($data['items'])) {
        return array();
    }
    
    $videos = array();
    foreach ($data['items'] as $item) {
        $title = $item['snippet']['title'];
        
        // Skip shorts if needed
        if ($exclude_shorts && stripos($title, '#shorts') !== false) {
            continue;
        }
        
        $videos[] = array(
            'id' => $item['contentDetails']['videoId'],
            'title' => $title,
            'thumbnail' => $item['snippet']['thumbnails']['high']['url'],
            'published_at' => $item['snippet']['publishedAt'],
            'url' => "https://www.youtube.com/watch?v=" . $item['contentDetails']['videoId']
        );
        
        if (count($videos) >= $count) {
            break;
        }
    }
    
    // Set transient for 1 hour
    set_transient('spocky_youtube_videos', $videos, HOUR_IN_SECONDS);
    
    return $videos;
}

/**
 * Get YouTube live stream
 */
function spocky_get_youtube_live() {
    $channel_id = get_option('spocky_youtube_channel_id', 'UCSPC6X4M-tVPeK4IZMbK5aw');
    $api_key = get_option('spocky_youtube_api_key', '');
    
    if (empty($api_key)) {
        return false;
    }
    
    // Check transient first
    $live_data = get_transient('spocky_youtube_live');
    if ($live_data !== false) {
        return $live_data;
    }
    
    // Search for live streams
    $url = "https://www.googleapis.com/youtube/v3/search?part=snippet&channelId={$channel_id}&eventType=live&type=video&key={$api_key}";
    $response = wp_remote_get($url);
    
    if (is_wp_error($response)) {
        return false;
    }
    
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    if (empty($data['items'])) {
        // No live stream, get latest video instead
        $videos = spocky_get_youtube_videos(1);
        if (!empty($videos)) {
            $live_data = array(
                'id' => $videos[0]['id'],
                'title' => $videos[0]['title'],
                'thumbnail' => $videos[0]['thumbnail'],
                'is_live' => false
            );
        } else {
            return false;
        }
    } else {
        $live_data = array(
            'id' => $data['items'][0]['id']['videoId'],
            'title' => $data['items'][0]['snippet']['title'],
            'thumbnail' => $data['items'][0]['snippet']['thumbnails']['high']['url'],
            'is_live' => true
        );
    }
    
    // Set transient for 5 minutes
    set_transient('spocky_youtube_live', $live_data, 5 * MINUTE_IN_SECONDS);
    
    return $live_data;
}

/**
 * AJAX handler for YouTube data
 */
function spocky_ajax_youtube_data() {
    $action = isset($_GET['youtube_action']) ? sanitize_text_field($_GET['youtube_action']) : '';
    $count = isset($_GET['count']) ? intval($_GET['count']) : 10;
    
    $response = array('success' => false);
    
    switch ($action) {
        case 'channel':
            $channel_data = spocky_get_youtube_channel_data();
            if ($channel_data) {
                $response = array(
                    'success' => true,
                    'data' => array(
                        'title' => $channel_data['snippet']['title'],
                        'description' => $channel_data['snippet']['description'],
                        'thumbnail' => $channel_data['snippet']['thumbnails']['high']['url'],
                        'statistics' => $channel_data['statistics']
                    )
                );
            }
            break;
            
        case 'videos':
            $videos = spocky_get_youtube_videos($count);
            if (!empty($videos)) {
                $response = array(
                    'success' => true,
                    'data' => $videos
                );
            }
            break;
            
        case 'live':
            $live_data = spocky_get_youtube_live();
            if ($live_data) {
                $response = array(
                    'success' => true,
                    'data' => $live_data
                );
            }
            break;
    }
    
    wp_send_json($response);
}
add_action('wp_ajax_spocky_youtube_data', 'spocky_ajax_youtube_data');
add_action('wp_ajax_nopriv_spocky_youtube_data', 'spocky_ajax_youtube_data');
