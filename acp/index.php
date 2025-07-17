<?php require '../config.php';  
// Consulta para pegar todos os usuários
$stmt = $pdo->query('SELECT * FROM usuarios'); 
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Contador de estatísticas
$total_usuarios = count($usuarios);
$usuarios_ativos = 0;
$usuarios_bloqueados = 0;
$expirando_hoje = 0;

// Data de hoje
$hoje = date('Y-m-d');

foreach ($usuarios as $user) {
    if (!$user['block']) {
        $usuarios_ativos++;
    } else {
        $usuarios_bloqueados++;
    }
    
    if ($user['data_expira'] == $hoje) {
        $expirando_hoje++;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Findy Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary-color: #1976D2;
            --sidebar-color: #0D62C3;
            --sidebar-width: 230px;
            --light-text: #F8F9FA;
            --card-shadow: 0 2px 5px rgba(0,0,0,0.08);
        }
        
        body {
            font-family: 'Segoe UI', 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        
        .sidebar {
            position: fixed;
            width: var(--sidebar-width);
            height: 100vh;
            background-color: var(--sidebar-color);
            color: white;
            padding-top: 20px;
            box-shadow: 3px 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
            overflow-y: auto;
        }
        
        .sidebar-header {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            padding: 15px 10px;
            margin-bottom: 20px;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-menu li {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            color: rgba(255,255,255,0.9);
            font-weight: 500;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .sidebar-menu li:hover {
            background-color: rgba(255,255,255,0.1);
        }
        
        .sidebar-menu li.active {
            background-color: rgba(255,255,255,0.15);
            border-left: 4px solid white;
        }
        
        .sidebar-menu i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .content {
            margin-left: var(--sidebar-width);
            padding: 20px;
        }
        
        .page-header {
            padding: 15px 20px;
            background-color: white;
            box-shadow: var(--card-shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .admin-badge {
            background-color: var(--primary-color);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .stat-card {
            padding: 20px;
            border-radius: 5px;
            box-shadow: var(--card-shadow);
            background-color: white;
            display: flex;
            flex-direction: column;
        }
        
        .stat-icon {
            color: var(--primary-color);
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        .stat-title {
            color: #888;
            font-size: 14px;
            margin-bottom: 8px;
        }
        
        .stat-value {
            font-size: 28px;
            font-weight: 600;
        }
        
        .user-table {
            background-color: white;
            border-radius: 5px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }
        
        .user-table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
        }
        
        .user-table-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #1565C0;
            border-color: #1565C0;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table th {
            border-top: none;
            border-bottom: 1px solid #eee;
            font-weight: 600;
            color: #555;
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .status-active {
            background-color: #e8f5e9;
            color: #2e7d32;
        }
        
        .status-blocked {
            background-color: #ffebee;
            color: #c62828;
        }
        
        .action-btn {
            padding: 5px 8px;
            margin: 0 3px;
        }

        /* Responsivo */
        @media (max-width: 992px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
                overflow: hidden;
            }
            
            .sidebar-header {
                font-size: 18px;
                padding: 10px 0;
            }
            
            .sidebar-menu li span {
                display: none;
            }
            
            .sidebar-menu i {
                margin-right: 0;
                font-size: 18px;
            }
            
            .content {
                margin-left: 60px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">Findy Admin</div>
        <ul class="sidebar-menu">
            <li><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></li>
            <li class="active"><i class="fas fa-users"></i> <span>Usuários</span></li>
            <li><i class="fas fa-check-circle"></i> <span>Aprovações</span></li>
            <li><i class="fas fa-cog"></i> <span>Configurações</span></li>
            <li><i class="fas fa-chart-bar"></i> <span>Relatórios</span></li>
            <li><i class="fas fa-sign-out-alt"></i> <span>Sair</span></li>
        </ul>
    </div>
    
    <!-- Content -->
    <div class="content">
        <div class="page-header">
            <h2>Gerenciamento de Usuários</h2>
            <div class="admin-badge">A</div>
        </div>
        
        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-title">Total de Usuários</div>
                <div class="stat-value"><?= $total_usuarios ?></div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-user-check"></i></div>
                <div class="stat-title">Usuários Ativos</div>
                <div class="stat-value"><?= $usuarios_ativos ?></div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-user-lock"></i></div>
                <div class="stat-title">Usuários Bloqueados</div>
                <div class="stat-value"><?= $usuarios_bloqueados ?></div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-calendar-day"></i></div>
                <div class="stat-title">Expirando Hoje</div>
                <div class="stat-value"><?= $expirando_hoje ?></div>
            </div>
        </div>
        
        <!-- Users Table -->
        <div class="user-table">
            <div class="user-table-header">
                <h3>Lista de Usuários</h3>
                <button class="btn btn-primary" id="btnAddUser"><i class="fas fa-plus"></i> Adicionar Usuário</button>
            </div>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuário</th>
                            <th>Telegram</th>
                            <th>Status</th>
                            <th>Data de Expiração</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $user): ?>
                        <tr id="user-<?= $user['id'] ?>">
                            <td><?= $user['id'] ?></td>
                            <td><?= htmlspecialchars($user['usuario']) ?></td>
                            <td><?= htmlspecialchars($user['telegram']) ?></td>
                            <td>
                                <span class="status-badge <?= $user['block'] ? 'status-blocked' : 'status-active' ?>">
                                    <?= $user['block'] ? 'Bloqueado' : 'Ativo' ?>
                                </span>
                            </td>
                            <td><?= $user['data_expira'] ? date('d/m/Y', strtotime($user['data_expira'])) : 'Não Definida' ?></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary action-btn edit-user" data-id="<?= $user['id'] ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-<?= $user['block'] ? 'success' : 'danger' ?> action-btn toggle-block" 
                                        data-id="<?= $user['id'] ?>" 
                                        data-status="<?= $user['block'] ?>">
                                    <i class="fas fa-<?= $user['block'] ? 'unlock' : 'lock' ?>"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger action-btn delete-user" data-id="<?= $user['id'] ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Modal Adicionar/Editar Usuário -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Adicionar Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm">
                        <input type="hidden" id="userId" name="id" value="">
                        
                        <div class="mb-3">
                            <label for="username" class="form-label">Usuário</label>
                            <input type="text" class="form-control" id="username" name="usuario" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="telegramUser" class="form-label">Telegram</label>
                            <input type="text" class="form-control" id="telegramUser" name="telegram">
                        </div>
                        
                        <div class="mb-3">
                            <label for="expirationDate" class="form-label">Data de Expiração</label>
                            <input type="date" class="form-control" id="expirationDate" name="data_expira">
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="statusCheck" name="block">
                            <label class="form-check-label" for="statusCheck">Usuário Bloqueado</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="saveUser">Salvar</button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Referencias aos elementos
        const userModal = new bootstrap.Modal(document.getElementById('userModal'));
        const userForm = document.getElementById('userForm');
        const modalTitle = document.getElementById('modalTitle');
        const saveUserBtn = document.getElementById('saveUser');
        const addUserBtn = document.getElementById('btnAddUser');
        
        // Botão de adicionar usuário
        addUserBtn.addEventListener('click', function() {
            modalTitle.textContent = 'Adicionar Usuário';
            userForm.reset();
            document.getElementById('userId').value = '';
            userModal.show();
        });
        
        // Botões de editar usuário
        document.querySelectorAll('.edit-user').forEach(btn => {
            btn.addEventListener('click', function() {
                const userId = this.getAttribute('data-id');
                modalTitle.textContent = 'Editar Usuário';
                
                // Em uma aplicação real, você faria uma requisição AJAX para obter os dados do usuário
                // Aqui vamos simular com os dados que já temos na página
                const row = document.getElementById('user-' + userId);
                if (row) {
                    const columns = row.querySelectorAll('td');
                    document.getElementById('userId').value = userId;
                    document.getElementById('username').value = columns[1].textContent.trim();
                    document.getElementById('telegramUser').value = columns[2].textContent.trim();
                    
                    // Extrair data de expiração e formatar para o campo date
                    const dateText = columns[4].textContent.trim();
                    if (dateText !== 'Não Definida') {
                        const dateParts = dateText.split('/');
                        const formattedDate = `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;
                        document.getElementById('expirationDate').value = formattedDate;
                    } else {
                        document.getElementById('expirationDate').value = '';
                    }
                    
                    // Status do checkbox baseado na classe do badge
                    const isBlocked = columns[3].querySelector('.status-badge').classList.contains('status-blocked');
                    document.getElementById('statusCheck').checked = isBlocked;
                    
                    userModal.show();
                }
            });
        });
        
        // Salvar usuário
        saveUserBtn.addEventListener('click', function() {
            // Em uma aplicação real, você faria uma requisição AJAX para salvar os dados
            // Aqui vamos apenas simular o sucesso da operação
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: 'Usuário salvo com sucesso.',
                confirmButtonColor: '#1976D2'
            }).then(() => {
                userModal.hide();
                // Em uma aplicação real, você recarregaria os dados ou atualizaria a tabela
            });
        });
        
        // Botões de toggle block
        document.querySelectorAll('.toggle-block').forEach(btn => {
            btn.addEventListener('click', function() {
                const userId = this.getAttribute('data-id');
                const isBlocked = this.getAttribute('data-status') === '1';
                const actionText = isBlocked ? 'desbloquear' : 'bloquear';
                
                Swal.fire({
                    title: `Confirmar ${actionText}?`,
                    text: `Você está prestes a ${actionText} este usuário.`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#1976D2',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Em uma aplicação real, você faria uma requisição AJAX
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: `Usuário ${isBlocked ? 'desbloqueado' : 'bloqueado'} com sucesso.`,
                            confirmButtonColor: '#1976D2'
                        });
                        
                        // Atualizar visualmente na tabela (simulação)
                        const row = document.getElementById('user-' + userId);
                        if (row) {
                            const statusCell = row.querySelectorAll('td')[3];
                            const badge = statusCell.querySelector('.status-badge');
                            const newStatus = !isBlocked;
                            
                            if (newStatus) {
                                badge.classList.remove('status-active');
                                badge.classList.add('status-blocked');
                                badge.textContent = 'Bloqueado';
                            } else {
                                badge.classList.remove('status-blocked');
                                badge.classList.add('status-active');
                                badge.textContent = 'Ativo';
                            }
                            
                            // Atualizar o botão
                            this.setAttribute('data-status', newStatus ? '1' : '0');
                            this.classList.remove('btn-outline-danger', 'btn-outline-success');
                            this.classList.add(newStatus ? 'btn-outline-success' : 'btn-outline-danger');
                            
                            const icon = this.querySelector('i');
                            icon.classList.remove('fa-lock', 'fa-unlock');
                            icon.classList.add(newStatus ? 'fa-unlock' : 'fa-lock');
                        }
                    }
                });
            });
        });
        
        // Botões de excluir usuário
        document.querySelectorAll('.delete-user').forEach(btn => {
            btn.addEventListener('click', function() {
                const userId = this.getAttribute('data-id');
                
                Swal.fire({
                    title: 'Tem certeza?',
                    text: "Esta ação não pode ser revertida!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1976D2',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: 'Sim, excluir!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Em uma aplicação real, você faria uma requisição AJAX
                        Swal.fire({
                            icon: 'success',
                            title: 'Excluído!',
                            text: 'Usuário excluído com sucesso.',
                            confirmButtonColor: '#1976D2'
                        });
                        
                        // Remover visualmente da tabela (simulação)
                        const row = document.getElementById('user-' + userId);
                        if (row) {
                            row.remove();
                            
                            // Atualizar contadores (simulação)
                            const totalEl = document.querySelector('.stats-grid .stat-card:nth-child(1) .stat-value');
                            const ativosEl = document.querySelector('.stats-grid .stat-card:nth-child(2) .stat-value');
                            const bloqueadosEl = document.querySelector('.stats-grid .stat-card:nth-child(3) .stat-value');
                            
                            if (totalEl) {
                                totalEl.textContent = parseInt(totalEl.textContent) - 1;
                            }
                            
                            // Determinar se o usuário era ativo ou bloqueado
                            const statusCell = row.querySelectorAll('td')[3];
                            const badge = statusCell.querySelector('.status-badge');
                            const isBlocked = badge.classList.contains('status-blocked');
                            
                            if (isBlocked && bloqueadosEl) {
                                bloqueadosEl.textContent = parseInt(bloqueadosEl.textContent) - 1;
                            } else if (!isBlocked && ativosEl) {
                                ativosEl.textContent = parseInt(ativosEl.textContent) - 1;
                            }
                        }
                    }
                });
            });
        });
    });
    </script>
</body>
</html>