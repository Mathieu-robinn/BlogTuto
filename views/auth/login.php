<?php

use App\Connection;
use App\Model\User;
use App\HTML\Form;
use App\Table\Exception\NotFoundException;
use App\Table\UserTable;

$user = new User();
$errors = [];
if(!empty($_POST)){
    $user->setUsername($_POST['username']);
    $errors['password'] = 'Identifiant ou mot de passe incorrect';

    if(!empty($_POST['username']) && !empty($_POST['password'])){
        $table = new UserTable(Connection::getPDO());
        try{
            $u = $table->findByusername($_POST['username']);
            if (password_verify($_POST['password'], $u->getPassword()) ===  true){
                session_start();
                $_SESSION['auth'] = $u->getID();
                header('Location: '. $router->url('admin_posts'));
                exit();
            }   

        }catch(NotFoundException){
        }
    }
}

$form = new Form($user, $errors);

?>

<h1>Se connecter</h1>

<?php if(isset($_GET['forbidden'])) { ?>
<div class="alert alert-danger">
    Vous ne pouvez pas accèder à cette page
</div>
<?php } ?>

<form action="<?= $router->url('login') ?>" method="POST">
    <?= $form->input('username', 'Nom d\'utilisateur') ?>
    <?= $form->input('password', 'Mot de passe')?>
    <button type="submit" class="btn btn-primary">Se connecter</button>
</form>