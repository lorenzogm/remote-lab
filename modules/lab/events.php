<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Sample Events Class
 *
 * @package     PyroCMS
 * @subpackage  Sample Module
 * @category    events
 * @author      PyroCMS Dev Team
 */
class Events_Lab
{
    protected $ci;

    public function __construct()
    {
        $this->ci =& get_instance();

        // register the public_controller event when this file is autoloaded
        Events::register('streams_post_insert_entry', array($this, 'create_booking'));
    }

    // this will be triggered by the Events::trigger('public_controller') code in Public_Controller.php
    public function create_booking($post)
    {
        if($this->ci->uri->segment(1) != 'admin') {
            $this->ci->db->where('date_start', $post['insert_data']['booking_date']);
            $result = $this->ci->db->get('calendar');

            $this->ci->db->where('id', $result->row('id'));
            if(!$this->ci->db->delete('c_i_events_list'))
                log_message('error', 'Delete entry in c_i_events_list');

            $this->ci->db->where('date_start', $post['insert_data']['booking_date']);
            if(!$this->ci->db->delete('calendar'))
                log_message('error', 'Delete entry in c_i_events_list');
        }

        // you can load a model or etc here if you like using $this->ci->load();
        return 'The streams_post_insert_entry has ran';
    }

}
/* End of file events.php */