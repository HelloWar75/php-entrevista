<?php
require 'connection.php';

$connection = new Connection();
$users = $connection->query("SELECT * FROM users");



?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container">
                <a class="navbar-brand" href="#">UserSys</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Usuários</a>
                        </li>

                    </ul>

                </div>
            </div>
        </nav>
    </header>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <script language="JavaScript" type="text/javascript">
        function checkDelete() {
            return confirm('Certeza que deseja deletar o usuário permanentemente ?');
        }
    </script>

</body>

</html>