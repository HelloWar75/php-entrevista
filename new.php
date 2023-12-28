<?php
require 'loader.php';

try {
    $colorDao = new ColorDao($db);
    $colors = $colorDao->getAll();
} catch (Exception $e) {
    notifyAndRedir('danger', $e->getMessage(), 'index.php');
}

include_once 'layout/header.php';
?>

<main>
    <div class="container py-4">
        <div class="row">
            <div class="offset-1 col-10">
                <h2 style="margin-bottom: 2px;">Adicionar Usuário
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
                            aria-label="Nome" aria-describedby="name-label">
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="offset-1 col-10">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="email-label">E-mail</span>
                        <input type="text" id="email" name="email" class="form-control" placeholder="E-mail"
                            aria-label="Email" aria-describedby="email-label">
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="offset-1 col-10">
                    <div class="mb-3">
                        <label for="colors" class="form-label">Cores</label>
                        <select id="colors" name="colors[]" class="form-select" multiple>
                            <?php foreach ($colors as $color) { ?>
                                <option value="<?php echo $color->getId() ?>">
                                    <?php echo $color->getName() ?>
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