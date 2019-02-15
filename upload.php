<?php
require_once("includes/header.php");
require_once("includes/markupRenderers/VideoDetailsFormProvider.php");

if (!User::isLoggedIn()) {
   header("Location: login.php");
}
?>

<div class="column">
   <?php
    $formProvider = new VideoDetailsFormProvider($db);
    echo $formProvider->createVideoUploadForm();
    ?>
</div>

<script>
$("form").submit(function() {
    $("#loadingModal").modal("show");
});
</script>

<div
    class="modal fade"
    id="loadingModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="loadingModal"
    aria-hidden="true"
    data-backdrop="static"
    data-keyboard="false"
>
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">     
      <div class="modal-body">
        Uploading Video. This might take a while. <br/>
        Please do no refresh your browser.
        <img src="assets/images/icons/loading-spinner.gif">
      </div>
    </div>
  </div>
</div>

<?php require_once("includes/footer.php"); ?>
                
