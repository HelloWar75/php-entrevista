<?php
require 'connection.php';

$connection = new Connection();
$users = $connection->query("SELECT * FROM users");

include_once 'layout/header.php';

?>

<main>
    <div class="container py-4">
        <div class="row">
            <div class="offset-1 col-9">
                <h2 style="margin-bottom: 2px;">Lista de usuários</h2>
            </div>
            <div class="col-1">
                <a class="btn btn-primary btn-sm" href="new.php" role="button">Novo</a>
            </div>
        </div>
        <div class="row">
            <div class="offset-1 col-10">
                <hr style="margin-top: 0px;">
            </div>
        </div>


        <!-- NOTIFICATIONS START -->
        <?php
        // Usuario deletado com sucesso!
        if (!empty($_GET['info']) && $_GET['info'] === '1') {
            ?>
            <div class="row">
                <div class="offset-1 col-10">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Usuário deletado com sucesso!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>

        <?php
        // Usuario deletado com sucesso!
        if (!empty($_GET['info']) && $_GET['info'] === '2') {
            ?>
            <div class="row">
                <div class="offset-1 col-10">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Usuário atualizado com sucesso!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>

        <?php
        // Erro ao deletar usuario!
        if (!empty($_GET['error']) && $_GET['error'] === '1') {
            ?>
            <div class="row">
                <div class="offset-1 col-10">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Erro ao deletar o usuário, tente novamente!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>

        <?php
        // Erro ao deletar usuario!
        if (!empty($_GET['error']) && $_GET['error'] === '2') {
            ?>
            <div class="row">
                <div class="offset-1 col-10">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Usuário não existe erro ao tentar editar!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>

        <?php
        // Erro ao deletar usuario!
        if (!empty($_GET['error']) && $_GET['error'] === '3') {
            ?>
            <div class="row">
                <div class="offset-1 col-10">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Erro ao atualizar o usuário tente novamente!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <!-- NOTIFICATIONS END -->

        <div class="row py-3">
            <div class="offset-1 col-10">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) {
                            echo sprintf("<tr scope='row'>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>
                                     <a class='btn btn-warning btn-sm' role='button' href='edit.php?id=%s'>Editar</a>
                                     <a class='btn btn-danger btn-sm' role='button' onclick='return checkDelete()' href='delete.php?id=%s'>Excluir</a>
                                </td>
                             </tr>",
                                $user->id, $user->name, $user->email, $user->id, $user->id);
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script language="JavaScript" type="text/javascript">
    function checkDelete() {
        return confirm('Certeza que deseja deletar o usuário permanentemente ?');
    }
</script>

<?php include_once 'layout/footer.php'; ?>