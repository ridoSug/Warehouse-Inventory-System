<?php

function check_login()
{
    //check session id
    $CI = get_instance();
    if (!($CI->session->has_userdata('wh_id'))) {
        if (!$CI->input->is_ajax_request()) {
            redirect(site_url());
        } else {
            echo json_encode(array(
                'code' => 500,
                'message' => 'SESSION_EXPIRED'
            ));
        }
    }
}
