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
        // Mengambil data dari tabel "leases" dengan filter selectedDay dan keyword
        $selectedDay = $this->input->post('selectedDay');
        $keyword = $this->input->post('keyword');

        $data['selectedDay'] = $selectedDay ?? '';

        $results = [];

        if (!empty($selectedDay) && !empty($keyword)) {
            $sql = "SELECT p.nama_pemilik, p.jenis, l.mac_address, l.ip_address, l.last_seen, r.nama_ruang, r.lantai, l.waktu_ambil, DAYNAME(l.waktu_ambil) AS day_name
            FROM pemilik p
            JOIN leases l ON p.mac_address = l.mac_address
            JOIN ip i ON l.ip_address = i.ip_address
            JOIN ruangan r ON i.ruangan_id = r.id
            WHERE p.nama_pemilik LIKE '%" . $keyword . "%'
                AND DAYNAME(l.waktu_ambil) = '" . $selectedDay . "'
            ORDER BY l.waktu_ambil DESC, l.last_seen ASC";

            $result = $this->db->query($sql)->result_array();

            $dataPoints = array();
            foreach ($result as $row) {
                $dataPoints[] = array($row['nama_pemilik'], $row['nama_ruang'], $row['waktu_ambil']);
            }

            // Fungsi K-Means Clustering
            function kMeansClustering($dataPoints, $k, $maxIterations = 100)
            {
                // Menentukan titik pusat awal secara acak
                shuffle($dataPoints);
                $centroids = array_slice($dataPoints, 0, $k);

                for ($iteration = 0; $iteration < $maxIterations; $iteration++) {
                    $clusters = array_fill(0, $k, array());

                    // Mengelompokkan data points ke dalam cluster terdekat
                    foreach ($dataPoints as $dataPoint) {
                        $minDistance = INF;
                        $closestCentroid = null;

                        foreach ($centroids as $centroid) {
                            $distance = euclideanDistance($dataPoint, $centroid);
                            if ($distance < $minDistance) {
                                $minDistance = $distance;
                                $closestCentroid = $centroid;
                            }
                        }

                        $clusters[array_search($closestCentroid, $centroids)][] = $dataPoint;
                    }

                    // Menghitung titik pusat baru untuk setiap cluster
                    $newCentroids = array();
                    foreach ($clusters as $cluster) {
                        $clusterSize = count($cluster);
                        $sumX = 0;
                        $sumY = 0;

                        if ($clusterSize > 0) {
                            foreach ($cluster as $dataPoint) {
                                $sumX += floatval($dataPoint[0]);
                                $sumY += floatval($dataPoint[1]);
                            }

                            $newCentroids[] = array($sumX / $clusterSize, $sumY / $clusterSize);
                        }
                    }

                    // Jika titik pusat tidak berubah, berhenti iterasi
                    if ($centroids === $newCentroids) {
                        break;
                    }

                    $centroids = $newCentroids;
                }

                return $clusters;
            }

            // Fungsi jarak Euclidean
            function euclideanDistance($point1, $point2)
            {
                $diffX = floatval($point1[0]) - floatval($point2[0]);
                $diffY = floatval($point1[1]) - floatval($point2[1]);
                return sqrt(pow($diffX, 2) + pow($diffY, 2));
            }

            // Menjalankan K-Means Clustering dengan 2 cluster
            $k = 2;
            $clusters = kMeansClustering($dataPoints, $k);

            // Menampilkan hasil clustering
            foreach ($clusters as $clusterIndex => $cluster) {
                echo "Cluster " . ($clusterIndex + 1) . ": ";
                foreach ($cluster as $dataPoint) {
                    echo "(" . $dataPoint[0] . ", " . $dataPoint[1] . ", " . $dataPoint[2] . ") ";
                }
                echo "<br>";
            }
        }
    }

    public function HasilPrediksi2()
    {
        $selectedDay = $this->input->post('selectedDay');
        $keyword = $this->input->post('keyword');

        $data['selectedDay'] = $selectedDay ?? '';

        $results = [];

        if (!empty($selectedDay) && !empty($keyword)) {
            $sql = "SELECT p.nama_pemilik, p.jenis, l.mac_address, l.ip_address, l.last_seen, r.nama_ruang, r.lantai, l.waktu_ambil, DAYNAME(l.waktu_ambil) AS day_name
                FROM pemilik p
                JOIN leases l ON p.mac_address = l.mac_address
                JOIN ip i ON l.ip_address = i.ip_address
                JOIN ruangan r ON i.ruangan_id = r.id
                WHERE p.nama_pemilik LIKE '%" . $keyword . "%'
                    AND DAYNAME(l.waktu_ambil) = '" . $selectedDay . "'
                ORDER BY l.waktu_ambil DESC, l.last_seen ASC
                LIMIT 10";

            $results = $this->db->query($sql)->result_array();
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
