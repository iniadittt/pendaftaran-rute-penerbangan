<?php
    $jsonURL = "./data/data.json";
    $dataPenerbangan = array();
    $dataJson = file_get_contents($jsonURL);
    $dataPenerbangan = json_decode($dataJson, true);

    function hitungPajakBandaraAsal($namaBandara){
        $pajak = 0;
        if($namaBandara == 'Soekarno-Hatta (CGK)'){
            $pajak = 50000;
        }else if($namaBandara == 'Husein Sastranegara (BDO)'){
            $pajak = 30000;
        }else if($namaBandara == 'Abdul Rachman Saleh (MLG)'){
            $pajak = 40000;
        }else if($namaBandara == 'Juanda (SUB)'){
            $pajak = 40000;
        }else{
            $pajak = 0;
        }
        return $pajak;
    }

    function hitungPajakBandaraTujuan($namaBandara){
        $pajak = 0;
        if($namaBandara == 'Ngurah Rai (DPS)'){
            $pajak = 80000;
        }else if($namaBandara == 'Hasanuddin (UPG)'){
            $pajak = 70000;
        }else if($namaBandara == 'Inanwatan (INX)'){
            $pajak = 90000;
        }else if($namaBandara == 'Sultan Iskandarmuda (BTJ)'){
            $pajak = 70000;
        }else{
            $pajak = 0;
        }
        return $pajak;
    }

    function getData(){
        $data = file_get_contents("./data/data.json");
        $dataFlights = json_decode($data, true);
        usort($dataFlights, function($a, $b) {
            return strcmp($a['maskapai'], $b['maskapai']);
        });
        return $dataFlights;
    }
    
    function saveData($data) {
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents('./data/data.json', $jsonData);
    }

    if(isset($_POST['submit'])){
        $maskapai = $_POST['maskapai'];
        $bandaraAsal = $_POST['bandaraAsal'];
        $bandaraTujuan = $_POST['bandaraTujuan'];
        $hargaTiket = (int)$_POST['hargaTiket'];
        $pajakBandaraAsal = hitungPajakBandaraAsal($bandaraAsal);
        $pajakBandaraTujuan = hitungPajakBandaraAsal($bandaraTujuan);
        $totalPajak = $pajakBandaraAsal + $pajakBandaraTujuan;
        $totalHargaTiket = $hargaTiket + $totalPajak;

        $newRute = [
                "maskapai" => $maskapai,
                "bandaraAsal" => $bandaraAsal,
                "bandaraTujuan" => $bandaraTujuan,
                "hargaTiket" => $hargaTiket,
                "totalPajak" => $totalPajak,
                "totalHargaTiket" => $totalHargaTiket
            ];

        array_push($dataPenerbangan, $newRute);
        saveData($dataPenerbangan);
    };



?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./library/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <div class="container my-4 text-center">
        <img src="./data/images/image.png" alt="Gambar Pesawat" width="30%">
    </div>
    <h1 class="py-4 text-center">Pendaftaran Rute Penerbangan</h1>
    <div class="container px-5">
        <form method="POST">
            <div class="row">
                <div class="col-2">
                    <label for="maskapai" class="form-label">Maskapai</label>
                </div>
                <div class="col-10">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="maskapai" placeholder="example: Garuda Indonesia" name="maskapai" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-2">
                    <label for="bandaraAsal" class="form-label">Bandara Asal</label>
                </div>
                <div class="col-10">
                    <div class="mb-3">
                        <select class="form-select" aria-label="Default select example" name="bandaraAsal" id="bandaraAsal" required>
                            <option value="Soekarno-Hatta (CGK)" selected>Soekarno-Hatta (CGK)</option>
                            <option value="Husein Sastranegara (BDO)">Husein Sastranegara (BDO)</option>
                            <option value="Abdul Rachman Saleh (MLG)">Abdul Rachman Saleh (MLG)</option>
                            <option value="Juanda (SUB)">Juanda (SUB)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-2">
                    <label for="bandaraTujuan" class="form-label">Bandara Tujuan</label>
                </div>
                <div class="col-10">
                    <div class="mb-3">
                        <select class="form-select" aria-label="Default select example" name="bandaraTujuan" id="bandaraTujuan" required>
                            <option value="Ngurah Rai (DPS)" selected>Ngurah Rai (DPS)</option>
                            <option value="Hasanuddin (UPG)">Hasanuddin (UPG)</option>
                            <option value="Inanwatan (INX)">Inanwatan (INX)</option>
                            <option value="Sultan Iskandarmuda (BTJ)">Sultan Iskandarmuda (BTJ)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-2">
                    <label for="hargaTiket" class="form-label">Harga Tiket</label>
                </div>
                <div class="col-10">
                    <div class="mb-3">
                        <input type="number" class="form-control" id="hargaTiket" placeholder="example: 100000" name="hargaTiket" required>
                    </div>
                </div>
            </div>
            <input type="submit" class="btn btn-success" name="submit" value="Submit"/>
        </form>
    </div>


    <div class="container pt-5">
        <h1 class="text-center pb-3">Daftar Rute Tersedia</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Maskapai</th>
                    <th scope="col">Asal Penerbangan</th>
                    <th scope="col">Tujuan Penerbangan</th>
                    <th scope="col">Harga Tiket</th>
                    <th scope="col">Pajak</th>
                    <th scope="col">Total Harga Tiket</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(count(getData()) != 0){
                        foreach(getData() as $value){
                            echo "<tr>";
                            echo "<td>" . $value['maskapai'] . "</td>";
                            echo "<td>" . $value['bandaraAsal'] . "</td>";
                            echo "<td>" . $value['bandaraTujuan'] . "</td>";
                            echo "<td>" . $value['hargaTiket'] . "</td>";
                            echo "<td>" . $value['totalPajak'] . "</td>";
                            echo "<td>" . $value['totalHargaTiket'] . "</td>";
                            echo "</tr>";
                        }
                    }else{
                        echo "";
                    }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
  </body>
</html>