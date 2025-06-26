<!DOCTYPE html>
<html lang="fr">
  <?php require_once "pages/head.php"; ?>

  <body class="h-screen bg-cover bg-no-repeat  backdrop-blur-sm"
  style="background-image: url('assets/bg_about.jfif');">
    <div id="wrap">
      <?php require_once "pages/header.php"; ?>

      <div id="body">
        <section>
            <div class="container mx-auto">
              <div class="-mx-4 flex flex-wrap">
                <div class="w-full px-4 md:w-1/2 xl:w-1/3">
                  <div
                    class="mb-10 overflow-hidden rounded-lg bg-white shadow-1 duration-300 hover:shadow-3 shadow-lg ">
                    <img src="assets/carte.png" alt="image" class="w-full h-64 object-cover" />
                    <div class="p-8 text-center sm:p-9 md:p-7 xl:p-9">
                      <h3>
                        <a href="javascript:void(0)"
                          class="mb-4 block text-xl font-semibold text-dark hover:text-primary sm:text-[22px] md:text-xl lg:text-[22px] xl:text-xl 2xl:text-[22px] flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="size-8 bg-[#1B44C8] mr-8 ml-10 pl-1 pr-1 pt-1 pb-1 rounded-lg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                        </svg> Big Data Part
                        </a>
                      </h3>
                      <p class="mb-7 text-base leading-relaxed text-body-color ">
                        The Big Data part consisted of taking a 
                        complex database and cleaning it up, 
                        filtering it to obtain information 
                        and better understand it after filtering. 
                        We also created an interactive map.
                      </p>
                    </div>
                  </div>
                </div>
                <div class="w-full px-4 md:w-1/2 xl:w-1/3">
                  <div
                    class="mb-10 overflow-hidden rounded-lg bg-white shadow-1 duration-300 hover:shadow-3 shadow-lg">
                    <img src="assets/web.jfif" alt="image" class="w-full h-64 object-cover" />
                    <div class="p-8 text-center sm:p-9 md:p-7 xl:p-9">
                      <h3>
                        <a href="javascript:void(0)"
                          class="mb-4 block text-xl font-semibold text-dark hover:text-primary sm:text-[22px] md:text-xl lg:text-[22px] xl:text-xl 2xl:text-[22px] flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="size-8 bg-[#1B44C8] mr-8 ml-10 pl-1 pr-1 pt-1 pb-1 rounded-lg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9.75v6.75m0 0-3-3m3 3 3-3m-8.25 6a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
                        </svg> Web Part
                        </a>
                      </h3>
                      <p class="mb-7 text-base leading-relaxed text-body-color">
                        For the web, we had to create a website, the one you are currently visiting. 
                        And as you can see, there are many features available. 
                        Such as adding a boat, predicting its type or trajectory. 
                        But also viewing it on a map.
                      </p>
                    </div>
                  </div>
                </div>
                <div class="w-full px-4 md:w-1/2 xl:w-1/3">
                  <div
                    class="mb-10 overflow-hidden rounded-lg bg-white shadow-1 duration-300 hover:shadow-3 shadow-lg ">
                    <img src="assets/ia.png" alt="image" class="w-full h-64 object-cover"/>
                    <div class="p-8 text-center sm:p-9 md:p-7 xl:p-9">
                      <h3>
                        <a href="javascript:void(0)"
                          class="mb-4 block text-xl font-semibold text-dark hover:text-primary sm:text-[22px] md:text-xl lg:text-[22px] xl:text-xl 2xl:text-[22px] flex items-center">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="size-8 bg-[#1B44C8] mr-8 ml-10 pl-1 pr-1 pt-1 pb-1 rounded-lg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 0 0 2.25-2.25V6.75a2.25 2.25 0 0 0-2.25-2.25H6.75A2.25 2.25 0 0 0 4.5 6.75v10.5a2.25 2.25 0 0 0 2.25 2.25Zm.75-12h9v9h-9v-9Z" />
                        </svg> Artificial Intelligence Part
                        </a>
                      </h3>
                      <p class="mb-7 text-base leading-relaxed text-body-color">
                        AI has enabled us to make all kinds of 
                        predictions: possible clusters, ship types, 
                        and even a ship's trajectory, all based 
                        on the characteristics present in the extracted database.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
      </div>

      <?php require_once "pages/footer.php"; ?>
    </div>
  </body>
</html>