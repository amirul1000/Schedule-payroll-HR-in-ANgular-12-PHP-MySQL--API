<?php

/**
 * Author: Amirul Momenin
 * Desc:Customer_services Controller
 *
 */
class Customer_services extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('pagination');
        $this->load->library('Customlib');
        $this->load->helper(array(
            'cookie',
            'url'
        ));
        $this->load->database();
        $this->load->model('Customer_services_model');
        if (! $this->session->userdata('validated')) {
            redirect('member/login/index');
        }
    }

    /**
     * Index Page for this controller.
     *
     * @param $start -
     *            Starting of customer_services table's index to get query
     *            
     */
    function index($start = 0)
    {
        $limit = 10;
        $data['customer_services'] = $this->Customer_services_model->get_limit_users_customer_services($limit, $start);
        // pagination
        $config['base_url'] = site_url('member/customer_services/index');
        $config['total_rows'] = $this->Customer_services_model->get_count_users_customer_services();
        $config['per_page'] = 10;
        // Bootstrap 4 Pagination fix
        $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '<span aria-hidden="true"></span></span></li>';
        $config['next_tag_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();

        $data['_view'] = 'member/customer_services/index';
        $this->load->view('layouts/member/body', $data);
    }

    /**
     * Save customer_services
     *
     * @param $id -
     *            primary key to update
     *            
     */
    function save($id = - 1)
    {
        $created_at = "";
        $updated_at = "";

        if ($id <= 0) {
            $created_at = date("Y-m-d H:i:s");
        } else if ($id > 0) {
            $updated_at = date("Y-m-d H:i:s");
        }

        $params = array(
            'services_id' => html_escape($this->input->post('services_id')),
            'customer_id' => $this->session->userdata('id'),
            'cost' => html_escape($this->input->post('cost')),
            'start_date' => html_escape($this->input->post('start_date')),
            'start_time' => html_escape($this->input->post('start_time')),
			'end_time' => html_escape($this->input->post('end_time')),
            'status' => 'booked',
            'created_at' => $created_at,
            'updated_at' => $updated_at
        );

        if ($id > 0) {
            unset($params['created_at']);
        }
        if ($id <= 0) {
            unset($params['updated_at']);
        }
        $data['id'] = $id;
        // update
        if (isset($id) && $id > 0) {
            $data['customer_services'] = $this->Customer_services_model->get_customer_services($id);
            if (isset($_POST) && count($_POST) > 0) {
                $this->Customer_services_model->update_customer_services($id, $params);
                $this->session->set_flashdata('msg', 'Customer_services has been updated successfully');
                redirect('member/customer_services/index');
            } else {
                $data['_view'] = 'member/customer_services/form';
                $this->load->view('layouts/member/body', $data);
            }
        } // save
        else {
            if (isset($_POST) && count($_POST) > 0) {
                $customer_services_id = $this->Customer_services_model->add_customer_services($params);
                $this->session->set_flashdata('msg', 'Customer_services has been saved successfully');
                redirect('member/customer_services/index');
            } else {
                $data['customer_services'] = $this->Customer_services_model->get_customer_services(0);
                $data['_view'] = 'member/customer_services/form';
                $this->load->view('layouts/member/body', $data);
            }
        }
    }

    /**
     * Details customer_services
     *
     * @param $id -
     *            primary key to get record
     *            
     */
    function details($id)
    {
        $data['customer_services'] = $this->Customer_services_model->get_customer_services($id);
        $data['id'] = $id;
        $data['_view'] = 'member/customer_services/details';
        $this->load->view('layouts/member/body', $data);
    }

    /**
     * Deleting customer_services
     *
     * @param $id -
     *            primary key to delete record
     *            
     */
    function remove($id)
    {
        $customer_services = $this->Customer_services_model->get_customer_services($id);

        // check if the customer_services exists before trying to delete it
        if (isset($customer_services['id'])) {
            $this->Customer_services_model->delete_customer_services($id);
            $this->session->set_flashdata('msg', 'Customer_services has been deleted successfully');
            redirect('member/customer_services/index');
        } else
            show_error('The customer_services you are trying to delete does not exist.');
    }

    /**
     * get_cost
     *
     * @param
     *            service_id
     */
    function get_cost()
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('id', $this->input->post('services_id'));
        $result = $this->db->get('services')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        echo json_encode($result);
    }

    /**
     * Search customer_services
     *
     * @param $start -
     *            Starting of customer_services table's index to get query
     */
    function search($start = 0)
    {
        if (! empty($this->input->post('key'))) {
            $key = $this->input->post('key');
            $_SESSION['key'] = $key;
        } else {
            $key = $_SESSION['key'];
        }

        $limit = 10;
        $this->db->like('id', $key, 'both');
        $this->db->or_like('services_id', $key, 'both');
        $this->db->or_like('customer_id', $key, 'both');
        $this->db->or_like('cost', $key, 'both');
        $this->db->or_like('start_date', $key, 'both');
        $this->db->or_like('start_time', $key, 'both');
        $this->db->or_like('end_time', $key, 'both');
        $this->db->or_like('assigned_to_staff_users_id', $key, 'both');
        $this->db->or_like('status', $key, 'both');
        $this->db->or_like('created_at', $key, 'both');
        $this->db->or_like('updated_at', $key, 'both');

        $this->db->order_by('id', 'desc');

        $this->db->limit($limit, $start);
        $data['customer_services'] = $this->db->get('customer_services')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }

        // pagination
        $config['base_url'] = site_url('member/customer_services/search');
        $this->db->reset_query();
        $this->db->like('id', $key, 'both');
        $this->db->or_like('services_id', $key, 'both');
        $this->db->or_like('customer_id', $key, 'both');
        $this->db->or_like('cost', $key, 'both');
        $this->db->or_like('start_date', $key, 'both');
        $this->db->or_like('start_time', $key, 'both');
        $this->db->or_like('end_time', $key, 'both');
        $this->db->or_like('assigned_to_staff_users_id', $key, 'both');
        $this->db->or_like('status', $key, 'both');
        $this->db->or_like('created_at', $key, 'both');
        $this->db->or_like('updated_at', $key, 'both');

        $config['total_rows'] = $this->db->from("customer_services")->count_all_results();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        $config['per_page'] = 10;
        // Bootstrap 4 Pagination fix
        $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '<span aria-hidden="true"></span></span></li>';
        $config['next_tag_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();

        $data['key'] = $key;
        $data['_view'] = 'member/customer_services/index';
        $this->load->view('layouts/member/body', $data);
    }

    /**
     * Export customer_services
     *
     * @param $export_type -
     *            CSV or PDF type
     */
    function export($export_type = 'CSV')
    {
        if ($export_type == 'CSV') {
            // file name
            $filename = 'customer_services_' . date('Ymd') . '.csv';
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$filename");
            header("Content-Type: application/csv; ");
            // get data
            $this->db->order_by('id', 'desc');
            $customer_servicesData = $this->Customer_services_model->get_all_customer_services();
            // file creation
            $file = fopen('php://output', 'w');
            $header = array(
                "Id",
                "Services Id",
                "Customer Id",
                "Cost",
                "Start Date",
                "Start Time",
                "End Time",
                "Assigned To Staff Users Id",
                "Status",
                "Created At",
                "Updated At"
            );
            fputcsv($file, $header);
            foreach ($customer_servicesData as $key => $line) {
                fputcsv($file, $line);
            }
            fclose($file);
            exit();
        } else if ($export_type == 'Pdf') {
            $this->db->order_by('id', 'desc');
            $customer_services = $this->db->get('customer_services')->result_array();
            // get the HTML
            ob_start();
            include (APPPATH . 'views/member/customer_services/print_template.php');
            $html = ob_get_clean();
            require_once FCPATH . 'vendor/autoload.php';
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($html);
            $mpdf->Output();
            exit();
        }
    }
}
//End of Customer_services controller