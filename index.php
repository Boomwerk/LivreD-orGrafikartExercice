<?php
require_once "class/Message.php";
require_once "class/GuestBook.php";

$errors = null;
$succes = false;
$guestbook = new GuestBook(__DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'messages');
if(isset($_POST["username"], $_POST["message"])){
    $message = new Message($_POST["username"], $_POST["message"]);
    if($message->isValid()){
        $guestbook->addMessage($message);
        $succes = true;
        $_POST = [];
    } else {
        $errors =  $message->getErrors();
    }
}
$messages = $guestbook->getMessages();
$title = "Livre d'or";
require "elements/header.php";
?>

<div class="container">
    <h1>Livre d'or</h1>

    <?php if(!empty($errors)): ?>

        <div class="alert alert-danger">
                Formulaire Invalide
        </div>
    <?php endif ?>

    <?php if($succes === true): ?>

        <div class="alert alert-success">
            Merci Pour Votre Message
        </div>
    <?php endif ?>
    
    

    <form action="" method="post">
        <div class="form-group">
            <input value="<?= htmlentities($_POST['username'] ?? '') ?>" type="text" name="username" placeholder="Veuillez entrez votre pseudo" class="form-control <?= isset($errors['message']) ? 'is-invalid': '' ?>">
            <?php if(isset($errors)):?>
                <div class="invalid-feedback"><?= $errors['username']; ?></div>
            <?php endif ?>
            
        </div>
        <div class="form-group">
            <textarea name="message" placeholder="Veuillez entrez votre message" class="form-control <?= isset($errors['message']) ? 'is-invalid': '' ?>"><?= htmlentities($_POST['message'] ?? '') ?></textarea>
            <?php if(isset($errors)):?>
                <div class="invalid-feedback"><?= $errors['message']; ?></div>
            <?php endif ?>
        </div>
        <button class="btn btn-primary"> Envoyer </button>
    </form>
    <?php foreach($messages as $message): ?>
    <?= $message->toHTML(); ?>
    <?php endforeach; ?>
</div>

<?php 
require "elements/footer.php";
?>