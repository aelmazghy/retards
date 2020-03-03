<?php include ('header.php');
$date = new DateTime();
$date->format('Y-m-d H:i:sP');

$selectRole = $db->query("SELECT role_id FROM users WHERE id=".$_SESSION['id']."");
$selectRole->execute();
$selectRole->setFetchMode(PDO::FETCH_ASSOC);

// select data foreach table
$selectAllEleves = $db->query('SELECT users_id,nom,prenom,telephone FROM users INNER JOIN eleves ON users.id = eleves.users_id');
$selectAllEleves->execute();
$selectAllEleves->setFetchMode(PDO::FETCH_ASSOC);



//insert retard
if(isset($_POST['motif'])){ $motif = $_POST['motif'];}
if(isset($_POST['heureretard'])){ $heureretard = date('Y-m-d').' '.$_POST['heureretard'].':00';} //9999-12-31 23:59:59
if(isset($_POST['id_eleve'])){ $id_eleve = $_POST['id_eleve'];}

if(isset($_POST['validerretard'])){

//id_retard 	id_eleve 	motif 	date_retard formateur_id
    if(empty($heureretard)){
        echo '<div class="alert alert-danger" role="alert">
            Il faut remplir tous les champs</div>
         ';
    }
    else{
    $insertRetard = $db->prepare("INSERT INTO retards (id_eleve, motif, heure_retard, formateur_id) VALUES(?,?,?,?)");
    $insertRetard->execute(array($id_eleve, $motif, $heureretard, $session_id));


    echo "<div class='alert alert-success' role='alert'>
            OK !</div>
         ";
}
}

?>

<?php
if ($selectRole->fetchAll()[0]['role_id'] == '1') {
    echo '




    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Accueil | Faire l\'appel </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content -->
    <div class="content">
        <!-- Animated -->
        <div class="animated fadeIn">
        <div class="addelevebtn">
<a href="/ajouteleve.php"><button type="button" class="btn btn-primary"><i class="fa fa-plus-square-o"></i>Ajouter un élève</button></a>
</div>
<div class="allboxeleve row">

';?>
    <?php

    foreach($selectAllEleves->fetchAll() as $key => $value) {
        echo'
                                        
            <!--form eleve-->
            <div class="col-md-4">
            <form action="index.php" method="POST">
            <input type="hidden" name="id_eleve" value="'.$value['users_id'].'">
                        <section class="card">
                            <div class="twt-feed blue-bg">
                                <div class="media">
                                    <a href="/profile.php?id='.$value['users_id'].'">
                                        <img class="align-self-center rounded-circle mr-3" style="width:85px; height:85px;" alt="" src="images/admin.jpg">
                                    </a>
                                    <div class="media-body">
                                        <h2 class="text-white display-6">'.$value['nom']. ' '.$value['prenom'].'</h2>
                                     </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                    <label class=" form-control-label">Heure retard</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input class="form-control" type="time" name="heureretard" value="'.$date->format('H:i').'">
                                    </div>
                                </div>
                            <div class="twt-write col-sm-12">
                                <textarea placeholder="Motif retard" rows="1" class="form-control t-text-area" name="motif"></textarea>
                            </div>
                            <footer class="twt-footer" style="padding-bottom: 10px;">
                                                    <button type="submit" name="validerretard" class="btn btn-success">Valider</button>

                            </footer>
                        </section>
                        </form>
                    </div>
            <!--form eleve-->
    <?php
    ';
    }
    ?>

    <div class="clearfix"></div>

    </div>
    <!-- .animated -->
    </div>
    <!-- /.content -->
    <div class="clearfix"></div>
    </div>
    <!-- /#right-panel -->


    <?php

}
if ($selectRole->fetchAll()[1]['role_id'] = '2') {
    echo '

Infos adm

';
    ?>
    <?php

}
if ($selectRole->fetchAll()[2]['role_id'] = '3') {
    echo '

Infos eleves

';
    ?>
    <?php

}

?>








<?php include ('footer.php');?>