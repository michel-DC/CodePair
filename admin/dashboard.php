<?php 
require_once '../includes/auth.php'; 
$_SESSION['connecté'] = true;

// Connexion à la base de données
$link = mysqli_connect("localhost", "micheldjoumessi_pair-prog", "michelchrist", "micheldjoumessi_pair-prog");

// Récupérer le nombre de développeurs
$query = "SELECT COUNT(*) as total FROM developpeurs";
$result = mysqli_query($link, $query);
$total_devs = mysqli_fetch_assoc($result)['total'];

// Récupérer le nombre d'utilisateurs
$query2 = "SELECT COUNT(*) as total FROM users";
$result2 = mysqli_query($link, $query2);
$total_users = mysqli_fetch_assoc($result2)['total'];

// Récuperer le nombre de réservation
$query5 = "SELECT COUNT(*) as total FROM reservations";
$result5 = mysqli_query($link, $query5);
$total_reservations = mysqli_fetch_assoc($result5)['total'];

// Récuperer le nombre d'admin
$query6 = "SELECT COUNT(*) as total FROM admins";
$result6 = mysqli_query($link, $query6);
$total_admins = mysqli_fetch_assoc($result6)['total'];

// recuperer le nom du dev le plus réservé
$query8 = "SELECT fullname FROM developpeurs ORDER BY nombre_reservation DESC LIMIT 1";
$result8 = mysqli_query($link, $query8);
$dev_plus_reserv = mysqli_fetch_assoc($result8)['fullname'];

// recuperer le nom de l'user qui à fait le plus de réservations
$query9 = "SELECT fullname FROM users ORDER BY nombre_reservation DESC LIMIT 1";
$result9 = mysqli_query($link, $query9);
$user_max_reserv = mysqli_fetch_assoc($result9)['fullname'];

// Récupérer l'évolution du nombre de développeurs par jour
$query3 = "SELECT DATE(date_creation) as date, COUNT(*) as count FROM developpeurs GROUP BY DATE(date_creation)";
$result3 = mysqli_query($link, $query3);
$dev_evolution = [];
while ($row = mysqli_fetch_assoc($result3)) {
    $dev_evolution[] = $row;
}

// Récupérer l'évolution du nombre d'utilisateurs par jour
$query4 = "SELECT DATE(date_creation) as date, COUNT(*) as count FROM users GROUP BY DATE(date_creation)";
$result4 = mysqli_query($link, $query4);
$user_evolution = [];
while ($row = mysqli_fetch_assoc($result4)) {
    $user_evolution[] = $row;
}

// Récupérer l'évolution du nombre de réservations par jour
$query7 = "SELECT DATE(date_creation) as date, COUNT(*) as count FROM reservations GROUP BY DATE(date_creation)";
$result7 = mysqli_query($link, $query7);
$reservation_evolution = [];
while ($row = mysqli_fetch_assoc($result7)) {
    $reservation_evolution[] = $row;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodePair | Admin Dashboard</title>
    <link rel="shortcut icon" href="../assets/images/icon/codepair_icon.PNG" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap');

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Space Grotesk", sans-serif; 
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            color: #333;
        }

        .dashboard-container {
            width: 95%;
            max-width: 1400px;
            margin: 20px auto;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .dashboard-header {
            text-align: center;
            margin-bottom: 30px;
            padding: 25px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .dashboard-header h1 {
            margin: 0;
            font-size: clamp(1.5rem, 4vw, 2.2rem);
            color: #2d3748;
            font-weight: 600;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 200px;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.2);
        }

        .stat-number {
            font-size: clamp(2rem, 5vw, 3rem);
            color: #2ECC71;
            font-weight: 700;
            margin-bottom: 15px;
            line-height: 1.2;
        }

        .stat-label {
            font-size: clamp(1rem, 2vw, 1.2rem);
            color: #4a5568;
            font-weight: 500;
        }

        .chart-card {
            position: relative;
            padding-top: 30px;
            min-height: 350px;
        }

        .message {
            padding: 15px;
            border-radius: 10px;
            margin: 10px auto;
            text-align: center;
            width: 90%;
            max-width: 500px;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            animation: fadeOut 5s forwards;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        @keyframes fadeOut {
            0% { opacity: 1; }
            80% { opacity: 1; }
            100% { opacity: 0; visibility: hidden; }
        }

        .error {
            background-color: #ffebee;
            color: #c62828;
            border-left: 4px solid #c62828;
        }

        .success {
            background-color: #e8f5e9;
            color: #2e7d32;
            border-left: 4px solid #2e7d32;
        }

        canvas {
            width: 100% !important;
            height: 250px !important;
            max-height: 300px;
        }
        
        @media screen and (min-width: 1024px) and (max-width: 1366px) {
            .dashboard-container {
                width: 90%;
                padding: 15px;
            }
            
            .stats-container {
                gap: 20px;
            }
            
            .stat-card {
                padding: 20px;
                min-height: 180px;
            }
            
            .chart-card {
                min-height: 320px;
            }
        }
        
        /* telephone */
        @media screen and (max-width: 767px) {
            .dashboard-container {
                width: 98%;
                padding: 10px;
                margin: 10px auto;
            }
            
            .dashboard-header {
                padding: 15px;
                margin-bottom: 20px;
            }
            
            .stats-container {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .stat-card {
                padding: 15px;
                min-height: 140px;
            }
            
            .chart-card {
                min-height: 250px;
            }
        }
    </style>
</head>
<body>
<?php include '../includes/sidebar.php'; ?>  

<div id="add-dev-section" style="display: none;"><?php include 'add_devs.php'; ?></div>
<div id="supp-dev-section" style="display: none;"><?php include 'supp_devs.php'; ?></div>
<div id="edit-dev-section" style="display: none;"><?php include 'edit_devs.php'; ?></div>
<div id="see-dev-section" style="display: none;"><?php include 'devs.php'; ?></div>
<div id="see-reserv-section" style="display: none;"><?php include 'reservations.php'; ?></div>
<div id="see-user-section" style="display: none;"><?php include 'user.php'; ?></div>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Tableau de Bord Administrateur</h1>
    </div>

    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-number"><?= $total_devs ?></div>
            <div class="stat-label">Développeurs/euses enregistrés 👨‍💻</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $total_users ?></div>
            <div class="stat-label">Utilisateurs inscrits 👤</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $total_admins ?></div>
            <div class="stat-label">Nombre d'administrateurs ✏️</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $total_reservations ?></div>
            <div class="stat-label">Nombre total de reservations 🗓️</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $dev_plus_reserv ?></div>
            <div class="stat-label">à été le développeur/euse le/la plus réservé 👑</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= $user_max_reserv ?></div>
            <div class="stat-label">est l'utilisateur qui a le plus réservé 🏆</div>
        </div>
        <div class="stat-card chart-card">
            <canvas id="devEvolutionGraph"></canvas>
            <div class="stat-label">Évolution des développeurs 👨‍💻</div>
        </div>
        <div class="stat-card chart-card">
            <canvas id="userEvolutionGraph"></canvas>
            <div class="stat-label">Évolution des utilisateurs 👤</div>
        </div>
        <div class="stat-card chart-card">
            <canvas id="reservationEvolutionGraph"></canvas>
            <div class="stat-label">Évolution des réservations 🗓️</div>
        </div>
    </div>
</div>

<?php
if (isset($_GET['erreur']) && $_GET['erreur'] === 'acces_interdit_admin') {
    echo "<div class='message error'>Vous devez être connecté en tant qu'utilisateur pour accéder à cette page, déconnectez-vous d'abord.</div>";
}
?>

<script>
function showSection(sectionId) {
    document.querySelectorAll('.dashboard-container, #add-dev-section, #see-dev-section, #supp-dev-section, #edit-dev-section, #see-reserv-section, #see-user-section')
        .forEach(section => section.style.display = 'none');
    document.getElementById(sectionId).style.display = 'block';
}

// Navigation depuis sidebar         
document.getElementById('add-dev-link').addEventListener('click', function(event) {
    event.preventDefault();
    showSection('add-dev-section');
});
document.getElementById('see-dev-link').addEventListener('click', function(event) {
    event.preventDefault();
    showSection('see-dev-section');
});
document.getElementById('supp-dev-link').addEventListener('click', function(event) {
    event.preventDefault();
    showSection('supp-dev-section');
});
document.getElementById('edit-dev-link').addEventListener('click', function(event) {
    event.preventDefault();
    showSection('edit-dev-section');
});
document.getElementById('see-user-link').addEventListener('click', function(event) {
    event.preventDefault();
    showSection('see-user-section');
});
document.getElementById('see-reserv-link').addEventListener('click', function(event) {
    event.preventDefault();
    showSection('see-reserv-section');
});


// Gestion de l'ancre dans l'URL
window.addEventListener('DOMContentLoaded', function() {
    const anchor = window.location.hash;
    if (anchor && document.querySelector(anchor)) {
        showSection(anchor.substring(1));
    }
});

// Configuration des graphiques
const createChart = (ctx, labels, data, color) => {
    return new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Nombre',
                data: data,
                borderColor: color,
                backgroundColor: color + '20', 
                borderWidth: 2,
                fill: true,
                tension: 0.4, 
                pointBackgroundColor: color,
                pointBorderColor: '#fff',
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { 
                    display: false 
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleFont: {
                        size: 14
                    },
                    bodyFont: {
                        size: 13
                    },
                    padding: 10,
                    cornerRadius: 4
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45,
                        font: {
                            size: 10
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    },
                    ticks: {
                        precision: 0,
                        font: {
                            size: 10
                        }
                    }
                }
            }
        }
    });
};

// Données et création des graphiques
const devEvolutionData = <?= json_encode($dev_evolution) ?>;
const userEvolutionData = <?= json_encode($user_evolution) ?>;
const reservationEvolutionData = <?= json_encode($reservation_evolution) ?>;

const devLabels = devEvolutionData.map(data => data.date);
const devCounts = devEvolutionData.map(data => data.count);

const userLabels = userEvolutionData.map(data => data.date);
const userCounts = userEvolutionData.map(data => data.count);

const reservationLabels = reservationEvolutionData.map(data => data.date);
const reservationCounts = reservationEvolutionData.map(data => data.count);

const devCtx = document.getElementById('devEvolutionGraph').getContext('2d');
const userCtx = document.getElementById('userEvolutionGraph').getContext('2d');
const reservationCtx = document.getElementById('reservationEvolutionGraph').getContext('2d');

const devChart = createChart(devCtx, devLabels, devCounts, '#2ECC71');
const userChart = createChart(userCtx, userLabels, userCounts, '#ff6e6e');
const reservationChart = createChart(reservationCtx, reservationLabels, reservationCounts, '#6eff8a');

// Gestion du redimensionnement
window.addEventListener('resize', function() {
    devChart.resize();
    userChart.resize();
    reservationChart.resize();
});
</script>

</body>
</html>