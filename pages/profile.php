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
<h3 class="text-center">Modifier votre mot de passe</h3>
<?php if(isset($_COOKIE["ModifieTrue"])) :?>
    <h6 class="text-center text-success">Mot de passe est modifié!</h6>
<?php endif; ?>
<div class="container d-flex justify-content-center">
    <form id="passwordForm" method="post" class="needs-validation">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Nom</label>
            <input type="email" value="<?php echo $_SESSION['user']['pseudo']; ?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" disabled>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" name="newMdp" class="form-control" id="exampleInputPassword1" required>
        </div>
  
        <button type="button" id="openConfirmationModal" class="btn btn-primary">Modifie</button>
    </form>

    <?php updatePassword(); ?>
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
                Êtes-vous sûr de modifier votre mot de passe ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <form id="confirmationForm" method="post">
                    <!-- Hidden input field to hold the password value -->
                    <input type="hidden" id="passwordValue" name="newMdp">
                    <button type="submit" name="updateP" class="btn btn-primary">Confirmer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Add event listener to the button that opens the confirmation modal
    document.getElementById("openConfirmationModal").addEventListener("click", function() {
        // Get the password value from the first form
        var password = document.getElementById("exampleInputPassword1").value;
        // Check if the password field is empty
        if (password.trim() === "") {
            alert("S'il vous plait éntrer un mot de passe!.");
        } else {
            // Set the password value to the hidden input field in the confirmation form
            document.getElementById("passwordValue").value = password;
            // Open the confirmation modal
            var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
            myModal.show();
        }
    });
</script>
