<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Booking extends Public_Controller
{

    public $data;

    /**
     * The constructor
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        if(!$this->current_user) {
            $this->session->set_flashdata('error', 'No tiene permisos para acceder al apartado solicitado.');
            redirect();
        }
        $this->load->driver('Streams');
    }

    /**
     * List all FAQs
     *
     * We are using the Streams API to grab
     * data from the faqs database. It handles
     * pagination as well.
     *
     * @access	public
     * @return	void
     */
    public function index()
    {
        $params = array(
            'stream' => 'subjects',
            'namespace' => 'streams',
            'where' => '`created_by`='.$this->current_user->id
        );
        $this->data->subjects = $this->streams->entries->get_entries($params);
        if(!$this->data->subjects['total']) {
            redirect('lab/tutor/create_subject');
        }
        // Build the page
        $this->template->title($this->module_details['name'])
            ->build('tutor/index', $this->data);
    }

    public function book_practice($date_id) {

        $params = array(
            'stream' => 'students',
            'namespace' => 'streams',
            'where' => '`created_by`='.$this->current_user->id
        );
        $students = $this->streams->entries->get_entries($params);

        foreach ($students['entries'] as $entry)
            $subjects[$entry['subject']['id']] = $entry['subject']['subject_name'];

        foreach ($subjects as $subject_id => $subject_name) {
            $params = array(
                'stream' => 'practices',
                'namespace' => 'streams',
                'where' => '`subject`='.$subject_id
            );

            $this->data['practices'] = $this->streams->entries->get_entries($params);
        }

        $params = array(
            'stream' => 'bookings',
            'namespace' => 'streams',
            'where' => '`created_by`='.$this->current_user->id
        );
        $booking = $this->streams->entries->get_entries($params);
        foreach ($booking['entries'] as $entry)
            $practices_booked[] = $entry['practice']['id'];
        $this->data['practices_booked'] = $practices_booked;

        $this->load->model('calendar/calendar_m');
        $date = $this->calendar_m->get_entry($date_id);
        $this->data['booking_date'] = $date->date_start;

        // Build the page
        $this->template->title($this->module_details['name'])
            ->build('booking/book_practice', $this->data);
    }

}

/* End of file faq.php */
