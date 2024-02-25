<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
<?php 
include("../php/functions_BD.php");
verifieLoginSession();
include("includes/header.php");
$modifie=false;
?><br><br><br>
<h3 class="text-center">Créer votre partie!</h3>
<div class="container d-flex justify-content-center">
    <form id="passwordForm" method="post" class="needs-validation">
        <div class="mb-3">
            <label for="nomPartie" class="form-label">Nom</label>
            <input type="text" name="nomPartie" class="form-control" id="nomPartie" required>
        </div>
  
        <button type="button" id="openConfirmationModal" class="btn btn-primary">Créer</button>
    </form>

    <?php creePartie(); ?>
</div>
</body>
</html>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmation</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de créer cette partie ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <form id="confirmationForm" method="post">
                    <!-- Hidden input field to hold the password value -->
                    <input type="hidden" id="nomPartieValue" name="nomPartieValue">
                    <button type="submit" name="creePartie" class="btn btn-primary">Confirmer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Add event listener to the button that opens the confirmation modal
    document.getElementById("openConfirmationModal").addEventListener("click", function() {
        // Get the password value from the first form
        var password = document.getElementById("nomPartie").value;
        // Check if the password field is empty
        if (password.trim() === "") {
            alert("S'il vous plait éntrer un nom de partie.");
        } else {
            // Set the password value to the hidden input field in the confirmation form
            document.getElementById("nomPartieValue").value = password;
            // Open the confirmation modal
            var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
            myModal.show();
        }
    });
</script>
