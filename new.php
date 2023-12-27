<?php

require_once 'connection.php';

$connection = new Connection();
$db_conn = $connection->getConnection();

// Buscar todas colors
$colors_stmt = $db_conn->prepare("SELECT * FROM colors;");
$colors_stmt->execute();
$colors_result = $colors_stmt->fetchAll(PDO::FETCH_ASSOC);

include_once 'layout/header.php';
?>

<main>
    <div class="container py-4">
        <div class="row">
            <div class="offset-1 col-10">
                <h2 style="margin-bottom: 2px;">Editando usuário:
                    <?php echo $result->name; ?>
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="offset-1 col-10">
                <hr style="margin-top: 0px;">
            </div>
        </div>

        <form method="post" action="new_p.php">

            <div class="row">
                <div class="offset-1 col-10">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="name-label">Nome</span>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Nome"
                            aria-label="Nome" aria-describedby="name-label" value="<?php echo $result->name ?>">
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="offset-1 col-10">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="email-label">E-mail</span>
                        <input type="text" id="email" name="email" class="form-control" placeholder="E-mail"
                            aria-label="Email" aria-describedby="email-label" value="<?php echo $result->email ?>">
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="offset-1 col-10">
                    <div class="mb-3">
                        <label for="colors" class="form-label">Cores</label>
                        <select id="colors" name="colors[]" class="form-select" multiple>
                            <?php foreach ($colors_result as $color) { ?>
                                <option value="<?php echo $color['id'] ?>">
                                    <?php echo $color['name'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="offset-1 col-10">
                    <button type="submit" class="btn btn-success">Adicionar</button>
                </div>
            </div>

        </form>

    </div>
</main>

<?php include_once 'layout/footer.php'; ?>