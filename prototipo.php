<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Findy Dashboard</title>
    <style>
        :root {
            --primary-blue: #2196F3;
            --primary-dark-blue: #1976D2;
            --light-blue: #64B5F6;
            --white: #FFFFFF;
            --light-gray: #F5F5F5;
            --dark-gray: #616161;
            --medium-gray: #9E9E9E;
            --green: #4CAF50;
            --yellow: #FFC107;
            --red: #F44336;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--light-gray);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Header */
        .header {
            background-color: var(--primary-blue);
            color: var(--white);
            padding: 20px;
            border-radius: 0 0 15px 15px;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .btn-solicitar {
            background-color: var(--white);
            color: var(--primary-blue);
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .btn-solicitar:hover {
            background-color: #f0f0f0;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background-color: var(--primary-dark-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: bold;
        }
        
        /* Main Content */
        .dashboard {
            margin-top: 30px;
        }
        
        .welcome-card {
            background-color: var(--white);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .welcome-card h2 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .welcome-card p {
            color: var(--dark-gray);
        }
        
        /* Stat Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }
        
        .stat-card {
            background-color: var(--white);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .stat-title {
            font-size: 0.9rem;
            color: var(--medium-gray);
            margin-bottom: 5px;
        }
        
        .stat-value {
            font-size: 1.8rem;
            font-weight: bold;
        }
        
        .total-value { color: #333; }
        .approved-value { color: var(--green); }
        .pending-value { color: var(--yellow); }
        .growth-value { color: var(--primary-blue); }
        
        /* Tables */
        .data-table {
            background-color: var(--white);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
        }
        
        .data-table h3 {
            margin-bottom: 15px;
            color: #333;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            text-align: left;
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            color: var(--medium-gray);
            font-weight: 600;
        }
        
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }
        
        .status-chip {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-approved {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--green);
        }
        
        .status-pending {
            background-color: rgba(255, 193, 7, 0.1);
            color: var(--yellow);
        }
        
        .status-rejected {
            background-color: rgba(244, 67, 54, 0.1);
            color: var(--red);
        }
        
        /* Form Section */
        .form-section {
            background-color: var(--white);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .form-section h3 {
            margin-bottom: 15px;
            color: #333;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: var(--dark-gray);
        }
        
        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }
        
        .btn-primary {
            background-color: var(--primary-blue);
            color: var(--white);
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark-blue);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .header-content {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">Findy Dashboard</div>
                <div class="header-actions">
                    <button class="btn-solicitar">Solicitar Aprovação</button>
                    <div class="user-avatar">AS</div>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <div class="container">
        <main class="dashboard">
            <!-- Welcome Card -->
            <section class="welcome-card">
                <h2>Bem-vindo ao Dashboard Administrativo</h2>
                <p>Gerencie solicitações de aprovação e monitore o crescimento de usuários na plataforma Findy.</p>
            </section>
            
            <!-- Stat Cards -->
            <section class="stats-container">
                <div class="stat-card">
                    <div class="stat-title">Total de Usuários</div>
                    <div class="stat-value total-value">3,245</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-title">Aprovados</div>
                    <div class="stat-value approved-value">2,876</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-title">Pendentes</div>
                    <div class="stat-value pending-value">369</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-title">Crescimento Semanal</div>
                    <div class="stat-value growth-value">+12.4%</div>
                </div>
            </section>
            
            <!-- Recent Users Table -->
            <section class="data-table">
                <h3>Usuários Recentes</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Status</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Carlos Silva</td>
                            <td><span class="status-chip status-approved">Aprovado</span></td>
                            <td>28/03/2025</td>
                            <td><a href="#">Ver detalhes</a></td>
                        </tr>
                        <tr>
                            <td>Maria Santos</td>
                            <td><span class="status-chip status-pending">Pendente</span></td>
                            <td>29/03/2025</td>
                            <td><a href="#">Ver detalhes</a></td>
                        </tr>
                        <tr>
                            <td>João Pereira</td>
                            <td><span class="status-chip status-approved">Aprovado</span></td>
                            <td>29/03/2025</td>
                            <td><a href="#">Ver detalhes</a></td>
                        </tr>
                        <tr>
                            <td>Ana Oliveira</td>
                            <td><span class="status-chip status-rejected">Reprovado</span></td>
                            <td>30/03/2025</td>
                            <td><a href="#">Ver detalhes</a></td>
                        </tr>
                    </tbody>
                </table>
            </section>
            
            <!-- Approval Form -->
            <section class="form-section">
                <h3>Solicitar Aprovação</h3>
                <form>
                    <div class="form-group">
                        <label for="name">Nome Completo</label>
                        <input type="text" id="name" class="form-control" placeholder="Digite seu nome completo">
                    </div>
                    
                    <div class="form-group">
                        <label for="telegram">Usuário do Telegram</label>
                        <input type="text" id="telegram" class="form-control" placeholder="@seu_usuario">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" class="form-control" placeholder="seu@email.com">
                    </div>
                    
                    <div class="form-group">
                        <label for="reason">Motivo da Solicitação</label>
                        <textarea id="reason" class="form-control" rows="4" placeholder="Descreva brevemente o motivo da sua solicitação"></textarea>
                    </div>
                    
                    <button type="submit" class="btn-primary">Enviar Solicitação</button>
                </form>
            </section>
        </main>
    </div>
</body>
</html>