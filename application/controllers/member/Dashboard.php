<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        try {
            if ($this->session->userdata('user') == '' or $this->session->userdata('user') == null) {
                redirect('auth');
            }
        } catch (Exception $e) {
            $this->session->unset_userdata(array('user' => ''));
            $this->session->sess_destroy();
            redirect('auth');
        }
        $this->load->model('member/M_member', "member");
        $this->load->model('M_log', "LOG");
    }

    function index()
    {
        // echo "ok";
    }

    function dashboard()
    {
        $data = array(
            'user' => $this->member->get_user_by_ses(),
            'sidebar_one' => "RCASH",
            'sidebar_two' => "Dashboard",
            'breadcrumb' => "",
            'icon_subheader' => "subheader-icon fal fa-dashboard",
            'bc_1' => "DASHBOARD",
            'bc_2' => "Laporan Saldo, Pemasanan dan lain lain akan tampil disini ",
            'title' => "RCASH | DASHBOARD",
            'tot_pesan_smm' => $this->member->get_tot_smm_by_ses(),
            'tot_depo' => $this->member->get_tot_depo_by_ses(),
            'file_js' => "laporan_rkat_return",
            'tot_trx' => $this->member->get_count_trx_by_ses(''),
            'tot_trx_success' => $this->member->get_count_trx_by_ses('Success'),
            'tot_trx_pending' => $this->member->get_count_trx_by_ses('Pending'),
            // 'tot_trx_processing' => $this->member->get_count_trx_by_ses('Processing'),
            // 'tot_trx_partial' => $this->member->get_count_trx_by_ses('Partial'),
            // 'tot_trx_failed' => $this->member->get_count_trx_by_ses('Failed'),
            // 'tot_trx_refund' => $this->member->get_count_trx_by_ses('Refund'),
            // 'tot_trx_cancel' => $this->member->get_count_trx_by_ses('Cancel'),
            'tot_trx_error' => $this->member->get_count_trx_by_ses('Error'),
        );



        $this->load->view('templates/header', $data);
        $this->load->view('member/dashboard/index');
        $this->load->view('member/dashboard/index-js');
        $this->load->view('templates/footer');
    }

    function logout()
    {
        $data = $this->member->get_user_by_ses();
        $this->LOG->log_usr($data['user_id'], "LOGOUT SUKSES");
        $this->session->unset_userdata(array('user' => ''));
        $this->session->sess_destroy();
        // $this->M_log->log_in('BERHASIL LOGOUT ');
        $this->session->set_flashdata('message', '<script>toastr["error"]("Your Username or Password is wrong, please try again")
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": 300,
            "hideDuration": 100,
            "timeOut": 5000,
            "extendedTimeOut": 1000,
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
          }</script>');
        redirect('auth');
    }
}

/* End of file Dashboard.php */
