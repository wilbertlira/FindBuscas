function searchUser() {
    const searchInput = document.getElementById('searchInput').value;
    if (searchInput) {
        // Realize uma requisição AJAX para buscar usuários com o nome ou telegram fornecido
        fetch(`search_user.php?query=${searchInput}`)
            .then(response => response.json())
            .then(data => {
                // Atualizar a tabela com os dados de pesquisa
                const tableBody = document.querySelector('#userTable tbody');
                tableBody.innerHTML = ''; // Limpar tabela antes de adicionar os resultados
                data.forEach(user => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${user.id}</td>
                        <td>${user.usuario}</td>
                        <td>${user.telegram}</td>
                        <td>${user.block ? 'Bloqueado' : 'Ativo'}</td>
                        <td>
                            <button onclick="editUser(${user.id})">Editar</button>
                            <button onclick="deleteUser(${user.id})">Excluir</button>
                            <button onclick="toggleBlock(${user.id}, ${user.block})">${user.block ? 'Desbloquear' : 'Bloquear'}</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            });
    }
}

function editUser(userId) {
    // Redireciona para a página de edição do usuário
    window.location.href = `edit_user.php?id=${userId}`;
}

// Função para excluir um usuário
function deleteUser(userId) {
    Swal.fire({
        title: 'Tem certeza?',
        text: 'Você não poderá reverter isso!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('delete_user.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${userId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Excluído!', 'O usuário foi excluído com sucesso.', 'success');
                    document.getElementById(`user-${userId}`).remove();
                } else {
                    Swal.fire('Erro!', data.message, 'error');
                }
            })
            .catch(error => Swal.fire('Erro!', 'Não foi possível excluir o usuário.', 'error'));
        }
    });
}

// Função para bloquear/desbloquear usuário
function toggleBlock(userId, currentStatus) {
    let newStatus = currentStatus ? 0 : 1; // Se o usuário está bloqueado, desbloqueia e vice-versa

    Swal.fire({
        title: currentStatus ? 'Desbloquear usuário?' : 'Bloquear usuário?',
        text: currentStatus ? 'Você deseja desbloquear este usuário?' : 'Você deseja bloquear este usuário?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: currentStatus ? 'Sim, desbloquear!' : 'Sim, bloquear!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('toggle_block.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id=${userId}&block=${newStatus}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Sucesso!', 'O status foi atualizado com sucesso.', 'success');
                    setTimeout(() => {
                        location.reload(); // Recarrega a página para refletir as mudanças
                    }, 1000); // Delay de 1 segundo antes de recarregar
                } else {
                    Swal.fire('Erro!', data.message, 'error');
                }
            })
            .catch(error => Swal.fire('Erro!', 'Não foi possível atualizar o status.', 'error'));
        }
    });
}
