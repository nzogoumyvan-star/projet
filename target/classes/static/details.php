<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails - CVE Explorer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .info-box { background: #f1f1f1; padding: 10px; border-radius: 5px; margin: 10px 0; }
        .exploit-code { background: #2d2d2d; color: #f8f8f2; padding: 15px; border-radius: 5px; font-family: monospace; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1>Détails de l'exploit</h1>
        <a href="index.php" class="btn btn-sm btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Retour</a>

        <?php
        $id = $_GET['id'] ?? null;

        if (!$id) {
            die("<div class='alert alert-danger'>ID manquant.</div>");
        }

        $stmt = $pdo->prepare("SELECT * FROM vulnerabilities WHERE id = ?");
        $stmt->execute([$id]);
        $vuln = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$vuln) {
            echo "<div class='alert alert-warning'>Vulnérabilité non trouvée.</div>";
        } else {
            $severityClass = match(strtolower($vuln['severity'] ?? '')) {
                'critical' => 'text-danger fw-bold',
                'high' => 'text-warning',
                'medium' => 'text-primary',
                'low' => 'text-info',
                default => ''
            };
            ?>
            <div class="card">
                <div class="card-header">
                    <h3><?= htmlspecialchars($vuln['title']) ?></h3>
                    <span class="badge bg-dark"><?= $vuln['cve_id'] ?></span>
                    <span class="badge bg-secondary"><?= strtoupper($vuln['type']) ?></span>
                    <span class="badge <?= $severityClass ?>"><?= ucfirst($vuln['severity']) ?></span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box">
                                <strong>Plateforme :</strong> <?= ucfirst($vuln['platform']) ?><br>
                                <strong>Auteur :</strong> <?= htmlspecialchars($vuln['author']) ?><br>
                                <strong>Date :</strong> <?= $vuln['date'] ? date('d/m/Y', strtotime($vuln['date'])) : 'N/A' ?><br>
                                <strong>Vérifié :</strong> <?= $vuln['verified'] ? '✅ Oui' : '❌ Non' ?><br>
                                <strong>Application disponible :</strong> <?= $vuln['has_app'] ? '✅ Oui' : '❌ Non' ?>
                            </div>
                        </div>
                    </div>

                    <h5>Description</h5>
                    <p><?= nl2br(htmlspecialchars($vuln['description'])) ?></p>

                    <h5>Méthode d'exploitation</h5>
                    <div class="exploit-code">
                        <?= nl2br(htmlspecialchars($vuln['exploit_method'])) ?>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>