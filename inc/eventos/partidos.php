<?php
$getLiga = $_GET['liga'];
$ligas = mysqli_query($conn, "SELECT * FROM ligas
WHERE ligaId = '$getLiga'");
$result = mysqli_fetch_array($ligas);
$ligaNombre = $result['ligaNombre'];
?>
<div class="header-large-title container">
    <h1 class="title">
        <?= $ligaNombre ?>
    </h1>
</div>
<div class="section mt-2">
    <div class="container">
        <div class="row">
            <?php
            $partidos = mysqli_query($conn, "SELECT p.id, p.local, p.visitante, p.liga, p.fecha_hora, p.tipo, p.starp, p.vix,
            h.hboId AS hbo, h.url AS hbo_url,
            e1.equipoId AS id_local, e1.equipoNombre AS equipo_local,
            e2.equipoId AS id_visitante, e2.equipoNombre AS equipo_visitante,
            e3.ligaNombre AS partido_liga,
            f1.fuenteId AS id_canal1, f1.fuenteNombre AS nombre_canal1, f1.canal AS canal_canal1,
            p1.paisNombre AS pais_canal1,
            f2.fuenteId AS id_canal2, f2.fuenteNombre AS nombre_canal2, f2.canal AS canal_canal2,
            p2.paisNombre AS pais_canal2,
            f3.fuenteId AS id_canal3, f3.fuenteNombre AS nombre_canal3, f3.canal AS canal_canal3,
            p3.paisNombre AS pais_canal3,
            f4.fuenteId AS id_canal4, f4.fuenteNombre AS nombre_canal4, f4.canal AS canal_canal4,
            p4.paisNombre AS pais_canal4,
            f5.fuenteId AS id_canal5, f5.fuenteNombre AS nombre_canal5, f5.canal AS canal_canal5,
            p5.paisNombre AS pais_canal5,
            f6.fuenteId AS id_canal6, f6.fuenteNombre AS nombre_canal6, f6.canal AS canal_canal6,
            p6.paisNombre AS pais_canal6,
            f7.fuenteId AS id_canal7, f7.fuenteNombre AS nombre_canal7, f7.canal AS canal_canal7,
            p7.paisNombre AS pais_canal7,
            f8.fuenteId AS id_canal8, f8.fuenteNombre AS nombre_canal8, f8.canal AS canal_canal8,
            p8.paisNombre AS pais_canal8,
            f9.fuenteId AS id_canal9, f9.fuenteNombre AS nombre_canal9, f9.canal AS canal_canal9,
            p9.paisNombre AS pais_canal9,
            f10.fuenteId AS id_canal10, f10.fuenteNombre AS nombre_canal10, f10.canal AS canal_canal10,
            p10.paisNombre AS pais_canal10
            FROM partidos p
            JOIN equipos e1 ON p.local = e1.equipoId
            JOIN equipos e2 ON p.visitante = e2.equipoId
            JOIN ligas e3 ON p.liga = e3.ligaId
            LEFT JOIN hbom h ON p.id = h.partido
            LEFT JOIN fuentes f1 ON p.canal1 = f1.fuenteId
            LEFT JOIN paises p1 ON f1.pais = p1.paisId
            LEFT JOIN fuentes f2 ON p.canal2 = f2.fuenteId
            LEFT JOIN paises p2 ON f2.pais = p2.paisId
            LEFT JOIN fuentes f3 ON p.canal3 = f3.fuenteId
            LEFT JOIN paises p3 ON f3.pais = p3.paisId
            LEFT JOIN fuentes f4 ON p.canal4 = f4.fuenteId
            LEFT JOIN paises p4 ON f4.pais = p4.paisId
            LEFT JOIN fuentes f5 ON p.canal5 = f5.fuenteId
            LEFT JOIN paises p5 ON f5.pais = p5.paisId
            LEFT JOIN fuentes f6 ON p.canal6 = f6.fuenteId
            LEFT JOIN paises p6 ON f6.pais = p6.paisId
            LEFT JOIN fuentes f7 ON p.canal7 = f7.fuenteId
            LEFT JOIN paises p7 ON f7.pais = p7.paisId
            LEFT JOIN fuentes f8 ON p.canal8 = f8.fuenteId
            LEFT JOIN paises p8 ON f8.pais = p8.paisId
            LEFT JOIN fuentes f9 ON p.canal9 = f9.fuenteId
            LEFT JOIN paises p9 ON f9.pais = p9.paisId
            LEFT JOIN fuentes f10 ON p.canal10 = f10.fuenteId
            LEFT JOIN paises p10 ON f10.pais = p10.paisId
            WHERE liga='$getLiga'
            ORDER BY fecha_hora ASC");
            include('inc/eventos/custom.php');
            while ($result = mysqli_fetch_array($partidos)) {
                // Teams
                $local = $result['equipo_local'];
                $local_id = $result['id_local'];
                $visitante = $result['equipo_visitante'];
                $visitante_id = $result['id_visitante'];
                $index = $result['id'];
                $tipo = $result['tipo'];
                $starp = $result['starp'];
                $vix = $result['vix'];
                $custId = getCustomLink($index);
                // Channels Image
                $ciSearch = $result['id_canal1'];
                if ($ciSearch == null || $ciSearch == "") {
                    $ciSearch = $result['id_canal2'];
                    if ($ciSearch == null || $ciSearch == "") {
                        $ciSearch = $result['id_canal3'];
                    }
                    if ($ciSearch == null || $ciSearch == "") {
                        $ciSearch = $result['id_canal4'];
                    }
                    if ($ciSearch == null || $ciSearch == "") {
                        $ciSearch = $result['id_canal5'];
                    }
                    if ($ciSearch == null || $ciSearch == "") {
                        $ciSearch = $result['id_canal6'];
                    }
                }
                $ciQuery = mysqli_query($conn, "SELECT canalImg FROM canales WHERE canalId IN (SELECT canal FROM fuentes WHERE fuenteId = '$ciSearch')");
                $ciResult = mysqli_fetch_array($ciQuery);
                $canalImg = $ciResult['canalImg'];
                // Star o Vix
                if ($canalImg === null) {
                    if ($result['starp'] == 1) {
                        $canalImg = "starplus";
                    } elseif ($result['vix'] == 1) {
                        $canalImg = "vix";
                    } elseif ($custId != null) {
                        if ($tipo == "american-football") {
                            $canalImg = "nfl";
                        } elseif ($tipo == "ice-hockey") {
                            $canalImg = "nhl";
                        } else {
                            $canalImg = "nbalp";
                        }
                    }
                }
                // Default
                if ($canalImg === null) {
                    $canalImg = "152x152";
                }
                include('inc/cntdwn.php');
                ?>
                <!-- Elemento -->
                <div class="col-12 mycard">
                    <a data-toggle="collapse" href="#juego<?= $index ?>" role="button" aria-expanded="<?= $aria ?>"
                        aria-controls="juego<?= $index ?>">
                        <div class="card product-card">
                            <div class="main-event">
                                <div class="league">
                                    <img src="https://api.sofascore.app/api/v1/unique-tournament/<?= $getLiga ?>/image/dark"
                                        alt="League" />
                                    <!-- <p class="<?= $index ?>"><?= ucfirst($dia) ?></p> -->
                                    <p class="cntdwn-<?= $index ?>"></p>
                                </div>
                                <div class="match">
                                    <div class="team">
                                        <img width="60px" src="https://api.sofascore.app/api/v1/team/<?= $local_id ?>/image"
                                            alt="" />
                                        <h4>
                                            <?= ucfirst($local) ?>
                                        </h4>
                                    </div>
                                    <div class="vs">
                                        <h6>vs</h6>
                                    </div>
                                    <div class="team">
                                        <img width="60px"
                                            src="https://api.sofascore.app/api/v1/team/<?= $visitante_id ?>/image" alt="" />
                                        <h4>
                                            <?= ucfirst($visitante) ?>
                                        </h4>
                                    </div>
                                </div>
                                <div class="channel">
                                    <img src="../assets/img/canales/<?= ($canalImg === null) ? "152x152" : $canalImg ?>.png"
                                        alt="" />
                                </div>
                            </div>
                        </div>
                    </a>
                    <div class="collapse <?= $collapse ?>" id="juego<?= $index ?>">
                        <div class="card card-body">
                            <ul class="listview link-listview">
                                <?php
                                if ($index == 11816830):
                                ?>
                                <li>
                                    <a class="justify-content-center" href="?p=tv&evento&ifr=aHR0cHM6Ly93My5tcC5sdXJhLmxpdmUvcGxheWVyL3Byb2QvdjMvYW52bG9hZC5odG1sP2tleT1leUp0SWpvZ0lrRk9WaUlzSUNKMklqb2dJbUZrYzNRd1NqUldUbFpDUzA0eWVsZ2lMQ0FpZEc5clpXNGlPaUFpWlhsS2FHSkhZMmxQYVVwSlZYcEpNVTVwU1hOSmJsSTFZME5KTmtscmNGaFdRMG81TG1WNVNuQmpNMDFwVDJsS2RGVlhTbWhOYXpscldqRkNTVlZzWkZkbGFtUnZWRzAxTUZSdWFFNU5ia3B3VDBSR2VGUnNaRFZYUTBselNXNWFjRnBEU1RaSmJVWnJZek5SZDFOcVVsZFViRnBEVXpBMGVXVnNaMmxNUTBwc1pVaEJhVTlxUlROTlJFRXlUV3BaTlU1VWEzTkpiV3hvWkVOSk5rMVVZM2ROUkZVd1RVUlZNVTlZTUM1eldXVnNZbnBNWWxjM1RsOW5NMnh6UlVkNFdWSlFOakY1YzE5WmQxaHdhV00xVlRCc2RtOHRUMWR2SWl3Z0ltRnVkbUZqYXlJNklDSnRVV0poTWs5a1oxQklVbGRXZWpkb1RtNTBUbmhOTW5KcE9ERnhUbGQ1V0NKOQ==&title=M%C3%A9xico%20vs%20Honduras">
                                        <i class="flag mx"></i>
                                            Vix + (Recomendado)
                                    </a>
                                </li>
                                <?php endif ?>
                                <?php
                                // HBO M
                                if ($result['hbo'] === null || $result['hbo'] === "") {
                                    // No mostramos nada
                                } else {
                                    ?>
                                    <li class="hidden">
                                        <a class="justify-content-center"
                                            href="?p=tv&tipo=<?= $tipo ?>&id=<?= $index ?>&s=<?= $result['hbo_url'] ?>">
                                            <i class="flag mx"></i>
                                            HBO Max
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php
                                // CUSTOM
                                $custId = getCustomLink($index);
                                if ($custId !== null) {
                                    $custom = '<li>
                                        <a class="justify-content-center"
                                            href="?p=tv&evento&nbalp=' . $custId . '">
                                            <i class="flag us"></i>
                                            ' . $ligaNombre . ' League Pass
                                        </a>
                                    </li>';
                                    echo $custom;
                                } else {}
                                // Canal 1
                                if ($result['canal_canal1'] === null || $result['canal_canal1'] === "") {
                                    // No mostramos nada
                                } else {
                                    ?>
                                    <li>
                                        <a class="justify-content-center"
                                            href="?p=tv&tipo=<?= $tipo ?>&id=<?= $index ?>&c=<?= $result['canal_canal1'] ?>&f=<?= $result['id_canal1'] ?>">
                                            <i class="flag <?= $result['pais_canal1'] ?>"></i>
                                            <?= $result['nombre_canal1'] ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php
                                // Canal 2
                                if ($result['canal_canal2'] === null || $result['canal_canal2'] === "") {
                                    // No mostramos nada
                                } else {
                                    ?>
                                    <li>
                                        <a class="justify-content-center"
                                            href="?p=tv&tipo=<?= $tipo ?>&id=<?= $index ?>&c=<?= $result['canal_canal2'] ?>&f=<?= $result['id_canal2'] ?>">
                                            <i class="flag <?= $result['pais_canal2'] ?>"></i>
                                            <?= $result['nombre_canal2'] ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php
                                // Canal 3
                                if ($result['canal_canal3'] === null || $result['canal_canal3'] === "") {
                                    // No mostramos nada
                                } else {
                                    ?>
                                    <li>
                                        <a class="justify-content-center"
                                            href="?p=tv&tipo=<?= $tipo ?>&id=<?= $index ?>&c=<?= $result['canal_canal3'] ?>&f=<?= $result['id_canal3'] ?>">
                                            <i class="flag <?= $result['pais_canal3'] ?>"></i>
                                            <?= $result['nombre_canal3'] ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php
                                // Canal 4
                                if ($result['canal_canal4'] === null || $result['canal_canal4'] === "") {
                                    // No mostramos nada
                                } else {
                                    ?>
                                    <li>
                                        <a class="justify-content-center"
                                            href="?p=tv&tipo=<?= $tipo ?>&id=<?= $index ?>&c=<?= $result['canal_canal4'] ?>&f=<?= $result['id_canal4'] ?>">
                                            <i class="flag <?= $result['pais_canal4'] ?>"></i>
                                            <?= $result['nombre_canal4'] ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php
                                // Canal 5
                                if ($result['canal_canal5'] === null || $result['canal_canal5'] === "") {
                                    // No mostramos nada
                                } else {
                                    ?>
                                    <li>
                                        <a class="justify-content-center"
                                            href="?p=tv&tipo=<?= $tipo ?>&id=<?= $index ?>&c=<?= $result['canal_canal5'] ?>&f=<?= $result['id_canal5'] ?>">
                                            <i class="flag <?= $result['pais_canal5'] ?>"></i>
                                            <?= $result['nombre_canal5'] ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php
                                // Canal 6
                                if ($result['canal_canal6'] === null || $result['canal_canal6'] === "") {
                                    // No mostramos nada
                                } else {
                                    ?>
                                    <li>
                                        <a class="justify-content-center"
                                            href="?p=tv&tipo=<?= $tipo ?>&id=<?= $index ?>&c=<?= $result['canal_canal6'] ?>&f=<?= $result['id_canal6'] ?>">
                                            <i class="flag <?= $result['pais_canal6'] ?>"></i>
                                            <?= $result['nombre_canal6'] ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php
                                // Canal 7
                                if ($result['canal_canal7'] === null || $result['canal_canal7'] === "") {
                                    // No mostramos nada
                                } else {
                                    ?>
                                    <li>
                                        <a class="justify-content-center"
                                            href="?p=tv&tipo=<?= $tipo ?>&id=<?= $index ?>&c=<?= $result['canal_canal7'] ?>&f=<?= $result['id_canal7'] ?>">
                                            <i class="flag <?= $result['pais_canal7'] ?>"></i>
                                            <?= $result['nombre_canal7'] ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php
                                // Canal 8
                                if ($result['canal_canal8'] === null || $result['canal_canal8'] === "") {
                                    // No mostramos nada
                                } else {
                                    ?>
                                    <li>
                                        <a class="justify-content-center"
                                            href="?p=tv&tipo=<?= $tipo ?>&id=<?= $index ?>&c=<?= $result['canal_canal8'] ?>&f=<?= $result['id_canal8'] ?>">
                                            <i class="flag <?= $result['pais_canal8'] ?>"></i>
                                            <?= $result['nombre_canal8'] ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php
                                // Canal 9
                                if ($result['canal_canal9'] === null || $result['canal_canal9'] === "") {
                                    // No mostramos nada
                                } else {
                                    ?>
                                    <li>
                                        <a class="justify-content-center"
                                            href="?p=tv&tipo=<?= $tipo ?>&id=<?= $index ?>&c=<?= $result['canal_canal9'] ?>&f=<?= $result['id_canal9'] ?>">
                                            <i class="flag <?= $result['pais_canal9'] ?>"></i>
                                            <?= $result['nombre_canal9'] ?>
                                        </a>
                                    </li>
                                <?php } ?>
                                <?php
                                // Canal 10
                                if ($result['canal_canal10'] === null || $result['canal_canal10'] === "") {
                                    // No mostramos nada
                                } else {
                                    ?>
                                    <li>
                                        <a class="justify-content-center"
                                            href="?p=tv&tipo=<?= $tipo ?>&id=<?= $index ?>&c=<?= $result['canal_canal10'] ?>&f=<?= $result['id_canal10'] ?>">
                                            <i class="flag <?= $result['pais_canal10'] ?>"></i>
                                            <?= $result['nombre_canal10'] ?>
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php
                                // Star
                                if ($starp == null || $starp == 0) {
                                    // No mostramos nada
                                } else {
                                    ?>
                                    <li>
                                        <a class="justify-content-center" href="?p=star">
                                            <i class="flag ar"></i>
                                            Star +
                                        </a>
                                    </li>
                                <?php } ?>

                                <?php
                                // Vix
                                if ($vix == null || $vix == 0) {
                                    // No mostramos nada
                                } else {
                                    ?>
                                    <li>
                                        <a class="justify-content-center" href="?p=vix">
                                            <i class="flag mx"></i>
                                            Vix +
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- End Elemento -->
                <?php
            }
            ?>
        </div>
    </div>
</div>