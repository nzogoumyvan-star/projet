<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>CVE Explorer - Base d'exploits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; font-size: 14px; }
        .navbar { background-color: #212529; }
        .table th { background-color: #343a40; color: white; }
        .verified { color: #28a745; font-weight: bold; }
        .has-app { color: #007bff; }
        .severity-critical { color: #dc3545; font-weight: bold; }
        .severity-high { color: #fd7e14; }
        .severity-medium { color: #ffc107; }
        .severity-low { color: #17a2b8; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">🔍 CVE Explorer</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.php"><i class="bi bi-collection"></i> Exploits</a>
                <a class="nav-link" href="#"><i class="bi bi-book"></i> Papers</a>
                <a class="nav-link" href="#"><i class="bi bi-terminal"></i> Shellcodes</a>
                <a class="nav-link" href="#"><i class="bi bi-search"></i> Search</a>
            </div>
        </div>
    </nav>

    <!-- Contenu -->
    <div class="container mt-4">
        <h2>🔎 Exploits Database By Yvan</h2>

        <!-- Filtres -->
        <form method="GET" action="search.php" class="bg-light p-3 rounded mb-4 shadow-sm">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="query" class="form-control form-control-sm" placeholder="Rechercher (CVE, titre...)">
                </div>
                <div class="col-md-2">
                    <select name="type" class="form-select form-select-sm">
                        <option value="">Type</option>
                        <option value="rce">RCE</option>
                        <option value="xss">XSS</option>
                        <option value="lfi">LFI</option>
                        <option value="dos">DoS</option>
                        <option value="csrf">CSRF</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="platform" class="form-select form-select-sm">
                        <option value="">Plateforme</option>
                        <option value="windows">Windows</option>
                        <option value="linux">Linux</option>
                        <option value="web">Web</option>
                        <option value="android">Android</option>
                        <option value="ios">iOS</option>
                        <option value="wifi">WiFi</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="text" name="author" class="form-control form-control-sm" placeholder="Auteur">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-sm btn-primary w-100"><i class="bi bi-funnel"></i> Filtrer</button>
                </div>
            </div>
        </form>

        <!-- Tableau -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="text-center">
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
                    $stmt = $pdo->query("SELECT * FROM vulnerabilities ORDER BY date DESC LIMIT 100");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $severityClass = 'severity-' . strtolower($row['severity'] ?? 'low');
                        echo "<tr onclick=\"window.location='details.php?id={$row['id']}'\" style='cursor:pointer;'>";
                        echo "<td class='text-center'>" . ($row['date'] ? date('Y-m-d', strtotime($row['date'])) : 'N/A') . "</td>";
                        echo "<td><strong>{$row['cve_id']}</strong><br><small>{$row['title']}</small></td>";
                        echo "<td class='text-center'>" . strtoupper($row['type']) . "</td>";
                        echo "<td class='text-center'>" . ucfirst($row['platform']) . "</td>";
                        echo "<td>{$row['author']}</td>";
                        echo "<td class='text-center'>" . ($row['verified'] ? '<span class="verified">✓</span>' : '') . "</td>";
                        echo "<td class='text-center'>" . ($row['has_app'] ? '<span class="has-app"><i class="bi bi-file-earmark-code"></i></span>' : '') . "</td>";
                        echo "<td class='text-center {$severityClass}'>" . ucfirst($row['severity'] ?? 'N/A') . "</td>";
                        echo "</tr>";
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
                <li><a href="#" class="text-light">TECHNOPOLE SOUSSE.</a></li>
                
            </p>
        </div>
    </div>
</footer>

<!-- Scripts Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>