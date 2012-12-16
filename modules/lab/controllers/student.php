<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Student extends Public_Controller
{

    /**
     * The constructor
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        if($this->current_user->group_id != 2) {
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

    public function index() {
        // Build the page
        $this->template->title($this->module_details['name'])
            ->build('student/index', $this->data);
    }
    public function subject_register($id = 0)
    {
        // Build the page
        $this->template->title($this->module_details['name'])
            ->build('student/subject_register', $this->data);
    }

    public function create_practice() {

        $params = array(
            'stream' => 'subjects',
            'namespace' => 'streams',
        );
        $this->data->subjects = $this->streams->entries->get_entries($params);
        // Build the page
        $this->template->title($this->module_details['name'])
            ->build('practice/create_practice', $this->data);
    }

    public function download($id = 0) {
        $this->data->id = $id;
        // Build the page
        $this->load->helper('date');

        $this->template->title($this->module_details['name'])
            ->build('download', $this->data);
    }

    public function category($id = 0) {
        $this->data->id = $id;

        $this->load->config('config');
        $this->data->video_quality = $this->config->item('video_quality');
        $this->data->video_audio_lang = $this->config->item('video_audio_lang');
        $this->data->video_subtitles = $this->config->item('video_subtitles');

        $this->data->books_format = $this->config->item('books_format');
        $this->data->books_genre = $this->config->item('books_genre');

        $this->data->games_region = $this->config->item('games_region');
        $this->data->games_lang = $this->config->item('games_lang');
        $this->data->games_genre = $this->config->item('games_genre');

        $this->data->audio_genre = $this->config->item('audio_genre');

        $filter['where'] = '`category_id`='.$id;
        if(count($_POST) >0)
            $filter = $this->_filters($filter, $_POST);

        $filter['where'] = $filter['where'].' AND `category_id`='.$id;

        $this->data->where = $filter['where'];
        $this->data->checked = $filter['checked'];
        $this->data->selected = $filter['selected'];

        // Build the page
        $this->template->title($this->module_details['name'])
            ->build('category', $this->data);
    }

    public function create() {
        $params = array(
            'stream' => 'categories',
            'namespace' => 'streams',
            'paginate' => 'yes',
            'pag_segment' => 4,
            'sort' => 'ASC'
        );
        $this->data->categories = $this->streams->entries->get_entries($params);

        $params['stream'] = 'subcategories';
        $this->data->subcategories = $this->streams->entries->get_entries($params);

        $this->load->library('pagination');
        $this->data->pagination = create_pagination('downloads/subcategories', 6, 4);

        // Build the page
        $this->template->title($this->module_details['name'])
            ->append_js('module::create.js')
            ->build('create', $this->data);
    }

}

/* End of file faq.php */
