<!DOCTYPE html>
<html>
<head>
    <?php include('templates/head.php') ?>
    <?php include('templates/administrate_includes.php') ?>

    <title>Administrer les produits</title>

    <script src="js/administrate.js"></script>
    <script src="js/administrate_users.js"></script>
    <link rel="stylesheet" type="text/css" href="css/administrate.css"/>
</head>
<body>

    <?php include('templates/nav.php') ?>

    <main>
   
        <h1 class="text-center">Gestion des usager.es</h1>

        <hr>

        <div class="container bg-light p-5">
            <div>
                <h2>Liste des usager.es</h2>

                <form class="float-right mb-2">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="i-search">Rechercher</label>
                        </div>
                        <input id="i-search" class="form-control filter" data-tablefilter="#table" type="search" placeholder="Nom, numéro étudiant.e ...">
                    </div>
                </form>

                <table id="table" class="table table-hover table-sm sortable-table table-striped bg-light">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Numéro étudiant.e</th>
                            <th scope="col" class="sortable">Nom</th>
                            <th scope="col" class="sortable">Adhérent.e</th>
                            <th scope="col" class="sortable">Niveau d'autorisation</th>
                            <th scope="col" class="sortable">Crédit</th>
                            <th scope="col" class="sortable">Actif</th>
                            <th></th> 
                        </tr>
                    </thead>
                    <tbody>
<?php

    // Include the database connection file
    require_once('lib/connect.php');

    // Connect to the database
    $connection = connectToDatabase();
    if($connection == FALSE) {
        echo '<p>Il y a eu une erreur ...</p>';
        exit();
    }

    $req = 'SELECT id, student_number, username, bdlc_member, auth_level, credit, activated FROM users';
    if($result = $connection->query($req)) {
        while($user = $result->fetch_array()) {
?>
                        <tr>
                            <th scope="row"><?php echo htmlspecialchars($user['id']); ?></th>
                            <td>
                                <a href="#" class="user-student-number" data-pk="<?php echo htmlspecialchars($user['id']); ?>">
                                    <?php echo htmlspecialchars($user['student_number']); ?>
                                </a>
                            </td>
                            <td>
                                <a href="#" class="user-username" data-pk="<?php echo htmlspecialchars($user['id']); ?>">
                                    <?php echo htmlspecialchars($user['username']); ?>
                                </a>
                            </td>
                            <td>
                                <a href="#" class="user-bdlc-member" data-value="<?php echo htmlspecialchars($user['bdlc_member']); ?>" data-pk="<?php echo htmlspecialchars($user['id']); ?>"></a>
                            </td>
                            <td>
                                <a href="#" class="user-auth-level" data-pk="<?php echo htmlspecialchars($user['id']); ?>" data-value="<?php echo htmlspecialchars($user['auth_level']); ?>"></a>
                            </td>
                            <td>
                                <a href="#" class="user-credit" data-pk="<?php echo htmlspecialchars($user['id']); ?>"><?php echo htmlspecialchars($user['credit']); ?></a>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($user['activated']); ?>
                            </td>
                            <td>
                                <a class="delete-row" href="lib/admin/user_delete.php?id=<?php echo htmlspecialchars($user['id']); ?>">
                                    <button type="button" title="Supprimer l'élément" class="btn btn-outline-danger">
                                        <i class="oi oi-x"></i>
                                    </button>
                                </a>
                            </td>
                        </tr>
<?php
        }
    }

    $connection->close();
?>
                    </tbody>
                </table>
            </div>

            <hr>

            <div>

                <h2>Ajouter un.e utilisateurice</h2>

                <form id="add-user-form" class="form-check" method="post" action="lib/admin/user_add.php">
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="i-user-student-number">Numéro d'étudiant.e</label>
                            <input class="form-control" type="number" min="0" id="i-user-student-number" name="student_number" placeholder="ex : 182355" required>
                        </div>
                        <div class="form-group col">
                            <label for="i-user-username">Nom</label>
                            <input class="form-control" type="text" id="i-user-username" name="username" placeholder="ex : Tom de Pasquale" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="i-user-bdlc-member">Adhérent.e au BDLC</label>
                            <input class="form-control form-check-input" type="checkbox" id="i-user-bdlc-member" name="bdlc_member">
                        </div>
                        <div class="form-group col">
                            <label for="i-auth-level">Niveau d'autorisation</label>
                            <select class="form-control" id="i-auth-level" name="auth_level" selected="0">
                                <option value="0">Étudiant.e</option>
                                <option value="1">Barista</option>
                                <option value="2">Administrateurice</option>
                            </select>
                        </div>
                        <div class="form-group col">
                            <label class="" for="i-user-credit">Crédit</label>
                            <input class="form-control" type="number" step="0.01" min="0" id="i-user-credit" name="credit" value="0" placeholder="ex : 5.50" required>
                        </div>
                    </div>
                    <button id="add-user-submit" type="submit" class="btn btn-primary" name="submit">Ajouter</button>
                </form> 
            </div>
        </div>

            <div id="add-success-message" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog">
            <div class="modal-dialog modal modal-dialog-centered">
                <div class="modal-content bg-success">
                    <div class="modal-body">
                        <h5 class="modal-title text-white" id="exampleModalLabel">L'utilisateurice a bien été ajouté !</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                            <span class="text-white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="add-error-message" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog">
            <div class="modal-dialog modal modal-dialog-centered">
                <div class="modal-content bg-danger">
                    <div class="modal-body">
                        <h5 class="modal-title text-white" id="exampleModalLabel">Il y a eu un problème lors de l'ajout de l'utilisateurice ... (oups)</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                            <span class="text-white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="delete-success-message" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog">
            <div class="modal-dialog modal modal-dialog-centered">
                <div class="modal-content bg-success">
                    <div class="modal-body">
                        <h5 class="modal-title text-white" id="exampleModalLabel">L'utilisateurice a bien été supprimé (de la base de donnée bien entendu). Iel va toujours bien rassurez-vous !</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                            <span class="text-white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="delete-error-message" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog">
            <div class="modal-dialog modal modal-dialog-centered">
                <div class="modal-content bg-danger">
                    <div class="modal-body">
                        <h5 class="modal-title text-white" id="exampleModalLabel">Il y a eu un problème lors de la suppression de l'utilisateurice ... Espérons qu'iel soit encore en un morceau !</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                            <span class="text-white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>