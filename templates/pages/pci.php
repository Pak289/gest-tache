<?php
    include_once('../../config/basic.php');
    session_start();

    if(isset($_SESSION['user'])) {
        $user = unserialize($_SESSION['user']);
        include_once('../generic/head.php'); //Add HEAD part to the code ?>

<body class="layout" style="background: #EAEAEA;">

    <?php include_once('../generic/header.php'); //Add HEADER part to the code ?>

    <!--    @Start     #Content -->

<div style="display: flex; flex-flow: row wrap; justify-content: center; align-items: flex-start; align-content: space-around">
    <?php
    $database = connection();

    if($user->getGroup()->getId() < 8 && $user->getGroup()->getId() > 4)
        $stmt = $database->prepare('SELECT * FROM PROJECTS WHERE visibility = false');
    else
        $stmt = $database->prepare('SELECT * FROM PROJECTS WHERE ug_id = :ug_id AND visibility = false');

    $stmt->execute(array(
            ':ug_id' => $user->getUgId()
    ));

    $stmt = $stmt->fetchAll(PDO::FETCH_BOTH);

    foreach ($stmt as $item)
    {
        ?>
        <div class="card shadow-1 light-hoverable-1 rounded-3 item vcenter">
            <div class="card-header"><?php echo $item[1]; ?></div>
            <div class="card-content">
                <p>
                    <?php echo $item[2]; ?>
                </p>
            </div>
            <form action="explore.php" method="POST" style="padding-bottom: 1.5rem">
                <input type="hidden" value="<?php echo $item[0]; ?>" name="project_id">
                <button class="btn shadow-1 rounded-1 outline txt-blue"><span class="outline-text">Voir ...</span></button>
            </form>
        </div>
    <?php } ?>
</div>

    <!--     @End      #Content -->

    <?php include_once('../generic/footer.php'); //Add FOOTER part to the code ?>

</body>

<?php } else { $_SESSION['error'] = 'Veuillez vous authentifier !'; header('Location: ../../index.php'); exit(); } ?>
