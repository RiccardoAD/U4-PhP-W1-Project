<?php
include __DIR__ . '/includes/dbconnect.php';
$stmt = $pdo->prepare('SELECT * FROM libri');
$stmt->execute();

$books = $stmt->fetchAll();
$errors = [];


include __DIR__ . '/includes/head.php';
?>
<div class="container mt-4">
    <div class="row">
        <div class="col-6">
            <h1 class="text-center pt-5">Inserisci il tuo Libro</h1>
            <form action="" method="post" class="pt-2 d-flex flex-column" novalidate>

                <div class="row mb-3">
                    <label class="col-4 pt-3" for="titolo">Titolo</label>
                    <div class="col-8">
                        <input class="form-control mt-2 w-100" type="text" name="titolo" id="titolo" placeholder="Inserisci il titolo">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-4 pt-3" for="autore">Autore</label>
                    <div class="col-8">
                        <input class="form-control mt-2 w-100" type="text" name="autore" id="autore" placeholder="Inserisci l'autore">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-4 pt-3" for="anno_pubblicazione">Data pubblicazione</label>
                    <div class="col-8">
                        <input class="form-control mt-2 w-100" type="number" name="anno_pubblicazione" id="anno_pubblicazione">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-4 pt-3" for="genere">Genere</label>
                    <div class="col-8">
                        <input type="text" name="genere" id="genere" placeholder="Inserisci il genere" class="form-control mt-2 w-100">
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success w-25 mt-4">Invia</button>
                </div>
            </form>
        </div>
        <div class="col-6">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $name = $_POST['titolo'];
                $autore = $_POST['autore'];
                $anno_pubblicazione = $_POST['anno_pubblicazione'];
                $genere = $_POST['genere'];

                if (empty($name)) {
                    $errors['titolo'] = 'Inserisci un titolo';
                }

                if (empty($autore)) {
                    $errors['autore'] = 'Inserisci un autore';
                }

                if (empty($anno_pubblicazione)) {
                    $errors['anno_pubblicazione'] = 'Inserisci un anno di pubblicazione';
                }

                if (empty($genere)) {
                    $errors['genere'] = 'Inserisci un genere';
                }

                if (!empty($errors)) {
                    echo '<div class="container mt-4 pt-5">';
                    echo '<h2 class="text-danger text-center">Ops! Inserisci i dati corretti!</h2>';
                    echo '<div class="alert alert-danger" role="alert">';
                    echo '<h4 class="alert-heading">Ci sono errori nel modulo:</h4>';
                    echo '<ul>';
                    foreach ($errors as $error) {
                        echo '<li>' . $error . '</li>';
                    }
                    echo '</ul>';
                    echo '</div>';
                    echo '</div>';
                } else {

                    $stmt = $pdo->prepare("INSERT INTO libri (titolo, autore, anno_pubblicazione, genere) VALUES (?, ?, ?, ?)");


                    $stmt->execute([$name, $autore, $anno_pubblicazione, $genere]);

                    header('Location: index.php');
                    exit;
                }
            }
            ?>
        </div>
        <div class="container mt-5">
            <h1>LIBRARY</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">TITOLO</th>
                        <th scope="col">AUTORE</th>
                        <th scope="col">ANNO</th>
                        <th scope="col">GENERE</th>
                        <th scope="col">Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($books as $book) {
                        echo "<tr>";
                        echo "<th scope='row'>$i</th>";
                        echo "<td>{$book['titolo']}</td>";
                        echo "<td>{$book['autore']}</td>";
                        echo "<td>{$book['anno_pubblicazione']}</td>";
                        echo "<td>{$book['genere']}</td>";
                        echo "<td>
                        <a href='./delete.php?id={$book['id']}' class='btn btn-danger'>Delete</a>
                        <a href='./modify.php?id={$book['id']}' class='btn btn-dark'>Modify</a>
                      </td>";
                        echo "</tr>";
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        </body>

        </html>