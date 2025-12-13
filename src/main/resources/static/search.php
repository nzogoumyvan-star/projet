<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats - CVE Explorer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .severity-critical { color: #dc3545; font-weight: bold; }
        .severity-high { color: #fd7e14; }
        .verified { color: #28a745; }
        .has-app { color: #007bff; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2>Résultats de la recherche</h2>
        <a href="index.php" class="btn btn-sm btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Retour</a>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Date</th>
                        <th>Titre / CVE</th>
                        <th>Type</th>
                        <th>Plateforme</th>
                        <th>Auteur</th>
                        <th>Vérifié</th>
                        <th>App</th>
                        <th>Sévérité</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = $_GET['query'] ?? '';
                    $type = $_GET['type'] ?? '';
                    $platform = $_GET['platform'] ?? '';
                    $author = $_GET['author'] ?? '';

                    $sql = "SELECT * FROM vulnerabilities WHERE 1=1";
                    $params = [];

                    if ($query) {
                        $sql .= " AND (cve_id LIKE ? OR title LIKE ?)";
                        $likeQuery = "%$query%";
                        $params[] = $likeQuery;
                        $params[] = $likeQuery;
                    }
                    if ($type) {
                        $sql .= " AND type = ?";
                        $params[] = $type;
                    }
                    if ($platform) {
                        $sql .= " AND platform = ?";
                        $params[] = $platform;
                    }
                    if ($author) {
                        $sql .= " AND author LIKE ?";
                        $params[] = "%$author%";
                    }

                    $sql .= " ORDER BY date DESC";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute($params);

                    if ($stmt->rowCount() == 0) {
                        echo "<tr><td colspan='8' class='text-center'>Aucun résultat trouvé.</td></tr>";
                    } else {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $severityClass = 'severity-' . strtolower($row['severity'] ?? 'low');
                            echo "<tr onclick=\"window.location='details.php?id={$row['id']}'\" style='cursor:pointer;'>";
                            echo "<td class='text-center'>" . ($row['date'] ? date('Y-m-d', strtotime($row['date'])) : 'N/A') . "</td>";
                            echo "<td><strong>{$row['cve_id']}</strong><br><small>{$row['title']}</small></td>";
                            echo "<td class='text-center'>" . strtoupper($row['type']) . "</td>";
                            echo "<td class='text-center'>" . ucfirst($row['platform']) . "</td>";
                            echo "<td>{$row['author']}</td>";
                            echo "<td class='text-center'>" . ($row['verified'] ? '<span class="verified">✓</span>' : '') . "</td>";
                            echo "<td class='text-center'>" . ($row['has_app'] ? '<i class="bi bi-file-earmark-code has-app"></i>' : '') . "</td>";
                            echo "<td class='text-center {$severityClass}'>" . ucfirst($row['severity'] ?? 'N/A') . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
<footer class="bg-dark text-light p-4 mt-5">
    <div class="container">
        <div class="row">
            <!-- Bases de données -->
            <div class="col-md-3">
                <h6 class="text-uppercase mb-3">Bases de données</h6>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-light">Exploits</a></li>
                    <li><a href="#" class="text-light">Papiers</a></li>
                    <li><a href="#" class="text-light">Shellcodes</a></li>
                </ul>
            </div>

            <!-- Liens -->
            <div class="col-md-3">
                <h6 class="text-uppercase mb-3">Liens</h6>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-light">Rechercher Exploit-DB</a></li>
                    <li><a href="#" class="text-light">Soumettre une entrée</a></li>
                    <li><a href="#" class="text-light">Manuel de SearchSploit</a></li>
                    <li><a href="#" class="text-light">Statistiques d'exploitation</a></li>
                </ul>
            </div>

            <!-- Sites -->
            <div class="col-md-3">
                <h6 class="text-uppercase mb-3">Sites</h6>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-light">OffSec</a></li>
                    <li><a href="#" class="text-light">Kali Linux</a></li>
                    <li><a href="#" class="text-light">VulnHub</a></li>
                </ul>
            </div>

            <!-- Solutions -->
            <div class="col-md-3">
                <h6 class="text-uppercase mb-3">Solutions</h6>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-light">Cours et certifications</a></li>
                    <li><a href="#" class="text-light">Apprendre les abonnements</a></li>
                    <li><a href="#" class="text-light">Terrains d'essai</a></li>
                    <li><a href="#" class="text-light">Services de tests de pénétration</a></li>
                </ul>
            </div>
        </div>

        <!-- Réseaux sociaux -->
        <div class="mt-4">
            <a href="#"><i class="bi bi-twitter text-light fs-4 mx-2"></i></a>
            <a href="#"><i class="bi bi-facebook text-light fs-4 mx-2"></i></a>
            <a href="#"><i class="bi bi-rss text-light fs-4 mx-2"></i></a>
        </div>

        <!-- Copyright -->
        <div class="text-center mt-4">
            <p class="mb-0 text-secondary">
                © OffSec Services Limited 2025. Tous droits réservés.
            </p>
        </div>
    </div>
</footer>

<!-- Scripts Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>