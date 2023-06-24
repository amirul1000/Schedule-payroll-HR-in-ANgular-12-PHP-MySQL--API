<?php

/**
 * Author: Amirul Momenin
 * Desc:Customer_services Model
 */
class Customer_services_model extends CI_Model
{

    protected $customer_services = 'customer_services';

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Get customer_services by id
     *
     * @param $id -
     *            primary key to get record
     *            
     */
    function get_customer_services($id)
    {
        $result = $this->db->get_where('customer_services', array(
            'id' => $id
        ))->row_array();
        if (! (array) $result) {
            $fields = $this->db->list_fields('customer_services');
            foreach ($fields as $field) {
                $result[$field] = '';
            }
        }
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Get all customer_services
     */
    function get_all_customer_services()
    {
        $this->db->order_by('id', 'desc');
        $result = $this->db->get('customer_services')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Get limit customer_services
     *
     * @param $limit -
     *            limit of query , $start - start of db table index to get query
     *            
     */
    function get_limit_customer_services($limit, $start)
    {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $result = $this->db->get('customer_services')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Count customer_services rows
     */
    function get_count_customer_services()
    {
        $result = $this->db->from("customer_services")->count_all_results();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Get all users-customer_services
     */
    function get_all_users_customer_services()
    {
        $this->db->order_by('id', 'desc');
        $this->db->where('users_id', $this->session->userdata('id'));
        $result = $this->db->get('customer_services')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Get limit users-customer_services
     *
     * @param $limit -
     *            limit of query , $start - start of db table index to get query
     *            
     */
    function get_limit_users_customer_services($limit, $start)
    {
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $start);
        $this->db->where('customer_id', $this->session->userdata('id'));
        $result = $this->db->get('customer_services')->result_array();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * Count users-customer_services rows
     */
    function get_count_users_customer_services()
    {
        $this->db->where('customer_id', $this->session->userdata('id'));
        $result = $this->db->from("customer_services")->count_all_results();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $result;
    }

    /**
     * function to add new customer_services
     *
     * @param $params -
     *            data set to add record
     *            
     */
    function add_customer_services($params)
    {
        $this->db->insert('customer_services', $params);
        $id = $this->db->insert_id();
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $id;
    }

    /**
     * function to update customer_services
     *
     * @param $id -
     *            primary key to update record,$params - data set to add record
     *            
     */
    function update_customer_services($id, $params)
    {
        $this->db->where('id', $id);
        $status = $this->db->update('customer_services', $params);
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $status;
    }

    /**
     * function to delete customer_services
     *
     * @param $id -
     *            primary key to delete record
     *            
     */
    function delete_customer_services($id)
    {
        $status = $this->db->delete('customer_services', array(
            'id' => $id
        ));
        $db_error = $this->db->error();
        if (! empty($db_error['code'])) {
            echo 'Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message'];
            exit();
        }
        return $status;
    }
}
