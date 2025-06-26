<!DOCTYPE html>
<html lang="fr">
    <?php require_once "pages/head.php"; ?>

    <body class="h-screen bg-cover bg-no-repeat  backdrop-blur-sm"
            style="background-image: url('assets/bg_accueil.jpg');">
        <div id="wrap">
            <?php require_once "pages/header.php"; ?>

            <div id="body">
                <div class="bg-center bg-[#E2F3FA]/40 mt-22 flex flex-col items-center justify-center text-center mb-22">
                    <h1 class="font-[Roboto] text-[40px] font-semibold text-white mb-10 mt-5"> Goals of our Project </h1>
                    <h2 class="font-[inter] text-2xl font-normal text-white mr-120 ml-120"> After collecting a set of data on ships sailing in the Gulf of Mexico, we cleaned, predicted, and visualized it in many different ways. </h2>
                    <div class="container py-16">
                        <a href="/about"
                        class="bg-[#1B44C8] border-0 rounded-md inline-flex items-center justify-center py-3 px-10 text-center text-base text-xl font-medium text-white hover:bg-body-color disabled:bg-gray-3 disabled:text-dark-5">
                        Learn More
                        </a>
                    </div>
                </div>
            </div>

            <?php require_once "pages/footer.php"; ?>
        </div>
    </body>
</html>