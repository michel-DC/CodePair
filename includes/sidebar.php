<aside class="sidebar collapsed">
    <div class="sidebar-header">
        <button id="toggle-sidebar" class="toggle-btn">☰</button>
    </div>
    <nav class="sidebar-nav">
        <ul>
            <li>
                <a href="dashboard.php" class="nav-link">
                    <span class="nav-icon">📊</span>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#" id="add-dev-link" class="nav-link">
                    <span class="nav-icon">➕</span>
                    <span class="nav-text">Ajouter un développeur</span>
                </a>
            </li>
            <li> 
                <a href="#" id="supp-dev-link" class="nav-link">
                    <span class="nav-icon">⛔</span>
                    <span class="nav-text">Supprimer un développeur</span>
                </a>
            </li>
            <li> 
                <a href="#" id="edit-dev-link" class="nav-link">
                    <span class="nav-icon">✏️</span>
                    <span class="nav-text">Modifier un profil</span>
                </a>
            </li>
            <li> 
                <a href="#" id="see-dev-link" class="nav-link">
                    <span class="nav-icon">👨‍💻</span>
                    <span class="nav-text">Voir tout les développeurs</span>
                </a>
            </li>
            <li> 
                <a href="#" id="see-reserv-link" class="nav-link">
                    <span class="nav-icon">🗓️</span>
                    <span class="nav-text">Voir toutes les réservations</span>
                </a>
            </li>
            <li>
                <a href="#" id="see-user-link" class="nav-link">
                    <span class="nav-icon">👤</span>
                    <span class="nav-text">Gérer Utilisateurs</span>
                </a>
            </li>
        </ul>
    </nav>
    <div class="sidebar-footer">
        <a href="../connexion/logout-admin.php" class="nav-link logout-link">
            <span class="nav-icon">🚪</span>
            <span class="nav-text">Déconnexion</span>
        </a>
    </div>
</aside>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap');
    .sidebar {
        font-family: "Space Grotesk", sans-serif;
        width: 250px;
        background: rgba(255, 255, 255, 0.8);
        color: #151717;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        padding: 20px;
        box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        z-index: 1000;
        backdrop-filter: blur(10px);
    }
    
    @media (max-width: 768px) {
        .sidebar {
            width: 80px;
            padding: 10px;
        }
        .sidebar .nav-text,
        .sidebar .nav-icon {
            margin-right: 0;
        }
        .sidebar-footer {
            left: 10px;
            right: 10px;
        }
    }
    
    .sidebar.collapsed {
        width: 120px;
    }
    .sidebar.collapsed .nav-text {
        display: none;
    }
    .sidebar.collapsed .sidebar-header h3 {
        display: none;
    }
    .sidebar-header {
        margin-bottom: 30px;
        padding-bottom: 20px;
        position: relative;
    }
    .toggle-btn {
        position: absolute;
        left: 50%;
        top: 0;
        transform: translateX(-50%);
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1.5rem;
        padding: 5px;
        color: #2ECC71;
        transition: color 0.2s ease;
    }
    .toggle-btn:hover {
        color: #2ECC71;
    }
    .sidebar-nav ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .nav-link {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        color: #151717;
        text-decoration: none;
        border-radius: 8px;
        margin-bottom: 8px;
        transition: all 0.2s ease-in-out;
        border: 1.5px solid rgba(236, 237, 236, 0.5);
        background-color: rgba(248, 249, 250, 0.8);
    }
    .nav-link:hover {
        border-color: #2ECC71;
        background-color: rgba(233, 242, 255, 0.8);
        transform: translateX(5px);
    }
    .nav-icon {
        margin-right: 15px;
        font-size: 1.2rem;
        color: #2ECC71;
        transition: margin 0.3s ease;
    }
    .nav-text {
        font-size: 0.95rem;
        font-weight: 500;
        transition: opacity 0.2s ease;
    }
    .sidebar-footer {
        position: absolute;
        bottom: 70px;
        left: 20px;
        right: 20px;
        padding-top: 20px;
    }
    .logout-link {
        background-color: rgba(255, 240, 240, 0.8);
        border-color: rgba(255, 204, 204, 0.5);
    }
    .logout-link:hover {
        background-color: rgba(255, 230, 230, 0.8);
        border-color: rgba(255, 153, 153, 0.5);
    }
</style>

<script>
    document.getElementById('toggle-sidebar').addEventListener('click', function() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('collapsed');
    });

    window.addEventListener('resize', function() {
        const sidebar = document.querySelector('.sidebar');
        if (window.innerWidth <= 768) {
            sidebar.classList.add('collapsed');
        } else {
            sidebar.classList.remove('collapsed');
        }
    });

    window.addEventListener('DOMContentLoaded', function() {
        if (window.innerWidth <= 768) {
            document.querySelector('.sidebar').classList.add('collapsed');
        }
    });
</script>