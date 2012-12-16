<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Lab extends Module
{

    public $version = '1.21.216';

    public function info()
    {
        return array(
            'name' => array(
                'en' => 'Lab'
            ),
            'description' => array(
                'en' => 'Lab'
            ),
            'frontend' => true,
            'backend' => true,
            'menu' => 'content',
        );
    }

    public function install()
    {
        // We're using the streams API to
        // do data setup.

        return true;
    }

    public function uninstall()
    {

        return true;
    }

    public function upgrade($old_version)
    {
        $CI =& get_instance();

        $CI->db->select_max('id');
        $result = $CI->db->get('c_i_events_list');
        $stream_id = $result->row('id');
        if($stream_id == null)
            $stream_id = 1;
        else
            ++$stream_id;

        $CI->db->select_max('id');
        $result = $CI->db->get('calendar');
        $calendar_id = $result->row('id');
        if($calendar_id == null)
            $calendar_id = 1;
        else
            ++$calendar_id;

        $year = date("Y");
        $m = date("m");
        $d = date("d") + 1;

        $calendar = array();
        $c_i_events_list = array();

        for ($month = $m; $month <= 12; ++$month) {

            for ($day = $d; $day <= 31; ++$day) {
                if(checkdate($month, $day, $year)) {

                    for($hour = 0; $hour <= 22; $hour++) {
                        $hour_end = $hour + 2;

                        if($hour_end == '24')
                            $hour_end = 0;
                        $calendar[] = array(
                            'id' => $calendar_id,
                            'date_start' => $year.'-'.$month.'-'.$day.' '.$hour.':00:00',
                            'date_end' => $year.'-'.$month.'-'.$day.' '.$hour_end.':00:00',
                            'restricted_to' => 2,
                            'category' => 2,
                            'item_type' => 1,
                            'recurrence' => 'once',
                            'stream_entry_id' => $stream_id,
                            'created_on' => time(),
                            'updated_on' => NULL,
                            'created_by' => 1
                        );
                        $c_i_events_list[] = array(
                            'id' => $stream_id,
                            'created' => $year.'-'.$m.'-'.$d.' 00:00:00',
                            'updated' => null,
                            'created_by' => 1,
                            'ordering_count' => $stream_id,
                            'title' => 'Free',
                            'description' => 'Free'
                        );
                        ++$calendar_id;
                        ++$stream_id;
                        ++$hour;
                    }
                }

            }
        }

        if (
            ! $this->db->insert_batch('calendar', $calendar)
            OR
            ! $this->db->insert_batch('c_i_events_list', $c_i_events_list)
        )
        {
            return FALSE;
        }
        // Your Upgrade Logic
        return true;
    }

    public function help()
    {
        // Return a string containing help info
        // You could include a file and return it here.
        return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
    }

}