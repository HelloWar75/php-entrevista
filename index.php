<?php
require 'loader.php';

$userDao = new UserDao($db);
$users = $userDao->getAll();

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
        if (notifyExists()) {
            ?>
            <div class="row">
                <div class="offset-1 col-10">
                    <div class="alert alert-<?php echo $_SESSION['notify_type'] ?> alert-dismissible fade show"
                        role="alert">
                        <?php echo $_SESSION['notify_msg'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <?php
            notifyReset();
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
                        <?php foreach ($users as $user) { ?>
                            <tr>
                                <td scope='row'><a href='view.php?id=<?php echo $user->getId() ?>'>
                                        <?php echo $user->getId() ?>
                                    </a></td>
                                <td>
                                    <?php echo $user->getName() ?>
                                </td>
                                <td>
                                    <?php echo $user->getEmail() ?>
                                </td>
                                <td>
                                    <a class='btn btn-warning btn-sm' role='button'
                                        href='edit.php?id=<?php echo $user->getId() ?>'>Editar</a>
                                    <a class='btn btn-danger btn-sm' role='button' onclick='return checkDelete()'
                                        href='delete.php?id=<?php echo $user->getId() ?>'>Excluir</a>
                                </td>
                            </tr>
                        <?php } ?>
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