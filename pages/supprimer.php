<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Admin</title>
</head>
<body>
    
<?php 
include("../php/functions_BD.php");
verifieLoginSession();
include("includes/header.php");
verifieAdmin();

?>

<h3 class="text-center">Supprimer votre partie!</h3>
<div class="container d-flex justify-content-center">
    <form id="passwordForm" method="post" class="needs-validation">
        <div class="mb-3">
        <label for="adversaire" class="form-label">Partie</label>
        <select name="adversaire" id="advS" class="form-select" aria-label="Default select example">
            <?php if(partiesAsOptions()) : ?>
            <option selected disabled hidden value="">Choisir la partie!</option>
            <?php else :?>
                <option selected disabled hidden value="non">Accune partie est en cours!</option>
            <?php endif; ?>
        </select>
        </div>
  
        <button type="button" id="openConfirmationModal" class="btn btn-primary">Supprimer</button>
    </form>

    <?php supprimerPartie(); ?>
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
                Êtes-vous sûr de supprimer cette partie ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <form id="confirmationForm" method="post">
                    <!-- Hidden input field to hold the password value -->
                    <input type="hidden" id="adversaireValue" name="partieId">
                    <button type="submit" name="supprimer" class="btn btn-primary">Confirmer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Add event listener to the button that opens the confirmation modal
    document.getElementById("openConfirmationModal").addEventListener("click", function() {
        var advS = document.getElementById("advS").value;
        // Check if the password field is empty
        if(advS.trim() === ""){
            alert("S'il vous plait choisir la partie a supprimer.");
        }else if(advS.trim() == "non"){
            alert("Déslole mais accune partie est en cours!.");
        }
        else {
            document.getElementById("adversaireValue").value = advS;
            var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
            myModal.show();
        }
    });
</script>
