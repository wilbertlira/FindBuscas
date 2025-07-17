<?php require_once ('config.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Findy - Dashboard de Usuário</title>
    <style>
        :root {
            --primary-blue: #2196F3;
            --primary-dark-blue: #1976D2;
            --light-blue: #64B5F6;
            --white: #FFFFFF;
            --light-gray: #F5F5F5;
            --dark-gray: #616161;
            --medium-gray: #9E9E9E;
            --light-border: #E0E0E0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--light-gray);
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Menu */
        .sidebar {
            width: 250px;
            background-color: var(--white);
            border-right: 1px solid var(--light-border);
            transition: all 0.3s;
            z-index: 10;
        }
        
        .sidebar-header {
            background-color: var(--primary-blue);
            color: var(--white);
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .sidebar-logo {
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        .menu-toggle {
            display: none;
            cursor: pointer;
            font-size: 1.5rem;
        }
        
        .sidebar-user {
            padding: 20px;
            border-bottom: 1px solid var(--light-border);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background-color: var(--primary-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: bold;
        }
        
        .user-info {
            flex: 1;
        }
        
        .user-name {
            font-weight: 600;
            color: #333;
        }
        
        .user-role {
            font-size: 0.8rem;
            color: var(--medium-gray);
        }
        
        .menu-list {
            list-style: none;
            padding: 10px 0;
        }
        
        .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--dark-gray);
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .menu-item:hover {
            background-color: rgba(33, 150, 243, 0.1);
            color: var(--primary-blue);
        }
        
        .menu-item.active {
            background-color: rgba(33, 150, 243, 0.1);
            color: var(--primary-blue);
            border-left: 3px solid var(--primary-blue);
        }
        
        .menu-icon {
            width: 20px;
            text-align: center;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            max-height: 100vh;
        }
        
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .page-title {
            font-size: 1.5rem;
            color: #333;
        }
        
        .search-bar {
            background-color: var(--white);
            border-radius: 20px;
            display: flex;
            align-items: center;
            padding: 5px 15px;
            width: 300px;
            border: 1px solid var(--light-border);
        }
        
        .search-bar input {
            border: none;
            outline: none;
            padding: 8px;
            width: 100%;
        }
        
        /* Module Cards */
        .module-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }
        
        .module-card {
            background-color: var(--white);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }
        
        .module-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        
        .module-card-header {
            background-color: var(--primary-blue);
            color: var(--white);
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .module-card-title {
            font-weight: 600;
        }
        
        .module-card-icon {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        .module-card-body {
            padding: 15px;
        }
        
        .module-card-description {
            color: var(--dark-gray);
            margin-bottom: 15px;
            font-size: 0.9rem;
            line-height: 1.5;
        }
        
        .module-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid var(--light-border);
            padding: 15px;
        }
        
        .card-status {
            font-size: 0.8rem;
            color: var(--medium-gray);
        }
        
        .card-status span {
            color: var(--primary-blue);
            font-weight: 600;
        }
        
        .card-button {
            color: var(--primary-blue);
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
        }
        
        /* Recent Activities */
        .recent-activities {
            background-color: var(--white);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-bottom: 25px;
        }
        
        .section-title {
            font-size: 1.2rem;
            color: #333;
            margin-bottom: 15px;
        }
        
        .activity-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 0;
            border-bottom: 1px solid var(--light-border);
        }
        
        .activity-icon {
            width: 40px;
            height: 40px;
            background-color: rgba(33, 150, 243, 0.1);
            color: var(--primary-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .activity-details {
            flex: 1;
        }
        
        .activity-message {
            color: #333;
            margin-bottom: 3px;
        }
        
        .activity-time {
            font-size: 0.8rem;
            color: var(--medium-gray);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                position: fixed;
                bottom: 0;
                height: auto;
                border-right: none;
                border-top: 1px solid var(--light-border);
            }
            
            .sidebar-header {
                padding: 15px;
            }
            
            .menu-toggle {
                display: block;
            }
            
            .sidebar-user,
            .menu-list {
                display: none;
            }
            
            .sidebar-expanded .sidebar-user,
            .sidebar-expanded .menu-list {
                display: block;
            }
            
            .main-content {
                margin-bottom: 60px;
            }
            
            .search-bar {
                width: 200px;
            }
            
            .module-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar Menu -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">Findy</div>
            <div class="menu-toggle">☰</div>
        </div>
        
        <div class="sidebar-user">
            <div class="user-avatar">JS</div>
            <div class="user-info">
                <div class="user-name">João Silva</div>
                <div class="user-role">Usuário Premium</div>
            </div>
        </div>
        
        <ul class="menu-list">
            <li class="menu-item active">
                <span class="menu-icon">📊</span>
                <span>Dashboard</span>
            </li>
            <li class="menu-item">
                <span class="menu-icon">⚙️</span>
                <span>Configurações</span>
            </li>
            <li class="menu-item">
                <span class="menu-icon">❓</span>
                <span>Ajuda e Suporte</span>
            </li>
            <li class="menu-item">
                <span class="menu-icon">🚪</span>
                <span>Sair</span>
            </li>
        </ul>
    </aside>
    
    <!-- Main Content -->
    <main class="main-content">
 
    
            </div>
        </div>
        
        <!-- Module Cards -->
        <div class="module-grid">
            <div class="module-card">
                <div class="module-card-header">
                    <div class="module-card-title">CPF Simples</div>
                    <div class="module-card-icon">👤</div>
                </div>
                <div class="module-card-body">
                    <p class="module-card-description">Consulte usando os 11 digitos , e obtenha informações atualizadas e precisas por categoria!  </p>
                </div>
                <div class="module-card-footer">
                    <div class="card-status">Status: <span>Disponível</span></div>
                    <div class="card-button">Acessar Modulo</div>
                </div>
            </div>
            
            <div class="module-card">
                <div class="module-card-header">
                    <div class="module-card-title">CPF Findy</div>
                    <div class="module-card-icon">👤</div>
                </div>
                <div class="module-card-body">
                    <p class="module-card-description">Consulte usando os 11 digitos , e obtenha informações atualizadas e precisas por categoria!  </p>
                </div>
                <div class="module-card-footer">
                    <div class="card-status">Status: <span>Disponível</span></div>
                    <div class="card-button">Acessar Modulo</div>
                </div>
            </div>
            
            <div class="module-card">
                <div class="module-card-header">
                    <div class="module-card-title">Placa Nacional</div>
                    <div class="module-card-icon">🚗</div>
                </div>
                <div class="module-card-body">
                    <p class="module-card-description">Acesse relatórios detalhados sobre o veiculo desejado , informações sobre propietario entre outros.</p>
                </div>
                <div class="module-card-footer">
                    <div class="card-status">Status: <span>Disponível</span></div>
                    <div class="card-button">Acessar Modulo</div>
                </div>
            </div>
            
            <div class="module-card">
                <div class="module-card-header">
                    <div class="module-card-title">Placa Estadual</div>
                    <div class="module-card-icon">🚗</div>
                </div>
                <div class="module-card-body">
                    <p class="module-card-description">Acesse relatórios detalhados sobre o veiculo desejado , informações sobre propietario entre outros.</p>
                </div>
                <div class="module-card-footer">
                    <div class="card-status">Status: <span>Disponível</span></div>
                    <div class="card-button">Acessar Modulo</div>
                </div>
            </div>
            
            <div class="module-card">
                <div class="module-card-header">
                    <div class="module-card-title">CNPJ Findy</div>
                    <div class="module-card-icon">📜</div>
                </div>
                <div class="module-card-body">
                    <p class="module-card-description">Acesse relatórios detalhados sobre o Juridico do CNPJ desejado , informações sobre Quadro Societario e outros.</p>
                </div>
                <div class="module-card-footer">
                    <div class="card-status">Status: <span>Disponível</span></div>
                    <div class="card-button">Acessar Modulo</div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activities -->
        <section class="recent-activities">
            <h2 class="section-title">Atividades Recentes</h2>
            
            <div class="activity-item">
                <div class="activity-icon">✅</div>
                <div class="activity-details">
                    <div class="activity-message">Modulos dos paineis funcionando!</div>
                    <div class="activity-time">Hoje, 10:23</div>
                </div>
            </div>
            
    </main>
    
    <script>
        // Simple toggle for mobile menu
        document.querySelector('.menu-toggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('sidebar-expanded');
        });
    </script>
</body>
</html>