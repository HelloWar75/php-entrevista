<?php

require_once 'connection.php';

$connection = new Connection();
$db_conn = $connection->getConnection();

// verificar se veio parametro id
if (empty($_GET['id'])) {
    header('Location: index.php?error=5');
}

$id = $_GET['id'];

$query = "SELECT * FROM users WHERE id = :id";
$stmt = $db_conn->prepare($query);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);
$result = $result ? (object) $result : null;

// Buscar todas colors
$colors_stmt = $db_conn->prepare("SELECT * FROM colors;");
$colors_stmt->execute();

$colors_result = $colors_stmt->fetchAll(PDO::FETCH_ASSOC);

// Buscar colors do usuario
$user_colors_query = "SELECT * FROM user_colors WHERE user_id = :user_id";
$user_colors_stmt = $db_conn->prepare($user_colors_query);
$user_colors_stmt->bindParam(':user_id', $result->id, PDO::PARAM_INT);
$user_colors_stmt->execute();
$user_colors_result = $user_colors_stmt->fetchAll(PDO::FETCH_ASSOC);

$color_array = [];

foreach ($user_colors_result as $c) {
    array_push($color_array, (string) $c['color_id']);
}

include_once 'layout/header.php';
?>

<main>
    <div class="container py-4">
        <div class="row">
            <div class="offset-1 col-10">
                <h2 style="margin-bottom: 2px;">Visualizando usuário:
                    <?php echo $result->name; ?>
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="offset-1 col-10">
                <hr style="margin-top: 0px;">
            </div>
        </div>


        <div class="row">
            <div class="offset-1 col-10">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="name-label">Nome</span>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Nome" aria-label="Nome"
                        aria-describedby="name-label" value="<?php echo $result->name ?>" disabled>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="offset-1 col-10">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="email-label">E-mail</span>
                    <input type="text" id="email" name="email" class="form-control" placeholder="E-mail"
                        aria-label="Email" aria-describedby="email-label" value="<?php echo $result->email ?>" disabled>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="offset-1 col-10">
                <div class="mb-3">
                    <label for="colors" class="form-label">Cores</label>
                    <select id="colors" name="colors[]" class="form-select" multiple disabled>
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
                <a class='btn btn-danger btn-sm' role='button' href='index.php'>Voltar</a>
            </div>
        </div>



    </div>
</main>

<script>
    var colorsSelect = document.getElementById("colors");
    var selectedOptions = <?php echo json_encode($color_array); ?>;

    for (var i = 0; i < colorsSelect.options.length; i++) {
        if (selectedOptions.includes(colorsSelect.options[i].value)) {
            colorsSelect.options[i].selected = true;
        }
    }
</script>

<?php include_once 'layout/footer.php'; ?>