<?php
// Koneksi database
$servername = "127.0.0.1";
$username = "root";
$password = "nazario123";
$dbname = "wpd"; // Ganti dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Mengambil data dari tabel "leases"
$query = "SELECT mac_address, waktu_ambil FROM leases";
$result = $conn->query($query);
$dataPoints = array();
while ($row = $result->fetch_assoc()) {
    $dataPoints[] = array($row['mac_address'], $row['waktu_ambil']);
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
        echo "(" . $dataPoint[0] . ", " . $dataPoint[1] . ") ";
    }
    echo "<br>";
}

$conn->close();
