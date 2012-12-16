<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Practice extends Public_Controller
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
    public function index($id = 0)
    {
        $this->data->id = $id;
        // Build the page
        $this->template->title($this->module_details['name'])
            ->build('practice/index', $this->data);
    }

    public function create_practice() {

        $params = array(
            'stream' => 'subjects',
            'namespace' => 'streams',
        );
        $this->data = new stdClass();
        $this->data->subjects = $this->streams->entries->get_entries($params);

        $this->load->library('assets');
        $this->assets->add_asset_group('jquery-ui', '1.9.2');
        $this->assets->add_asset_group('jquery-ui.timepicker', '1.9.2');

        // Build the page
        $this->template->title($this->module_details['name'])
            ->build('practice/create_practice', $this->data);
    }

}

/* End of file faq.php */
