<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tutor extends Public_Controller
{

    /**
     * The constructor
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        if($this->current_user->group_id != 3) {
            $this->session->set_flashdata('error', 'No tiene permisos para acceder al apartado solicitado.');
            redirect();
        }
        $this->load->driver('Streams');
        //$this->template->append_css('module::downloads.css');
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
        $this->data = new stdClass();
        $this->data->subjects = $this->streams->entries->get_entries($params);
        if(!$this->data->subjects['total']) {
            redirect('lab/tutor/create_subject');
        }
        // Build the page
        $this->template->title($this->module_details['name'])
            ->build('tutor/index', $this->data);
    }

    public function create_subject() {

        // Build the page
        $this->template->title($this->module_details['name'])
            ->build('tutor/create_subject', $this->data);
    }

}

/* End of file faq.php */
