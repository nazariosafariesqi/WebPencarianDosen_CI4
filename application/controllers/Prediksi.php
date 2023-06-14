<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Prediksi extends CI_Controller
{
    public function index()
    {
        $data['title'] = 'Prediksi Hari Tertentu';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/prediksi', $data);
        $this->load->view('templates/footer');
    }

    public function HasilPrediksi()
    {
        $selectedDay = $this->input->post('selectedDay');
        $keyword = $this->input->post('keyword');
        $data['selectedDay'] = $selectedDay ?? '';

        if (!empty($selectedDay)) {
            $dayNames = [
                'Senin' => 'Monday',
                'Selasa' => 'Tuesday',
                'Rabu' => 'Wednesday',
                'Kamis' => 'Thursday',
                'Jumat' => 'Friday',
                'Sabtu' => 'Saturday',
                'Minggu' => 'Sunday'
            ];

            if (array_key_exists($selectedDay, $dayNames)) {
                $selectedDayEn = $dayNames[$selectedDay];
                if (empty($keyword)) {
                    $results = []; // Jika keyword kosong
                } else {
                    $sql = "SELECT p.nama_pemilik, p.jenis, l.mac_address, l.ip_address, l.last_seen, r.nama_ruang, r.lantai, l.waktu_ambil, DAYNAME(l.waktu_ambil) AS day_name
                FROM pemilik p
                JOIN leases l ON p.mac_address = l.mac_address
                JOIN ip i ON l.ip_address = i.ip_address
                JOIN ruangan r ON i.ruangan_id = r.id
                WHERE p.nama_pemilik LIKE '%" . $keyword . "%'
                    AND DAYNAME(l.waktu_ambil) = '" . $selectedDayEn . "'
                    AND DATE_FORMAT(l.waktu_ambil, '%W') = '" . $selectedDayEn . "'
                    ORDER BY l.waktu_ambil DESC
                    LIMIT 5";

                    $results = $this->db->query($sql)->result_array();
                }
            }

            $data['title'] = 'Prediksi Hari Tertentu';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $data['leases'] = $results;

            // Check if results are empty
            $data['no_data'] = (count($results) === 0);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/hasilPrediksi', $data);
            $this->load->view('templates/footer');
        }
    }
}
